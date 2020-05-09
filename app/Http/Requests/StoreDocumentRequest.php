<?php

namespace App\Http\Requests;

use App\Documents;
use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    public function authorize()
    {
        // return \Gate::allows('documents_create');
        return \Gate::allows('participant_create');
    }

    public function rules()
    {

        return [
            'title' => 'required',
            'document' => 'required|mimes:jpeg,png,bmp,tiff |max:12288',
            'user_id' => 'required',
        ];

        // return [
        //     'email' => 'required|email|unique:users',
        //     'name' => 'required|string|max:50',
        //     'password' => 'required'
        // ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.title' => 'Document title is required!',
            'document.required' => 'Document File is required!',
            'document.mimes' => 'Only jpeg,png,bmp,tiff files are allowed!',
            'document.max' => 'Max file size allowed is 12MB!',
            'user_id.required' => 'Something wrong happened! Please try again later',
        ];
    }
}
