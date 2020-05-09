<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBookingRequest;

use Illuminate\Notifications\Notifiable;
use App\Notifications\RescheduleRequestByParticipant;
use App\Notifications\RescheduleRequestBySw;
use App\Notifications\RescheduleBookingApproved;
use App\Notifications\RescheduleBookingDeclined;
use App\Notifications\RescheduleResponsePending;
use App\Notifications\BookingIncidentReport;
use App\Notifications\BookingComplaint;
use App\Notifications\ServiceBookingCancelled;
use App\Notifications\ServiceBookingCancelConfirm;
use App\Notifications\IncidentComment;
use App\Notifications\ComplaintComment;
use App\Notifications\MessageForBooking;
use App\Notifications\MessageSent;

use Dmark\Messenger\Models\Message;
use Dmark\Messenger\Models\Participant;
use Dmark\Messenger\Models\Thread;

use App\BookingOrders;
use App\BookingOrderMeta;
use App\BookingIncidents;
use App\BookingComplaints;
use App\User;

use App\Http\Controllers\Traits\BookingProcessTrait;
use App\Http\Controllers\Traits\ApiTrait;

use App\Events\UpdateFunds;


class BookingsApiController extends Controller
{

    use BookingProcessTrait, ApiTrait, Notifiable;

    /**
     * Function that allows Users to checking to a booking after checking the following conditions
     * - Booking Order Id given should be a valid Order Id ( where service_type support_worker)
     * - User_id given should be valid member ( participant / support_worker ) of the booking
     * - Booking should be already started or should be starting in given time in config('ndis.booking.early_checkin_time') 
     * - User should not already checked in
     */
    public function checkin( Request $request )
    {

        $messages = [
                    'booking_order_id'   => "Booking instance ID is required!",
                    'lat'   => "Location Latitude is requird!",
                    'lng'   => "Location Longitude is requird!",
                ];

        $data = Validator::make( $request->all(), [
                                                    'booking_order_id' => 'required',
                                                    'lat' => 'required',
                                                    'lng' => 'required'
                                                ], $messages);

        if($data->fails()):
            return response()->json(['status'=>false,'error'=>$data->messages()], 400);
        endif;
        
        try{

            $user = \Auth::user();

            //Verify if BookingOrder is set
            if(!$request->bookingOrder)
                return apiError('Something goes wrong with booking!', 500);

            $bookingOrder = $request->bookingOrder;

            //Check is Booking Status is valid
            if( !in_array( $bookingOrder->status, [ config('ndis.booking.statuses.Scheduled'), config('ndis.booking.statuses.Started') ] ) )
                return apiError('Booking already processed!', 403);

            //If Booking hasn't started yet return error
            $bookingStartsDiff = Carbon::parse( $bookingOrder->starts_at )->diffInMinutes(Carbon::now(), false);
            if( ($bookingStartsDiff  - config('ndis.booking.early_checkin_time') ) < 0 ){
                return response()->json(['status'=>false,'error'=>'Cannot Checkin into this booking yet!'], 401);
            }
            
            $bookingOrder->status = "Started";
            $bookingOrder->save();

            if(!$bookingOrder->checkin){
                $checkin = new \App\Model\Api\BookingCheckin;
                $checkin->booking_order_id = $bookingOrder->id;
            }
            else
                $checkin = $bookingOrder->checkin;

            

            if( $bookingOrder->booking->participant_id == $user->id ){
                if($bookingOrder->checkin && $bookingOrder->checkin->participant_checkin_time){
                    return response()->json(['status'=>false, 'error'=>'User already checked in!'], 404);
                }
                $checkin->participant_checkin_time = Carbon::now();
                $checkin->participant_lat = $request->input('lat');
                $checkin->participant_lng = $request->input('lng');
            }

            if( $bookingOrder->booking->supp_wrkr_ext_serv_id == $user->id ){
                if($bookingOrder->checkin && $bookingOrder->checkin->sw_checkin_time){
                    return response()->json(['status'=>false, 'error'=>'User already checked in!'], 404);
                }
                $checkin->sw_checkin_time = Carbon::now();
                $checkin->sw_lat = $request->input('lat');
                $checkin->sw_lng = $request->input('lng');
            }

            if($bookingOrder->checkin)
                $checkin->id = $bookingOrder->checkin->id;

            $checkin->save();

            return response()->json(['status'=>true, 'message'=> 'checkin done' ], 200);
            
        }
        catch(ModelNotFoundException $e){
            return reportAndRespond( $e,  400);
        }
        catch(Exception $e){
            return reportAndRespond( $e,  401);
        }

    }


