<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserPassword extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => [ 'required','confirmed','min:6' ],
            'password_confirmation' => [ 'required' ],
            'token' => [ 'required'],
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
            'password.required' => trans('errors.pass'),
            'password.confirmed' => trans('errors.pass_mismatch'),
            'password_confirmation.required' => trans('errors.pass_confirm'),
            'token.required' => trans('errors.pass_token')
        ];
    }


}
