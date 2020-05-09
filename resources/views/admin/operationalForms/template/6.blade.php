@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-body">
      <div class="operational-form-design">
         {{-- 6th client-reffral form start here--}}
         <form action="{{ route($formAction[0],$formAction[1]) }}" method="POST" class="validated" enctype="multipart/form-data">
            @csrf
            @if(!empty($formAction[1]))
            @method('PUT')        
            @endif
            <div class="card-header">
               <h2>Client Referral Form</h2>
            </div>
            <input type="hidden" name="template_id" value="6">
            <input type="hidden" name="user_id" value='{{$participant->user_id}}'>
            <div class="row">
               <div class="col-sm-3">
                  <div class="form-group">
                     <div class="refral-colimn">
                        <label>Enquiry</label>
                     </div>
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <div class="refral-colimn">
                        <label>New Client</label>
                     </div>
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <div class="refral-colimn">
                        <label>Previous Client</label>
                     </div>
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <div class="refral-colimn">
                        <label>Existing Client</label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <h3>Client Information</h3>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{trans('opforms.fields.client_name')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('client_name',  '', old('full_name', $participant->getName() ))
                  ->id('client_name')
                  ->readonly($readOnly)
                  ->help(trans('global.user.fields.name_helper')) 
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{ trans('opforms.fields.address')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::location('meta[referral_address]', 
                  trans(''), 
                  valOrAlt( $meta, 'participant_address', $participant, 'address' ),
                  valOrAlt( $meta, 'participant_lat', $participant, 'lat' ),
                  valOrAlt( $meta, 'participant_lng', $participant, 'lng' ) 
                  )
                  ->id('referral_address')
                  ->locationLatName('meta[referral_lat]')
                  ->locationLngName('meta[referral_lng]')
                  ->required('required')
                  ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Address field required" ])
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{trans('opforms.fields.email')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('meta[email]', '', valOrAlt( $meta, 'email', $participant, 'email' ))
                  ->id('email')
                  ->attrs([
                  "data-rule-required"=>"true",
                  "data-rule-email"=>"true", 
                  "data-msg-required"=>trans('errors.register.email'),
                  "data-msg-email"=>trans('errors.register.email_format')
                  ])
                  ->help(trans('global.user.fields.name_helper')) 
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{trans('opforms.fields.phone')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('meta[phone]', '', valOrAlt( $meta, 'phone', $participant, 'phone' ))
                  ->id('phone')
                  ->attrs([
                  "required"=>"required",
                  "data-rule-required"=>"true",
                  "data-msg-required"=>"Please enter your mobile number",
                  "data-rule-minlength"=>"10",
                  "data-rule-number" => "true",
                  "data-msg-minlength"=>"Mobile number should be 10 digits minimum"
                  ])
                  ->help(trans('global.user.fields.name_helper')) 
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{trans('opforms.fields.date_of_birth')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::date('meta[dateofbirth]', '', old('dateofbirth', isset($meta['dateofbirth']) ? $meta['dateofbirth'] : date('d-m-Y')))
                  ->id('date-1')
                  ->required('required')
                  ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Date of birth required" ])
                  ->help(trans('lobal.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{trans('opforms.fields.present_situation')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('meta[present_situation]', '', issetKey( $meta, 'present_situation', '' ))
                  ->id('present_situation')
                  ->help(trans('global.user.fields.name_helper')) 
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{trans('opforms.fields.identified_needs')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('meta[identified_needs]', '', issetKey( $meta, 'identified_needs', '' ))
                  ->id('identified_needs')
                  ->help(trans('global.user.fields.name_helper')) 
                  !!}
               </div>
            </div>
            <div class="form-group">
               <h2>Referrer Information</h2>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{trans('opforms.fields.client_name')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('meta[client_referrer_name]', '', issetKey( $meta, 'client_referrer_name', '' ))
                  ->id('client_referrer_name')
                  ->help(trans('global.user.fields.name_helper')) 
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{trans('opforms.fields.position')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('meta[position]', '', issetKey( $meta, 'position', '' ))
                  ->id('position')
                  ->help(trans('global.user.fields.name_helper')) 
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{trans('opforms.fields.organization')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('meta[organisation]', '', issetKey( $meta, 'organisation', '' ))
                  ->id('organisation')
                  ->help(trans('global.user.fields.name_helper')) 
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{trans('opforms.fields.contact')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('meta[contact]', '', issetKey( $meta, 'contact', '' ))
                  ->id('contact')
                  ->help(trans('global.user.fields.name_helper')) 
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{trans('opforms.fields.reason')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::textarea('meta[reason]', '', issetKey( $meta, 'reason', '' ))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{trans('opforms.fields.notes')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::textarea('meta[notes]', '', issetKey( $meta, 'notes', '' ))
                  !!}
               </div>
            </div>
            {!! Form::submit('Submit')->attrs(["class"=>"rounded"]) !!}
         </form>
         {{-- 6th client-reffral form end here--}}
      </div>
   </div>
</div>
@endsection