    /**
     * Function that allows Users to checkout of a booking after checking the following conditions
     * - Booking Order Id given should be a valid Order Id ( where service_type support_worker)
     * - User_id given should be valid member ( participant / support_worker ) of the booking
     * - Booking should be already started or should be starting in given time in config('ndis.booking.early_checkin_time') 
     * - User should not already checked out
     * - If both Member's Checkout Then Queue the Job for Completion                                                                                                           
     */
    public function checkout( Request $request )
    {

        $messages = [
                    'booking_order_id'   => "Booking instance ID is required!",
                    'lat'   => "Location Latitude is requird!",
                    'lng'   => "Location Longitude is requird!",
                ];

        $data = Validator::make( $request->all(), [
                                                    'booking_order_id' => 'required',
                                                    'lat' => 'required',
                                                    'lng' => 'required'
                                                ], $messages);

        if($data->fails()):
            return response()->json(['status'=>false,'error'=>$data->messages()], 400);
        endif;
        
        try{

            $user =  \Auth::user();

            //Verify if BookingOrder is set
            if(!$request->bookingOrder)
                return apiError('Something goes wrong with booking!', 500);

            $bookingOrder = $request->bookingOrder;

            //Check is Booking Status is valid
            if( !in_array( $bookingOrder->status, [ config('ndis.booking.statuses.Scheduled'), config('ndis.booking.statuses.Started') ] ) )
                return apiError('Booking already processed!', 403);

            
            //If checkin record dont exist for this booking
            if(  ! $bookingOrder->checkin ){
                return response()->json(['status'=>false,'error'=>'You have to checkin first !'], 401);
            }


            //If Booking hasn't started yet return error
            // $bookingStartsDiff = Carbon::parse( $bookingOrder->starts_at )->diffInMinutes(Carbon::now(), false);
            // if( ($bookingStartsDiff  - config('ndis.booking.early_checkin_time') ) < 0 ){
            //     return response()->json(['status'=>false,'error'=>'Cannot Checkin into this booking yet!'], 401);
            // }
            
            $bookingOrder->status = "Started";
            $bookingOrder->save();

            if(!$bookingOrder->checkout){
                $checkout = new \App\Model\Api\BookingCheckout;
                $checkout->booking_order_id = $bookingOrder->id;
            }
            else
                $checkout = $bookingOrder->checkout;


            if( $bookingOrder->booking->participant_id == $user->id ){
                if($bookingOrder->checkout && $bookingOrder->checkout->participant_checkout_time){
                    return response()->json(['status'=>false,'error'=>'User already checked out!'], 404);
                }
                $checkout->participant_checkout_time = Carbon::now();
                $checkout->participant_lat = $request->input('lat');
                $checkout->participant_lng = $request->input('lng');
            }

            if( $bookingOrder->booking->supp_wrkr_ext_serv_id == $user->id ){
                if($bookingOrder->checkout && $bookingOrder->checkout->sw_checkout_time){
                    return response()->json(['status'=>false,'error'=>'User already checked out!'], 404);
                }
                $checkout->sw_checkout_time = Carbon::now();
                $checkout->sw_lat = $request->input('lat');
                $checkout->sw_lng = $request->input('lng');
            }

            if($bookingOrder->checkout)
                $checkout->id = $bookingOrder->checkout->id;

            $checkout->save();

            // // Check if Both Participant and Support Worker's checked-out then Queue the Job for Booking Completion
            if( $checkout->participant_checkout_time && $checkout->sw_checkout_time )
                \App\Jobs\BookingCompletionJob::dispatch($checkout->booking_order_id);

            return response()->json(['status'=>true, 'message'=> 'checkout done' ], 200);
            
        }
        catch(Exception $e){
            return reportAndRespond( $e,  401);
        }

    }


    /***************************************************************************************************************************************/
    /** Bookings Reschedule */
    /***************************************************************************************************************************************/


