<?php

declare(strict_types=1);

namespace App\Http\Controllers\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use \Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Exception;

use App\Jobs\BookingCompletionJob;
use App\Jobs\JobSendEmail;
use App\Mail\BookingCompletionMail;

use App\Model\Api\Bookings;
use App\Model\Api\BookingOrders;
use App\Model\Api\BookingCheckin;
use App\Model\Api\BookingCheckout;

use Dmark\Messenger\Models\Participant as MessageParticipant;

use App\Notifications\MessageForBooking;


trait BookingTrait
{


    /**
     * Function that will check if a given Participant has any booking in the given period
     * @param integer  $participant_id 
     * @param date  $starts_at 
     * @param date  $ends_at 
     * 
     * @return \App\Bookings
     */
    public function participantBookingsBetween( $participant_id, $starts_at, $ends_at, $order_id )
    {
        // pr($order_id,1);
        return $this->where('bookings.participant_id',$participant_id)
                    ->where('booking_orders.status', "Scheduled")
                    ->whereRaw(
                        '(
                            ( `booking_orders`.`starts_at` <= "'.$starts_at.'" AND `booking_orders`.`ends_at` >= "'.$starts_at.'" ) OR
                            ( `booking_orders`.`starts_at` <= "'.$ends_at.'" AND `booking_orders`.`ends_at` >= "'.$ends_at.'" ) 
                            
                        )'
                    )
                    ->whereNotIn('booking_orders.id', [$order_id])
                    ->first();
    }


    /**
     * Function that will check if a given Participant has any booking in the given period
     * @param integer  $swid 
     * @param date  $starts_at 
     * @param date  $ends_at 
     * 
     * @return \App\Bookings
     */
    public function swBookingsBetween( $swid, $starts_at, $ends_at )
    {
        return $this->where('bookings.supp_wrkr_ext_serv_id',$swid)
                    ->whereRaw(
                        '(
                            ( `booking_orders`.`starts_at` <= "'.$starts_at.'" AND `booking_orders`.`ends_at` >= "'.$starts_at.'" ) OR
                            ( `booking_orders`.`starts_at` <= "'.$ends_at.'" AND `booking_orders`.`ends_at` >= "'.$ends_at.'" ) 
                        )'
                    )
                    ->first();
    }


    /**
     * function that'll return the Message thread Id for the current booking Order between given user Id's
     * @param /App/User      $userIds array for user id's
     */
    public function msgThreadForUsers( $userIds ){

        $msgParticipant = MessageParticipant::select('thread_id')
                            ->whereIn('user_id', $userIds)->count();

        if($msgParticipant >= 2){
            return \App\BookingMessages::distinct()->select('message_thread_id as id')
                ->where('booking_order_id', $this->id )
                ->whereIn('message_thread_id', function($query) use($userIds){
                                $query->distinct()
                                    ->select('thread_id')
                                    ->from(with(new MessageParticipant)->getTable() )
                                    ->whereIn('user_id', $userIds);
                                })->first();
        }
        
        return null;
        
    }


    /**
     * Function to save BookingMessage for booking and Users
     */
    public function sendBookingMessage( $recipient, $message, $sender ){

        // get existing Thread
        $thread = $this->msgThreadForUsers( [ $sender->id, $recipient->id ] );
        
        $subject = formatBookingMsgSubject($this->id);

        $message = $recipient->sendThreadMessage( $subject, $message, $sender->id, [$recipient->id], isset($thread)?$thread->id:0 );


        if(! \App\BookingMessages::where('booking_order_id', $this->id)->where('message_thread_id', $message['thread_id'])->first() ){
            \App\BookingMessages::create([
                'booking_order_id' => $this->id,
                'message_thread_id' => $message['thread_id'],
            ]);
        }
        
        //Send Notification to the recipient
        $recipient->notify(new MessageForBooking( $subject, $message, $sender, $this->id));

        return $message;
    }


    public function userBookingMessages( $user_id )
    {
        return DB::table('messages')
                    ->join('booking_messages', 'booking_messages.message_id', '=', 'messages.id')
                    ->leftJoin('message_thread', 'booking_messages.message_id', '=', 'message_thread.id')
                    ->leftJoin('message_participants', 'message_participants.thread_id', '=', 'message_thread.id')
                    ->leftJoin('users', 'messages.user_id', '=', 'users.id')
                    ->whereIn( 'booking_messages.booking_order_id', [$this->id])
                    ->where( 'message_participants.user_id', $user_id)
                    ->select(
                                'messages.id','messages.thread_id','message_thread.subject','messages.body','messages.created_at',
                                DB::raw('users.id as sender_id'),
                                DB::raw('CONCAT(users.first_name, " " , users.last_name) as sender')
                            )
                    ->groupBy( 'booking_messages.booking_order_id' )
                    ->distinct()->get();
                
    }


    /**
     * Get past bookings.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function pastBookings(): Collection
    {
        return \App\Bookings::leftJoin('users','users.id','=','bookings.participant_id')                        
            ->whereDate('booking_orders.ends_at', '<', \Carbon\Carbon::now()->toDateTimeString())
            ->whereNull('cancelled_at')
            ->select(
                    "bookings.*",
                    "booking_orders.starts_at as start_date",
                    "booking_orders.ends_at as end_date",
                    "booking_orders.status as status",
                    "users.first_name as participant_fname",
                    "users.last_name as participant_lname",
                    "users.mobile as participant_mobile",
                    "users.email as participant_email"
                    )
            ->orderBy('booking_orders.starts_at', 'DESC')
            ->get();
    }

    /**
     * Get future bookings.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function futureBookings(): Collection
    {
        return \App\Bookings::leftJoin('users','users.id','=','bookings.participant_id')
            ->whereDate('booking_orders.starts_at', '>=', \Carbon\Carbon::now()->toDateTimeString())
            ->whereNull('cancelled_at')
            ->select(
                    "bookings.*",
                    "booking_orders.starts_at",
                    "booking_orders.ends_at",
                    "booking_orders.status as status",
                    "users.first_name as participant_fname",
                    "users.last_name as participant_lname",
                    "users.mobile as participant_mobile",
                    "users.email as participant_email"
                    )
            ->orderBy('booking_orders.starts_at', 'ASC')
            ->get();
    }

    /**
     * Get future bookings.
     *
     * @return interger
     */
    public static function futureBookingsCount(): int
    {
        $count = \App\Bookings::selectRaw("count(`bookings`.id) as total")
            ->leftJoin('users','users.id','=','bookings.participant_id')                        
            ->whereDate('booking_orders.starts_at', '>=', \Carbon\Carbon::now()->toDateTimeString())
            ->whereNull('cancelled_at')
            ->first();
        return ($count)?$count->total:0;
    }


    /**
     * Get inccomplete bookings count
     *
     * @return interger
     */
    public static function incompleteBookingsCount(): int
    {
        $count = \App\Bookings::leftJoin('users','users.id','=','bookings.participant_id')                        
            ->where('booking_orders.status', '=', 'Pending')
            ->selectRaw("count(`bookings`.id) as total")
            ->first();
        return ($count)?$count->total:0;
    }

    /**
     * Get inccomplete bookings.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function incompleteBookings(): Collection
    {
        return \App\Bookings::leftJoin('users','users.id','=','bookings.participant_id')                        
            ->where('booking_orders.status', '=', 'Pending')
            ->whereNull('cancelled_at')
            ->whereNotNull('starts_at')
            ->select(
                    "bookings.*",
                    "booking_orders.starts_at as start_date",
                    "booking_orders.ends_at as end_date",
                    "booking_orders.status as status",
                    "users.first_name as participant_fname",
                    "users.last_name as participant_lname",
                    "users.mobile as participant_mobile",
                    "users.email as participant_email"
                    )
            ->orderBy('booking_orders.starts_at', 'ASC')
            ->get();
    }


    /**
     * Get current bookings.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function currentBookings(): MorphMany
    {
        return $this
                    ->whereNull('cancelled_at')
                    ->whereNotNull('starts_at')
                    ->whereNotNull('ends_at')
                    ->where('starts_at', '<', now())
                    ->where('ends_at', '>', now());
    }


    /**
     * Get inccomplete bookings count
     *
     * @return interger
     */
    public static function cancelledBookingsCount(): int
    {
        $count = \App\Bookings::leftJoin('users','users.id','=','bookings.participant_id')                        
            ->where('booking_orders.status', '=', 'Cancelled')
            ->whereNotNull('cancelled_at')
            ->selectRaw("count(`bookings`.id) as total")
            ->first();
        return ($count)?$count->total:0;
    }

    /**
     * Get cancelled bookings.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function cancelledBookings(): Collection
    {
        return \App\Bookings::leftJoin('users','users.id','=','bookings.participant_id')                 
            ->where('booking_orders.status', '=', 'Cancelled')
            ->whereNotNull('cancelled_at')
            ->select(
                    "bookings.*",
                    "booking_orders.starts_at as start_date",
                    "booking_orders.ends_at as end_date",
                    "booking_orders.status as status",
                    "users.first_name as participant_fname",
                    "users.last_name as participant_lname",
                    "users.mobile as participant_mobile",
                    "users.email as participant_email"
                    )
            ->get();
    }

    
    
    


    /**
     * Get bookings starts before the given date.
     *
     * @param string $date
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function bookingsStartsBefore(string $date): MorphMany
    {
        return $this
                    ->whereNull('cancelled_at')
                    ->whereNotNull('starts_at')
                    ->where('starts_at', '<', new Carbon($date));
    }

    /**
     * Get bookings starts after the given date.
     *
     * @param string $date
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function bookingsStartsAfter(string $date): MorphMany
    {
        return $this
                    ->whereNull('cancelled_at')
                    ->whereNotNull('starts_at')
                    ->where('starts_at', '>', new Carbon($date));
    }

    /**
     * Get bookings starts between the given dates.
     *
     * @param string $startsAt
     * @param string $endsAt
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function bookingsStartsBetween(string $startsAt, string $endsAt): MorphMany
    {
        return $this
                    ->whereNull('cancelled_at')
                    ->whereNotNull('starts_at')
                    ->where('starts_at', '>', new Carbon($startsAt))
                    ->where('starts_at', '<', new Carbon($endsAt));
    }

    /**
     * Get bookings ends before the given date.
     *
     * @param string $date
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function bookingsEndsBefore(string $date): MorphMany
    {
        return $this
                    ->whereNull('cancelled_at')
                    ->whereNotNull('ends_at')
                    ->where('ends_at', '<', new Carbon($date));
    }

    /**
     * Get bookings ends after the given date.
     *
     * @param string $date
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function bookingsEndsAfter(string $date): MorphMany
    {
        return $this
                    ->whereNull('cancelled_at')
                    ->whereNotNull('ends_at')
                    ->where('ends_at', '>', new Carbon($date));
    }

    /**
     * Get bookings ends between the given dates.
     *
     * @param string $startsAt
     * @param string $endsAt
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function bookingsEndsBetween(string $startsAt, string $endsAt): MorphMany
    {
        return $this
                    ->whereNull('cancelled_at')
                    ->whereNotNull('ends_at')
                    ->where('ends_at', '>', new Carbon($startsAt))
                    ->where('ends_at', '<', new Carbon($endsAt));
    }

    /**
     * Get bookings cancelled before the given date.
     *
     * @param string $date
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function bookingsCancelledBefore(string $date): MorphMany
    {
        return $this
                    ->whereNotNull('cancelled_at')
                    ->where('cancelled_at', '<', new Carbon($date));
    }

    /**
     * Get bookings cancelled after the given date.
     *
     * @param string $date
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function bookingsCancelledAfter(string $date): MorphMany
    {
        return $this
                    ->whereNotNull('cancelled_at')
                    ->where('cancelled_at', '>', new Carbon($date));
    }

    /**
     * Get bookings cancelled between the given dates.
     *
     * @param string $startsAt
     * @param string $endsAt
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function bookingsCancelledBetween(string $startsAt, string $endsAt): MorphMany
    {
        return $this
                    ->whereNotNull('cancelled_at')
                    ->where('cancelled_at', '>', new Carbon($startsAt))
                    ->where('cancelled_at', '<', new Carbon($endsAt));
    }



    /**
     * Evalute booking start conditions
     *
     * @return mixed booking status
     * 
     */
    public function bookingStartConditionsEvaluator( $booking_order_id, $type ,$request)
    {
        
        $booking_order = BookingOrders::find($booking_order_id);
        $booking = Bookings::where('id','=', $booking_order->booking_id)->first();
       

        /* Set variables in context to participant or sw */
        if( $type == 'participant'):
            $checkin_status = "participant_checkin";
            $checkout_status = "participant_checkout";
            $user_id = "participant_id";
            $update = [
                        'participant_checkin' => $request->participant_checkin,
                        'participant_checkin_time' => $request->participant_checkin_time,
                        'participant_lat'=> $request->participant_lat,
                        'participant_lng'=> $request->participant_lng
            ];
        elseif($type == 'sw'):
            $checkin_status = "sw_checkin";
            $checkout_status = "sw_checkout";
            $user_id = "supp_wrkr_ext_serv_id";
            $update = [
                        'sw_checkin' => $request->sw_checkin,
                        'sw_checkin_time' => $request->sw_checkin_time,
                        'sw_lat'=> $request->sw_lat,
                        'sw_lng'=> $request->sw_lng
            ];
        endif;
                
        /* 
            Basic checks:
            1- Check if booking exists
            2- Check if user belongs to this booking
            3- Check if booking status is Scheduled or Started
            4- Check if booking has any checkout record and user is already checked out
            5- Check if booking has any checkin record and user is already checked in
            6- Check if record exists or create new one
                6.1- If creating new record then Update booking status to 'Started'           
        */
        try {
            //Check-1
            if( is_null($booking) || !$booking->exists() )
                throw new Exception('Booking not available!');
            
            //Check-2
            if( $booking->{$user_id} != \Auth::id() )
                throw new Exception('Unauthorized access to booking!');

            //Check-3
            if( ! in_array($booking_order->status ,['Started','Scheduled']))
                throw new Exception('Booking order expired !');
            
            //Check-4
            $checkoutRecord = BookingCheckout::where('booking_order_id','=', $booking_order->id);
            if( !is_null($checkoutRecord->first()) && $checkoutRecord->first()->{$checkout_status} ):
                throw new Exception('Sorry but this booking is already closed by you!');
            endif;

            //Check-5
            $checkinRecord = BookingCheckin::where('booking_order_id','=', $booking_order->id);
            if( !is_null($checkinRecord->first()) && $checkinRecord->first()->{$checkin_status} ):
                throw new Exception('You are already checked-in for this booking !');
            endif;

            //Check-6
            if ($checkinRecord->exists()):
                $checkin  = $checkinRecord->update($update);
            else:
                $checkin = BookingCheckin::create( $request->all() );
                //Check-6.1
                $started = BookingOrders::where('id','=',$booking->id)
                                    ->update( ['status' => 'Started'] );
            endif;

            return array('status'=>true,'response'=>$checkin);
        }
        catch(ModelNotFoundException $e){
            \Log::critical( [ 'Message' => $e->getMessage(), 'file' => $e->getFile(), 'line'=>$e->getLine() ] );
            return  array('status'=>false,'response'=>$e->getMessage());
        }
        catch(Exception $exception) {
            \Log::critical( [ 'Message' => $exception->getMessage(), 'file' => $exception->getFile(), 'line'=>$exception->getLine() ] );
            return  array('status'=>false,'response'=>$exception->getMessage());
        }

    }



    /**
     * Evalute booking completion conditions
     *
     * @return mixed booking status
     * 
     */
    public function bookingCompletionConditionsEvaluator( $booking_order_id, $type, $request )
    {         
        $booking_order = BookingOrders::find($booking_order_id);
        $booking = Bookings::where('id','=', $booking_order->booking_id)->first();

        /* Set variables in context to participant or sw */
        if( $type == 'participant'):
            $checkoutStatus = "participant_checkout";
            $checkinStatus = "participant_checkin";
            $user_id = "participant_id";
            $update = [
                        'participant_checkout' => $request->participant_checkout,
                        'participant_checkout_time' => $request->participant_checkout_time,
                        'participant_lat'=> $request->participant_lat,
                        'participant_lng'=> $request->participant_lng
            ];
        elseif($type == 'sw'):
            $checkoutStatus = "sw_checkout";
            $checkinStatus = "sw_checkin";
            $user_id = "supp_wrkr_ext_serv_id";
            $update = [
                        'sw_checkout' => $request->sw_checkout,
                        'sw_checkout_time' => $request->sw_checkout_time,
                        'sw_lat'=> $request->sw_lat,
                        'sw_lng'=> $request->sw_lng
            ];
        endif;
        
        /*
            Basic Checks:
            1- Check if booking exists
            2- Check if user belongs to this booking
            3- Check if booking status is Started or NotSatisfied            
            4- Check if booking has any checkin record and user is already checked in or not
            5- Check if booking has any checkout record and user is already checked out
            6- Check if checkout record exists then update or create new one
            7- Dispatch jobs based on following conditions:
                7.1- Both users have checked out then create BookingCompletionJOB
                7.2- Else update booking order status to NotSatisfied
        */

        try
        {
            //Check-1
            if( $booking_order == null)
                throw new Exception('Booking order does not exists!');

            //Check-2
            if( $booking != null && $booking->{$user_id} != \Auth::id() )
                throw new Exception('Unauthorized access to booking!');

            //Check-3
            if( !in_array($booking_order->status ,['Started','NotSatisfied']) )
                throw new Exception('Booking order expired !');

            //Check-4
            $checkinRecord = BookingCheckin::where('booking_order_id','=', $booking_order->id);
            $checkin = $checkinRecord->first();
            if( is_null($checkin) ):
                throw new Exception('Sorry You are not checked-in for this booking! Please check-in first.');
            elseif( ! $checkin->{$checkinStatus} ):
                throw new Exception('Sorry You are not checked-in for this booking! Please check-in first.');
            endif;
            
            //Check-5
            $checkoutRecord = BookingCheckout::where('booking_order_id','=', $booking_order->id);
            $chkout = $checkoutRecord->first();
            if( ! is_null($chkout) && $chkout->{$checkoutStatus} ):
                throw new Exception('Sorry but this booking is already closed by you!');
            endif; 

            //Check-6
            if ( $checkoutRecord->exists() ):
                $checkout  = $checkoutRecord->update($update);
            else:
                $checkout = BookingCheckout::create( $request->all() );
            endif;
            
            //Check-7
            $chkout->refresh(); //get fresh checkout record
            if( $chkout->participant_checkout && $chkout->sw_checkout ):
                BookingCompletionJob::dispatch($booking_order_id);
                BookingOrders::whereId($booking_order->id)->update(['status'=>'NotSatisfied']);
                return array('status'=>true,'response'=>'Booking completed.');
            else:
                // BookingCompletionJob::dispatch($booking_order_id);
                BookingOrders::whereId($booking_order->id)->update(['status'=>'NotSatisfied']);
                return array('status'=>true,'response'=>'Booking completion is on hold !');
            endif;
            
        }
        catch(ModelNotFoundException $exception) {
            \Log::critical( [ 'Message' => $exception->getMessage(), 'file' => $exception->getFile(), 'line'=>$exception->getLine() ] );
            return  array('status'=>false,'response'=>$exception->getMessage());
        }
        catch(Exception $exception) {
            \Log::critical( [ 'Message' => $exception->getMessage(), 'file' => $exception->getFile(), 'line'=>$exception->getLine() ] );
            return  array('status'=>false,'response'=>$exception->getMessage());
        }
        

    }

    /**
     * Add Approved bookings to timesheet
     *
     * @return mixed booking status
     * 
     */
    public function addApprovdBookingInTimesheet( $booking_order_id ,$swRate=null, $providerRate=null){

        try{
            // throw new Exception('catch');
            $booking_order = BookingOrders::find($booking_order_id);
            $booking = Bookings::where('id','=', $booking_order->booking_id)->first();
    
            // get registration item data
            $reg_item_query = \App\RegistrationGroup::withoutGlobalScopes()->whereId($booking->item_number);
            $reg_item = $reg_item_query->first();
    
            // booking totaltime = endtime - starttime
            $total_time = round( $booking_order->ends_at->floatDiffInHours($booking_order->starts_at),2);
    
            // get support worker rate
            if( $swRate == null)
                $swRate = DB::table('provider_reg_groups')->whereUserId($booking->provider_id)->whereRegGroupId($booking->item_number)->first()->cost;
            // get total amount/provider rate
            if( $providerRate == null)
                $providerRate = $reg_item->price_limit;
            
            // set timesheet data array
            $data = [];
            $data['booking_order_id'] = $booking_order->id;
            $data['total_time'] = $total_time;
            $data['is_billed'] = 0;
            
    
            //for hourly units
            if( $reg_item->unit == "H" ):
                $data['total_amount'] = $providerRate * $total_time; //provider rate * booking hrs
                $data['payable_amount'] = $swRate * $total_time; //sw rate * booking hrs
            else:
                $data['total_amount'] = $providerRate; //provider rate
                $data['payable_amount'] = $swRate; //sw rate
            endif;
    
            /* 
                TRAVEL COMPENSATION CHECKS
                1 - reg item has Hourly type unit
                2 - booking service_type is support worker
                3 - booking_type is travel 
                4 - next booking start time < 4hrs from current booking end time
            */
            $data['travel_compensation'] = array('rate'=>$swRate,'time'=>0,'amount'=>0);
            $item = $reg_item_query->whereUnit('H')->first();
            $withinFourHrs = BookingOrders::withoutGlobalScopes()->whereBetween('starts_at',[$booking_order->ends_at,($booking_order->ends_at)->addHours(4)])->first();
            $compensation = '';
            if( $withinFourHrs != null &&
                            $item != null &&
                                trim($booking->service_type) == 'support_worker' &&
                                        trim($booking_order->booking_type) == 'travel' ):
    
                $diffInMinutes = $booking_order->ends_at->diffInMinutes($withinFourHrs->starts_at);
                if($diffInMinutes >= 30):
                    $diffInHours = round((30/60),2);
                    $compensation = $swRate * $diffInHours;
                else:
                    $diffInHours = round(($diffInMinutes/60),2);
                    $compensation = $swRate * $diffInHours;
                endif;
                
                $data['travel_compensation'] = array('rate'=>$swRate,'time'=>$diffInHours ,'amount'=>$compensation);
    
            endif;
    
            $timesheet = \App\Timesheet::create($data);

            return  array('status'=>true,'timesheet'=>$timesheet,'data'=>$data);
        }
        catch(ModelNotFoundException $exception) {
            \Log::critical( [ 'Message' => $exception->getMessage(), 'file' => $exception->getFile(), 'line'=>$exception->getLine() ] );
            return  array('status'=>false,'response'=>$exception->getMessage());
        }
        catch(Exception $exception) {
            \Log::critical( [ 'Message' => $exception->getMessage(), 'file' => $exception->getFile(), 'line'=>$exception->getLine() ] );
            return  array('status'=>false,'response'=>$exception->getMessage());
        }
       


    }




}