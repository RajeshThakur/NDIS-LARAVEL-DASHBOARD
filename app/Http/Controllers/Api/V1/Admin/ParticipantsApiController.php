<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreParticipantRequest;
use App\Http\Requests\UpdateParticipantRequest;
use Illuminate\Http\Request;
use App\Model\Api\Participant;
use App\ParticipantRegGroups;
use App\Model\Api\SupportWorker;
use App\Http\Controllers\Traits\OpformTrait;
use App\Http\Controllers\Traits\SignatureTrait;
use App\User;
use App\Documents;
use App\Model\Api\Bookings;
use App\BookingOrders;
use App\BookingIncidents;
use App\Model\Api\BookingCheckin;
use App\Model\Api\BookingCheckout;
use App\RegistrationGroup;
use App\Availability;
use App\OperationalForms;
use App\OpformMeta;
use App\Timesheet;
use App\Role;
use Exception;

use Carbon\Carbon;
use App\Http\Controllers\Traits\Common;
use App\Http\Controllers\Traits\BookingTrait;
use App\Http\Controllers\Traits\BookingProcessTrait;
use App\Http\Controllers\Traits\ApiTrait;

use DB;

use App\Notifications\InvoiceUploaded;


class ParticipantsApiController extends Controller
{

    
    use Common, BookingProcessTrait, BookingTrait, ApiTrait, SignatureTrait, OpformTrait, Notifiable;
    
    
    public function onboarding( Request $request )
    {

        $step = $request->input('step');
        
        switch( intval($step) ){
            case 1:

                $data = $request->validate([
                                            'have_gps_phone' => 'required',
                                            'using_guardian' => 'required',
                                            'user_id' => 'required',
                                            'step' => 'required'
                                        ]);

                $participant = new Participant;

                //Fetch User data
                $participant = $participant->getParticipantUser( $data['user_id'] );

                if( !$participant ){
                    return [ 'error'=>true, 'msg'=>'Invalid Submission! please try again later.' ];
                }

                $next_step = 2;

                //Update the Participant with given values
                $participant->where('user_id', $participant->user_id)->update([
                    'have_gps_phone' => $request->input('have_gps_phone'),
                    'using_guardian' => $request->input('using_guardian'),
                    'onboarding_step'=> $next_step
                ]);

                

                return [ 'success'=>true, 'type'=>'popup', 'next_step'=>$next_step ];

            break;

            case 2:
                
                $data = $request->validate([
                                                'provider_agreement' => 'required',
                                                'user_id' => 'required',
                                                'step' => 'required'
                                            ]);

                $participant = new Participant;

                //Fetch User data
                $participant = $participant->getParticipantUser( $data['user_id'] );
                
                
                if( !$participant ){
                    return [ 'error'=>true, 'msg'=>'Invalid Submission! please try again later.' ];
                }

                $next_step = 3;
                //Update the Participant with given values
                $participant->where('user_id', $participant->user_id)->update([ 'onboarding_step'=> $next_step ]);

                if( $data['provider_agreement'] ){
                    $agreement_link = route("admin.forms.index");
                    return [ 'success'=>true, 'type'=>'redirect', 'redirect_url'=>$agreement_link ];
                }else{
                    return [ 'success'=>true, 'type'=>'popup', 'next_step'=>$next_step ];
                }
                    
            break;

            case 3:

                $data = $request->validate([
                                            'care_plan_id' => 'required',
                                            'risk_assesment_id' => 'required',
                                            'consent_form_id' => 'required',
                                            'user_id' => 'required',
                                            'step' => 'required'
                                        ]);
                $participant = new Participant;

                //Fetch User data
                $participant = $participant->getParticipantUser( $data['user_id'] );
                
                
                if( !$participant ){
                    return [ 'error'=>true, 'msg'=>'Invalid Submission! please try again later.' ];
                }

                $next_step = 4;
                //Update the Participant with given values
                $participant->where('user_id', $participant->user_id)->update([ 'onboarding_step'=> $next_step ]);

                return [ 'success'=>true, 'type'=>'popup', 'next_step'=>$next_step ];

            break;
            case 4:

                $data = $request->validate([
                                            'start_booking' => 'required',
                                            'user_id' => 'required',
                                            'step' => 'required'
                                        ]);
                $participant = new Participant;

                //Fetch User data
                $participant = $participant->getParticipantUser( $data['user_id'] );
                
                
                if( !$participant ){
                    return [ 'error'=>true, 'msg'=>'Invalid Submission! please try again later.' ];
                }

                if($participant->using_guardian){
                    $next_step = 5;
                    $onboarding_complete = 0;
                }
                else{
                    $next_step = 9; // to finish this
                    $onboarding_complete = 1;
                }

                

                //Update the Participant with given values
                $participant->where('user_id', $participant->user_id)->update([ 'onboarding_step'=> $next_step, 'is_onboarding_complete'=>$onboarding_complete ]);

                if( $data['start_booking'] ){
                    $_link = route("admin.bookings.create");
                    return [ 'success'=>true, 'type'=>'redirect', 'redirect_url'=>$_link ];
                }else if($participant->using_guardian){
                    return [ 'success'=>true, 'type'=>'popup', 'next_step'=>$next_step ];
                }else{
                    return [ 'success'=>true, 'type'=>'finish' ];
                }

            break;


            case 5:

                $data = $request->validate([
                                            'guardian_email' => 'required',
                                            'guardian_password' => 'required|min:6|confirmed',
                                            'user_id' => 'required',
                                            'step' => 'required'
                                        ]);
                $participant = new Participant;

                //Fetch User data
                $participant = $participant->getParticipantUser( $data['user_id'] );
                
                
                if( !$participant ){
                    return [ 'error'=>true, 'msg'=>'Invalid Submission! please try again later.' ];
                }

                $guardian = $participant->addParticipantGuardian( $data['user_id'], $data['guardian_email'], $data['guardian_password'] );

                $next_step = 9; // to finish this
                $onboarding_complete = 1;

                //Update the Participant with given values
                $participant->where('user_id', $participant->user_id)->update([ 'onboarding_step'=> $next_step, 'is_onboarding_complete'=>$onboarding_complete ]);

                return [ 'success'=>true, 'type'=>'finish' ];


            break;

            default:
                return [ 'error'=>true, 'msg'=>trans('errors.internal_error'), 'step'=>intval($step) ];
            break;
        }
        
    }


