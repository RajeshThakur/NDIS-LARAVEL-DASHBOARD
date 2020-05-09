@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-header participant">
      {{-- <span><i class="fa fa-arrow-left" aria-hidden="true"></i></span>
      {{ trans('global.create') }} {{ trans('participants.title_singular') }} --}}
   </div>
   <div class="card-body">
      {{-----Self-Assessment Submission Form start--------}}
      <div class="form-parent">
         <div class="self-assessment ">
            <h2 class="form-title">Self-Assessment Submission Form</h2>
            <p class="default-text">Please complete the following details, to be submitted with the self-assessment to the Department of Communities
               Child Safety and Disability Services (DCCSDS) at <a class="gmail" href="#">hsqf@communities.qld.gov.au.</a>
            </p>
            <div class="self-assessment-fields">
               <div class="left-fields">
                  {!! 
                  Form::text('provider_name', '
                  <p>Provider name</p>
                  <p class="helper">(legal entity)</p>
                  ', old('provider_name', isset($opMetaData['provider_name']) ? ($opMetaData['provider_name']) : ''))
                  ->id('provider_name')
                  !!}
                  {!! 
                  Form::text('provider_trading_name', '
                  <p>Provider trading name </p>
                  <p class="helper">(where applicable)</p>
                  ', old('provider_trading_name', isset($opMetaData['provider_trading_name']) ? ($opMetaData['provider_trading_name']) : ''))
                  ->id('provider_trading_name')
                  !!}
                  {!! 
                  Form::text('australian_business_no', '
                  <p>Australian Business No  (ABN) </p>
                  ',  old('australian_business_no', isset($opMetaData['australian_business_no']) ? ($opMetaData['australian_business_no']) : ''))
                  ->id('australian_business_no')
                  !!}
                  {!! 
                  Form::text('ndis_provider_reg_no', '
                  <p>NDIS Provider Registration No</p>
                  ', old('ndis_provider_reg_no', isset($opMetaData['ndis_provider_reg_no']) ? ($opMetaData['ndis_provider_reg_no']) : ''))
                  ->id('ndis_provider_reg_no')
                  !!}
                  {!! 
                  Form::text('head_office_address', '
                  <p>Head Office physical address </p>
                  ', old('head_office_address', isset($opMetaData['head_office_address']) ? ($opMetaData['head_office_address']) : ''))
                  ->id('head_office_address')
                  !!}
                  {!! 
                  Form::text('provider_legal_entity_status', '
                  <p>Provider legal entity status 
                  </p>
                  <p class="helper">(e.g. Sole Trader, Partnership, Australian Private Company, Incorporated Association)</p>
                  ', old('provider_legal_entity_status', isset($opMetaData['provider_legal_entity_status']) ? ($opMetaData['provider_legal_entity_status']) : '') )
                  ->id('provider_legal_entity_status')
                  !!}
                  <div class="form-group row">
                     <label for="" class="col-sm-3 col-form-label custom-label">
                        <p>NDIS Registration group(s)– Section 4 NDIS Guide to Suitability
                        </p>
                        <p class="helper">
                           (Please check all relevant boxes) 
                        </p>
                     </label>
                     <div class="col-sm-9">
                        <div class="row">
                           <div class="col-sm-12">
                              <div class="row border-btm">
                                 <div class="form-check form-check-inline custom-check col-sm-4">
                                    <input class="form-check-input asignment-check" name="registration_groups_guide" type="checkbox" value="">
                                    <label class="form-check-label" for="defaultCheck1">
                                    Development Life Skills (01117) 
                                    </label>
                                 </div>
                                 <div class="form-check form-check-inline custom-check col-sm-4">
                                    <input class="form-check-input asignment-check" name="registration_groups_guide" type="checkbox" value="">
                                    <label class="form-check-label" for="defaultCheck1">
                                    Daily Personal Activities (0107) 
                                    </label>
                                 </div>
                                 <div class="form-check form-check-inline custom-check col-sm-4">
                                    <input class="form-check-input asignment-check" name="registration_groups_guide" type="checkbox" value="">
                                    <label class="form-check-label" for="defaultCheck1">
                                    High Intensity Daily Personal Activities (0104)
                                    </label>
                                 </div>
                                 <div class="form-check form-check-inline custom-check col-sm-4">
                                    <input class="form-check-input asignment-check" name="registration_groups_guide" type="checkbox" value="">
                                    <label class="form-check-label" for="defaultCheck1">
                                    Daily Tasks/Shared Living (0115) 
                                    </label>
                                 </div>
                                 <div class="form-check form-check-inline custom-check col-sm-4">
                                    <input class="form-check-input asignment-check" name="registration_groups_guide" type="checkbox" value="">
                                    <label class="form-check-label" for="defaultCheck1">
                                    Participate Community (0125)  
                                    </label>
                                 </div>
                                 <div class="form-check form-check-inline custom-check col-sm-4">
                                    <input class="form-check-input asignment-check" name="registration_groups_guide" type="checkbox" value="">
                                    <label class="form-check-label" for="defaultCheck1">
                                    Group/Centre Activities  (0136)   
                                    </label>
                                 </div>
                                 <div class="form-check form-check-inline custom-check col-sm-4">
                                    <input class="form-check-input asignment-check" name="registration_groups_guide" type="checkbox" value="">
                                    <label class="form-check-label" for="defaultCheck1">   
                                    Plan Management (0127)    Life Stage, Transition (0106) 
                                    </label>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="" class="col-sm-3 col-form-label custom-label">
                        <p>NDIS Professional Registration group(s) 
                           Section 5 NDIS Guide to Suitability
                        </p>
                        <p class="helper">
                           (Please check all relevant boxes and  include evidence of membership with relevant professional association as per requirements of Section 8 Guide to Suitability)
                        </p>
                     </label>
                     <div class="col-sm-9">
                        <div class="row">
                           <div class="col-sm-12">
                              <div class="row border-btm">
                                 <div class="form-check form-check-inline custom-check col-sm-3">
                                    <input class="form-check-input asignment-check" name="professional_registration_group" type="checkbox" value="">
                                    <label class="form-check-label" for="defaultCheck1">
                                    Behaviour Support (0110)    
                                    </label>
                                 </div>
                                 <div class="form-check form-check-inline custom-check col-sm-3">
                                    <input class="form-check-input asignment-check" name="professional_registration_group" type="checkbox" value="">
                                    <label class="form-check-label" for="defaultCheck1">
                                    Early Intervention for early childhood (0118
                                    </label>
                                 </div>
                                 <div class="form-check form-check-inline custom-check col-sm-3">
                                    <input class="form-check-input asignment-check" name="professional_registration_group" type="checkbox" value="">
                                    <label class="form-check-label" for="defaultCheck1">
                                    Support Coordination (0132)   
                                    </label>
                                 </div>
                                 <div class="form-check form-check-inline custom-check col-sm-3">
                                    <input class="form-check-input asignment-check" name="professional_registration_group" type="checkbox" value="">
                                    <label class="form-check-label" for="defaultCheck1">
                                    Therapeutic Supports (0128) 
                                    </label>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="form-group row ">
                     <label for="" class="col-sm-3 col-form-label custom-label">
                        <p>NDIS participant focus
                        </p>
                        <p class="helper">
                           (Please check all relevant boxes)
                        </p>
                     </label>
                     <div class="col-sm-9">
                        <div class="row">
                           <div class="col-sm-12">
                              <div class="row border-btm">
                                 <div class="form-check form-check-inline custom-check col-sm-3">
                                    <input class="form-check-input asignment-check" name="ndis_participant_focus" type="checkbox" value="">
                                    <label class="form-check-label" for="defaultCheck1">
                                    Children and young people under 18 years   
                                    </label>
                                 </div>
                                 <div class="form-check form-check-inline custom-check col-sm-3">
                                    <input class="form-check-input asignment-check" name="ndis_participant_focus" type="checkbox" value="">
                                    <label class="form-check-label" for="defaultCheck1">
                                    Adults over 18 years
                                    </label>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  {!! 
                  Form::location('geographic_loc_deliver', '
                  <p>Geographic location for delivery of registration groups</p>
                  ', old('geographic_loc_deliver', isset($opMetaData['geographic_loc_deliver']) ? ($opMetaData['geographic_loc_deliver']) : '') )
                  ->id('geographic_loc_deliver')
                  !!}
                  <div class="form-group row  mb-none">
                     <label for="" class="col-sm-3 col-form-label custom-label">
                        <p>Accountable officer</p>
                        <p class="helper">(refer to Declaration below)</p>
                     </label>
                     <div class="col-sm-9">
                        <div class="row">
                           {!! 
                           Form::text('accountable_officer_name', 'Name', old('accountable_officer_name', isset($opMetaData['accountable_officer_name']) ? ($opMetaData['accountable_officer_name']) : ''))
                           ->id('accountable_officer_name')
                           !!}
                        </div>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="" class="col-sm-3 col-form-label custom-label">
                        <p></p>
                     </label>
                     <div class="col-sm-9">
                        <div class="row">
                           {!! 
                           Form::text('accountable_position_name', 'Position', old('accountable_position_name', isset($opMetaData['accountable_position_name']) ? ($opMetaData['accountable_position_name']) : ''))
                           ->id('accountable_position_name')
                           !!}
                        </div>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="" class="col-sm-3 col-form-label custom-label">
                        <p></p>
                     </label>
                     <div class="col-sm-9">
                        <div class="row">
                           {!! 
                           Form::text('accountable_email_name', 'Email', old('accountable_email_name', isset($opMetaData['accountable_email_name']) ? ($opMetaData['accountable_email_name']) : ''))
                           ->id('accountable_email_name')
                           !!}
                        </div>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="" class="col-sm-3 col-form-label custom-label">
                        <p></p>
                     </label>
                     <div class="col-sm-9">
                        <div class="row">
                           {!! 
                           Form::text('accountable_phone_no', 'Phone Contact', old('accountable_phone_no', isset($opMetaData['accountable_phone_no']) ? ($opMetaData['accountable_phone_no']) : ''))
                           ->id('accountable_phone_no')
                           !!}
                        </div>
                     </div>
                  </div>
                  <div class="form-group row ">
                     <label for="" class="col-sm-3 col-form-label custom-label">
                        <p>Person who completed the self-assessment </p>
                     </label>
                     <div class="col-sm-9">
                        <div class="form-group row">
                           {!! 
                           Form::text('person_self_assessment_name', 'Name', old('person_self_assessment_name', isset($opMetaData['person_self_assessment_name']) ? ($opMetaData['person_self_assessment_name']) : ''))
                           ->id('person_self_assessment_name')
                           !!}
                        </div>
                        <div class="form-group row">
                           {!! 
                           Form::text('person_self_assessment_position', 'Position', old('person_self_assessment_position', isset($opMetaData['person_self_assessment_position']) ? ($opMetaData['person_self_assessment_position']) : ''))
                           ->id('person_self_assessment_position')
                           !!}
                        </div>
                     </div>
                  </div>
                  {!! 
                  Form::date('self_assessment_complted_date', '
                  <p>Date slef-assessment completed</p>
                  ', old('self_assessment_complted_date', isset($opMetaData['self_assessment_complted_date']) ? ($opMetaData['self_assessment_complted_date']) : date('d-m-Y')))
                  ->id('self_assessment_complted_date')
                  !!}
               </div>
            </div>
         </div>
      </div>
      {{-----Self-Assessment Submission Form end--------}}
      {{-----Self-assessment workbook start--------}}
      {{-----Self-assessment workbook standerd1 start--------}}
      <div class="assessment-work-book">
         {{-----Self-assessment workbook section one start--------}}
         <div class="workbook-sheet">
            <h2 class="form-title">Self-assessment workbook</h2>
            <div class="row backbg-book">
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Reference</h5>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Indicator details </h5>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Core (C) or  Developmental (D)</h5>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Requirements</h5>
                        <p>(Safeguard requirements to be addressed in the indicator)</p>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Evidence available</h5>
                        <p> (Yes or No)</p>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Provider evidence</h5>
                        <p>(What is, or is intended to be in place, to meet this indicator)</p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row under-title-bg">
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="text-book">
                        <h5>Standard 1 </h5>
                     </div>
                  </div>
               </div>
               <div class="col-sm-10">
                  <div class="bg-height">
                     <div class="text-book">
                        <h5>Governance and management</h5>
                        <hr>
                     </div>
                     <h5>Expected Outcomes:<span> Sound governance and management systems that maximise outcomes for stakeholders </span></h5>
                     <hr>
                     <h5>Context:<span> The organisation maintains accountability to stakeholders through the implementation and
                        maintenance of sound governance and management systems. These systems should reflect the size and structure of the organisation 
                        and contribute to maximising outcomes for people using services. </span>
                     </h5>
                  </div>
               </div>
            </div>
            <div class="row mt-40">
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="text-book">
                     </div>
                     <p>1.1</p>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="text-book">
                     </div>
                     <p>The organisation has effective information management systems that maintain appropriate controls of privacy and confidentiality for stakeholders.</p>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <p>Core</p>
                     <p>Evidence examples</p>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="bg-height">
                     <p> Processes or systems are in place for ensuring compliance with financial, legislative, regulatory and contractual responsibilities relevant to the 
                        provider’s operations. 
                     <hr>
                     </p>
                     <p>Defined structure and process for monitoring and responding to quality and safety matters associated with delivering supports to Participants. </p>
                     <hr>
                     <p>Documented business or organisational structure/plan (appropriate to the size of the provider and the types of supports
                        or services to be provided) that identifies key decision makers, roles and relationships, and delegated authorities.
                     </p>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-6">
               </div>
               <div class="col-sm-6">
                  <div class="below-form work-sheet-list">
                     <ul>
                        <li>
                           <div class="form-group">
                              <p>Policies, procedures or other documentation that support good governance e.g. constitution, terms of reference, or equivalent guiding 
                                 documents that articulate processes of how the governing body/company/sole trader operates, including meeting and reporting arrangements, 
                                 conflict of interest policy/procedure, Code of Conduct.
                                 :
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Processes for maintaining legislative compliance e.g. regulatory compliance processes, external audits/reviews, advisory services 
                                 & professional or industry specific memberships
                                 :
                              </p>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         {{-----Self-assessment workbook section one end--------}}
         {{-----Self-assessment workbook section two start--------}}
         <div class="workbook-sheet">
            <div class="row backbg-book">
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Reference</h5>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Indicator details </h5>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Core (C) or  Developmental (D)</h5>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Requirements</h5>
                        <p>(Safeguard requirements to be addressed in the indicator)</p>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Evidence available</h5>
                        <p> (Yes or No)</p>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Provider evidence</h5>
                        <p>(What is, or is intended to be in place, to meet this indicator)</p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row mt-40">
               <div class="col-sm-2">
                  <div class="bg-height">
                     <p>1.2</p>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <p>The organisation ensures that members of the governing body possess and maintain the knowledge, skills and experience required to fulfil their roles.</p>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <p>Core</p>
                     <p>Evidence examples</p>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="bg-height">
                     <p>Members of the governing body* has access to learning and development opportunities relevant to their role and function</p>
                     <p><i>(*Note: For providers without a governing body this requirement can be interpreted to include learning and development relevant to provision of
                        supports and services to NDIS participants) </i>
                     </p>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-6">
               </div>
               <div class="col-sm-6">
                  <div class="below-form work-sheet-list">
                     <ul>
                        <li>
                           <div class="form-group">
                              <p>Records of orientation, induction or training provided, attendance at professional development training/workshops
                                 :
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Processes for identifying and addressing any gaps in skills or knowledge or experience 
                                 :
                              </p>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
            <div class="row mt-40 border-top">
               <div class="col-sm-2">
                  <div class="bg-height">
                     <p>1.3</p>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <p>The organisation develops and implements a vision, purpose statement, values, objectives and strategies for service delivery that
                        reflect contemporary practice.
                     </p>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <p>Core</p>
                     <p>Evidence examples</p>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="bg-height">
                     <p>The purpose and values of the provider are documented and communicated to stakeholders </p>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-6">
               </div>
               <div class="col-sm-6">
                  <div class="below-form work-sheet-list">
                     <ul>
                        <li>
                           <div class="form-group">
                              <p>Processes to establish plans, objectives & strategies required to deliver services. These may include: strategic plan, business or operational plan, vision and 
                                 values statement, 
                                 client charter, Code of Conduct 
                                 :
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Processes for measuring performance against established plans 
                                 :
                              </p>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         {{-----Self-assessment workbook section two start--------}}
         {{-----Self-assessment workbook section three start--------}}
         <div class="workbook-sheet">
            <div class="row backbg-book">
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Reference</h5>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Indicator details </h5>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Core (C) or  Developmental (D)</h5>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Requirements</h5>
                        <p>(Safeguard requirements to be addressed in the indicator)</p>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Evidence available</h5>
                        <p> (Yes or No)</p>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Provider evidence</h5>
                        <p>(What is, or is intended to be in place, to meet this indicator)</p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row mt-40">
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="text-book">
                     </div>
                     <p>1.4</p>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="text-book">
                     </div>
                     <p>The organisation’s management systems are clearly defined, documented, monitored and (where appropriate) communicated including finance, assets 
                        and risk.
                     </p>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <p>Core</p>
                     <p>Evidence examples</p>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="bg-height">
                     <p>Evidence of a risk management framework that addresses the core elements of ISO 31000. </p>
                     <p>This should include: processes for identifying, assessing and managing risk, including: organisational; financial; occupational; as well as risks associated with provision
                        of supports to participants. 
                     </p>
                     <p><i>Note: This framework should be proportionate to the provider’s size, structure and types of supports provided</i> </p>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-6">
               </div>
               <div class="col-sm-6">
                  <div class="below-form work-sheet-list">
                     <ul>
                        <li>
                           <div class="form-group">
                              <p>Documented risk management plans including risk assessments relating to support activities for NDIS participants, financial and asset management, 
                                 occupational health & safety, building/equipment
                                 maintenance plan, business continuity plan, emergency/disaster management & recovery plans
                                 :
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Financial management systems which support effective management, accountability, control & ongoing viability (e.g. documentation of financial controls & delegations, insurances, 
                                 budgeting & purchasing processes, payroll processes)
                                 :
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Processes for delegating authority & responsibilities throughout the organisation & for establishing, recording, communicating & reviewing delegated
                                 authority
                                 :
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Processes for reporting adverse events including notification to the correct authority where required e.g. incident reporting 
                                 :
                              </p>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         {{-----Self-assessment workbook section three start--------}}
         {{-----Self-assessment workbook section four start--------}}
         <div class="workbook-sheet">
            <div class="row backbg-book">
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Reference</h5>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Indicator details </h5>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Core (C) or  Developmental (D)</h5>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Requirements</h5>
                        <p>(Safeguard requirements to be addressed in the indicator)</p>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Evidence available</h5>
                        <p> (Yes or No)</p>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Provider evidence</h5>
                        <p>(What is, or is intended to be in place, to meet this indicator)</p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row mt-40">
               <div class="col-sm-2">
                  <div class="bg-height">
                     <p>1.5</p>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <p>Mechanisms for continuous improvement are demonstrated in organisational management and service delivery processes.</p>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <p>Developmental</p>
                     <p>Evidence examples</p>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="bg-height">
                     <p>A continuous improvement plan that includes (at a minimum): </p>
                     <div class="below-form work-sheet-list">
                        <ul>
                           <li>
                              <div class="form-group">
                                 <p>Documented continuous quality improvement plan</p>
                              </div>
                           </li>
                           <li>
                              <div class="form-group">
                                 <p>Improvement processes connected to: feedback, complaints and appeals processes; records of incidents for people using services; workplace 
                                    injuries/hazard reporting systems
                                 </p>
                              </div>
                           </li>
                           <li>
                              <div class="form-group">
                                 <p>Processes for the governing body to regularly review the effectiveness of its own processes and structure in providing good governance to the organisation</p>
                              </div>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row mt-40 border-top">
               <div class="col-sm-2">
                  <div class="bg-height">
                     <p>1.6</p>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <p>The organisation encourages and promotes processes for participation by people using services and other relevant stakeholders in governance and management processes.</p>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <p>Developmental</p>
                     <p>Evidence examples</p>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="bg-height">
                     <p>Participants, their nominated representatives and/or advocates are offered opportunities to participate in review and improvement activities </p>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-6">
               </div>
               <div class="col-sm-6">
                  <div class="below-form work-sheet-list">
                     <ul>
                        <li>
                           <div class="form-group">
                              <p>Strategies & processes that support participation by people using services & other stakeholders 
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Strategies for supporting people using services to submit feedback on service management or governance processes e.g. surveys, feedback forms &/or member groups 
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Representation of people using services on the organisation’s board 
                              </p>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         {{-----Self-assessment workbook section four end--------}}
         {{-----Self-assessment workbook section five start--------}}
         <div class="workbook-sheet">
            <div class="row backbg-book">
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Reference</h5>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Indicator details </h5>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Core (C) or  Developmental (D)</h5>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Requirements</h5>
                        <p>(Safeguard requirements to be addressed in the indicator)</p>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Evidence available</h5>
                        <p> (Yes or No)</p>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Provider evidence</h5>
                        <p>(What is, or is intended to be in place, to meet this indicator)</p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row mt-40">
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="text-book">
                     </div>
                     <p>1.7</p>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="text-book">
                     </div>
                     <p>The organisation has effective information management systems that maintain appropriate controls of privacy and confidentiality for stakeholders.</p>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <p>Core</p>
                     <p>Evidence examples</p>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="bg-height">
                     <p> Processes are in place for ensuring the confidentiality and privacy of personal information of participants and other stakeholders  </p>
                     <hr>
                     <p>Processes are in place for aligning information management systems and operational processes with privacy legislation and relevant privacy principles. </p>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-6">
               </div>
               <div class="col-sm-6">
                  <div class="below-form work-sheet-list">
                     <ul>
                        <li>
                           <div class="form-group">
                              <p>Policies &  procedures addressing information management, privacy & confidentiality requirements,
                                 management of consents, retrieval, archiving and disposal of records, & records management generally
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Privacy Policy & processes that align with the Australian Privacy Principles</p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Privacy statement is included on all forms or electronic platforms used to collect personal information </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Electronic storage systems have appropriate security mechanisms (including ensuring the security, privacy & 
                                 confidentiality of information supported by cloud based technology 
                                 such as web portals & portable electronic devices such as iPad and laptops, smartphones and USB  
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Processes for maintaining physical security, including access to building(s), rooms & filing cabinets </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Where electronic monitoring is in use (e.g. in accommodation sites), documented processes to guide its usage, storage and retrieval of 
                                 images & obtaining informed 
                                 consent from people using services & other relevant stakeholders 
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Records &/or feedback from participants (family members or carers) or other stakeholders confirm the 
                                 effectiveness of privacy & confidentiality controls, as appropriate to the supports provided  
                              </p>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         {{-----Self-assessment workbook section five end--------}}
         {{-----Self-assessment workbook standerd1 end--------}}
         {{-----Self-assessment workbook standerd2 start--------}}
         <div class="workbook-sheet">
            <div class="row backbg-book">
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Reference</h5>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Indicator details </h5>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Core (C) or  Developmental (D)</h5>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Requirements</h5>
                        <p>(Safeguard requirements to be addressed in the indicator)</p>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Evidence available</h5>
                        <p> (Yes or No)</p>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Provider evidence</h5>
                        <p>(What is, or is intended to be in place, to meet this indicator)</p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row under-title-bg">
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="text-book">
                        <h5>Standard 2 </h5>
                     </div>
                  </div>
               </div>
               <div class="col-sm-10">
                  <div class="bg-height">
                     <div class="text-book">
                        <h5>Service access</h5>
                        <hr>
                     </div>
                     <h5> Expected Outcomes:<span> Sound eligibility, entry and exit processes facilitate access to services on the basis of relative  </span></h5>
                     <hr>
                     <h5>Context:<span>The organisation makes their services available to their target group 
                        in fair, transparent and non-discriminatory ways and people seeking access to services are prioritised and responded to. </span>
                     </h5>
                  </div>
               </div>
            </div>
            <div class="row mt-40">
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="text-book">
                     </div>
                     <p>2.1</p>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="text-book">
                     </div>
                     <p>Where the organisation has responsibility for eligibility, entry and exit processes, these are 
                        consistently applied based on relative need, available resources and the purpose of the service.
                     </p>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <p>Developmental</p>
                     <p>Evidence examples</p>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="bg-height">
                     <p> Processes are in place for ensuring that participants seeking to access supports are treated in a fair, equitable and non-discriminatory way.</p>
                  </div>
               </div>
               <div class="col-sm-6">
               </div>
               <div class="col-sm-6">
                  <div class="bg-height">
                     <p>Eligibility criteria, priority of access & waiting list policy & procedures are developed within the context of the<i> Anti-Discrimination Act 1991 </i>
                        (Queensland) and/or <i>Disability Discrimination Act 1992 </i>(Commonwealth)
                     </p>
                  </div>
               </div>
            </div>
            <div class="row mt-40 border-top">
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="text-book">
                     </div>
                     <p>2.2</p>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="text-book">
                     </div>
                     <p>Where an organisation is unable to provide services to a person, due to ineligibility or lack of capacity, 
                        there are processes in place to refer the person to an appropriate alternative service.
                     </p>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <p>Developmental</p>
                     <p>Evidence examples</p>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="bg-height">
                     <p>Information available to participants on the process for leaving the service includes alternative service options and referral points </p>
                  </div>
               </div>
               <div class="col-sm-6">
               </div>
               <div class="col-sm-6">
                  <div class="bg-height">
                     <p>Procedures describe the information that will be provided to people on leaving the service & this includes information on alternative service options & referral points </p>
                  </div>
               </div>
            </div>
            <div class="row mt-40 border-top">
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="text-book">
                     </div>
                     <p>2.3</p>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="text-book">
                     </div>
                     <p>The organisation has processes to communicate, interact effectively and respond to the individuals’ decision to access and/or exit services.</p>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <p>Core</p>
                     <p>Evidence examples</p>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="bg-height">
                     <p>Access and entry criteria (including associated costs) are clearly defined and communicated to participants in a manner and
                        format the person is most likely to understand.
                     </p>
                  </div>
               </div>
               <div class="col-sm-6">
               </div>
               <div class="col-sm-6">
                  <div class="bg-height">
                     <p>Welcome kit for participants, family members and carers (available in different formats) is provided on entry to the service or initial engagement with provider </p>
                  </div>
               </div>
            </div>
         </div>
         {{-----Self-assessment workbook standerd2 end--------}}
         {{-----Self-assessment workbook standerd3 start--------}}
         <div class="workbook-sheet">
            <div class="row backbg-book">
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Reference</h5>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Indicator details </h5>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Core (C) or  Developmental (D)</h5>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Requirements</h5>
                        <p>(Safeguard requirements to be addressed in the indicator)</p>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Evidence available</h5>
                        <p> (Yes or No)</p>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Provider evidence</h5>
                        <p>(What is, or is intended to be in place, to meet this indicator)</p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row under-title-bg">
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="text-book">
                        <h5>Standard 3 </h5>
                     </div>
                  </div>
               </div>
               <div class="col-sm-10">
                  <div class="bg-height">
                     <div class="text-book">
                        <h5>Responding to individual need</h5>
                        <hr>
                     </div>
                     <h5> Expected Outcomes:<span> Expected Outcomes: The assessed needs of the individual are being appropriately addressed and responded to
                        within resource capability. </span>
                     </h5>
                     <hr>
                     <h5>Context:<span>The organisation provides appropriate services that are identified/assessed, planned, monitored, reviewed and delivered in 
                        collaboration with the person using the service, their representative and/or relevant stakeholders. 
                        The organisation uses referral pathways and partnerships to promote  </span>
                     </h5>
                  </div>
               </div>
            </div>
            <div class="row mt-40">
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="text-book">
                     </div>
                     <p>3.1</p>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="text-book">
                     </div>
                     <p>The organisation uses flexible and inclusive methods to identify the individual strengths, needs, goals and aspirations of people using services.</p>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <p>Developmental</p>
                     <p>Evidence examples</p>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="bg-height">
                     <div class="bg-height">
                        <p> Processes are in place demonstrating a person-centred approach to provision of supports</p>
                        <hr>
                        <p>Staff/key personnel are provided with training on how to use a strengths-based approach to identifying needs and life goals</p>
                        <hr>
                        <p>Records show how feedback is sought from participants on the most appropriate ways to collaboratively work together to identify 
                           strengths, needs and life goals
                        </p>
                        <hr>
                        <p>Participant support plans show that the wellbeing of the person is taken into consideration through individualised planning and review</p>
                     </div>
                     <div class="below-form work-sheet-list">
                        <p>Processes are in place for:</p>
                        <ul>
                           <li>
                              <div class="form-group">
                                 <p>Assessing & recording individual/s’ needs, strengths, goals and 
                                 </p>
                              </div>
                           </li>
                           <li>
                              <div class="form-group">
                                 <p>Including & ensuring the active involvement of the individual/s in </p>
                              </div>
                           </li>
                           <li>
                              <div class="form-group">
                                 <p>Promoting a belief in the ability of people with disability to fulfil valued roles in the community
                                    (e.g. through promoting skills development and lifelong learning)
                                 </p>
                              </div>
                           </li>
                           <li>
                              <div class="form-group">
                                 <p>Informing people using services about changes to service provision</p>
                              </div>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         {{---------selfassessment workbook standered 3.2 start------------}}
         <div class="workbook-sheet">
            <div class="row backbg-book">
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Reference</h5>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Indicator details </h5>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Core (C) or  Developmental (D)</h5>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Requirements</h5>
                        <p>(Safeguard requirements to be addressed in the indicator)</p>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Evidence available</h5>
                        <p> (Yes or No)</p>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="heading-back-bg">
                        <h5>Provider evidence</h5>
                        <p>(What is, or is intended to be in place, to meet this indicator)</p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row mt-40">
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="text-book">
                     </div>
                     <p>3.2</p>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <div class="text-book">
                     </div>
                     <p>The organisation has processes to ensure that services delivered to individual(s) are monitored, reviewed and reassessed in a timely manner.</p>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="bg-height">
                     <p>Core</p>
                     <p>Developmental</p>
                     <p>Evidence examples</p>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="bg-height">
                     <div class="bg-height">
                        <p>Core guiding documents and/or purpose statements describe how the provider responds to diversity, at both an organisational and individual participant level. </p>
                        <hr>
                        <p>Where supports are provided to Aboriginal and Torres Strait Islander people, processes are in place to support a culturally informed
                           assessment process and for addressing cultural strengths, risks and needs in the provision of supports.
                        </p>
                        <hr>
                        <p>Policy outlining the provider’s commitment to supporting diversity is available. </p>
                        <hr>
                        <p>Staff participate in relevant training regarding diversity, cultural competency and can describe implications of recognising and facilitating diversity in 
                           the provision of supports to participants
                        </p>
                     </div>
                  </div>
                  <div class="below-form work-sheet-list">
                     <ul>
                        <li>
                           <div class="form-group">
                              <p>Processes for allocating a suitable person/s working for the provider to deliver the most appropriate service</p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Cultural competency </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Processes for promoting opportunities for people using services to fulfil valued community roles</p>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
      {{---------selfassessment workbook standered 3.2 end------------}}
      {{---------selfassessment workbook standered 3.3 start------------}}
      <div class="workbook-sheet">
         <div class="row backbg-book">
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Reference</h5>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Indicator details </h5>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Core (C) or  Developmental (D)</h5>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Requirements</h5>
                     <p>(Safeguard requirements to be addressed in the indicator)</p>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Evidence available</h5>
                     <p> (Yes or No)</p>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Provider evidence</h5>
                     <p>(What is, or is intended to be in place, to meet this indicator)</p>
                  </div>
               </div>
            </div>
         </div>
         <div class="row mt-40">
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="text-book">
                  </div>
                  <p>3.3</p>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="text-book">
                  </div>
                  <p>The organisation has processes to ensure that services delivered to individual(s) are monitored, reviewed and reassessed in a timely manner.</p>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <p>Core</p>
                  <p>Developmental</p>
                  <p>Evidence examples</p>
               </div>
            </div>
            <div class="col-sm-6">
               <div class="below-form work-sheet-list">
                  <p>Documented process/procedure that describes:</p>
                  <ul>
                     <li>
                        <div class="form-group">
                           <p>how the participant (and/or their nominated representative) consent to, and are involved in review planning </p>
                        </div>
                     </li>
                     <li>
                        <div class="form-group">
                           <p>how individualised planning, and review, is centred on the strengths, needs and goals of participants</p>
                        </div>
                     </li>
                     <li>
                        <div class="form-group">
                           <p>assessment and needs identification processes.</p>
                        </div>
                     </li>
                  </ul>
               </div>
               <div class="bg-height">
                  <p>Support staff/key personnel can describe how they facilitate the involvement of participants in making decisions
                     relating to their individual goals 
                  </p>
                  <hr>
                  <p>Staff/key personnel can describe how they review individual goals with participants and significant others, where relevant and/or as 
                     directed by the participant.
                  </p>
                  <hr>
                  <p>There are review records demonstrating how participants have progressed in achieving their goals, and that goal plans are 
                     modified where necessary so that goals remain relevant to the person
                  </p>
                  <hr>
                  <p>Feedback from participants confirms that their goals and aspirations have been considered during the review process</p>
               </div>
               <div class="below-form work-sheet-list">
                  <p>Processes are in place for:</p>
                  <ul>
                     <li>
                        <div class="form-group">
                           <p>Providing support in order to meet the changing needs, strengths, goals & aspirations of people accessing supports</p>
                        </div>
                     </li>
                     <li>
                        <div class="form-group">
                           <p>Planning, delivering, monitoring & reassessing the supports provided to an individual/s.</p>
                        </div>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
   {{---------selfassessment workbook standered 3.3 end------------}}
   {{---------selfassessment workbook standered 3.4 and 3.5 start------------}}
   <div class="workbook-sheet">
      <div class="row backbg-book">
         <div class="col-sm-2">
            <div class="bg-height">
               <div class="heading-back-bg">
                  <h5>Reference</h5>
               </div>
            </div>
         </div>
         <div class="col-sm-2">
            <div class="bg-height">
               <div class="heading-back-bg">
                  <h5>Indicator details </h5>
               </div>
            </div>
         </div>
         <div class="col-sm-2">
            <div class="bg-height">
               <div class="heading-back-bg">
                  <h5>Core (C) or  Developmental (D)</h5>
               </div>
            </div>
         </div>
         <div class="col-sm-2">
            <div class="bg-height">
               <div class="heading-back-bg">
                  <h5>Requirements</h5>
                  <p>(Safeguard requirements to be addressed in the indicator)</p>
               </div>
            </div>
         </div>
         <div class="col-sm-2">
            <div class="bg-height">
               <div class="heading-back-bg">
                  <h5>Evidence available</h5>
                  <p> (Yes or No)</p>
               </div>
            </div>
         </div>
         <div class="col-sm-2">
            <div class="bg-height">
               <div class="heading-back-bg">
                  <h5>Provider evidence</h5>
                  <p>(What is, or is intended to be in place, to meet this indicator)</p>
               </div>
            </div>
         </div>
      </div>
      <div class="row mt-40">
         <div class="col-sm-2">
            <div class="bg-height">
               <div class="text-book">
               </div>
               <p>3.4</p>
            </div>
         </div>
         <div class="col-sm-2">
            <div class="bg-height">
               <div class="text-book">
               </div>
               <p>The organisation has partnerships and collaborates to enable it to effectively work with community support networks, 
                  other organisations and government agencies as relevant and appropriate.
               </p>
            </div>
         </div>
         <div class="col-sm-2">
            <div class="bg-height">
               <p>Developmental</p>
               <p>Evidence examples</p>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="bg-height">
               <p>Records demonstrating collaboration with other services and/or professionals relevant to participant support needs. </p>
               <hr>
               <p>Documented arrangements for working in partnership with other providers, agencies and community members to support participants 
                  to actively participate in their community. 
               </p>
            </div>
            <div class="below-form work-sheet-list">
               <ul>
                  <li>
                     <div class="form-group">
                        <p>Processes for supporting people using services to take part in the 
                        </p>
                     </div>
                  </li>
                  <li>
                     <div class="form-group">
                        <p>Processes for referring people using services to other agencies where relevant to their needs/goals and aspirations</p>
                     </div>
                  </li>
               </ul>
            </div>
         </div>
      </div>
      <div class="row mt-40 border-top">
         <div class="col-sm-2">
            <div class="bg-height">
               <p>3.5</p>
            </div>
         </div>
         <div class="col-sm-2">
            <div class="bg-height">
               <p>The organisation has a range of strategies to ensure communication and decision-making by the individual is respected and reflected 
                  in goals set by the person using services and in plans to achieve service delivery outcomes.
               </p>
            </div>
         </div>
         <div class="col-sm-2">
            <div class="bg-height">
               <p>Developmental</p>
               <p>Evidence examples</p>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="bg-height">
               <p>Records show that feedback is sought from participants on the most appropriate ways to work together to identify strengths, needs and goals</p>
               <hr>
               <p>Participant files include evidence of participants being provided with their individual plan in a manner and format the person is most likely to understand</p>
               <hr>
               <p>Where an external party has been involved in planning, delivery of supports, and or review, there is documentary evidence of this involvement</p>
               <hr>
               <p>Processes & documentation for providing information in different ways to suit a range of communication needs </p>
            </div>
         </div>
      </div>
   </div>
   {{---------selfassessment workbook standered 3.4 and 3.5 end------------}}
   {{---------selfassessment workbook standered 4.1 start------------}}
   <div class="workbook-sheet">
      <div class="row backbg-book">
         <div class="col-sm-2">
            <div class="bg-height">
               <div class="heading-back-bg">
                  <h5>Reference</h5>
               </div>
            </div>
         </div>
         <div class="col-sm-2">
            <div class="bg-height">
               <div class="heading-back-bg">
                  <h5>Indicator details </h5>
               </div>
            </div>
         </div>
         <div class="col-sm-2">
            <div class="bg-height">
               <div class="heading-back-bg">
                  <h5>Core (C) or  Developmental (D)</h5>
               </div>
            </div>
         </div>
         <div class="col-sm-2">
            <div class="bg-height">
               <div class="heading-back-bg">
                  <h5>Requirements</h5>
                  <p>(Safeguard requirements to be addressed in the indicator)</p>
               </div>
            </div>
         </div>
         <div class="col-sm-2">
            <div class="bg-height">
               <div class="heading-back-bg">
                  <h5>Evidence available</h5>
                  <p> (Yes or No)</p>
               </div>
            </div>
         </div>
         <div class="col-sm-2">
            <div class="bg-height">
               <div class="heading-back-bg">
                  <h5>Provider evidence</h5>
                  <p>(What is, or is intended to be in place, to meet this indicator)</p>
               </div>
            </div>
         </div>
      </div>
      <div class="row under-title-bg">
         <div class="col-sm-2">
            <div class="bg-height">
               <div class="text-book">
                  <h5>Standard 4 </h5>
               </div>
            </div>
         </div>
         <div class="col-sm-10">
            <div class="bg-height">
               <div class="text-book">
                  <h5>Safety, wellbeing and rights</h5>
                  <hr>
               </div>
               <h5> Expected Outcomes:<span>The safety, wellbeing and human and legal rights of people using services are protected and </span></h5>
               <hr>
               <h5>Context:<span>The organisation upholds the legal and human rights of people using services. This includes people’s right to receive 
                  services that protect and promote their safety and wellbeing, participation and choice</span>
               </h5>
            </div>
         </div>
      </div>
      <div class="row mt-40">
         <div class="col-sm-2">
            <div class="bg-height">
               <div class="text-book">
               </div>
               <p>4.1</p>
               <p>4.1 count</p>
            </div>
         </div>
         <div class="col-sm-2">
            <div class="bg-height">
               <div class="text-book">
               </div>
               <p>The organisation provides services in a manner that upholds people’s human and legal rights.</p>
            </div>
         </div>
         <div class="col-sm-2">
            <div class="bg-height">
               <p>Core</p>
               <p>Evidence examples</p>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="bg-height">
               <div class="bg-height">
                  <p> Core guiding document that outlines how supports will be planned and delivered in a manner that supports the human and legal rights of people with disability.</p>
                  <hr>
                  <p>Policies and processes are in place for ensuring that supports are provided in the least restrictive way. </p>
                  <hr>
               </div>
               <div class="below-form work-sheet-list">
                  <p>Policy and operational procedures are in place to ensure legislative compliance (under the Disability Services Act 2006) for services provided for 
                     positive behaviour support and the delivery of 
                     services involving the use of restrictive practices, including: 
                  </p>
                  <ul>
                     <li>
                        <div class="form-group">
                           <p>a copy of the Model Statement is available on participant’s file 
                           </p>
                        </div>
                     </li>
                     <li>
                        <div class="form-group">
                           <p>conducting a multidisciplinary functional assessment and developing a positive behaviour support plan (PBSP) or a respite/ community 
                              access plan 
                           </p>
                        </div>
                     </li>
                     <li>
                        <div class="form-group">
                           <p>monthly reporting to the department of the use of restrictive practices in accordance<i> with the Disability Services Regulation 2017</i> </p>
                        </div>
                     </li>
                     <li>
                        <div class="form-group">
                           <p>obtaining relevant consents and approvals for the use of the restrictive practice as detailed in the PBSP (note -  the model PBSP will evidence these 
                              requirements such as dates of approval)
                           </p>
                        </div>
                     </li>
                     <li>
                        <div class="form-group">
                           <p>obtaining relevant consents and approvals for the use of the restrictive practice as detailed in the PBSP (note -  the model PBSP will evidence these 
                              requirements such as dates of approval)
                           </p>
                        </div>
                     </li>
                     <li>
                        <div class="form-group">
                           <p>using reports from the department’s Online Data Collection (ODC) system (e.g. Client Record of restrictive practices usage report) to monitor and review the 
                              implementation and outcomes of the 
                              PBSP with the view to improving quality of life and reducing use of restrictive practices
                           </p>
                        </div>
                     </li>
                     <li>
                        <div class="form-group">
                           <p>professional staff who conduct multidisciplinary functional assessments and develop PBSPs be appropriately qualified and experienced as per
                              the Act (relevant to NDIS Professional Registration Group Specialist Positive Behaviour Support).
                           </p>
                        </div>
                     </li>
                     <hr>
                     <li>
                        <div class="form-group">
                           <p>A Code of Conduct or Charter of Rights</p>
                        </div>
                     </li>
                     <li>
                        <div class="form-group">
                           <p>Policies & operational procedures for ensuring that services are provided in the least restrictive way possible & uphold the rights of people with </p>
                        </div>
                     </li>
                     <li>
                        <div class="form-group">
                           <p>Current Positive Behaviour Support plan with record of consents & approval including evidence of the Model Statement being provided </p>
                        </div>
                     </li>
                     <li>
                        <div class="form-group">
                           <p>Examples of appropriately skilled or qualified persons such as behaviour analysts, medical practitioners, psychologist, psychiatrists, speech & 
                              language pathologies, occupational therapists, registered nurses, social workers
                           </p>
                        </div>
                     </li>
                     <li>
                        <div class="form-group">
                           <p>Examples of appropriately skilled/qualified person has significant practice in conducting & implementing functional assessments & development of PBSPs to a high standard  
                           </p>
                        </div>
                     </li>
                     <li>
                        <div class="form-group">
                           <p>Pamphlets/welcome kits providing information to service users about their rights & responsibilities  
                           </p>
                        </div>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
   {{---------selfassessment workbook standered 4.1 end------------}}
   {{---------selfassessment workbook standered 4.2 start------------}}
   <div class="workbook-sheet">
      <div class="row backbg-book">
         <div class="col-sm-2">
            <div class="bg-height">
               <div class="heading-back-bg">
                  <h5>Reference</h5>
               </div>
            </div>
         </div>
         <div class="col-sm-2">
            <div class="bg-height">
               <div class="heading-back-bg">
                  <h5>Indicator details </h5>
               </div>
            </div>
         </div>
         <div class="col-sm-2">
            <div class="bg-height">
               <div class="heading-back-bg">
                  <h5>Core (C) or  Developmental (D)</h5>
               </div>
            </div>
         </div>
         <div class="col-sm-2">
            <div class="bg-height">
               <div class="heading-back-bg">
                  <h5>Requirements</h5>
                  <p>(Safeguard requirements to be addressed in the indicator)</p>
               </div>
            </div>
         </div>
         <div class="col-sm-2">
            <div class="bg-height">
               <div class="heading-back-bg">
                  <h5>Evidence available</h5>
                  <p> (Yes or No)</p>
               </div>
            </div>
         </div>
         <div class="col-sm-2">
            <div class="bg-height">
               <div class="heading-back-bg">
                  <h5>Provider evidence</h5>
                  <p>(What is, or is intended to be in place, to meet this indicator)</p>
               </div>
            </div>
         </div>
      </div>
      <div class="row mt-40">
         <div class="col-sm-2">
            <div class="bg-height">
               <p>4.2</p>
               <p>4.2 Count</p>
            </div>
         </div>
         <div class="col-sm-2">
            <div class="bg-height">
               <p>The organisation proactively prevents, identifies and responds to risks to the safety and wellbeing of people using services.</p>
            </div>
         </div>
         <div class="col-sm-2">
            <div class="bg-height">
               <p>Core</p>
               <p>Evidence examples</p>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="bg-height">
               <div class="bg-height">
                  <p> Policies and processes are in place for preventing, identifying and responding to risks to the safety (including the prevention of 
                     all forms of harm, abuse and neglect) and wellbeing of participants.
                  </p>
                  <hr>
                  <p>Processes are in place for ensuring accessible and safe environments with due regard to legislative requirements* as relevant to the 
                     types of supports to be provided. <i>*Relevant requirements may include, fire safety, pool safety, electrical safety, maintenance and management of
                     equipment 
                     and buildings, medication management, infection control </i>
                  </p>
                  <hr>
                  <p>Processes are in place for ensuring accessible and safe environments with due regard to legislative requirements* as relevant to the 
                     types of supports to be provided. 
                  </p>
                  <hr>
               </div>
               <div class="below-form work-sheet-list">
                  <p>Policy, procedures and/or processes for criminal history screening. </p>
                  <p>These include as relevant to the provider:  </p>
                  <p>(1) ensuring compliance with requirements of the Disability Services Act 2006 (i.e. yellow card system for working with adults with disability), 
                     including:    
                  </p>
                  <ul>
                     <li>
                        <div class="form-group">
                           <p>ensuring that all relevant persons engaged by the provider undergo criminal history screening 
                           </p>
                        </div>
                     </li>
                     <li>
                        <div class="form-group">
                           <p>managing and tracking the status of screening applications </p>
                        </div>
                     </li>
                     <li>
                        <div class="form-group">
                           <p>implementing a Risk Management Strategy which complies with legislative requirements. </p>
                        </div>
                     </li>
                     <li>
                        <div class="form-group">
                           <p>Incident management policy & procedures, registers and reports</p>
                        </div>
                     </li>
                     <li>
                        <div class="form-group">
                           <p>Processes & registers for ensuring that criminal history screening requirements for all persons working in or for the organisation including volunteers are monitored and met (e.g. Blue Card register/Yellow Card register)
                           </p>
                        </div>
                     </li>
                     <li>
                        <div class="form-group">
                           <p>Processes that minimise & promptly respond to challenging behaviours or threats against other people using the service or people working in the organisation
                           </p>
                        </div>
                     </li>
                     <li>
                        <div class="form-group">
                           <p>Policies/procedures/registers for ensuring that medication is managed safely & correctly (e.g. security, storage and disposal of medications, authorisation & administration of medications, processes for monitoring correctness of medications against medication records, monitoring and review of medication errors)
                           </p>
                        </div>
                     </li>
                     <li>
                        <div class="form-group">
                           <p>Records of preventative and corrective actions to protect the safety & wellbeing of people using services </p>
                        </div>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
   {{---------selfassessment workbook standered 4.2 end------------}}
   {{---------selfassessment workbook standered 4.3 start------------}}
   <div class="workbook-sheet">
      <div class="row backbg-book">
         <div class="col-sm-2">
            <div class="bg-height">
               <div class="heading-back-bg">
                  <h5>Reference</h5>
               </div>
            </div>
         </div>
         <div class="col-sm-2">
            <div class="bg-height">
               <div class="heading-back-bg">
                  <h5>Indicator details </h5>
               </div>
            </div>
         </div>
         <div class="col-sm-2">
            <div class="bg-height">
               <div class="heading-back-bg">
                  <h5>Core (C) or  Developmental (D)</h5>
               </div>
            </div>
         </div>
         <div class="col-sm-2">
            <div class="bg-height">
               <div class="heading-back-bg">
                  <h5>Requirements</h5>
                  <p>(Safeguard requirements to be addressed in the indicator)</p>
               </div>
            </div>
         </div>
         <div class="col-sm-2">
            <div class="bg-height">
               <div class="heading-back-bg">
                  <h5>Evidence available</h5>
                  <p> (Yes or No)</p>
               </div>
            </div>
         </div>
         <div class="col-sm-2">
            <div class="bg-height">
               <div class="heading-back-bg">
                  <h5>Provider evidence</h5>
                  <p>(What is, or is intended to be in place, to meet this indicator)</p>
               </div>
            </div>
         </div>
      </div>
      <div class="row mt-40">
         <div class="col-sm-2">
            <div class="bg-height">
               <p>4.3</p>
               <p>4.3 Count</p>
            </div>
         </div>
         <div class="col-sm-2">
            <div class="bg-height">
               <p>The organisation has processes for reporting and responding to potential or actual harm, abuse and/or neglect that may occur for people using services.</p>
            </div>
         </div>
         <div class="col-sm-2">
            <div class="bg-height">
               <p>Core</p>
               <p>Evidence examples</p>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="bg-height">
               <div class="bg-height">
                  <div class="below-form work-sheet-list">
                     <p>Policies and processes consistent with the DCCSDS policy for Preventing and Responding to the Abuse, Neglect and Exploitation of People with a 
                        Disability are in place, including:
                     </p>
                     <ul>
                        <li>
                           <div class="form-group">
                              <p>promoting a culture of no retribution 
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>ensuring there are systems to identify and respond to abuse, neglect or exploitation </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>ensuring timely, adequate and appropriate responses to incidents.  </p>
                           </div>
                        </li>
                        <hr>
                        <p>Policies and processes are in place for reporting and responding to incidents and adverse events including potential,
                           suspected, alleged or actual harm, abuse and/or neglect of participants. 
                        </p>
                        <li>
                           <div class="form-group">
                              <p>what constitutes, harm, abuse, neglect and exploitation; and how to respond in a manner that is consistent with any legislative requirements 
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>how to record and report allegations or incidents, including reporting of harm through internal processes and to any 
                                 external agencies (e.g. QPS, Child Safety), as appropriate
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>their responsibilities to support people, or make referrals to appropriate supports</p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>the importance of responding to allegations of harm in a manner that observes the principles of natural justice, and for 
                                 all parties to be supported during the investigation of an allegation of harm.
                              </p>
                           </div>
                        </li>
                        <p> <i>Note:  Providers should respond as relevant to their size and structure.   </i></p>
                        <hr>
                        <li>
                           <div class="form-group">
                              <p>Incident management policy & procedures, registers and reports
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Records of correspondence with guardians/custodians regarding 
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Records demonstrating the organisation’s response to incidents involving the use of restrictive or prohibited practices
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Records of reporting to external agencies where harm has been identified or suspected (e.g. the Queensland Police Service)
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Action plans which outline strategies to prevent future risk
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Records of staff training on: what constitutes harm, abuse, neglect & exploitation; how to respond to actual or suspected instances;
                                 & how to respond to, record & report allegations 
                              </p>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
      {{---------selfassessment workbook standered 4.3 end------------}}
      {{---------selfassessment workbook standered 4.4 or 4.5 start------------}}
      {{---------selfassessment workbook standered4.4 or 4.5 start------------}}
      <div class="workbook-sheet">
         <div class="row backbg-book">
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Reference</h5>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Indicator details </h5>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Core (C) or  Developmental (D)</h5>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Requirements</h5>
                     <p>(Safeguard requirements to be addressed in the indicator)</p>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Evidence available</h5>
                     <p> (Yes or No)</p>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Provider evidence</h5>
                     <p>(What is, or is intended to be in place, to meet this indicator)</p>
                  </div>
               </div>
            </div>
         </div>
         <div class="row mt-40">
            <div class="col-sm-2">
               <div class="bg-height">
                  <p>4.4</p>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <p>People using services are enabled to access appropriate supports and advocacy.</p>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <p>Developmental</p>
                  <p>Evidence examples</p>
               </div>
            </div>
            <div class="col-sm-6">
               <div class="bg-height">
                  <p>Participants are provided with information on independent advocacy services and are supported to access an advocate to promote their rights, 
                     interests and wellbeing  
                  </p>
               </div>
               <div class="below-form work-sheet-list">
                  <ul>
                     <li>
                        <div class="form-group">
                           <p>Welcome kits including details of relevant advocacy & support services 
                           </p>
                        </div>
                     </li>
                     <li>
                        <div class="form-group">
                           <p>Contact details for support/advocacy bodies are displayed in areas that are frequently accessed by people using services</p>
                        </div>
                     </li>
                     <li>
                        <div class="form-group">
                           <p>Case records demonstrate how the provider has supported people using services to access independent advocacy and support services 
                              (e.g. Community Visitors
                           </p>
                        </div>
                     </li>
                     <li>
                        <div class="form-group">
                           <p>Policies outlining the requirement for people using services to be provided with relevant information & contact details</p>
                        </div>
                     </li>
                     <li>
                        <div class="form-group">
                           <p>Where applicable, processes to link people using services with Aboriginal and Torres Strait Islander services, ethno-specific or multi-cultural services 
                              (including language or specialist services) in order to support 
                              people exercise their legal and human rights
                           </p>
                        </div>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
         <div class="row mt-40 border-top">
            <div class="col-sm-2">
               <div class="bg-height">
                  <p>4.5</p>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <p>Processes are in place for ensuring that information is provided in appropriate formats (based on the individual’s preferences for the communication method) to enable people
                     to participate and make choices about the supports and services they receive.
                  </p>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <p>Developmental</p>
                  <p>Evidence examples</p>
               </div>
            </div>
            <div class="col-sm-6">
               <div class="bg-height">
                  <div class="below-form work-sheet-list">
                     <p>Processes are in place for ensuring that information is provided in appropriate formats (based on the individual’s preferences for the communication method) 
                        to enable people to participate and make choices about the supports and services they receive.
                     </p>
                     <ul>
                        <li>
                           <div class="form-group">
                              <p>Welcome/ induction packs contain information regarding service user’s rights to participate & make choices about services</p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Documented strategies for identifying & addressing barriers to service user participation are available</p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>There are processes for supporting flexibility in service delivery options which reflect the changing needs, aspiration & choices of people using services</p>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
      {{-----Self-assessment workbook standerd3 end--------}}
      {{---------selfassessment workbook standered 5.1 start------------}}
      <div class="workbook-sheet">
         <div class="row backbg-book">
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Reference</h5>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Indicator details </h5>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Core (C) or  Developmental (D)</h5>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Requirements</h5>
                     <p>(Safeguard requirements to be addressed in the indicator)</p>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Evidence available</h5>
                     <p> (Yes or No)</p>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Provider evidence</h5>
                     <p>(What is, or is intended to be in place, to meet this indicator)</p>
                  </div>
               </div>
            </div>
         </div>
         <div class="row under-title-bg">
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="text-book">
                     <h5>Standard 5 </h5>
                  </div>
               </div>
            </div>
            <div class="col-sm-10">
               <div class="bg-height">
                  <div class="text-book">
                     <h5>Feedback, complaints and appeals</h5>
                     <hr>
                  </div>
                  <h5> Expected Outcomes:<span> Effective feedback, complaints and appeals processes that lead to improvements in service </span></h5>
                  <hr>
                  <h5>Context:<span>The organisation listens to people and takes on feedback as a source of ideas for improving services and other activities. 
                     It includes the way the organisation responds to complaints from people using 
                     services and their right to have complaints fairly assessed and acted </span>
                  </h5>
               </div>
            </div>
         </div>
         <div class="row mt-40">
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="text-book">
                  </div>
                  <p>5.1</p>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="text-book">
                  </div>
                  <p>The organisation has fair, accessible and accountable feedback, complaints and appeals processes.</p>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <p>Core</p>
                  <p>Evidence examples</p>
               </div>
            </div>
            <div class="col-sm-6">
               <div class="bg-height">
                  <div class="bg-height">
                     <p> The provider has a complaints management framework that is aligned with Australian/New Zealand <i>
                        Standard Guidelines for Complaint Management in Organizations (AS/NZS 10002:2014).</i> 
                     </p>
                  </div>
                  <div class="below-form work-sheet-list">
                     <ul>
                        <li>
                           <div class="form-group">
                              <p>Processes for managing, resolving complaints & tracking complaints are developed that include all of the following:
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>A definition or explanation of what constitutes a complaint </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>How the complaint can be made, including formal and informal avenues for making complaints, including anonymously
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Timeframes & steps for responding to a complaint</p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p> Avenues for escalating a complaint</p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>	How complaints are recorded</p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>A method for tracking complaints</p>
                           </div>
                        </li>
                        <hr>
                        <li>
                           <div class="form-group">
                              <p>How the organisation will respect people’s right to privacy & confidentiality in managing complaints</p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>How the stakeholders will be advised of the outcome of the complaint </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>How feedback, complaints & appeals are reported to the governance body or to the delegated authority </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>How complaints are submitted to funding bodies where required</p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>	Mechanisms to ensure complaints are responded to & dealt with in a timely manner
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Review processes to identify & address any systematic barriers to complaints, appeals & feedback mechanisms
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Processes are in place to ensure that people are not disadvantaged as a result of making complaints 
                              </p>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
      {{---------selfassessment workbook standered 5.1 end------------}}
      {{---------selfassessment workbook standered 5.2 or 5.3 start------------}}
      <div class="workbook-sheet">
         <div class="row backbg-book">
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Reference</h5>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Indicator details </h5>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Core (C) or  Developmental (D)</h5>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Requirements</h5>
                     <p>(Safeguard requirements to be addressed in the indicator)</p>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Evidence available</h5>
                     <p> (Yes or No)</p>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Provider evidence</h5>
                     <p>(What is, or is intended to be in place, to meet this indicator)</p>
                  </div>
               </div>
            </div>
         </div>
         <div class="row mt-40">
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="text-book">
                  </div>
                  <p>5.2</p>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <p>The organisation effectively communicates feedback, complaints and appeals processes to people using services and other relevant stakeholders.</p>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <p>Developmental</p>
                  <p>Evidence examples</p>
               </div>
            </div>
            <div class="col-sm-6">
               <div class="bg-height">
                  <p>There are records demonstrating that the provider communicates the results of feedback (including complaints) to participants 
                     and/or significant others
                  </p>
                  <hr>
                  <p> Participants and/or nominated representatives are involved in the review of feedback.</p>
               </div>
            </div>
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
               <div class="bg-height">
                  <div class="below-form work-sheet-list">
                     <ul>
                        <li>
                           <div class="form-group">
                              <p>Processes are in place that maximise access to information about complaints, disputes & feedback processes for all 
                                 people accessing services including those from diverse stakeholder groups (culture, age etc.) 
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Welcome kit/induction pack information informing people using services of the organisation’s complaint mechanisms & 
                                 feedback processes
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Complaints information is made available in areas that are frequently accessed by people using services</p>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         <div class="row mt-40 border-top">
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="text-book">
                  </div>
                  <p>5.3</p>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="text-book">
                  </div>
                  <p>People using services and other relevant stakeholders are informed of and enabled to access any external avenues or appropriate supports for 
                     feedback, complaints or appeals processes and assisted to understand how they access them.
                  </p>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <p>Developmental</p>
                  <p>Evidence examples</p>
               </div>
            </div>
            <div class="col-sm-6">
               <div class="bg-height">
                  <p>Policy/procedures or process for ensuring that participants are made aware of their right to access an external 
                     complaints agency and independent advocacy/support agency as appropriate, and are informed how to do so 
                  </p>
                  <hr>
                  <p>Policy/procedure or process for ensuring that participants are appropriately supported to: provide feedback; make a complaint; 
                     or appeal to external avenues should they choose to do so
                  </p>
               </div>
            </div>
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
               <div class="bg-height">
                  <div class="below-form work-sheet-list">
                     <p>Processes are in place for:</p>
                     <ul>
                        <li>
                           <div class="form-group">
                              <p>Assessing &amp; recording individual/s’ needs, strengths, goals and 
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Including &amp; ensuring the active involvement of the individual/s in </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Promoting a belief in the ability of people with disability to fulfil valued roles in the community
                                 (e.g. through promoting skills development and lifelong learning)
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Informing people using services about changes to service provision</p>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         <div class="row mt-40 border-top">
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="text-book">
                  </div>
                  <p>5.3 Count</p>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <span>&nbsp;</span>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <p>Evidence examples</p>
               </div>
            </div>
            <div class="col-sm-6">
               <div class="bg-height">
                  <div class="below-form work-sheet-list">
                     <ul>
                        <li>
                           <div class="form-group">
                              <p>Policy and/or procedure that describes how people will be supported to provide feedback,
                                 make a complaint, or appeal to an external body 
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Welcome kit and or induction pack containing contact information to relevant external feedback, complaint, & appeal bodies </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Procedure for engaging an independent mediator where complaints & appeals remain unresolved</p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Process for ensuring external feedback, complaints & appeals mechanisms are made available in areas that are frequently accessed by people who access the service & significant others.
                              </p>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
      {{---------selfassessment workbook standered 5.2 or 5.3 end------------}}
      {{---------selfassessment workbook standered 5.4 start------------}}
      <div class="workbook-sheet">
         <div class="row backbg-book">
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Reference</h5>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Indicator details </h5>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Core (C) or  Developmental (D)</h5>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Requirements</h5>
                     <p>(Safeguard requirements to be addressed in the indicator)</p>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Evidence available</h5>
                     <p> (Yes or No)</p>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Provider evidence</h5>
                     <p>(What is, or is intended to be in place, to meet this indicator)</p>
                  </div>
               </div>
            </div>
         </div>
         <div class="row mt-40">
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="text-book">
                  </div>
                  <p>5.4</p>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <p>The organisation demonstrates that feedback, complaints and appeals processes lead to improvements within the service and that outcomes
                     are communicated to relevant stakeholders.
                  </p>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <p>Core</p>
                  <p>Developmental</p>
                  <p>Evidence examples</p>
               </div>
            </div>
            <div class="col-sm-6">
               <div class="bg-height">
                  <p>There is a welcome/Induction pack for participants that includes information about how the provider will use feedback and complaints information. </p>
                  <hr>
                  <p> There is a Complaints Register that includes actions recommended and documents times taken to complete the complaints process</p>
               </div>
            </div>
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
               <div class="bg-height">
                  <div class="below-form work-sheet-list">
                     <p>There is:</p>
                     <ul>
                        <li>
                           <div class="form-group">
                              <p>A policy & or procedure that addresses how feedback, complaints and appeals will inform service delivery and planning 
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>A Quality Improvement Plan and associated action plans</p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Systems for managing feedback, complaints and appeals</p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Meeting agenda templates with relevant standing agenda items regarding feedback, complaints, appeals & continuous quality improvement</p>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
      {{---------selfassessment workbook standered 5.4 end------------}}
      {{---------selfassessment workbook standered 6 start-----------}}
      <div class="workbook-sheet">
         <div class="row backbg-book">
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Reference</h5>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Indicator details </h5>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Core (C) or  Developmental (D)</h5>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Requirements</h5>
                     <p>(Safeguard requirements to be addressed in the indicator)</p>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Evidence available</h5>
                     <p> (Yes or No)</p>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Provider evidence</h5>
                     <p>(What is, or is intended to be in place, to meet this indicator)</p>
                  </div>
               </div>
            </div>
         </div>
         <div class="row under-title-bg">
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="text-book">
                     <h5>Standard 6 </h5>
                  </div>
               </div>
            </div>
            <div class="col-sm-10">
               <div class="bg-height">
                  <div class="text-book">
                     <h5>Human resources</h5>
                     <hr>
                  </div>
                  <h5> Expected Outcomes:<span>Effective human resource management systems, including recruitment, induction </span></h5>
                  <hr>
                  <h5>Context:<span> The organisation has human resource management systems that ensure people working in services (including volunteers) are
                     recruited appropriately and are suitable 
                     for their roles within the organisation. Once appointed, people working in the organisation have access to support, supervision </span>
                  </h5>
               </div>
            </div>
         </div>
         <div class="row mt-40">
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="text-book">
                  </div>
                  <p>6.1</p>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="text-book">
                  </div>
                  <p>The organisation has human resource management systems that are consistent with regulatory requirements, 
                     industrial relations legislation, work health and safety legislation and relevant agreements or awards.
                  </p>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <p>Core</p>
                  <p>Evidence examples</p>
               </div>
            </div>
            <div class="col-sm-6">
               <div class="bg-height">
                  <div class="bg-height">
                     <p> Management processes (proportionate to the size of the provider and types of supports provided) are in 
                        place – these include, but are not limited to: 
                     </p>
                  </div>
                  <div class="below-form work-sheet-list">
                     <ul>
                        <li>
                           <div class="form-group">
                              <p>Workforce planning
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Learning and development </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Code of conduct
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Emergency procedures</p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p> Performance planning and management</p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Recruitment, selection and retention processes </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Position descriptions </p>
                           </div>
                        </li>
                        <hr>
                        <li>
                           <div class="form-group">
                              <p>Grievance procedures</p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Use of phones & information technology </p>
                           </div>
                        </li>
                        <p><i>Note: Providers should respond as relevant to their size and structure. </i></p>
                        <hr>
                        <li>
                           <div class="form-group">
                              <p>Policies & procedures for Human Resource Management are in place including: non-discriminatory human 
                                 resource practices; application of equal employment opportunity principles; elimination of bullying & harassment; consistent application of awards,
                                 collective agreements or contracts; safe work practices; safe work environment
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Evidence of health & safety training relevant to a </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Meeting/training records regarding safe work practices & safe work environment (e.g. records of safety and 
                                 quality committee meeting agenda and 
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Policy/procedures for ensuing staff safety (e.g. when working with people with challenging behaviours)   </p>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
      {{---------selfassessment workbook standered 6 end-----------}}
      {{---------selfassessment workbook standered 6.2 start-----------}}
      <div class="workbook-sheet">
         <div class="row backbg-book">
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Reference</h5>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Indicator details </h5>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Core (C) or  Developmental (D)</h5>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Requirements</h5>
                     <p>(Safeguard requirements to be addressed in the indicator)</p>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Evidence available</h5>
                     <p> (Yes or No)</p>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Provider evidence</h5>
                     <p>(What is, or is intended to be in place, to meet this indicator)</p>
                  </div>
               </div>
            </div>
         </div>
         <div class="row mt-40">
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="text-book">
                  </div>
                  <p>6.2</p>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="text-book">
                  </div>
                  <p>The organisation has transparent and accountable recruitment and selection processes that ensure people working in the organisation
                     possess knowledge, skills and experience required to fulfil their roles.
                  </p>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <p>Developmental</p>
                  <p>Evidence examples</p>
               </div>
            </div>
            <div class="col-sm-6">
               <div class="bg-height">
                  <div class="bg-height">
                     <p> Written policies and procedures guide recruitment and selection, induction and ethical conduct for all staff, management, governing bodies 
                        and volunteers, including position descriptions that outline required skills and knowledge
                        (e.g. up to date records of qualifications and legal requirements, such as police clearances and mandatory criminal history screening) 
                     </p>
                     <p><i>Note: Providers should respond as relevant to their size and structure. d</i></p>
                  </div>
                  <div class="below-form work-sheet-list">
                     <p>Examples of evidence:</p>
                     <ul>
                        <li>
                           <div class="form-group">
                              <p>Policy & procedures for workforce planning, recruitment 
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Duty statements or position descriptions for all </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Records of the advertising/promotion of available 
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Evidence that staff qualifications have been checked & are current & that they have the skills & experience necessary to fulfil their role</p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Professional registration &/or other credentialing requirements for specialist roles are outlined within position descriptions & a process is in place </p>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
      {{---------selfassessment workbook standered 6.2 end-----------}}
      {{---------selfassessment workbook standered 6.3 start-----------}}
      <div class="workbook-sheet">
         <div class="row backbg-book">
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Reference</h5>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Indicator details </h5>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Core (C) or  Developmental (D)</h5>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Requirements</h5>
                     <p>(Safeguard requirements to be addressed in the indicator)</p>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Evidence available</h5>
                     <p> (Yes or No)</p>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Provider evidence</h5>
                     <p>(What is, or is intended to be in place, to meet this indicator)</p>
                  </div>
               </div>
            </div>
         </div>
         <div class="row mt-40">
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="text-book">
                  </div>
                  <p>6.3</p>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="text-book">
                  </div>
                  <p>The organisation provides people working in the organisation with induction, training and development opportunities relevant to their roles.</p>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <p>Developmental</p>
                  <p>Evidence examples</p>
               </div>
            </div>
            <div class="col-sm-6">
               <div class="bg-height">
                  <div class="bg-height">
                     <p>Policy and process for ensuring compliance with the DCCSDS policy on Preventing and 
                        Responding to the Abuse, Neglect and Exploitation of People with Disability, including ensuring that staff/volunteers:
                     </p>
                  </div>
                  <div class="below-form work-sheet-list">
                     <ul>
                        <li>
                           <div class="form-group">
                              <p>are aware of, trained in, policies on preventing and responding to the abuse, neglect and exploitation  
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>are trained to recognise and prevent/minimise the occurrence or recurrence of abuse, neglect and exploitation  </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>are trained in early intervention approaches where potential or actual abuse, neglect or exploitation of people using services is identified. 
                              </p>
                           </div>
                        </li>
                        <div class="form-group">
                           <p><i>Note: Providers should respond as relevant to their size and structure </i></p>
                           <hr>
                        </div>
                        <li>
                           <div class="form-group">
                              <p>Policies or procedures addressing induction, training and development of people working in or for the organisation</p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Records of induction processes showing that the organisation has addressed all mandatory requirements & the knowledge
                                 necessary to fulfil a role within the organisation
                              </p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Written strategies/policies that support & promote the retention of staff and/or volunteers</p>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
      {{---------selfassessment workbook standered 6.3 end-----------}}
      {{---------selfassessment workbook standered 6.4 or 5 start-----------}}
      <div class="workbook-sheet">
         <div class="row backbg-book">
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Reference</h5>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Indicator details </h5>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Core (C) or  Developmental (D)</h5>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Requirements</h5>
                     <p>(Safeguard requirements to be addressed in the indicator)</p>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Evidence available</h5>
                     <p> (Yes or No)</p>
                  </div>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <div class="heading-back-bg">
                     <h5>Provider evidence</h5>
                     <p>(What is, or is intended to be in place, to meet this indicator)</p>
                  </div>
               </div>
            </div>
         </div>
         <div class="row mt-40">
            <div class="col-sm-2">
               <div class="bg-height">
                  <p>6.4</p>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <p>The organisation provides ongoing support, supervision, feedback and fair disciplinary processes for people working in the organisation.</p>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <p>Developmental</p>
                  <p>Evidence examples</p>
               </div>
            </div>
            <div class="col-sm-6">
               <div class="bg-height">
                  <p>Policy and associated procedures and processes for the provision of supervision, reflective practice, or similar feedback process.</p>
                  <p><i>Note: Providers should respond as relevant to their size and structure..</i></p>
                  <hr>
               </div>
               <div class="below-form work-sheet-list">
                  <ul>
                     <li>
                        <div class="form-group">
                           <p>Policy &/or procedures outlining the organisation’s approach to supporting staff/volunteers, providing supervision,
                              feedback & commitment to fair disciplinary processes. 
                           </p>
                        </div>
                     </li>
                     <li>
                        <div class="form-group">
                           <p>Records of performance management processes</p>
                        </div>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
         <div class="row mt-40 border-top">
            <div class="col-sm-2">
               <div class="bg-height">
                  <p>6.5</p>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <p>The organisation ensures that people working in the organisation have access to fair and effective systems for dealing with grievances and disputes.</p>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="bg-height">
                  <p>Developmental</p>
                  <p>Evidence examples</p>
               </div>
            </div>
            <div class="col-sm-6">
               <div class="bg-height">
                  <div class="below-form work-sheet-list">
                     <p>Policy, procedure and process which addresses the management of grievances and disputes raised by people working in and for the organisation.</p>
                     <p><i>Note: Providers should respond as relevant to their size and structure..</i></p>
                     <hr>
                     <ul>
                        <li>
                           <div class="form-group">
                              <p>Policies or procedures which outline how the organisation manages staff/volunteer grievances & disputes</p>
                           </div>
                        </li>
                        <li>
                           <div class="form-group">
                              <p>Staff induction kit containing information regarding the organisation’s dispute resolution procedure & how staff can raise grievances</p>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
      {{---------selfassessment workbook standered 6.4 or 5 end-----------}}
   </div>
   {{-----Self-assessment workbook start--------}}
</div>
</div>
@endsection
@section('scripts')
@parent
<script>
   jQuery(document).ready(function(){ 
      
   });
</script>
@endsection