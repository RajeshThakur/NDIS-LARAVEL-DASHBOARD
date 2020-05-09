<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\BookingTaskCreated;
use App\Http\Controllers\Traits\Common;


use App\Model\Api\Bookings;
use App\Model\Api\BookingOrders;
use App\Model\Api\BookingCheckin;
use App\Model\Api\BookingCheckout;


// use App\Jobs\JobSendEmail;
// use App\Mail\BookingCompletionMail;

use App\Http\Controllers\Traits\BookingTrait;

use App\Notifications\BookingCompleted;

use Carbon\Carbon;
use DB;


class BookingCompletionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Notifiable, Common, BookingTrait;

    protected $booking;
    protected $booking_order;
    protected $booking_order_id;
    protected $participant;
    protected $worker;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $booking_order_id )
    {
        $this->booking_order_id = $booking_order_id;
    }

    

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        try{
            $this->booking_order = BookingOrders::find($this->booking_order_id);
            $this->booking = Bookings::where('id','=', $this->booking_order->booking_id)->first();
            $checkinRecord = BookingCheckin::where('booking_order_id','=', $this->booking_order_id)->first();
            $checkoutRecord = BookingCheckout::where('booking_order_id','=', $this->booking_order_id)->first();

            $this->worker = \App\User::find($this->booking_order->booking->supp_wrkr_ext_serv_id);
            $this->participant = \App\User::find($this->booking_order->booking->participant_id);
        }
        catch(ModelNotFoundException $exception) {
            \Log::critical( [ 'Message' => $exception->getMessage(), 'file' => $exception->getFile(), 'line'=>$exception->getLine() ] );
            return  array('status'=>false,'response'=>$exception->getMessage());
        }
        catch(Exception $exception) {
            \Log::critical( [ 'Message' => $exception->getMessage(), 'file' => $exception->getFile(), 'line'=>$exception->getLine() ] );
            return  array('status'=>false,'response'=>$exception->getMessage());
        }
        // dd($this->booking_order);
        $completionConditions = false;
        $in = true;
        $out = true;
        $quote = 0;

        $failed = [];
        
        //check if checkin record exist
        if( null === $checkinRecord){
            $failed[] = "None of the user checked in for this booking.";
            $in = false;
        }
         //check if checkout record exist
        if( null === $checkoutRecord){
            $failed[] = "None of the user checked out of this booking.";
            $out = false;
        }
        /*
        Completion Checks:
            - Check if both users are checked in, if yes then, calculate location difference
            - Check if both users are checked out, if yes then, calculate location difference
        */
        if( $in && $out){

            if( $checkinRecord->participant_checkin_time && $checkinRecord->sw_checkin_time ){
                $parti_chkin_cords = array(
                                        "lat" => $checkinRecord->participant_lat,
                                        "lng" => $checkinRecord->participant_lng
                                    );
                $sw_chkin_cords = array(   
                                        "lat" => $checkinRecord->sw_lat, 
                                        "lng" => $checkinRecord->sw_lng
                                    );
                if ( getDistance( $parti_chkin_cords , $sw_chkin_cords ) > 100 ){
                    $completionConditions = false;
                    $failed[] =  "Checkin location difference is more than 100 meters.";
                }else{
                    $completionConditions = true;
                }
            }else{
                if( ! $checkinRecord->participant_checkin_time )
                    $failed[] = "Participant did not checked in for booking.";

                if( ! $checkinRecord->sw_checkin_time )
                    $failed[] = "Support worker did not checked in for booking.";
            }
            
            if( $checkoutRecord->participant_checkout_time && $checkoutRecord->sw_checkout_time ){
                $parti_chkout_cords = array(
                                            "lat" => $checkoutRecord->participant_lat,
                                            "lng" => $checkoutRecord->participant_lng
                                        );
                $sw_chkout_cords = array(
                                        "lat" => $checkoutRecord->sw_lat,
                                        "lng" => $checkoutRecord->sw_lng
                                    );       
                if ( getDistance( $parti_chkout_cords , $sw_chkout_cords ) > 100 ){
                    $completionConditions = false;
                    $failed[] = "Checkout location difference is more than 100 meters.";
                }else{
                    $completionConditions = true;
                }
            }else{
                if( ! $checkoutRecord->participant_checkout_time ){
                    $failed[] =  "Participant did not checked out of booking.";
                    $completionConditions = false;
                }

                if( ! $checkoutRecord->sw_checkout_time ){
                    $failed[] =  "Support worker did not checked out of booking.";
                    $completionConditions = false;
                }
            
            }
        }
        
        //Check if quote required
        $reg_item = \App\RegistrationGroup::withoutGlobalScopes()->whereId($this->booking->item_number)->first();
        if( ($reg_item->unit == "H"  &&  $reg_item->quote_required == "Y" ) ||  $reg_item->unit != "H" ):
            $completionConditions = false;
            $failed[] =  "Quote required";
            $quote = 1;
        endif;

        // \Log::debug( $completionConditions ? 'true' : 'false' );
        // \Log::debug( $failed );

        if($completionConditions):
            try{
                //update booking_order status to Approved
                $this->booking_order->status = config('ndis.booking.statuses.Approved');

                $timesheet = $this->addApprovdBookingInTimesheet($this->booking_order_id);
                if( $timesheet['status'] ){
                    $this->booking_order->save(); //Approve only after timesheet record is inserted

                    // $email = new BookingCompletionMail( $timesheet['data'] );
                    // $emailJob = (new JobSendEmail($email,\App\User::find( $this->booking->provider_id )->email) )->onQueue('emails');
                    // dispatch($emailJob);

                    $this->participant->notify( new BookingCompleted(  $this->booking_order, 'participant' ) );
                    $this->worker->notify( new BookingCompleted(  $this->booking_order, 'worker' ) );


                }else{
                    throw new Exception($timesheet['response']);
                }
            }
            catch(ModelNotFoundException $exception) {
                \Log::critical( [ 'Message' => $exception->getMessage(), 'file' => $exception->getFile(), 'line'=>$exception->getLine() ] );
                return  array('status'=>false,'response'=>$exception->getMessage());
            }
            catch(Exception $exception) {
                \Log::critical( [ 'Message' => $exception->getMessage(), 'file' => $exception->getFile(), 'line'=>$exception->getLine() ] );
                return  array('status'=>false,'response'=>$exception->getMessage());
            }
         
        else:  
            try{
                BookingOrders::whereId($this->booking_order->id)->update(['status'=>config('ndis.booking.statuses.NotSatisfied')]);
                $this->booking_order->refresh();
                // \Log::debug( $failed );
                
                $task = \App\Task::create([
                                            'name' => 'Service booking with order ID '.$this->booking_order->id .' is incomplete.',
                                            'due_date' =>  Carbon::now()->addDays(1),
                                            'start_time' => Carbon::now()->toTimeString(),
                                            'end_time' => Carbon::now()->addDays(1)->toTimeString(),
                                            'location' => $this->booking->location,
                                            'lng' => $this->booking->lng,
                                            'lat' => $this->booking->lat,
                                            'description' => serialize($failed),
                                            'status_id' => 1,
                                            'provider_id' => $this->booking->provider_id,
                                            'created_by_id' => $this->booking->provider_id,
                                            'color_id' => 0, //this will be used to hide this task from calendar
                                        ]);
                

                $task->tags()->sync(2);
                $task->assigned_to_update()->sync($this->booking->provider_id);

                $task->load('assignees');

                // \Log::debug($task);

                $booking_meta = DB::table('booking_meta');

                $meta = $booking_meta->insert([
                                ['booking_order_id' => $this->booking_order->id, 'meta_key' => config('ndis.booking.manual.meta_key.reason'), 'meta_value' => serialize($failed)],
                                ['booking_order_id' => $this->booking_order->id, 'meta_key' => config('ndis.booking.manual.meta_key.quote'), 'meta_value' => $quote]
                            ]
                        );

                // \Log::debug( ($task->assignees)->toArray() );

                $task->booking_order_id = $this->booking_order->id;

                //Send Notification to each Assignee
                foreach($task->assignees as $assignee)
                    $assignee->notify( new BookingTaskCreated( $task->toArray() ) );
                
                // $email = new BookingCompletionMail( $task->toArray() );
                // Mail::to(\App\User::find( $this->booking->provider_id )->email)->send($email);

            }
            catch(ModelNotFoundException $exception) {
                \Log::critical( [ 'Message' => $exception->getMessage(), 'file' => $exception->getFile(), 'line'=>$exception->getLine() ] );
                return  array('status'=>false,'response'=>$exception->getMessage());
            }
            catch(Exception $exception) {
                \Log::critical( [ 'Message' => $exception->getMessage(), 'file' => $exception->getFile(), 'line'=>$exception->getLine() ] );
                return  array('status'=>false,'response'=>$exception->getMessage());
            }           
            
        endif;

    }

        
}
