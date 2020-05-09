<?php

namespace App\Http\Controllers\Traits;


use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\StoreBookingMessageRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Http\Requests\StoreBookingIncidentRequest;

use App\Http\Controllers\Traits\Common;
//use App\Http\Controllers\Traits\BookingProcessTrait;

use App\Provider;
use App\Participant;
use App\RegistrationGroup;
use App\Bookings;
use App\SupportWorker;
use App\User;

use Dmark\DMForms\FormService as Form;

trait BookingProcessTrait
{
    
    //---------------------------------------------------------------------------------------------------------
    // AJAX Functions
    //---------------------------------------------------------------------------------------------------------
    public function ajax_create_form( Request $request ){
        
        abort_unless( \Gate::allows('service_booking_create'), 403 );

        if ( \Auth::user()->roles()->get()->contains(1) || Gate::allows('onboarding-complete', (Provider::where('user_id', '=', \Auth::user()->id )->firstOrFail()->is_onboarding_complete)) ) {

            // $data = $request->validate([
            //     'guardian_email' => 'required',
            //     'guardian_password' => 'required|min:6|confirmed',
            //     'user_id' => 'required',
            //     'step' => 'required'
            // ]);
            
            $section = $request->query('section');

            $participants = Participant::getBookableParticipants()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');
            

            if($section == 'sw'){
                $html = view("admin.bookings.supportWrkr",compact('participants'))->render();
                return response()->json([ 'success'=>true, 'html'=>$html ]);
            }
            
            if($section == 'esp'){
                $html = view("admin.bookings.extservice",compact('participants'))->render();
                return response()->json([ 'success'=>true, 'html'=>$html ]);
            }

            return response()->json([ 'error'=>true, 'msg'=>"Invalid request!" ]);
        }

    }

    public function ajax_participant_details( Request $request ){
        
        abort_unless( \Gate::allows('service_booking_create'), 403 );

        // dd($request);

        $validator = Validator::make(   $request->all(),
                                        [
                                            'service_type' => 'required',
                                            'participant_id' => 'required'
                                        ]
                                    );

        if ($validator->fails()) {
            $_err = [];
            foreach( $validator->errors()->getMessages()  as $err)
                $_err[] = $err[0];

            return response()->json(['status' => false, 'message' => implode('<br/>', $_err)], 200);
        }


        $participantId = $request->input('participant_id');
        $service_type = $request->input('service_type');

        $daysAvailable = \App\Availability::userAvailabilityDays($participantId);
        if(!$daysAvailable){
            return response()->json([ 'status'=>false, 'message'=>"Participant haven't updated the Availabily!" ]);
        }
        
        $_daysAvailable = [];
        $daysDisabled = [0,1,2,3,4,5,6];
        $availbleDaysMsgs = [];

        foreach($daysAvailable as$day){
            $d_num = date("w", strtotime( $day['range'] ));
            if(in_array( $d_num, $daysDisabled ))
                unset($daysDisabled[$d_num]);
            
            $availbleDaysMsgs[$d_num] = $day['range'];

            $_k = isset($_daysAvailable[$d_num])?count($_daysAvailable[$d_num]):0;
            $_daysAvailable[$d_num][$_k]['from'] = $day['from'];
            $_daysAvailable[$d_num][$_k]['to'] = $day['to'];
        }

        ksort($availbleDaysMsgs);

        $disabledDaysMsg = "";
        if(count($daysDisabled))
            $disabledDaysMsg = "Particiapnt is only available on ".implode(', ', $availbleDaysMsgs);

        // pr($_daysAvailable);
        //Free the memory
        unset($daysAvailable);

        // We need to get the following for a service Booking
        // - Participant default address
        // $participant = \App\User::with('participant')->where('id',$participantId)->first();

        $participant = \App\Participant::where('participants_details.user_id',$participantId)->where('participants_details.is_onboarding_complete',1)->first();

        if($service_type == 'external_service'){
            $regGroups = $participant->getParticipantExternalRegGroups();
        }else{
            // $regGroups = $participant->getParticipantRegGroups();
            $regGroups = $participant->getParticipantInhouseRegGroups();
        }
        

        // pr($regGroups, 1);

        $form = new Form;
        $regGroupDDHTML = $form->select('registration_group_id', trans('bookings.fields.registration_group'),  $regGroups )
                                ->id('registration_group_id')
                                ->size('col-sm-6')
                                ->help(trans('bookings.fields.registration_group_helper'))
                                ->required();

        $form = new Form;
        $regItemDDHTML = $form->select('item_number', trans('bookings.fields.item_number'),  ['Please Select Registration Group first'] )
                                ->id('item_number')
                                ->size('col-sm-6')
                                ->help(trans('bookings.fields.item_number_helper'))
                                ->required();
        
        if($participant->user_id){
            
            return response()->json([   'status'=>true,
                                        'result'=>[
                                                    'address' => $participant->address,
                                                    'lat' => $participant->lat,
                                                    'lng' => $participant->lng,
                                                    'regGroupDDHTML' => (string) $regGroupDDHTML,
                                                    'regItemDDHTML' => (string) $regItemDDHTML,
                                                    'daysDisabled' => implode(',',$daysDisabled),
                                                    'disabledDaysMsg' => $disabledDaysMsg,
                                                    'daysAvailable' => $_daysAvailable,
                                                ]
                                    ]);
        }
        
        return response()->json([ 'error'=>true, 'msg'=>"Participant might not have completed the Onboarding Process!" ]);
        
    }


