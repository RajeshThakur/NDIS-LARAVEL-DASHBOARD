<?php

namespace App\Http\Requests;

use App\Role;
use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('role_create');
    }

    public function rules()
    {
        return [
            'title'         => [
                'required',
            ],
            'permissions' => [
                //  'integer', 
                  'required',
            ],
            
            // 'permissions'   => [
            //     'required',
            //     'array',
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
            'title.required' => trans('errors.role.title'),
            'permissions.required' => trans('errors.role.permissions'),
            
        ];
    }
    
    
}
