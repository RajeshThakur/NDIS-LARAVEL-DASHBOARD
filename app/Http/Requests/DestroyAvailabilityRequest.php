<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DestroyAvailabilityRequest extends FormRequest
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
            'user_id' => 'required|integer',
            'availability_id' => 'required|integer',
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
            'user_id.required' => 'Somethign went wrong!',
            'availability_id.required' => 'Your request could not be completed!',
        ];

    }
}
