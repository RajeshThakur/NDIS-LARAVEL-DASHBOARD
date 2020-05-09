<div class="card" style="font-family: 'Open Sans', sans-serif;">
<style>
table{
   border-collapse: collapse;
}
table.discription tr td{
padding-top:7px;
padding-bottom:7px;
}
table.dynamic-data tr th{
font-size:10px;
padding:3px;
text-align:center;
}

table.dynamic-data tr td {
font-size:10px;
padding:3px;
text-align:center;
}
table.contact-details tr td.pdd-right{ 
   padding-right:250px;
}
table.contact-details tr td.text-right{ 
   text-align:right;
}

.custom-table-pdf table tr td{
   padding-top:10px;
   padding-bottom:15px;
   padding-left:0px;
   border-bottom:1px solid #e7e6e8;
   padding-right:0px;
   margin-left:-2px;
}
   

</style>
   <div class="table" style="font-family: 'Open Sans', sans-serif; border:1px solid #777d; padding:15px;">
      <div class="custom-table-pdf">
         <table class="table discription">
            <tbody>
               <tr>
                  <td style="padding-bottom:14px; font-size:24px; text-align:center">  National Disability Insurance Support Service Agreement </td>
                  <td style="padding-bottom:14px;"> &nbsp;</td>
               </tr>
               <tr>
                  <td style="padding-bottom:14px;">   {!! '<h3><strong>'.$participant->getName().'</strong></h3>' !!} </td>
                  <td style="padding-bottom:14px;"> &nbsp;</td>
               </tr>
               <tr>
                  <td>
                     Date of Birth
                  </td>
                  <td style="">
                     {!! $meta['dob_participant'] !!}
                  </td>
               </tr>
               <tr>
                  <td style="font-size: 22px;">
                     National Disability Insurance Scheme (NDIS) Support Service Agreement
                  </td>
                  <td style="padding-bottom:14px;"> &nbsp;</td>
               </tr>
            </tbody>
         </table>
      </div>
      <div class="custom-table-pdf">
         <table style="width:100%;" class="discription">
            <tbody>
               <tr>
                  <td>
                     <h4>Introduction</h4>
                  </td>
                  <td style="padding-bottom:14px;"> &nbsp;</td>
               </tr>
               <tr>
                  <td>
                     <label>{!! trans('opforms.fields.service_agreement_with') !!}</label>
                  </td>
                  <td style="text-align:right">
                     {!!$participant->getName()!!}
                  </td>
               </tr>
               <tr>
                  <td>
                     <label>{!! trans('opforms.fields.address') !!}:</label>
                  </td>
                  <td style="text-align:right">
                     {!!$meta['participant_address']!!}
                  </td>
               </tr>
               <tr>
                  <td>
                     <label>{!! trans('opforms.fields.provider_and_business') !!}:</label>
                  </td>
                  <td style="text-align:right">
                     {!!$meta['commences_on']!!}
                  </td>
               </tr>
               <tr>
                  <td>
                     <label>{!! trans('opforms.fields.cases_on') !!}:</label>
                  </td>
                  <td style="text-align:right">
                     {!!$meta['ceases_on']!!}
                  </td>
               </tr>
               <tr>
                  <td>
                     <label>{!! trans('opforms.fields.start_date') !!}:</label>
                  </td>
                  <td style="text-align:right">
                     {!!$meta['aggrement_start_date']!!}
                  </td>
               </tr>
               <tr>
                  <td>
                     <label>{!! trans('opforms.fields.end_date') !!}</label>
                  </td>
                  <td style="text-align:right">
                     {!!$meta['aggrement_end_date']!!}
                  </td>
               </tr>
               <tr>
                  <td><h4>As a provider, <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong>  agrees to supply the following supports (please tick appropriate box)</h4></td>
                  <td style="padding-bottom:14px;"> &nbsp;</td>
               </tr>

            
               @foreach($particiPant_reg_group as $val)
               <tr>
                  <td style="paading-left:25px;">
                     {{ $val->title }}
                  </td>
                  <td style="padding-bottom:14px;"> &nbsp;</td>
               </tr>
               @endforeach
               
                   
                  
            </tbody>
         </table>

         <label> Selected Supports that you will be providing.</label>
            @foreach($child_items_group as $item)
               <li style="margin-left:25px; width:100%;">{{ $item->title }}</li>
            @endforeach
            <p style=""> The types and duration of supports will continue between the <strong> Agreement start and finish dates</strong> unless a 
            review is initiated earlier by either the Participant or .</p>

            <p style="">will respect notice periods in relation to any changes in the type or duration of supports in the event of a review of <strong>the 
            Participant’s</strong> National Disability Insurance Scheme (NDIS) plan occurring.</p>

            <p style="">This <strong> support service agreement </strong> will be reviewed prior to the NDIS Plan Review Date or as required and agreed by both <strong>and the Participant.</strong></p>
      </div>

       <div class="custom-box">  
            <h4>Responsibilities</h4>
         
            <label>The Provider’s responsibilities.</label>
         
            <label>The provider agree to:</label>
         
            {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}
         
            <ul>
               <li style="padding-bottom:10px"><label>Provide the Participant with written information (or in other format as requested) about the types of support to be offered; </label></li>
               <li style="padding-bottom:10px"><label>Work with the Participant and their family/Carer and other relevant stakeholders (where required) to provide supports in a manner that suits their needs;  </label></li>
               <li style="padding-bottom:10px"><label>Consult the Participant and their family/Carer and other relevant stakeholders (where required) on decisions about how supports are provided;</label></li>
               <li style="padding-bottom:10px"><label>Treat the Participant and their family/Carer with courtesy and respect; </label>
               </li>
               <li style="padding-bottom:10px"><label>Communicate openly and honestly and in a timely manner;</label>
               </li>
               <li style="padding-bottom:10px"><label>Listen to the Participant’s feedback and work to resolve problems quickly; </label>
               </li>
               <li style="padding-bottom:10px"><label>Keep clear and timely records on the supports provided;</label></li>
               <li style="padding-bottom:10px">
               {!!$meta['review_service_agreement']!!}
               </li>
               <li style="padding-bottom:10px"><label>At all times comply with all Legislations, Regulations, Laws, Acts and Standards established by Government Authority in the provision of service under this NDIS Support Service Agreement;</label>
               </li>
               <li style="padding-bottom:10px"><label>Thorough provision of agreed supports/ services, under no circumstances discredit the valued status and prejudice the name of either the Participant or {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} ;</label></li>
               <li style="padding-bottom:10px"><label>Notify immediately your family/ Carer or other significant stakeholders of any significant incidents or accidents involving yourself under this Support Service Agreement;</label>
               </li>
               <li style="padding-bottom:10px"><label>Induct and appropriately train all support workers prior to the commencement of supports; </label></li>
               <li style="padding-bottom:10px"><label>Provide ongoing supervision and feedback to support workers involved in your direct support; </label></li>
               <li style="padding-bottom:10px">
                  <label>Ensure criminal record and Working with Children (where required) checks for staff providing you with supports have been completed; </label>
               </li>
               <li style="padding-bottom:10px">
                  <label>Provide staffing at different skill levels; however the various options come at different costs pending on the support needs of the Participant. 
                  There may also be an option of a private agreement which will incur an additional charge to the Participant if he/ she wants to select their own staff member;</label>
               </li>
               <li style="padding-bottom:10px">
                  <label>Follow the SCHADS (Social, Community, Home care And Disability Service) Award at all times to ensure the staff employed meet the award conditions; </label>
               </li>
               <li style="padding-bottom:10px">
                  <label>Not accept any gifts over $20 and declare the gift if this occurs.</label>
               </li>
            </ul>
         
         <h4>The Participant’s responsibilities:</h4>
         
         <label>I <strong>{{$participant->getName()}}</strong> the Plan Nominee, agree to:</label>
         
            <ul>
               <li style="margin-bottom:12px;"><label>Work cooperatively with <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong>  to ensure that services and supports are delivered to meet my needs; </label></li>
               <li style="margin-bottom:12px;"><label>Treat those involved in the delivery of my supports with courtesy and respect;  </label></li>
               <li style="margin-bottom:12px;"><label>Keep <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> informed of any changes to my situation that I expect will have an impact on this Agreement;</label></li>
               <li><label>Adhere to <strong> {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong>  complaint policies and procedure if I have any concerns about the services or supports being provided; agree if staff are not suitable, 
                  I will contact the Client Service Manager immediately and report my concerns; </label>
               </li>
               <li style="margin-bottom:12px;"><label>Give <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong>  reasonable notice (2 weeks’ notice) should I need to change any arrangement so that appropriate adjustment, if necessary, can be made;</label>
               </li>
               <li style="margin-bottom:12px;"><label>Give <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong>  reasonable notice (4 weeks’ notice) should I wish to cease this agreement;</label>
               </li>
               <li style="margin-bottom:12px;"><label>Agree that if I overspend with my NDIA funds, I personally am liable for any extra costs;</label></li>
               <li><label>Agree that <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong>  services will cease immediately until there are adequate funds available;</label></li>
               <li style="margin-bottom:12px;">
                  <label>Agree that the best method of communication for me is (please indicate preferences) </label>
                  <div class="fields mt-3">
                        <div class="icheck-primary d-inline">
                           <input type="checkbox" class="form-check-input" id="communication_method_email" name="meta[communication_method][email]" 
                           {{ (isset($meta['communication_method']) && isset($meta['communication_method']['email']) )?"checked=checked":'' }}>
                           <label class="form-check-label" for="communication_method_email">Email</label>
                        </div>
                        <div class="icheck-primary d-inline">
                              <input type="checkbox" class="form-check-input" id="communication_method_letter" name="meta[communication_method][letter]"
                              {{ (isset($meta['communication_method']) && isset($meta['communication_method']['letter']) )?"checked=checked":'' }}>
                           <label class="form-check-label" for="communication_method_letter">Letter</label>
                        </div>
                        <div class="icheck-primary d-inline">
                              <input type="checkbox" class="form-check-input" id="communication_method_mobile" name="meta[communication_method][mobile]"
                              {{ (isset($meta['communication_method']) && isset($meta['communication_method']['mobile']) )?"checked=checked":'' }}>
                           <label class="form-check-label" for="communication_method_mobile">Mobile</label>
                        </div>
                        <div class="icheck-primary d-inline">
                              <input type="checkbox" class="form-check-input" id="communication_method_text" name="meta[communication_method][text]"
                              {{ (isset($meta['communication_method']) && isset($meta['communication_method']['text']) )?"checked=checked":'' }}>
                           <label class="form-check-label" for="communication_method_text">Text</label>
                        </div>
                        <div class="icheck-primary d-inline">
                              <input type="checkbox" class="form-check-input" id="communication_method_home" name="meta[communication_method][home]"
                              {{ (isset($meta['communication_method']) && isset($meta['communication_method']['home']) )?"checked=checked":'' }}>
                           <label class="form-check-label" for="communication_method_home">Home Phone</label>
                        </div>
                        <div class="icheck-primary d-inline">
                           <input type="checkbox" class="form-check-input" id="communication_method_other" name="meta[communication_method][other]"
                           {{ (isset($meta['communication_method']) && isset($meta['communication_method']['other']) )?"checked=checked":'' }}>
                           <label class="form-check-label" for="communication_method_other">Other</label>
                        </div>
                  </div>
               </li>
               <li style="margin-bottom:12px;"><label>Agree to contact the Client Service Manager with reasonable notice if additional hours/days are needed;</label>
               </li>
               <li style="margin-bottom:12px;"><label>Provide a safe, working environment if working in the family / Participant’s home;</label></li>
               <li style="margin-bottom:12px;"><label>Agree to not deliberately contravene the SCHADS Award by asking the staff to work outside its conditions;</label>
               </li>
               <li style="margin-bottom:12px;"><label>Agree to adhere to all <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> Policies and Procedures. </label></li>
            </ul>
            
               <div class="payment-section">
                  <div class="form-group">
                     <h4>Changes to this Agreement</h4>
                  </div>
                  <div class="form-group service-agreement-red">
                     <label>Should either party need to substantially change when or how supports are to be provided, each party agree to give two <strong> (2) week’s </strong> notice.  </label>
                  </div>
                  <div class="responsible-section2 last-new-agreement">
                     <div class="form-group">
                        <ul>
                           <li><label>If I, or my <strong>Plan Nominee </strong> do not provide the notice in the time specified, the provider will seek payment from me for the missed/ cancelled support.  </label></li>
                           
                           <li><label>If <strong> {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong>  does not provide notice in the time specified, <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong>  will be responsible to provide missed/ cancelled
                              support at no cost to the Participant at another time suitable to both parties.</label>
                           </li>
                        </ul>
                     </div>
                     <div class="form-group">
                        <label>Should changes start to happen on a regular basis, we both agree that it is time to discuss and review the support schedule 
                        documented in Section 3 of this Agreement. We agree that any changes to this Agreement will be documented in writing,
                        signed and dated by both parties.  
                        </label>
                     </div>

                     <div class="form-group">
                     <h4>Termination of Agreement</h4>
                     </div>
                     <div class="form-group service-agreement-red">
                        <label>Should either party require this Agreement to end, we agree to give four (4) week’s notification. If extenuating circumstances present or either party seriously breaches any terms of this Agreement then the requirement of notice will be waived.</label>
                     </div>
                  </div>
               </div>
          </div>      

         <table class="table discription">
            <tbody>
               <tr>
                  <td> <h4>Schedule of Support</h4>  </td>
               </tr>
               <tr>
                  <td style="padding-bottom:14px;"> <h4 class="br-bottm"><span>*Definitions</span></h4> </td>
               </tr>
               <tr>
                  <td>
                  <label>Should either party require this Agreement to end, we agree to give four (4) week’s notification.  If extenuating 
                  circumstances present or either party seriously breaches any terms of this Agreement then the requirement of notice will be waived.</label>
                  </td>
                  
               </tr>
               <tr>
                  <td>
                  <label><strong>CORE –</strong> A support that enables a Participant to complete activities of daily living and enables them to work towards their goals and meet their objectives</label>
                  </td>
               </tr>

               <tr>
                  <td>
                  <div style="display:flex;">
                     <span>
                     {!! 
                        Form::text('budget_funding', '', isset($participant->budget_funding)?$participant->budget_funding:'' )
                        ->required('required')
                        ->size('col-sm-12')
                        ->hideLabel()
                        !!}
                        
                     </span>
                     <span style="margin-left:220px;">{!! 'Total Funding'!!}</span>
                  </div>
                  </td>
               </tr>
               <tr>
                  <td>
                  &nbsp;
                  </td>
               </tr>

               <tr>
                  <td>
                  <label style="display:block; padding-bottom:10px">Table 1.</label>
                  <label style="padding-top:10px;">Total Budget for this Participant</label>
                  </td>
               </tr>

               <tr>
                  <td>
                     <table class="dynamic-data" style="max-width:100%; overflow-x:auto;">
                        <thead style="background: #000;
                                    color: #fff;
                                    font-weight: normal;
                                    padding: 15px;
                                    text-align:center;
                                    ">
                           <tr>
                              <th>Support Areas Required</th>
                              <th>Description of Support/s (Details)</th>
                              <th>Annual Cost (Budget)</th>
                              <th>Monthly Cost (Budget)</th>
                              <th>Frequency</th>
                              <th>How will the supports be paid?</th>
                              <th>CODE</th>
                           </tr>
                        
                        </thead>
                        <tbody>
                           {!!$regDataTable!!}
                        </tbody>
                     </table>
                  </td>
               </tr>
            </tbody>
      </table>
 

        
   <h4>  Cancellation of Supports</h4>
   <h4>Cancellation by {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</h4>
      <div class="form-group">
         <h5><i><Cancellatio></Cancellatio> {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </i></h5>
         <label>Should <strong> {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong>  staff be unavailable due to illness/ leave, support for that day may be cancelled. <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong>  
         will notify you of our staff member’s absence as early as possible. Where applicable and appropriate, supports for that day may be 
         renegotiated for another time agreed upon by both the Participant and <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> to enable continuity of supports or another staff member may be utilised.
         <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong>  will be responsible to notify the Participant no later than 2 hours prior to the documented support start time.
         No charge will be incurred by the Participant for that day’s support.
         </label>
      </div> 
      <div class="form-group">
         <h5><i>Cancellation by The Participant.</i></h5>
         <label> <strong> {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong>  is required to receive notice of support cancellation 24 hours prior to provision of support.  If <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong> 
         does not receive such notice, payment will be claimed as per the participant’s agreed support Plan through the NDIS Provider Portal. <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong> will make claim for no more 
         than 8 individual instances of cancellation or no shows in a continuous 12 month period. Where cancellation is received within the specified
         timeframe no claim for payment will be made to NDIA. 
         </label>
      </div>
      <div class="form-group">
         <label> Where a Participant will not be available to receive support for a period of time in excess of 5 days (e.g. supported holiday, family holiday)
         <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}   </strong>requests that a minimum of two (2) week’s notification is provided. 
         Failure to notify <strong> {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}  </strong> of an extended absence may result in  <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}  </strong> making claims for payment of scheduled support to meet 
         industrial relations obligations to its staff. 
         </label>
      </div>
      <div class="form-group">
         <label> 
         <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> acknowledges that at times the health, personal and physical wellbeing of Participants may be compromised and extended periods 
         away from support will occur at short notice.
         In these instances, <strong> {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong>  will consult with Participants, their families/ Carers or others responsible to ensure a suitable outcome is reached.
         </label>
      </div>
   </div> 

   <div class="custom-box">
      <h4>Cancellation by The Participant</h4>
         <label><strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> is required to receive notice of support cancellation 24 hours prior to provision of support.  
         If <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong>  does not receive such notice, payment will be claimed as per the participant’s agreed support Plan through the NDIS Provider Portal. 
         <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong>  will make claim for no more than 8 individual instances of cancellation or no shows in a continuous 12 month period. Where 
         cancellation is received within the specified timeframe no claim for payment will be made to NDIA. 
         </label>
         <label>Where a Participant will not be available to receive support for a period of time in excess of 5 days (e.g. supported holiday, family holiday) 
         <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> requests that a minimum of two (2) week’s notification is provided.  Failure to notify <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> of an extended absence may result in <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong>  
         making claims for payment of scheduled support to meet industrial relations obligations to its staff.   
         </label>
         <label><strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong>  acknowledges that at times the health, personal and physical wellbeing of Participants may be compromised and extended periods away 
         from support will occur at short notice. In these instances, <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!},</strong>  will consult
         with Participants, their families/ Carers or others responsible to ensure a suitable outcome is reached.  
         </label>
         <h4>Participant Cancellation Protocol</h4>
         <label><strong>Weekday Supports: {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong>  office hours of operation are from 8am – 5pm Monday to Friday. Participants, families/ Carers and other important stakeholders are 
         requested to contact 02 9679 0174 during these operating hours to notify any cancellation of your support.</label>

         <label>Weekend/Public Holiday Supports: Participants, families/ Carers and other stakeholders are requested to contact our on call mobile number on </label>
         {!!
            Form::text('meta[cancellation_phone]', '',  issetKey( $meta, 'cancellation_phone', '' ) )
            ->id('cancellation_phone')
            ->hideLabel()
         !!}                                      
         <label> to notify any cancellation of your support.   
         </label>               
   

         <h4>Authorisation of Supports</h4>
         <div class="form-group">
            <label style="padding-bottom:12px;"><strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> acknowledges that each Participant’s circumstance, knowledge and expertise is different.
            To ensure Participants are provided opportunity to have as much choice, control, flexibility and responsibility in the management of supports,<strong> {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong>
            has included a range of options for Participants to ensure accountability and effective authorisation of supports that have been provided.
            Participants can choose from the below options:
            </label>
         </div>
         <div class="form-group" style="padding-bottom:12px;">
            
               <div class="icheck-primary d-inline">
                  <input type="checkbox" class="form-check-input" id="authorization_claim" name="meta[authorization][claim]"
                  {{ (isset($meta['authorization']) && isset($meta['authorization']['claim']) )?"checked=checked":'' }}>
                  <label for="authorization_claim" class="form-checkbox">I wish to manage and provide written authorisation of supports on a weekly basis to <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong>  prior to <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong>  making Claim for payment through NDIA. </label>
               </div>
            
         </div>
         <div class="form-group" style="padding-bottom:12px;">
            
               <div class="icheck-primary d-inline">
                  <input type="checkbox" class="form-check-input" id="authorization_claim_late_cancellation" name="meta[authorization][claim_late_cancellation]"
                  {{ (isset($meta['authorization']) && isset($meta['authorization']['claim_late_cancellation']) )?"checked=checked":'' }}>
                  <label for="authorization_claim_late_cancellation" class="form-checkbox">I provide<strong> {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> with permission to manage the authorisation of supports and make claims to NDIA for payments of support provided on a weekly basis. This also includes making claims any late notice cancellations within each claim period. I have chosen to self-manage my supports and request that <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> provide me with details of types of support.</label>
               </div>
            
         </div>
         <div class="form-group" style="padding-bottom:12px;">
               <div class="icheck-primary d-inline">
                  <input type="checkbox" class="form-check-input" id="authorization_self" name="meta[authorization][self]"
                  {{ (isset($meta['authorization']) && isset($meta['authorization']['self']) )?"checked=checked":'' }}>
                  <label for="authorization_self" class="form-checkbox">I have chosen to self-manage my supports and request that <strong>{{$provider->business_name}}</strong>  provide me with details of types of support.</label>
               </div>
            
         </div>    
   


         <h4>Claims for and Payment of Supports</h4>
         <div class="form-group">
            <label><strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> will seek payment for supports provided to Participants. After checking that a support was delivered and has been correctly  authorised, a claim for payment to NDIA will be made as soon as practicable.  To ensure claims for payments are made in a timely fashion please selects an option from the list below. </label>
         </div>
         
         <div class="form-group">
            <div class="icheck-primary d-inline">
               <input type="checkbox" class="form-check-input" id="claim_payments_ndia" name="meta[claim_payments][ndia]"
               {{ (isset($meta['claim_payments']) && isset($meta['claim_payments']['ndia']) )?"checked=checked":'' }}>
               <label for="claim_payments_ndia" class="form-checkbox">If you have nominated the NDIA to manage your funded supports, <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> will make a claim for payment from the NDIA
               </label>
            </div>
         </div>
         <div class="form-group">
            <div class="icheck-primary d-inline">
                  <input type="checkbox" class="form-check-input" id="claim_payments_pmp" name="meta[claim_payments][pmp]"
                  {{ (isset($meta['claim_payments']) && isset($meta['claim_payments']['pmp']) )?"checked=checked":'' }}>
                  <label for="claim_payments_pmp" class="form-checkbox">If you have nominated a Plan Management provider to manage your funded supports, <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> will advise your <strong>Plan Management provider</strong> they can make a claim for payment from the NDIA. Where<strong> {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> may be the Service Provider and the Plan Management provider<strong> {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> will make claims for payment from NDIA.
                  </label>
            </div>
         </div>
         <div class="form-group">
            <div class="icheck-primary d-inline">
               <input type="checkbox" class="form-check-input" id="claim_payments_self_manage" name="meta[claim_payments][self_manage]"
               {{ (isset($meta['claim_payments']) && isset($meta['claim_payments']['self_manage']) )?"checked=checked":'' }}>
               <label for="claim_payments_self_manage" class="form-checkbox">If you have chosen to self-manage your supports (including Participant Transport Assistance payment),<strong> {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> will send you an invoice for you to pay. You will need to pay this invoice by either cheque or Electronic Funds Transfer. Accounts must be paid strictly within 7 days from the issue date of each invoice.
               </label>
            </div>
         </div>
         
         <div class="form-group m-p-none">
            <div class="form-check responsibility-label">
               <h4>Overdue Accounts</h4>
               <label class="m-5 m-none" for="">In the event payments for support are not received within 7 days from the issue date 
               of each invoice the payments will be considered overdue 
               and support for <strong> the Participant </strong> not be provided until such time as the account is sufficiently settled.   </label>
            </div>
         </div>
         <div class="form-group m-p-none">
            <div class="form-check responsibility-label">
               <h4>Expiration of Support Funding</h4>
               <label class="m-5" for="">
               In the event that your allocated support funds for any of the support items included in your plan are exhausted prior to your annual review with the NDIA,
               {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}  will make contact with you to identify and negotiate alternative arrangements for reimbursement of support costs incurred as part of your schedule of supports.
               </label>
            </div>
         </div>
   

      
         <h4>Goods and services tax (GST)</h4>
         <div class="responsible-section2 last-new-agreement">
            <div class="form-group">
               <label>For the purposes of GST legislation, the Parties confirm that:</label>
            </div>
            <div class="form-group">
               <ul>
                  <li><label>the supports described in this Service Agreement are reasonable and necessary supports specified in the statement 
                     of supports in the Participant’s NDIS plan currently in effect under section 37 of the<a href="javascript-void:0"> National Disability Insurance Scheme Act 2013;</a></label>
                  </li>
               </ul>
            </div>
            <div class="form-group">
               <ul>
                  <li><label>the Participant’s NDIS plan is expected to remain in effect during the period the supports are provided; and</label></li>
               </ul>
            </div>
            <div class="form-group">
               <ul>
                  <li><label>Will immediately notify {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}  if the Participant’s NDIS Plan is replaced by a new plan or the Participant stops being a Participant in the NDIS.</label></li>
               </ul>
            </div>
         </div>    
   
         <h4>
            Insurance & Indemnity:
         </h4>
         <div class="form-group">
            <h4>  </h4>
            <label><strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}  </strong> be responsible to implement
            and maintain current and appropriate insurance coverage. </label>
         </div>   
   
         <h4>Feedback/Complaint/Disputes</h4>
         <div class="responsible-section2 last-new-agreement">
            <div class="form-group">
               <label>If you wish to provide feedback or make a complaint, please contact your Client Service Manager on Ph. 1800 795 382.  If the complaint/dispute 
               remains unresolved, and you are not happy with the outcomes or <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong>’s Complaints
               process you can write to the <strong>CEO, Avail Consulting, Disability Services, Studio 3, 249 Annangrove Rd, Annangrove, NSW 2156</strong></label>
            </div>
            <div class="form-group">
               <label>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}  is committed to resolving complaints fairly, equitably and as quickly as possible. The complaint can be face to face, by phone, 
               fax, letter or email. The complaint will remain confidential and information will only be available to those who are involved in resolving the complaint. 
               Complainants will not be disadvantaged or be prevented from continuing to receive supports as a result of making a complaint.</label>
            </div>
            <div class="form-group">
               <label>The Complainant may at any point in the complaints process, contact the following </label>
               <ul>
                  <li><label>Client Service Manager</label></li>
                  <li><label>CEO</label></li>
                  <li><label>National Disability Insurance Agency</label></li>
                  <li><label>An external support agency</label></li>
               </ul>
            </div>
            <div class="form-group">
               <label>Included is a list of external providers who can assist you with the complaints process if you prefer.</label>
            </div>
            <div class="form-group">
               <div class="complant-table-agreement">
                  <table class="table-responsible" style="border:1px solid #333;">
                     <thead>
                        <tr>
                           <th style="text-align: center;
                                       font-size:12px;
                                       ">NSW Ombudsman</th>
                                       
                           <th style="text-align: center;
                                       font-size:12px;
                                       ">National Disability Abuse & Neglect Hotline</th>
                                       
                           <th style="text-align: center;
                                       font-size:12px;
                                       ">Intellectual Disability Rights Service</th>
                                       
                           <th style="text-align: center;
                                       font-size:12px;
                                       ">NSW Council for Intellectually Disabled</th>
                                       
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td style="text-align: center;font-size:12px;">Phone: 1800 451 524</td>
                           <td style="text-align: center;
                                       font-size:12px;
                                       ">Phone: 1800 880 052</td>
                                       
                           <td style="text-align: center;
                                       font-size:12px;
                                       ">Phone: 9318 0144</td>
                                       
                           <td style="text-align: center;
                                       font-size:12px;
                                       ">Phone: 1800 424 065
                                       
                           </td>
                        </tr>
                        <tr>
                           <td style="text-align: center;
                                       font-size:12px;
                                       ">
                                       
                              Email: 
                              <p><a href="">nswombo@ombo.nsw.gov.au</a> </p>
                           </td>
                           <td style="text-align: center;
                                       font-size:12px;
                                       ">
                                       
                              Email: hotline@workfocus.com
                           </td>
                           <td style="text-align: center;
                                       font-size:12px;
                                       ">
                                       
                              Email: 
                              <p><a href="">info@idrs.org.au</a></p>
                           </td>
                           <td style="text-align: center;
                                       font-size:12px;
                                       ">
                                       
                              Email: 
                              <p><a href="">mail@nswcid.org.au</a> </p>
                           </td>
                        </tr>
                        <tr>
                           <td style="text-align: center;
                                       font-size:12px;
                                       ">
                                       
                              Website: 
                              <p><a href=""> www.ombo.nsw.gov.au</a> </p>
                           </td>
                           <td style="text-align: center;
                                       font-size:12px;
                                       ">
                                       
                              Website: 
                              <p><a href="">www.disabilityhotline.net.au </a></p>
                           </td>
                           <td style="text-align: center;
                                       font-size:12px;
                                       ">
                                       
                              Website: 
                              <p><a href=""> www.idrs.org.au </a></p>
                           </td>
                           <td style="text-align: center;
                                       font-size:12px;
                                       ">
                                       
                              Website: 
                              <p><a href=""> www.nswcid.org.au </a> </p>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
            <div class="form-group">
               <h4> Entire Agreement</h4>
            </div>
            <div class="form-group">
               <label>
               This agreement sets out all of the terms of your supports and services with {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} . This agreement supersedes and replaces 
               all prior representations, contracts and agreements (whether oral or in writing) detailing your supports and services with <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} . </strong>
               </label>
            </div>
            <div class="form-group">
               <label>
               If there are any other matters you wish to discuss further, please let<strong> {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}  </strong> before you sign this agreement.
               </label>
            </div>
            <div class="form-group">
               <label>
               Once you sign this agreement, you are confirming it is complete and no agreed terms are missing.
               </label>
            </div>
       </div>              
                 
       <table class="custom-table-pdf">
         <table class="contact-details">
               <tr>
                  <td>
                  <h4>Contact details:</h4>     
                  </td>
                  <td>&nbsp;</td>
               </tr>

               <tr>
                  <td class="pdd-right">
                     <label>I</label>     
                  </td>
                  <td class="text-right">
                     {!! old('participant_name', $participant->getName() )!!}
                  </td>
               </tr>
               <tr>
                  <td class="pdd-right">
                    <label style="display:block; widh:100%;">can be contacted on: </label> 
                 <label style="display:block; widh:100%;">{{ trans('opforms.fields.address')}}:</label> 
                  </td>
                  <td class="text-right">
                  <label>{{ trans('opforms.fields.address')}}:</label>
                  </td>
               </tr>

               <tr>
                  <td class="pdd-right">
                     <label>{{ trans('opforms.fields.phone_mobile')}}</label>
                  </td>
                  <td class="text-right">{!!$meta['phone_mobile']!!}</td>
               </tr>

               <tr>
                  <td class="pdd-right">
                  <label>{{ trans('opforms.fields.contact_email')}}:</label>
                  </td>
                  <td class="text-right">{!! issetKey( $meta, 'email', valOrAlt( $meta, 'email', $participant, 'email' ) )!!}</td>
               </tr>

               <tr>
                  <td class="pdd-right">
                  <label>{{ trans('opforms.fields.nominee_name')}}:</label>
                  </td>
                  <td class="text-right"> {!!
                         issetKey( $meta, 'nominee_name', '' )    
                        !!}
                  </td>
               </tr>

               <tr>
                     <td class="pdd-right">
                        <label style="display:block;">can be contacted on: </label>
                        <label style="display:block;">{{ trans('opforms.fields.address')}}:</label>
                     </td>

                     <td class="text-right">
                        {!! issetKey( $meta, 'nominee_address', '' )!!}
                     </td>
               </tr>

               <tr>
                  <td class="pdd-right">
                  <label>{{ trans('opforms.fields.phone_mobile')}}</label>
                  </td>

                  <td class="text-right">
                     {!! issetKey( $meta, 'nominee_phone', '' ) !!}
                  </td>
               </tr>

               <tr>
                  <td class="pdd-right">
                  <label>{{ trans('opforms.fields.contact_email')}}:</label>
                  </td>

                  <td class="text-right">
                     {!! issetKey( $meta, 'nominee_email', '' ) !!}
                  </td>
               </tr>

               <tr>
                  <td >
                  <h5>Agreement signatures:</h5>
                  </td>
                  <td>&nbsp;</td>
               </tr>

               <tr>
                  <td class="pdd-right">
                  <label>I</label>
                  </td>

                  <td class="text-right">
                     {!! issetKey( $meta, 'participant_declartion', '' ) !!}
                  </td>
               </tr>

               <tr>
                  <td>
                  <label>confirm that this agreement has been explained to me and/or my plan nominee and that I/we agree to this:</label>
                  </td>
                  <td>&nbsp;</td>
               </tr>
               
               <tr>
                  <td class="pdd-right">
                  <label>Name of Participant: </label>
                  </td>

                  <td class="text-right">
                     {!! old('participant_name', $participant->getName() ) !!}
                  </td>
               </tr>

               <tr>
                  <td class="pdd-right">
                  <label>{{trans('opforms.fields.date')}}</label>
                  </td>

                  <td class="text-right">
                     {!! issetKey( $meta, 'signature_date', todayDate() ) !!}
                  </td>
               </tr>
         </table>
      </div>

         <label>Signature of Jill Participant</label>
         @if(isset($meta['participant_signature']))
            <img alt="participant_signature" style="width:270px;" src="{{ $meta['participant_signature'] }}" class="img-fluid" />
         @else
            <span>Signature not</span>
         @endif

   </div>

   <!-- <div class="card-header">
      National Disability Insurance Support Service Agreement
   </div> -->
   <div class="card-body opforms">
      <div class="operational-form-design new-agreement">
         <!-- <form action="{{ route($formAction[0],$formAction[1]) }}" method="POST" class="validated" enctype="multipart/form-data">

            @csrf
            @if(!empty($formAction[1]))
            @method('PUT')        
            @endif
     
            <div class="service-agreementt">
               {{-- <input type="hidden" name="meta[form_title]" value="NDIS Service Agreement"> --}}
               {{-- <input type="hidden" name="template_id" value="11"> --}}
               {{-- <input type="hidden" name="user_id" id="user_id_val" value="{{$participant->user_id}}"> --}}
               {{-- <input type="hidden" name="participant_controller" value="{{$participantController}}"> --}}

               <div class="below-form">
                  <div class="parties-section">
                     <div class="intro mb-5">
                        <div class="row text-center">
                           <label>
                              {!! '<h3><strong>'.$participant->getName().'</strong></h3>' !!}
                           </label>
                        </div>
                        <div class="row ">
                           <div class="label col-sm-4">
                              <div class="form-group">
                                 <label>{!! trans('opforms.fields.date_of_birth') !!}</label>
                              </div>
                           </div>
                           <div class="label col-sm-8">
                              {!! 
                              Form::date('meta[dob_participant]', '', issetKey( $meta, 'dob_participant', todayDate() ) )
                              ->required('required')
                              ->size('col-sm-12')
                              ->hideLabel()
                              !!}
                           </div>
                        </div>
                     </div>
                     <div id="" class="col-sm-12">
                        <div class="form-group">
                           <h4 class=" mb-3">National Disability Insurance Scheme (NDIS) Support Service Agreement</h4>
                        </div>
                     </div>
                     <fieldset class="mb-5">
                        <legend>Introduction</legend>
                        <div class="row ">
                           <div class="label col-sm-4">
                              <div class="form-group">
                                 <label>{!! trans('opforms.fields.service_agreement_with') !!}</label>
                              </div>
                           </div>
                           <div class="label col-sm-8">
                              {!!
                              Form::text('meta[service_agreement_with]', trans('opforms.fields.service_agreement_with'),  old('service_agreement_with', $participant->getName() ) )
                              ->id('participant_name')
                              ->readonly()
                              ->hideLabel()
                              !!}
                           </div>
                        </div>
                        <div class="row ">
                           <div class="label col-sm-4">
                              <div class="form-group">
                                 <label>{!! trans('opforms.fields.address') !!}:</label>
                              </div>
                           </div>
                           <div class="label col-sm-8">
                              {!! 
                              Form::location('meta[participant_address]', 
                                 '', 
                                 valOrAlt( $meta, 'address', $participant, 'address' ),
                                 valOrAlt( $meta, 'participant_lat', $participant, 'lat' ),
                                 valOrAlt( $meta, 'participant_lng', $participant, 'lng' )
                              )
                              ->id('participant_address')
                              ->locationLatName('meta[participant_lat]')
                              ->locationLngName('meta[participant_lng]')
                              ->required('required')
                              ->hideLabel()
                              ->size('col-sm-12')
                              ->help(trans('global.user.fields.name_helper'))
                              !!}
                           </div>
                        </div>
                        <div class="row ">
                           <div class="label col-sm-4">
                              <div class="form-group">
                                 <label>{!! trans('opforms.fields.provider_and_business') !!}:</label>
                              </div>
                           </div>
                           <div class="label col-sm-8">
                              {!!
                              Form::text('provider_name', '', old('provider_name', isset($provider->id) ? $provider->getName() : '') )
                              ->id('provider_name')
                              ->size('col-sm-12')
                              ->readonly()
                              ->hideLabel()
                              !!}
                           </div>
                        </div>
                        <div class="row ">
                           <div class="label col-sm-11">
                              <label>{!! trans('opforms.fields.trading_as', ['business'=>$provider->provider->business_name]) !!}</label>
                           </div>
                        </div>
                        <div class="row ">
                           <div class="label col-sm-4">
                              <div class="form-group">
                                 <label>{!! trans('opforms.fields.commences') !!}:</label>
                              </div>
                           </div>
                           <div class="label col-sm-8">
                              {!! 
                              Form::date('meta[commences_on]', '', issetKey( $meta, 'commences_on', todayDate() ) )
                              ->id('commences_on')
                              ->size('col-sm-12')
                              // ->hideLabel()
                              !!}
                           </div>
                        </div>
                        <div class="row ">
                           <div class="label col-sm-4">
                              <div class="form-group">
                                 <label>{!! trans('opforms.fields.cases_on') !!}:</label>
                              </div>
                           </div>
                           <div class="label col-sm-8">
                              {!!
                              Form::date('meta[ceases_on]', '', issetKey( $meta, 'ceases_on', todayDate() ) )
                              ->id('ceases_on')
                              ->size('col-sm-12')
                              // ->hideLabel()
                              !!}
                           </div>
                        </div>
                        <div class="row ">
                           <div class="label col-sm-4">
                              <div class="form-group">
                                 <label>{!! trans('opforms.fields.start_date') !!}:</label>
                              </div>
                           </div>
                           <div class="label col-sm-8">
                              {!! 
                              Form::date('meta[aggrement_start_date]', '', issetKey( $meta, 'aggrement_start_date', todayDate() ) )
                              ->required('required')
                              ->size('col-sm-12')
                              ->help(trans('global.user.fields.name_helper'))
                              !!}
                           </div>
                        </div>
                        <div class="row ">
                           <div class="label col-sm-4">
                              <div class="form-group">
                                 <label>{!! trans('opforms.fields.end_date') !!}</label>
                              </div>
                           </div>
                           <div class="label col-sm-8">
                              {!! 
                              Form::date('meta[aggrement_end_date]', '', issetKey( $meta, 'aggrement_end_date', todayDate() ) )
                              ->required('required')
                              ->size('col-sm-12')
                              ->help(trans('global.user.fields.name_helper'))
                              !!}
                           </div>
                        </div>
                        <div class="responsible-section new-form-agreement">
                           <div class="form-group">
                              <h4>As a provider, <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong>  agrees to supply the following supports (please tick appropriate box)</h4>
                           </div>
                           <div class="form-group">
                              {{-- <label for="registeration_group"><strong>Select Registered Plan Management Provider</strong></label> --}}
                              <select name="registeration_group[]" id="registeration_group" class="form-control select2" multiple="multiple"> 
                                 @foreach($registeration_group as $id => $category)
                                    <option value="{{ $id }}" {{ (in_array($id, old('registeration_group', [])) || isset($particiPant_reg_group) && $particiPant_reg_group->contains($id)) ? 'selected' : '' }}>{{ $category }}</option>
                                 @endforeach
                              </select>
                             
                              <p class="helper-block">
                                 {{ trans('cruds.contentPage.fields.category_helper') }}
                              </p>
                           </div>

                           <div class="form-group">
                              <h4>Select the Supports that you will be providing.</h4>
                           </div>

                           <div class="form-group ">
                              
                              <select name="child_items_group[]" id="childitems" class="form-control select2" multiple="multiple"> 
                                 @foreach($child_items_group as $item)
                                    <option value="{{ $item->id }}" {{ (in_array($item->id, old('child_items_group', [])) || isset($selected_items_group) && $selected_items_group->contains($item->id)) ? 'selected' : '' }}>{{ $item->title }}</option>
                                 @endforeach
                              </select>
                              
                              <p class="helper-block">
                                 {{ trans('cruds.contentPage.fields.category_helper') }}
                              </p>
                           </div>
                          
                           
                           <div class="form-group">
                              <label>  The types and duration of supports will continue between the <strong>Agreement start and finish dates</strong> unless a review is initiated earlier by either <strong>the Participant</strong> or <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} .</strong> </label>
                           </div>

                           <div class="form-group">
                              <label> <strong> {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong>  will respect notice periods in relation to any changes in the type or duration of supports in the event of a review of <strong> the Participant’s</strong> National Disability Insurance Scheme (NDIS) plan occurring. </label>
                           </div>

                           <div class="form-group">
                              <label> This <strong>support service agreement</strong> will be reviewed prior to the NDIS Plan Review Date or as required and agreed by both<strong> {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}  and the Participant. </strong></label>
                           </div>
                        </div>
                     </fieldset>


                     <fieldset class="responsibilite2 mb-5">
                        <legend>Responsibilities</legend>
                        <div class="responsible-section2 last-new-agreement">
                           <div class="responsible-section new-form-agreement">
                              <div class="form-group">
                                 <label>The Provider’s responsibilities.</label>
                              </div>
                           </div>
                           <div class="form-group">
                              <label>The provider <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}   </strong> agrees to:</label>
                           </div>
                           <div class="form-group">
                              <ul>
                                 <li><label>Provide the Participant with written information (or in other format as requested) about the types of support to be offered; </label></li>
                                 <li><label>Work with the Participant and their family/Carer and other relevant stakeholders (where required) to provide supports in a manner that suits their needs;  </label></li>
                                 <li><label>Consult the Participant and their family/Carer and other relevant stakeholders (where required) on decisions about how supports are provided;</label></li>
                                 <li><label>Treat the Participant and their family/Carer with courtesy and respect; </label>
                                 </li>
                                 <li><label>Communicate openly and honestly and in a timely manner;</label>
                                 </li>
                                 <li><label>Listen to the Participant’s feedback and work to resolve problems quickly; </label>
                                 </li>
                                 <li><label>Keep clear and timely records on the supports provided;</label></li>
                                 <li>
                                    {!! 
                                    Form::text('meta[review_service_agreement]', trans('opforms.fields.review_service_agreement'), issetKey( $meta, 'review_service_agreement', '' ) )
                                    ->id('review_service_agreement')
                                    ->size('col-sm-12')
                                    !!}
                                 </li>
                                 <li><label>At all times comply with all Legislations, Regulations, Laws, Acts and Standards established by Government Authority in the provision of service under this NDIS Support Service Agreement;</label>
                                 </li>
                                 <li><label>Thorough provision of agreed supports/ services, under no circumstances discredit the valued status and prejudice the name of either the Participant or {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} ;</label></li>
                                 <li><label>Notify immediately your family/ Carer or other significant stakeholders of any significant incidents or accidents involving yourself under this Support Service Agreement;</label>
                                 </li>
                                 <li><label>Induct and appropriately train all support workers prior to the commencement of supports; </label></li>
                                 <li><label>Provide ongoing supervision and feedback to support workers involved in your direct support; </label></li>
                                 <li>
                                    <label>Ensure criminal record and Working with Children (where required) checks for staff providing you with supports have been completed; </label>
                                 </li>
                                 <li>
                                    <label>Provide staffing at different skill levels; however the various options come at different costs pending on the support needs of the Participant. 
                                    There may also be an option of a private agreement which will incur an additional charge to the Participant if he/ she wants to select their own staff member;</label>
                                 </li>
                                 <li>
                                    <label>Follow the SCHADS (Social, Community, Home care And Disability Service) Award at all times to ensure the staff employed meet the award conditions; </label>
                                 </li>
                                 <li>
                                    <label>Not accept any gifts over $20 and declare the gift if this occurs.</label>
                                 </li>
                              </ul>
                           </div>
                        </div>
                        <div class="responsible-section2 last-new-agreement">
                           <h4>The Participant’s responsibilities:</h4>
                           <div class="form-group">
                              <label>I <strong>{{$participant->getName()}}</strong> the Plan Nominee, agree to:</label>
                           </div>
                           <div class="form-group">
                              <ul>
                                 <li><label>Work cooperatively with <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong>  to ensure that services and supports are delivered to meet my needs; </label></li>
                                 <li><label>Treat those involved in the delivery of my supports with courtesy and respect;  </label></li>
                                 <li><label>Keep <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> informed of any changes to my situation that I expect will have an impact on this Agreement;</label></li>
                                 <li><label>Adhere to <strong> {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong>  complaint policies and procedure if I have any concerns about the services or supports being provided; agree if staff are not suitable, 
                                    I will contact the Client Service Manager immediately and report my concerns; </label>
                                 </li>
                                 <li><label>Give <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong>  reasonable notice (2 weeks’ notice) should I need to change any arrangement so that appropriate adjustment, if necessary, can be made;</label>
                                 </li>
                                 <li><label>Give <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong>  reasonable notice (4 weeks’ notice) should I wish to cease this agreement;</label>
                                 </li>
                                 <li><label>Agree that if I overspend with my NDIA funds, I personally am liable for any extra costs;</label></li>
                                 <li><label>Agree that <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong>  services will cease immediately until there are adequate funds available;</label></li>
                                 
                                 <li>
                                    <label>Agree that the best method of communication for me is (please indicate preferences) </label>

                                    <div class="fields mt-3">
                                          <div class="icheck-primary d-inline">
                                             <input type="checkbox" class="form-check-input" id="communication_method_email" name="meta[communication_method][email]" 
                                             {{ (isset($meta['communication_method']) && isset($meta['communication_method']['email']) )?"checked=checked":'' }}>
                                             <label class="form-check-label" for="communication_method_email">Email</label>
                                          </div>
                                          <div class="icheck-primary d-inline">
                                                <input type="checkbox" class="form-check-input" id="communication_method_letter" name="meta[communication_method][letter]"
                                                {{ (isset($meta['communication_method']) && isset($meta['communication_method']['letter']) )?"checked=checked":'' }}>
                                             <label class="form-check-label" for="communication_method_letter">Letter</label>
                                          </div>
                                          <div class="icheck-primary d-inline">
                                                <input type="checkbox" class="form-check-input" id="communication_method_mobile" name="meta[communication_method][mobile]"
                                                {{ (isset($meta['communication_method']) && isset($meta['communication_method']['mobile']) )?"checked=checked":'' }}>
                                             <label class="form-check-label" for="communication_method_mobile">Mobile</label>
                                          </div>
                                          <div class="icheck-primary d-inline">
                                                <input type="checkbox" class="form-check-input" id="communication_method_text" name="meta[communication_method][text]"
                                                {{ (isset($meta['communication_method']) && isset($meta['communication_method']['text']) )?"checked=checked":'' }}>
                                             <label class="form-check-label" for="communication_method_text">Text</label>
                                          </div>
                                          <div class="icheck-primary d-inline">
                                                <input type="checkbox" class="form-check-input" id="communication_method_home" name="meta[communication_method][home]"
                                                {{ (isset($meta['communication_method']) && isset($meta['communication_method']['home']) )?"checked=checked":'' }}>
                                             <label class="form-check-label" for="communication_method_home">Home Phone</label>
                                          </div>
                                          <div class="icheck-primary d-inline">
                                             <input type="checkbox" class="form-check-input" id="communication_method_other" name="meta[communication_method][other]"
                                             {{ (isset($meta['communication_method']) && isset($meta['communication_method']['other']) )?"checked=checked":'' }}>
                                             <label class="form-check-label" for="communication_method_other">Other</label>
                                          </div>

                                    </div>
                                    

                                 </li>
                                 
                                 <li><label>Agree to contact the Client Service Manager with reasonable notice if additional hours/days are needed;</label>
                                 </li>
                                 <li><label>Provide a safe, working environment if working in the family / Participant’s home;</label></li>
                                 <li><label>Agree to not deliberately contravene the SCHADS Award by asking the staff to work outside its conditions;</label>
                                 </li>
                                 <li><label>Agree to adhere to all <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> Policies and Procedures. </label></li>
                              </ul>
                           </div>
                        </div>
                        <div class="payment-section">
                           <div class="form-group">
                              <h4>Changes to this Agreement</h4>
                           </div>
                           <div class="form-group service-agreement-red">
                              <label>Should either party need to substantially change when or how supports are to be provided, each party agree to give two <strong> (2) week’s </strong> notice.  </label>
                           </div>
                           <div class="responsible-section2 last-new-agreement">
                              <div class="form-group">
                                 <ul>
                                    <li><label>If I, or my <strong>Plan Nominee </strong> do not provide the notice in the time specified, the provider will seek payment from me for the missed/ cancelled support.  </label></li>
                                    
                                    <li><label>If <strong> {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong>  does not provide notice in the time specified, <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong>  will be responsible to provide missed/ cancelled
                                       support at no cost to the Participant at another time suitable to both parties.</label>
                                    </li>
                                 </ul>
                              </div>
                              <div class="form-group">
                                 <label>Should changes start to happen on a regular basis, we both agree that it is time to discuss and review the support schedule 
                                 documented in Section 3 of this Agreement. We agree that any changes to this Agreement will be documented in writing,
                                 signed and dated by both parties.  
                                 </label>
                              </div>
                           </div>
                        </div>
                        <div class="payment-section">
                           <div class="form-group">
                              <h4>Termination of Agreement</h4>
                           </div>
                           <div class="form-group service-agreement-red">
                              <label>Should either party require this Agreement to end, we agree to give four (4) week’s notification.  If extenuating 
                              circumstances present or either party seriously breaches any terms of this Agreement then the requirement of notice will be waived.</label>
                           </div>
                        </div>
                     </fieldset>


                     <fieldset class="responsibilite2 mb-5">
                        <legend>
                           Schedule of Support 
                        </legend>
                        <div class="main-table-agreement-form">
                           <div class="form-group">
                              <h4 class="br-bottm"><span>*Definitions</span></h4>
                           </div>
                           <div class="form-group service-agreement-red">
                              <label>Should either party require this Agreement to end, we agree to give four (4) week’s notification.  If extenuating 
                              circumstances present or either party seriously breaches any terms of this Agreement then the requirement of notice will be waived.</label>
                           </div>
                           <div class="responsible-section2 last-new-agreement">
                              <div class="form-group">
                                 <label><strong>CORE –</strong> A support that enables a Participant to complete activities of daily living and enables them to work towards their goals and meet their objectives</label>
                              </div>

                              <div class="row ">
                                 <div class="label col-sm-4">
                                    <div class="form-group">
                                       <label>{!! 'Total Funding'!!}</label>
                                    </div>
                                 </div>
                                 <div class="label col-sm-8">
                                    {!! 
                                    Form::text('budget_funding', '', isset($participant->budget_funding)?$participant->budget_funding:'' )
                                    ->required('required')
                                    ->size('col-sm-12')
                                    ->hideLabel()
                                    !!}
                                 </div>
                              </div>


                              <div class="form-group">
                                 <label>Table 1.</label>
                                 <label>Total Budget for this Participant</label>
                              </div>
                              <div class="new-agreement-table ">
                                 <table class="table-responsible table-1 text-center responsive" id="reg_budget">
                                    <thead>
                                       <tr>
                                          <th>Support Areas Required</th>
                                          <th>Description of Support/s (Details)</th>
                                          <th>Annual Cost (Budget)</th>
                                          <th>Monthly Cost (Budget)</th>
                                          <th>Frequency</th>
                                          <th>How will the supports be paid?</th>
                                          <th>CODE</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr>
                                          <td colspan="7">Please Select Registration Groups Above</td>
                                       </tr>
                                    </tbody>

                                    
                                 </table>
                              </div>
                           </div>
                        </div>
                     </fieldset>


                     <fieldset class="responsibilite2 mb-5">
                        <legend>
                           Cancellation of Supports
                        </legend>
                        <div class="cancel-suport block-italick">
                           <div id="" class="col-sm-12">
                              <div class="form-group">
                                 <h4>Cancellation by {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} .</h4>
                                 <div class="form-group">
                                    <h5><i><Cancellatio></Cancellatio>n by {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} .</i></h5>
                                    <label>Should <strong> {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong>  staff be unavailable due to illness/ leave, support for that day may be cancelled. <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong>  
                                    will notify you of our staff member’s absence as early as possible. Where applicable and appropriate, supports for that day may be 
                                    renegotiated for another time agreed upon by both the Participant and <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> to enable continuity of supports or another staff member may be utilised.
                                    <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong>  will be responsible to notify the Participant no later than 2 hours prior to the documented support start time.
                                    No charge will be incurred by the Participant for that day’s support.
                                    </label>
                                 </div>
                                 <div class="form-group">
                                    <h5><i>Cancellation by The Participant.</i></h5>
                                    <label> <strong> {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong>  is required to receive notice of support cancellation 24 hours prior to provision of support.  If <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong> 
                                    does not receive such notice, payment will be claimed as per the participant’s agreed support Plan through the NDIS Provider Portal. <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong> will make claim for no more 
                                    than 8 individual instances of cancellation or no shows in a continuous 12 month period. Where cancellation is received within the specified
                                    timeframe no claim for payment will be made to NDIA. 
                                    </label>
                                 </div>
                                 <div class="form-group">
                                    <label> Where a Participant will not be available to receive support for a period of time in excess of 5 days (e.g. supported holiday, family holiday)
                                    <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}   </strong>requests that a minimum of two (2) week’s notification is provided. 
                                    Failure to notify <strong> {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}  </strong> of an extended absence may result in  <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}  </strong> making claims for payment of scheduled support to meet 
                                    industrial relations obligations to its staff. 
                                    </label>
                                 </div>
                                 <div class="form-group">
                                    <label> 
                                    <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> acknowledges that at times the health, personal and physical wellbeing of Participants may be compromised and extended periods 
                                    away from support will occur at short notice.
                                    In these instances, <strong> {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong>  will consult with Participants, their families/ Carers or others responsible to ensure a suitable outcome is reached.
                                    </label>
                                 </div>
                              </div>
                              <div class="cancle-participant">
                                 <h4>Cancellation by The Participant</h4>
                                 <label><strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> is required to receive notice of support cancellation 24 hours prior to provision of support.  
                                 If <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong>  does not receive such notice, payment will be claimed as per the participant’s agreed support Plan through the NDIS Provider Portal. 
                                 <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong>  will make claim for no more than 8 individual instances of cancellation or no shows in a continuous 12 month period. Where 
                                 cancellation is received within the specified timeframe no claim for payment will be made to NDIA. 
                                 </label>
                                 <label>Where a Participant will not be available to receive support for a period of time in excess of 5 days (e.g. supported holiday, family holiday) 
                                 <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> requests that a minimum of two (2) week’s notification is provided.  Failure to notify <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> of an extended absence may result in <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong>  
                                 making claims for payment of scheduled support to meet industrial relations obligations to its staff.   
                                 </label>
                                 <label><strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong>  acknowledges that at times the health, personal and physical wellbeing of Participants may be compromised and extended periods away 
                                 from support will occur at short notice. In these instances, <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!},</strong>  will consult
                                 with Participants, their families/ Carers or others responsible to ensure a suitable outcome is reached.  
                                 </label>
                              </div>
                              <div class="cancle-participant">
                                 <h4>Participant Cancellation Protocol</h4>
                                 <label><strong>Weekday Supports: {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong>  office hours of operation are from 8am – 5pm Monday to Friday. Participants, families/ Carers and other important stakeholders are 
                                 requested to contact 02 9679 0174 during these operating hours to notify any cancellation of your support.</label>

                                 <label>Weekend/Public Holiday Supports: Participants, families/ Carers and other stakeholders are requested to contact our on call mobile number on </label>
                                 {!!
                                    Form::text('meta[cancellation_phone]', '',  issetKey( $meta, 'cancellation_phone', '' ) )
                                    ->id('cancellation_phone')
                                    ->hideLabel()
                                 !!}                                       

                                 <label> to notify any cancellation of your support.   
                                 </label>
                              </div>
                           </div>
                        </div>
                     </fieldset>


                     <fieldset class="responsibilite2 mb-5">
                        <legend>Authorisation of Supports</legend>
                        <div class="form-group">
                           <label><strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> acknowledges that each Participant’s circumstance, knowledge and expertise is different.
                           To ensure Participants are provided opportunity to have as much choice, control, flexibility and responsibility in the management of supports,<strong> {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong>
                           has included a range of options for Participants to ensure accountability and effective authorisation of supports that have been provided.
                           Participants can choose from the below options:
                           </label>
                        </div>
                        <div class="form-group">
                           
                              <div class="icheck-primary d-inline">
                                 <input type="checkbox" class="form-check-input" id="authorization_claim" name="meta[authorization][claim]"
                                 {{ (isset($meta['authorization']) && isset($meta['authorization']['claim']) )?"checked=checked":'' }}>
                                 <label for="authorization_claim" class="form-checkbox">I wish to manage and provide written authorisation of supports on a weekly basis to <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong>  prior to <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}</strong>  making Claim for payment through NDIA. </label>
                              </div>
                           
                        </div>
                        <div class="form-group">
                           
                              <div class="icheck-primary d-inline">
                                 <input type="checkbox" class="form-check-input" id="authorization_claim_late_cancellation" name="meta[authorization][claim_late_cancellation]"
                                 {{ (isset($meta['authorization']) && isset($meta['authorization']['claim_late_cancellation']) )?"checked=checked":'' }}>
                                 <label for="authorization_claim_late_cancellation" class="form-checkbox">I provide<strong> {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> with permission to manage the authorisation of supports and make claims to NDIA for payments of support provided on a weekly basis. This also includes making claims any late notice cancellations within each claim period. I have chosen to self-manage my supports and request that <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> provide me with details of types of support.</label>
                              </div>
                           
                        </div>
                        <div class="form-group">
                              <div class="icheck-primary d-inline">
                                 <input type="checkbox" class="form-check-input" id="authorization_self" name="meta[authorization][self]"
                                 {{ (isset($meta['authorization']) && isset($meta['authorization']['self']) )?"checked=checked":'' }}>
                                 <label for="authorization_self" class="form-checkbox">I have chosen to self-manage my supports and request that <strong>{{$provider->business_name}}</strong>  provide me with details of types of support.</label>
                              </div>
                           
                        </div>
                     </fieldset>



                     <fieldset class="responsibilite2 mb-5">
                        <legend>Claims for and Payment of Supports</legend>
                        <div class="form-group">
                           <label><strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> will seek payment for supports provided to Participants. After checking that a support was delivered and has been correctly  authorised, a claim for payment to NDIA will be made as soon as practicable.  To ensure claims for payments are made in a timely fashion please selects an option from the list below. </label>
                        </div>
                        
                        <div class="form-group">
                           <div class="icheck-primary d-inline">
                              <input type="checkbox" class="form-check-input" id="claim_payments_ndia" name="meta[claim_payments][ndia]"
                              {{ (isset($meta['claim_payments']) && isset($meta['claim_payments']['ndia']) )?"checked=checked":'' }}>
                              <label for="claim_payments_ndia" class="form-checkbox">If you have nominated the NDIA to manage your funded supports, <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> will make a claim for payment from the NDIA
                              </label>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="icheck-primary d-inline">
                                 <input type="checkbox" class="form-check-input" id="claim_payments_pmp" name="meta[claim_payments][pmp]"
                                 {{ (isset($meta['claim_payments']) && isset($meta['claim_payments']['pmp']) )?"checked=checked":'' }}>
                                 <label for="claim_payments_pmp" class="form-checkbox">If you have nominated a Plan Management provider to manage your funded supports, <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> will advise your <strong>Plan Management provider</strong> they can make a claim for payment from the NDIA. Where<strong> {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> may be the Service Provider and the Plan Management provider<strong> {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> will make claims for payment from NDIA.
                                 </label>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="icheck-primary d-inline">
                              <input type="checkbox" class="form-check-input" id="claim_payments_self_manage" name="meta[claim_payments][self_manage]"
                              {{ (isset($meta['claim_payments']) && isset($meta['claim_payments']['self_manage']) )?"checked=checked":'' }}>
                              <label for="claim_payments_self_manage" class="form-checkbox">If you have chosen to self-manage your supports (including Participant Transport Assistance payment),<strong> {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> will send you an invoice for you to pay. You will need to pay this invoice by either cheque or Electronic Funds Transfer. Accounts must be paid strictly within 7 days from the issue date of each invoice.
                              </label>
                           </div>
                        </div>
                        
                        <div class="form-group m-p-none">
                           <div class="form-check responsibility-label">
                              <h4>Overdue Accounts</h4>
                              <label class="m-5 m-none" for="">In the event payments for support are not received within 7 days from the issue date 
                              of each invoice the payments will be considered overdue 
                              and support for <strong> the Participant </strong> not be provided until such time as the account is sufficiently settled.   </label>
                           </div>
                        </div>
                        <div class="form-group m-p-none">
                           <div class="form-check responsibility-label">
                              <h4>Expiration of Support Funding</h4>
                              <label class="m-5" for="">
                              In the event that your allocated support funds for any of the support items included in your plan are exhausted prior to your annual review with the NDIA,
                              {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}  will make contact with you to identify and negotiate alternative arrangements for reimbursement of support costs incurred as part of your schedule of supports.
                              </label>
                           </div>
                        </div>
                     </fieldset>


                     <fieldset class="responsibilite2 mb-5">
                        <legend>Goods and services tax (GST)</legend>
                        <div class="responsible-section2 last-new-agreement">
                           <div class="form-group">
                              <label>For the purposes of GST legislation, the Parties confirm that:</label>
                           </div>
                           <div class="form-group">
                              <ul>
                                 <li><label>the supports described in this Service Agreement are reasonable and necessary supports specified in the statement 
                                    of supports in the Participant’s NDIS plan currently in effect under section 37 of the<a href="javascript-void:0"> National Disability Insurance Scheme Act 2013;</a></label>
                                 </li>
                              </ul>
                           </div>
                           <div class="form-group">
                              <ul>
                                 <li><label>the Participant’s NDIS plan is expected to remain in effect during the period the supports are provided; and</label></li>
                              </ul>
                           </div>
                           <div class="form-group">
                              <ul>
                                 <li><label>Will immediately notify {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}  if the Participant’s NDIS Plan is replaced by a new plan or the Participant stops being a Participant in the NDIS.</label></li>
                              </ul>
                           </div>
                        </div>
                     </fieldset>
                     <fieldset class="responsibilite2 mb-5">
                        <legend>
                           Insurance & Indemnity:
                        </legend>
                        <div class="form-group">
                           <h4>  </h4>
                           <label><strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}  </strong> be responsible to implement
                           and maintain current and appropriate insurance coverage. </label>
                        </div>
                     </fieldset>
                     <fieldset class="responsibilite2 mb-5">
                        <legend>Confidentiality</legend>
                        <div class="responsible-section2 last-new-agreement">
                           <div class="form-group">
                              <label> <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}  </strong> be responsible 
                              to implement and maintain current and appropriate insurance coverage. </label>
                           </div>
                           <div class="form-group">
                              <ul>
                                 <li><label>Keep all information in this Support Service Agreement confidential.</label></li>
                                 <li><label>Keep all attached information to the Support Service Agreement confidential.</label></li>
                                 <li><label>Only use the confidential information provided to enhance and support its </label></li>
                                 <li><label>performance in the provision of agreed services under this Support Service Agreement. </label></li>
                                 <li><label>Provide access to information from this agreement for a specific need allowing the supports requested to be provided. </label></li>
                              </ul>
                           </div>
                           <div class="form-group">
                                 <label ><strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> has a strict Privacy and Confidentiality policy, so to do this we need to seek your consent. Please <strong><i>tick and initial</i></strong> the boxes below to indicate whether or not you consent to the following. You can withdraw your consent at any time.
                                 </label>
                           </div>
                           <div class="form-group">
                              <div class="icheck-primary d-inline">
                                 <input type="checkbox" class="form-check-input" id="confidentiality_newsletter" name="meta[confidentiality][newsletter]"
                                 {{ (isset($meta['confidentiality']) && isset($meta['confidentiality']['newsletter']) )?"checked=checked":'' }}>
                                 <label for="confidentiality_newsletter" class="form-checkbox">Yes, I hereby consent to my photo, name and / or comment / story being published in the<strong> {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> Newsletter, Facebook page and Website.</label>
                              </div>
                           </div>
                           <div class="form-group">
                                 <div class="icheck-primary d-inline">
                                    <input type="checkbox" class="form-check-input" id="confidentiality_newspapers" name="meta[confidentiality][newspapers]"
                                    {{ (isset($meta['confidentiality']) && isset($meta['confidentiality']['newspapers']) )?"checked=checked":'' }}>
                                    <label for="confidentiality_newspapers" class="form-checkbox">Yes, I hereby consent to my photo, name and / or comment / story being sent to newspapers (local, state and / or national), radio and Television media outlets.</label>
                                 </div>
                           </div>
                           <div class="form-group">
                                 <div class="icheck-primary d-inline">
                                    <input type="checkbox" class="form-check-input" id="confidentiality_photo" name="meta[confidentiality][photo]"
                                    {{ (isset($meta['confidentiality']) && isset($meta['confidentiality']['photo']) )?"checked=checked":'' }}>
                                    <label for="confidentiality_photo" class="form-checkbox">Yes, I hereby consent for my photo, story / comment to appear but using a false name to preserve my privacy.</label>
                                 </div>
                           </div>
                           <div class="form-group">
                                 <div class="icheck-primary d-inline">
                                    <input type="checkbox" class="form-check-input" id="confidentiality_photo_denied" name="meta[confidentiality][photo_denied]"
                                    {{ (isset($meta['confidentiality']) && isset($meta['confidentiality']['photo_denied']) )?"checked=checked":'' }}>
                                    <label for="confidentiality_photo_denied" class="form-checkbox">No. I do not provide consent for any photo of me to be taken and / or stories or comments be used by <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} .</strong></label>
                                 </div>
                           </div>
                           <div class="form-group">
                                 <div class="icheck-primary d-inline">
                                    <input type="checkbox" class="form-check-input" id="confidentiality_records" name="meta[confidentiality][records]"
                                    {{ (isset($meta['confidentiality']) && isset($meta['confidentiality']['records']) )?"checked=checked":'' }}>
                                    <label for="confidentiality_records" class="form-checkbox">Yes, I hereby consent for <strong> {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> to access records on the Portal at any time.</label>
                                 </div>
                           </div>
                           <div class="form-group">
                                 <div class="icheck-primary d-inline">
                                    <input type="checkbox" class="form-check-input" id="confidentiality_liaise" name="meta[confidentiality][liaise]"
                                    {{ (isset($meta['confidentiality']) && isset($meta['confidentiality']['liaise']) )?"checked=checked":'' }}>
                                    <label for="confidentiality_liaise" class="form-checkbox">Yes, I hereby consent for <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong> to liaise with the NDIS, NDIA or any other relevant Service Provider on my behalf.</label>
                                 </div>
                                 
                           </div>
                        </div>
                     </fieldset>


                     <fieldset class="responsibilite2 mb-5">
                        <legend>Feedback/Complaint/Disputes</legend>
                        <div class="responsible-section2 last-new-agreement">
                           <div class="form-group">
                              <label>If you wish to provide feedback or make a complaint, please contact your Client Service Manager on Ph. 1800 795 382.  If the complaint/dispute 
                              remains unresolved, and you are not happy with the outcomes or <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} </strong>’s Complaints
                              process you can write to the <strong>CEO, Avail Consulting, Disability Services, Studio 3, 249 Annangrove Rd, Annangrove, NSW 2156</strong></label>
                           </div>
                           <div class="form-group">
                              <label>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}  is committed to resolving complaints fairly, equitably and as quickly as possible. The complaint can be face to face, by phone, 
                              fax, letter or email. The complaint will remain confidential and information will only be available to those who are involved in resolving the complaint. 
                              Complainants will not be disadvantaged or be prevented from continuing to receive supports as a result of making a complaint.</label>
                           </div>
                           <div class="form-group">
                              <label>The Complainant may at any point in the complaints process, contact the following </label>
                              <ul>
                                 <li><label>Client Service Manager</label></li>
                                 <li><label>CEO</label></li>
                                 <li><label>National Disability Insurance Agency</label></li>
                                 <li><label>An external support agency</label></li>
                              </ul>
                           </div>
                           <div class="form-group">
                              <label>Included is a list of external providers who can assist you with the complaints process if you prefer.</label>
                           </div>
                           <div class="form-group">
                              <div class="complant-table-agreement">
                                 <table class="table-responsible">
                                    <thead>
                                       <tr>
                                          <th>NSW Ombudsman</th>
                                          <th>National Disability Abuse & Neglect Hotline</th>
                                          <th>Intellectual Disability Rights Service</th>
                                          <th>NSW Council for Intellectually Disabled</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr>
                                          <td>Phone: 1800 451 524</td>
                                          <td>Phone: 1800 880 052</td>
                                          <td>Phone: 9318 0144</td>
                                          <td>Phone: 1800 424 065
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>
                                             Email: 
                                             <p><a href="">nswombo@ombo.nsw.gov.au</a> </p>
                                          </td>
                                          <td>
                                             Email: hotline@workfocus.com
                                          </td>
                                          <td>
                                             Email: 
                                             <p><a href="">info@idrs.org.au</a></p>
                                          </td>
                                          <td>
                                             Email: 
                                             <p><a href="">mail@nswcid.org.au</a> </p>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>
                                             Website: 
                                             <p><a href=""> www.ombo.nsw.gov.au</a> </p>
                                          </td>
                                          <td>
                                             Website: 
                                             <p><a href="">www.disabilityhotline.net.au </a></p>
                                          </td>
                                          <td>
                                             Website: 
                                             <p><a href=""> www.idrs.org.au </a></p>
                                          </td>
                                          <td>
                                             Website: 
                                             <p><a href=""> www.nswcid.org.au </a> </p>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                           <div class="form-group">
                              <h4> Entire Agreement</h4>
                           </div>
                           <div class="form-group">
                              <label>
                              This agreement sets out all of the terms of your supports and services with {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} . This agreement supersedes and replaces 
                              all prior representations, contracts and agreements (whether oral or in writing) detailing your supports and services with <strong>{!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!} . </strong>
                              </label>
                           </div>
                           <div class="form-group">
                              <label>
                              If there are any other matters you wish to discuss further, please let<strong> {!! isset($provider->provider->business_name) ? $provider->provider->business_name : '' !!}  </strong> before you sign this agreement.
                              </label>
                           </div>
                           <div class="form-group">
                              <label>
                              Once you sign this agreement, you are confirming it is complete and no agreed terms are missing.
                              </label>
                           </div>
                        </div>
                     </fieldset>
                     <fieldset class="responsibilite2 mb-5">
                        <legend>Contact details:</legend>
                        <div class="filling-agreement-form-below">
                           <div class="row ">
                              <div class="label col-sm-4">
                                 <div class="form-group">
                                    <label>I</label>
                                 </div>
                              </div>
                              <div class="label col-sm-8">
                                 {!!
                                 Form::text('participant_name', '',  old('participant_name', $participant->getName() ) )
                                 ->id('participant_name')
                                 // ->readonly()
                                 ->hideLabel()
                                 !!}
                              </div>
                              <div class="form-group">
                                 <label>can be contacted on: </label>
                              </div>
                           </div>
                           <div class="row ">
                              <div class="label col-sm-4">
                                 <div class="form-group">
                                    <label>{{ trans('opforms.fields.address')}}:</label>
                                 </div>
                              </div>
                              <div class="label col-sm-8">
                                 {!! 
                                       Form::location('meta[address]', 
                                          trans(''),
                                          valOrAlt( $meta, 'address', $participant, 'address' ),
                                          valOrAlt( $meta, 'participant_lat', $participant, 'lat' ),
                                          valOrAlt( $meta, 'participant_lng', $participant, 'lng' )
                                       )
                                       ->id('address')
                                       ->locationLatName('meta[participant_lat]')
                                       ->locationLngName('meta[participant_lng]')
                                       ->required('required')
                                       ->size('col-sm-12')
                                       ->help(trans('global.user.fields.name_helper'))
                                       ->hideLabel()
                                 !!}
                              </div>
                           </div>
                           <div class="row ">
                              <div class="label col-sm-4">
                                 <div class="form-group">
                                    <label>{{ trans('opforms.fields.phone_mobile')}}</label>
                                 </div>
                              </div>
                              <div class="label col-sm-8">
                                 {!!
                                 Form::text('meta[phone_mobile]', '',  issetKey( $meta, 'phone_mobile', '' ) )
                                 ->id('phone_mobile')
                                 ->attrs([
                                    "required"=>"required",
                                    "data-rule-required"=>"true",
                                    "data-msg-required"=>"Please enter your mobile number",
                                    "data-rule-minlength"=>"10",
                                    "data-rule-number" => "true",
                                    "data-msg-minlength"=>"Mobile number should be 10 digits minimum"
                                 ])
                                 ->hideLabel()
                                 !!}
                              </div>
                           </div>
                           <div class="row ">
                              <div class="label col-sm-4">
                                 <div class="form-group">
                                    <label>{{ trans('opforms.fields.contact_email')}}:</label>
                                 </div>
                              </div>
                              <div class="label col-sm-8">
                                 {!!
                                 Form::text('meta[email]', '',  issetKey( $meta, 'email', valOrAlt( $meta, 'email', $participant, 'email' ) ) )
                                 ->id('particiapnt_email')
                                 ->attrs([
                                    "data-rule-required"=>"true", 
                                    "data-rule-email"=>"true", 
                                    "data-msg-required"=>trans('errors.register.email'),
                                    "data-msg-email"=>trans('errors.register.email_format')  
                                ])
                                 !!}
                              </div>
                           </div>



                           {{-- Fields for Nominee --}}
                          
                           <div class="row ">
                              <div class="label col-sm-4">
                                 <div class="form-group">
                                    <label>{{ trans('opforms.fields.nominee_name')}}:</label>
                                 </div>
                              </div>
                              <div class="label col-sm-8">
                                 {!!
                                 Form::text('meta[nominee_name]', '',  issetKey( $meta, 'nominee_name', '' ) )
                                 ->id('nominee_name')
                                 ->hideLabel() 
                                 !!}
                              </div>
                           </div>

                           <div class="form-group">
                              <label>can be contacted on: </label>
                           </div>
                           <div class="row ">
                              <div class="label col-sm-4">
                                 <div class="form-group">
                                    <label>{{ trans('opforms.fields.address')}}:</label>
                                 </div>
                              </div>
                              <div class="label col-sm-8">
                                 {!! 
                                 Form::location('meta[nominee_address]', 
                                             trans(''), 
                                             issetKey( $meta, 'nominee_address', '' ),
                                             issetKey( $meta, 'nominee_lat', '' ),
                                             issetKey( $meta, 'nominee_lng', '' )
                                    )
                                 ->id('nominee_address')
                                 ->locationLatName('meta[nominee_lat]')
                                 ->locationLngName('meta[nominee_lng]')
                                 ->required('required')
                                 ->help(trans('global.user.fields.name_helper'))
                                 !!}
                              </div>
                           </div>
                           <div class="row ">
                              <div class="label col-sm-4">
                                 <div class="form-group">
                                    <label>{{ trans('opforms.fields.phone_mobile')}}</label>
                                 </div>
                              </div>
                              <div class="label col-sm-8">
                                 {!!
                                 Form::text('meta[nominee_phone]', '',  issetKey( $meta, 'nominee_phone', '' ) )
                                 ->id('nominee_phone')
                                 ->attrs([
                                    "data-msg-required"=>"Please enter your mobile number",
                                    "data-rule-minlength"=>"10",
                                    "data-rule-number" => "true",
                                    "data-msg-minlength"=>"Mobile number should be 10 digits minimum"
                                 ])
                                 !!}
                              </div>
                           </div>
                           <div class="row ">
                              <div class="label col-sm-4">
                                 <div class="form-group">
                                    <label>{{ trans('opforms.fields.contact_email')}}:</label>
                                 </div>
                              </div>
                              <div class="label col-sm-8">
                                 {!!
                                 Form::text('meta[nominee_email]', '',  issetKey( $meta, 'nominee_email', '' ) )
                                 ->id('nominee_email')
                                 ->attrs([
                                    "data-msg-required"=>trans('errors.register.email'),
                                    "data-msg-email"=>trans('errors.register.email_format')  
                                ])
                                 
                                 !!}
                              </div>
                           </div>
                           <div class="row ">
                              <div class="form-group">
                                 <h5>Agreement signatures:</h5>
                              </div>
                              <div class="label col-sm-4">
                                 <div class="form-group">
                                    <label>I</label>
                                 </div>
                              </div>
                              <div class="label col-sm-8">
                                 {!!
                                 Form::text('meta[participant_declartion]', '',  issetKey( $meta, 'participant_declartion', '' ) )
                                 ->id('participant_declartion')
                                 !!}
                              </div>
                              <div class="form-group">
                                 <label>confirm that this agreement has been explained to me and/or my plan nominee and that I/we agree to this:</label>
                              </div>
                           </div>
                           <div class="row ">
                              <div class="label col-sm-4">
                                 <div class="form-group">
                                    <label>Name of Participant: </label>
                                 </div>
                              </div>
                              <div class="label col-sm-8">
                                 {!!
                                 Form::text('participant_name', '',  old('participant_name', $participant->getName() ) )
                                 ->id('participant_name')
                                 // ->readonly()   
                                 !!}
                              </div>
                           </div>
                           <div class="row ">
                              <div class="label col-sm-4">
                                 <div class="form-group">
                                    <label>{{trans('opforms.fields.date')}}</label>
                                 </div>
                              </div>
                              <div class="label col-sm-8">
                                 {!! 
                                 Form::date('meta[signature_date]', '', issetKey( $meta, 'signature_date', todayDate() ) )
                                 ->required('required')
                                 ->help(trans('global.user.fields.name_helper'))
                                 !!}
                              </div>
                           </div>
                           <div class="row ">
                              <div class="label col-sm-4">
                                 <div class="form-group">
                                    <label>Signature of Jill Participant</label>
                                 </div>
                              </div>
                              <div class="label col-sm-8">
                                 @if(isset($meta['participant_signature']))
                                    <img alt="participant_signature" src="{{ $meta['participant_signature'] }}" class="img-fluid" />
                                 @else
                                    @include('template.sign_pad', [ 'id' => 'participant_signature', 'user_id'=>$participant->id, 'name'=>'meta[participant_signature]', 'label' => 'Signature of <span>'.$participant->getName().'</span>' ]) 
                                 @endif
                              </div>
                           </div>
                           <div class="row ">
                              <div class="label col-sm-4">
                                 <div class="form-group">
                                    <label>{{trans('opforms.fields.plan_name')}}</label>
                                 </div>
                              </div>
                              <div class="label col-sm-8">
                                 {!!
                                 Form::text('meta[nominee_name]', '',  issetKey( $meta, 'nominee_name', '' ) )
                                 ->id('nominee_name')
                                 // ->readonly()   
                                 !!}
                              </div>
                           </div>
                           <div class="row ">
                              <div class="label col-sm-4">
                                 <div class="form-group">
                                    <label>{{trans('opforms.fields.date')}}</label>
                                 </div>
                              </div>
                              <div class="label col-sm-8">
                                 {!! 
                                 Form::date('meta[nominee_signature_date]', '', issetKey( $meta, 'nominee_signature_date', todayDate() ) )
                                 ->required('required')
                                 ->help(trans('global.user.fields.name_helper'))
                                 !!}
                              </div>
                           </div>
                           <div class="row ">
                              <div class="label col-sm-4">
                                 <div class="form-group">
                                    <label>Signature of Nominee</label>
                                 </div>
                              </div>
                              <div class="label col-sm-8">
                                 @if(isset($meta['nominee_signature']))
                                    <img alt="nominee_signature" src="{{ $meta['nominee_signature'] }}"  class="img-fluid" />
                                 @else
                                    @include('template.sign_pad', [ 'id' => 'nominee_signature', 'user_id'=>$participant->id, 'name'=>'meta[nominee_signature]', 'label' => 'Signature of Nominee' ]) 
                                 @endif
                              </div>
                           </div>
                           <div class="row ">
                              <div class="label col-sm-4">
                                 <div class="form-group">
                                    <label>Signature on behalf of</label>
                                 </div>
                              </div>
                              <div class="label col-sm-8">
                                 @if(isset($meta['consulting_signature']))
                                    <img alt="consulting_signature" src="{{ $meta['consulting_signature'] }}" class="img-fluid" />
                                 @else
                                    @include('template.sign_pad', [ 'id' => 'consulting_signature', 'user_id'=>$participant->id, 'name'=>'meta[consulting_signature]', 'label' => 'Signature on behalf of' ]) 
                                 @endif
                              </div>
                           </div>
                           <div class="row ">
                              <div class="label col-sm-4">
                                 <div class="form-group">
                                    <label>{{ trans('opforms.fields.date')}}</label>
                                 </div>
                              </div>
                              <div class="label col-sm-8">
                                 {!! 
                                 Form::date('meta[consulting_signature_date]','', issetKey( $meta, 'consulting_signature_date', todayDate() ) )
                                 ->required('required')
                                 ->help(trans('global.user.fields.name_helper'))
                                 !!}
                              </div>
                           </div>
                           <div class="row ">
                              <div class="label col-sm-4">
                                 <div class="form-group">
                                    <label>{{ trans('opforms.fields.name_position')}}</label>
                                 </div>
                              </div>
                              <div class="label col-sm-8">
                                 {!!
                                 Form::text('meta[name_position]', '',  issetKey( $meta, 'name_position', '' ) )
                                 ->id('name_position')
                                 !!}
                              </div>
                           </div>
                           <div class="form-group">
                              <label for="practice_details" class=""><strong>Receipt of the acceptance constitutes an absolute agreement for the provision of the service.</strong> </label>
                           </div>
                        </div>
                     </fieldset>
                     {!! Form::submit('Submit')->attrs(["class"=>"rounded mt-40"]) !!}
                  </div>
                  
               </div>
            </div>
         </form> -->
      </div>
   </div>
</div>