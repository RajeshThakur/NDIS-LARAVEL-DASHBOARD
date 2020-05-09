@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-body">
      <div class="operational-form-design custom-radio-input">
         {{-- fourth 9th PARTICIPANT Form start here--}} 
         <form action="{{ route($formAction[0],$formAction[1]) }}" method="POST" class="validated" enctype="multipart/form-data">
            @csrf
            @if(!empty($formAction[1]))
            @method('PUT')        
            @endif
            <div class="card-header">
               <h2> {!! trans('opforms.fields.participant_form') !!} </h2>
            </div>
            <input type="hidden" name="template_id" value="9">
            <input type="hidden" name="user_id" value='{{$participant->user_id}}'>
            <div class="form-group">
               <h3> {!! trans('opforms.fields.participant_registration') !!} </h3>
               {{-- 
               <h4> {!! trans('opforms.fields.participant_details') !!} </h4>
               --}}
            </div>
            <div class="form-group">
               {{-- 
               <h2> {!! trans('opforms.fields.participant_registration') !!} </h2>
               --}}
               <h4> {!! trans('opforms.fields.participant_details') !!} </h4>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{trans('opforms.fields.participant_title')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('participant_name', '', old('participant_name', $participant->getName() ) )
                  ->id('participant_title')
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{trans('opforms.fields.participant_family')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('meta[participant_family]', '', issetKey( $meta, 'participant_family', '' ) )
                  ->id('participant_family')
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{trans('opforms.fields.given_name')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('meta[participant_given_name]', '', issetKey( $meta, 'participant_given_name', '' ) )
                  ->id('participant_given_name')
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{trans('opforms.fields.preferred_name')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('meta[participant_preferred_name]', '', issetKey( $meta, 'participant_preferred_name', '' ) )
                  ->id('participant_preferred_name')
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{trans('opforms.fields.date_of_sign')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::date('meta[participant_date_of_birth]', '', old('participant_date_of_birth', isset($meta['participant_date_of_birth']) ? $meta['participant_date_of_birth'] : date('d-m-Y')))
                  ->id('date-1')
                  ->required('required')
                  ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Participant dob required" ])
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
               <label> {!! trans('opforms.fields.sex') !!} </label>
               <div class="form-check-custom">
                  <div class="form-check">
                     <input type="radio" name="meta[participant_gender]" value="male" class="form-check-input" {{ issetKey( $meta, 'participant_gender', '' ) == 'male' ? 'checked' : '' }} >
                     <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.male') !!}</label>
                     <input type="radio" name="meta[participant_gender]" value="female" class="form-check-input" class="form-check-input" {{ issetKey( $meta, 'participant_gender', '' ) == 'female' ? 'checked' : '' }} >
                     <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.female') !!}</label>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{trans('opforms.fields.address')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::location('meta[participant_address]', 
                  trans(''), 
                  valOrAlt( $meta, 'participant_address', $participant, 'address' ),
                  valOrAlt( $meta, 'participant_lat', $participant, 'lat' ),
                  valOrAlt( $meta, 'participant_lng', $participant, 'lng' )
                  )
                  ->id('participant_address')
                  ->locationLatName('meta[participant_lat]')
                  ->locationLngName('meta[participant_lng]')
                  ->required('required')
                  ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Participant address required" ])
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{trans('opforms.fields.street_name')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('meta[participant_street_name]', '', issetKey( $meta, 'participant_street_name', '' ) )
                  ->id('participant_street_name')
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{trans('opforms.fields.suburb')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('meta[participant_suburb]', '', issetKey( $meta, 'participant_suburb', '' ) )
                  ->id('participant_suburb')
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{trans('opforms.fields.state')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('meta[participant_state]', '', issetKey( $meta, 'participant_state', '' ) )
                  ->id('participant_state')
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{ trans('opforms.fields.postal')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('meta[participant_postal_code]','', issetKey( $meta, 'participant_postal_code', '' ) )
                  ->id('participant_postal_code')
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{ trans('opforms.fields.telephone')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('meta[participant_telephone_no]', '', issetKey( $meta, 'participant_telephone_no', '' ) )
                  ->id('participant_telephone_no')
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
                  <label>  {{ trans('opforms.fields.contact_mobile')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('meta[participant_mobile_no]', '', issetKey( $meta, 'participant_mobile_no', '' ) )
                  ->id('participant_mobile_no')
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
                  <label>  {{ trans('opforms.fields.language')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('meta[participant_language_spoken]', '', issetKey( $meta, 'participant_language_spoken', '' ) )
                  ->id('participant_language_spoken')
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="ndis-detail">
               <h4>{!! trans('opforms.fields.ndis_detail') !!}</h4>
               <div class="row">
                  <div class="col-sm-4">
                     <label>  {{  trans('opforms.fields.ndis_no')}}</label>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::text('meta[participant_ndis_no]','', issetKey( $meta, 'participant_ndis_no', '' ) )
                     ->id('participant_ndis_no')
                     ->help(trans('global.user.fields.name_helper'))
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-4">
                     <label>  {{ trans('opforms.fields.ndis_start')}}</label>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::date('meta[participant_ndis_start_date]', '', old('participant_ndis_start_date', isset($meta['participant_ndis_start_date']) ? $meta['participant_date_of_birth'] : date('d-m-Y')))
                     ->id('date-2')
                     ->required('required')
                     ->help(trans('lobal.user.fields.name_helper'))
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-4">
                     <label>  {{ trans('opforms.fields.ndis_end')}}</label>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::date('meta[participant_ndis_end_date]', '', old('participant_ndis_end_date', isset($meta['participant_ndis_end_date']) ? $meta['participant_date_of_birth'] : date('d-m-Y')))
                     ->id('date-3')
                     ->required('required')
                     ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Participant ndis end date required" ])
                     ->help(trans('lobal.user.fields.name_helper'))
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-4">
                     <div class="form-group ">
                        <label> {!! trans('opforms.fields.ndis_another') !!} </label>
                        <input type="radio" name="meta[registered_another_ndis]" value="yes" class="form-check-input" {{ issetKey( $meta, 'registered_another_ndis', '' ) == 'yes' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.yes') !!}</label>
                        <input type="radio" name="meta[registered_another_ndis]" value="no" class="form-check-input" {{ issetKey( $meta, 'registered_another_ndis', '' ) == 'no' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.no') !!}</label>
                        <label>{!! trans('opforms.fields.if_registered') !!}</label>
                     </div>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::text('meta[participant_another_ndis_service]', '' , issetKey( $meta, 'participant_another_ndis_service', '' ) )
                     ->id('participant_another_ndis_service')
                     ->help(trans('global.user.fields.name_helper'))
                     !!}
                  </div>
               </div>
               <div class="ndis-family">
                  <h4>{!! trans('opforms.fields.family_detail') !!}</h4>
                  <label>{!! trans('opforms.fields.line_detail_family1') !!}</label>
                  <label>{!! trans('opforms.fields.line_detail_family2') !!}</label>
               </div>
               <div class="row">
                  <div class="col-sm-4">
                     <label>  {{ trans('opforms.fields.family_1')}}</label>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::text('meta[participant_family_member_1]','', issetKey( $meta, 'participant_family_member_1', '' ) )
                     ->id('participant_family_member_1')
                     ->help(trans('global.user.fields.name_helper'))
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-4">
                     <label>  {{ trans('opforms.fields.family_2')}}</label>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::text('meta[participant_family_member_2]','', issetKey( $meta, 'participant_family_member_2', '' ) )
                     ->id('participant_family_member_2')
                     ->help(trans('global.user.fields.name_helper'))
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-4">
                     <label>  {{trans('opforms.fields.family_3')}}</label>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::text('meta[participant_family_member_3]', '', issetKey( $meta, 'participant_family_member_3', '' ) )
                     ->id('participant_family_member_3')
                     ->help(trans('global.user.fields.name_helper'))
                     !!}
                  </div>
               </div>
            </div>
            <div class="primary-address">
               <label for="PRIMARY"> {!! trans('opforms.fields.primary_mailing_address') !!}</label>
               <div class="row">
                  <div class="col-sm-4">
                     <label>  {{trans('opforms.fields.family_address')}}</label>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::text('meta[participant_family_mailing_address]', '', issetKey( $meta, 'participant_family_mailing_address', '' ) )
                     ->id('participant_family_mailing_address')
                     ->help(trans('global.user.fields.name_helper'))
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-4">
                     <label>  {{trans('opforms.fields.street_name')}}</label>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::text('meta[participant_family_mailing_street]', '', issetKey( $meta, 'participant_family_mailing_street', '' ) )
                     ->id('participant_family_mailing_street')
                     ->help(trans('global.user.fields.name_helper'))
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-4">
                     <label>  {{trans('opforms.fields.state')}}</label>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::text('meta[participant_family_mailing_state]', '', issetKey( $meta, 'participant_family_mailing_state', '' ) )
                     ->id('participant_family_mailing_state')
                     ->help(trans('global.user.fields.name_helper'))
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-4">
                     <label>  {{trans('opforms.fields.postal')}}</label>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::text('meta[participant_family_mailing_postal]', '', issetKey( $meta, 'participant_family_mailing_postal', '' ) )
                     ->id('participant_family_mailing_postal')
                     ->help(trans('global.user.fields.name_helper'))
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-4">
                     <label>  {{ trans('opforms.fields.telephone')}}</label>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::text('meta[participant_family_mailing_telephone]','', issetKey( $meta, 'participant_family_mailing_telephone', '' ) )
                     ->id('participant_family_mailing_telephone')
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
                     <label>  {{trans('opforms.fields.contact_mobile')}}</label>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::text('meta[participant_family_mailing_mobile]', '', issetKey( $meta, 'participant_family_mailing_mobile', '' ))
                     ->id('participant_family_mailing_mobile')
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
               <div class="row column-two-form">
                  <div class="col-sm-6">
                     <div class="Carer-Participant participent-one">
                        <div class="form-group">
                           <h4> {!! trans('opforms.fields.adult_a_detail') !!} </h4>
                        </div>
                        <div class="form-group ">
                           <label>{!! trans('opforms.fields.sex') !!}</label>
                           <div class="form-check-custom">
                              <div class="form-check">
                                 <input type="radio" name="meta[adult_a_gender]" value="male" class="form-check-input" {{ issetKey( $meta, 'adult_a_gender', '' ) == 'male' ? 'checked' : '' }} >
                                 <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.male') !!}</label>
                                 <input type="radio" name="meta[adult_a_gender]" value="female" class="form-check-input" {{ issetKey( $meta, 'adult_a_gender', '' ) == 'female' ? 'checked' : '' }} >
                                 <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.female') !!}</label>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-4">
                              <label>  {{trans('opforms.fields.participant_title')}}</label>
                           </div>
                           <div class="col-sm-8">
                              {!! 
                              Form::text('meta[participant_adult_a_title]', '', issetKey( $meta, 'participant_adult_a_title', '' ) )
                              ->id('participant_adult_a_title')
                              ->help(trans('global.user.fields.name_helper'))
                              !!}
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-4">
                              <label>  {{trans('opforms.fields.adult_a_surname')}}</label>
                           </div>
                           <div class="col-sm-8">
                              {!! 
                              Form::text('meta[participant_adult_a_surname]', '', issetKey( $meta, 'participant_adult_a_surname', '' ) )
                              ->id('participant_adult_a_surname')
                              ->help(trans('global.user.fields.name_helper'))
                              !!}
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-4">
                              <label>  {{trans('opforms.fields.adult_a_first_name')}}</label>
                           </div>
                           <div class="col-sm-8">
                              {!! 
                              Form::text('meta[participant_adult_a_first_name]', '', issetKey( $meta, 'participant_adult_a_first_name', '' ) )
                              ->id('participant_adult_a_first_name')
                              ->help(trans('global.user.fields.name_helper'))
                              !!}
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-4">
                              <label>  {{trans('opforms.fields.adult_a_occupation')}}</label>
                           </div>
                           <div class="col-sm-8">
                              {!! 
                              Form::text('meta[participant_adult_a_occupation]', '', issetKey( $meta, 'participant_adult_a_occupation', '' ) )
                              ->id('participant_adult_a_occupation')
                              ->help(trans('global.user.fields.name_helper'))
                              !!}
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-4">
                              <label>  {{trans('opforms.fields.adult_a_employer')}}</label>
                           </div>
                           <div class="col-sm-8">
                              {!! 
                              Form::text('meta[participant_adult_a_employer]', '', issetKey( $meta, 'participant_adult_a_employer', '' ) )
                              ->id('participant_adult_a_employer')
                              ->help(trans('global.user.fields.name_helper'))
                              !!}
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-4">
                              <label>  {{trans('opforms.fields.adult_a_born')}}</label>
                           </div>
                           <div class="col-sm-8">
                              {!! 
                              Form::text('meta[participant_adult_a_born]', '', issetKey( $meta, 'participant_adult_a_born', '' ) )
                              ->id('participant_adult_a_born')
                              ->help(trans('global.user.fields.name_helper'))
                              !!}
                           </div>
                        </div>
                        <div class="below-form">
                           <div class="form-group {{ $errors->has('employer') ? 'has-error' : '' }}">
                              <ul>
                                 <li><label for="employer"> {!! trans('opforms.fields.adult_a_does_speak_en') !!} </label>
                                 </li>
                              </ul>
                              <div class="form-check-custom">
                                 <div class="form-check">
                                    <input type="radio" name="meta[adult_a_speak_lang]" value="No_English_Only" class="form-check-input" {{ issetKey( $meta, 'adult_a_speak_lang', '' ) == 'No_English_Only' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.speak_english_only') !!}</label>
                                    <input type="radio" name="meta[adult_a_speak_lang]" value="yes_other" class="form-check-input" {{ issetKey( $meta, 'yes_other', '' ) == 'No_English_Only' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.no_speak_enlish') !!}</label>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-4">
                                 <label>  {{trans('opforms.fields.adult_a_additional_lang')}}</label>
                              </div>
                              <div class="col-sm-8">
                                 {!! 
                                 Form::text('meta[participant_adult_a_additional_lang]', '', issetKey( $meta, 'participant_adult_a_additional_lang', '' ))
                                 ->id('participant_adult_a_additional_lang')
                                 ->help(trans('global.user.fields.name_helper'))
                                 !!}
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-4">
                                 <label>  {{trans('opforms.fields.adult_a_spoken_lang')}}</label>
                              </div>
                              <div class="col-sm-8">
                                 {!! 
                                 Form::text('meta[participant_adult_a_spoken_lang]', '', issetKey( $meta, 'participant_adult_a_spoken_lang', '' ) )
                                 ->id('participant_adult_a_spoken_lang')
                                 ->help(trans('global.user.fields.name_helper'))
                                 !!}
                              </div>
                           </div>
                           <div class="form-group {{ $errors->has('employer') ? 'has-error' : '' }}">
                              <label for="employer"> {!! trans('opforms.fields.line_for_interpreter') !!} </label>
                              <div class="form-check-custom">
                                 <div class="form-check">
                                    <input type="radio" name="meta[is_interpreter_required_a]" value="yes" class="form-check-input" {{ issetKey( $meta, 'is_interpreter_required_a', '' ) == 'yes' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.yes') !!}</label>
                                    <input type="radio" name="meta[is_interpreter_required_a]" value="no" class="form-check-input" {{ issetKey( $meta, 'is_interpreter_required_a', '' ) == 'no' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.no') !!}</label>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group {{ $errors->has('employer') ? 'has-error' : '' }}">
                              <ul>
                                 <li><label>{!! trans('opforms.fields.adult_a_primary_school') !!}</label>
                                 </li>
                                 <div class="form-check-custom">
                                    <div class="form-check">
                                       <input type="radio" name="meta[adult_a_passed_school]" value="Year_12_or_equivalent" class="form-check-input" {{ issetKey( $meta, 'adult_a_passed_school', '' ) == 'Year_12_or_equivalent' ? 'checked' : '' }} >
                                       <label class="form-check-label" for="exampleCheck1"> {!! trans('opforms.fields.adult_a_school_12') !!} </label>
                                    </div>
                                 </div>
                                 <div class="form-check-custom">
                                    <div class="form-check">
                                       <input type="radio" name="meta[adult_a_passed_school]" value="Year_11_or_equivalent" class="form-check-input" {{ issetKey( $meta, 'adult_a_passed_school', '' ) == 'Year_11_or_equivalent' ? 'checked' : '' }} >
                                       <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.adult_a_school_11') !!} </label>
                                    </div>
                                 </div>
                                 <div class="form-check-custom">
                                    <div class="form-check">
                                       <input type="radio" name="meta[adult_a_passed_school]" value="Year_10_or_equivalent" class="form-check-input" {{ issetKey( $meta, 'adult_a_passed_school', '' ) == 'Year_10_or_equivalent' ? 'checked' : '' }} >
                                       <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.adult_a_school_10') !!} </label>
                                    </div>
                                 </div>
                                 <div class="form-check-custom">
                                    <div class="form-check">
                                       <input type="radio" name="meta[adult_a_passed_school]" value="Year_9_or_equivalent" class="form-check-input" {{ issetKey( $meta, 'adult_a_passed_school', '' ) == 'Year_9_or_equivalent' ? 'checked' : '' }} >
                                       <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.adult_a_school_9') !!} </label>
                                    </div>
                                 </div>
                              </ul>
                           </div>
                           <div class="form-group {{ $errors->has('employer') ? 'has-error' : '' }}">
                              <ul>
                                 <li><label>{!! trans('opforms.fields.adult_a_qualification') !!}</label></li>
                                 <div class="form-check-custom">
                                    <div class="form-check">
                                       <input type="radio" name="meta[adult_a_qualification]" value="Bachelor_degree_or_above" class="form-check-input" {{ issetKey( $meta, 'adult_a_qualification', '' ) == 'Bachelor_degree_or_above' ? 'checked' : '' }} >
                                       <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.adult_a_bechelor') !!}</label>
                                    </div>
                                 </div>
                                 <div class="form-check-custom">
                                    <div class="form-check">
                                       <input type="radio" name="meta[adult_a_qualification]" value="Advanced_diploma_I_Diploma" class="form-check-input" {{ issetKey( $meta, 'adult_a_qualification', '' ) == 'Advanced_diploma_I_Diploma' ? 'checked' : '' }} >
                                       <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.adult_a_advanced') !!}</label>
                                    </div>
                                 </div>
                                 <div class="form-check-custom">
                                    <div class="form-check">
                                       <input type="radio" name="meta[adult_a_qualification]" value="Certificate_I_to_IV" class="form-check-input" {{ issetKey( $meta, 'adult_a_qualification', '' ) == 'Certificate_I_to_IV' ? 'checked' : '' }} >
                                       <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.adult_a_certified') !!}</label>
                                    </div>
                                 </div>
                                 <div class="form-check-custom">
                                    <div class="form-check">
                                       <input type="radio" name="meta[adult_a_qualification]" value="No_non_school_qualification" class="form-check-input" {{ issetKey( $meta, 'adult_a_qualification', '' ) == 'No_non_school_qualification' ? 'checked' : '' }} >
                                       <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.adult_a_no_school') !!}</label>
                                    </div>
                                 </div>
                              </ul>
                           </div>
                           <div class="form-group {{ $errors->has('employer') ? 'has-error' : '' }}">
                              <ul>
                                 <li><label>{!! trans('opforms.fields.adult_a_occupation_line1') !!}</label></li>
                                 <li><label>{!! trans('opforms.fields.adult_a_occupation_line2') !!}</label>
                                 </li>
                                 <li><label>{!! trans('opforms.fields.adult_a_occupation_line3') !!}</label></li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="Carer-Participant participent-one">
                        <div class="form-group">
                           <h4> {!! trans('opforms.fields.adult_b_detail') !!} </h4>
                        </div>
                        <div class="form-group ">
                           <label>{!! trans('opforms.fields.sex') !!}</label>
                           <div class="form-check-custom">
                              <div class="form-check">
                                 <input type="radio" name="meta[adult_b_gender]" value="male" class="form-check-input" {{ issetKey( $meta, 'adult_b_gender', '' ) == 'male' ? 'checked' : '' }} >
                                 <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.male') !!}</label>
                                 <input type="radio" name="meta[adult_b_gender]" value="female" class="form-check-input" {{ issetKey( $meta, 'adult_b_gender', '' ) == 'female' ? 'checked' : '' }} >
                                 <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.female') !!}</label>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-4">
                              <label>  {{trans('opforms.fields.participant_title')}}</label>
                           </div>
                           <div class="col-sm-8">
                              {!! 
                              Form::text('meta[participant_adult_b_title]', '', issetKey( $meta, 'participant_adult_b_title', '' ))
                              ->id('participant_adult_a_title')
                              ->help(trans('global.user.fields.name_helper'))
                              !!}
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-4">
                              <label>  {{ trans('opforms.fields.adult_b_surname')}}</label>
                           </div>
                           <div class="col-sm-8">
                              {!! 
                              Form::text('meta[participant_adult_b_surname]','', issetKey( $meta, 'participant_adult_b_surname', '' ))
                              ->id('participant_adult_b_surname')
                              ->help(trans('global.user.fields.name_helper'))
                              !!}
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-4">
                              <label>  {{ trans('opforms.fields.adult_b_first_name')}}</label>
                           </div>
                           <div class="col-sm-8">
                              {!! 
                              Form::text('meta[participant_adult_b_first_name]', '', issetKey( $meta, 'participant_adult_b_first_name', '' ))
                              ->id('participant_adult_b_first_name')
                              ->help(trans('global.user.fields.name_helper'))
                              !!}
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-4">
                              <label>  {{ trans('opforms.fields.adult_b_occupation')}}</label>
                           </div>
                           <div class="col-sm-8">
                              {!! 
                              Form::text('meta[participant_adult_b_occupation]', '', issetKey( $meta, 'participant_adult_b_occupation', '' ))
                              ->id('participant_adult_b_occupation')
                              ->help(trans('global.user.fields.name_helper'))
                              !!}
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-4">
                              <label>  {{trans('opforms.fields.adult_b_employer')}}</label>
                           </div>
                           <div class="col-sm-8">
                              {!! 
                              Form::text('meta[participant_adult_b_employer]', '', issetKey( $meta, 'participant_adult_b_employer', '' ))
                              ->id('participant_adult_b_employer')
                              ->help(trans('global.user.fields.name_helper'))
                              !!}
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-4">
                              <label>  {{trans('opforms.fields.adult_b_born')}}</label>
                           </div>
                           <div class="col-sm-8">
                              {!! 
                              Form::text('meta[participant_adult_b_born]', '', issetKey( $meta, 'participant_adult_b_born', '' ))
                              ->id('participant_adult_b_born')
                              ->help(trans('global.user.fields.name_helper'))
                              !!}
                           </div>
                        </div>
                        <div class="below-form">
                           <div class="form-group {{ $errors->has('employer') ? 'has-error' : '' }}">
                              <ul>
                                 <li><label for="employer"> {!! trans('opforms.fields.adult_b_does_speak_en') !!} </label>
                                 </li>
                              </ul>
                              <div class="form-check-custom">
                                 <div class="form-check">
                                    <input type="radio" name="meta[adult_b_speak_lang]" value="No_English_Only" class="form-check-input" {{ issetKey( $meta, 'No_English_Only', '' ) == 'female' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.speak_english_only') !!}</label>
                                    <input type="radio" name="meta[adult_b_speak_lang]" value="yes_other" class="form-check-input" {{ issetKey( $meta, 'adult_b_speak_lang', '' ) == 'yes_other' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.no_speak_enlish') !!}</label>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-4">
                                 <label>  {{trans('opforms.fields.adult_b_additional_lang')}}</label>
                              </div>
                              <div class="col-sm-8">
                                 {!! 
                                 Form::text('meta[participant_adult_b_additional_lang]', '', issetKey( $meta, 'participant_adult_b_additional_lang', '' ))
                                 ->id('participant_adult_b_additional_lang')
                                 ->help(trans('global.user.fields.name_helper'))
                                 !!}
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-4">
                                 <label>  {{trans('opforms.fields.adult_b_spoken_lang')}}</label>
                              </div>
                              <div class="col-sm-8">
                                 {!! 
                                 Form::text('meta[participant_adult_b_spoken_lang]', '', issetKey( $meta, 'participant_adult_b_spoken_lang', '' ))
                                 ->id('participant_adult_b_spoken_lang')
                                 ->help(trans('global.user.fields.name_helper'))
                                 !!}
                              </div>
                           </div>
                           <div class="form-group {{ $errors->has('employer') ? 'has-error' : '' }}">
                              <label for="employer"> {!! trans('opforms.fields.line_for_interpreter') !!} </label>
                              <div class="form-check-custom">
                                 <div class="form-check">
                                    <input type="radio" name="meta[is_interpreter_required_b]" value="yes" class="form-check-input" {{ issetKey( $meta, 'is_interpreter_required_b', '' ) == 'yes' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.yes') !!}</label>
                                    <input type="radio" name="meta[is_interpreter_required_b]" value="no" class="form-check-input" {{ issetKey( $meta, 'is_interpreter_required_b', '' ) == 'no' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.no') !!}</label>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group {{ $errors->has('employer') ? 'has-error' : '' }}">
                              <ul>
                                 <li><label>{!! trans('opforms.fields.adult_b_primary_school') !!}</label>
                                 </li>
                                 <div class="form-check-custom">
                                    <div class="form-check">
                                       <input type="radio" name="meta[adult_b_passed_school]" value="Year_12_or_equivalent" class="form-check-input" {{ issetKey( $meta, 'adult_b_passed_school', '' ) == 'Year_12_or_equivalent' ? 'checked' : '' }} >
                                       <label class="form-check-label" for="exampleCheck1"> {!! trans('opforms.fields.adult_b_school_12') !!} </label>
                                    </div>
                                 </div>
                                 <div class="form-check-custom">
                                    <div class="form-check">
                                       <input type="radio" name="meta[adult_b_passed_school]" value="Year_11_or_equivalent" class="form-check-input" {{ issetKey( $meta, 'adult_b_passed_school', '' ) == 'Year_11_or_equivalent' ? 'checked' : '' }}>
                                       <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.adult_b_school_11') !!} </label>
                                    </div>
                                 </div>
                                 <div class="form-check-custom">
                                    <div class="form-check">
                                       <input type="radio" name="meta[adult_b_passed_school]" value="Year_10_or_equivalent" class="form-check-input" {{ issetKey( $meta, 'adult_b_passed_school', '' ) == 'Year_10_or_equivalent' ? 'checked' : '' }} >
                                       <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.adult_b_school_10') !!} </label>
                                    </div>
                                 </div>
                                 <div class="form-check-custom">
                                    <div class="form-check">
                                       <input type="radio" name="meta[adult_b_passed_school]" value="Year_9_or_equivalent" class="form-check-input" {{ issetKey( $meta, 'adult_b_passed_school', '' ) == 'Year_9_or_equivalent' ? 'checked' : '' }} >
                                       <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.adult_b_school_9') !!} </label>
                                    </div>
                                 </div>
                              </ul>
                           </div>
                           <div class="form-group {{ $errors->has('employer') ? 'has-error' : '' }}">
                              <ul>
                                 <li><label>{!! trans('opforms.fields.adult_b_qualification') !!}</label></li>
                                 <div class="form-check-custom">
                                    <div class="form-check">
                                       <input type="radio" name="meta[adult_b_qualification]" value="Bachelor_degree_or_above" class="form-check-input" {{ issetKey( $meta, 'adult_b_qualification', '' ) == 'Bachelor_degree_or_above' ? 'checked' : '' }} >
                                       <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.adult_b_bechelor') !!}</label>
                                    </div>
                                 </div>
                                 <div class="form-check-custom">
                                    <div class="form-check">
                                       <input type="radio" name="meta[adult_b_qualification]" value="Advanced_diploma_I_Diploma" class="form-check-input" {{ issetKey( $meta, 'adult_b_qualification', '' ) == 'Advanced_diploma_I_Diploma' ? 'checked' : '' }} >
                                       <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.adult_b_advanced') !!}</label>
                                    </div>
                                 </div>
                                 <div class="form-check-custom">
                                    <div class="form-check">
                                       <input type="radio" name="meta[adult_b_qualification]" value="Certificate_I_to_IV" class="form-check-input" {{ issetKey( $meta, 'adult_b_qualification', '' ) == 'Certificate_I_to_IV' ? 'checked' : '' }} >
                                       <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.adult_b_certified') !!}</label>
                                    </div>
                                 </div>
                                 <div class="form-check-custom">
                                    <div class="form-check">
                                       <input type="radio" name="meta[adult_b_qualification]" value="No_non_school" class="form-check-input" {{ issetKey( $meta, 'adult_b_qualification', '' ) == 'No_non_school' ? 'checked' : '' }} >
                                       <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.adult_b_no_school') !!}</label>
                                    </div>
                                 </div>
                              </ul>
                           </div>
                           <div class="form-group {{ $errors->has('employer') ? 'has-error' : '' }}">
                              <ul>
                                 <li><label>{!! trans('opforms.fields.adult_b_occupation_line1') !!}</label></li>
                                 <li><label>{!! trans('opforms.fields.adult_b_occupation_line2') !!}</label>
                                 </li>
                                 <li><label>{!! trans('opforms.fields.adult_b_occupation_line3') !!}</label></li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="adults-contact">
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="participent-one adult-content-form">
                           <div class="form-group {{ $errors->has('Language') ? 'has-error' : '' }}">
                              <h3>{!! trans('opforms.fields.line_a_primary_1') !!}</h3>
                              <label for="contact">{!! trans('opforms.fields.line_a_primary_2') !!}</label>
                              <label for="contact">{!! trans('opforms.fields.line_a_primary_3') !!}</label>
                           </div>
                           <div class="form-group ">
                              <label for="employer">{!! trans('opforms.fields.line_a_primary_4') !!}</label>
                              <div class="form-check-custom">
                                 <div class="form-check">
                                    <input type="radio" name="meta[contact_a_business_hours]" value="yes" class="form-check-input" {{ issetKey( $meta, 'contact_a_business_hours', '' ) == 'yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.yes') !!}</label>
                                    <input type="radio" name="meta[contact_a_business_hours]" value="no" class="form-check-input" {{ issetKey( $meta, 'contact_a_business_hours', '' ) == 'no' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.no') !!}</label>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group ">
                              <label for="employer">{!! trans('opforms.fields.line_a_primary_5') !!}</label>
                              <div class="form-check-custom">
                                 <div class="form-check">
                                    <input type="radio" name="meta[contact_a_home_business_hours]" value="yes" class="form-check-input" {{ issetKey( $meta, 'contact_a_home_business_hours', '' ) == 'yes' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.yes') !!}</label>
                                    <input type="radio" name="meta[contact_a_home_business_hours]" value="no" class="form-check-input" {{ issetKey( $meta, 'contact_a_home_business_hours', '' ) == 'no' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.no') !!}</label>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-4">
                                 <label>  {{trans('opforms.fields.work_telephone')}}</label>
                              </div>
                              <div class="col-sm-8">
                                 {!! 
                                 Form::text('meta[participant_adult_contact_a_work_telephone]', '', issetKey( $meta, 'participant_adult_contact_a_work_telephone', '' ))
                                 ->id('participant_adult_contact_a_work_telephone')
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
                                 <label>  {{ trans('opforms.fields.other_telephone')}}</label>
                              </div>
                              <div class="col-sm-8">
                                 {!! 
                                 Form::text('meta[participant_adult_contact_a_work_other_contact]','', issetKey( $meta, 'participant_adult_contact_a_work_other_contact', '' ))
                                 ->id('participant_adult_contact_a_work_other_contact')
                                 ->help(trans('global.user.fields.name_helper'))
                                 !!}
                              </div>
                           </div>
                           <div class="form-group ">
                              <label for="employer">{!! trans('opforms.fields.line_a_primary_6') !!}</label>
                              <div class="form-check-custom">
                                 <div class="form-check">
                                    <input type="radio" name="meta[is_contact_a_home_after_business]" value="yes" class="form-check-input" {{ issetKey( $meta, 'is_contact_a_home_after_business', '' ) == 'yes' ? 'checked' : '' }} >
                                    <label class="form-check-label"  for="exampleCheck1">{!! trans('opforms.fields.yes') !!}</label>
                                    <input type="radio" name="meta[is_contact_a_home_after_business]" value="no" class="form-check-input" {{ issetKey( $meta, 'is_contact_a_home_after_business', '' ) == 'no' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.no') !!}</label>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-4">
                                 <label>  {{ trans('opforms.fields.home_telephone')}}</label>
                              </div>
                              <div class="col-sm-8">
                                 {!! 
                                 Form::text('meta[participant_adult_contact_a_home_telephone]', '', issetKey( $meta, 'participant_adult_contact_a_home_telephone', '' ))
                                 ->id('participant_adult_contact_a_home_telephone')
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
                                 <label>  {{  trans('opforms.fields.after_work_contact')}}</label>
                              </div>
                              <div class="col-sm-8">
                                 {!! 
                                 Form::text('meta[participant_adult_contact_a_after_work_contact]','', issetKey( $meta, 'participant_adult_contact_a_after_work_contact', '' ))
                                 ->id('participant_adult_contact_a_after_work_contact')
                                 ->help(trans('global.user.fields.name_helper'))
                                 !!}
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-4">
                                 <label>  {{trans('opforms.fields.contact_mobile')}}</label>
                              </div>
                              <div class="col-sm-8">
                                 {!! 
                                 Form::text('meta[participant_adult_contact_a_mobile]', '', issetKey( $meta, 'participant_adult_contact_a_mobile', '' ))
                                 ->id('participant_adult_contact_a_mobile')
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
                           <div class="form-group ">
                              <label for="employer">{!! trans('opforms.fields.sms') !!}</label>
                              <div class="form-check-custom">
                                 <div class="form-check">
                                    <input type="radio" name="meta[contact_a_sms_notification]" value="yes" class="form-check-input" {{ issetKey( $meta, 'contact_a_sms_notification', '' ) == 'yes' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="exampleCheck1">Yes</label>
                                    <input type="radio" name="meta[contact_a_sms_notification]" value="no" class="form-check-input" {{ issetKey( $meta, 'contact_a_sms_notification', '' ) == 'no' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="exampleCheck1">No</label>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group ">
                              <label for="employer">{!! trans('opforms.fields.line_a_primary_7') !!}</label>
                              <div class="form-check-custom">
                                 <div class="form-check">
                                    <input type="radio" name="meta[meta[conact_a_prefered_contact_method]]" value="email" class="form-check-input" {{ issetKey( $meta, 'conact_a_prefered_contact_method', '' ) == 'email' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.email') !!}</label>
                                    <input type="radio" name="meta[conact_a_prefered_contact_method]" value="phone" class="form-check-input" {{ issetKey( $meta, 'conact_a_prefered_contact_method', '' ) == 'phone' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.phone') !!}</label>
                                    <input type="radio" name="meta[conact_a_prefered_contact_method]" value="facsimile" class="form-check-input" {{ issetKey( $meta, 'conact_a_prefered_contact_method', '' ) == 'facsimile' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.facsimile') !!}</label>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-4">
                                 <label>  {{ trans('opforms.fields.email')}}</label>
                              </div>
                              <div class="col-sm-8">
                                 {!! 
                                 Form::text('meta[participant_adult_contact_a_email]','', issetKey( $meta, 'participant_adult_contact_a_email', '' ))
                                 ->id('participant_adult_contact_a_email')
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
                           <div class="form-group ">
                              <label for="employer">{!! trans('opforms.fields.sms') !!}</label>
                              <div class="form-check-custom">
                                 <div class="form-check">
                                    <input type="radio" name="meta[conact_a_prefered_sms_notification]" value="yes" class="form-check-input" {{ issetKey( $meta, 'conact_a_prefered_sms_notification', '' ) == 'yes' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.yes') !!}</label>
                                    <input type="radio" name="meta[conact_a_prefered_sms_notification]" value="no" class="form-check-input" {{ issetKey( $meta, 'conact_a_prefered_sms_notification', '' ) == 'no' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.no') !!}</label>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-4">
                                 <label>  {{ trans('opforms.fields.fax')}}</label>
                              </div>
                              <div class="col-sm-8">
                                 {!! 
                                 Form::text('meta[participant_adult_contact_a_fax]', '', issetKey( $meta, 'participant_adult_contact_a_fax', '' ))
                                 ->id('participant_adult_contact_a_fax')
                                 ->help(trans('global.user.fields.name_helper'))
                                 !!}
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-4">
                                 <label>  {{trans('opforms.fields.after_hours')}}</label>
                              </div>
                              <div class="col-sm-8">
                                 {!! 
                                 Form::text('meta[participant_adult_contact_a_after_hours]', '', issetKey( $meta, 'participant_adult_contact_a_after_hours', '' ))
                                 ->id('participant_adult_contact_a_after_hours')
                                 ->help(trans('global.user.fields.name_helper'))
                                 !!}
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="participent-one adult-content-form">
                           <div class="form-group {{ $errors->has('Language') ? 'has-error' : '' }}">
                              <h3>{!! trans('opforms.fields.line_a_primary_1') !!}</h3>
                              <label for="contact">{!! trans('opforms.fields.line_b_primary_2') !!}</label>
                              <label for="contact">{!! trans('opforms.fields.line_b_primary_3') !!}</label>
                           </div>
                           <div class="form-group ">
                              <label for="employer">{!! trans('opforms.fields.line_b_primary_4') !!}</label>
                              <div class="form-check-custom">
                                 <div class="form-check">
                                    <input type="radio" name="meta[contact_b_business_hours]" value="yes" class="form-check-input" {{ issetKey( $meta, 'contact_b_business_hours', '' ) == 'yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.yes') !!}</label>
                                    <input type="radio" name="meta[contact_b_business_hours]" value="no" class="form-check-input" {{ issetKey( $meta, 'contact_b_business_hours', '' ) == 'no' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.no') !!}</label>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group ">
                              <label for="employer">{!! trans('opforms.fields.line_b_primary_5') !!}</label>
                              <div class="form-check-custom">
                                 <div class="form-check">
                                    <input type="radio" name="meta[contact_b_home_business_hours]" value="yes" class="form-check-input" {{ issetKey( $meta, 'contact_b_home_business_hours', '' ) == 'yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.yes') !!}</label> 
                                    <input type="radio" name="meta[contact_b_home_business_hours]" value="no" class="form-check-input" {{ issetKey( $meta, 'contact_b_home_business_hours', '' ) == 'no' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.no') !!}</label>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-4">
                                 <label>  {{trans('opforms.fields.work_telephone')}}</label>
                              </div>
                              <div class="col-sm-8">
                                 {!! 
                                 Form::text('meta[participant_adult_contact_b_work_telephone]', '', issetKey( $meta, 'participant_adult_contact_b_work_telephone', '' ))
                                 ->id('participant_adult_contact_b_work_telephone')
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
                                 <label>  {{ trans('opforms.fields.other_telephone')}}</label>
                              </div>
                              <div class="col-sm-8">
                                 {!! 
                                 Form::text('meta[participant_adult_contact_b_work_other_contact]','', issetKey( $meta, 'participant_adult_contact_b_work_other_contact', '' ))
                                 ->id('participant_adult_contact_b_work_other_contact')
                                 ->help(trans('global.user.fields.name_helper'))
                                 !!}
                              </div>
                           </div>
                           <div class="form-group ">
                              <label for="employer">{!! trans('opforms.fields.line_b_primary_6') !!}</label>
                              <div class="form-check-custom">
                                 <div class="form-check">
                                    <input type="radio" name="meta[is_contact_b_home_after_business]" value="yes" class="form-check-input" {{ issetKey( $meta, 'is_contact_b_home_after_business', '' ) == 'yes' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.yes') !!}</label>
                                    <input type="radio" name="meta[is_contact_b_home_after_business]" value="no" class="form-check-input" {{ issetKey( $meta, 'is_contact_b_home_after_business', '' ) == 'no' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.no') !!}</label>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-4">
                                 <label>  {{ trans('opforms.fields.home_telephone')}}</label>
                              </div>
                              <div class="col-sm-8">
                                 {!! 
                                 Form::text('meta[participant_adult_contact_b_home_telephone]', '', issetKey( $meta, 'participant_adult_contact_b_home_telephone', '' ))
                                 ->id('participant_adult_contact_b_home_telephone')
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
                                 <label>  {{trans('opforms.fields.after_work_contact')}}</label>
                              </div>
                              <div class="col-sm-8">
                                 {!! 
                                 Form::text('meta[participant_adult_contact_b_after_work_contact]', '', issetKey( $meta, 'participant_adult_contact_b_after_work_contact', '' ))
                                 ->id('participant_adult_contact_b_after_work_contact')
                                 ->help(trans('global.user.fields.name_helper'))
                                 !!}
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-4">
                                 <label>  {{trans('opforms.fields.contact_mobile')}}</label>
                              </div>
                              <div class="col-sm-8">
                                 {!! 
                                 Form::text('meta[participant_adult_contact_b_mobile]', '', issetKey( $meta, 'participant_adult_contact_b_mobile', '' ))
                                 ->id('participant_adult_contact_b_mobile')
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
                           <div class="form-group ">
                              <label for="employer">{!! trans('opforms.fields.sms') !!}</label>
                              <div class="form-check-custom">
                                 <div class="form-check">
                                    <input type="radio" name="meta[contact_b_sms_notification]" value="yes" class="form-check-input" {{ issetKey( $meta, 'contact_b_sms_notification', '' ) == 'yes' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="exampleCheck1">Yes</label>
                                    <input type="radio" name="meta[contact_b_sms_notification]" value="no" class="form-check-input" {{ issetKey( $meta, 'contact_b_sms_notification', '' ) == 'no' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="exampleCheck1">No</label>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group ">
                              <label for="employer">{!! trans('opforms.fields.line_b_primary_7') !!}</label>
                              <div class="form-check-custom">
                                 <div class="form-check">
                                    <input type="radio" name="meta[conact_b_prefered_contact_method]" value="email" class="form-check-input" {{ issetKey( $meta, 'conact_b_prefered_contact_method', '' ) == 'email' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.email') !!}</label>
                                    <input type="radio" name="meta[conact_b_prefered_contact_method]" value="phone" class="form-check-input" {{ issetKey( $meta, 'conact_b_prefered_contact_method', '' ) == 'phone' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.phone') !!}</label>
                                    <input type="radio" name="meta[conact_b_prefered_contact_method]" value="facsimile" class="form-check-input" {{ issetKey( $meta, 'conact_b_prefered_contact_method', '' ) == 'facsimile' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.facsimile') !!}</label>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-4">
                                 <label>  {{ trans('opforms.fields.email')}}</label>
                              </div>
                              <div class="col-sm-8">
                                 {!! 
                                 Form::text('meta[participant_adult_contact_b_email]','', issetKey( $meta, 'participant_adult_contact_b_email', '' ))
                                 ->id('participant_adult_contact_b_email')
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
                           <div class="form-group ">
                              <label for="employer">{!! trans('opforms.fields.sms') !!}</label>
                              <div class="form-check-custom">
                                 <div class="form-check">
                                    <input type="radio" name="meta[conact_b_prefered_sms_notification]" value="yes" class="form-check-input" {{ issetKey( $meta, 'conact_b_prefered_sms_notification', '' ) == 'yes' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.yes') !!}</label>
                                    <input type="radio" name="meta[conact_b_prefered_sms_notification]" value="no" class="form-check-input" {{ issetKey( $meta, 'conact_b_prefered_sms_notification', '' ) == 'no' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.no') !!}</label>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-4">
                                 <label>  {{ trans('opforms.fields.fax')}}</label>
                              </div>
                              <div class="col-sm-8">
                                 {!! 
                                 Form::text('meta[participant_adult_contact_b_fax]','', issetKey( $meta, 'participant_adult_contact_b_fax', '' ))
                                 ->id('participant_adult_contact_b_fax')
                                 ->help(trans('global.user.fields.name_helper'))
                                 !!}
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-4">
                                 <label>  {{ trans('opforms.fields.after_hours')}}</label>
                              </div>
                              <div class="col-sm-8">
                                 {!! 
                                 Form::text('meta[participant_adult_contact_b_after_hours]', '', issetKey( $meta, 'participant_adult_contact_b_after_hours', '' ))
                                 ->id('participant_adult_contact_b_after_hours')
                                 ->help(trans('global.user.fields.name_helper'))
                                 !!}
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="docter-details">
                  <h4>{!! trans('opforms.fields.doctor_line_1') !!}</h4>
                  <div class="row">
                     <div class="col-sm-4">
                        <label>  {{ trans('opforms.fields.doctor_name')}}</label>
                     </div>
                     <div class="col-sm-8">
                        {!! 
                        Form::text('meta[participant_doctor_name]', '', issetKey( $meta, 'participant_doctor_name', '' ))
                        ->id('participant_doctor_name')
                        ->help(trans('global.user.fields.name_helper'))
                        !!}
                     </div>
                  </div>
                  <div class="form-group ">
                     <label for="employer">{!! trans('opforms.fields.doctor_practice') !!}</label>
                     <div class="form-check-custom">
                        <div class="form-check">
                           <input type="radio" name="meta[doctor_practice]" value="individual" class="form-check-input" {{ issetKey( $meta, 'doctor_practice', '' ) == 'individual' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.individual') !!}</label>
                           <input type="radio" name="meta[doctor_practice]" value="group" class="form-check-input" {{ issetKey( $meta, 'doctor_practice', '' ) == 'group' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.group') !!}</label>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-4">
                        <label>  {{trans('opforms.fields.doctor_street')}}</label>
                     </div>
                     <div class="col-sm-8">
                        {!! 
                        Form::text('meta[participant_doctor_street]', '', issetKey( $meta, 'participant_doctor_street', '' ))
                        ->id('participant_doctor_street')
                        !!}
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-4">
                        <label>  {{ trans('opforms.fields.suburb')}}</label>
                     </div>
                     <div class="col-sm-8">
                        {!! 
                        Form::text('meta[participant_doctor_suburb]','', issetKey( $meta, 'participant_doctor_suburb', '' ))
                        ->id('participant_doctor_suburb')
                        !!}
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-4">
                        <label>  {{ trans('opforms.fields.state')}}</label>
                     </div>
                     <div class="col-sm-8">
                        {!! 
                        Form::text('meta[participant_doctor_state]', '', issetKey( $meta, 'participant_doctor_state', '' ))
                        ->id('participant_doctor_state')
                        !!}
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-4">
                        <label>  {{ trans('opforms.fields.telephone')}}</label>
                     </div>
                     <div class="col-sm-8">
                        {!! 
                        Form::text('meta[participant_doctor_telephone]', '', issetKey( $meta, 'participant_doctor_telephone', '' ))
                        ->id('participant_doctor_telephone_2')
                        ->attrs([
                        "required"=>"required",
                        "data-rule-required"=>"true",
                        "data-msg-required"=>"Please enter your mobile number",
                        "data-rule-minlength"=>"10",
                        "data-rule-number" => "true",
                        "data-msg-minlength"=>"Mobile number should be 10 digits minimum"
                        ])
                        !!}
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-4">
                        <label>  {{ trans('opforms.fields.postal')}}</label>
                     </div>
                     <div class="col-sm-8">
                        {!! 
                        Form::text('meta[participant_doctor_postal', '', issetKey( $meta, 'participant_doctor_postal', '' ))
                        ->id('participant_doctor_postal')
                        !!}
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-4">
                        <label>  {{ trans('opforms.fields.fax')}}</label>
                     </div>
                     <div class="col-sm-8">
                        {!! 
                        Form::text('meta[participant_doctor_fax]','', issetKey( $meta, 'participant_doctor_fax', '' ))
                        ->id('participant_doctor_fax')
                        !!}
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-4">
                        <label>  {{  trans('opforms.fields.medicare_no')}}</label>
                     </div>
                     <div class="col-sm-8">
                        {!! 
                        Form::text('meta[participant_doctor_medicare_no]','', issetKey( $meta, 'participant_doctor_medicare_no', '' ))
                        ->id('participant_doctor_medicare_no')
                        !!}
                     </div>
                  </div>
                  <div class="form-group ">
                     <label for="employer">{!! trans('opforms.fields.ambulance_subscription') !!}</label>
                     <div class="form-check-custom">
                        <div class="form-check">
                           <input type="radio" name="meta[participant_ambulance_subscription]" value="yes" class="form-check-input" {{ issetKey( $meta, 'participant_ambulance_subscription', '' ) == 'yes' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.yes') !!}</label>
                           <input type="radio" name="meta[participant_ambulance_subscription]" value="no" class="form-check-input" {{ issetKey( $meta, 'participant_ambulance_subscription', '' ) == 'no' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.no') !!}</label>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="detail-participant below-form">
                  <div class="form-group {{ $errors->has('Language') ? 'has-error' : '' }}">
                     <h4>{!! trans('opforms.fields.demographic_line_1') !!}</h4>
                     <ul>
                        <li><label for="Language">{!! trans('opforms.fields.demographic_line_2') !!}</label></li>
                     </ul>
                     <div class="row">
                        <div class="col-sm-4">
                           <label>  Australia/Other (please specify):</label>
                        </div>
                        <div class="col-sm-8">
                           {!! 
                           Form::text('meta[participant_born_country]', '', issetKey( $meta, 'participant_born_country', '' ))
                           ->id('participant_born_country')
                           !!}
                        </div>
                     </div>
                  </div>
                  <div class="form-group ">
                     <label for="employer">Send Correspondence person to: (tick one)</label>
                     <div class="form-check-custom">
                        <div class="form-check">
                           <input type="radio" name="meta[document_send_person]" value="Adult_A" class="form-check-input" {{ issetKey( $meta, 'document_send_person', '' ) == 'Adult_A' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Adult A</label>
                           <input type="radio" name="meta[document_send_person]" value="Adult_B" class="form-check-input" {{ issetKey( $meta, 'document_send_person', '' ) == 'Adult_B' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Adult B</label>
                           <input type="radio" name="meta[document_send_person]" value="Both_Adults" class="form-check-input" {{ issetKey( $meta, 'document_send_person', '' ) == 'Both_Adults' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Both Adults</label>
                           <input type="radio" name="meta[document_send_person]" value="Neither" class="form-check-input" {{ issetKey( $meta, 'document_send_person', '' ) == 'Neither' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Neither</label>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-4">
                        <label>  Date of arrival in Australia OR Date of return to Australia:</label>
                     </div>
                     <div class="col-sm-8">
                        {!! 
                        Form::date('meta[participant_arrival_australia_date]', '', old('participant_arrival_australia_date', isset($meta['participant_arrival_australia_date']) ? $meta['participant_arrival_australia_date'] : ''))
                        ->id('date-4')
                        ->required('required')
                        ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Participant arrival required" ])
                        ->help(trans('lobal.user.fields.name_helper'))
                        !!}
                     </div>
                  </div>
                  <div class="form-group ">
                     <label for="employer">Send Correspondence addressed to: (tick one)</label>
                     <div class="form-check-custom">
                        <div class="form-check">
                           <input type="radio" name="meta[document_send_addressed]" value="permanent" class="form-check-input" {{ issetKey( $meta, 'document_send_addressed', '' ) == 'permanent' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Permanent</label>
                           <input type="radio" name="meta[document_send_addressed]" value="Temporary" class="form-check-input" {{ issetKey( $meta, 'document_send_addressed', '' ) == 'Temporary' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Temporary</label>
                        </div>
                     </div>
                  </div>
                  <div class="form-group ">
                     <label for="employer">Basis of Australian Residency:</label>
                     <div class="form-check-custom">
                        <div class="form-check">
                           <input type="radio" name="meta[basis_of_residency]" value="Eligible_for_Australian_Passport" class="form-check-input" {{ issetKey( $meta, 'basis_of_residency', '' ) == 'Eligible_for_Australian_Passport' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Eligible for Australian Passport</label>
                           <input type="radio" name="meta[basis_of_residency]" value="Holds_Australian_Passport" class="form-check-input" {{ issetKey( $meta, 'basis_of_residency', '' ) == 'Holds_Australian_Passport' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Holds Australian Passport</label>
                           <input type="radio" name="meta[basis_of_residency]" value="Holds_Permanent_Residency_Visa" class="form-check-input" {{ issetKey( $meta, 'basis_of_residency', '' ) == 'Holds_Permanent_Residency_Visa' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Holds Permanent Residency  Visa</label>
                        </div>
                     </div>
                  </div>
                  <div class="form-group {{ $errors->has('Language') ? 'has-error' : '' }}">
                     <ul>
                        <li><label for="Language">Does the participant speak a language other than English at home?  (tick)</label></li>
                     </ul>
                     <label>( If more than one language is spoken at home, indicate the one that is spoken most often)</label>
                     <div class="form-check-custom">
                        <div class="form-check">
                           <input type="radio" name="meta[demographic_participant_speak_lang]" value="No_English_only" class="form-check-input" {{ issetKey( $meta, 'demographic_participant_speak_lang', '' ) == 'No_English_only' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">No, English only</label>
                           <input type="radio" name="meta[demographic_participant_speak_lang]" value="Yes_other" class="form-check-input" {{ issetKey( $meta, 'demographic_participant_speak_lang', '' ) == 'Yes_other' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Yes (please specify):</label>
                        </div>
                     </div>
                  </div>
                  <div class="form-group {{ $errors->has('Language') ? 'has-error' : '' }}">
                     <label>Does the student speak English? (tick)</label>
                     <div class="form-check-custom">
                        <div class="form-check">
                           <input type="radio" name="meta[does_student_speak_eng]" value="yes" class="form-check-input" {{ issetKey( $meta, 'does_student_speak_eng', '' ) == 'yes' ? 'checked' : '' }}>
                           <label class="form-check-label" for="exampleCheck1">Yes</label>
                           <input type="radio" name="meta[does_student_speak_eng]" value="no" class="form-check-input" {{ issetKey( $meta, 'does_student_speak_eng', '' ) == 'no' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">No</label>
                        </div>
                     </div>
                  </div>
                  <div class="form-group {{ $errors->has('Language') ? 'has-error' : '' }}">
                     <ul>
                        <li><label for="Language">Is the participant of Aboriginal or Torres Strait Islander origin? (tick one)</label></li>
                     </ul>
                     <div class="form-check-custom">
                        <div class="form-check">
                           <input type="radio" name="meta[is_participant_islander]" value="no" class="form-check-input" {{ issetKey( $meta, 'is_participant_islander', '' ) == 'no' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">No</label>
                           <input type="radio" name="meta[is_participant_islander]" value="Yes_Torres_Strait_Islander" class="form-check-input" {{ issetKey( $meta, 'is_participant_islander', '' ) == 'Yes_Torres_Strait_Islander' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Yes, Torres Strait Islander </label>
                           <input type="radio" name="meta[is_participant_islander]" value="Yes_Aboriginal" class="form-check-input" {{ issetKey( $meta, 'is_participant_islander', '' ) == 'Yes_Aboriginal' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Yes, Aboriginal</label>
                           <input type="radio" name="meta[is_participant_islander]" value="Yes_Both_Aboriginal_Torres_Strait_Islander" class="form-check-input" {{ issetKey( $meta, 'is_participant_islander', '' ) == 'Yes_Both_Aboriginal_Torres_Strait_Islander' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Yes, Both Aboriginal & Torres Strait Islander</label>
                        </div>
                     </div>
                  </div>
                  <div class="form-group {{ $errors->has('Language') ? 'has-error' : '' }}">
                     <ul>
                        <li><label for="Language">What is the Participant's living arrangements? (tick one):</label></li>
                     </ul>
                     <div class="form-check-custom">
                        <div class="form-check">
                           <input type="radio" name="meta[is_participant_living]" value="at_home_with_two_guardians" class="form-check-input" {{ issetKey( $meta, 'is_participant_living', '' ) == 'at_home_with_two_guardians' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">At home with  Two Guardians </label>
                           <input type="radio" name="meta[is_participant_living]" value="at_home_with_one_guardian" class="form-check-input" {{ issetKey( $meta, 'is_participant_living', '' ) == 'at_home_with_one_guardian' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">At home with ONE  Guardian  </label>
                           <input type="radio" name="meta[is_participant_living]" value="independent" class="form-check-input" {{ issetKey( $meta, 'is_participant_living', '' ) == 'independent' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Independent</label>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="emergency-contact">
                  <div class="form-group {{ $errors->has('Language') ? 'has-error' : '' }}">
                     <div class="row">
                        <div class="col-sm-4">
                           <h4>PRIMARY FAMILY EMERGENCY CONTACTS: (Apart from primary carers):</h4>
                           <label>  Name</label>
                        </div>
                        <div class="col-sm-8">
                           {!! 
                           Form::text('meta[parimary_family_emergency]', '', issetKey( $meta, 'parimary_family_emergency', '' ) )
                           ->id('parimary_family_emergency')
                           ->help(trans('global.user.fields.name_helper'))
                           !!}
                        </div>
                     </div>
                  </div>
                  <div class="form-group {{ $errors->has('Language') ? 'has-error' : '' }}">
                     <div class="row">
                        <div class="col-sm-4">
                           <label>Relationship (Neighbour, Relative, Friend or other)</label>
                           <label>  Name</label>
                        </div>
                        <div class="col-sm-8">
                           {!! 
                           Form::text('meta[relationship_with_family]', '', issetKey( $meta, 'relationship_with_family', '' ) )
                           ->id('relationship_with_family')
                           ->help(trans('global.user.fields.name_helper'))
                           !!}
                        </div>
                     </div>
                  </div>
                  <div class="form-group {{ $errors->has('Language') ? 'has-error' : '' }}">
                     <div class="row">
                        <div class="col-sm-4">
                           <label>Telephone Contact</label>
                           <label>  Name</label>
                        </div>
                        <div class="col-sm-8">
                           {!! 
                           Form::text('meta[primary_contact]', '', issetKey( $meta, 'primary_contact', '' ) )
                           ->id('primary_contact')
                           ->help(trans('global.user.fields.name_helper'))
                           !!}
                        </div>
                     </div>
                  </div>
                  <div class="form-group {{ $errors->has('Language') ? 'has-error' : '' }}">
                     <label>Language Spoken (IF English Write “E”)</label>
                     <div class="form-group {{ $errors->has('Language') ? 'has-error' : '' }}">
                        <div class="row">
                           <div class="col-sm-4">
                              <label>Telephone Contact</label>
                              <label>  Name</label>
                           </div>
                           <div class="col-sm-8">
                              {!! 
                              Form::text('meta[parimary_family_lang]', '', issetKey( $meta, 'parimary_family_lang', '' ) )
                              ->id('parimary_family_lang')
                              ->help(trans('global.user.fields.name_helper'))
                              !!}
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="family-detail">
                  <div class="form-group ">
                     <h4>OTHER PRIMARY FAMILY DETAILS</h4>
                     <label for="employer">Relationship of Adult A to Participant: (tick one)</label>
                     <div class="form-check-custom parent-label">
                        <div class="form-check">
                           <input type="radio" name="meta[relationship_adult_a_to_participant]" value="parent" class="form-check-input" {{ issetKey( $meta, 'relationship_adult_a_to_participant', '' ) == 'parent' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Parent</label>
                           <input type="radio" name="meta[relationship_adult_a_to_participant]" value="foster_parent" class="form-check-input" {{ issetKey( $meta, 'relationship_adult_a_to_participant', '' ) == 'foster_parent' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Foster Parent</label>
                           <input type="radio" name="meta[relationship_adult_a_to_participant]" value="friend" class="form-check-input" {{ issetKey( $meta, 'relationship_adult_a_to_participant', '' ) == 'friend' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Friend</label>
                        </div>
                     </div>
                     <div class="form-check-custom parent-label">
                        <div class="form-check">
                           <input type="radio" name="meta[relationship_adult_a_to_participant]" value="step_parent" class="form-check-input" {{ issetKey( $meta, 'relationship_adult_a_to_participant', '' ) == 'step_parent' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Step-Parent</label>
                           <input type="radio" name="meta[relationship_adult_a_to_participant]" value="host_family" class="form-check-input" {{ issetKey( $meta, 'relationship_adult_a_to_participant', '' ) == 'host_family' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Host Family</label>
                           <input type="radio" name="meta[relationship_adult_a_to_participant]" value="self" class="form-check-input" {{ issetKey( $meta, 'relationship_adult_a_to_participant', '' ) == 'self' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Self</label>
                        </div>
                     </div>
                     <div class="form-check-custom parent-label">
                        <div class="form-check">
                           <input type="radio" name="meta[relationship_adult_a_to_participant]" value="adoptive_parent" class="form-check-input" {{ issetKey( $meta, 'relationship_adult_a_to_participant', '' ) == 'adoptive_parent' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Adoptive Parent</label>
                           <input type="radio" name="meta[relationship_adult_a_to_participant]" value="relative" class="form-check-input" {{ issetKey( $meta, 'relationship_adult_a_to_participant', '' ) == 'relative' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Relative</label>
                           <input type="radio" name="meta[relationship_adult_a_to_participant]" value="other" class="form-check-input" {{ issetKey( $meta, 'relationship_adult_a_to_participant', '' ) == 'other' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Other</label>
                        </div>
                     </div>
                  </div>
                  <div class="form-group ">
                     <label for="employer">Relationship of Adult B to Participant: (tick one) </label>
                     <div class="form-check-custom parent-label">
                        <div class="form-check">
                           <input type="radio" name="meta[relationship_adult_b_to_participant]" value="parent" class="form-check-input" {{ issetKey( $meta, 'relationship_adult_a_to_participant', '' ) == 'parent' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Parent</label>
                           <input type="radio" name="meta[relationship_adult_b_to_participant]" value="foster_parent" class="form-check-input"{{ issetKey( $meta, 'relationship_adult_a_to_participant', '' ) == 'foster_parent' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Foster Parent</label>
                           <input type="radio" name="meta[relationship_adult_b_to_participant]" value="friend" class="form-check-input" {{ issetKey( $meta, 'relationship_adult_a_to_participant', '' ) == 'friend' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Friend</label>
                        </div>
                     </div>
                     <div class="form-check-custom parent-label">
                        <div class="form-check">
                           <input type="radio" name="meta[relationship_adult_b_to_participant]" value="step_parent" class="form-check-input" {{ issetKey( $meta, 'relationship_adult_a_to_participant', '' ) == 'step_parent' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Step-Parent</label>
                           <input type="radio" name="meta[relationship_adult_b_to_participant]" value="host_family" class="form-check-input" {{ issetKey( $meta, 'relationship_adult_a_to_participant', '' ) == 'host_family' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Host Family</label>
                           <input type="radio" name="meta[relationship_adult_b_to_participant]" value="self" class="form-check-input" {{ issetKey( $meta, 'relationship_adult_a_to_participant', '' ) == 'self' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Self</label>
                        </div>
                     </div>
                     <div class="form-check-custom parent-label">
                        <div class="form-check">
                           <input type="radio" name="meta[relationship_adult_b_to_participant]" value="adoptive_parent" class="form-check-input" {{ issetKey( $meta, 'relationship_adult_a_to_participant', '' ) == 'adoptive_parent' ? 'checked' : '' }}>
                           <label class="form-check-label" for="exampleCheck1">Adoptive Parent</label>
                           <input type="radio" name="meta[relationship_adult_b_to_participant]" value="relative" class="form-check-input" {{ issetKey( $meta, 'relationship_adult_a_to_participant', '' ) == 'relative' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Relative</label>
                           <input type="radio" name="meta[relationship_adult_b_to_participant]" value="other" class="form-check-input" {{ issetKey( $meta, 'relationship_adult_a_to_participant', '' ) == 'other' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Other</label>
                        </div>
                     </div>
                  </div>
                  <div class="form-group ">
                     <label for="employer">The participant lives with the Primary Family: (tick one)</label>
                     <div class="form-check-custom parent-label">
                        <div class="form-check">
                           <input type="radio" name="meta[participant_living_with_family]" value="always" class="form-check-input" {{ issetKey( $meta, 'participant_living_with_family', '' ) == 'always' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1"> Always</label>
                           <input type="radio" name="meta[participant_living_with_family]" value="monthly" class="form-check-input" {{ issetKey( $meta, 'participant_living_with_family', '' ) == 'monthly' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Monthly</label>
                           <input type="radio" name="meta[participant_living_with_family]" value="balanced" class="form-check-input" {{ issetKey( $meta, 'participant_living_with_family', '' ) == 'balanced' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Balanced</label>
                           <input type="radio" name="meta[participant_living_with_family]" value="occasionally" class="form-check-input" {{ issetKey( $meta, 'participant_living_with_family', '' ) == 'occasionally' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Occasionally</label>
                           <input type="radio" name="meta[participant_living_with_family]" value="never" class="form-check-input" {{ issetKey( $meta, 'participant_living_with_family', '' ) == 'never' ? 'checked' : '' }}>
                           <label class="form-check-label" for="exampleCheck1">Never</label>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="medical-assessment below-form">
                  <div class="form-group {{ $errors->has('Language') ? 'has-error' : '' }}">
                     <h4>MEDICAL ASSESSMENT</h4>
                     <label>Please note, prior to commencing as a participant at our service, it is our policy that the participant obtain a medical assessment 
                     from a GP, with a comprehensive report of the participant's conditions.</label>
                  </div>
                  <div class="form-group {{ $errors->has('Language') ? 'has-error' : '' }}">
                     <ul>
                        <li>
                           <div class="form-group"><label>Please list the condition which impact participant daily living</label></div>
                        </li>
                        <li>
                           <div class="form-group"><label>Deafness or Severe Hearing Impairment</label></div>
                        </li>
                        <li>
                           <div class="form-group"><label>Blindness or Severe Visual Impairment</label></div>
                        </li>
                        <li>
                           <div class="form-group"><label>Autism</label></div>
                        </li>
                        <li>
                           <div class="form-group"><label>Other</label></div>
                        </li>
                     </ul>
                  </div>
                  <div class="form-group {{ $errors->has('Language') ? 'has-error' : '' }}">
                     <label> A condition that substantially  limits physical activity such as walking, climbing stairs ,  or carrying a learning difficulty</label>
                     <label> A long standing psychological  or mental health condition</label>
                  </div>
                  <div class="form-group ">
                     <label for="employer">Do you have any allergies </label>
                     <div class="form-check-custom">
                        <div class="form-check">
                           <input type="radio" name="meta[have_allergies]" value="yes" class="form-check-input" {{ issetKey( $meta, 'have_allergies', '' ) == 'yes' ? 'checked' : '' }}>
                           <label class="form-check-label" for="exampleCheck1">Yes</label>
                           <input type="radio" name="meta[have_allergies]" value="no" class="form-check-input" {{ issetKey( $meta, 'have_allergies', '' ) == 'no' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">No</label>
                        </div>
                     </div>
                  </div>
                  <div class="form-group ">
                     <div class="row">
                        <div class="col-sm-4">
                           <label for="employer">If Yes Please  Specify :</label>
                           <label>  Name</label>
                        </div>
                        <div class="col-sm-8">
                           {!! 
                           Form::text('meta[if_allergies_specify]', '', issetKey( $meta, 'if_allergies_specify', '' ) )
                           ->id('if_allergies_specify')
                           ->help(trans('global.user.fields.name_helper'))
                           !!}
                        </div>
                     </div>
                  </div>
                  <div class="form-group ">
                     <label for="employer">Are you currently on Medication? </label>
                     <div class="form-check-custom">
                        <div class="form-check">
                           <input type="radio" name="meta[are_you_on_medication]" value="" class="form-check-input" {{ issetKey( $meta, 'are_you_on_medication', '' ) == 'yes' ? 'checked' : '' }}>
                           <label class="form-check-label" for="exampleCheck1">Yes</label>
                           <input type="radio" name="meta[are_you_on_medication]" value="" class="form-check-input" {{ issetKey( $meta, 'are_you_on_medication', '' ) == 'no' ? 'checked' : '' }}>
                           <label class="form-check-label" for="exampleCheck1">No</label>
                        </div>
                     </div>
                  </div>
                  <div class="form-group ">
                     <div class="row">
                        <div class="col-sm-4">
                           <label for="employer">If Yes Please  Specify the medication that  you are on :</label>
                           <label>  Name</label>
                        </div>
                        <div class="col-sm-8">
                           {!! 
                           Form::text('meta[if_allergies_specify]', '', issetKey( $meta, 'if_allergies_specify', '' ) )
                           ->id('if_allergies_specify')
                           ->help(trans('global.user.fields.name_helper'))
                           !!}
                        </div>
                     </div>
                  </div>
                  <div class="form-group ">
                     <label for="employer">Does the Participant have any other medical  requirements your support worker, Allied Health , and the Approved Provider need to know of </label>
                     <div class="form-check-custom">
                        <div class="form-check">
                           <input type="radio" name="does_participant_any_other_medical" value="" class="form-check-input" {{ issetKey( $meta, 'does_participant_any_other_medical', '' ) == 'yes' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">Yes</label>
                           <input type="radio" name="does_participant_any_other_medical" value="" class="form-check-input" {{ issetKey( $meta, 'does_participant_any_other_medical', '' ) == 'no' ? 'checked' : '' }} >
                           <label class="form-check-label" for="exampleCheck1">No</label>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-4">
                        <label>  Name</label>
                     </div>
                     <div class="col-sm-8">
                        {!! 
                        Form::text('meta[if_allergies_specify]', '', issetKey( $meta, 'if_allergies_specify', '' ) )
                        ->id('if_allergies_specify')
                        ->help(trans('global.user.fields.name_helper'))
                        !!}
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-4">
                        <label>  {{trans('opforms.fields.fax')}}</label>
                     </div>
                     <div class="col-sm-8">
                        {!! 
                        Form::text('meta[participant_adult_contact_b_fax]', '', issetKey( $meta, 'participant_adult_contact_b_fax', '' ))
                        ->id('participant_adult_contact_b_fax')
                        ->help(trans('global.user.fields.name_helper'))
                        !!}
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-4">
                        <label>  {{trans('opforms.fields.after_hours')}}</label>
                     </div>
                     <div class="col-sm-8">
                        {!! 
                        Form::text('meta[participant_adult_contact_b_after_hours]', '', issetKey( $meta, 'participant_adult_contact_b_after_hours', '' ))
                        ->id('participant_adult_contact_b_after_hours')
                        ->help(trans('global.user.fields.name_helper'))
                        !!}
                     </div>
                  </div>
               </div>
            </div>
            <div class="docter-details">
               <h4>{!! trans('opforms.fields.doctor_line_1') !!}</h4>
               <div class="row">
                  <div class="col-sm-4">
                     <label>  {{trans('opforms.fields.doctor_name')}}</label>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::text('meta[participant_doctor_name]', '', issetKey( $meta, 'participant_doctor_name', '' ))
                     ->id('participant_doctor_name')
                     ->help(trans('global.user.fields.name_helper'))
                     !!}
                  </div>
               </div>
               <div class="form-group ">
                  <label for="employer">{!! trans('opforms.fields.doctor_practice') !!}</label>
                  <div class="form-check-custom">
                     <div class="form-check">
                        <input type="radio" name="meta[doctor_practice]" value="individual" class="form-check-input" {{ issetKey( $meta, 'doctor_practice', '' ) == 'individual' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.individual') !!}</label>
                        <input type="radio" name="meta[doctor_practice]" value="group" class="form-check-input" {{ issetKey( $meta, 'doctor_practice', '' ) == 'group' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.group') !!}</label>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-4">
                     <label>  {{ trans('opforms.fields.doctor_street')}}</label>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::text('meta[participant_doctor_street]','', issetKey( $meta, 'participant_doctor_street', '' ))
                     ->id('participant_doctor_street')
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-4">
                     <label>  {{ trans('opforms.fields.suburb')}}</label>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::text('meta[participant_doctor_suburb]', '', issetKey( $meta, 'participant_doctor_suburb', '' ))
                     ->id('participant_doctor_suburb')
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-4">
                     <label>  {{ trans('opforms.fields.state')}}</label>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::text('meta[participant_doctor_state]', '', issetKey( $meta, 'participant_doctor_state', '' ))
                     ->id('participant_doctor_state')
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-4">
                     <label>  {{trans('opforms.fields.telephone')}}</label>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::text('meta[participant_doctor_telephone]', '', issetKey( $meta, 'participant_doctor_telephone', '' ))
                     ->id('participant_doctor_telephone')
                     ->attrs([
                     "required"=>"required",
                     "data-rule-required"=>"true",
                     "data-msg-required"=>"Please enter your mobile number",
                     "data-rule-minlength"=>"10",
                     "data-rule-number" => "true",
                     "data-msg-minlength"=>"Mobile number should be 10 digits minimum"
                     ])
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-4">
                     <label>  {{ trans('opforms.fields.postal')}}</label>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::text('meta[participant_doctor_postal]','', issetKey( $meta, 'participant_doctor_postal', '' ))
                     ->id('participant_doctor_postal')
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-4">
                     <label>  {{ trans('opforms.fields.fax')}}</label>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::text('meta[participant_doctor_fax]', '', issetKey( $meta, 'participant_doctor_fax', '' ))
                     ->id('participant_doctor_fax')
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-4">
                     <label>  {{ trans('opforms.fields.medicare_no')}}</label>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::text('meta[participant_doctor_medicare_no]', '', issetKey( $meta, 'participant_doctor_medicare_no', '' ))
                     ->id('participant_doctor_medicare_no')
                     !!}
                  </div>
               </div>
               <div class="form-group ">
                  <label for="employer">{!! trans('opforms.fields.ambulance_subscription') !!}</label>
                  <div class="form-check-custom">
                     <div class="form-check">
                        <input type="radio" name="meta[participant_ambulance_subscription]" value="yes" class="form-check-input" {{ issetKey( $meta, 'participant_ambulance_subscription', '' ) == 'yes' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.yes') !!}</label>
                        <input type="radio" name="meta[participant_ambulance_subscription]" value="no" class="form-check-input" {{ issetKey( $meta, 'participant_ambulance_subscription', '' ) == 'no' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">{!! trans('opforms.fields.no') !!}</label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="detail-participant below-form">
               <div class="form-group {{ $errors->has('Language') ? 'has-error' : '' }}">
                  <h4>{!! trans('opforms.fields.demographic_line_1') !!}</h4>
                  <ul>
                     <li><label for="Language">{!! trans('opforms.fields.demographic_line_2') !!}</label></li>
                  </ul>
                  <div class="row">
                     <div class="col-sm-4">
                        <label>  Australia/Other (please specify):</label>
                     </div>
                     <div class="col-sm-8">
                        {!! 
                        Form::text('meta[participant_born_country]', '', issetKey( $meta, 'participant_born_country', '' ) )
                        ->id('participant_born_country')
                        ->help(trans('global.user.fields.name_helper'))
                        !!}
                     </div>
                  </div>
               </div>
               <div class="form-group ">
                  <label for="employer">Send Correspondence person to: (tick one)</label>
                  <div class="form-check-custom">
                     <div class="form-check">
                        <input type="radio" name="meta[document_send_person]" value="Adult_A" class="form-check-input" {{ issetKey( $meta, 'participant_ambulance_subscription', '' ) == 'Adult_A' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Adult A</label>
                        <input type="radio" name="meta[document_send_person]" value="Adult_B" class="form-check-input" {{ issetKey( $meta, 'participant_ambulance_subscription', '' ) == 'Adult_B' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Adult B</label>
                        <input type="radio" name="meta[document_send_person]" value="Both_Adults" class="form-check-input" {{ issetKey( $meta, 'participant_ambulance_subscription', '' ) == 'Both_Adults' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Both Adults</label>
                        <input type="radio" name="meta[document_send_person]" value="Neither" class="form-check-input" {{ issetKey( $meta, 'participant_ambulance_subscription', '' ) == 'Neither' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Neither</label>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-4">
                     <label> Date of arrival in Australia OR Date of return to Australia:</label>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::date('meta[participant_arrival_australia_date_a]', '', old('participant_arrival_australia_date_a', isset($meta['participant_arrival_australia_date_a']) ? $meta['participant_arrival_australia_date_a'] : ''))
                     ->id('date-5')
                     ->required('required')
                     ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Date field required" ])
                     ->help(trans('lobal.user.fields.name_helper'))
                     !!}
                  </div>
               </div>
               <div class="form-group ">
                  <label for="employer">Send Correspondence addressed to: (tick one)</label>
                  <div class="form-check-custom">
                     <div class="form-check">
                        <input type="radio" name="meta[document_send_addressed]" value="permanent" class="form-check-input" {{ issetKey( $meta, 'document_send_addressed', '' ) == 'permanent' ? 'checked' : '' }}>
                        <label class="form-check-label" for="exampleCheck1">Permanent</label>
                        <input type="radio" name="meta[document_send_addressed]" value="Temporary" class="form-check-input" {{ issetKey( $meta, 'document_send_addressed', '' ) == 'Temporary' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Temporary</label>
                     </div>
                  </div>
               </div>
               <div class="form-group ">
                  <label for="employer">Basis of Australian Residency:</label>
                  <div class="form-check-custom">
                     <div class="form-check">
                        <input type="radio" name="meta[basis_of_residency]" value="Eligible_for_Australian_Passport" class="form-check-input" {{ issetKey( $meta, 'basis_of_residency', '' ) == 'Eligible_for_Australian_Passport' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Eligible for Australian Passport</label>
                        <input type="radio" name="meta[basis_of_residency]" value="Holds_Australian_Passport" class="form-check-input" {{ issetKey( $meta, 'basis_of_residency', '' ) == 'Holds_Australian_Passport' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Holds Australian Passport</label>
                        <input type="radio" name="meta[basis_of_residency]" value="Holds_Permanent_Residency_Visa" class="form-check-input" {{ issetKey( $meta, 'basis_of_residency', '' ) == 'Holds_Permanent_Residency_Visa' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Holds Permanent Residency  Visa</label>
                     </div>
                  </div>
               </div>
               <div class="form-group {{ $errors->has('Language') ? 'has-error' : '' }}">
                  <ul>
                     <li><label for="Language">Does the participant speak a language other than English at home?  (tick)</label></li>
                  </ul>
                  <label>( If more than one language is spoken at home, indicate the one that is spoken most often)</label>
                  <div class="form-check-custom">
                     <div class="form-check">
                        <input type="radio" name="meta[demographic_participant_speak_lang]" value="No_English_only" class="form-check-input" {{ issetKey( $meta, 'demographic_participant_speak_lang', '' ) == 'No_English_only' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">No, English only</label>
                        <input type="radio" name="meta[demographic_participant_speak_lang]" value="Yes_other" class="form-check-input" {{ issetKey( $meta, 'demographic_participant_speak_lang', '' ) == 'Yes_other' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Yes (please specify):</label>
                     </div>
                  </div>
               </div>
               <div class="form-group {{ $errors->has('Language') ? 'has-error' : '' }}">
                  <label>Does the student speak English? (tick)</label>
                  <div class="form-check-custom">
                     <div class="form-check">
                        <input type="radio" name="meta[does_student_speak_eng]" value="yes" class="form-check-input" {{ issetKey( $meta, 'does_student_speak_eng', '' ) == 'yes' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Yes</label>
                        <input type="radio" name="meta[does_student_speak_eng]" value="no" class="form-check-input" {{ issetKey( $meta, 'does_student_speak_eng', '' ) == 'no' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">No</label>
                     </div>
                  </div>
               </div>
               <div class="form-group {{ $errors->has('Language') ? 'has-error' : '' }}">
                  <ul>
                     <li><label for="Language">Is the participant of Aboriginal or Torres Strait Islander origin? (tick one)</label></li>
                  </ul>
                  <div class="form-check-custom">
                     <div class="form-check">
                        <input type="radio" name="meta[is_participant_islander]" value="no" class="form-check-input" {{ issetKey( $meta, 'is_participant_islander', '' ) == 'no' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">No</label>
                        <input type="radio" name="meta[is_participant_islander]" value="Yes_Torres_Strait_Islander" class="form-check-input" {{ issetKey( $meta, 'is_participant_islander', '' ) == 'Yes_Torres_Strait_Islander' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Yes, Torres Strait Islander </label>
                        <input type="radio" name="meta[is_participant_islander]" value="Yes_Aboriginal" class="form-check-input" {{ issetKey( $meta, 'is_participant_islander', '' ) == 'Yes_Aboriginal' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Yes, Aboriginal</label>
                        <input type="radio" name="meta[is_participant_islander]" value="Yes_Both_Aboriginal_Torres_Strait_Islander" class="form-check-input" {{ issetKey( $meta, 'is_participant_islander', '' ) == 'Yes_Both_Aboriginal_Torres_Strait_Islander' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Yes, Both Aboriginal & Torres Strait Islander</label>
                     </div>
                  </div>
               </div>
               <div class="form-group {{ $errors->has('Language') ? 'has-error' : '' }}">
                  <ul>
                     <li><label for="Language">What is the Participant's living arrangements? (tick one):</label></li>
                  </ul>
                  <div class="form-check-custom">
                     <div class="form-check">
                        <input type="radio" name="meta[participant_living_arrangement]" value="at_home_with_two_guardians" class="form-check-input" {{ issetKey( $meta, 'participant_living_arrangement', '' ) == 'at_home_with_two_guardians' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">At home with  Two Guardians </label>
                        <input type="radio" name="meta[participant_living_arrangement]" value="At_home_with_ONE  Guardian" class="form-check-input" {{ issetKey( $meta, 'participant_living_arrangement', '' ) == 'At_home_with_ONE' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Independent</label>
                        <input type="radio" name="meta[participant_living_arrangement]" value="At_home_with_ONE  Guardian" class="form-check-input" {{ issetKey( $meta, 'participant_living_arrangement', '' ) == 'At_home_with_ONE' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Independent</label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="emergency-contact">
               <h4>PRIMARY FAMILY EMERGENCY CONTACTS: (Apart from primary carers):</h4>
               <div class="row">
                  <div class="col-sm-4">
                     <label>  {{ trans('opforms.fields.full_name')}}</label>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::text('meta[participant_emergency_contact_name]','', issetKey( $meta, 'participant_emergency_contact_name', '' ))
                     ->id('participant_emergency_contact_name')
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-4">
                     <label>  Relationship (Neighbour, Relative, Friend or other)</label>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::text('meta[participant_emergency_contact_relationship]', '', issetKey( $meta, 'participant_emergency_contact_relationship', '' ))
                     ->id('participant_emergency_contact_relationship')
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-4">
                     <label> Telephone Contact</label>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::text('meta[participant_emergency_contact_telephone]', '', issetKey( $meta, 'participant_emergency_contact_telephone', '' ))
                     ->id('participant_emergency_contact_telephone')
                     ->attrs([
                     "required"=>"required",
                     "data-rule-required"=>"true",
                     "data-msg-required"=>"Please enter your mobile number",
                     "data-rule-minlength"=>"10",
                     "data-rule-number" => "true",
                     "data-msg-minlength"=>"Mobile number should be 10 digits minimum"
                     ])
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-4">
                     <label> Language Spoken (IF English Write “E”)</label>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::text('meta[participant_emergency_contact_lang]', '', issetKey( $meta, 'participant_emergency_contact_lang', '' ))
                     ->id('participant_emergency_contact_lang')
                     !!}
                  </div>
               </div>
            </div>
            <div class="family-detail">
               <div class="form-group ">
                  <h4>OTHER PRIMARY FAMILY DETAILS</h4>
                  <label for="employer">Relationship of Adult A to Participant: (tick one)</label>
                  <div class="form-check-custom parent-label">
                     <div class="form-check">
                        <input type="radio" name="meta[participant_relation_a]" value="parent" class="form-check-input" {{ issetKey( $meta, 'participant_relation_a', '' ) == 'parent' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Parent</label>
                        <input type="radio" name="meta[participant_relation_a]" value="Forter_Parent" class="form-check-input" {{ issetKey( $meta, 'participant_relation_a', '' ) == 'Forter_Parent' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Foster Parent</label>
                        <input type="radio" name="meta[participant_relation_a]" value="Friend" class="form-check-input" {{ issetKey( $meta, 'participant_relation_a', '' ) == 'Friend' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Friend</label>
                     </div>
                  </div>
                  <div class="form-check-custom parent-label">
                     <div class="form-check">
                        <input type="radio" name="meta[participant_relation_a]" value="Step_Parent" class="form-check-input" {{ issetKey( $meta, 'participant_relation_a', '' ) == 'Step_Parent' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Step-Parent</label>
                        <input type="radio" name="meta[participant_relation_a]" value="Host_Family" class="form-check-input" {{ issetKey( $meta, 'participant_relation_a', '' ) == 'Host_Family' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Host Family</label>
                        <input type="radio"  name="meta[participant_relation_a]" value="Self" class="form-check-input" {{ issetKey( $meta, 'participant_relation_a', '' ) == 'Self' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Self</label>
                     </div>
                  </div>
                  <div class="form-check-custom parent-label">
                     <div class="form-check">
                        <input type="radio" name="meta[participant_relation_a]" value="Adoptive_Parent" class="form-check-input" {{ issetKey( $meta, 'participant_relation_a', '' ) == 'Adoptive_Parent' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Adoptive Parent</label>
                        <input type="radio" name="meta[participant_relation_a]" value="Relative" class="form-check-input" {{ issetKey( $meta, 'participant_relation_a', '' ) == 'Relative' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Relative</label>
                        <input type="radio" name="meta[participant_relation_a]" value="Other" class="form-check-input" {{ issetKey( $meta, 'participant_relation_a', '' ) == 'Other' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Other</label>
                     </div>
                  </div>
               </div>
               <div class="form-group ">
                  <label for="employer">Relationship of Adult B to Participant: (tick one) </label>
                  <div class="form-check-custom parent-label">
                     <div class="form-check">
                        <input type="radio" name="meta[participant_relation_b]" value="Parent" class="form-check-input" {{ issetKey( $meta, 'participant_relation_b', '' ) == 'Parent' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Parent</label>
                        <input type="radio" name="meta[participant_relation_b]" value="Foster_Parent" class="form-check-input" {{ issetKey( $meta, 'participant_relation_b', '' ) == 'Foster_Parent' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Foster Parent</label>
                        <input type="radio" name="meta[participant_relation_b]" value="Friend" class="form-check-input" {{ issetKey( $meta, 'participant_relation_b', '' ) == 'Friend' ? 'checked' : '' }}>
                        <label class="form-check-label" for="exampleCheck1">Friend</label> 
                     </div>
                  </div>
                  <div class="form-check-custom parent-label">
                     <div class="form-check">
                        <input type="radio" name="meta[participant_relation_b]" value="Step_Parent" class="form-check-input" {{ issetKey( $meta, 'participant_relation_b', '' ) == 'Step_Parent' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Step-Parent</label>
                        <input type="radio" name="meta[participant_relation_b]" value="Host_Family" class="form-check-input" {{ issetKey( $meta, 'participant_relation_b', '' ) == 'Host_Family' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Host Family</label>
                        <input type="radio" name="meta[participant_relation_b]" value="Self" class="form-check-input" {{ issetKey( $meta, 'participant_relation_b', '' ) == 'Self' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Self</label>
                     </div>
                  </div>
                  <div class="form-check-custom parent-label">
                     <div class="form-check">
                        <input type="radio" name="meta[participant_relation_b]" value="Adoptive_Parent" class="form-check-input" {{ issetKey( $meta, 'participant_relation_b', '' ) == 'Adoptive_Parent' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Adoptive Parent</label>
                        <input type="radio" name="meta[participant_relation_b]" value="Relative" class="form-check-input" {{ issetKey( $meta, 'participant_relation_b', '' ) == 'Relative' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Relative</label>
                        <input type="radio" name="meta[participant_relation_b]" value="Other" class="form-check-input" {{ issetKey( $meta, 'participant_relation_b', '' ) == 'Other' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Other</label>
                     </div>
                  </div>
               </div>
               <div class="form-group ">
                  <label for="employer">The participant lives with the Primary Family: (tick one)</label>
                  <div class="form-check-custom parent-label">
                     <div class="form-check">
                        <input type="radio" name="meta[participant_live_family]" value="always" class="form-check-input" {{ issetKey( $meta, 'participant_live_family', '' ) == 'always' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1"> Always</label>
                        <input type="radio" name="meta[participant_live_family]" value="monthly" class="form-check-input" {{ issetKey( $meta, 'participant_live_family', '' ) == 'monthly' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Monthly</label>
                        <input type="radio" name="meta[participant_live_family]" value="balanced" class="form-check-input" {{ issetKey( $meta, 'participant_live_family', '' ) == 'balanced' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Balanced</label>
                        <input type="radio" name="meta[participant_live_family]" value="occasionally" class="form-check-input" {{ issetKey( $meta, 'participant_live_family', '' ) == 'occasionally' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Occasionally</label>
                        <input type="radio" name="meta[participant_live_family]" value="never" class="form-check-input" {{ issetKey( $meta, 'participant_live_family', '' ) == 'never' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Never</label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="medical-assessment below-form">
               <div class="form-group {{ $errors->has('Language') ? 'has-error' : '' }}">
                  <h4>MEDICAL ASSESSMENT</h4>
                  <label>Please note, prior to commencing as a participant at our service, it is our policy that the participant obtain a medical assessment 
                  from a GP, with a comprehensive report of the participant's conditions.</label>
               </div>
               <div class="form-group {{ $errors->has('Language') ? 'has-error' : '' }}">
                  <ul>
                     <li>
                        <div class="form-group"><label>Please list the condition which impact participant daily living</label></div>
                     </li>
                     <li>
                        <div class="form-group"><label>Deafness or Severe Hearing Impairment</label></div>
                     </li>
                     <li>
                        <div class="form-group"><label>Blindness or Severe Visual Impairment</label></div>
                     </li>
                     <li>
                        <div class="form-group"><label>Autism</label></div>
                     </li>
                     <li>
                        <div class="form-group"><label>Other</label></div>
                     </li>
                  </ul>
               </div>
               <div class="form-group {{ $errors->has('Language') ? 'has-error' : '' }}">
                  <label> A condition that substantially  limits physical activity such as walking, climbing stairs ,  or carrying a learning difficulty</label>
                  <label> A long standing psychological  or mental health condition</label>
               </div>
               <div class="form-group ">
                  <label for="employer">Do you have any allergies </label>
                  <div class="form-check-custom">
                     <div class="form-check">
                        <input type="radio" name="meta[participant_have_allergies]" value="yes" class="form-check-input" {{ issetKey( $meta, 'participant_have_allergies', '' ) == 'yes' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Yes</label>
                        <input type="radio" name="meta[participant_have_allergies]" value="no" class="form-check-input" {{ issetKey( $meta, 'participant_have_allergies', '' ) == 'no' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">No</label>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-4">
                     <label>If Yes Please  Specify :</label>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::text('meta[participant_specify_allergies]', '', issetKey( $meta, 'participant_specify_allergies', '' ))
                     ->id('participant_specify_allergies')
                     !!}
                  </div>
               </div>
               <div class="form-group ">
                  <label for="employer">Are you currently on Medication? </label>
                  <div class="form-check-custom">
                     <div class="form-check">
                        <input type="radio" name="meta[participant_is_medication]" value="yes" class="form-check-input" {{ issetKey( $meta, 'participant_is_medication', '' ) == 'yes' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Yes</label>
                        <input type="radio" name="meta[participant_is_medication]" value="no" class="form-check-input" {{ issetKey( $meta, 'participant_is_medication', '' ) == 'no' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">No</label>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-4">
                     <label>If Yes Please Specify the medication that you are on :</label>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::text('meta[participant_specify_medication]', '', issetKey( $meta, 'participant_specify_medication', '' ))
                     ->id('participant_specify_medication')
                     !!}
                  </div>
               </div>
               <div class="form-group ">
                  <label for="employer">Does the Participant have any other medical  requirements your support worker, Allied Health , and the Approved Provider need to know of </label>
                  <div class="form-check-custom">
                     <div class="form-check">
                        <input type="radio" name="meta[participant_have_other_medical_req]" name="yes" class="form-check-input" {{ issetKey( $meta, 'participant_have_other_medical_req', '' ) == 'yes' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Yes</label>
                        <input type="radio" name="meta[participant_have_other_medical_req]" name="no" class="form-check-input" {{ issetKey( $meta, 'participant_have_other_medical_req', '' ) == 'no' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">No</label>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-4">
                     <label>If Yes Please  Specify</label>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::text('meta[participant_specify_other_medical_req]', '', issetKey( $meta, 'participant_specify_other_medical_req', '' ))
                     ->id('participant_specify_other_medical_req')
                     !!}
                  </div>
               </div>
            </div>
            <div class="service-required">
               <div class="form-group ">
                  <h4>SERVICES REQUIRED</h4>
                  <label>Please  refer to your Approved NDIS plan, and  tick the services  that you require:</label>
               </div>
               <div class="form-group ">
                  <label for="employer">Group</label>
               </div>
               <div class="form-group ">
                  <label for="employer">1 Ex Phys Personal Training</label>
                  <div class="form-check-custom">
                     <div class="form-check">
                        <input type="radio" name="meta[participant_service_req_personal_training]" value="yes" class="form-check-input" {{ issetKey( $meta, 'participant_service_req_personal_training', '' ) == 'yes' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Yes</label>
                        <input type="radio" name="meta[participant_service_req_personal_training]" value="no" class="form-check-input" {{ issetKey( $meta, 'participant_service_req_personal_training', '' ) == 'no' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">No</label>
                     </div>
                  </div>
               </div>
               <div class="form-group ">
                  <label for="employer">2 Innov.  Community Participation</label>
                  <div class="form-check-custom">
                     <div class="form-check">
                        <input type="radio" name="meta[participant_service_req_community_participant]" value="yes" class="form-check-input" {{ issetKey( $meta, 'participant_service_req_community_participant', '' ) == 'yes' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Yes</label>
                        <input type="radio" name="meta[participant_service_req_community_participant]" value="no" class="form-check-input" {{ issetKey( $meta, 'participant_service_req_community_participant', '' ) == 'no' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">No</label>
                     </div>
                  </div>
               </div>
               <div class="form-group ">
                  <label for="employer">3 Accommodation/Tenancy</label>
                  <div class="form-check-custom">
                     <div class="form-check">
                        <input type="radio" name="meta[participant_service_req_accommodation]" value="yes" class="form-check-input" {{ issetKey( $meta, 'participant_service_req_accommodation', '' ) == 'yes' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Yes</label>
                        <input type="radio" name="meta[participant_service_req_accommodation]" value="no" class="form-check-input" {{ issetKey( $meta, 'participant_service_req_accommodation', '' ) == 'no' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">No</label>
                     </div>
                  </div>
               </div>
               <div class="form-group ">
                  <label for="employer">4 Assistive Prod-Household Task</label>
                  <div class="form-check-custom">
                     <div class="form-check">
                        <input type="radio" name="meta[participant_service_req_assistive_task]" value="yes" class="form-check-input" {{ issetKey( $meta, 'participant_service_req_assistive_task', '' ) == 'yes' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Yes</label>
                        <input type="radio" name="meta[participant_service_req_assistive_task]" value="no" class="form-check-input" {{ issetKey( $meta, 'participant_service_req_assistive_task', '' ) == 'no' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">No</label>
                     </div>
                  </div>
               </div>
               <div class="form-group ">
                  <label for="employer">5 Home  Modification</label>
                  <div class="form-check-custom">
                     <div class="form-check">
                        <input type="radio" name="meta[participant_service_req_home_modification]" value="yes" class="form-check-input" {{ issetKey( $meta, 'participant_service_req_home_modification', '' ) == 'yes' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Yes</label>
                        <input type="radio" name="meta[participant_service_req_home_modification]" value="no" class="form-check-input" {{ issetKey( $meta, 'participant_service_req_home_modification', '' ) == 'no' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">No</label>
                     </div>
                  </div>
               </div>
               <div class="form-group ">
                  <label for="employer">6 Therapeutic Supports</label>
                  <div class="form-check-custom">
                     <div class="form-check">
                        <input type="radio" name="meta[participant_service_req_therapeutic_support]" value="yes" class="form-check-input" {{ issetKey( $meta, 'participant_service_req_therapeutic_support', '' ) == 'yes' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Yes</label>
                        <input type="radio" name="meta[participant_service_req_therapeutic_support]" value="no" class="form-check-input" {{ issetKey( $meta, 'participant_service_req_therapeutic_support', '' ) == 'no' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">No</label>
                     </div>
                  </div>
               </div>
               <div class="form-group ">
                  <label for="employer">7 Plan Management</label>
                  <div class="form-check-custom">
                     <div class="form-check">
                        <input type="radio" name="meta[participant_service_req_plan_management]" value="yes" class="form-check-input" {{ issetKey( $meta, 'participant_service_req_plan_management', '' ) == 'yes' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Yes</label>
                        <input type="radio" name="meta[participant_service_req_plan_management]" value="no" class="form-check-input" {{ issetKey( $meta, 'participant_service_req_plan_management', '' ) == 'no' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">No</label>
                     </div>
                  </div>
               </div>
               <div class="form-group ">
                  <label for="employer">8 Assist  Prod-Pers Care/Safety</label>
                  <div class="form-check-custom">
                     <div class="form-check">
                        <input type="radio" name="meta[participant_service_req_assist_care]" value="yes" class="form-check-input" {{ issetKey( $meta, 'participant_service_req_assist_care', '' ) == 'yes' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Yes</label>
                        <input type="radio" name="meta[participant_service_req_assist_care]" value="no" class="form-check-input" {{ issetKey( $meta, 'participant_service_req_assist_care', '' ) == 'no' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">No</label>
                     </div>
                  </div>
               </div>
               <div class="form-group ">
                  <label for="employer">9 Assist-Travel/Transport</label>
                  <div class="form-check-custom">
                     <div class="form-check">
                        <input type="radio" name="meta[participant_service_req_assist_travel]" value="yes" class="form-check-input" {{ issetKey( $meta, 'participant_service_req_assist_travel', '' ) == 'yes' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Yes</label>
                        <input type="radio" name="meta[participant_service_req_assist_travel]" value="no" class="form-check-input" {{ issetKey( $meta, 'participant_service_req_assist_travel', '' ) == 'no' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">No</label>
                     </div>
                  </div>
               </div>
               <div class="form-group ">
                  <label for="employer">10 Household Tasks</label>
                  <div class="form-check-custom">
                     <div class="form-check">
                        <input type="radio" name="meta[participant_service_req_household_tasks]" value="yes" class="form-check-input" {{ issetKey( $meta, 'participant_service_req_household_tasks', '' ) == 'yes' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Yes</label>
                        <input type="radio" name="meta[participant_service_req_household_tasks]" value="no" class="form-check-input" {{ issetKey( $meta, 'participant_service_req_household_tasks', '' ) == 'no' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">No</label>
                     </div>
                  </div>
               </div>
               <div class="form-group ">
                  <label for="employer">11 Vision  Equipment</label>
                  <div class="form-check-custom">
                     <div class="form-check">
                        <input type="radio" name="meta[participant_service_req_vision_equipment]" value="yes" class="form-check-input" {{ issetKey( $meta, 'participant_service_req_vision_equipment', '' ) == 'yes' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Yes</label>
                        <input type="radio" name="meta[participant_service_req_vision_equipment]" value="no" class="form-check-input" {{ issetKey( $meta, 'participant_service_req_vision_equipment', '' ) == 'no' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">No</label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="office-use">
               <div class="form-group ">
                  <h4>OFFICIAL USE ONLY</h4>
               </div>
               <div class="form-group ">
                  <label for="employer">Has the enrolment  form been completed</label>
                  <div class="form-check-custom">
                     <div class="form-check">
                        <input type="radio" name="meta[office_has_enrolment]" value="yes"  class="form-check-input" {{ issetKey( $meta, 'office_has_enrolment', '' ) == 'yes' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Yes</label>
                        <input type="radio" name="meta[office_has_enrolment]" value="no" class="form-check-input" {{ issetKey( $meta, 'office_has_enrolment', '' ) == 'no' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">No</label>
                     </div>
                  </div>
               </div>
               <div class="form-group ">
                  <label for="employer">Has the participant completed the Medical Assessment form by the GP</label>
                  <div class="form-check-custom">
                     <div class="form-check">
                        <input type="radio" name="meta[office_has_participant_completed_mdeical]" value="yes" class="form-check-input" {{ issetKey( $meta, 'office_has_participant_completed_mdeical', '' ) == 'yes' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Yes</label>
                        <input type="radio" name="meta[office_has_participant_completed_mdeical]" value="no" class="form-check-input" {{ issetKey( $meta, 'office_has_participant_completed_mdeical', '' ) == 'no' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">No</label>
                     </div>
                  </div>
               </div>
               <div class="form-group ">
                  <label for="employer">Has the Participant provided l00 points of ID</label>
                  <div class="form-check-custom">
                     <div class="form-check">
                        <input type="radio" name="meta[office_has_participant_provided_points]" value="yes" class="form-check-input" {{ issetKey( $meta, 'office_has_participant_provided_points', '' ) == 'yes' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">Yes</label>
                        <input type="radio" name="meta[office_has_participant_provided_points]" value="no" class="form-check-input" {{ issetKey( $meta, 'office_has_participant_provided_points', '' ) == 'no' ? 'checked' : '' }} >
                        <label class="form-check-label" for="exampleCheck1">No</label>
                     </div>
                  </div>
               </div>
            </div>
            {!! Form::submit('Submit')->attrs(["class"=>"rounded mt-40"]) !!}
         </form>
         {{-- fourth 9th PARTICIPANT Report Form end here--}} 
      </div>
   </div>
</div>
</div>
</div>
@endsection