<div class="card">
   <div class="card-body">
   <style>
      table th, table.border-class tr td{
         border:1px solid #333;
         padding:12px;
         text-align:center;
      }
      table{
         border-collapse: collapse;
      }
      table.discription th, table.discription tr td, {
         padding:15px;
         text-align:center;
         border:1px solid #333;
      }
   </style>
      <div class="operational-form-design risk-assessment-re-build"  style="font-family: 'Open Sans', sans-serif; border:1px solid #777d; padding:15px;">

            <div class="card-header">
               <h2 style="text-align:center; margin-bottom:20px;">Risk Assessment</h2>
            </div>

            <br>
            <div class="backgroud-info">
               <div class="heading" style="font: italic bold 12px/30px Georgia, serif;">
                  <label>  Background Information</label>
               </div>
               <div class="info">
                  <span>{!! issetKey( $meta, 'background_info', '' ) !!}</span>
               </div>
            </div>

            <br>

            <div class="risk-data">
               <div class="heading">
                  <label>Risk Assessment Date:  </label>
               </div>
               <div class="info">
                  <span>{!! issetKey( $meta, 'risk_assessment_date', '' ) !!}</span>
               </div>
            </div>

            <br>
            <div class="person-name">
               <div class="heading">
                  <label>Name of person conducting assessment:  </label>
               </div>
               <div class="info">
                  <span>{!! issetKey( $meta, 'person_name_conducting_assessment', '' ) !!}</span>
               </div>
            </div>

            <br>
            <table class="table-responsive border-class" style="text-align:center; border-1px solid #eee;">
               <thead>
                  <tr>
                     <th scope="col">&nbsp;</th>
                     <th scope="col">Identify and list hazards</th>
                     <th scope="col">List Current Risk Controls</th>
                     <th scope="col">Risk Rating</th>
                     <th scope="col">List Additional Controls (if any – where current controls are not adequately managing the level of risk)</th>
                  </tr>
               </thead>
               <tbody>
                  @if(isset($meta['identify'][1]) || isset($meta['risk'][1]) || isset($meta['risk_rating'][1]) || isset( $meta['addl_control'][1] ) )
                     <tr>
                        <th>1</th>
                        <td>
                           {!! old('identify[1]', isset($meta['identify'][1]) ? $meta['identify'][1] : '') !!}
                        </td>
                        <td>
                           {!! old('risk[1]', isset($meta['risk'][1]) ? $meta['risk'][1] : '') !!}
                        </td>
                        <td>
                           {!! old('risk_rating[1]', isset($meta['risk_rating'][1]) ? $meta['risk_rating'][1] : '') !!}
                        </td>
                        <td>
                           {!! old('addl_control[1]', isset($meta['addl_control'][1]) ? $meta['addl_control'][1] : '') !!}
                        </td>
                     </tr>
                  @endif
                  @if(isset($meta['identify'][2]) || isset($meta['risk'][2]) || isset($meta['risk_rating'][2]) || isset( $meta['addl_control'][2] ) )
                     <tr>
                        <th scope="row">2</th>
                        <td>
                           {!! old('identify[2]', isset($meta['identify'][2]) ? $meta['identify'][2] : '') !!}
                        </td>
                        <td>
                           {!! old('risk[2]', isset($meta['risk'][2]) ? $meta['risk'][2] : '') !!}
                        </td>
                        <td>
                           {!! old('risk_rating[2]', isset($meta['risk_rating'][2]) ? $meta['risk_rating'][2] : '') !!}
                        </td>
                        <td>
                           {!! old('addl_control[2]', isset($meta['addl_control'][2]) ? $meta['addl_control'][2] : '') !!}
                        </td>
                     </tr>
                  @endif
                  @if(isset($meta['identify'][3]) || isset($meta['risk'][3]) || isset($meta['risk_rating'][3]) || isset( $meta['addl_control'][3] ) )
                     <tr>
                        <th scope="row">3</th>
                        <td>
                           {!! old('identify[3]', isset($meta['identify'][3]) ? $meta['identify'][3] : '') !!}
                        </td>
                        <td>
                           {!! old('risk[3]', isset($meta['risk'][3]) ? $meta['risk'][3] : '') !!}
                        </td>
                        <td>
                           {!! old('risk_rating[3]', isset($meta['risk_rating'][3]) ? $meta['risk_rating'][3] : '') !!}
                        </td>
                        <td>
                           {!! old('addl_control[3]', isset($meta['addl_control'][3]) ? $meta['addl_control'][3] : '') !!}
                        </td>
                     </tr>
                  @endif
                  @if(isset($meta['identify'][4]) || isset($meta['risk'][4]) || isset($meta['risk_rating'][4]) || isset( $meta['addl_control'][4] ) )
                     <tr>
                        <th scope="row">4</th>
                        <td>
                           {!! old('identify[4]', isset($meta['identify'][4]) ? $meta['identify'][4] : '') !!}
                        </td>
                        <td>
                           {!! old('risk[4]', isset($meta['risk'][4]) ? $meta['risk'][4] : '') !!}
                        </td>
                        <td>
                           {!! old('risk_rating[4]', isset($meta['risk_rating'][4]) ? $meta['risk_rating'][4] : '') !!}
                        </td>
                        <td>
                           {!! old('addl_control[4]', isset($meta['addl_control'][4]) ? $meta['addl_control'][4] : '') !!}
                        </td>
                     </tr>
                  @endif
                  @if(isset($meta['identify'][5]) || isset($meta['risk'][5]) || isset($meta['risk_rating'][5]) || isset( $meta['addl_control'][5] ) )
                     <tr>
                        <th scope="row">5</th>
                        <td>
                           {!! old('identify[5]', isset($meta['identify'][5]) ? $meta['identify'][5] : '') !!}
                        </td>
                        <td>
                           {!! old('risk[5]', isset($meta['risk'][5]) ? $meta['risk'][5] : '') !!}
                        </td>
                        <td>
                           {!! old('risk_rating[5]', isset($meta['risk_rating'][5]) ? $meta['risk_rating'][5] : '') !!}
                        </td>
                        <td>
                           {!! old('addl_control[5]', isset($meta['addl_control'][5]) ? $meta['addl_control'][5] : '') !!}
                        </td>
                     </tr>
                  @endif
                  @if(isset($meta['identify'][6]) || isset($meta['risk'][6]) || isset($meta['risk_rating'][6]) || isset( $meta['addl_control'][6] ) )
                     <tr>
                        <th scope="row">6</th>
                        <td>
                           {!! old('identify[6]', isset($meta['identify'][6]) ? $meta['identify'][6] : '') !!}
                        </td>
                        <td>
                           {!! old('risk[6]', isset($meta['risk'][6]) ? $meta['risk'][6] : '') !!}
                        </td>
                        <td>
                           {!! old('risk_rating[6]', isset($meta['risk_rating'][6]) ? $meta['risk_rating'][6] : '') !!}
                        </td>
                        <td>
                           {!! old('addl_control[6]', isset($meta['addl_control'][6]) ? $meta['addl_control'][6] : '') !!}
                        </td>
                     </tr>
                  @endif
                  @if(isset($meta['identify'][7]) || isset($meta['risk'][7]) || isset($meta['risk_rating'][7]) || isset( $meta['addl_control'][7] ) )
                     <tr>
                        <th scope="row">7</th>
                        <td>
                           {!! old('identify[7]', isset($meta['identify'][7]) ? $meta['identify'][7] : '') !!}
                        </td>
                        <td>
                           {!! old('risk[7]', isset($meta['risk'][7]) ? $meta['risk'][7] : '') !!}
                        </td>
                        <td>
                           {!! old('risk_rating[7]', isset($meta['risk_rating'][7]) ? $meta['risk_rating'][7] : '') !!}
                        </td>
                        <td>
                           {!! old('addl_control[7]', isset($meta['addl_control'][7]) ? $meta['addl_control'][7] : '') !!}
                        </td>
                     </tr>
                  @endif
                  @if(isset($meta['identify'][8]) || isset($meta['risk'][8]) || isset($meta['risk_rating'][8]) || isset( $meta['addl_control'][8] ) )
                     <tr>
                        <th scope="row">8</th>
                        <td>
                           {!! old('identify[8]', isset($meta['identify'][8]) ? $meta['identify'][8] : '') !!}
                        </td>
                        <td>
                           {!! old('risk[8]', isset($meta['risk'][8]) ? $meta['risk'][8] : '') !!}
                        </td>
                        <td>
                           {!! old('risk_rating[8]', isset($meta['risk_rating'][8]) ? $meta['risk_rating'][8] : '') !!}
                        </td>
                        <td>
                           {!! old('addl_control[8]', isset($meta['addl_control'][8]) ? $meta['addl_control'][8] : '') !!}
                        </td>
                     </tr>
                  @endif
                  @if(isset($meta['identify'][9]) || isset($meta['risk'][9]) || isset($meta['risk_rating'][9]) || isset( $meta['addl_control'][9] ) )
                     <tr>
                        <th scope="row">9</th>
                        <td>
                           {!! old('identify[9]', isset($meta['identify'][9]) ? $meta['identify'][9] : '') !!}
                        </td>
                        <td>
                           {!! old('risk[9]', isset($meta['risk'][9]) ? $meta['risk'][9] : '') !!}
                        </td>
                        <td>
                           {!! old('risk_rating[9]', isset($meta['risk_rating'][9]) ? $meta['risk_rating'][9] : '') !!}
                        </td>
                        <td>
                           {!! old('addl_control[9]', isset($meta['addl_control'][9]) ? $meta['addl_control'][9] : '') !!}
                        </td>
                     </tr>
                  @endif
                  @if(isset($meta['identify'][10]) || isset($meta['risk'][10]) || isset($meta['risk_rating'][10]) || isset( $meta['addl_control'][10] ) )
                     <tr>
                        <th scope="row">10</th>
                        <td>
                           {!! old('identify[10]', isset($meta['identify'][10]) ? $meta['identify'][10] : '') !!}
                        </td>
                        <td>
                           {!! old('risk[10]', isset($meta['risk'][10]) ? $meta['risk'][10] : '') !!}
                        </td>
                        <td>
                           {!! old('risk_rating[10]', isset($meta['risk_rating'][10]) ? $meta['risk_rating'][10] : '') !!}
                        </td>
                        <td>
                           {!! old('addl_control[10]', isset($meta['addl_control'][10]) ? $meta['addl_control'][10] : '') !!}
                        </td>
                     </tr>
                  @endif
                  @if(isset($meta['identify'][11]) || isset($meta['risk'][11]) || isset($meta['risk_rating'][11]) || isset( $meta['addl_control'][11] ) )
                     <tr>
                        <th scope="row">11</th>
                        <td>
                           {!! old('identify[11]', isset($meta['identify'][11]) ? $meta['identify'][11] : '') !!}
                        </td>
                        <td>
                           {!! old('risk[11]', isset($meta['risk'][11]) ? $meta['risk'][11] : '') !!}
                        </td>
                        <td>
                           {!! old('risk_rating[11]', isset($meta['risk_rating'][11]) ? $meta['risk_rating'][11] : '') !!}
                        </td>
                        <td>
                           {!! old('addl_control[11]', isset($meta['addl_control'][11]) ? $meta['addl_control'][11] : '') !!}
                        </td>
                     </tr>
                  @endif
                  @if(isset($meta['identify'][12]) || isset($meta['risk'][12]) || isset($meta['risk_rating'][12]) || isset( $meta['addl_control'][12] ) )
                     <tr>
                        <th scope="row">12</th>
                        <td>
                           {!! old('identify[12]', isset($meta['identify'][12]) ? $meta['identify'][12] : '') !!}
                        </td>
                        <td>
                           {!! old('risk[12]', isset($meta['risk'][12]) ? $meta['risk'][12] : '') !!}
                        </td>
                        <td>
                           {!! old('risk_rating[12]', isset($meta['risk_rating'][12]) ? $meta['risk_rating'][12] : '') !!}
                        </td>
                        <td>
                           {!! old('addl_control[12]', isset($meta['addl_control'][12]) ? $meta['addl_control'][12] : '') !!}
                        </td>
                     </tr>
                  @endif
               </tbody>
            </table>

            <br>
            <br>

            <div class="risk-page-two below-form mt-40">
               <div class="form-group ">
                  <label for="Language"><strong>Consequence </strong>– Evaluate the consequences of a risk occurring according to the ratings in the top row.</label>
               </div>
               <div class="risk-assessment-re-build custom-border">
                  <div class="table-responsive">
                     <div classs="form-group">
                        <label for="Language">Risk Assessment</label>
                     </div>
                     <table class="table discription">
                        <thead>
                           <tr>
                              <th>Descriptor</th>
                              <th>Level</th>
                              <th>Definition</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td>Insignificant</td>
                              <td>1</td>
                              <td>No injury</td>
                           </tr>
                           <tr>
                              <td>Minor</td>
                              <td>2</td>
                              <td>Injury/ ill health requiring first aid </td>
                           </tr>
                           <tr>
                              <td>Moderate</td>
                              <td>3</td>
                              <td>Injury/ ill health requiring medical attention</td>
                           </tr>
                           <tr>
                              <td>Major</td>
                              <td>4</td>
                              <td>Injury/ ill health requiring hospital admission</td>
                           </tr>
                           <tr>
                              <td>Severe</td>
                              <td>5</td>
                              <td>Fatality</td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>

            <br>

            <div class="risk-page-two below-form">
               <div class="risk-assessment-re-build custom-border">
                  <div class="table-responsive">
                     <div classs="form-group">
                        <label for="Language"><strong>Risk Matrix  </strong> – Using the matrix calculate the level of <strong>risk</strong> by finding the intersection between the likelihood and the consequences</label>
                     </div>
                     <table class="table-responsive discription">
                        <thead>
                           <tr>
                              <th scope="col">Likelihood</th>
                              <th scope="col" colspan="5" style="text-align:center;"> Consequences</th>
                           </tr>
                           <tr>
                              <th scope="col">&nbsp;</th>
                              <th scope="col" style="background:none;">Insignificant</th>
                              <th scope="col" style="background:none;">Minor</th>
                              <th scope="col" style="background:none;">Moderate</th>
                              <th scope="col" style="background:none;">Major</th>
                              <th scope="col" style="background:none;">Severe</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <th style="background:none;">Almost Certain</th>
                              <td style="background: #f4f73f;">Medium</td>
                              <td style="background: #f7833f">height</td>
                              <td style="background: red;">Extreme</td>
                              <td style="background: red;">Extreme</td>
                              <td style="background: red;">Extreme</td>
                           </tr>
                           <tr>
                              <th style="background:none;">Likely</th>
                              <td style="background: #f4f73f;">Medium</td>
                              <td style="background: #f4f73f;">Medium</td>
                              <td style="background: #f7833f">height</td>
                              <td style="background: red;">Extreme</td>
                              <td style="background: red;">Extreme</td>
                           </tr>
                           <tr>
                              <th style="background:none;">Possible</th>
                              <td style="background: blue;">low</td>
                              <td style="background: #f4f73f;">Medium</td>
                              <td style="background: #f4f73f;">Medium</td>
                              <td style="background: white;">height</td>
                              <td style="background: red;">Extreme</td>
                           </tr>
                           <tr>
                              <th style="background:none;">Rare</th>
                              <td style="background: blue;">low</td>
                              <td style="background: blue;">low</td>
                              <td style="background: #f4f73f;">Medium</td>
                              <td style="background: #f4f73f;">Medium</td>
                              <td style="background: white;">height</td>
                           </tr>
                           <tr>
                              <th style="background:none;">Unlikely</th>
                              <td style="background: blue;">low</td>
                              <td style="background: blue;">low</td>
                              <td style="background: blue;">low</td>
                              <td style="background: #f4f73f;">Medium</td>
                              <td style="background: #f4f73f;">Medium</td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>

            <br>

            <div class="risk-page-two below-form">
               <div class="risk-assessment-re-build onlyfor-theading custom-border">
                  <div class="table-responsive">
                     <div classs="form-group">
                        <label for="Language"> <strong>Likelihood</strong>- Evaluate the  <strong>Likelihood </strong> of an incident occurring according to the rating in the left hand column</label>
                     </div>
                     <table class="table discription">
                        <thead>
                           <tr>
                              <th scope="col" style="background:#086175;">Descriptor</th>
                              <th scope="col" style="background:#086175;">Level</th>
                              <th scope="col" style="background:#086175;">Definition</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td >Rare</td>
                              <td >1</td>
                              <td >May occur somewhere, sometime (“once in a life time/once in a hundred years”)</td>
                           </tr>
                           <tr>
                              <td >Unlikely</td>
                              <td >2</td>
                              <td >May occur somewhere within the Department over an extended period of time</td>
                           </tr>
                           <tr>
                              <td >Possible</td>
                              <td >3</td>
                              <td >May occur several times across the Department or a region over a period of time</td>
                           </tr>
                           <tr>
                              <td>Likely</td>
                              <td >4</td>
                              <td >May be anticipated multiple times over a period of time May occur once every few repetitions of the activity or event</td>
                           </tr>
                           <tr>
                              <td >Almost Certain</td>
                              <td >5</td>
                              <td >Prone to occur regularly It is anticipated for each repetition of the activity of event</td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
               <div class="risk-page-two below-form last-below">
                  <div class="form-group ">
                     <label for="Language"><strong>Risk Level/ Rating and Actionsbetween the likelihood and the consequences</strong></label>
                  </div>
                  <div class="risk-page-two below-form">
                     <div class="risk-assessment-re-build custom-border">
                        <div class="table-responsive">
                           <div classs="form-group">
                              <label for="Language"><strong>Risk Matrix  </strong> – Using the matrix calculate the level of <strong>risk</strong> by finding the intersection between the likelihood and the consequences</label>
                           </div>
                           <table class="table discription">
                              <thead>
                                 <tr>
                                    <th scope="col">Descriptor</th>
                                    <th scope="col" colspan="5" style="text-align:center;">Definition</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr>
                                    <td style="background: red;">Extreme</td>
                                    <td style="">Notify <strong>Workplace and/or Management OHS Nominee </strong> immediately. Corrective actions should be taken immediately. Cease associated activity.</td>
                                 </tr>
                                 <tr>
                                    <td style="background: #f7833f">height</td>
                                    <td style="">Notify <strong>Workplace and/or Management OHS Nominee </strong> immediately. Corrective actions should be taken immediately within 48 hours of notification.</td>
                                 </tr>
                                 <tr>
                                    <td style="background: #f4f73f;">Medium</td>
                                    <td style="">Notify <strong>Nominated employee, HSR / OHS Committee.</strong>
                                       Nominated employee, OHS Representative / OHS Committee is to follow up that corrective action is taken within 7 days. 
                                    </td>
                                 </tr>
                                 <tr>
                                    <td style="background: blue;">low</td>
                                    <td style="">Notify <strong>Nominated employee, HSR / OHS Committee.</strong>
                                       Nominated employee, OHS Representative / OHS Committee is to follow up that corrective action is taken within a reasonable time.
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

         </div>
      </div>
   </div>
</div>