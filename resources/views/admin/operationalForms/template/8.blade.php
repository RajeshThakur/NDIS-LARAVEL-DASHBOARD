@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-body">
      <div class="operational-form-design">
         {{-- 8th incident-report form start here--}}
         <form action="{{ route($formAction[0],$formAction[1]) }}" method="POST" class="validated" enctype="multipart/form-data">
            @csrf
            @if(!empty($formAction[1]))
            @method('PUT')        
            @endif
            <div class="card-header">
               <h2>Incident Report Form</h2>
            </div>
            <input type="hidden" name="template_id" value="8">
            <input type="hidden" name="user_id" value='{{$participant->user_id}}'>
            <div class="authority-section">
               <div class="form-group">
                  <h3>Incident Report Form</h3>
               </div>
               <div class="form-group">
                  <h4>An incident can be defined as</h4>
               </div>
               <div class="below-form">
                  <ul>
                     <li>
                        <div class="form-group ">
                           <label> any injury to a  person,  or</label>
                        </div>
                     </li>
                     <li>
                        <div class="form-group">
                           <label>damage to plant or  property,  or</label>
                        </div>
                     </li>
                     <li>
                        <div class="form-group">
                           <label>a "near-miss" where there  was potential  for injury  or damage.</label>
                        </div>
                     </li>
                  </ul>
                  <div class="form-group">
                     <h4>What is an Incident Report Form used for?</h4>
                  </div>
                  <div class="form-group">
                     <label>It is important to develop a strong culture of incident reporting, no matter how minor, as all reported incidents
                     should be used as valuable lessons in how to prevent a recurrence.</label>
                  </div>
                  <div class="form-group">
                     <label>An investigation should concentrate on identifying what actions or events led to the incident, and to identify strategies 
                     to ensure that the incident is addressed and controlled. Outcomes of investigations will strengthen the safety systems and methods of work within a company.
                     </label>
                  </div>
                  <div class="form-group">
                     <label>Information to be completed on an Incident Report Form is:</label>
                     <ul>
                        <li>
                           <div class="form-group">
                              <label>What was the Incident/near miss?</label>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <label>Where there any injuries? (Note: Any injuries require an Accident Report Form to be completed)</label>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <label>Was there any damage to property or plant?</label>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <label>
                              What caused the incident?  (List what factors you feel led to the incident.Possible causes are, lack of training, 
                              ineffective guarding, poor system of work, miscommunication, poor housekeeping, lack of maintenance, or inexperience.)
                              </label>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <label>
                              What actions will be taken to eliminate future repeats of the incident? Look at adopting  the "Hierarchy  
                              of Control" method  to decide what action  to take to prevent the  incident  happening  again
                              </label>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <label>
                              Management comments.
                              </label>
                           </div>
                        </li>
                     </ul>
                  </div>
                  <div class="form-group">
                     <h4>Management must ensure that the incident:</h4>
                  </div>
                  <div class="form-group">
                     <ul>
                        <li>
                           <div class="form-group">
                              <label>has  been discussed  with  all  parties  involved</label>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <label>has  been controlled  to a  level  acceptable  by  all  parties  involved</label>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <label>has  not created  any  new  issues</label>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <label>
                              can be considered  as controlled  and  able to be signed off as closed
                              </label>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
            <div class="authority-section">
               <div class="incident-report">
                  <div class="form-group">
                     <h4>Incident report form</h4>
                  </div>
                  <div class="row">
                     <div class="col-sm-4">
                        <label>  {{trans('opforms.fields.job')}}</label>
                     </div>
                     <div class="col-sm-8">
                        {!! 
                        Form::text('meta[job]', '', issetKey( $meta, 'job', '' ))
                        ->id('job')
                        ->help(trans('global.user.fields.name_helper')) 
                        !!}
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-4">
                        <label>  {{trans('opforms.fields.date')}}</label>
                     </div>
                     <div class="col-sm-8">
                        {!! 
                        Form::date('meta[date_of_incident]', '', old('date_of_incident', isset($meta['date_of_incident']) ? $meta['date_of_incident'] : date('d-m-Y')))
                        ->id('date-1')
                        ->required('required')
                        ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Date of incident required" ])
                        ->help(trans('lobal.user.fields.name_helper'))
                        !!}
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-4">
                        <label>  {{trans('opforms.fields.incident_time')}}</label>
                     </div>
                     <div class="col-sm-8">
                        {!! 
                        Form::time('meta[incident_time]', '', old('incident_time', isset($meta['incident_time']) ? $meta['incident_time'] : ''))
                        ->id('time-1')
                        ->help(trans('global.user.fields.name_helper')) 
                        !!}
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-4">
                        <label>  {{ trans('opforms.fields.incident_details')}}</label>
                     </div>
                     <div class="col-sm-8">
                        {!! 
                        Form::textarea('meta[incident_details]', '', issetKey( $meta, 'incident_details', '' ))
                        !!}
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-4">
                        <label>  {{  trans('opforms.fields.any_injuries')}}</label>
                     </div>
                     <div class="col-sm-8">
                        {!! 
                        Form::textarea('meta[any_injuries]','', issetKey( $meta, 'any_injuries', '' ))
                        !!}
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-4">
                        <label>  {{  trans('opforms.fields.any_damage')}}</label>
                     </div>
                     <div class="col-sm-8">
                        {!! 
                        Form::textarea('meta[any_damage]', '', issetKey( $meta, 'any_damage', '' ))
                        !!}
                     </div>
                  </div>
               </div>
               <div class="incident-report">
                  <div class="form-group">
                     <h4>Incident report form</h4>
                  </div>
                  <div class="row">
                     <div class="col-sm-4">
                        <label>  {{ trans('opforms.fields.cause_of_incident')}}</label>
                     </div>
                     <div class="col-sm-8">
                        {!! 
                        Form::textarea('meta[cause_of_incident]', '', issetKey( $meta, 'cause_of_incident', '' ))
                        !!}
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-4">
                        <label>  {{trans('opforms.fields.actions_to_eliminate')}}</label>
                     </div>
                     <div class="col-sm-8">
                        {!! 
                        Form::textarea('meta[actions_to_eliminate]', '', issetKey( $meta, 'actions_to_eliminate', '' ))
                        !!}
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-4">
                        <label>  {{trans('opforms.fields.management_comments')}}</label>
                     </div>
                     <div class="col-sm-8">
                        {!! 
                        Form::textarea('meta[management_comments]', '', issetKey( $meta, 'management_comments', '' ))
                        !!}
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-4">
                        <div class="form-group {{ $errors->has('Time') ? 'has-error' : '' }}">
                           <label for="incident" style="margin:48px 0px;">Signed off by management when corrective actions have been adopted and monitored.</label>
                        </div>
                     </div>
                     <div class="col-sm-8">
                        @if(isset($meta['management_sign']))
                        <img alt="management_sign" src="{{ $meta['management_sign'] }}" />
                        @else
                        @include('template.sign_pad', [ 'id' => 'management_sign', 'user_id'=>0, 'name'=>'meta[management_sign]', 'label' => 'Management Signature' ]) 
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="row">
                        <div class="col-sm-4">
                           {{trans('opforms.fields.date_of_sign')}}
                        </div>
                        <div class="col-sm-8">
                           {!! 
                           Form::date('meta[date_of_sign]', '', old('date_of_sign', isset($meta['date_of_sign']) ? $meta['date_of_sign'] : date('d-m-Y')))
                           ->id('date-2')
                           ->required('required')
                           ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Management Signature date required" ])
                           ->help(trans('lobal.user.fields.name_helper'))
                           !!}
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            {!! Form::submit('Submit')->attrs(["class"=>"rounded"]) !!}
         </form>
         {{-- 8th incident-report form end here--}}
      </div>
   </div>
</div>
@endsection