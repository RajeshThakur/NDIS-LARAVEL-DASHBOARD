<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return  \Gate::allows('message_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subject'      => [
                'required',
            ],
            'message' => [
                'required',
            ],            
            'recipients'  => [
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
            'subject.required' => 'Subject cannot be empty !',
            'message.required' => 'Message cannot be empty !',
            'recipients.required' => 'Recipient cannot be empty !',
            
        ];
    }

    
}