    /**
     * API call handler to reschedule a service booking
     * - Booking Order Id given should be a valid Order Id ( where service_type support_worker)
     * - Logged in user should be a valid member of the Booking
     * - Second Party should be available on suggested dateTime
     */
    public function reschedule( Request $request )
    {
        
        try{
            
            $messages = [
                'booking_order_id'   => "Booking instance ID is required!",
                'start_time'   => "Booking start time is missing!",
                'end_time'   => "Booking end time is missing!",
                'date'   => "Booking date is missing",
            ];
    
            $data = Validator::make( $request->all(), [
                                                        'booking_order_id' => 'required',
                                                        'start_time' => 'required',
                                                        'end_time' => 'required',
                                                        'date' => 'required'
                                                    ], $messages);
                                                    
            if($data->fails())
                return apiError($data->messages(), 400);

            $start_time = $request->input('start_time');
            $end_time = $request->input('end_time');
            $date = $request->input('date');


            $starts_at = datetimeToDB( $date . ' '. $start_time );
            $ends_at = datetimeToDB( $date . ' '. $end_time );

            $user =  \Auth::user();
            
            if( !isset($user->id ) )
                return apiError('unauthorised!', 401);

            //Verify if BookingOrder is set via middleware ApiBookingVerify
            if(!$request->bookingOrder)
                return apiError('Something goes wrong with booking!', 500);

            $bookingOrder = $request->bookingOrder;

            //Check is Booking Status is valid
            if( !in_array( $bookingOrder->status, [ config('ndis.booking.statuses.Scheduled') ] ) )
                return apiError('Booking already processed!', 403);

            $orderMeta = BookingOrderMeta::getMetaVal( $bookingOrder->id, config('ndis.booking.reschedule.identifier') );

            if(!empty($orderMeta)){

                if( $user->id == $orderMeta['initiated_by_id'] && 1 == $orderMeta['approved'] )
                    return apiError("Booking reschedule request is already approved.", 401);

                if( $user->id == $orderMeta['initiated_by_id'] && 0 == $orderMeta['approved']  )
                    return apiError("Booking reschedule request is already denied.", 401);

                if( $user->id == $orderMeta['initiated_by_id'] && 2 == $orderMeta['approved'] )
                    return apiError("There's already one request for Reschedule!", 401);

            }

            $rescheduleRequest = [ 
                                    'initiated_by_id' => $user->id, 
                                    'provider_id' => $bookingOrder->booking->provider_id,
                                    'date' => $date,
                                    'start_time' => $start_time,
                                    'end_time' => $end_time,
                                    'approved' => 2
                                ];

            
            if( $bookingOrder->booking->participant_id == $user->id ){

                $rescheduleRequest['initiated_by'] = 'participant';

                $swUser = \App\SupportWorker::withoutGlobalScope('App\Scopes\SWProviderScope')->where( 'user_id', $bookingOrder->booking->supp_wrkr_ext_serv_id )->first();

                // pr($swUser->user, 1);
                
                //Verify that SW is available for selected datetime
                if(!$swUser->availableBetween(Carbon::parse($starts_at), Carbon::parse($ends_at)))
                    return apiError('Support Worker not available during selected time!', 401);
                
                BookingOrderMeta::saveMeta( $bookingOrder->id, config('ndis.booking.reschedule.identifier'), $rescheduleRequest );
                
                $swBooking = $bookingOrder->booking->swBookingsBetween( $bookingOrder->booking->supp_wrkr_ext_serv_id, 
                                                                        $starts_at, 
                                                                        $ends_at
                                                                        );
                if($swBooking)
                    return apiError( trans('msg.bookings.sw.already_booked'), 401 );
            
            
                //Send Notification to Support Worker
                $swUser->user->notify( new RescheduleRequestByParticipant( $bookingOrder ) );

                //Send Notification to Provider
                $provider = \App\User::findOrFail( $bookingOrder->booking->provider_id );
                $provider->notify( new RescheduleRequestByParticipant( $bookingOrder ) );
                
            }
            else{

                $rescheduleRequest['initiated_by'] = 'support_worker';
                
                BookingOrderMeta::saveMeta( $bookingOrder->id, config('ndis.booking.reschedule.identifier'), $rescheduleRequest );

                //Send Notification to Provider
                $provider = \App\User::findOrFail( $bookingOrder->booking->provider_id );
                $provider->notify( new RescheduleRequestBySw( $bookingOrder ) );
                
            }

            //Queue the Job to Check the Booking Response
            \App\Jobs\RescheduleResponseCheck::dispatch( $bookingOrder)
                ->delay( now()->addHours( config('ndis.booking.reschedule.wait_response') ) );
            
            return response()->json(['status'=>true, 'message'=> 'Booking reschedule request sent.' ], 200);

        }
        catch(FatalThrowableError $e){
            return reportAndRespond( $e,  401 );
        }catch(Exception $e){
            return reportAndRespond( $e,  401 );
        }


    }



