<?php

namespace App\Http\Requests;

use App\RegistrationGroup;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRegistrationGroupRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('registration_group_edit');
    }

    public function rules()
    {
        return [
            'title'  => [
                'required',
            ],
            'item_number'  => [
                'required',
            ],
            'price_limit'  => [
                'required',
            ],
            'parent_id'  => [
                'required',
            ],
            'status' => [
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
            'title.required' => trans('errors.registration_group_edit.title'),
            'item_number.required' => trans('errors.registration_group_edit.item_number'),
            'price_limit.required' => trans('errors.registration_group_edit.price_limit'),
            'parent_id.required' => trans('errors.registration_group_edit.parent_id'),
            'status.required' => trans('errors.registration_group_edit.status'),
        ];
    }
    
    
}