    public function ajax_check_availbale_time( Request $request ){

        abort_unless( \Gate::allows('service_booking_create'), 403 );

        // dd($request);

        $validator = Validator::make(   $request->all(),
                                        [
                                            'service_type' => 'required',
                                            'participant_id' => 'required'
                                        ]
                                    );

        if ($validator->fails()) {
            $_err = [];
            foreach( $validator->errors()->getMessages()  as $err)
                $_err[] = $err[0];

            return response()->json(['status' => false, 'message' => implode('<br/>', $_err)], 200);
        }

        $participantId = $request->input('participant_id');
        $service_type = $request->input('service_type');
        
    }

    public function ajax_registration_items( Request $request ){
        
        $request->validate([ 'parentId' => 'bail|required|integer' ]);

        $parentId = $request->input('parentId');

        if($parentId){
        
            $regItems = RegistrationGroup::where('parent_id', '=', $parentId)->pluck('title', 'id')->prepend( 'Select Registration Item', '' );

            $form = new Form;
            $regItemsDDHTML = $form->select('item_number', trans('bookings.fields.item_number'),  $regItems )
                                    ->id('item_number')
                                    ->size('col-sm-6')
                                    ->help(trans('bookings.fields.item_number_helper'))
                                    ->required();

            return response()->json([ 'success'=>true, 'result'=>[
                                        'regItemsDDHTML' => (string) $regItemsDDHTML,
                                        ]
                                    ]);

        }
        
        return response()->json([ 'error'=>true, 'msg'=>trans('errors.internal_error') ]);


    }