    /**
     * Fetch return participant profile data
     *
     * @return mixed profile fields and status
     * 
     */
    public function getProfile( Request $request)
    {        
        try {
            //Fetch Participant data
            $participant = \App\Participant::where('participants_details.user_id', \Auth::id())
                                        ->first();
            
            // pr($participant, 1);
            unset($participant->id);
            unset($participant->password);
            unset($participant->remember_token);

            // pr($participant);
          
            return response()->json(['status'=>true,'profile'=>$participant], 200);

        }
        catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }

    }

    /**
     * update participant profile data
     *
     * @return mixed profile fields and status
     * 
     */
    public function updateProfile( Request $request )
    {
        
        $user = User::find(Auth::id());
        // $participant = Participant::withoutGlobalScope(ParticipantProviderScope::class)->get();       
        // dd($participant);
        // dd($request->all());
        $messages = [
            'user_id.required' => 'User id is required!',
        ];
        $data = Validator::make($request->all(),[
            
            'first_name' =>'required' ,
            'last_name' => 'required',
            'ndis_number'=>'required',
            'email' => 'required',
            'address'=>'required',
            'lat'=>'required',
            'lng'=>'required',
            
            // 'mobile' => 'required | min:10 ',
            
            // 'start_date_ndis'=>'required','date_format:Y-m-d', 
            // 'end_date_ndis'=>'required','date_format:Y-m-d|after:today',
            // 'avatar'=>'required',
            // 'user_id' => ['required',
            //                function ($attribute, $value, $fail) {
            //                             if (Auth::id() != $value) {
            //                                 $fail('Unauthorized request');
            //                             }
            //                         }
            //             ],
        ], $messages);
        //return error if any field is missing
        if($data->fails()):
            return response()->json(['status'=>false,'error'=>$data->messages()], 400);
        endif;
        try {
            //update Participant data
            $participant = Participant::withoutGlobalScopes()
                                        ->where('participants_details.user_id', Auth::id())
                                        ->update([
                                                    'address'=>$request->input('address'),
                                                    'lat'=>$request->input('lat'),
                                                    'lng'=>$request->input('lng'),
                                                    // 'start_date_ndis'=>Carbon::parse($request->input('start_date_ndis')),
                                                    // 'end_date_ndis'=>Carbon::parse($request->input('end_date_ndis')),
                                                    'ndis_number'=>$request->input('ndis_number'),
                                            ]);
            
            $updateUser = $user->update([
                'first_name'=>$request->input('first_name'),
                'last_name'=>$request->input('last_name'),
                'email'=>$request->input('email'),
                // 'mobile'=>$request->input('mobile')
            ]);
            // $participant->update($request->all());
            // dump($updateUser);
            // dd($participant);
          
            return response()->json(['status'=>true,'profile_data'=>$participant], 200);
        } catch(ModelNotFoundException $e) {
            return response()->json(['status'=>false,'message'=>'Sorry, Please try again!'], 400);
        }
    }


    /**
     * Get availabilities of participant
     *
     * @return mixed availabilities array and status
     * 
     */
    public function getAvailability( Request $request)
    {

        try{
            $availabilities = \App\Availability::where('user_id', \Auth::id())
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
     * Create availabilities of participant
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

        // $user_id = $request->input('user_id');
        $type = 'participant';
        $range = $request->input('day');
        $from = $request->input('from');
        $to = $request->input('to');
        $provider = 1;

        try{
            $availability = Availability::create([
                                                'user_type'=>$type,
                                                'user_id'=>\Auth::id(),
                                                'range'=>$range,
                                                'from'=>$from,
                                                'to'=>$to,
                                                'provider_id'=>$provider,
                                                'is_bookable'=>1,
                                                'priority'=>1,
                                            ]);
            return response()->json(['status'=>true, 'message'=>'Availability Created', 'availability_id'=>$availability->id], 200);            
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
     * Update availabilitiy of participant
     *
     * @return mixed availability and status
     * 
     */
    public function updateAvailability( $availability_id ,Request $request)
    {
        // dd($request->all());
        $messages = [
            'day'   => 'Day is required',
            'from'   => 'Start time is required',
            'to'   => 'End time is required',
            // 'availability_id' => 'Availability id is required'
        ];
        $data = Validator::make($request->all(),[           
            // 'availability_id'   => 'required | integer',
            'day'   => 'required',
            'from'   => [ 'required', 'date_format:' . config('panel.time_format'), 'nullable' ],
            'to'   => [ 'required', 'date_format:' . config('panel.time_format'), 'nullable' ],

        ], $messages);
        //return error if any field is missing
        if($data->fails()):
            return response()->json(['status'=>false,'error'=>$data->messages()], 400);
        endif;

        $user_id = \Auth::id();
        $type = 'participant';
        $range = $request->input('day');
        $from = $request->input('from');
        $to = $request->input('to');
        $provider = 0;
        // $availability_id = $request->input('availability_id', 0);

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
     * Delete availabilitiy of participant
     *
     * @return mixed availability and status
     * 
     */
    public function deleteAvailability( $availability_id ,Request $request)
    {
      
        try{ 
            $availability = Availability::withoutGlobalScopes()
                                        ->where('user_id',\Auth::id())
                                        ->where('id',$availability_id);
            // dd(($availability->get()));
            
            if( ($availability->get())->isNotEmpty() ){
                $availability->delete();
            }else{
                $e = new Exception('Availability not found');
                return response()->json([ 'status'=>false, 'error'=>$e->getMessage()],400);
            }          
            
            return response()->json(['status'=>true, 'message'=>'Availability deleted'], 200);
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
     * Fetch support worker linked with participants
     *
     * @return mixed support worker array and status
     * 
     */
    public function getSupportWorker(Request $request)
    {
        
        try {
            
            //Fetch linked supportworkers List for participant            
            $supportworkers = \App\SupportWorker::select(
                                                    'support_workers_details.user_id',
                                                    'users.first_name',
                                                    'users.last_name',
                                                    'users.email',
                                                    'users.mobile',
                                                    'users.avatar',
                                                    'support_workers_details.address',
                                                    'support_workers_details.lat',
                                                    'support_workers_details.lng'
                                                    )
                                ->ForParticpant(Auth::id())
                                ->get();

             //Fetch linked service provider List for participants            
            $serviceproviders = \App\ServiceProvider::select(
                                                    'service_provider_details.user_id',
                                                    'users.first_name',
                                                    'users.last_name',
                                                    'users.email',
                                                    'users.mobile',
                                                    'users.avatar',
                                                    'service_provider_details.address',
                                                    'service_provider_details.lat',
                                                    'service_provider_details.lng'
                                                    )
                                ->ForParticpant(Auth::id())
                                ->get();

            //combine the collection supportworker and service providers                    
            $swdetails = $supportworkers->concat($serviceproviders);

            $swdetails->all();
            // pr($participants, 1);
            return response()->json(['status'=>true,'swdetails'=>$swdetails], 200);

        }catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }

    }

     /**
     * Search supportworker/serviceprovider linked with participant
     *
     * @return mixed sw array and status
     * 
     */
    public function searchSupportWorker( Request $request)
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
            $supportworkers = \App\SupportWorker::select(
                                                    'support_workers_details.user_id',
                                                    'users.first_name',
                                                    'users.last_name',
                                                    'users.email',
                                                    'users.mobile',
                                                    'users.avatar',
                                                    'support_workers_details.address',
                                                    'support_workers_details.lat',
                                                    'support_workers_details.lng'
                                                    )
                                ->ForParticpant(Auth::id())
                                ->search( trim($request->input('q')) )
                                ->get();

            //Fetch linked service provider List for participants            
            $serviceproviders = \App\ServiceProvider::select(
                                                    'service_provider_details.user_id',
                                                    'users.first_name',
                                                    'users.last_name',
                                                    'users.email',
                                                    'users.mobile',
                                                    'users.avatar',
                                                    'service_provider_details.address',
                                                    'service_provider_details.lat',
                                                    'service_provider_details.lng'
                                                    )
                                ->ForParticpant(Auth::id())
                                ->search( trim($request->input('q')) )
                                ->get();

            //combine the collection supportworker and service providers                    
            $swdetails = $supportworkers->concat($serviceproviders);
            
            $swdetails->all();
            
            return response()->json(['status'=>true,'supportworkers'=>$swdetails], 200);

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
            
            $agreementForms = OperationalForms::where(['user_id' => $user_id, 'template_id' => '11'])->get();
            
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

            $opFormAttribute = ['id', 'title', 'date', 'user_id', 'provider_id', 'template_id', 'provider_signed', 'created_at', 'updated_at', 'deleted_at'];

            $template_id = $request->input('template_id');
            //Perform validation
            switch( intval($template_id) ){
               case 11:
                   $validator = $this->validateNdisAgreement($request);
               break;
            }
           
            if(isset($validator)):
                if($validator->fails()):
                    $messages = $validator->customMessages;
                    return response()->json([ 'status'=>false, 'messages'=>$messages],400);
                endif;
            endif;

            

            
           foreach($request->all() as $key=>$value){
               if(!in_array($key, $opFormAttribute)){
                   $meta_fields[$key] = $value;
               }
           }
           
           //update or create opform meta key value pair
           foreach($meta_fields as $key => $val) {
                OpformMeta::where('opform_id', $id)->where('meta_key', $key)->update(['meta_value' => serialize($val)]);
           }
   
            //Perform tasks based on template ID
            switch( intval($template_id) ){
               case 11:
                   // Maybe Save Participant Data
                   $this->maybeSaveParticipantData($request);
                   $this->saveParticipantRegGroups($request);
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


     /**
     * 
     * Get Participant Transactions
     * 
     * 
     */
    public function getTransactions(Request $request)
    {
        
        try {

            $user_id = \Auth::id();

            $bookings = Bookings::where('participant_id', $user_id)->get();

            $bookings->load('orders'); 
            
            if($bookings->isEmpty())
            {
                $e = new Exception('Transactions not found');
                return response()->json([ 'status'=>false, 'error'=>$e->getMessage()],400);
            }
            

            $booking_paid_ids = $bookings->map->orders->mapSpread(function ($item,$key){

                if($item->status == 'Paid'){
                    return $item->id;
                }
            });

            $transactions = BookingOrders::whereIn('id',$booking_paid_ids)->get();

            if(!$transactions->isEmpty()){

                $participant_detail = Participant::where('user_id',$user_id)->first();
                return response()->json(['status'=>true, 'transactions'=>$transactions, 'participant_detail'=>$participant_detail], 200);
                
            }else{
                $e = new Exception('Transactions not found');
                return response()->json([ 'status'=>false, 'error'=>$e->getMessage()],400);
            }          
        
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


    /**
     * Upload invoice
     *
     * @return mixed docid and status
     * 
     */
    public function uploadInvoice(Request $request)
    {
        $messages = [
            'document.required' => 'Invoice is missing please upload it.',
            'booking_id' => 'Booking id is required.',
        ];

        $data = Validator::make($request->all(),[
            'document' => 'required | file | mimes:jpg,jpeg,bmp,png,pdf,doc,docx,xls,xlsx',
            'booking_id' => 'required ',
        ], $messages);

        if($data->fails()):
            return response()->json(['status'=>false,'error'=>$data->messages()], 400);
        endif;

        $user = \Auth::User();

        $file = $request->file('document');
        // $booking_order = BookingOrders::with('booking')->find($request->booking_id);
        $booking_order = BookingOrders::with('booking','participant','supportWorker','worker')
                                        ->whereId( $request->booking_id )
                                        ->whereIn('status',[ config('ndis.booking.statuses.Started'),config('ndis.booking.statuses.NotSatisfied') ])
                                        ->first();
        // dd($booking_order,1);
       
        $provider = User::find($user->getUserProviders()->first()->provider_id);

        //check if booking exists
        if( $booking_order == null ){
            return response()->json([ "status"=>false, "error" => "Sorry, no booking found! " ], 400);
        }
        
        //check if external service
        if( $booking_order->booking->service_type != 'external_service' ){
            return response()->json([ "status"=>false, "error" => "You can upload invoice only for an External Service." ], 400);
        }

        
        //confirm if participant belongs to booking
        if( $booking_order->participant->user_id !== $user->id ){
            return response()->json([ "status"=>false, "error" => "User don't belong to this booking." ], 400);
        }
        
        try {
            $document = \App\Documents::saveDoc( $file, [
                                            'title'=> 'invoice',
                                            'user_id'=>$user->id,
                                            'provider_id'=>$provider->id,
                                        ]);
            if($document){
                $metaArray[] = [
                                'booking_order_id' => $request->booking_id,
                                'meta_key' => 'invoice_id',
                                'meta_value' => $document->id
                                ];
                $booking_order->meta()->create($metaArray);
            }
            

            $notification_data['participant'] =  $user->id;
            $notification_data['sw'] =  $booking_order->booking->supp_wrkr_ext_serv_id;
            $notification_data['url'] =   $document->url;
            $notification_data['time'] =  $document->created_at;
            
            if( isset($document->url) ){

                $provider->notify(new InvoiceUploaded( $notification_data ));

                return response()->json([ "status"=>true, "document_id" => $document->id, 'file_url'=>$document->url ], 200);
            }else {
                return response()->json([ "status"=>false, "error" => $document ], 400);
            }
        }
        catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }
    }


     /**
     * Get total funds
     *
     * @return mixed total_funds and status
     * 
     */
    public function getTotalAllocatedFunds( Request $request )
    {
        try {            
            $total_funds = Participant::find( \Auth::id() )->pluck('budget_funding');
            return response()->json(['status'=>true, 'total_funds'=>$total_funds[0]], 200);
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
     * Get total remaining funds
     *
     * @return mixed total_remaining_funds and status
     * 
     */
    public function getTotalRemainingFunds( Request $request )
    {
        try {            
            $total_remaining_funds = Participant::find( \Auth::id() )->pluck('funds_balance');
            return response()->json(['status'=>true, 'total_remaining_funds'=>$total_remaining_funds[0]], 200);
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
     * Get funds allocated to a registarion group 
     *
     * @return mixed allocated_to_reg_group and status
     * 
     */
    public function getAllocatedRegGroupFunds( Request $request )
    {
        $messages = [
            'reg_group_id.required' => 'Registration group id is required.',
        ];
        $data = Validator::make($request->all(),[
            'reg_group_id' => 'required',
        ], $messages);
        //return error if any field is missing
        if($data->fails()):
            return response()->json(['status'=>false,'error'=>$data->messages()], 400);
        endif;

        try {            
            $allocated_reg_group_funds = ParticipantRegGroups::whereUserId( \Auth::id() )->whereRegGroupId( trim($request->reg_group_id) )->pluck('budget');
            return response()->json(['status'=>true, 'allocated_reg_group_funds'=>$allocated_reg_group_funds[0]], 200);
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
     * Get annual remaining funds for a registarion group 
     *
     * @return mixed remaining_reg_group_funds and status
     * 
     */
    public function getRemainingRegGroupFunds( Request $request )
    {
        $messages = [
            'reg_group_id.required' => 'Registration group id is required.',
        ];
        $data = Validator::make($request->all(),[
            'reg_group_id' => 'required',
        ], $messages);
        //return error if any field is missing
        if($data->fails()):
            return response()->json(['status'=>false,'error'=>$data->messages()], 400);
        endif;

        try {
            $remaining_reg_group_funds = ParticipantRegGroups::whereUserId( \Auth::id() )->whereRegGroupId( trim($request->reg_group_id) )->pluck('anual_funds_balance');
            return response()->json(['status'=>true, 'remaining_reg_group_funds'=>$remaining_reg_group_funds[0]], 200);
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
     * Get paid services list
     *
     * @return mixed paid_services_list and status
     * 
     */
    public function getPaidServicesList( Request $request )
    {
        try {

            $participant = Participant::whereUserId( \Auth::id() )->with('bookings')->first();
            $paid =  [];
            $booking_orders = new BookingOrders();
            foreach( $participant->bookings as $k=>$booking ){
                $paid_order = $booking_orders->whereBookingId($booking->id)->whereStatus( config('ndis.booking.statuses.Paid'))->get();
                if ( $paid_order->isNotEmpty() ){
                    
                    $paid[$k]['order_id'] = $paid_order->pluck('booking_id')[0];
                    $paid[$k]['paid_amount'] = $paid_order->pluck('timesheet.total_amount')[0];
                    $paid[$k]['service_name'] = RegistrationGroup::find( $paid_order->pluck('booking.item_number')[0] )->pluck('title')[0];
                    // dump($paid_order);
                };
            }

            // dd($paid);


            return response()->json(['status'=>true, 'paid_services'=>$paid], 200);
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
     * Get funds detail
     *
     * @return mixed total_funds and status
     * 
     */
    public function getFundsDetail( Request $request )
    {
        try {            
            $total_funds = Participant::find( \Auth::id() );
            $allocated_reg_group_funds = ParticipantRegGroups::whereUserId( \Auth::id() )->get();
            // dd($allocated_reg_group_funds->toArray());

            $reg_group = [];
            foreach( $allocated_reg_group_funds as $k=>$v   ){

                $reg_group[$k]['item_group_id'] = $v->reg_group_id;
                $reg_group[$k]['item_group_title'] = $v->reg_group_id ? RegistrationGroup::whereId( $v->reg_group_id )->pluck('title')[0] : null;
                
                $reg_group[$k]['item_id'] = $v->reg_item_id;
                $reg_group[$k]['item_title'] = $v->reg_item_id ? RegistrationGroup::whereId( $v->reg_item_id )->pluck('title')[0] : null;

                $reg_group[$k]['budget'] = $v->budget;
                $reg_group[$k]['balance'] = $v->anual_funds_balance;

                // dump( RegistrationGroup::whereId( $v->reg_group_id )->pluck('title')[0]);
            }

            return response()->json( [
                                        'status'=>true,
                                        'total_allocated_funds'=>$total_funds->budget_funding,
                                        'total_remaining_funds'=>$total_funds->funds_balance,
                                        'total_spent_funds'=> $total_funds->budget_funding - $total_funds->funds_balance,
                                        'registration_groups'=> $reg_group,
                                    ],
                            200);
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



}