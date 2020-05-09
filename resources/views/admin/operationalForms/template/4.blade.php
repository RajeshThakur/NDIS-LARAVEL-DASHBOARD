@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-body">
      <div class="operational-form-design">
         {{-- 4th client-exittransfoem-exit form start here--}}
         <form action="{{ route($formAction[0],$formAction[1]) }}" method="POST" class="validated" enctype="multipart/form-data">
            @csrf
            @if(!empty($formAction[1]))
            @method('PUT')        
            @endif
            <div class="card-header">
               <h2>Client Exit/Transition Form</h2>
            </div>
            <input type="hidden" name="template_id" value="4">
            <input type="hidden" name="user_id" value='{{$participant->user_id}}'>
            <div class="row">
               <div class="label col-sm-4">
                  <div class="form-group">
                     <label> {{trans('opforms.fields.client_full_name')}} </label>
                  </div>
               </div>
               <div class="label col-sm-8">
                  {!!
                  Form::text('full_name', '', old('full_name', $participant->getName() ))
                  ->id('full_name')
                  ->readonly($readOnly)
                  ->hideLabel()
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="label col-sm-4">
                  <div class="form-group">
                     <label>  {{trans('opforms.fields.commencement_service')}}</label>
                  </div>
               </div>
               <div class="label col-sm-8">
                  {!! 
                  Form::date('meta[commencement_service]', '', old('commencement_service', isset($meta['commencement_service']) ? $meta['commencement_service'] : date('d-m-Y')))
                  ->id('date-1')
                  // ->required('required')
                  ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Commencement service date required" ])
                  ->hideLabel()
                  ->help(trans('lobal.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="label col-sm-4">
                  <div class="form-group">
                     <label> {{trans('opforms.fields.commencement_exit')}}</label>
                  </div>
               </div>
               <div class="label col-sm-8">
                  {!! 
                  Form::date('meta[commencement_exit]', '', old('commencement_exit', isset($meta['commencement_exit']) ? $meta['commencement_exit'] : date('d-m-Y')))
                  ->id('date-2')
                  // ->required('required')
                  ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Commencement service exit date required" ])
                  ->hideLabel()
                  ->help(trans('lobal.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="label col-sm-4">
                  <div class="form-group">
                     <label> {{trans('opforms.fields.reason_end_service')}}</label>
                  </div>
               </div>
               <div class="label col-sm-8">
                  {!! 
                  Form::text('meta[reason_end_service]', '', issetKey( $meta, 'reason_end_service', '' ))
                  ->id('reason_end_service')
                  ->hideLabel()
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="label col-sm-4">
                  <div class="form-group">
                     <label> {{trans('opforms.fields.transition_goals')}}</label>
                  </div>
               </div>
               <div class="label col-sm-8">
                  {!! 
                  Form::text('meta[transition_goals]', '', issetKey( $meta, 'transition_goals', '' ))
                  ->id('transition_goals')
                  ->hideLabel()
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="label col-sm-4">
                  <div class="form-group">
                     <label>  {{trans('opforms.fields.client_need')}}</label>
                  </div>
               </div>
               <div class="label col-sm-8">
                  {!! 
                  Form::text('meta[client_need]', '', issetKey( $meta, 'client_need', '' ))
                  ->id('client_need')
                  ->hideLabel()
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="form-group">
                <h3>Client Exit / Transition Form</h3>
            </div>
           
            <div class="row">
               <div class="label col-sm-4">
                  <div class="form-group">
                     <label>  {{ trans('opforms.fields.item')}}</label>
                  </div>
               </div>
               <div class="label col-sm-8">
                  {!! 
                  Form::text('meta[item]','', issetKey( $meta, 'item', '' ))
                  ->id('item')
                  ->hideLabel()
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="label col-sm-4">
                  <div class="form-group">
                     <label>  {{ trans('opforms.fields.doctor')}}</label>
                  </div>
               </div>
               <div class="label col-sm-8">
                  {!! 
                  Form::text('meta[doctor]', '', issetKey( $meta, 'doctor', '' ))
                  ->id('doctor')
                  ->hideLabel()
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="label col-sm-4">
                  <div class="form-group">
                     <label>  {{ trans('opforms.fields.health_providers')}}</label>
                  </div>
               </div>
               <div class="label col-sm-8">
                  {!! 
                  Form::text('meta[health_providers]', '', issetKey( $meta, 'health_providers', '' ))
                  ->id('health_providers')
                  ->hideLabel()
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="label col-sm-4">
                  <div class="form-group">
                     <label>  {{  trans('opforms.fields.other_clubs')}}</label>
                  </div>
               </div>
               <div class="label col-sm-8">
                  {!! 
                  Form::text('meta[other_clubs]','', issetKey( $meta, 'other_clubs', '' ))
                  ->id('other_clubs')
                  ->hideLabel()
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="label col-sm-4">
                  <div class="form-group">
                     <label>  {{ trans('opforms.fields.relevant_staff')}}</label>
                  </div>
               </div>
               <div class="label col-sm-8">
                  {!! 
                  Form::text('meta[relevant_staff]', '', issetKey( $meta, 'relevant_staff', '' ))
                  ->id('relevant_staff')
                  ->hideLabel()
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="label col-sm-4">
                  <div class="form-group">
                     <label>  {{ trans('opforms.fields.administration')}}</label>
                  </div>
               </div>
               <div class="label col-sm-8">
                  {!! 
                  Form::text('meta[administration]','', issetKey( $meta, 'administration', '' ))
                  ->id('administration')
                  ->hideLabel()
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="label col-sm-4">
                  <div class="form-group">
                     <label>  {{  trans('opforms.fields.loan_retrieved')}}</label>
                  </div>
               </div>
               <div class="label col-sm-8">
                  {!! 
                  Form::text('meta[loan_retrieved]','', issetKey( $meta, 'loan_retrieved', '' ))
                  ->id('loan_retrieved')
                  ->hideLabel()
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="label col-sm-4">
                  <div class="form-group">
                     <label>  {{  trans('opforms.fields.filing_chart')}}</label>
                  </div>
               </div>
               <div class="label col-sm-8">
                  {!! 
                  Form::text('meta[filing_chart]', '', issetKey( $meta, 'filing_chart', '' ))
                  ->id('filing_chart')
                  ->hideLabel()
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="label col-sm-4">
                  <div class="form-group">
                     <label>  {{ trans('opforms.fields.client_office_archived')}}</label>
                  </div>
               </div>
               <div class="label col-sm-8">
                  {!! 
                  Form::text('meta[client_office_archived]', '', issetKey( $meta, 'client_office_archived', '' ))
                  ->id('client_office_archived')
                  ->hideLabel()
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="label col-sm-4">
                  <div class="form-group">
                     <label>  {{trans('opforms.fields.representative_signature')}}</label>
                  </div>
               </div>
               <div class="label col-sm-8">
                  {!! 
                  Form::text('meta[client_representative]', '', issetKey( $meta, 'client_representative', '' ))
                  ->id('client_representative')
                  ->hideLabel()
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="label col-sm-4">
                  <div class="form-group">
                     <label>  {{trans('opforms.fields.date')}}</label>
                  </div>
               </div>
               <div class="label col-sm-8">
                  {!! 
                  Form::date('meta[date]', '', old('date', isset($meta['date']) ? $meta['date'] : date('d-m-Y')))
                  ->id('date-3')
                  ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Date field required" ])
                  // ->required('required')
                  ->hideLabel()
                  ->help(trans('lobal.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="label col-sm-4">
                  <div class="form-group">
                     <label> Client Signature</label>
                  </div>
               </div>
               <div class="label col-sm-8">
                  @if(isset($meta['member_signature']))
                  <img alt="member_signature" src="{{ $meta['member_signature'] }}" />
                  @else
                  @include('template.sign_pad', [ 'id' => 'member_signature', 'user_id'=>0, 'name'=>'meta[member_signature]', 'label' => 'Client Signature' ]) 
                  @endif
               </div>
            </div>
            <div class="row">
               <div class="label col-sm-4">
                  <div class="form-group">
                     <label>  {{trans('opforms.fields.date')}}</label>
                  </div>
               </div>
               <div class="label col-sm-8">
                  {!! 
                  Form::date('meta[date3]', '', old('date3', isset($meta['date3']) ? $meta['date3'] : date('d-m-Y')))
                  ->id('date-4')
                  // ->required('required')
                  ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Member signature date required" ])
                  ->help(trans('lobal.user.fields.name_helper'))
                  !!}  
               </div>
            </div>
            <div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
               <label style="text-align:right;" for="Representative">Client Exit/Transition Form</label>
            </div>
            {!! Form::submit('Submit')->attrs(["class"=>"rounded"]) !!}
         </form>
         {{-- 4th client-exittransfoem-exit form end here--}}
      </div>
   </div>
</div>
@endsection