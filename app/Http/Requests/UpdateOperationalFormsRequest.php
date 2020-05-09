<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOperationalFormsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Gate::allows('participant_edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'meta.participant_address'         => [
            //     'required',
            // ],
            // 'meta.participant_lat'         => [
            //     'required',
            // ],
            // 'meta.participant_lng'         => [
            //     'required',
            // ],
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
            'merta.participant_address.required' => "Address is required",
            'meta.participant_lat.required' => trans('errors.invalid_address'),
        ];
    }
}
