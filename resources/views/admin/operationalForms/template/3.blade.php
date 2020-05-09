@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-body">
      <div class="operational-form-design">
         {{-- 3rd client sppprot form start here--}}
         <form action="{{ route($formAction[0],$formAction[1]) }}" method="POST" class="validated" enctype="multipart/form-data">
            @csrf
            @if(!empty($formAction[1]))
            @method('PUT')        
            @endif
            <div class="card-header">
               <h2>Client Consent Form</h2>
            </div>
            <input type="hidden" name="template_id" value="3">
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
                  Form::text('client_consent_details', '', old('client_full_name', $participant->getName() ) )
                  ->id('client_consent_details')
                  ->hideLabel()
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="below-form">
               <div class="form-group {{ $errors->has('Being-form') ? 'has-error' : '' }}">
                  <label> (client/carer/advocate name) consent to information relevant to the care I receive being made available as outlined below:</label>
               </div>
               <ul>
                  <li>
                     <div class="form-group">
                        <label>I understand that  the  following   service(s)   are  recommended   and   relevant information  about  me  may 
                        be  forwarded  to  the  agency(s)  
                        that  provide  these services,  in order that I    receive the best possible service:</label>
                     </div>
                  </li>
                  <li class="help-block">
                     <div class="form-group">
                        {{-- <label>(Insert names of third parties as agreed with client.)</label> --}}
                        {!! 
                           Form::text('meta[third_party_name]', '',  old('third_party_name', isset($meta['third_party_name']) ? ($meta['third_party_name']) : ''))
                           ->attrs(["class"=>"custom-inserttext-color form-control"])
                           // ->placeholder('Insert names of third parties as agreed with client.')
                           ->id('third_party_name')
                        !!}
                        {{-- <input class="custom-inserttext-color form-control" type="text" placeholder="Insert names of third parties as agreed with client."> --}}
                     </div>
                  </li>
                  <li>
                     <div class="form-group">
                        <label>I understand that the service must comply with relevant privacy laws and I will contact the organization immediately if I feel that 
                        these laws have been breached.</label>
                     </div>
                  </li>
                  <li>
                     <div class="form-group">
                        <label>My worker has discussed with me how and why certain information about me may need to be provided to other service providers.</label>
                     </div>
                  </li>
                  <li>
                     <div class="form-group">
                        <label>I understand that recommendation and I give my permission for the information to be shared with the people or agencies as detailed above.</label>
                     </div>
                  </li>
               </ul>
               <div class="signature-paid">
                  <div class="row">
                     <div class="label col-sm-4">
                        <div class="form-group">
                           <label>Representative Signature</label>
                        </div>
                     </div>
                     <div class="label col-sm-8">
                        @if(isset($meta['client_signature_form']))
                        <img alt="client_signature_form" src="{{ $meta['client_signature_form'] }}" />
                        @else
                        @include('template.sign_pad', [ 'id' => 'client_signature_form', 'user_id'=>$participant->id, 'name'=>'meta[client_signature_form]', 'label' => 'Representative Signature' ])
                        @endif
                     </div>
                  </div>
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
                              Form::date('meta[client_signature_date]','', old('client_signature_date', isset($meta['client_signature_date']) ? $meta['client_signature_date'] : date('d-m-Y')))
                              ->id('date-1')
                              // ->required('required')
                              ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Client signature date reqired" ])
                              ->hideLabel()
                              ->help(trans('global.user.fields.name_helper'))
                              !!}
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="signature-paid">
                  <div class="row">
                     <div class="label col-sm-4">
                        <div class="form-group">
                           <label>Staff Member Signature</label>
                        </div>
                     </div>
                     <div class="label col-sm-8">
                        @if(isset($meta['staff_member_signature']))
                        <img alt="staff_member_signature" src="{{ $meta['staff_member_signature'] }}" />
                        @else
                        @include('template.sign_pad', [ 'id' => 'staff_member_signature', 'user_id'=>$participant->id, 'name'=>'meta[staff_member_signature]', 'label' => 'Staff Member Signature' ])
                        @endif
                     </div>
                  </div>
                  <div class="col-sm-12 pl-0">
                     <div class="form-customs participent-two form-group">
                        <div class="row">
                           <div class="label col-sm-4">
                              <div class="form-group">
                                 <label>{{  trans('opforms.fields.date')}}</label>
                              </div>
                           </div>
                           <div class="label col-sm-8">
                              {!! 
                              Form::date('meta[staff_member_signature_date]','', old('staff_member_signature_date', isset($meta['staff_member_signature_date']) ? $meta['staff_member_signature_date'] : date('d-m-Y')))
                              ->id('date-2')
                              // ->required('required')
                              ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Staff signature date reqired" ])
                              ->hideLabel()
                              ->help(trans('global.user.fields.name_helper'))
                              !!}
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            {!! Form::submit('Submit')->attrs(["class"=>"rounded"]) !!}
         </form>
         {{-- client sppprot form end here--}}
      </div>
   </div>
</div>
@endsection