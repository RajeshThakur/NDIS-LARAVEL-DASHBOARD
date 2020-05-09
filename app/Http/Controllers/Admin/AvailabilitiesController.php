<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\StoreAvailabilityRequest;
use App\Http\Requests\DestroyAvailabilityRequest;


use App\Availability;


class AvailabilitiesController extends Controller
{
    

    public function ajax_save( StoreAvailabilityRequest $availability ){

        abort_unless(\Gate::allows('participant_edit'), 403);
        
        $user_id = $availability->input('user_id');
        $availability_id = $availability->input('availability_id', 0);
        $type = $availability->input('type', 'participant');
        $range = $availability->input('range');
        $from = $availability->input('from');
        $to = $availability->input('to');
        $provider = \Auth::user();

        try{

            if($availability_id){

                $availability = Availability::where('user_id',$user_id)->where('id',$availability_id)->first();

                if($availability){
                    $availability->range = $range;
                    $availability->from = $from;
                    $availability->to = $to;
                    $availability->save();
                }
                
                return [ 'status'=>true, 'message'=> trans('msg.availability.updated'), 'availability_id'=>$availability->id];

            }
            else{
                $availability = Availability::create([
                                                    'user_type'=>$type,
                                                    'user_id'=>$user_id,
                                                    'range'=>$range,
                                                    'from'=>$from,
                                                    'to'=>$to,
                                                    'provider_id'=>$provider->id,
                                                    'is_bookable'=>1,
                                                    'priority'=>1,
                                                ]);
                return [ 'status'=>true, 'message'=>trans('msg.availability.created'), 'availability_id'=>$availability->id];
            }

            
            
            

        }
        catch(Exeption $e){
            return [ 'status'=>false, 'message'=>$e->getMessage() ];
        }
    }


    public function ajax_remove( DestroyAvailabilityRequest $availability ){

        abort_unless(\Gate::allows('participant_edit'), 403);
        
        $user_id = $availability->input('user_id');
        $availability_id = $availability->input('availability_id');
        $provider = \Auth::user();

        try{
            $availability = Availability::where('user_id',$user_id)->where('id',$availability_id)->first();
            if($availability)
                $availability->delete();

            return [ 'status'=>true, 'message'=>trans('msg.availability.deleted')];

        }
        catch(Exeption $e){
            return [ 'status'=>false, 'message'=>$e->getMessage() ];
        }
    }


}
