<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupportWorkerRequest;
use App\Http\Requests\UpdateSupportWorkerRequest;
use App\Http\Requests\StoreAvailabilityRequest;

use Illuminate\Http\Request;
use App\SupportWorker;
use App\User;
use App\Documents;
use App\Model\Api\Bookings;
use App\Model\Api\BookingOrders;
use App\Model\Api\BookingIncidents;
use App\Model\Api\BookingCheckin;
use App\Model\Api\BookingCheckout;
use App\Notes;
use App\Availability;
use Exception;

use Carbon\Carbon;
use App\Http\Controllers\Traits\Common;
use App\Http\Controllers\Traits\BookingProcessTrait;
use App\Http\Controllers\Traits\BookingTrait;
use App\Http\Controllers\Traits\ApiTrait;
use App\Http\Controllers\Traits\OpformTrait;
use App\Http\Controllers\Traits\SignatureTrait;
use App\RegistrationGroup;
use App\OperationalForms;
use App\OpformMeta;
use App\Role;

use DB;

use function PHPSTORM_META\map;

class SupportWorkerApiController extends Controller
{   
    
    use Common, BookingProcessTrait, BookingTrait, ApiTrait, SignatureTrait, OpformTrait;

     /**
     * Fetch return sw profile data
     *
     * @return mixed profile fields and status
     * 
     */
    public function getProfile( Request $request)
    {
        try {
            //Fetch SW data
            $sw = SupportWorker::where('support_workers_details.user_id', Auth::id())->first();

            unset($sw->id);
            unset($sw->password);
            unset($sw->remember_token);

            return response()->json(['status'=>false,'profile'=>$sw], 200);

        }
        catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }

    }


    /**
     * update sw profile data
     *
     * @return mixed profile fields and status
     * 
     */
    public function updateProfile( Request $request )
    {
        $messages = [
            // 'user_id.required' => 'User id is required!',
        ];
        $data = Validator::make($request->all(),
                            [
                                'email' => 'email | unique:users',
                                'avatar' => 'int'
                            ], $messages);
        //return error if any field is missing
        if($data->fails()):
            return response()->json(['status'=>false,'error'=>$data->messages()], 400);
        endif;

        try {

            //update Participant data
            $user = User::find(Auth::id());
            $supportWorker = $user->supportWorker;
            
            if ($request->filled('first_name'))
                $user->first_name = $request->input('first_name');
            if ($request->filled('last_name'))
                $user->last_name = $request->input('last_name');
            if ($request->filled('email'))
                $user->email = $request->input('email');
            if ($request->filled('mobile'))
                $user->mobile = $request->input('mobile');
            if ($request->filled('avatar'))
                $user->avatar = $request->input('avatar');

            $user->save();

            $supportWorker->address = $request->input('address', $supportWorker->address);
            $supportWorker->lat = $request->input('lat', $supportWorker->lat);
            $supportWorker->lng = $request->input('lng', $supportWorker->lng);
            
            $supportWorker->save();
            
            return response()->json(['status'=>true,'message'=>"Profile Updated Successfully." ], 200);

        }  
        catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }

    }


    /**
     * Fetch participants linked with support worker
     *
     * @return mixed participants array and status
     * 
     */
    public function getParticipants( Request $request)
    {
       
        try {
            //Fetch linked Participants List for Support Workers            
            $participants = \App\Participant::select(
                                                    'participants_details.user_id',
                                                    'users.first_name',
                                                    'users.last_name',
                                                    'users.email',
                                                    'users.mobile',
                                                    'users.avatar',
                                                    'participants_details.address',
                                                    'participants_details.lat',
                                                    'participants_details.lng',
                                                    'participants_details.ndis_number',
                                                    'participants_details.funds_balance'
                                                    )
                                ->forWorker(Auth::id())
                                ->get();
            // pr($participants, 1);
            return response()->json(['status'=>true,'participants'=>$participants], 200);

        }        
        catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }

    }

    
    /**
     * Search participants linked with support worker
     *
     * @return mixed participants array and status
     * 
     */
    public function searchParticipants( Request $request)
    {
    
        $messages = [
            'q.required' => 'Query cannot be blank!',
        ];
        $data = Validator::make($request->all(),[
            'q' => 'required',
        ], $messages);
        //return error if any field is missing
        if($data->fails()):
            return response()->json(['status'=>false,'error'=>$data->messages()], 400);
        endif;

        try {
            //Fetch linked Participants List
            $participants = \App\Participant::select(
                                                    'participants_details.user_id',
                                                    'users.first_name',
                                                    'users.last_name',
                                                    'users.email',
                                                    'users.mobile',
                                                    'users.avatar',
                                                    'participants_details.address',
                                                    'participants_details.lat',
                                                    'participants_details.lng',
                                                    'participants_details.ndis_number',
                                                    'participants_details.funds_balance'
                                                    )
                                ->forWorker(Auth::id())
                                ->search( trim($request->input('q')) )
                                ->get();
            // dd($participant);
            return response()->json(['status'=>true,'participants'=>$participants], 200);

        } 
        catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }
    }


    /**
     * Get availabilities of support worker
     *
     * @return mixed availabilities array and status
     * 
     */
    public function getAvailability( Request $request)
    {
        // clearCache(1,1,1);
        try{

            $availabilities = Availability::where('user_id',\Auth::id())
                                            ->select(
                                                      'user_availabilities.id as availability_id',  
                                                      'user_availabilities.range as day',  
                                                      'user_availabilities.from',
                                                      'user_availabilities.to',
                                                      'user_availabilities.is_bookable',
                                                      'user_availabilities.priority'
                                            )
                                            ->get();           
            // dd($availabilities->toArray());
            return response()->json(['status'=>true,'availabilities'=>$availabilities], 200);
        }
        catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }
    }


     /**
     * Create availabilities of support worker
     *
     * @return mixed availability and status
     * 
     */
    public function createAvailability( Request $request)
    {
        // dd($request->all());
        $messages = [
            'day'   => 'Day is required',
            'from'   => 'Start time is required',
            'to'   => 'End time is required',
            // 'user_type'   => 'User type is required',
        ];
        $data = Validator::make($request->all(),[           
            'day'   => 'required',
            'from'   => [ 'required', 'date_format:' . config('panel.time_format'), 'nullable' ],
            'to'   => [ 'required', 'date_format:' . config('panel.time_format'), 'nullable' ],
            // 'user_type'   => 'required',

        ], $messages);
        //return error if any field is missing
        if($data->fails()):
            return response()->json(['status'=>false,'error'=>$data->messages()], 400);
        endif;

        $user_id = \Auth::id();
        $type = 'support_worker';
        $range = $request->input('day');
        $from = $request->input('from');
        $to = $request->input('to');
        $provider = 1;

        try{
            $availability = Availability::create([
                                                'user_type'=>$type,
                                                'user_id'=>$user_id,
                                                'range'=>$range,
                                                'from'=>$from,
                                                'to'=>$to,
                                                'provider_id'=>$provider,
                                                'is_bookable'=>1,
                                                'priority'=>1,
                                            ]);
            return response()->json(['status'=>true, 'message'=>'Availability Created', 'availability_id'=>$availability->id], 200);            
        }
        catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }
    }


     /**
     * Update availabilitiy of support worker
     *
     * @return mixed availability and status
     * 
     */
    public function updateAvailability( $availability_id, Request $request)
    {
        // dd($request->all());
        $messages = [
            'day'   => 'Day is required',
            'from'   => 'Start time is required',
            'to'   => 'End time is required',
        ];
        $data = Validator::make($request->all(),[          
            'day'   => 'required',
            'from'   => [ 'required', 'date_format:' . config('panel.time_format'), 'nullable' ],
            'to'   => [ 'required', 'date_format:' . config('panel.time_format'), 'nullable' ],

        ], $messages);
        //return error if any field is missing
        if($data->fails()):
            return response()->json(['status'=>false,'error'=>$data->messages()], 400);
        endif;

        $user_id = \Auth::id();
        $type = 'support_worker';
        $range = $request->input('day');
        $from = $request->input('from');
        $to = $request->input('to');
        $provider = 1;

        $update = [
                    'user_type'=>$type,
                    'range'=>$range,
                    'from'=>$from,
                    'to'=>$to,
                    'user_id'=>$user_id,
                    'provider_id'=> $provider,
                ];

        try{           

            $availability = Availability::withoutGlobalScopes()
                                        ->where('user_id',$user_id)
                                        ->where('id',$availability_id);
                                        
            // dd(($availability->get()));
            
            if( ($availability->get())->isNotEmpty() ){
                $availability->update($update);
            }else{
                $e = new Exception('Availability not found');
                return response()->json([ 'status'=>false, 'error'=>$e->getMessage()],400);
            }          
            
            return response()->json(['status'=>true, 'message'=>'Availability Updated', 'data'=>$update], 200);
        }
        catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }
    }

     /**
     * Delete availabilitiy of support worker
     *
     * @return mixed availability and status
     * 
     */
    public function deleteAvailability( $availability_id,Request $request)
    {
        $user_id = \Auth::id();

        try{ 
            $availability = Availability::withoutGlobalScopes()
                                        ->where('user_id',$user_id)
                                        ->where('id',$availability_id);                                        
            // dd(($availability->get()));
            
            if( ($availability->get())->isNotEmpty() ){
                $availability->delete();
            }else{
                $e = new Exception('Availability not found');
                \Log::critical( [ 'Message' => $e->getMessage(), 'file' => $e->getFile(), 'line'=>$e->getLine() ] );
                return response()->json([ 'status'=>false, 'error'=>$e->getMessage()],400);
            }          
            
            return response()->json(['status'=>true, 'message'=>'Availability deleted'], 200);
        }
        catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }
    }


     /**
     * Check-in supportworker to start a booking
     *
     * @return mixed checkin status 
     * 
     */
    public function swBookingCheckin( $booking_order_id, Request $request)
    {
        $messages = [
            'sw_checkin'   => 'Checkin status is required',
            'sw_lat'   => 'Latitude is required',
            'sw_lng'   => 'Longitude is required',
        ];
        $data = Validator::make($request->all(),[
            'sw_checkin'   => 'required',
            'sw_lat'   => 'required',
            'sw_lng'   => 'required',
        ], $messages);
        //return error if any field is missing
        if($data->fails()):
            return response()->json(['status'=>false,'error'=>$data->messages()], 400);
        endif;

        try{
            //Adding required DB fields
            $request->request->add([
                'sw_checkin_time'=>Carbon::now(),
                'booking_order_id'=>$booking_order_id
            ]);
            
            $evaluation = $this->bookingStartConditionsEvaluator($booking_order_id,'sw', $request);

            //not needed now
            if ( ! $evaluation['status'] ):
                return response()->json(['status'=>false,'message'=>$evaluation['response']], 400);
            endif;
        
            return response()->json(['status'=>true,'message'=>'You have checked in to booking.'], 200);

        }
        catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }
       
    }


    /**
     * Check-out sw from currently active booking
     *
     * @return mixed checkout status
     * 
     */
    public function swBookingCheckout( $booking_order_id, Request $request)
    {
        $messages = [
            'sw_checkout'   => 'Checkout status is required',
            'sw_lat'   => 'Latitude is required',
            'sw_lng'   => 'Longitude is required',
        ];
        $data = Validator::make($request->all(),[
            'sw_checkout' => 'required',
            'sw_lat'   => 'required',
            'sw_lng'   => 'required',
        ], $messages);
        //return error if any field is missing
        if($data->fails()):
            return response()->json(['status'=>false,'error'=>$data->messages()], 400);
        endif;
        
        try{                     
            //Adding required DB fields
            $request->request->add([
                'sw_checkout_time'=>Carbon::now(),
                'booking_order_id'=>$booking_order_id
            ]);

            $evaluation = $this->bookingCompletionConditionsEvaluator($booking_order_id, 'sw', $request);
            
            //not needed now
            if ( ! $evaluation['status'] ):
                return response()->json(['status'=>false,'message'=>$evaluation['response']], 400);
            endif;

            return response()->json(['status'=>true,'message'=>'You have checked out of booking.'], 200);

        }
        catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }
  

    }


     /**
     * Get paid bookings list of support worker
     *
     * @return mixed payouts array and status
     * 
     */
    public function getPayouts( Request $request)
    {
        try{
            $arr = [];
            $payouts = \App\Payout::whereUserId(Auth::id())->get()->toArray();

            foreach( $payouts as $key=>$val){
                $arr[] = \App\Timesheet::select(
                                                'timesheet.payable_amount as booking_amount',
                                                'timesheet.travel_compensation',
                                                'timesheet.updated_at as paid_on',
                                                'timesheet.booking_order_id as order_id'
                                            )
                                            ->whereId($val['timesheet_id'])
                                            ->first()
                                            ->toArray();
            };

            // pr($arr,1);

            return response()->json(['status'=>true,'payouts'=>$arr], 200);
        }
        catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }
    }

    /**
     * 
     * Get Participant All agreements
     * 
     * 
     */
    public function getAgreements()
    {

        try {
             
            $user_id = \Auth::id();
            
            $agreementForms = OperationalForms::where(['user_id' => $user_id, 'template_id' => '13'])->get();            
            
            $agreementForms->map(function($item, $key) {

                $meta = OpformMeta::where('opform_id',$item->id)->get();

                $meta->each(function ($meta, $key) use( $item) {
                    
                    if(is_serialized($meta->meta_value))
                        $item->setAttribute($meta->meta_key, unserialize($meta->meta_value ));
                    else
                        $item->setAttribute($meta->meta_key, $meta->meta_value);  
                        
                });

            });
            

            return response()->json(['status'=>true, 'agreements'=>$agreementForms], 200);
        }
        catch(ModelNotFoundException $e){
            \Log::critical( [ 'Message' => $e->getMessage(), 'file' => $e->getFile(), 'line'=>$e->getLine() ] );
            return response()->json([ "status"=>false, "message" => 'Sorry, Please try again!','error'=>$e->getMessage() ], 400);
        }        
        catch(Exception $exception) {
            \Log::critical( [ 'Message' => $exception->getMessage(), 'file' => $exception->getFile(), 'line'=>$exception->getLine() ] );
            return response()->json(['status'=>false,'message'=>'Sorry, Please try again!','error'=>$exception->getMessage()], 400);
        }

    }

    /**
     * 
     * Update agreement of participant
     * 
     * 
     */
    public function updateAgreement(Request $request, $id)
    {
        
        try {

            $template_id = $request->input('template_id');
            //Perform validation
            switch( intval($template_id) ){
               case 13:
                   $validator = $this->validateNdisAgreement($request);
               break;
            }
           
            if(isset($validator)):
                if($validator->fails()):
                    $messages = $validator->customMessages;
                    return response()->json([ 'status'=>false, 'messages'=>$messages],400);
                endif;
            endif;

   
           $meta_fields = $request->input('meta',[]);
           
           foreach($meta_fields as $key => $val) {
               OpformMeta::where('opform_id', $id)->where('meta_key', $key)->update(['meta_value' => serialize($val)]);                
           }
   
            //Perform tasks based on template ID
            switch( intval($template_id) ){
                case 13:
                    $this->saveSupportServiceRegGroups($request);
                    $this->checkAgreementSigned($request);
                break;
           }   
           
           return response()->json([ 'status'=>true, 'messages'=>'Agreement form updated'],400);
        }
        catch(ModelNotFoundException $e){
            \Log::critical( [ 'Message' => $e->getMessage(), 'file' => $e->getFile(), 'line'=>$e->getLine() ] );
            return response()->json([ "status"=>false, "message" => 'Sorry, Please try again!','error'=>$e->getMessage() ], 400);
        }        
        catch(Exception $exception) {
            \Log::critical( [ 'Message' => $exception->getMessage(), 'file' => $exception->getFile(), 'line'=>$exception->getLine() ] );
            return response()->json(['status'=>false,'message'=>'Sorry, Please try again!','error'=>$exception->getMessage()], 400);
        }

    }

    //operation form validation rule for form no 11
    public function validateNdisAgreement($request)
    {
        $messages = [
            'registeration_group.required' => 'Registration group selection required.',
        ];


        return Validator::make($request->all(),[
            'registeration_group' => 'required|array'
        ], $messages);
    }

}