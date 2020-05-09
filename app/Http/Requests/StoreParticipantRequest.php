<?php

namespace App\Http\Requests;

use App\Participant;
use Illuminate\Foundation\Http\FormRequest;

class StoreParticipantRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('participant_create');
    }

    public function rules()
    {
        return [
            'first_name'      => [
                'required',
            ],
            'last_name'       => [
                'required',
            ],
            'email'           => [
                'required',
                'unique:users,email',
            ],
            'address'         => [
                'required',
            ],
            'lat'         => [
                'required',
            ],
            'start_date_ndis' => [
                'required',
                'date_format:'.config('panel.date_input_format'),
            ],
            'end_date_ndis'   => [
                'required',
                'date_format:'.config('panel.date_input_format'),
            ],
            'ndis_number'     => [
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
            'first_name.required' => trans('errors.participants.first_name'),
            'last_name.required' => trans('errors.participants.last_name'),
            'email.required' => trans('errors.participants.email'),
            'address.required' => trans('errors.participants.address'),
            'lat.required' => trans('errors.invalid_address'),
            'start_date_ndis.required' => trans('errors.participants.start_date_ndis'),
            'start_date_ndis.date_format' => trans('errors.participants.start_date_ndis_format', ['format'=>config('panel.date_input_format')]),
            'end_date_ndis.required' => trans('errors.participants.end_date_ndis'),
            'end_date_ndis.date_format' => trans('errors.participants.end_date_ndis_format', ['format'=>config('panel.date_input_format')]),
            'ndis_number.required' => trans('errors.participants.ndis_number'),
        ];
    }
}
