@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-body">
      {{-- one advocate authorty Form start here --}}
      <form action="{{ route($formAction[0],$formAction[1]) }}" method="POST" class="validated" enctype="multipart/form-data">
         @csrf
         @if(!empty($formAction[1]))
         @method('PUT')        
         @endif
         <input type="hidden" name="template_id" value="1">
         <input type="hidden" name="user_id" value='{{$participant->user_id}}'>
         <input type="hidden" name="participant_controller" value='{{$participantController}}'>
         <div class="operational-form-design">
            <div class="authority-section">
               <div class="card-header">
                  <h2>AUTHORITY TO ACT AS AN ADVOCATE</h2>
               </div>
               <div class="row">
                  <div class="label col-sm-4">
                     <div class="form-group">
                        <label>{{trans('opforms.fields.first_name')}}</label>
                     </div>
                  </div>
                  <div class="label col-sm-8">
                     {!! 
                     Form::text('participant_first_name', '', $participant->first_name )
                     ->id('client_first_name')
                     ->readonly($readOnly)
                     ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Participant first name requried" ])
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="label col-sm-4">
                     <div class="form-group">
                        <label> {{trans('opforms.fields.last_name')}}</label>
                     </div>
                  </div>
                  <div class="label col-sm-8">
                     {!! 
                     Form::text('participant_last_name', '', $participant->last_name )
                     ->id('participant_last_name')
                     // ->required('required')
                     ->readonly($readOnly)
                     ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Participant last name requried" ])
                     ->hideLabel()
                     ->help(trans('global.user.fields.name_helper'))
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="label col-sm-4">
                     <div class="form-group">
                        <label> {{ trans('opforms.fields.address')}}</label>
                     </div>
                  </div>
                  <div class="label col-sm-8">
                     {!! 
                     Form::location('meta[participant_address]', 
                     '', 
                     valOrAlt( $meta, 'participant_address', $participant, 'address' ),
                     valOrAlt( $meta, 'participant_lat', $participant, 'lat' ),
                     valOrAlt( $meta, 'participant_lng', $participant, 'lng' )
                     )
                     ->id('participant_address')
                     ->locationLatName('meta[participant_lat]')
                     ->locationLngName('meta[participant_lng]')
                     // ->required('required')
                     ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Participant address requried" ])
                     ->hideLabel()
                     ->help(trans('global.user.fields.name_helper'))
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="label col-sm-4">
                     <div class="form-group">
                        <label> {{trans('opforms.fields.phone')}}</label>
                     </div>
                  </div>
                  <div class="label col-sm-8">
                     {!! 
                     Form::text('meta[participant_phone]', '', valOrAlt( $meta, 'participant_phone', $participant, 'mobile' ) )
                     ->id('client_phone')
                     ->attrs([
                     "required"=>"required",
                     "data-rule-required"=>"true",
                     "data-msg-required"=>"Please enter your mobile number",
                     "data-rule-minlength"=>"10",
                     "data-rule-number" => "true",
                     "data-msg-minlength"=>"Mobile number should be 10 digits minimum"
                     ])
                     // ->help(trans('global.user.fields.name_helper'))
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="label col-sm-4">
                     <div class="form-group">
                        <label> {{trans('opforms.fields.involvement')}}</label>
                     </div>
                  </div>
                  <div class="label col-sm-8">
                     {!! 
                     Form::text('meta[involvement_auth]', '', issetKey( $meta, 'involvement_auth', '' ) )
                     ->id('involvement')
                     // ->required('required')
                     ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Guardian name required" ])
                     ->hideLabel()
                     ->help(trans('global.user.fields.name_helper'))
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="label col-sm-4">
                     <div class="form-group">
                        <div class="form-group {{ $errors->has('services') ? 'has-error' : '' }}">
                           <label for="services">I understand that the service may discuss details of my plan of care and services with my advocate if the need arises.</label>
                        </div>
                        <div class="form-group {{ $errors->has('services') ? 'has-error' : '' }}">
                           <label for="date">This authority is to take effect from Date:</label>
                        </div>
                        <div class="form-group {{ $errors->has('services') ? 'has-error' : '' }}">
                           <label for="change-writting">This replaces any previously advised arrangements. I understand that I can change my choice of advocate at any time and undertake to advise the service of any such change in writing.</label>
                        </div>
                     </div>
                  </div>
                  <div class="label col-sm-8">
                     @if(isset($meta['client_signature']))
                     <img alt="client_signature" src="{{ $meta['client_signature'] }}" />
                     @else
                     @include('template.sign_pad', [ 'id' => 'client_signature', 'user_id'=>$participant->id, 'name'=>'meta[client_signature]', 'label' => 'Client Signature (<span>'.$participant->getName().'</span>)' ])
                     @endif
                  </div>
               </div>
               <div class="row">
                  <div class="label col-sm-4">
                     <div class="form-group">
                        <label> {{trans('bookings.fields.date')}}</label>
                     </div>
                  </div>
                  <div class="label col-sm-8">
                     {!! 
                     Form::date('meta[client_signature_date]', '', old('client_signature_date', isset($meta['client_signature_date']) ? $meta['client_signature_date'] : date('d-m-Y')))
                     ->id('date-1')
                     // ->required('required')
                     ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Signature date required" ])
                     ->hideLabel()
                     ->help(trans('bookings.fields.date_helper'))
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="label col-sm-4">
                     <div class="form-group">
                        <label> {{trans('opforms.fields.advocate_name')}}</label>
                     </div>
                  </div>
                  <div class="label col-sm-8">
                     {!!
                     Form::text('meta[advocate_name]', '', issetKey( $meta, 'advocate_name', '' ) )
                     ->id('advocate_name')
                     // ->required('required')
                     ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Advocate name required" ])
                     ->hideLabel()
                     ->help(trans('global.user.fields.name_helper'))
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="label col-sm-4">
                     <div class="form-group">
                        <label> {{ trans('opforms.fields.advocate_address')}}</label>
                     </div>
                  </div>
                  <div class="label col-sm-8">
                     {!! 
                     Form::location(
                        'meta[advocate_address]',  '',
                        issetKey( $meta, 'advocate_address', '' ),
                        issetKey( $meta, 'advocate_lat', '' ),
                        issetKey( $meta, 'advocate_lng','' )
                     )
                     ->id('advocate_address')
                     ->locationLatName('meta[advocate_lat]')
                     ->locationLngName('meta[advocate_lng]')
                     ->required('required')
                     ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Participant address requried" ])
                     ->hideLabel()
                     ->help(trans('global.user.fields.name_helper'))
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="label col-sm-4">
                     <div class="form-group">
                        <label> {{trans('opforms.fields.advocate_phone')}}</label>
                     </div>
                  </div>
                  <div class="label col-sm-8">
                     {!! 
                     Form::text('meta[advocate_phone]','', issetKey( $meta, 'advocate_phone', '' ) )
                     ->id('advocate_phone')
                     // ->required('required')
                     ->attrs([
                     "required"=>"required",
                     "data-rule-required"=>"true",
                     "data-msg-required"=>"Please enter your mobile number",
                     "data-rule-minlength"=>"10",
                     "data-rule-number" => "true",
                     "data-msg-minlength"=>"Mobile number should be 10 digits minimum"
                     ])
                     ->hideLabel()
                     ->help(trans('global.user.fields.name_helper'))
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="label col-sm-4">
                     <div class="form-group">
                        <label> {{trans('opforms.fields.advocate_mobile')}}</label>
                     </div>
                  </div>
                  <div class="label col-sm-8">
                     {!! 
                     Form::text('meta[advocate_mobile]', '', issetKey( $meta, 'advocate_mobile', '' ) )
                     ->id('advocate_mobile')
                     ->attrs([
                     "required"=>"required",
                     "data-rule-required"=>"true",
                     "data-msg-required"=>"Please enter your mobile number",
                     "data-rule-minlength"=>"10",
                     "data-rule-number" => "true",
                     "data-msg-minlength"=>"Mobile number should be 10 digits minimum"
                     ])
                     ->hideLabel()
                     ->help(trans('global.user.fields.name_helper'))
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="label col-sm-4">
                     <div class="form-group">
                        <label> {{trans('opforms.fields.advocate_email')}}</label>
                     </div>
                  </div>
                  <div class="label col-sm-8">
                     {!! 
                     Form::text('meta[advocate_email]', '', issetKey( $meta, 'advocate_email', '' ) )
                     ->id('advocate_email')
                     ->attrs([
                     "data-rule-required"=>"true",
                     "data-rule-email"=>"true", 
                     "data-msg-required"=>trans('errors.register.email'),
                     "data-msg-email"=>trans('errors.register.email_format')
                     ])
                     ->hideLabel()
                     ->help(trans('global.user.fields.name_helper'))
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="label col-sm-4">
                     <div class="form-group">
                        <div class="form-group {{ $errors->has('named-client') ? 'has-error' : '' }}">
                           <label for="named-client">I have read the 'Guidelines for Advocates' and agree to act as an advocate for the above named client.</label>
                        </div>
                     </div>
                  </div>
                  <div class="label col-sm-8">
                     @if(isset($meta['advocate_signature']))
                     <img alt="advocate_signature" src="{{ $meta['advocate_signature'] }}" />
                     @else
                     @include('template.sign_pad', [ 'id' => 'advocate_signature', 'user_id'=>0, 'name'=>'meta[advocate_signature]', 'label' => 'Advocate Signature' ]) 
                     @endif
                  </div>
               </div>
               <div class="row">
                  <div class="label col-sm-4">
                     <div class="form-group">
                        <label> {{ trans('bookings.fields.date')}}</label>
                     </div>
                  </div>
                  <div class="label col-sm-8">
                     {!! 
                     Form::date('meta[advocate_date]','', old('advocate_date', isset($meta['advocate_date']) ? $meta['advocate_date'] : date('d-m-Y')))
                     ->id('date-2')
                     // ->required('required')
                     ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Advocate signature date required" ])
                     ->hideLabel()
                     ->help(trans('bookings.fields.date_helper'))
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="label col-sm-4">
                     <div class="form-group">
                        <label> {{trans('opforms.fields.advocate_authority')}}</label>
                     </div>
                  </div>
                  <div class="label col-sm-8">
                     {!! 
                     Form::textarea('meta[advocate_authority]', '',  old('advocate_authority', isset($meta['advocate_authority']) ? ($meta['advocate_authority']) : ''))
                     !!}
                  </div>
               </div>
            </div>
            <div class="authority-section">
               <div class="below-form">
                  <h3>GUIDELINES FOR ADVOCATES</h3>
                  <div class="row">
                     <div class="label col-sm-4">
                        <div class="form-group">
                           <label> {{trans('opforms.fields.being_an_advocate')}}</label>
                        </div>
                     </div>
                     <div class="label col-sm-8">
                        {!! 
                        Form::text('meta[being_an_advocate]', '',  old('being_an_advocate', isset($meta['being_an_advocate']) ? ($meta['being_an_advocate']) : ''))
                        ->id('being_an_advocate')
                        !!}
                     </div>
                  </div>
                  <div class="form-group {{ $errors->has('Being-form') ? 'has-error' : '' }}">
                     <label><strong>{{$participant->getName()}}</strong> has asked you to be their advocate, which means they would like you to act on their behalf in their dealings with the service. 
                     You may be a family member or friend of the client or a member of an advocacy service.</label>
                  </div>
                  <div class="form-group {{ $errors->has('Being-form') ? 'has-error' : '' }}">
                     <label>Being an advocate may mean your attendance or involvement will be required during assessments and reviews of the client's situation 
                     and services received, or if the client wishes to communicate or negotiate anything with the service or lodge a complaint about the service.</label>
                  </div>
                  <div class="form-group {{ $errors->has('Being-form') ? 'has-error' : '' }}">
                     <label>We ask our clients to complete an 'Authority to Act as an Advocate Form' when they wish to appoint or change their advocate. Clients are free to change their advocates 
                     whenever they wish, however we request a new authority form be completed each time so that service staff are always clear about who the client's advocate is. </label>
                  </div>
                  <div class="form-group {{ $errors->has('Being-form') ? 'has-error' : '' }}">
                     <label>As an advocate of a client we ask you to be aware of the following and ensure that:</label>
                     <ul>
                        <li>
                           <label> The client has given their written authority for you to act as their advocate</label>
                        </li>
                        <li>
                           <label>The service is aware that you are acting as the client's advocate</label>
                        </li>
                        <li>
                           <label>You always act in the best interests of the client</label>
                        </li>
                        <li>
                           <label> The client is aware of any issues and developments in relation to the services they receive and which you, as their advocate,  may be involved in</label>
                        </li>
                        <li>
                           <label> The client is kept informed of any developments</label>
                        </li>
                        <li>
                           <label>You are familiar with the contents of the Client's Handbook and the details of the client's care plan</label>
                        </li>
                        <li>
                           <label>You encourage the client to provide feedback to you about the services they are receiving</label>
                        </li>
                        <li>
                           <label>You advise the service about any changes in client circumstances and any concerns about changing client needs</label>
                        </li>
                        <li>
                           <label> You are prepared to relinquish the role of advocate should the client wish this.</label>
                        </li>
                     </ul>
                     <p class="helper-block">
                        {{ trans('global.user.fields.name_helper') }}
                     </p>
                  </div>
               </div>
            </div>
         </div>
         {!! Form::submit('Submit')->attrs(["class"=>"rounded"]) !!}
   </div>
   </form>
   {{-- one advocate authorty Form end here--}}
</div>
</div>
@endsection
@section('scripts')
@parent
<script>
   //  $(document).ready(function() {
    
   //  });
    
</script>
@endsection