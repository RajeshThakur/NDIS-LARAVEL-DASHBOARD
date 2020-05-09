<?php

namespace App\Http\Requests;

use App\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskStatusRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('task_status_edit');
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
            'name.required' => trans('errors.task_status.name'),
        ];
    }
    
    
}
