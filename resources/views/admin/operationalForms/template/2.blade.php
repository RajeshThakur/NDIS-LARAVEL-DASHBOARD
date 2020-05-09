@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-body">
      <div class="operational-form-design">
         {{-- two care plane form start here--}}
         <form action="{{ route($formAction[0],$formAction[1]) }}" method="POST" class="validated" enctype="multipart/form-data">
            @csrf
            @if(!empty($formAction[1]))
            @method('PUT')
            @endif
            <div class="card-header">
               <h2>Care Plan</h2>
            </div>
            <div class="form-group mt-20">
               <h4>CLIENT DETAILS</h4>
            </div>
            <input type="hidden" name="template_id" value="2">
            <input type="hidden" name="user_id" value='{{$participant->user_id}}'>
            <input type="hidden" name="participant_controller" value='{{$participantController}}'>
            <div class="row">
               <div class="label col-sm-4">
                  <div class="form-group">
                     <label>{{trans('opforms.fields.client_name')}}</label>
                  </div>
               </div>
               <div class="label col-sm-8">
                  {!! 
                  Form::text('client_full_name', '', old('client_full_name', $participant->getName() ) )
                  ->id('client_full_name')
                  ->readonly($readOnly)
                  ->hideLabel()
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="label col-sm-4">
                  <div class="form-group">
                     <label>{{trans('opforms.fields.date_of_birth')}}</label>
                  </div>
               </div>
               <div class="label col-sm-8">
                  {!! 
                  Form::date('meta[client_date_of_birth]', '' , old('client_date_of_birth', isset($meta['client_date_of_birth']) ? $meta['client_date_of_birth'] : date('d-m-Y')))
                  ->id('date-1')
                  // ->required('required')
                  ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>trans('errors.opform.dob') ])
                  ->hideLabel()
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="label col-sm-4">
                  <div class="form-group">
                     <label>{{trans('opforms.fields.address')}}</label>
                  </div>
               </div>
               <div class="label col-sm-8">
                  {!! 
                  Form::location(
                  'meta[client_residential]', 
                  '', 
                  valOrAlt( $meta, 'client_residential', $participant, 'address' ),
                  valOrAlt( $meta, 'client_lat', $participant, 'lat' ),
                  valOrAlt( $meta, 'client_lng', $participant, 'lng' )
                  )
                  ->id('participant_address')
                  ->locationLatName('meta[participant_lat]')
                  ->locationLngName('meta[participant_lng]')
                  // ->required('required')
                  ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Client address requried" ])
                  ->hideLabel()
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="label col-sm-4">
                  <div class="form-group">
                     <label>{{trans('opforms.fields.client_goal')}}</label>
                  </div>
               </div>
               <div class="label col-sm-8">
                  {!! 
                  Form::textarea('meta[client_goal]', '', issetKey( $meta, 'client_goal', '' ))
                  ->hideLabel()
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="form-group">
               <h4>SERVICES AND INTERVENTIONS</h4>
            </div>
            
            <div class="row">
               <div class="label col-sm-4">
                  <div class="form-group">
                     <label>{{trans('opforms.fields.client_meal_name')}}</label>
                  </div>
               </div>
               <div class="label col-sm-8">
                  {!! 
                  Form::text('meta[client_meal_name]', '', issetKey( $meta, 'client_meal_name', '' ))
                  ->id('client_meal_name')
                  ->hideLabel()
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="label col-sm-4">
                  <div class="form-group">
                     <label>{{trans('opforms.fields.transportation')}}</label>
                  </div>
               </div>
               <div class="label col-sm-8">
                  {!! 
                  Form::text('meta[transportation]', '', issetKey( $meta, 'transportation', '' ))
                  ->id('transportation')
                  ->hideLabel()
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="label col-sm-4">
                  <div class="form-group">
                     <label>{{trans('opforms.fields.details')}}</label>
                  </div>
               </div>
               <div class="label col-sm-8">
                  {!! 
                  Form::text('meta[details]', '', issetKey( $meta, 'details', '' ))
                  ->id('details')
                  ->hideLabel()
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="below-form">
               <div class="row">
                  <div class="label col-sm-4">
                     <div class="form-group">
                        <label>{{trans('opforms.fields.advocate_agree_plan', [ 'client_name'=>$participant->getName() ])}}</label>
                     </div>
                  </div>
                  <div class="label col-sm-8">
                     {!! 
                     Form::text('meta[being_an_advocate]', '', issetKey( $meta, 'being_an_advocate', '' ))
                     ->id('being-an-advocate')
                     ->hideLabel()
                     ->help(trans('global.user.fields.name_helper'))
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="label col-sm-4">
                     <div class="form-group">
                        <label>Client Signature</label>
                     </div>
                  </div>
                  <div class="label col-sm-8">
                     @if(isset($meta['client_signature_form']))
                     <img alt="client_signature_form" class="opform_signature" src="{{ $meta['client_signature_form'] }}" />
                     @else
                     @include('template.sign_pad', [ 'id' => 'client_signature_form', 'user_id'=>0, 'name'=>'meta[client_signature_form]', 'label' => '' ]) 
                     @endif
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-12 pl-0">
                     <div class="form-customs participent-two">
                        <div class="row">
                           <div class="label col-sm-4">
                              <div class="form-group">
                                 <label>{{trans('opforms.fields.date')}}</label>
                              </div>
                           </div>
                           <div class="label col-sm-8">
                              {!! 
                              Form::date('meta[client_signature_date]','' , old('client_signature_date', isset($meta['client_signature_date']) ? $meta['client_signature_date'] : date('d-m-Y')))
                              ->id('date-2')
                              // ->required('required')
                              ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Client signature date requried" ])
                              ->hideLabel()
                              ->help(trans('global.user.fields.name_helper'))
                              !!}
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="label col-sm-4">
                     <div class="form-group">
                        <label>Staff Manager Signature</label>
                     </div>
                  </div>
                  <div class="label col-sm-8">
                     @if(isset($meta['staff_manager_signature']))
                     <img alt="staff_manager_signature" src="{{ $meta['staff_manager_signature'] }}" />
                     @else
                     @include('template.sign_pad', [ 'id' => 'staff_manager_signature', 'user_id'=>0, 'name'=>'meta[staff_manager_signature]', 'label' => '' ]) 
                     @endif  
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-12 pl-0">
                     <div class="form-customs participent-two">
                        <div class="row">
                           <div class="label col-sm-4">
                              <div class="form-group">
                                 <label>{{ trans('opforms.fields.date')}}</label>
                              </div>
                           </div>
                           <div class="label col-sm-8">
                              {!! 
                              Form::date('meta[date2]','', old('date2', isset($meta['date2']) ? $meta['date2'] : date('d-m-Y')))
                              ->id('date-3')
                              // ->required('required')
                              ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Staff signature date requried" ])
                              ->hideLabel()
                              ->help(trans('global.user.fields.name_helper'))
                              !!}
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <br /><br />
            <div>
               {!! Form::submit(trans('global.save'))->attrs(["class"=>"btn btn-primary rounded"]) !!}
            </div>
         </form>
         {{-- two care plane forn end here--}}
      </div>
   </div>
</div>
@endsection