    /**
     * API Callback to handle resonse for Booking Reschedule request
     * - For Booking Reschedule request either Participant/SW has to be a valid member of the Booking
     * - Booking should not be be started
     * - User calling this API request should be authorized to approve the request
     */
    public function rescheduleResponse( Request $request ){

        try{
            $messages = [
                'booking_order_id'   => "Booking instance ID is required!",
                'approved'   => "Reschedule response is missing!",
                'approved.boolean'   => "Reschedule response is incorrect!",
            ];
    
            $data = Validator::make( $request->all(), [
                                                        'booking_order_id' => 'required',
                                                        'approved' => 'required|boolean',
                                                    ], $messages);
    
            if($data->fails())
                return apiError($data->messages(), 400);

            $user =  \Auth::user();
            
            if( !isset($user->id ) )
                return apiError('unauthorised!', 401);

            //Verify if BookingOrder is set
            if(!$request->bookingOrder)
                return apiError('Something goes wrong with booking!', 500);

            $bookingOrder = $request->bookingOrder;

            //Check is Booking Status is valid
            if( !in_array( $bookingOrder->status, [ config('ndis.booking.statuses.Scheduled') ] ) )
                return apiError('Booking already processed!', 403);

            $orderMeta = BookingOrderMeta::getMetaVal( $bookingOrder->id, config('ndis.booking.reschedule.identifier') );

            if(!$orderMeta)
                return apiError("UnAuthorised!", 404);
            
            if( $user->id == $orderMeta['initiated_by_id'] )
                return apiError("You yourself cannot approve!", 404);

            if( $orderMeta['approved'] !== 2  )
                return apiError("Booking reschedule request has already been processed!", 402);
            
            
            //Update Meta register response
            $orderMeta['approved'] = (int) $request->input('approved');
            BookingOrderMeta::saveMeta( $bookingOrder->id, config('ndis.booking.reschedule.identifier'), $orderMeta);
            // BookingOrderMeta::deleteMetaKey($bookingOrder->id, config('ndis.booking.reschedule.identifier'));
            
            // If Approved
            if($request->input('approved')){

                //Update the Booking Order Start End time
                $bookingOrder->starts_at = datetimeToDB($orderMeta['date'] . ' '. $orderMeta['start_time'] );
                $bookingOrder->ends_at = datetimeToDB($orderMeta['date'] . ' '. $orderMeta['end_time'] );
                $bookingOrder->save();

                $booking_member = \App\User::findOrFail( $orderMeta['initiated_by_id'] );
                $booking_member->notify(new RescheduleBookingApproved( $bookingOrder ) );

                return response()->json(['status'=>true, 'message'=> 'Booking reschedule approved.' ], 200);

            }
            else{
                
                $booking_member = \App\User::findOrFail( $orderMeta['initiated_by_id'] );
                $booking_member->notify(new RescheduleBookingDeclined( $bookingOrder ) );

                return response()->json(['status'=>true, 'message'=> 'Booking reschedule denied.' ], 200);
            }
            
        }
        catch(FatalThrowableError $ex){
            return reportAndRespond( $ex,  401);
        }catch(Exception $ex){
            return reportAndRespond( $ex,  401);
        }
        

    }


