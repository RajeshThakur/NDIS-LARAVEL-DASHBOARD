<?php

namespace App\Http\Requests;

use App\ParticipantFund;
use Illuminate\Foundation\Http\FormRequest;

class UpdateParticipantFundRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('participant_fund_edit');
    }

    public function rules()
    {
        return [
            'participant_id'        => [
                'required',
                'integer',
            ],
            'registration_group_id' => [
                'required',
                'integer',
            ],
            'funds'                 => [
                'required',
            ],
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
        ];
    }
    
    
}
