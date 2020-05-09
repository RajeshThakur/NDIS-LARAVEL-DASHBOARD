<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;


class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('user_edit');
    }

    public function rules()
    {
        return [
            'first_name'  => 'required',
            'last_name'   => 'required',
            'email'       => 'required',
            //'business_name'       => 'required',
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
