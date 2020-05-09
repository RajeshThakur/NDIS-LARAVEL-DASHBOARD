
{{-- 11th SERVICE AGREEMENT Form start here--}}
   <div class="operational-form-design">
      <form action="{{ route($formAction[0],$formAction[1]) }}" method="POST" enctype="multipart/form-data">
         @csrf
         @if(!empty($formAction[1]))
            @method('PUT')
         @endif

         <div class="service-agreementt">
            <div class="form-group">
               <h2>{!! trans('opforms.fields.ndis_service_agreement') !!}</h2>
            </div>
            <input type="hidden" name="meta[form_title]" value="NDIS Service Agreement">
            <input type="hidden" name="template_id" value="11">
            <input type="hidden" name="user_id" value='{{$participant->user_id}}'>
            <input type="hidden" name="participant_controller" value='{{$participantController}}'>
            <div class="below-form">
               <div class="parties-section">
                  <div class="form-group">
                        <h3>{!! trans('opforms.fields.parties') !!}</h3>
                  </div>

                  {!!
                     Form::text('meta[service_agreement_with]', trans('opforms.fields.service_agreement_with'),  old('service_agreement_with', $participant->getName() ) )
                     ->id('participant_name')
                     ->readonly()   
                  !!}

                  {!!
                     Form::text('provider_name', trans('opforms.fields.provider_and_business'), old('provider_name', isset($provider->id) ? $provider->getName() : '') )
                     ->id('provider_name')
                     ->readonly()
                  !!}

                  {!! 
                     Form::text('practice_details', trans('opforms.fields.practice_details'), old('practice_details', isset($participant->practice_details) ? $participant->practice_details : '') )
                     ->id('practice_details')
                  !!}

               </div>

               <div class="Summary-section serviceagreement-additional">
                  <div class="row">
                     <label>{!! trans('opforms.fields.agreement_commence_on') !!}<span>
                        
                        </span>{!! trans('opforms.fields.for_period') !!}<span></label>
                           {!! 
                              Form::date('meta[aggrement_start_date]', trans('opforms.fields.date'), issetKey( $meta, 'aggrement_start_date', today()->toDateString() ) )
                                 ->id('aggrement_start_date')
                                 ->required('required')
                                 ->size('col-sm-6')
                                 ->help(trans('global.user.fields.name_helper'))
                           !!}
                        </span>

                        {!! 
                           Form::date('meta[aggrement_end_date]', trans('opforms.fields.date'), issetKey( $meta, 'aggrement_end_date', today()->toDateString() ) )
                              ->id('aggrement_end_date')
                              ->required('required')
                              ->size('col-sm-6')
                              ->help(trans('global.user.fields.name_helper'))
                        !!}

                        
                  <span class="center-text">To</span>
                  </div>
               </div>

               <div class="form-group">
                     <h3>{!! trans('opforms.fields.summary') !!}</h3>
               </div>

                  <div class="form-group service-agreement-red">
                  <label>This Service Agreement is made for the purpose of providing therapy services under the participant’s NDIS plan.</label>
                  </div>
                  <div class="form-group service-agreement-red">
                  <label>A copy of the participant’s NDIS plan is attached to this Service Agreement . </label>
                  </div>
                  <div class="form-group service-agreement-red">
                  <label>The parties agree that this Service Agreement is made in the context of the NDIS, which is a scheme that aims to:</label>
                  </div>
                  <div class="form-group service-agreement-red">
                     <ul>
                        <li><label>support the independence and social and economic participation of people with disability, and</label></li>
                     </ul>
                  </div>
                  <div class="form-group service-agreement-red">
                     <ul>
                        <li><label>support the independence and social and economic participation of people with disability, and</label></li>
                        <li><label>enable people with a disability to exercise choice and control in the pursuit of their goals and the planning and delivery of their supports.</label></li>
                     </ul>
                  </div>
               </div>
               <div class="Schedule of supports">
                  <div class="form-group service-agreement-red">
                        <h3>3. Schedule of supports</h3>
                  </div>
                  <div class="form-group service-agreement-red">
                  <label>The provider agrees to provide the participant therapy services for <span>[insert duration of services if applicable].</span>.</label>
                  </div>
                  <div class="form-group service-agreement-red">
                  <label>The supports and their prices are set out in the attached Schedule of Supports. All prices are GST inclusive (if applicable) and include the cost of providing the supports.</span>.</label>
                  </div>
               </div>
               <div class="responsible-section">
                  <div class="form-group">
                     
                        <h3>4. Responsibilities of Practice name</h3>
                     
                  </div>
                  <div class="form-group">
                     <label>Practice name agrees to:</label>
                  </div>
                  <div class="form-group">
                     <ul>
                        <li><label>review the provision of therapy services at each occasion of service with the participant </label></li>
                        <li><label>once agreed, provide therapy services that meet the participant’s needs at the participant’s preferred times </label></li>
                        <li><label>communicate openly and honestly in a timely manner </label></li>
                        <li><label>treat the participant with courtesy and respect</label></li>
                        <li><label>consult the participant on decisions about how treatment is provided </label></li>
                        <li><label>give the participant information about managing any complaints or disagreements and details of the provider’s cancellation policy (if relevant)</label></li>
                        <li><label>listen to the participant’s feedback and resolve problems quickly</label></li>
                        <li><label>give the participant a minimum of 24 hours’ notice if the provider has to change a scheduled appointment to provide therapy services </label></li>
                        <li><label>give the participant the required notice if the provider needs to end the Service Agreement (see ‘Ending this Service 
                           Agreement’ below for more information)</label></li>
                        <li><label>protect the participant’s privacy and confidential information</label></li>
                        <li><label>provide support in a manner consistent with all relevant laws, including the National Disability Insurance Scheme Act 2013 and rules, and the Australian
                           Consumer Law; keep accurate records on the supports provided to the participant</label></li>
                        <li><label>issue regular invoices and statements of the therapy services delivered to the participant as per the Terms of Business for Registered Providers. </label></li>
                     </ul>
                  </div>
               </div>
               <div class="responsible-section2">
                  <div class="form-group">
                     
                        <h3>5. Responsibilities of the participant/participant’s representative</h3>
                     
                  </div>
                  <div class="form-group">
                     <label>The participant/participant’s representative agrees to:</label>
                  </div>
                  <div class="form-group">
                     <ul>
                        <li><label>inform the provider about how they wish the therapy services to be delivered to meet the participant’s needs </label></li>
                        <li><label>treat the provider with courtesy and respect </label></li>
                        <li><label>talk to the provider if the participant has any concerns about the therapy services being provided</label></li>
                        <li><label>give the provider a minimum of 24 hours’ notice if the participant cannot make a scheduled appointment; and if the notice is not provided by then, the provider’s 
                           cancellation policy will apply</label></li>
                        <li><label>give the provider the required notice if the participant needs to end the Service Agreement (see ‘Ending this Service Agreement’ below
                           for more information), and</label></li>
                        <li><label>let the provider know immediately if the participant’s NDIS plan is suspended or replaced by a new NDIS plan or the participant stops being a 
                           participant in the NDIS.</label></li>
                        <li><label>listen to the participant’s feedback and resolve problems quickly</label></li>
                        <li><label>give the participant a minimum of 24 hours’ notice if the provider has to change a scheduled appointment to provide therapy services </label></li>
                        <li><label>give the participant the required notice if the provider needs to end the Service Agreement (see ‘Ending this Service 
                           Agreement’ below for more information)</label></li>
                        <li><label>protect the participant’s privacy and confidential information</label></li>
                        <li><label>provide support in a manner consistent with all relevant laws, including the National Disability Insurance Scheme Act 2013 and rules, and the Australian
                           Consumer Law; keep accurate records on the supports provided to the participant</label></li>
                        <li><label>issue regular invoices and statements of the therapy services delivered to the participant as per the Terms of Business for Registered Providers. </label></li>
                     </ul>
                  </div>
               </div>
               <div class="payment-section">
                  <div class="form-group">
                     
                        <h3>6. Payments</h3>
                     
                  </div>
                  <div class="form-group service-agreement-red">
                  <label>Practice name will seek payment for their provision of therapy services in the following manner after the <span> {!! $participant->getName() !!} </span> 
                     satisfactory delivery. </label>
                  </div>
                  <div class="form-group">
                  <label>The participant has chosen to self-manage the funding for NDIS services provided under this Service Agreement. After providing those services, the provider will generate an
                        invoice on conclusion of service provision for the participant to pay. The participant can 
                     elect to pay the invoice by cash / cheque / EFT at the time of consultation. </label>
                  </div>
                  <div class="form-group service-agreement-red">
                  <label><span>[OR]</span> </label>
                  </div>
                  <div class="form-group service-agreement-red">
                  <label>Practice name will seek payment for their provision of therapy services in the following manner after the <span> {!! $participant->getName() !!} </span> confirms 
                     satisfactory delivery. </label>
                  </div>
                  <div class="form-group service-agreement-red">
                  <label><span>[OR]</span> </label>
                  </div>
                  <div class="form-group ">
                  <label>The participant has nominated the NDIA to manage the funding for services provided under this Service Agreement. 
                     After providing those services, the provider will claim payment for those supports from the NDIA.</label>
                  </div>
                  <div class="form-group service-agreement-red">
                  <label><span>[OR]</span> </label>
                  </div>
                  <div class="form-group service-agreement-red">
                  <label>The participant has nominated the Plan Management Provider [insert name of Registered Plan Management Provider] to manage 
                     the funding for NDIS services provided under this Service Agreement. After providing those supports, the provider will claim
                        payment for those services from name of Registered Plan Management Provider.</label>
                  </div>
                  <div class="form-group {{ $errors->has('registeration_group') ? 'has-error' : '' }}">
                        <label for="registeration_group">Select Registered Plan Management Provider</label>
                        <select name="registeration_group[]" id="registeration_group" class="form-control select2" multiple="multiple"> 
                           @foreach($registeration_group as $id => $category)
                              <option value="{{ $id }}" {{ (in_array($id, old('registeration_group', [])) || isset($particiPant_reg_group) && $particiPant_reg_group->contains($id)) ? 'selected' : '' }}>{{ $category }}</option>
                           @endforeach
                        </select>
                        @if($errors->has('registeration_group'))
                           <em class="invalid-feedback">
                              {{ $errors->first('registeration_group') }}
                           </em>
                        @endif
                        <p class="helper-block">
                           {{ trans('cruds.contentPage.fields.category_helper') }}
                        </p>
                  </div>
               </div>

               <div class="agreeement-section">
                  <div class="form-group service-agreement-red">
                     
                        <h3>7. Changes to this Service Agreement</h3>
                     
                  </div>
                  <div class="form-group service-agreement-red">
                  <label>If changes to the treatment or their delivery are required, the parties agree to discuss and review this Service Agreement. The parties agree that any changes
                        to this Service 
                     Agreement will be in writing, signed, and dated by the parties.</label>
                  </div>
               </div>

               <div class="agreeement-section">
                  <div class="form-group service-agreement-red">
                     
                        <h3>8. Ending this Service Agreement</h3>
                     
                  </div>
                  <div class="form-group service-agreement-red">
                  <label>Should either party wish to end this Service Agreement they must give 1 months’ notice.</label>
                  <label>If either party seriously breaches this Service Agreement the requirement of notice will be waived.</label>
                  </div>
               </div>

               <div class="agreeement-section">
                  <div class="form-group service-agreement-red">
                     
                        <h3>9. Feedback, complaints, and disputes</h3>
                     
                  </div>
                  <div class="form-group service-agreement-red">
                  <label>If the participant wishes to give the provider feedback, the participant can talk to Contact Person on <span>[insert number]</span> or <span>[insert email]</span></label>
                  </div>
                  <div class="form-group service-agreement-red">
                  <label>If the participant is not happy with the provision of therapy services and wishes to make a complaint, the participant can talk to 
                     [insert your contact details here].</label>
                  </div>
                  <div class="form-group service-agreement-red">
                  <label>If the participant is not satisfied or does not want to talk to this person, the participant can contact the National Disability Insurance
                        Agency by calling 1800 800 110, visiting one of their offices in person, or visiting <a href="#"> ndis.gov.au</a> for further information.
                     </label>
                  </div>
               </div>

               <div class="agreeement-section">
                  <div class="form-group">
                     
                        <h3>10. Goods and Services Tax (GST) </h3>
                     
                  </div>
                  <div class="form-group service-agreement-red">
                  <label>For the purposes of GST legislation, the Parties confirm that: </label>
                  </div>
                  <div class="form-group service-agreement-red">
                     <ul>
                        <li><label>a supply of therapy services under this Service Agreement is a supply of one or more of the reasonable and 
                           necessary supports specified in the statement included, under subsection 33(2) of the National Disability Insurance Scheme Act 2013
                           (NDIS Act), in the participant’s NDIS plan currently in effect under section 37 of the NDIS Act;</label>
                        </li>
                        <li><label>the participant’s NDIS plan is expected to remain in effect during the period the therapy supports are provided; and</label>
                        </li>
                        <li><label>the <span>{!! $participant->getName() !!}</span> will immediately notify the provider if the participant’s 
                           NDIS Plan is replaced by a new plan or the participant stops being a participant in the NDIS.</label>
                        </li>
                     </ul>
                  </div>
               </div>

               <div class="agreeement-section">
                  <div class="form-group">
                        <h3>11. Contact details</h3>
                  </div>
                  <div class="form-group service-agreement-red">
                     <label>The <span>{!! $participant->getName() !!} </span> be contacted on:</label>
                  </div>
                  <div class="form-group">
                     <label>Contact details</label>
                  </div>

                  {!! 
                     Form::text('meta[participant_phone_bh]', trans('opforms.fields.phone_bh') )
                     ->id('participant_phone_bh')
                     ->help(trans('participants.fields.first_name_helper'))
                  !!}

                  {!! 
                     Form::text('meta[participant_phone_ah]', trans('opforms.fields.phone_ah'))
                     ->id('participant_phone_ah')
                     ->help(trans('participants.fields.first_name_helper'))
                  !!}

                  {!! 
                     Form::text('meta[participant_contact_mobile]', trans('opforms.fields.contact_mobile'), valOrAlt( $meta, 'participant_contact_mobile', $participant, 'mobile' ) )
                     ->id('participant_contact_mobile')
                     ->help(trans('participants.fields.first_name_helper'))
                  !!}

                  {!! 
                     Form::text('meta[participant_email]', trans('opforms.fields.email'), valOrAlt( $meta, 'participant_email', $participant, 'email' ))
                     ->id('participant_contact_email')
                     ->help(trans('participants.fields.first_name_helper'))
                  !!}

                  {!! 
                     Form::text('meta[participant_address]', trans('opforms.fields.address'), valOrAlt( $meta, 'participant_address', $participant, 'address' ))
                     ->id('participant_contact_address')
                     ->help(trans('participants.fields.first_name_helper'))
                  !!}

                  {!! 
                     Form::text('meta[participant_alernative_contact]', trans('opforms.fields.alernative_contact'), issetKey( $meta, 'participant_alernative_contact', '' ))
                     ->id('participant_alernative_contact')
                     ->help(trans('participants.fields.first_name_helper'))
                  !!}

                  
               <div class="agreeement-section">
                  <div class="form-group">
                     <h3>The provider can be contacted on:</h3>
                  </div>
                  <div class="form-group">
                  <label for="Phone">{{ $provider->getName() }}</label>
                  </div>

                  {!! 
                     Form::text('meta[provider_phone_bh]', trans('opforms.fields.phone_bh'), issetKey( $meta, 'provider_phone_bh', '' ) )
                     ->id('phone_bh')
                     ->help(trans('participants.fields.first_name_helper'))
                  !!}

                  {!! 
                     Form::text('meta[provider_phone_ah]', trans('opforms.fields.phone_ah'), issetKey( $meta, 'provider_phone_ah', '' ) )
                     ->id('phone_ah')
                     ->help(trans('participants.fields.first_name_helper'))
                  !!}

                  {!! 
                     Form::text('meta[provider_email]', trans('opforms.fields.email'), valOrAlt( $meta, 'provider_email', $provider, 'email' ) )
                     ->id('contact_email')
                     ->help(trans('participants.fields.first_name_helper'))
                  !!}

                  {!! 
                     Form::text('meta[provider_address]', trans('opforms.fields.address'), issetKey( $meta, 'provider_address', '' ) )
                     ->id('contact_address')
                     ->help(trans('participants.fields.first_name_helper'))
                  !!}
                  
               </div>

               <div class="agreeement-section">
                  <div class="form-group">
                     <ul>
                        <li class="text-bold"><label>Agreement signatures</label></li>
                     </ul>
                  </div>

                  <div class="form-group">
                     <label>The parties agree to the terms and conditions of this Service Agreement.</label>
                  </div>

                  @if(isset($meta['participant_signature']))
                     <img alt="participant_signature" src="{{ $meta['participant_signature'] }}" />
                  @else
                     @include('template.sign_pad', [ 'id' => 'participant_signature', 'user_id'=>$participant->id, 'name'=>'meta[participant_signature]', 'label' => 'Signature of <span>'.$participant->getName().'</span>' ]) 
                  @endif


                  @if(isset($meta['provider_signature']))
                     <img alt="provider_signature" src="{{ $meta['provider_signature'] }}" />
                  @else
                     @include('template.sign_pad', [ 'id' => 'provider_signature', 'user_id'=>$provider->id, 'name'=>'meta[provider_signature]', 'label' => 'Signature of <span>'.$provider->getName().'</span>' ]) 
                  @endif                  

                  {!! Form::date('meta[signature_date]', trans('opforms.fields.date'), issetKey( $meta, 'signature_date', today()->toDateString() ) )
                      ->id('signature_date')
                      ->size('col-sm-12') !!}

                  @if(isset($meta['authorize_signature']))
                     <img alt="authorize_signature" src="{{ $meta['authorize_signature'] }}" />
                  @else
                     @include('template.sign_pad', [ 'id' => 'authorize_person_signature', 'user_id'=>$provider->id, 'name'=>'meta[authorize_signature]', 'label' => 'Signature of authorized person from practice name' ])
                  @endif

                  {!! 
                     Form::text('meta[auth_person]', 'Name of authorised person from Practice name', issetKey( $meta, 'auth_person', '' ) )
                     ->id('name_of_auth_person')
                  !!}
               

                  {!! Form::date('signature_date_auth', trans('opforms.fields.date'), issetKey( $meta, 'signature_date_auth', today()->toDateString() ) )
                     ->id('signature_date_auth')
                     ->size('col-sm-12') 
                  !!}


               <div>

               <div class="agreeement-section"> 
                  <div class="form-group">
                     <ul>
                        <li class="text-bold"><label>Copy of participant’s NDIS plan</label></li>
                     </ul>
                  </div>
               </div>

               <div class="agreeement-section">
                     <div class="form-group service-agreement-red">
                        <label for="representative1"><span>[Attach a copy of the participant’s NDIS plan or delete this page if not required.] </span></label>
                        </div>
                        <div class="form-group">
                           <ul>
                              <li class="text-bold"><label>Schedule of supports</label></li>
                           </ul>
                     </div>
                     <div class="form-group service-agreement-red">
                        <label for="representative1"><span>[Insert a table of the supports to be provided under the Service Agreement, including sufficient details such as 
                           description, price, and how they will be provided. Example table below.]</span></label>
                        </div>

                        <h4>Support</h4>
                        {!! 
                           Form::text('meta[support_person_name]', 'List the name of the support.', issetKey( $meta, 'support_person_name', '' ) )
                           ->id('name_of_support_person')
                        !!}
                        
                        <h4>Description of support</h4>
                        {!! 
                           Form::text('meta[support_person_detail]', 'List the details of the support, including scope and volume.', issetKey( $meta, 'support_person_detail', '' ) )
                           ->id('support_person_detail')
                        !!}
                  
                        <h4>Price and payment information</h4>
                        {!! 
                           Form::text('meta[payment_info]', 'List the price of the support (e.g. per hour / per session / per unit) and whether NDIS funding for the support is managed by the Participant,
                              Participant’s Nominee, the NDIA, or a Registered Plan Management Provider.', issetKey( $meta, 'payment_info', '' ))
                           ->id('payment_info')
                        !!}

                        <h4>How the support will be provided</h4>
                        {!! 
                           Form::text('meta[support_provided]', 'List how, when, where, and by whom the support will be provided.', issetKey( $meta, 'support_provided', '' ) )
                           ->id('support_provided')
                        !!}
                     

               </div>

               <div class="agreeement-section">
                  <div class="form-group service-agreement-red">
                     <ul>
                        <li class="text-bold"><label>Cancellation Policy</label></li>
                     </ul>
                  <label for="representative1"><span>[Insert information about a cancellation policy (if relevant). Cancellation policies must be reasonable and comply with 
                     all applicable laws (e.g. the Australian Consumer Law).]</span></label>
                  </div>
               </div>

               <div class="agreeement-section">
                     <div class="form-group service-agreement-red">
                        <h4>Variations</h4>
                     <label for="Variations"><span>[your practice name]</span> reserves the right to vary, replace or terminate this policy from time to time.</label>
                     </div>
                     <div class="form-group service-agreement-red">
                        <h4>Policy version and revision information</h4>
                     <label for="Variations"><span>[your practice name]</span> reserves the right to vary, replace or terminate this policy from time to time.</label>
                     </div>

                     {!!
                        Form::text('meta[policy_authorised_name]', 'Policy Authorised by: <span>[Name]', issetKey( $meta, 'policy_authorised_name', '' ))
                        ->id('policy_authorised_name')
                     !!}

                     {!!
                        Form::text('meta[policy_maintained_name]', 'Policy Maintained by: <span>[Name]', issetKey( $meta, 'policy_maintained_name', '' ))
                        ->id('policy_maintained_name')
                     !!}

                     {!! 
                        Form::date('meta[policy_review_date]', 'Review date:', issetKey( $meta, 'policy_review_date', today()->toDateString() ) )
                        ->id('policy_review_date')
                        ->size('col-sm-12')
                        
                     !!}

                     {!! 
                        Form::date('meta[original_review_date]', 'Original issue:', issetKey( $meta, 'original_review_date', today()->toDateString() ) )
                        ->id('original_review_date')
                        ->size('col-sm-12') 
                     !!}

                     {!! Form::date('meta[current_version_date]', 'Current version:', issetKey( $meta, 'current_version_date', today()->toDateString() ) )
                        ->id('current_version_date')
                        ->size('col-sm-12') !!}

               </div>
            </div>
         </div>
         {!! Form::submit('Submit')->attrs(["class"=>"rounded"]) !!}
      </form>
   </div>
   {{-- 11th SERVICE AGREEMENT Form end here--}}


@section('scripts')
@parent
<script>

    
</script>
@endsection 