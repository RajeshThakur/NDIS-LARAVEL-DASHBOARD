<?php

namespace App\Http\Requests;

use App\SupportWorker;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSupportWorkerRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('support_worker_edit');
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
            ],
            'mobile'           => [
                'required',
            ],
            'address'         => [
                'required',
            ],
            'lat'         => [
                'required',
            ],
            'registration_groups_id' => [
                'required', 'array'
            ]
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
            'first_name.required' => trans('errors.support_worker.first_name'),
            'last_name.required' => trans('errors.support_worker.last_name'),
            'email.required' => trans('errors.support_worker.email'),
            'mobile.required' => trans('errors.support_worker.email'),
            'address.required' => trans('errors.support_worker.address'),
            'lat.required' => trans('errors.invalid_address'),
            'registration_groups.required' => trans('errors.support_worker.registration_groups')
        ];
    }
    
    
}
