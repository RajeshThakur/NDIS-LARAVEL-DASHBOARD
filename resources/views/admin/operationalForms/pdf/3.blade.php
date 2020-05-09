<div class="card">
   <div class="card-body">
      <div class="operational-form-design"  style="font-family: 'Open Sans', sans-serif; border:1px solid #777d; padding:15px;">
         <div class="card-header">
            <h2 style=" text-align:center; margin-bottom:20px;">Client Consent Form</h2>
         </div>
         <div class="form-group" style="border-bottom:1px solid #e7e6e8; margin-bottom:15px">
            <label style="padding-right:200px; padding-bottom:15px; display:inline-block;">{{trans('opforms.fields.client_name')}}</label>
            <span style="padding-bottom:10px; padding-bottom:15px; display:inline-block;">{!! old('client_full_name', $participant->getName() )  !!}</span>
         </div>
         <div class="below-form">
            <div class="form-group">
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
                     <span>{!! old('third_party_name', isset($meta['third_party_name']) ? ($meta['third_party_name']) : '') !!}</span>
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
                        <img alt="client_signature_form" style="width:270px;" src="{{ $meta['client_signature_form'] }}" />
                     @else
                     <span style="font-size:22px; display:block;">Signature have not signed</span>
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
                           <span>{!! old('client_signature_date', isset($meta['client_signature_date']) ? $meta['client_signature_date'] : '') !!}</span>
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
                     <img alt="staff_member_signature" style="width:270px;" src="{{ $meta['staff_member_signature'] }}" />
                     @else
                     <span style="font-size:22px; display:block;">Signature have not signed</span>
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
                           <span>{!! old('staff_member_signature_date', isset($meta['staff_member_signature_date']) ? $meta['staff_member_signature_date'] : '' ) !!}</span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>         
      </div>
   </div>
</div>