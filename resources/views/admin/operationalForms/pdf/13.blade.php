
<div class="card">
<style>
      .custom-table-pdf table tr td{
         padding-top:10px;
         padding-bottom:15px;
         padding-left:0px;
         border-bottom:1px solid #e7e6e8;
         padding-right:0px;
         margin-left:-2px;
      }
   </style>
   <div class="card-body">
      <div class="operational-form-design" style="font-family: 'Open Sans', sans-serif; border:1px solid #777d; padding:15px;">
         <div>
            <h4 style="font-size: 2rem;
            font-weight: 500;
            margin-bottom: 10px; text-align:center;">ENGAGEMENT AGREEMENT</h4>
         </div>
           </thead>
           <div class="custom-table-pdf">
               <table class="table">
               <tbody>
                  <tr>
                     <td style="background:none;">
                        <label>{{ $roleName }}</label>
                     </td>
                     <td style="">
                        {!! old('sw_esw_name', $participant->getName() ) !!}
                     </td>
                  </tr>
                  <tr>
                     <td style="background:none;">
                        <label>  {!! trans('opforms.fields.provider_and_business', [ 'provider_name'=>$provider->getName(), 'business'=> (isset($provider->provider->business_name) && $provider->provider->business_name!='')?$provider->provider->business_name:$provider->getName() ]) !!}</label>
                     </td>
                     <td style="background:none;">
                     {!! old('provider_name', isset($provider->id) ? $provider->getName() : '') !!}
                     </td>
                  </tr>
                  <tr>
                     <td style="background:none;">
                        <label>  {{ trans('sw.fields.registration_groups') }}</label>
                     </td>
                     <td>
                        @foreach($registration_groups as $id => $registration_groups)
                           <li>{{ $registration_groups }}</li>
                        @endforeach
                     </td>
                  </tr>               
               </tbody>
               </table>
            </div>

            <div class="col-sm-12 mt-40">
               <div class="form-group form-border-bottom">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">1</span>
                     <h3 for="employe_first_name" class=""> Employment </h3>
                  </div>
               </div>
               <div class="form-group" style="padding-left:20px;">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">1.1</span>
                     <label> shall be employed by the employer as a Subcontractor in the role of<strong> {{ $roleName }} </strong> to the terms and conditions set out in this agreement. </label>
                  </div>
               </div>
               <div class="form-group" style="padding-left:20px;">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">1.2</span>
                     <label> The duties and responsibilities of your position are to act as a  
                     <strong>{{ $roleName }}</strong>   of the employer and to carry out such other duties as
                     the employer may allocate from time to time. </label>
                  </div>
               </div>
            </div>
            <div class="col-sm-12 mt-40">
               <div class="form-group form-border-bottom">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">2</span>
                     <h3 for="employe_first_name" class=""> Your Responsibilities</h3>
                  </div>
               </div>
               <div class="form-group" style="padding-left:20px;">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">2.1</span>
                     <div class="custopm-sw-list">
                        <label>You must:</label>
                        <div class="inline-box">
                           <span class="pd-r">2.1.1</span>
                           <label>serve the employer faithfully, diligently and to the best of your ability;</label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">2.1.2</span>
                           <label>act in the best interests of the employer;</label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">2.1.3</span>
                           <label>comply with all directions of the employer from time to time;</label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">2.1.4</span>
                           <label>comply with all laws that apply to your position and the duties assigned to you;</label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">2.1.5</span>
                           <label>dedicate all of your time and attention to the employer during your hours of work;</label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">2.1.6</span>
                           <label>inform yourself of and comply with all the employer policies and procedures; and</label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">2.1.7</span>
                           <label>not act in conflict with the employer’s 
                           interests or engage in any business or activity for any Competitor, without the prior written approval of the employer.</label>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-sm-12 mt-40">
               <div class="form-group form-border-bottom">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">3</span>
                     <h3 for="employe_first_name" class="">Commencement and duration </h3>
                  </div>
               </div>
               <div class="form-group" style="padding-left:20px;">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">3.1</span>
                     <div class="row">
                        <div class="label col-sm-4">
                           <div class="form-group">
                              <label> {!! trans('opforms.fields.date') !!} </label>
                           </div>
                        </div>
                        <div class="label col-sm-8">
                           {!! 
                           Form::date('meta[agreement_start_date]', '', old('agreement_start_date', isset($meta['agreement_start_date']) ? $meta['agreement_start_date'] : date('d-m-Y')))
                           ->id('date-1')
                           ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Duration date required" ])
                           ->hideLabel()
                           ->help(trans('bookings.fields.date_helper'))
                           !!}
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-sm-12 mt-40">
               <div class="form-group form-border-bottom">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">4</span>
                     <h3 for="employe_first_name" class="">Probationary period </h3>
                  </div>
               </div>
               <div class="form-group" style="padding-left:20px;">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">4.1</span>
                     <label>
                        You will be employed for a probationary period of 6 months from:
                        <div class="row">
                           <div class="label col-sm-4">
                              <div class="form-group">
                     <label> {!! trans('opforms.fields.date') !!} </label>
                     </div>
                     </div>
                     <div class="label col-sm-8">
                     {!! 
                     Form::date('meta[agreement_probationary_date]', '', old('agreement_probationary_date', isset($meta['agreement_probationary_date']) ? $meta['agreement_probationary_date'] : date('d-m-Y')))
                     ->id('agreement_probationary_date')
                     ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Duration date required" ])
                     ->hideLabel()
                     ->help(trans('bookings.fields.date_helper'))
                     !!}
                     </div>
                     </div>
                     The probationary period does not 
                     include any time off such as sick leave or holidays.  For example, if you have 3 days leave
                     (for any reason) during your first three months with us then the probationary period shall be extended by 3 days.</label>
                  </div>
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">4.2</span>
                     <label>During the probationary period either you or the employer may terminate this agreement by 
                     giving one week's notice in writing or by the employer making a payment equivalent to one week's salary instead of giving notice.</label>
                  </div>
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">4.3</span>
                     <label>The probationary period may be extended by agreement with you.</label>
                  </div>
               </div>
            </div>
            <div class="col-sm-12 mt-40">
               <div class="form-group form-border-bottom">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">5</span>
                     <h3 for="employe_first_name" class=""> Hours of work</h3>
                  </div>
               </div>
               <div class="form-group" style="padding-left:20px;">
                  <div class="agrrement-support-list">
                     <span class="pd-r">5.1</span>
                     <div class="custopm-sw-list">
                        <div class="inline-box">
                           <label>You will be required to do the work necessary and reasonable to meet the requirements of your position.  
                           You will devote substantially the whole of your time and attention during the ordinary business hours of the employer to the discharge of 
                           your duties and shall conform to such hours of work as may from time to time reasonably be required by the employer. </label>
                        </div>
                     </div>
                  </div>
                  <div class="agrrement-support-list">
                     <span class="pd-r">5.2</span>
                     <div class="custopm-sw-list">
                        <div class="inline-box">
                           <label>The days and hours during which you are required to work will normally be: </label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">5.1</span>
                           <label><strong>On a casual basis . </strong></label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">5.2.2</span>
                           <label>Commence at varied shifts throughout the week or as directed by the Director.</label>
                        </div>
                     </div>
                  </div>
                  <div class="agrrement-support-list">
                     <span class="pd-r">5.3</span>
                     <div class="custopm-sw-list">
                        <div class="inline-box">
                           <label>In the event that in any given week you work less than (5) days, which shall be by consent of the employer and not by 
                           reason of leave pursuant to this agreement, then your 
                           remuneration shall be on the basis of time actually worked and the balance of time in that week shall be treated as leave without pay. </label>
                        </div>
                     </div>
                  </div>
                  <div class="agrrement-support-list">
                     <span class="pd-r">5.4</span>
                     <div class="custopm-sw-list">
                        <div class="inline-box">
                           <label>The employer reserves the right to vary your days or hours of work, or both.  </label>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-sm-12 mt-40">
               <div class="form-group form-border-bottom">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">6</span>
                     <h3 for="employe_first_name" class="">Remuneration and other benefits</h3>
                  </div>
               </div>
               <div class="form-group" style="padding-left:20px;">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">6.1</span>
                     <label>You will be paid per completed project.</label>
                  </div>
               </div>
               <div class="form-group" style="padding-left:20px;">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">6.2</span>
                     <label>As  a subcontractor you are not entitled to any superannuation. </label>
                  </div>
               </div>
            </div>
            <div class="col-sm-12 mt-40">
               <div class="form-group form-border-bottom">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">7</span>
                     <h3 for="employe_first_name" class="">Offset</h3>
                  </div>
               </div>
               <div class="form-group" style="padding-left:20px;">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">7.1</span>
                     <div class="custopm-sw-list">
                        <label>If a law or industrial instrument (including a modern award) applies to your employment at any time: </label>
                        <div class="inline-box">
                           <span class="pd-r">7.1.1</span>
                           <label>your TR will fully satisfy your minimum entitlements (including overtime, wages, allowances, 
                           penalties and loadings) under the law or industrial instrument; </label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">7.1.2</span>
                           <label>if any entitlement arises under a law or industrial instrument, that entitlement will be calculated by 
                           reference to the applicable rate of pay in the law or industrial instrument; and</label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">7.1.3</span>
                           <label>the law or industrial instrument will apply to your employment as a matter of law and will not form part of this Agreement. </label>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-sm-12 mt-40">
               <div class="form-group form-border-bottom">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">8</span>
                     <h3 for="employe_first_name" class="">Leave</h3>
                  </div>
               </div>
               <div class="custom-group" style="padding-left:20px;" >
                  <div class="form-group">
                     <label class="italic">Annual Leave</label>
                     <div class="agrrement-support-list">
                        <span class="pdd-right-30">8.1</span>
                        <label>As a subcontractor, you are not entitled to annual leave. </label>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="agrrement-support-list">
                        <span class="pdd-right-30">8.2</span>
                        <label>Other than by agreement with the employer, you are not entitled to take leave during your probationary period.  </label>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="agrrement-support-list">
                        <span class="pdd-right-30">8.3</span>
                        <label>You will be entitled to the gazetted public holidays recognised at your work location.  You will be paid for any public holiday which falls on a day of the week that you are otherwise scheduled to work </label>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="italic">Sick leave</label>
                     <div class="agrrement-support-list">
                        <span class="pdd-right-30">8.4</span>
                        <label>You will not be  entitled to sick leave as set out in the Act. </label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-sm-12 mt-40">
               <div class="form-group form-border-bottom">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">9</span>
                     <h3 for="employe_first_name" class="">Legislation and employer policies</h3>
                  </div>
               </div>
               <div class="form-group" style="padding-left:20px;">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">9.1</span>
                     <label>You are subject to and required to observe all State and Commonwealth legislation impacting on your work.  You are also required to read all employer policies (a copy of which is provided with this contract)
                     and ensure that you abide by these and any future firm policies or instructions as varied from time to time.</label>
                  </div>
               </div>
               <div class="form-group" style="padding-left:20px;">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">9.2</span>
                     <label>Attached to this agreement is a copy of the ‘Fair Work Information Statement’ produced by the Fair Work Ombudsman.   </label>
                  </div>
               </div>
            </div>
            <div class="col-sm-12 mt-40">
               <div class="form-group form-border-bottom">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">10</span>
                     <h3 for="employe_first_name" class="">Intellectual Property</h3>
                  </div>
               </div>
               <div class="form-group" style="padding-left:20px;">
                  <label class="italic">Disclosure</label>
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">10.1</span>
                     <div class="custopm-sw-list">
                        <label>You must disclose and deliver to the employer: </label>
                        <div class="inline-box">
                           <span class="pd-r">10.1.1</span>
                           <label>all materials, works, ideas, concepts, designs, developments, improvements, systems; and</label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">10.1.2</span>
                           <label>anything else made during the course of your employment or where you used the employer’s time, material or facilities</label>
                        </div>
                     </div>
                  </div>
                  <label>whether created by yourself or with others (Materials).</label>
                  <label class="italic">Ownership of Intellectual Property Rights</label>
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">10.2</span>
                     <div class="custopm-sw-list">
                        <label>You agree that:  </label>
                        <div class="inline-box">
                           <span class="pd-r">10.2.1</span>
                           <label>all materials will be the sole property of the employer; and</label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">10.2.2</span>
                           <label>you will assign all Intellectual Property Rights in the Materials to the employer, for its use.</label>
                        </div>
                        <label class="italic">Continuing obligations</label>
                     </div>
                  </div>
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">10.3</span>
                     <div class="custopm-sw-list">
                        {{-- <label>Continuing obligations  </label> --}}
                        <div class="inline-box">
                           <label>Your obligations under this clause continue to apply after your employment ends. </label>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-sm-12 mt-40">
               <div class="form-group form-border-bottom">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">11</span>
                     <h3 for="employe_first_name" class="">Confidentiality</h3>
                  </div>
               </div>
               <div class="form-group" style="padding-left:20px;">
                  {{-- <label class="italic">Disclosure</label> --}}
                  <div class="agrrement-support-list" style="padding-left:20px;">
                     <span class="pdd-right-30">11.1</span>
                     <div class="custopm-sw-list">
                        <label>
                        During and after the term of this agreement you <strong> must </strong> treat all information regarding the employer's and its clients' 
                        business and affairs with the strictest confidentiality (“Confidential Information”).  
                        You must not disclose Confidential Information regarding any person connected or associated with the employer's and its 
                        clients' business 
                        </label>
                        <label>
                        without the written consent of the employer and that person.  You must not copy, reproduce or store 
                        in a retrieval system or data base Confidential Information 
                        regarding any person, product, service, project or development, except 
                        to perform your duties, functions and responsibilities arising out of your employment.
                        </label>
                     </div>
                  </div>
                  <div class="agrrement-support-list" style="padding-left:20px;">
                     <span class="pdd-right-30">11.2</span>
                     <div class="custopm-sw-list">
                        <label>
                        You must use Confidential Information solely to perform your duties; 
                        </label>
                        <div class="inline-box">
                           <span class="pd-r">11.1.1</span>
                           <label>
                           all materials, works, ideas, concepts, designs, developments, improvements, systems; and
                           </label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">11.1.2</span>
                           <label>
                           anything else made during the course of your employment or where you used the employer’s time, material or facilities
                           </label>
                        </div>
                     </div>
                  </div>
                  <div class="agrrement-support-list" style="padding-left:20px;">
                     <span class="pdd-right-30">11.3</span>
                     <div class="custopm-sw-list">
                        <label>
                        You must disclose Confidential Information only:  
                        </label>
                        <div class="inline-box">
                           <span class="pd-r">11.3.1</span>
                           <label>
                           to anyone who has been approved by the employer to receive the Confidential Information and who 
                           agrees that the Confidential Information must be kept confidential; or
                           </label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">11.3.2</span>
                           <label>
                           if required by law; and
                           </label>
                        </div>
                     </div>
                  </div>
                  <div class="custom-group" style="padding-left:20px;">
                     <label>if you are required to disclose Confidential Information, first notify the employer of that requirement.  
                     If that is not possible, you must notify the employer of the disclosure immediately after the disclosure. </label>
                     <div class="agrrement-support-list">
                        <span class="pdd-right-30">11.4</span>
                        <div class="custopm-sw-list">
                        <label>
                        You must:   
                        </label>
                        <div class="inline-box">
                           <span class="pd-r">11.4.1</span>
                           <label>
                           immediately notify the employer of any suspected or actual unauthorised use, copying or disclosure of Confidential Information by anyone; and
                           </label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">11.4.2</span>
                           <label>
                           if requested by the employer, provide assistance regarding any proceedings the employer may take against 
                           anyone for unauthorised use, copying or disclosure of Confidential Information.
                           </label>
                        </div>
                        </div>
                     </div>
                  </div>
                  <div class="agrrement-support-list" style="padding-left:20px;">
                     <span class="pdd-right-30">11.5</span>
                     <div class="custopm-sw-list">
                        <div class="inline-box">
                           {{-- <span class="pd-r">10.1.1</span> --}}
                           <label>
                           Any breach by the employee of the terms of clause<strong> [11.1], [11.2] or [11.3]</strong> may lead to immediate dismissal of the employee and termination of this 
                           Agreement with immediate loss by the employee of any rights or entitlements for payment by the employer. 
                           </label>
                        </div>
                     </div>
                  </div>
                  <div class="agrrement-support-list" style="padding-left:20px;">
                     <span class="pdd-right-30">11.6</span>
                     <div class="custopm-sw-list">
                        <div class="inline-box">
                           {{-- <span class="pd-r">10.1.1</span> --}}
                           <label>
                           Your obligations under this clause continue to apply after your employment ends
                           </label>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-sm-12 mt-40">
               <div class="form-group form-border-bottom">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">12</span>
                     <h3 for="employe_first_name" class="">Proprietary Rights</h3>
                  </div>
               </div>
               <div class="form-group" style="padding-left:20px;">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">12.1</span>
                     <label>Your work results are the property of the employer as sole owner.  You will assign to the employer all right, title and interest to such work 
                     results and do such acts and things as the employer may require to effect this assignment</label>
                  </div>
               </div>
               <div class="form-group" style="padding-left:20px;">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">12.2</span>
                     <label>On termination of this agreement or your employment you must return to the employer all originals and copies in any form (including computer data) of all books, records and documents
                     relating to your duties, functions and responsibilities as an employee of the employer. </label>
                  </div>
               </div>
            </div>
            <div class="col-sm-12 mt-40">
               <div class="form-group form-border-bottom">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">13</span>
                     <h3 for="employe_first_name" class="">Termination</h3>
                  </div>
               </div>
               <div class="form-group" style="padding-left:20px;">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">13.1</span>
                     <div class="custopm-sw-list">
                        <label>
                        Subject to clause <strong>[14]</strong> which relates to resignation this agreement may be terminated: </label>
                        <div class="inline-box">
                           <span class="pd-r">13.1.1</span>
                           <label>
                           by agreement in writing between the parties at any time; 
                           </label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">13.1.2</span>
                           <label>
                           by the employer giving to you 1 weeks’ notice in writing;
                           </label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">13.1.3</span>
                           <label>
                           by immediate dismissal, without pay in lieu of notice, in cases of misconduct (for example, a breach under clause <strong>[11]).</strong>
                           </label>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="form-group" style="padding-left:20px;">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">13.2</span>
                     <label>The employer is not required to give notice of termination for conduct that justifies instant dismissal. </label>
                  </div>
               </div>
               <div class="form-group" style="padding-left:20px;">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">13.3</span>
                     <div class="custopm-sw-list">
                        <label>
                        At its sole discretion, the employer may require you to work all or part of any notice period.  In these circumstances
                        </label>
                        <div class="inline-box">
                           <span class="pd-r">13.3.1</span>
                           <label>
                           for the part of any notice period you are required to work the employer will continue to pay you your TR; and 
                           </label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">13.3.2</span>
                           <label>
                           for the part of any notice period you are not required to work, the employer will pay you your TR and any other 
                           payments that it is required to make under the Act in lieu of notice
                           </label>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="form-group" style="padding-left:20px;">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">13.4</span>
                     <div class="custopm-sw-list">
                        <label>
                        During any notice period given by the employer or by you, the employer may require you to:
                        </label>
                        <div class="inline-box">
                           <span class="pd-r">13.4.1</span>
                           <label>
                           not attend work or any the employer’s premises
                           </label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">13.4.2</span>
                           <label>
                           perform duties which are different from those which you were required to
                           perform during the rest of your employment with the employer, including working from a different location;
                           </label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">13.4.3</span>
                           <label>
                           not have contact with any clients, customers, contractors or employees of the employer; 
                           </label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">13.4.4</span>
                           <label>
                           not access the computer or IT systems of the employer; or
                           </label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">13.4.5</span>
                           <label>
                           return any of the employer’s property to the employer, including Confidential Information belonging to the employer.
                           </label>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="form-group" style="padding-left:20px;">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">13.5</span>
                     <div class="custopm-sw-list">
                        <label>
                        If you engage in serious misconduct, your employment and this Agreement may be terminated by the employer 
                        by giving you notice in writing, effective immediately.  Serious misconduct includes, without limitation:
                        </label>
                        <div class="inline-box">
                           <span class="pd-r">13.5.1</span>
                           <label>
                           wilful or deliberate conduct that is inconsistent with your employment continuing
                           </label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">13.5.2</span>
                           <label>
                           any breach of any material provision of this Agreement or any law which applies to your employment;
                           </label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">13.5.3</span>
                           <label>
                           conduct that causes an imminent or serious risk to the health or safety of a person or the reputation, viability or profitability of the employer’s business;
                           </label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">13.5.4</span>
                           <label>
                           theft, fraud, dishonesty or assault;
                           </label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">13.5.5</span>
                           <label>
                           being under the influence of alcohol or illegal drugs at work;
                           </label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">13.5.6</span>
                           <label>
                           being charged with a criminal offence (other than an offence which in the reasonable opinion of the employer does not affect your position as an employee);
                           </label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">13.5.7</span>
                           <label>
                           a breach of your obligations of Confidentiality as set out in Clause [10] herein;
                           </label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">13.5.8</span>
                           <label>
                           a breach of an applicable policy of the employer, including policies relating to email and internet use, OHS, discrimination and harassment or rehabilitation and environment; or
                           </label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">13.5.9</span>
                           <label>
                           refusing to carry out a lawful instruction.
                           </label>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-sm-12 mt-40">
               <div class="form-group form-border-bottom">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">14</span>
                     <h3 for="employe_first_name" class=""> Resignation</h3>
                  </div>
               </div>
               <div class="form-group" style="padding-left:20px;">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">14.1</span>
                     <div class="custopm-sw-list">
                        <label>If you resign then you must: </label>
                        <div class="inline-box">
                           <span class="pd-r">14.1.1</span>
                           <label>immediately return any of the employer’s property to the employer, 
                           including any Confidential Information and intellectual property belonging to the employer </label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">14.1.2</span>
                           <label>give to the employer 4 weeks’ notice in writing (which shall be exclusive of any leave periods).</label>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="form-group" style="padding-left:20px;">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">14.2</span>
                     <div class="custopm-sw-list">
                        <label>
                        If you resign without giving the employer the agreed amount of notice, 
                        the employer may withhold payment corresponding to the shortfall in the notice given from any moneys owing to you by the employer.
                        </label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-sm-12 mt-40">
               <div class="form-group form-border-bottom">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">15</span>
                     <h3 for="employe_first_name" class=""> Abandonment of employment</h3>
                  </div>
               </div>
               <div class="form-group" style="padding-left:20px;">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">15.1</span>
                     <div class="custopm-sw-list">
                        <label>If you fail to attend for work for 3 consecutive days of your usual work days without informing the employer: </label>
                        <div class="inline-box">
                           <span class="pd-r">15.1.1</span>
                           <label>you will be taken to have abandoned your employment from the last day you worked; and</label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">15.1.2</span>
                           <label>
                           you will be taken to have resigned your employment on and from the last day you worked
                           </label>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-sm-12 mt-40">
               <div class="form-group form-border-bottom">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">16</span>
                     <h3 for="employe_first_name" class="">Requirements after your employment ends</h3>
                  </div>
               </div>
               <div class="form-group" style="padding-left:20px;">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">16.1</span>
                     <div class="custopm-sw-list">
                        <label>After your employment ends, in addition to any post-employment restrictions you may have under this Agreement:</label>
                        <div class="inline-box">
                           <span class="pd-r">16.1.1</span>
                           <label>you must immediately return any of the employer’s property to the employer, including any Confidential Information belonging to the employer</label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">16.1.2</span>
                           <label>
                           you must not represent that you are, or continue to be, associated with the employer; and
                           </label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">16.1.3</span>
                           <label>
                           you must provide any assistance reasonably requested by the employer concerning any threatened or actual proceedings against the employer.
                           </label>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-sm-12 mt-40">
               <div class="form-group form-border-bottom">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">17</span>
                     <h3 for="employe_first_name" class="">Payments on termination</h3>
                  </div>
               </div>
               <div class="form-group" style="padding-left:20px;">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">17.1</span>
                     <div class="custopm-sw-list">
                        <label>On termination of your employment for any reason, the employer will not make any payment to you other than: </label>
                        <div class="inline-box">
                           <span class="pd-r">17.1.1</span>
                           <label>
                           your TR due to you for work you have performed up to your last day of work;
                           </label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">17.1.2</span>
                           <label>
                           any superannuation contributions the employer must pay under applicable legislation for work you have performed 
                           up to your last day of work, and where a payment instead of notice is made, if any, for that notice period; and
                           </label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">17.1.3</span>
                           <label>
                           a payment for any unused annual leave or long service leave, or both that you are entitled to under applicable
                           legislation as at your last day of work.
                           </label>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-sm-12 mt-40">
               <div class="form-group form-border-bottom">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">18</span>
                     <h3 for="employe_first_name" class="">Post employment restrictions</h3>
                  </div>
               </div>
               <div class="form-group" style="padding-left:20px;">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">18.1</span>
                     <div class="custopm-sw-list">
                        <label>For 12 months after the date of termination of your employment (“the Restraint Period”), and within 5 kilometres
                        of the place of business of the employer (“the Restraint Area”), you must not: </label>
                        <div class="inline-box">
                           <span class="pd-r">18.1.1</span>
                           <label>
                           canvass, solicit, approach or accept any approach from, or deal in any way with, any client or customer of the employer with a view to
                           obtaining the custom or dealing with that client or customer in a Restrained Business;
                           </label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">18.1.2</span>
                           <label>
                           induce or encourage any employee or contractor of the employer with whom you had dealings during the last 12 months of
                           your employment to leave their employment or engagement with the employer; or
                           </label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">18.1.3</span>
                           <label>
                           interfere with the relationship between the employer and any of their clients, customers, suppliers, employees, agents or contractors.
                           </label>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-sm-12 mt-40">
               <div class="form-group form-border-bottom">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">19</span>
                     <h3 for="employe_first_name" class="">Office equipment & facilities</h3>
                  </div>
               </div>
               <div class="form-group" style="padding-left:20px;">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">19.1</span>
                     <div class="custopm-sw-list">
                        <label>
                        You shall not use any office equipment or facilities for your own personal use except by agreement or consent with the employer.  In this regard:
                        </label>
                        <div class="inline-box">
                           <span class="pd-r">19.1.1</span>
                           <label>
                           you shall not use any computer to access the internet unless connected with your duties, 
                           requested to do so by the employer or with the consent of the employer.
                           </label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">19.1.2</span>
                           <label>
                           you shall not use any computer for the sending or receipt of email unless connected with your duties,
                           requested to do so by the employer or with the consent of the employer.
                           </label>
                        </div>
                        <div class="inline-box">
                           <span class="pd-r">19.1.3</span>
                           <label>
                           you shall not use any telephone or facsimile equipment for personal use unless with the consent of the employer.
                           </label>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-sm-12 mt-40">
               <div class="form-group form-border-bottom">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">20</span>
                     <h3 for="employe_first_name" class="">Workplace Surveillance</h3>
                  </div>
               </div>
               <div class="form-group" style="padding-left:20px;">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">20.1</span>
                     <div class="custopm-sw-list">
                        <label>
                        The employer notifies you that continuous ongoing camera, computer and tracking surveillance may be carried out in your workplace. 
                        You agree to this surveillance from the start of your employment.
                        </label>
                     </div>
                  </div>
               </div>
               <div class="form-group" style="padding-left:20px;">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">20.2</span>
                     <div class="custopm-sw-list">
                        <label>
                        In areas where camera surveillance occurs, notices reminding you of that surveillance will be displayed.  Computers may also be subject to surveillance.  
                        The security system installed in your workplace may allow tracking by recording when and where employees use their access codes.
                        </label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-sm-12 mt-40">
               <div class="form-group form-border-bottom">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">21</span>
                     <h3 for="employe_first_name" class="">General Provisions</h3>
                  </div>
               </div>
               <div class="form-group" style="padding-left:20px;">
                  <div class="agrrement-support-list">
                     <span class="pdd-right-30">21.1</span>
                     <div class="custopm-sw-list">
                        <label>
                        This Agreement is governed by and construed under New South Wales law.  Any legal action relating to this Agreement against you or the employer may be brought in any court of competent jurisdiction in New South Wales, 
                        and you and the employer irrevocably, generally and unconditionally submit to the nonexclusive jurisdiction of the courts of that State.
                        </label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-sm-12 mt-40">
               <div class="form-group">
                  <div class="agrrement-support-list">
                     <div class="custopm-sw-list">
                        <label>
                        Signed for and on behalf of 
                        </label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-sm-12 mt-40">
               <div class="row">
                  <div class="label col-sm-4">
                     <div class="form-group">
                        <label> {{ 'Provider Signature' }} </label>
                     </div>
                  </div>
                  <div class="label col-sm-8">
                     @if(isset($meta['provider_signature']))
                     <img alt="provider_signature" style="width:270px;" src="{{ $meta['provider_signature'] }}" />
                     @else
                     @include('template.sign_pad', [ 'id' => 'provider_signature', 'user_id'=>'1', 'name'=>'meta[provider_signature]', 'label' => '' ])
                     @endif
                  </div>
               </div>
               <div class="row">
                  <div class="label col-sm-4">
                     <div class="form-group">
                        <label> {{ trans('opforms.fields.full_name') }} </label>
                     </div>
                  </div>
                  <div class="label col-sm-8">
                     {!! 
                     Form::text('provider_name', '', old('provider_name', isset($provider->id) ? $provider->getName() : '') )
                     ->id('provider_name')
                     ->required('required')
                     ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Provider full name required" ])
                     ->readonly($readOnly)
                     ->hideLabel()
                     ->help(trans('global.user.fields.name_helper'))
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="label col-sm-4">
                     <div class="form-group">
                        <label> {{ trans('opforms.fields.date') }} </label>
                     </div>
                  </div>
                  <div class="label col-sm-8">
                     {!! 
                     Form::date('meta[provider_signature_date]', '', old('provider_signature_date', isset($meta['provider_signature_date']) ? $meta['provider_signature_date'] : date('d-m-Y')))
                     ->id('date-3')
                     ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Date of signature required" ])
                     ->required()
                     ->hideLabel()
                     ->help(trans('bookings.fields.date_helper'))
                     !!}
                  </div>
               </div>
               <div class="form-group col-sm-12">
                  <label for="employe_first_name" class="">By signing below, I acknowledge that I have read and fully understand and accept 
                  the terms and conditions of this agreement:</label>
               </div>
               <div class="row">
                  <div class="label col-sm-4">
                     <div class="form-group">
                        <label> {{ $roleName . ' Signature' }} </label>
                     </div>
                  </div>
                  <div class="label col-sm-8">
                     @if(isset($meta['worker_signature']))
                     <img alt="worker_signature"  style="width:270px;" src="{{ $meta['worker_signature'] }}" />
                     @else
                     @include('template.sign_pad', [ 'id' => 'worker_signature', 'user_id'=>'1', 'name'=>'meta[worker_signature]', 'label' => '' ])
                     @endif
                  </div>
               </div>
               <div class="row">
                  <div class="label col-sm-4">
                     <div class="form-group">
                        <label> {{ $roleName }} </label>
                     </div>
                  </div>
                  <div class="label col-sm-8">
                     {!! 
                     Form::text('sw_esw_name', '' , old('sw_esw_name', $participant->getName() ) )
                     ->id('sw_esw_name')
                     ->required('required')
                     ->readonly($readOnly)
                     ->hideLabel()
                     ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Support Worker/External Service Provider name required" ])
                     ->help(trans('global.user.fields.name_helper'))
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="label col-sm-4">
                     <div class="form-group">
                        <label> {{ trans('opforms.fields.date') }} </label>
                     </div>
                  </div>
                  <div class="label col-sm-8">
                     {!! 
                     Form::date('meta[worker_signature_date]', '', old('worker_signature_date', isset($meta['worker_signature_date']) ? $meta['worker_signature_date'] : date('d-m-Y')))
                     ->id('date-4')
                     ->required()
                     ->hideLabel()
                     ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Signature date required" ])
                     ->help(trans('bookings.fields.date_helper'))
                     !!}
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
