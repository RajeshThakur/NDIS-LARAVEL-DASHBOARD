<?php

namespace App\Http\Requests;

use App\ContentPage;
use Illuminate\Foundation\Http\FormRequest;

class StoreContentPageRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('content_page_create');
    }

    public function rules()
    {
        return [
            'title'        => [
                'required',
            ],
            // 'categories.*' => [
            //     'integer',
            // ],
            'categories'   => [
                'array',
            ],
            // 'tags.*'       => [
            //     'integer',
            // ],
            'tags'         => [
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
            'title.required' => trans('errors.content_page_create.title'),
            'categories.array' => trans('errors.content_page_create.categories'),
            'tags.array' => trans('errors.content_page_create.tags'),
        ];
    }
    
}
