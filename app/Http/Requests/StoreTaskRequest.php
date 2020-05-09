<?php

namespace App\Http\Requests;

use App\Task;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize()
    {

        return \Gate::allows('task_create');
    }

    public function rules()
    {
        
        return [
            'name'      => [
                'required',
            ],
            'location' => [
                'required',
            ],            
            'due_date'  => [
                'date_format:' . config('panel.date_input_format'),
                'nullable',
            ],
            'description'  => [
                'required',                
            ],
            'task_assignee_id'  => [
                'required',                
            ],
            'status_id'  => [
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
            'name.required' => trans('errors.task_create.name'),
            'location.required' => trans('errors.task_create.location'),
            'description.required' => trans('errors.task_create.description'),
            'task_assignee_id.required' => trans('errors.task_create.task_assignee_id'),
            'status_id.required' => trans('errors.task_create.status_id'),
        ];
    }

}
