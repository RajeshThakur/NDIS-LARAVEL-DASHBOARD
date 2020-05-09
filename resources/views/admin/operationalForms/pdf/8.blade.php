
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
      <div class="operational-form-design incident-pdf" style="font-family: 'Open Sans', sans-serif; border:1px solid #777d; padding:15px;">
         <div>
            <h4 style="font-size: 2rem;
            font-weight: 500;
            margin-bottom: 0; text-align:center;">Incident Report Form</h4>
         </div>
         <div class="authority-section">
            <div class="form-group">
               <h3 style="text-align:center;">Incident Report Form</h3>
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

      <div class=" custom-table-pdf">
         <table class="table">
            <tbody>
               <tr>
                  <td style="background:none;padding-right:270px;">
                   <label>{{trans('opforms.fields.job')}}</label>
                  </td>
                  <td style="text-align:right; padding-left:270px;">
                   {!! issetKey( $meta, 'job', '' ) !!}
                  </td>
               </tr>
               <tr>
                <td style="background:none;">
                   <label> {{trans('opforms.fields.date')}}</label>
                </td>
                <td style="background:none; text-align:right;">
                 {!! old('date_of_incident', isset($meta['date_of_incident']) ? $meta['date_of_incident'] : date('d-m-Y')) !!}
                </td>
             </tr>
               <tr>
                <td style="background:none;">
                   <label>  {{trans('opforms.fields.incident_time')}}</label>
                </td>
                <td style="text-align:right;">
                   {{ old('incident_time', isset($meta['incident_time']) ? $meta['incident_time'] : '') }}
                </td>
             </tr>               
            </tbody>
          </table>
      </div>

         <div class="textarea"> 
            <h4 style="margin-bottom:12px; color: #444444; font-family: 'Open Sans', sans-serif;">
               <label>{{ trans('opforms.fields.incident_details')}} :-</label>
            </h4>
            <span style="height:auto; width:100%; font-family: 'Open Sans', sans-serif;"> {!! issetKey( $meta, 'incident_details', '' ) !!}</span>
         </div>

         <div class="textarea"> 
            <h4 style="margin-bottom:12px; color: #444444; font-family: 'Open Sans', sans-serif;">
               <label>{{  trans('opforms.fields.any_injuries')}} :-</label>
            </h4>
            <span style="height:auto; width:100%; font-family: 'Open Sans', sans-serif;"> {!! issetKey( $meta, 'any_injuries', '' ) !!}</span>
         </div>

         <div class="textarea"> 
            <h4 style="margin-bottom:12px; color: #444444; font-family: 'Open Sans', sans-serif;">
               <label>{{  trans('opforms.fields.any_damage')}} :-</label>
            </h4>
            <span style="height:auto; width:100%; font-family: 'Open Sans', sans-serif;"> {!! issetKey( $meta, 'any_damage', '' ) !!}</span>
         </div>


         <div class="form-group" style="margin:0;" >
            <h4 style="margin-bottom:0;">Incident report form</h4>
         </div>

         <div class="textarea"> 
            <h4 style="margin-bottom:12px; color: #444444; font-family: 'Open Sans', sans-serif;">
               <label>{{ trans('opforms.fields.cause_of_incident')}} :-</label>
            </h4>
            <span style="height:auto; width:100%; font-family: 'Open Sans', sans-serif;"> {!! issetKey( $meta, 'cause_of_incident', '' ) !!}</span>
         </div>

         <div class="textarea"> 
            <h4 style="margin-bottom:12px; color: #444444; font-family: 'Open Sans', sans-serif;">
               <label>{{trans('opforms.fields.actions_to_eliminate')}} :-</label>
            </h4>
            <span style="height:auto; width:100%; font-family: 'Open Sans', sans-serif;"> {!! issetKey( $meta, 'actions_to_eliminate', '' ) !!}</span>
         </div>

         <div class="textarea"> 
            <h4 style="margin-bottom:12px; color: #444444; font-family: 'Open Sans', sans-serif;">
               <label>{{trans('opforms.fields.management_comments')}} :-</label>
            </h4>
            <span style="height:auto; width:100%; font-family: 'Open Sans', sans-serif;"> {!! issetKey( $meta, 'management_comments', '' ) !!}</span>
         </div>      
         
         <div class="row">
            <div class="col-sm-4">
               <div class="form-group">
                  <label for="incident" style="margin:48px 0px;">Signed off by management when corrective actions have been adopted and monitored.</label>
               </div>
            </div>
            <div class="col-sm-8">
               @if(isset($meta['management_sign']))
               <img alt="management_sign" style="width:270px;" src="{{ $meta['management_sign'] }}" />
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
                     old('date_of_sign', isset($meta['date_of_sign']) ? $meta['date_of_sign'] : date('d-m-Y'))
                  !!}
               </div>
            </div>
         </div>
           
            

         </div>
      </div>
   </div>
</div>