    /**
     * API Callback to cancel a service booking
     * - For Booking Reschedule request either Participant/SW has to be a valid member of the Booking
     * - Booking should not be started
     * 
     */
    public function cancelBooking( Request $request ){

        try{
            $messages = [
                'booking_order_id'   => "Booking instance ID is required!",
                'reason'   => "Reason for Cancellation is required!"
            ];
    
            $data = Validator::make( $request->all(), [
                                                        'booking_order_id' => 'required',
                                                        'reason' => 'required'
                                                    ], $messages);
    
            if($data->fails())
                return apiError($data->messages(), 400);

            $user =  \Auth::user();
            
            if( !isset($user->id ) )
                return apiError('unauthorised!', 401);

            //Verify if BookingOrder is set
            if(!$request->bookingOrder)
                return apiError('Something goes wrong with booking!', 500);

            $bookingOrder = $request->bookingOrder;

            //Check is Booking Status is okay for cancellation??
            if( !in_array( $bookingOrder->status, [ config('ndis.booking.statuses.Scheduled') ] ) )
                return apiError('Booking cannot be Cancelled!', 403);

            $now = Carbon::now();
            $starts_at = Carbon::parse($bookingOrder->starts_at);
            $starts_at_lockout = Carbon::parse($bookingOrder->starts_at)->subHours( config('ndis.booking.cancel_lock_in_period') );

            if($now->greaterThanOrEqualTo($starts_at))
                return apiError('Booking start time is past, so cannot cancel in!', 403);

            //Check if Booking can just be cancelled or will be billed as cancelled?
            if($now->greaterThanOrEqualTo($starts_at_lockout)){
                //Cancellation will be charged!
                // Update Booking Order to "Approved and set booking Type = cancelled
                $bookingOrder->booking_type = 'cancelled';
                $bookingOrder->status = 'Approved';
                $bookingOrder->save();

            }else{
                //Cancellation will not be charged!
                $bookingOrder->status = 'cancelled';
                $bookingOrder->save();
            }

            event( new UpdateFunds( 
                                    array(                                                  
                                            'order_id'=> $bookingOrder->id,
                                            'type' =>'cancel'
                                    )
                        )
            );

            //Send Notifications to the Members of the Booking

                
            $booking_member = \App\User::findOrFail( $bookingOrder->booking->provider_id );
            $booking_member->notify(new ServiceBookingCancelled( $bookingOrder, $booking_member ) );
        

            if( $bookingOrder->booking->participant_id ==  \Auth::id()):
                $booking_member = \App\User::findOrFail( $bookingOrder->booking->participant_id );
                $booking_member->notify(new ServiceBookingCancelConfirm( $bookingOrder, $booking_member ) );
                $booking_member = \App\User::findOrFail( $bookingOrder->booking->supp_wrkr_ext_serv_id );
                $booking_member->notify(new ServiceBookingCancelled( $bookingOrder, $booking_member ) );
            endif;

            if( $bookingOrder->booking->supp_wrkr_ext_serv_id ==  \Auth::id()):
                $booking_member = \App\User::findOrFail( $bookingOrder->booking->supp_wrkr_ext_serv_id );
                $booking_member->notify(new ServiceBookingCancelConfirm( $bookingOrder, $booking_member ) );
                $booking_member = \App\User::findOrFail( $bookingOrder->booking->participant_id );
                $booking_member->notify(new ServiceBookingCancelled( $bookingOrder, $booking_member ) );
            endif;

            // ServiceBookingCancelled

            return response()->json(['status'=>true, 'bookingOrder'=>$bookingOrder], 200);


        }
        catch(FatalThrowableError $ex){
            return reportAndRespond( $ex,  401);
        }catch(Exception $ex){
            return reportAndRespond( $ex,  401);
        }
        
    }


    /***************************************************************************************************************************************/
    /** Bookings Incidents */
    /***************************************************************************************************************************************/

