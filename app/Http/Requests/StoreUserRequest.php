<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('user_create');
    }

    public function rules()
    {
        return [
            'name'     => [
                'required',
            ],
            'email'    => [
                'unique:users,email',
                'required'
            ],
            'password' => [
                'required',
            ],
            // 'business_name' => [
            //     'required',
            // ],
            // 'roles.*'  => [
            //     'integer',
            // ],
            'roles'    => [
                'required',
                'array',
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
            'name.required' => trans('errors.user.name'),
            'email.required' => trans('errors.user.email'),
            // 'email.unique:users,email' => trans('errors.user.email'),
            'password.required' => trans('errors.user.password'),
            //'business_name.required' => trans('errors.user.business'),
            'roles.required' => trans('errors.user.roles'),
            
        ];
    }
    
    
}
