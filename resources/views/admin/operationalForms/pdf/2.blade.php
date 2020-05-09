<div class="card">
   <div class="card-body">
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
      <div class="operational-form-design custom-table-pdf">
         <div class="table-responsive" style="font-family: 'Open Sans', sans-serif; border:1px solid #777d; padding:15px;">
            <h2 style="font-size: 24px;
            font-weight: 500;
            margin-bottom: 20px;  text-align:center;">CLIENT DETAILS</h2>
            <table class="table">
              <tbody>
              <tr style="padding-bottom:15px;">
                  <td style="background:none; padding-right:226px;">
                  <label>{{trans('opforms.fields.client_name')}}</label>
                  </td>
                  <td style="text-align:right;">
                     {!! old('client_full_name', $participant->getName() ) !!}
                  </td>
               </tr>
               <tr style="padding-bottom:15px;">
                  <td style="background:none;">
                     <label>{{ trans('opforms.fields.date_of_birth') }}</label>
                  </td>
                  <td style="background:none; text-align:right;">
                     {!! old('client_date_of_birth', isset($meta['client_date_of_birth']) ? $meta['client_date_of_birth'] : '' ) !!}
                  </td>
               </tr>
               <tr style="padding-bottom:15px;">
                  <td style="background:none;">
                     <label>{{trans('opforms.fields.address') }}</label>
                  </td>
                  <td style="text-align:right;">
                   {!! valOrAlt( $meta, 'client_residential', $participant, 'address' ) !!}
                  </td>
               </tr>
               <tr style="padding-bottom:15px;">
                  <td style="background:none;">
                  <label style="paading-right:150px;">{{trans('opforms.fields.client_goal')}} : </label>
                  </td>
                  <td style="text-align:right;">
                  <label style="text-align-right">{!! issetKey( $meta, 'client_goal', '' ) !!} </label>
                  </td>
               </tr>
              </tbody>
            </table>
                  <!-- <div>
                     <label style="paading-right:150px;">{{trans('opforms.fields.client_goal')}} : </label>
                     <label style="text-align-right">{!! issetKey( $meta, 'client_goal', '' ) !!} </label>
                  </div> -->
            <div class="form-group" style="margin-top:30px;">
               <h4 style="margin-bottom:0;">SERVICES AND INTERVENTIONS</h4>
            </div>
            <table>
               <tbody>
               <tr style="padding-bottom:15px;">
                  <td>
                     <label>{{trans('opforms.fields.client_meal_name')}}</label>
                  </td>
                  <td style="text-align:right;">
                     {!! issetKey( $meta, 'client_meal_name', '' )!!}
                  </td>
               </tr>
               <tr style="padding-bottom:15px;">
                  <td>
                     <label>{{trans('opforms.fields.transportation')}}</label>
                  </td>
                  <td style="text-align:right;">
                     {!! issetKey( $meta, 'transportation', '' )!!}
                  </td>
               </tr>
               <tr style="padding-bottom:15px;">
                  <td>
                     <label>{{trans('opforms.fields.details')}}</label>
                  </td>
                  <td style="text-align:right;">
                     {!! issetKey( $meta, 'details', '' )!!}
                  </td>
               </tr>
               <tr style="padding-bottom:15px;">
                  <td>
                     <label>{{trans('opforms.fields.advocate_agree_plan', [ 'client_name'=>$participant->getName() ])}}</label>
                  </td>
                  <td style="text-align:right;">
                     {!! issetKey( $meta, 'being_an_advocate', '' )!!}
                  </td>
               </tr>
               </tbody>
            </table>
               
            <label for="named-client">Client Signature</label>      
            @if(isset($meta['client_signature_form']))
               <img alt="client_signature_form" style="width:300px;" class="opform_signature" src="{{ $meta['client_signature_form'] }}" />
            @else
            <span style="font-size:22px;">Signature have not signed</span>
            @endif
            
            <table>
               <tbody>
               <tr style="padding-bottom:15px;">
                  <td>
                     <label>{{ trans('bookings.fields.date')}}</label>
                  </td>
                  <td style="text-align:right;">
                   {!! issetKey( $meta, 'client_signature_date', '' ) !!}
                  </td>
               </tr>
              </tbody>
            </table>

            <label for="named-client">Staff Manager Signature</label>      
            @if(isset($meta['staff_manager_signature']))
               <img alt="staff_manager_signature" src="{{ $meta['staff_manager_signature'] }}" />
            @else
            <span style="font-size:22px; display:block;">Signature have not signed</span>
            @endif
            <label>{{ trans('opforms.fields.date')}}</label>
            <span>{!! issetKey( $meta, 'date2', '' ) !!}</span>
         </div>
      </div>      
   </div>
</div>