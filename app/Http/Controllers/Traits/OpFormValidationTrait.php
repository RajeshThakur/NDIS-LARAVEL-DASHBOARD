<?php
/**
 * Operational Forms Validations
 */
namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\ParticipantRegGroups;
use App\SupportWorker;
use App\ServiceProvider;
use Illuminate\Support\Facades\Validator;

trait OpFormValidationTrait
{

    protected function validateForm(Request $request, $template_id){
        
        //Perform validation
        switch( intval($template_id) ){
            case 1:
                $request->request->add(['email'=>$request->meta['advocate_email']]);
                $validator = $this->validateAdvocate($request);
            break;
            case 2:
                $validator = $this->validateCarePlan($request);                
            break;
            case 3:
                $validator = $this->defaultValidator($request);
            break;
            case 4:
                $validator = $this->defaultValidator($request);
            break;
            case 5:
                $validator = $this->defaultValidator($request);
            break;
            case 6:
                $validator = $this->defaultValidator($request);
            break;
            case 7:
                $validator = $this->defaultValidator($request);
            break;
            case 8:
                $validator = $this->defaultValidator($request);
            break;
            case 9:
                $validator = $this->defaultValidator($request);
            break;
            case 10:
                $validator = $this->validateRiskAssessment($request);
            break;
            case 11:
                $validator = $this->validateNdisAgreement($request);
            break;
            case 12:
                $validator = $this->defaultValidator($request);
            break;
            case 13:
                $validator = $this->validateNdisAgreement($request);
            break;
        }

        return $validator;

    }

    /**
     * operation form default validation
     */
    protected function defaultValidator($request)
    {
        return Validator::make($request->all(),[
            'user_id' => 'required',
        ], 
        [
            'user_id.required' => 'User id is required',         
        ])->validate();
    }

    /**
     * operation form validation rule ( AUTHORITY TO ACT AS AN ADVOCATE )
     * @template_id 1
     */
    protected function validateAdvocate($request)
    {
        return Validator::make($request->all(),[
            'participant_first_name' => 'required',
            'email' => 'required|email|unique:users|unique:participants_guardian',
            'meta.advocate_address' => 'required',
            'meta.advocate_lat' => 'nullable|required',
        ], 
        [
            'participant_first_name.required' => trans('errors.opform.participant_name'),
            'email.required' => trans('errors.opform.guardian.email_required'),
            'email.unique' => trans('errors.opform.guardian.email_exists'),
            'meta.advocate_address.required' =>  trans('errors.opform.advocate_address'),
            'meta.advocate_lat.required' =>  trans('errors.invalid_address')
        ])->validate();
    }
    
    
    /**
     * operation form validation rule
     * @template_id 2
     */
    protected function validateCarePlan($request)
    {
        $messages = [
            'meta.client_date_of_birth.required' => trans('errors.opform.dob'),
            'meta.client_date_of_birth.date_format' => trans('errors.opform.dob_invalid'),
        ];

        return Validator::make($request->all(),[
            'meta.client_date_of_birth' => 'required',
            'meta.client_date_of_birth' => 'date_format:' . config('panel.date_input_format'),
        ], $messages)->validate();
    }




    /**
     * operation form validation rule
     * @template_id 10
     */
    protected function validateRiskAssessment($request)
    {
        $messages = [
            'meta.background_info.required' => trans('errors.opform.risk_assessment.bg_info'),
            'meta.risk_assessment_date.required' => trans('errors.opform.risk_assessment.date_required'),
            'meta.person_name_conducting_assessment.required' => trans('errors.opform.risk_assessment.name_conducting'),
        ];


        return Validator::make($request->all(),[
            'meta.background_info' => 'required',
            'meta.risk_assessment_date' => 'required',
            'meta.person_name_conducting_assessment' => 'required',
        ], $messages)->validate();
    }


    /**
     * operation form validation rule
     * @template_id 11
     */
    protected function validateNdisAgreement($request)
    {
        $messages = [
            'registeration_group.required' => 'Registration group selection required.',
        ];


        return Validator::make($request->all(),[
            'registeration_group' => 'required|array'
        ], $messages)->validate();
    }

    

}