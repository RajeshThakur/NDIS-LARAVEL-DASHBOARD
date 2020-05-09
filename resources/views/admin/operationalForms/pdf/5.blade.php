
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
      <div class="operational-form-design custom-table-pdf" style="font-family: 'Open Sans', sans-serif; border:1px solid #777d; padding:15px;">
         <div>
            <h4 style="font-size: 2rem;
            font-weight: 500;
            margin-bottom: 0; text-align:center; margin-bottom:20px;">Client Progress Form</h4>
         </div>
          
            <table class="table">
              <tbody>
                 <tr>
                    <td style="background:none; padding-bottom:15px;">
                     <label>  {{trans('opforms.fields.client_surname')}}</label>
                    </td>
                    <td style="text-align:right; padding-bottom:15px;">
                     {!!$participant->last_name!!}
                    </td>
                 </tr>
                 <tr>
                  <td style="background:none; padding-bottom:15px;">
                     <label>  {{ trans('opforms.fields.given_name')}}</label>
                  </td>
                  <td style="background:none; text-align:right; padding-bottom:15px;">
                   {!!$participant->first_name!!}
                  </td>
               </tr>
                 <tr>
                  <td style="background:none; padding-bottom:15px;">
                     <label>  {{ trans('opforms.fields.date_of_birth')}}</label>
                  </td>
                  <td style="text-align:right; padding-bottom:15px;">
                   {!!old('date_of_birth', isset($meta['date_of_birth']) ? $meta['date_of_birth'] : date('d-m-Y'))!!}
                  </td>
               </tr>
                 <tr>
                  <td style="background:none; text-align:right; padding-bottom:15px;">
                     <h3 style="font-size: 24px;
                     font-weight: 500;
                     margin-bottom: 0; font-family: 'Open Sans', sans-serif;">CLIENT PROGRESS NOTES</h3>
                  </td>
                  <td
                  &nbsp;>
                  </td>
               </tr>
               <tr>
               <td style="padding-bottom:15px;">
                     <label>  {{trans('opforms.fields.date_time')}}</label>
                  </td>
                  <td style="text-align:right; padding-bottom:15px;">
                   {!! old('progress_date_time', isset($meta['progress_date_time']) ? $meta['progress_date_time'] : date('d-m-Y H:i:s'))!!}
                  </td>
               </tr>
               <tr>
                  <td>
                  <div class="textarea"> 
                     <h4 style="margin-bottom:12px; color: #444444; font-family: 'Open Sans', sans-serif;">
                        <label>{{trans('opforms.fields.notes_text')}} :-</label>
                     </h4>
                     <span style="height:auto; width:100%; font-family: 'Open Sans', sans-serif;"> {!!$meta['notes_text']!!}</span>
                  </div>
                  </td>
                  </tr>
              </tbody>
            </table>
            
         </div>
      </div>
   </div>
</div>
