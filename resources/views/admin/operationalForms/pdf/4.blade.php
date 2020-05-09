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
         <div class="card-header">
            <h2 style=" text-align:center; margin-bottom:20px;">Client Exit/Transition Form</h2>
         </div>
         <table class="table">
            <tbody>
             <tr>
                <td style="background:none; padding-bottom:12px;">
                <label>{{trans('opforms.fields.client_full_name')}}</label>
                </td>
                <td style="text-align:right; padding-bottom:12px;">
                  {!! old('full_name', $participant->getName() ) !!}
                </td>
             </tr>
             <tr>
                <td style="background:none; padding-bottom:12px;">
                   <label>{{trans('opforms.fields.commencement_service')}}</label>
                </td>
                <td style="background:none; text-align:right; padding-bottom:12px;">
                  {!! old('commencement_service', isset($meta['commencement_service']) ? $meta['commencement_service'] : '') !!}
                </td>
             </tr>
             <tr style="padding-bottom:15px; ">
                <td style="background:none; padding-bottom:12px;">
                   <label>{{trans('opforms.fields.commencement_exit')}}</label>
                </td>
                <td style="text-align:right; padding-bottom:12px;">
                 {!! old('commencement_exit', isset($meta['commencement_exit']) ? $meta['commencement_exit'] : '') !!}
                </td>
             </tr>
             <tr>
                <td style="padding-bottom:12px;">
                   <label>{{trans('opforms.fields.reason_end_service')}}</label>
                </td>
                <td style="text-align:right; padding-bottom:12px;">
                 {!! issetKey( $meta, 'reason_end_service', '' ) !!}
                </td>
             </tr>
             <tr style="padding-bottom:15px; ">
                <td style="padding-bottom:12px;">
                   <label>{{trans('opforms.fields.transition_goals')}}</label>
                </td>
                <td style="text-align:right; padding-bottom:12px;">
                 {!! issetKey( $meta, 'transition_goals', '' ) !!}
                </td>
             </tr>
             <tr>
               <td style="padding-bottom:12px;">
                  <label>{{trans('opforms.fields.client_need')}}</label>
               </td>
               <td style="text-align:right; padding-bottom:12px;">
                {!! issetKey( $meta, 'client_need', '' ) !!}
               </td>
            </tr>
            <tr>
               <td style="padding-bottom:12px;">
                  <label>{{ trans('opforms.fields.item')}}</label>
               </td>
               <td style="text-align:right; padding-bottom:12px;">
                {!! issetKey( $meta, 'item', '' ) !!}
               </td>
            </tr>
            <tr>
               <td style="padding-bottom:12px;">
                  <label>{{ trans('opforms.fields.doctor')}}</label>
               </td>
               <td style="text-align:right; padding-bottom:12px;">
                {!! issetKey( $meta, 'doctor', '' ) !!}
               </td>
            </tr>
            <tr>
               <td style="padding-bottom:12px;">
                  <label>{{ trans('opforms.fields.health_providers')}}</label>
               </td>
               <td style="text-align:right; padding-bottom:12px;">
                {!! issetKey( $meta, 'health_providers', '' ) !!}
               </td>
            </tr>
            <tr>
               <td style="padding-bottom:12px;">
                  <label>{{  trans('opforms.fields.other_clubs')}}</label>
               </td>
               <td style="text-align:right; padding-bottom:12px;">
                {!! issetKey( $meta, 'other_clubs', '' ) !!}
               </td>
            </tr>
            <tr>
               <td style="padding-bottom:12px;">
                  <label>{{ trans('opforms.fields.relevant_staff')}}</label>
               </td>
               <td style="text-align:right; padding-bottom:12px;">
                {!! issetKey( $meta, 'relevant_staff', '' ) !!}
               </td>
            </tr>
            <tr>
               <td style="padding-bottom:12px;">
                  <label>{{ trans('opforms.fields.administration')}}</label>
               </td>
               <td style="text-align:right; padding-bottom:12px;">
                {!! issetKey( $meta, 'administration', '' ) !!}
               </td>
            </tr>
            <tr>
               <td style="padding-bottom:12px;">
                  <label>{{  trans('opforms.fields.loan_retrieved')}}</label>
               </td>
               <td style="text-align:right; padding-bottom:12px;">
                {!! issetKey( $meta, 'loan_retrieved', '' ) !!}
               </td>
            </tr>
            <tr>
               <td style="padding-bottom:12px;">
                  <label>{{  trans('opforms.fields.filing_chart')}}</label>
               </td>
               <td style="text-align:right; padding-bottom:12px;">
                {!! issetKey( $meta, 'filing_chart', '' ) !!}
               </td>
            </tr>
            <tr>
               <td style="padding-bottom:12px;">
                  <label>{{ trans('opforms.fields.client_office_archived')}}</label>
               </td>
               <td style="text-align:right; padding-bottom:12px;">
                {!! issetKey( $meta, 'client_office_archived', '' ) !!}
               </td>
            </tr>
            <tr>
               <td style="padding-bottom:12px;">
                  <label>{{trans('opforms.fields.representative_signature')}}</label>
               </td>
               <td style="text-align:right; padding-bottom:12px;">
                {!! issetKey( $meta, 'client_representative', '' ) !!}
               </td>
            </tr>
            <tr>
               <td style="padding-bottom:12px;">
                  <label>{{trans('opforms.fields.date')}}</label>
               </td>
               <td style="text-align:right; padding-bottom:12px;">
                {!! old('date', isset($meta['date']) ? $meta['date'] : '') !!}
               </td>
            </tr>
            </tbody>
          </table>


          <div class="form-group">
            <label> Client Signature</label>
         </div>
         <div class="signature">
            @if(isset($meta['member_signature']))
               <img alt="member_signature" style="width:270px;" src="{{ $meta['member_signature'] }}" />
            @else
            <span style="font-size:22px; display:block;">Signature have not signed</span>
            @endif
         </div>
         <div class="form-group">
            <label>  {{trans('opforms.fields.date')}}</label>
            <span>{!! old('date3', isset($meta['date3']) ? $meta['date3'] : '') !!}</span>
         </div>
      </div>
      </div>
   </div>
</div>