    /**
     * Fetch all incident report for booking
     *
     * @return mixed incident array and status
     * 
     */
    public function getBookingIncidents(Request $request, $booking_order_id){
        try{
            $user =  \Auth::user();
            $incidents = \App\BookingIncidents::where('booking_order_id', $booking_order_id)->get();
            return response()->json(['status'=>true, 'incidents'=>$incidents], 200);
        }
        catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }
    }

    /**
     * Fetch a [articular Incident by ID]
     *
     * @return mixed incident array and status
     * 
     */
    public function getIncident(Request $request, $incidentId){
        try{
            $user =  \Auth::user();
            $incident = \App\BookingIncidents::findOrFail( $incidentId );
            $incident->comments();
            return response()->json(['status'=>true, 'incident'=>$incident], 200);
        }
        catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }
    }

    /**
     * Create incident report for User
     *
     * @return mixed incident array and status
     * 
     */
    public function createIncident( Request $request)
    {
        $data = Validator::make($request->all(),[          
            'booking_order_id'   => 'required | integer',
            'incident_details'   => 'required',
            'any_injuries'   => 'required',
            'any_damage'   => 'required',
            'cause_of_incident'   => 'required',
            'actions_to_eliminate'   => 'required',
            'management_comments'   => 'required'
        ], []);
        
        //return error if any field is missing
        if($data->fails()):
            return response()->json(['status'=>false,'error'=>$data->messages()], 400);
        endif;

        try{
            $user =  \Auth::user();

            $bookingOrder = BookingOrders::find($request->booking_order_id);

            //Verify if BookingOrder is set
            // if(!$request->bookingOrder)
            if( empty($bookingOrder) )
                return apiError('Something goes wrong with booking!', 500);

            // $bookingOrder = $request->bookingOrder;

            //Check is Booking Status is valid to create Incident report
            if( !in_array( $bookingOrder->status, [ config('ndis.booking.statuses.Scheduled'), config('ndis.booking.statuses.Started'), config('ndis.booking.statuses.NotSatisfied'), config('ndis.booking.statuses.Approved') ] ) )
                return apiError('Cannot create incident on a booking that is already submitted!', 403);

            $provider = \App\User::find($bookingOrder->booking->provider_id);
            $participant = \App\User::find($bookingOrder->booking->participant_id);
            $supportWorker = \App\User::find($bookingOrder->booking->supp_wrkr_ext_serv_id);

            //Adding DB required fields
            $request->request->add([
                'datetime'=>Carbon::now(),
                'created_by'=> $user->id,
                'provider_id'=>$bookingOrder->booking->provider_id
            ]);

            if( $bookingOrder->booking->participant_id == $user->id )
                $request->request->add([ 'user_id'=> $bookingOrder->booking->supp_wrkr_ext_serv_id ]);

            if( $bookingOrder->booking->supp_wrkr_ext_serv_id == $user->id )
                $request->request->add([ 'user_id'=> $bookingOrder->booking->participant_id ]);

            $incident = BookingIncidents::create( $request->all() );

            $incident->url = route("admin.bookings.edit.incident", [$bookingOrder->id]);

            // if( $bookingOrder->booking->participant_id == $user->id && $bookingOrder->booking->service_type == 'support_worker' ){
            //     $supportWorker->notify(new BookingIncidentReport( $participant, $incident) );
            // }
            // else if( $bookingOrder->booking->supp_wrkr_ext_serv_id == $user->id && $bookingOrder->booking->service_type == 'support_worker' ){
            //     $participant->notify(new BookingIncidentReport( $supportWorker, $incident) );
            // }
            // else if($bookingOrder->booking->participant_id == $user->id && $bookingOrder->booking->service_type != 'support_worker'){
            //     $provider->notify(new BookingIncidentReport( $participant, $incident) );
            // }
            // else{
            //     $provider->notify(new BookingIncidentReport( $supportWorker, $incident) );
            // }

            $provider->notify(new BookingIncidentReport( $supportWorker, $incident) );

            return response()->json(['status'=>true, 'message'=>'Incident created successfully.'], 200);
        }
        catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }

    }


    /***************************************************************************************************************************************/
    /** Bookings Complaints */
    /***************************************************************************************************************************************/

    /**
     * Fetch all complaints for booking
     *
     * @return mixed complaint array and status
     * 
     */
    public function getBookingComplaints(Request $request, $booking_order_id){
        try{
            $user =  \Auth::user();
            $complaints = \App\BookingComplaints::where('booking_order_id', $booking_order_id)->get();
            return response()->json(['status'=>true, 'complaints'=>$complaints], 200);
        }
        catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }
    }

    /**
     * Create a complaint by Participant for booking
     *
     * @return mixed complaint array and status
     * 
     */
    public function createComplaint( Request $request)
    {
        $data = Validator::make($request->all(),[          
            'booking_order_id'   => 'required | integer',
            'complaint_details'   => 'required',
        ], []);
        
        //return error if any field is missing
        if($data->fails()):
            return response()->json(['status'=>false,'error'=>$data->messages()], 400);
        endif;

        try{
            $user =  \Auth::user();

            $bookingOrder = BookingOrders::find($request->booking_order_id);

            //Verify if BookingOrder is set            
            if( empty($bookingOrder) )
                return apiError('Something goes wrong with booking!', 500);

            //Check is Booking Status is valid to create Complaint 
            if( !in_array( $bookingOrder->status, [ config('ndis.booking.statuses.Scheduled'), config('ndis.booking.statuses.Started'), config('ndis.booking.statuses.NotSatisfied'), config('ndis.booking.statuses.Approved') ] ) )
                return apiError('Cannot create complaint on a booking that is already submitted!', 403);

            $provider = \App\User::find($bookingOrder->booking->provider_id);
            $participant = \App\User::find($bookingOrder->booking->participant_id);
            $supportWorker = \App\User::find($bookingOrder->booking->supp_wrkr_ext_serv_id);

            //Adding DB required fields
            $request->request->add([               
                'created_by'=> $user->id,
                'provider_id'=>$bookingOrder->booking->provider_id
            ]);


            if( $bookingOrder->booking->participant_id == $user->id )
                $request->request->add([ 'user_id'=> $user->id ]);

            $complaint = BookingComplaints::create( $request->all() );

            $complaint->url = route("admin.bookings.edit", [$bookingOrder->id]);

            $provider->notify(new BookingComplaint( $participant, $complaint) );

            return response()->json(['status'=>true, 'message'=>'Complaint submitted successfully.'], 200);
        }
        catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }

    }


    /***************************************************************************************************************************************/
    /** add Comments */

    //Incident comment  (by provider or SW )
    public function addComment(Request $request){

        $data = Validator::make($request->all(),[          
            'booking_order_id'   => 'required | integer',
            'incident_id'   => 'required | integer',
            'author_ip'   => 'required',
            'content'   => 'required'
        ], []);
        
        //return error if any field is missing
        if($data->fails()):
            return response()->json(['status'=>false,'error'=>$data->messages()], 400);
        endif;


        try{

            $user =  \Auth::user();

            $bookingOrder = BookingOrders::find($request->booking_order_id);

            //Verify if BookingOrder is set
            if( empty ($bookingOrder) )
                return apiError('Something goes wrong with booking!', 500);

            
            //Check if incident exists for booking Order
            $incident = $bookingOrder->incidents()->get()->firstWhere( 'id', $request->input('incident_id') );

            if(!$incident)
                return apiError('Indcident not found!', 404);
            
            //Adding DB required fields
            $request->request->add([
                'relatation_id'=> $request->input('incident_id'),
                'type'=> 'incident',
                'user_id'=> $user->id
            ]);

            $comment = \App\Comment::create( $request->all() );

            if( $bookingOrder->booking->participant_id == $user->id && $bookingOrder->booking->service_type == 'support_worker' ){
                $supportWorker = \App\User::find($bookingOrder->booking->supp_wrkr_ext_serv_id)->first();
                $supportWorker->notify(new IncidentComment( $bookingOrder ) );
            }
            else if( $bookingOrder->booking->supp_wrkr_ext_serv_id == $user->id && $bookingOrder->booking->service_type == 'support_worker' ){
                $participant = \App\User::find($bookingOrder->booking->participant_id)->first();
                $participant->notify(new IncidentComment( $bookingOrder ) );
            }  

            return response()->json(['status'=>true, 'message'=>'Comment Added Successfully!'], 200);

        }
        catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }

    }

    //Complaint comment  (by provider or participant )
    public function addComplaintComment(Request $request){

        $data = Validator::make($request->all(),[
            'booking_order_id'   => 'required | integer',
            'complaint_id'   => 'required | integer',
            'author_ip'   => 'required',
            'content'   => 'required'
        ], []);
        
        //return error if any field is missing
        if($data->fails()):
            return response()->json(['status'=>false,'error'=>$data->messages()], 400);
        endif;


        try{

            $user =  \Auth::user();

            $bookingOrder = BookingOrders::find($request->booking_order_id);

            //Verify if BookingOrder is set
            if( empty ($bookingOrder) )
                return apiError('Something goes wrong with booking!', 500);

            
            //Check if incident exists for booking Order
            $complaint = $bookingOrder->complaints()->get()->firstWhere( 'id', $request->input('complaint_id') );

            if( ! $complaint )
                return apiError('Complaint not found!', 404);
            
            //Adding DB required fields
            $request->request->add([
                'relatation_id'=> $request->input('complaint_id'),
                'type'=> 'complaint',
                'user_id'=> $user->id
            ]);

            $comment = \App\Comment::create( $request->all() );

            $provider = \App\User::find($bookingOrder->booking->provider_id)->first();
            $provider->notify(new ComplaintComment( $bookingOrder ) );

            return response()->json(['status'=>true, 'message'=>'Comment Added Successfully!'], 200);

        }
        catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }

    }


    /***************************************************************************************************************************************/
    /** Notes Section */

    /**
     * Get notes linked with support worker
     *
     * @return mixed notes array and status
     * 
     */
    public function getNotes( Request $request, $booking_irder_id )
    {
        
        try{

            //Verify if BookingOrder is set
            if(!$request->bookingOrder)
                return apiError('Something goes wrong with booking!', 500);

            $notes = $request->bookingOrder->notes;

            return response()->json(['status'=>true,'notes'=>$notes], 200);
        }
        catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }
    }

    /**
     * Add note for support worker
     *
     * @return mixed note and status
     * 
     */
    public function addNote( Request $request)
    {
        $data = Validator::make($request->all(),[      
            'title' => ['required'],
            'description' => ['required'],
        ], []);

        if($data->fails()):
            return response()->json(['status'=>false,'error'=>$data->messages()], 400);
        endif;

        try{
            $user =  \Auth::user();

            //Verify if BookingOrder is set
            if(!$request->bookingOrder)
                return apiError('Something goes wrong with booking!', 500);

           $note = \App\Notes::create([
                'title' => trim($request['title']),
                'description' => trim($request['description']),
                'type' => 'booking',
                'relation_id' => $request->bookingOrder->id,
                'created_by' => $user->id,
                'provider_id' => $request->bookingOrder->booking->provider_id,
            ]);

            return response()->json(['status'=>true,'notes'=>"Note added successfully!", 'note_id' => $note->id ], 200);
        }
        catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }        

    }

    /**
     * 
     * Messages function of participant and support worker
     * 
     */

    public function message(Request $request)
    {
        
        $messages = [
            'bookingOrder.booking_id.required' => 'Booking id is required!',
            'message.required' => 'Message cannot be blank!',
        ];
        $data = Validator::make($request->all(),[
            'bookingOrder.booking_id' => 'required',           
            'message' => 'required'
        ], $messages);

        
        //return error if any field is missing
        if($data->fails()):
            return response()->json(['status'=>false,'error'=>$data->messages()], 400);
        endif;
        
        try{

            $user_id = \Auth::id();
            
            $bookingOrderInstance = BookingOrders::where('id', $request->booking_order_id)->first();
            
            $bookingOrderInstance->load('message');
        
            
            if(isset($bookingOrderInstance->message['0']->message_thread_id)) {
                    
                $thread_id = $bookingOrderInstance->message['0']->message_thread_id;

                $thread = Thread::findOrFail($thread_id);

                $thread->activateAllParticipants();

                $creator = $thread->creator();

                $provider = \App\User::find($creator->id);

                $comment = $request->input('message');

                // Message
                $message = Message::create([
                                'thread_id' => $thread->id,
                                'user_id' => $user_id,
                                'body' => $comment,
                            ]);
                  
                $provider->notify(new MessageForBooking( $thread->id, $comment, $user_id, $request->booking_order_id));

                return response()->json(['status'=>true,'message_id'=>$message['message_id']], 200);
                
            } else {
                
                $message = $request->input('message');
                
                $bookingOrder = BookingOrders::find($request->booking_order_id);
                
                $participant = \Auth::user();
                
                $provider = User::find( $bookingOrder->booking->provider_id ); 
                
                $message = $bookingOrder->sendBookingMessage( $provider, $message, $participant );
                
                return response()->json(['status'=>true,'thread_id'=>$message->message_id], 200);

            }
           
        }
        catch(Exception $exception){
           return reportAndRespond($exception, 400);
        }
        
    }

    public function getThreadList(Request $request, $booking_order_id)
    {
        
        //validate the request
        $messages = [
            'booking_id.required' => 'Booking id is required!',
            
        ];
        $data = Validator::make($request->all(),[
            'bookingOrder.booking_id' => 'required',           
        ], $messages);

        
        //return error if any field is missing
        if($data->fails()):
            return response()->json(['status'=>false,'error'=>$data->messages()], 400);
        endif;

        
        // All threads that user is participating in
        try {
            
            $bookingOrderInstance = BookingOrders::where('id',$booking_order_id)->first();
            $bookingOrderInstance->load('message');
            $thread_id = $bookingOrderInstance->message['0']->message_thread_id;
            $threads = Thread::findOrFail($thread_id);
            $threads->load('messages');
            
            return response()->json(['status'=>false,'thread'=>$threads], 200);

        } catch(ModelNotFoundException $exception) {
            
            \Log::critical( [ 'Message' => $exception->getMessage(), 'file' => $exception->getFile(), 'line'=>$exception->getLine() ] );

            return response()->json(['status'=>false, 'message'=>'Sorry, Please try agin '], 400);
        }
        catch(Exception $exception) {
            
            \Log::critical( [ 'Message' => $exception->getMessage(), 'file' => $exception->getFile(), 'line'=>$exception->getLine() ] );

            return response()->json(['status'=>false, 'message'=>'Sorry, Please try agin '], 400);
        }
    }



}
