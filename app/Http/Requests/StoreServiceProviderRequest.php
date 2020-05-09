<?php

namespace App\Http\Requests;

use App\ServiceProvider;
use Illuminate\Foundation\Http\FormRequest;

class StoreServiceProviderRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('external_service_provider_create');
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
                'required','unique:users',
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
            // 'lng'         => [
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
            'first_name.required' => trans('errors.external_service_provider_edit.first_name'),
            'last_name.required' => trans('errors.external_service_provider_edit.last_name'),
            'email.required' => trans('errors.external_service_provider_edit.email'),
            'mobile.required' => trans('errors.external_service_provider_edit.mobile'),
            'address.required' => trans('errors.external_service_provider_edit.address'),
            'lat.required' => trans('errors.external_service_provider_edit.lat'),
            // 'lng.required' => trans('errors.external_service_provider_edit.address'),
        ];
    }
    
    
}
