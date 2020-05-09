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
            <h2 style="font-size: 2rem;
            font-weight: 500;
            margin-bottom: 20px; text-align:center;">AUTHORITY TO ACT AS AN ADVOCATE</h2>
            <table class="table">
              <tbody>
               <tr>
                  <td style="background:none;">
                  <label>{{trans('opforms.fields.first_name')}}</label>
                  </td>
                  <td style="text-align:right;">
                  {!!$participant->first_name!!}
                  </td>
               </tr>
               <tr>
                  <td style="background:none;">
                     <label>{{trans('opforms.fields.last_name')}}</label>
                  </td>
                  <td style="background:none; text-align:right;">
                   {!!$participant->last_name!!}
                  </td>
               </tr>
               <tr>
                  <td style="background:none;">
                     <label>{{trans('opforms.fields.address') }}</label>
                  </td>
                  <td style="text-align:right;">
                   {!!$meta['participant_address']!!}
                  </td>
               </tr>
               <tr>
                  <td>
                     <label> {{trans('opforms.fields.phone')}}</label>
                  </td>
                  <td style="text-align:right;">
                   {!! $meta['participant_phone']!!}
                  </td>
               </tr>
               <tr>
                  <td>
                     <label> {{trans('opforms.fields.involvement')}}</label>
                  </td>
                  <td style="text-align:right;">
                   {!! $meta['involvement_auth']!!}
                  </td>
               </tr>
              </tbody>
            </table>
                  <div>
                     <div class="form-group "  style="padding-bottom:15px;">
                        <label for="services">I understand that the service may discuss details of my plan of care and services with my advocate if the need arises.</label>
                     </div>
                     <div class="form-group " style="padding-bottom:15px;">
                        <label for="date">This authority is to take effect from Date:</label>
                     </div>
                     <div class="form-group " style="padding-bottom:15px;">
                        <label for="change-writting">This replaces any previously advised arrangements. I understand that I can change my choice of advocate at any time and undertake to advise the service of any such change in writing.</label>
                     </div>
                  </div>
                  @if(isset($meta['client_signature']))
                     <img alt="client_signature" src="{{ $meta['client_signature'] }}" />
                  @else
                  <span style="font-size:22px;">Signature have not signed</span>
                  @endif
            <table style="width:100%;">
               <tbody>
               <tr>
                  <td>
                     <label>{{trans('bookings.fields.date')}}</label>
                  </td>
                  <td style="text-align:right;">
                   {!!$meta['client_signature_date']!!}
                  </td>
               </tr>
               <tr>
                  <td>
                     <label>{{trans('opforms.fields.advocate_name')}}</label>
                  </td>
                  <td style="text-align:right;">
                   {!!$meta['advocate_name']!!}
                  </td>
               </tr>

               <tr>
                  <td>
                  <label>{{ trans('opforms.fields.advocate_address')}}</label>
                  </td>
                  <td style="text-align:right;">
                  {!!$meta['advocate_address']!!}
                  </td>
               </tr>
               
               <tr>
                  <td>
                     <label>{{trans('opforms.fields.advocate_phone')}}</label>
                  </td>
                  <td style="text-align:right;">
                   {!!$meta['advocate_phone']!!}
                  </td>
               </tr>
               <tr>
                  <td>
                     <label>{{trans('opforms.fields.advocate_email')}}</label>
                  </td>
                  <td style="text-align:right;">
                   {!!$meta['advocate_email']!!}
                  </td>
               </tr>
               <tr>
                  <td>
                     <label>{{trans('opforms.fields.advocate_email')}}</label>
                  </td>
                  <td style="text-align:right;">
                   {!!$meta['advocate_email']!!}
                  </td>
               </tr>
               </tbody>
            </table>
               
               <label for="named-client">I have read the 'Guidelines for Advocates' and agree to act as an advocate for the above named client.</label>      
               @if(isset($meta['advocate_signature']))
                  <img alt="advocate_signature" style="width:400px;" src="{{ $meta['advocate_signature'] }}" />
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
                   {!!$meta['advocate_date']!!}
                  </td>
               </tr>
              </tbody>
            </table>
            <div class="textarea"> 
               <label>{{trans('opforms.fields.advocate_authority')}} :-</label>
               <span style="height:auto; width:100%; font-family: 'Open Sans', sans-serif;">{!! issetKey( $meta, 'advocate_authority', '' ) !!}
               </span>
            </div>
            <div class="being" style="padding-bottom:15px;">
               <label> {{trans('opforms.fields.being_an_advocate')}}: </label>
               <span>{!! issetKey( $meta, 'being_an_advocate', '' ) !!}</span>
            </div>
            <div class="form-group " style="padding-bottom:15px;">
               <label><strong>{{$participant->getName()}}</strong> has asked you to be their advocate, which means they would like you to act on their behalf in their dealings with the service. 
               You may be a family member or friend of the client or a member of an advocacy service.</label>
            </div>
            <div class="form-group " style="padding-bottom:15px;">
               <label>Being an advocate may mean your attendance or involvement will be required during assessments and reviews of the client's situation 
               and services received, or if the client wishes to communicate or negotiate anything with the service or lodge a complaint about the service.</label>
            </div>
            <div class="form-group " style="padding-bottom:15px;">
               <label>We ask our clients to complete an 'Authority to Act as an Advocate Form' when they wish to appoint or change their advocate. Clients are free to change their advocates 
               whenever they wish, however we request a new authority form be completed each time so that service staff are always clear about who the client's advocate is. </label>
            </div>
            <div class="form-group " style="padding-bottom:15px;">
               <label>As an advocate of a client we ask you to be aware of the following and ensure that:</label>
               <ul>
                  <li>
                     <label> The client has given their written authority for you to act as their advocate</label>
                  </li>
                  <li>
                     <label>The service is aware that you are acting as the client's advocate</label>
                  </li>
                  <li>
                     <label>You always act in the best interests of the client</label>
                  </li>
                  <li>
                     <label> The client is aware of any issues and developments in relation to the services they receive and which you, as their advocate,  may be involved in</label>
                  </li>
                  <li>
                     <label> The client is kept informed of any developments</label>
                  </li>
                  <li>
                     <label>You are familiar with the contents of the Client's Handbook and the details of the client's care plan</label>
                  </li>
                  <li>
                     <label>You encourage the client to provide feedback to you about the services they are receiving</label>
                  </li>
                  <li>
                     <label>You advise the service about any changes in client circumstances and any concerns about changing client needs</label>
                  </li>
                  <li>
                     <label> You are prepared to relinquish the role of advocate should the client wish this.</label>
                  </li>
               </ul>
               <p class="helper-block">
                  {{ trans('global.user.fields.name_helper') }}
               </p>
            </div>
         </div>
      </div>
   </div>
</div>