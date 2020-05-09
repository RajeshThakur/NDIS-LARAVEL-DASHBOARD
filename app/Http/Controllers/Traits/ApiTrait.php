<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use App\RegistrationGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


trait ApiTrait
{

    /***************************************************************************************************************************************/
    /** Bookings Sections */
    /***************************************************************************************************************************************/

    /**
     * Fetch bookings linked with participant
     *
     * @return mixed bookings array and status
     * 
     */
    public function getBookings( Request $request)
    {
        try {

            //Fetch linked Participants List
            $bookings = \App\Bookings::withoutGlobalScopes()
                                    ->userBookings()
                                    // ->where('bookings.participant_id', \Auth::id())
                                    ->leftJoin('booking_orders','bookings.id','=','booking_orders.booking_id')
                                    ->leftJoin('registration_groups','bookings.item_number','=','registration_groups.id')
                                    ->select(
                                                'bookings.location as booking_location',
                                                'bookings.id as booking_id',
                                                'booking_orders.id as booking_order_id',
                                                'bookings.item_number as booking_item_id',
                                                'registration_groups.title as booking_item_title',
                                                'registration_groups.item_number as booking_item_number',
                                                'booking_orders.starts_at as booking_start_date',
                                                'booking_orders.ends_at as booking_end_date',
                                                'booking_orders.status as booking_status',
                                                'bookings.is_recurring as booking_is_recurring',
                                                'bookings.recurring_frequency as booking_recurring_frequency',
                                                'bookings.recurring_num as booking_recurring_count',
                                                'bookings.service_type as booking_service_type',
                                                'bookings.participant_id as participant',
                                                'bookings.supp_wrkr_ext_serv_id as worker_id',
                                                'bookings.provider_id as provider_id'
                                            )
                                    ->get()->toArray();

            foreach($bookings as $key => $booking){
                // dd($booking);
                $parentid = \App\RegistrationGroup::find( $booking['booking_item_id'])->parent_id;
                $reg_grp =\App\RegistrationGroup::find( $parentid);
                $provider =\App\User::find( $booking['provider_id']);

                $bookings[$key]['booking_reg_group_title'] = $reg_grp->title;
                $bookings[$key]['booking_reg_group_id'] = $reg_grp->id;
                $bookings[$key]['booking_reg_group_number'] = $reg_grp->item_number;
                $bookings[$key]['booking_provider'] = $provider->getName();
                unset($bookings[$key]['provider_id']);

                $bookings[$key]['participant'] = \App\Participant::basicInfo( $booking['participant'] );
                
                if( $booking['booking_service_type'] == 'external_service' ){
                    $bookings[$key]['external'] = \App\ServiceProvider::basicInfo( $booking['worker_id'] );
                    
                }else{
                    $bookings[$key]['support_worker'] = \App\SupportWorker::basicInfo( $booking['worker_id'] );
                    
                }
                unset($booking['worker_id']);

            }

            // pr($bookings, 1);
            
            return response()->json(['status'=>true,'bookings'=>$bookings], 200);

        }
        catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }
    }


    /**
     * List the details for a Booking Id for User
     *
     * @return mixed bookings array and status
     * 
     */
    public function getBooking( $booking_order_id, Request $request)
    {
        try {
            
            $booking = \App\Bookings::with(['participant', 'supportWorker','serviceProvider', 'registration_group'])
                                    ->userBookings()
                                    ->where( 'booking_orders.id', $booking_order_id )
                                    ->first();
            // dd($booking->toArray() );
            if(!$booking)
                return response()->json(['status'=>false,'message'=>"booking not found!"], 404);


            return response()->json(['status'=>true,'bookings'=>$booking->toArray()], 200);

        }
        catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }
    }





    


    /***************************************************************************************************************************************/
    /** Complaints */    
    /**
     * Fetch all complaints reported by participant
     *
     * @return mixed incident array and status
     * 
     */
    public function getUserComplaints(Request $request){
        try{
            $user =  \Auth::user();
            $complaints = \App\BookingComplaints::where('user_id', $user->id)->orWhere('created_by', $user->id)->get();
            return response()->json(['status'=>true, 'complaints'=>$complaints], 200);
        }
        catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }
    }

    /**
     * Fetch all complaints for booking with this participants
     *
     * @return mixed incident array and status
     * 
     */
    public function getComplaintsByUser(Request $request){
        try{
            $user =  \Auth::user();
            $complaints = $user->complaints;
            return response()->json(['status'=>true, 'complaints'=>$complaints], 200);
        }
        catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }
    }



    /***************************************************************************************************************************************/
    /** Incidents */
    
    /**
     * Fetch all incident report for participant
     *
     * @return mixed incident array and status
     * 
     */
    public function getUserIncidents(Request $request){
        try{
            $user =  \Auth::user();
            $incidents = \App\BookingIncidents::where('user_id', $user->id)->orWhere('created_by', $user->id)->get();
            return response()->json(['status'=>true, 'incidents'=>$incidents], 200);
        }
        catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }
    }

    /**
     * Fetch all incident report for participant
     *
     * @return mixed incident array and status
     * 
     */
    public function getIncidentsByUser(Request $request){
        try{
            $user =  \Auth::user();
            $incidents = $user->incidents;
            return response()->json(['status'=>true, 'incidents'=>$incidents], 200);
        }
        catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }
    }


    /***************************************************************************************************************************************/
    /** User Section */
    /***************************************************************************************************************************************/

    /**
     * update avatar/profileimage
     *
     * @return mixed profile fields and status
     * 
     */
    public function updateAvatar( Request $request )
    {
        // clearCache(true,true,true);
        $messages = [
            'avatar.required' => 'Upload an image !',
        ];
        $data = Validator::make($request->all(),[
            'avatar' => 'required | file',
        ], $messages);
        //return error if any field is missing
        if($data->fails()):
            return response()->json(['status'=>false,'error'=>$data->messages()], 400);
        endif;

        $file = $request->file('avatar');
        $user_id = \Auth::id();
        
        try {
            $document = \App\Documents::saveDoc( $file, [
                                            'title'=>'profile_image',
                                            'user_id'=>$user_id,
                                            'provider_id'=>1,
                                        ]);
            
            if( isset($document->url) ){
                //Save Avatar
                User::findOrFail($user_id)->update(['avatar'=>$document->id]);    
                return response()->json([ "status"=>true, "document_id" => $document->id, 'file_url'=>$document->url ], 200);
            }else {
                return response()->json([ "status"=>false, "error" => $document ], 400);
            }
        }
        catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }
       
    }

}