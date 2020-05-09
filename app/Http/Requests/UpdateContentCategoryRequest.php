<?php

namespace App\Http\Requests;

use App\ContentCategory;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContentCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('content_category_edit');
    }

    public function rules()
    {
        return [
            'name' => [
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
            'name.required' => trans('errors.content_category_edit.name'),
        ];
    }
    
    
}