    /**
     * Function to search for bookable Support workers using the following conditions
     * - Support worker is related to the given Registration Group
     * - Support worker is available within given date|start_time|end_time
     * - Support worker is within a fesible distance of the location Lat/Lng
     */
    public function ajax_bookable_support_workers( Request $request ){
        
        abort_unless( \Gate::allows('service_booking_create'), 403 );


        $validator = Validator::make(   $request->all(),
                                        [
                                            'service_type' => 'required',
                                            'participant_id' => 'required',
                                            'bookingDate' => 'required',
                                            'bookingStart' => 'required',
                                            'bookingEnd' => 'required',
                                            'regGroup' => 'required',
                                            'lat' => 'required',
                                            'lng' => 'required',
                                        ]
                                    );

        if ($validator->fails()) {
            $_err = [];
            foreach( $validator->errors()->getMessages()  as $err)
                $_err[] = $err[0];

            return response()->json(['error' => true, 'msg' => implode('<br/>', $_err)], 200);
        }


        $participant_id = $request->input('participant_id');
        $regGroup = $request->input('regGroup');
        $service_type = $request->input('service_type');

        // We need to get the following for a service Booking
        // - Participant default address
        $participant = \App\Participant::where('participants_details.user_id',$participant_id)->ready()->first();


        $provider = \Auth::user();
        
        if($participant->user_id){
            
            if($service_type == 'support_worker'){
                $_sw = new SupportWorker;
                
                //Get Support Workers for RegGroups
                $resourceSW = $_sw->getSupportWorkerIdsByRegGroup( $regGroup );

                if($resourceSW){

                    $bookingDate = $request->input('bookingDate');
                    $bookingStart = $request->input('bookingStart');
                    $bookingEnd = $request->input('bookingEnd');

                    // pr($resourceSW, 1);

                    //Check if Support Worker is availble on the given date time
                    $resourceSW = $_sw->filterSWbyAvailability( $resourceSW, $bookingDate, $bookingStart, $bookingEnd );

                    if($resourceSW){

                        $lat = $request->input('lat');
                        $lng = $request->input('lng');

                        //Next Check Closest Support Workers
                        $resourceSW = $_sw->filterSWbyLocation( $resourceSW, $lat, $lng );

                        // pr($resourceSW);

                        $bookableSupportWorkers = [];
                        foreach($resourceSW as $key => $SW){
                            $bookableSupportWorkers[$SW->user_id] = $SW->name . ' ( '. number_format($SW->distance, 2) .' kms)';
                        }

                        if(empty($bookableSupportWorkers))
                            $bookableSupportWorkers[0] =  "No Support Worker Found in date/Location";


                        $form = new Form;
                        $swDDHTML = $form->select('supp_wrkr_ext_serv_id', trans('bookings.fields.support_worker'),  $bookableSupportWorkers )
                                                ->id('supp_wrkr_ext_serv_id')
                                                ->size('col-sm-6')
                                                ->help(trans('bookings.fields.support_worker_helper'))
                                                ->required();
                        
                        // pr( (string) $swDDHTML, 1);
                        return response()->json([ 'success'=>true, 
                                                    'result' => [
                                                                'swDDHTML' => (string) $swDDHTML
                                                                ]
                                                            ]);

                    }
                }
            }   // end if $service_type == 'support_worker'

            if($service_type == 'external_service'){

                $_sw = new \App\ServiceProvider;
                //Get Support Workers for RegGroups
                $resourceSW = $_sw->getServiceProviderIdsByRegGroup( $regGroup )->pluck('name', 'user_id');

                // pr($resourceSW, 1);

                $form = new Form;
                $swDDHTML = $form->select('supp_wrkr_ext_serv_id', trans('bookings.fields.ext_service_provider'),  $resourceSW )
                                        ->id('supp_wrkr_ext_serv_id')
                                        ->size('col-sm-6')
                                        ->help(trans('bookings.fields.ext_service_provider_helper'))
                                        ->required();

                return response()->json([   'success'=>true, 
                                            'result' => [
                                                        'swDDHTML' => (string) $swDDHTML
                                                        ]
                                                    ]);

            }


        }

        return response()->json([ 'error'=>true, 'msg'=>"'No Support Worker Found in given creteria!" ]);
        
    }

    public function ajax_nearby_sw( Request $request ){
        
        abort_unless( \Gate::allows('service_booking_create'), 403 );
        // pr($request->all());
        
        $support_workers = Bookings::getNearBySupportworkers(  );

        // pr( $support_workers,1);
        

        return response()->json([ 'status'=>true,'msg'=>$support_workers ]);

    }

    public function ajax_participant_reg_grp( Request $request ){
        
        abort_unless( \Gate::allows('service_booking_create'), 403 );
        // pr($request->all());

       
        $regGroups = Bookings::participantsRegGroups( $request->participant_id);

        // pr( $support_workers,1);


        return response()->json([ 'status'=>true,'msg'=>$regGroups ]);

    }    

}
