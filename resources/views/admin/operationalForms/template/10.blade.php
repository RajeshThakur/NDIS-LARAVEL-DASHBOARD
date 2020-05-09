@extends('layouts.admin')
@section('content')
<div class="card">
<div class="card-body">
   <div class="operational-form-design risk-assessment-re-build">
      {{-- 10th risk-assessment Form start here--}} 
      <form action="{{ route($formAction[0],$formAction[1]) }}" method="POST" class="validated" enctype="multipart/form-data">
         @csrf
         @if(!empty($formAction[1]))
         @method('PUT')        
         @endif
         <div class="risk-assessment">
            <div class="card-header">
               <h2>Risk Assessment</h2>
            </div>
            <input type="hidden" name="template_id" value="10">
            <input type="hidden" name="user_id" value='{{$participant->user_id}}'>
            <input type="hidden" name="participant_controller" value='{{$participantController}}'>
            <div class="form-group ">
               <h4>OTHER PRIMARY FAMILY DETAILS</h4>
            </div>
            <div class="detail-participant below-form">
               <div class="row">
                  <div class="col-sm-4">
                     <label>  Background Information</label>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::textarea('meta[background_info]', '', issetKey( $meta, 'background_info', '' ))
                     ->required('required')
                     ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=> trans('errors.opform.risk_assessment.bg_info') ])
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-4">
                     <label>  Risk Assessment Date</label>
                  </div>
                  <div class="col-sm-8">
                     {!! 
                     Form::date('meta[risk_assessment_date]', '', old('risk_assessment_date', isset($meta['risk_assessment_date']) ? $meta['risk_assessment_date'] : date('d-m-Y')))
                     ->id('risk_assessment_date')
                     ->readonly($readOnly)
                     ->required('required')
                     ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=> trans('errors.opform.risk_assessment.date_required') ])
                     !!}
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-4">
                     <label> Name of person conducting assessment</label>
                  </div>
                  <div class="col-sm-8">
                     {!! Form::text('meta[person_name_conducting_assessment]', '', issetKey( $meta, 'person_name_conducting_assessment', '' ))
                     ->id('person_name_conducting_assessment')
                     ->required('required')
                     ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=> trans('errors.opform.risk_assessment.name_conducting') ])
                     !!}
                  </div>
               </div>
            </div>
            <div class="assessment-column">
               <div class="risk-assessment-re-build  input-ontd custom-border">
                  <div class="table-responsive">
                     <div classs="form-group">
                        <label for="Language">Risk Assessment</label>
                     </div>
                     <table class="table-responsive">
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
                           <tr>
                              <th scope="row">1</th>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[identify][1]', '', old('identify[1]', isset($meta['identify'][1]) ? $meta['identify'][1] : ''))
                                    !!}
                                    {{-- <input type="text" name="first_name" id="inp-first_name" value="" class="form-control"> --}}
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[risk][1]', '', old('risk[1]', isset($meta['risk'][1]) ? $meta['risk'][1] : ''))
                                    !!}
                                    {{-- <input type="text" name="first_name" id="inp-first_name" value="" class="form-control"> --}}
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[risk_rating][1]', '', old('risk_rating[1]', isset($meta['risk_rating'][1]) ? $meta['risk_rating'][1] : ''))
                                    !!}
                                    {{-- <input type="text" name="first_name" id="inp-first_name" value="" class="form-control"> --}}
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[addl_control][1]', '', old('addl_control[1]', isset($meta['addl_control'][1]) ? $meta['addl_control'][1] : ''))
                                    !!}
                                    {{-- <input type="text" name="first_name" id="inp-first_name" value="" class="form-control"> --}}
                                 </div>
                              </td>
                           </tr>
                           <tr>
                              <th scope="row">2</th>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[identify][2]', '', old('identify[2]', isset($meta['identify'][2]) ? $meta['identify'][2] : ''))
                                    !!}
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[risk][2]', '', old('risk[2]', isset($meta['risk'][2]) ? $meta['risk'][2] : ''))
                                    !!}
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[risk_rating][2]', '', old('risk_rating[2]', isset($meta['risk_rating'][2]) ? $meta['risk_rating'][2] : ''))
                                    !!}
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[addl_control][2]', '', old('addl_control[2]', isset($meta['addl_control'][2]) ? $meta['addl_control'][2] : ''))
                                    !!}
                                 </div>
                              </td>
                           </tr>
                           <tr>
                              <th scope="row">3</th>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[identify][3]', '', old('identify[3]', isset($meta['identify'][3]) ? $meta['identify'][3] : ''))
                                    !!}
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[risk][3]', '', old('risk[3]', isset($meta['risk'][3]) ? $meta['risk'][3] : ''))
                                    !!}                              
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[risk_rating][3]', '', old('risk_rating[3]', isset($meta['risk_rating'][3]) ? $meta['risk_rating'][3] : ''))
                                    !!}                              
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[addl_control][3]', '', old('addl_control[3]', isset($meta['addl_control'][3]) ? $meta['addl_control'][3] : ''))
                                    !!}
                                 </div>
                              </td>
                           </tr>
                           <tr>
                              <th scope="row">4</th>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[identify][4]', '', old('identify[4]', isset($meta['identify'][4]) ? $meta['identify'][4] : ''))
                                    !!}                              
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[risk][4]', '', old('risk[4]', isset($meta['risk'][4]) ? $meta['risk'][4] : ''))
                                    !!}
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[risk_rating][4]', '', old('risk_rating[4]', isset($meta['risk_rating'][4]) ? $meta['risk_rating'][4] : ''))
                                    !!}
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[addl_control][4]', '', old('addl_control[4]', isset($meta['addl_control'][4]) ? $meta['addl_control'][4] : ''))
                                    !!}
                                 </div>
                              </td>
                           </tr>
                           <tr>
                              <th scope="row">5</th>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[identify][5]', '', old('identify[5]', isset($meta['identify'][5]) ? $meta['identify'][5] : ''))
                                    !!}
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[risk][5]', '', old('risk[5]', isset($meta['risk'][5]) ? $meta['risk'][5] : ''))
                                    !!}
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[risk_rating][5]', '', old('risk_rating[5]', isset($meta['risk_rating'][5]) ? $meta['risk_rating'][5] : ''))
                                    !!}
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[addl_control][5]', '', old('addl_control[5]', isset($meta['addl_control'][5]) ? $meta['addl_control'][5] : ''))
                                    !!}
                                 </div>
                              </td>
                           </tr>
                           <tr>
                              <th scope="row">6</th>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[identify][6]', '', old('identify[6]', isset($meta['identify'][6]) ? $meta['identify'][6] : ''))
                                    !!}
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[risk][6]', '', old('risk[6]', isset($meta['risk'][6]) ? $meta['risk'][6] : ''))
                                    !!}
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[risk_rating][6]', '', old('risk_rating[6]', isset($meta['risk_rating'][6]) ? $meta['risk_rating'][6] : ''))
                                    !!}
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[addl_control][6]', '', old('addl_control[6]', isset($meta['addl_control'][6]) ? $meta['addl_control'][6] : ''))
                                    !!}
                                 </div>
                              </td>
                           </tr>
                           <tr>
                              <th scope="row">7</th>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[identify][7]', '', old('identify[7]', isset($meta['identify'][7]) ? $meta['identify'][7] : ''))
                                    !!}
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[risk][7]', '', old('risk[7]', isset($meta['risk'][7]) ? $meta['risk'][7] : ''))
                                    !!}
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[risk_rating][7]', '', old('risk_rating[7]', isset($meta['risk_rating'][7]) ? $meta['risk_rating'][7] : ''))
                                    !!}
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[addl_control][7]', '', old('addl_control[7]', isset($meta['addl_control'][7]) ? $meta['addl_control'][7] : ''))
                                    !!}
                                 </div>
                              </td>
                           </tr>
                           <tr>
                              <th scope="row">8</th>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[identify][8]', '', old('identify[8]', isset($meta['identify'][8]) ? $meta['identify'][8] : ''))
                                    !!}
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[risk][8]', '', old('risk[8]', isset($meta['risk'][8]) ? $meta['risk'][8] : ''))
                                    !!}
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[risk_rating][8]', '', old('risk_rating[8]', isset($meta['risk_rating'][8]) ? $meta['risk_rating'][8] : ''))
                                    !!}
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[addl_control][8]', '', old('addl_control[8]', isset($meta['addl_control'][8]) ? $meta['addl_control'][8] : ''))
                                    !!}
                                 </div>
                              </td>
                           </tr>
                           <tr>
                              <th scope="row">9</th>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[identify][9]', '', old('identify[9]', isset($meta['identify'][9]) ? $meta['identify'][9] : ''))
                                    !!}                              
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[risk][9]', '',  old('risk[9]', isset($meta['risk'][9]) ? $meta['risk'][9] : ''))
                                    !!}                              
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[risk_rating][9]', '', old('risk_rating[9]', isset($meta['risk_rating'][9]) ? $meta['risk_rating'][9] : ''))
                                    !!}
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[addl_control][9]', '', old('addl_control[9]', isset($meta['addl_control'][9]) ? $meta['addl_control'][9] : ''))
                                    !!}
                                 </div>
                              </td>
                           </tr>
                           <tr>
                              <th scope="row">10</th>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[identify][10]', '', old('identify[10]', isset($meta['identify'][10]) ? $meta['identify'][10] : ''))
                                    !!}                              
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[risk][10]', '', old('risk[10]', isset($meta['risk'][10]) ? $meta['risk'][10] : ''))
                                    !!}
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[risk_rating][10]', '', old('risk_rating[10]', isset($meta['risk_rating'][10]) ? $meta['risk_rating'][10] : ''))
                                    !!}
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[addl_control][10]', '', old('addl_control[10]', isset($meta['addl_control'][10]) ? $meta['addl_control'][10] : ''))
                                    !!}
                                 </div>
                              </td>
                           </tr>
                           <tr>
                              <th scope="row">11</th>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[identify][11]', '', old('identify[11]', isset($meta['identify'][11]) ? $meta['identify'][11] : ''))
                                    !!}
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[risk][11]', '', old('risk[11]', isset($meta['risk'][11]) ? $meta['risk'][11] : ''))
                                    !!}
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[risk_rating][11]', '', old('risk_rating[11]', isset($meta['risk_rating'][11]) ? $meta['risk_rating'][11] : ''))
                                    !!}
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[addl_control][11]', '', old('addl_control[11]', isset($meta['addl_control'][11]) ? $meta['addl_control'][11] : ''))
                                    !!}
                                 </div>
                              </td>
                           </tr>
                           <tr>
                              <th scope="row">12</th>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[identify][12]', '', old('identify[12]', isset($meta['identify'][12]) ? $meta['identify'][12] : ''))
                                    !!}                          
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[risk][12]', '', old('risk[12]', isset($meta['risk'][12]) ? $meta['risk'][12] : ''))
                                    !!}
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[risk_rating][12]', '', old('risk_rating[12]', isset($meta['risk_rating'][12]) ? $meta['risk_rating'][12] : ''))
                                    !!}
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    {!! 
                                    Form::text('meta[addl_control][12]', '', old('addl_control[12]', isset($meta['addl_control'][12]) ? $meta['addl_control'][12] : ''))
                                    !!}
                                 </div>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
            <div class="risk-page-two below-form mt-40">
               <div class="form-group ">
                  <label for="Language"><strong>Consequence </strong>– Evaluate the consequences of a risk occurring according to the ratings in the top row.</label>
               </div>
               <div class="risk-assessment-re-build custom-border">
                  <div class="table-responsive">
                     <div classs="form-group">
                        <label for="Language">Risk Assessment</label>
                     </div>
                     <table class="table">
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
            <div class="risk-page-two below-form">
               <div class="risk-assessment-re-build custom-border">
                  <div class="table-responsive">
                     <div classs="form-group">
                        <label for="Language"><strong>Risk Matrix  </strong> – Using the matrix calculate the level of <strong>risk</strong> by finding the intersection between the likelihood and the consequences</label>
                     </div>
                     <table class="table-responsive">
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
            <div class="risk-page-two below-form">
               <div class="risk-assessment-re-build onlyfor-theading custom-border">
                  <div class="table-responsive">
                     <div classs="form-group">
                        <label for="Language"> <strong>Likelihood</strong>- Evaluate the  <strong>Likelihood </strong> of an incident occurring according to the rating in the left hand column</label>
                     </div>
                     <table class="table">
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
                           <table class="table">
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
            {!! Form::submit('Submit')->attrs(["class"=>"rounded"]) !!}
      </form>
      {{-- 10th risk-assessment Form end here--}} 
      </div>
   </div>
</div>
@endsection