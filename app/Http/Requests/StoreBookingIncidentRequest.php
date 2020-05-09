<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingIncidentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'booking_order_id'      => ['required','integer'],
            'incident_details'      => ['required'],
            'any_injuries' => ['required'],
            'any_damage' => ['required'],
            'cause_of_incident' => ['required'],
            'actions_to_eliminate' => ['required'],
            'management_comments' => ['required'],
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
            'booking_order_id.required' => trans('errors.internal_error'),
            'incident_details.required' => 'Incident details are required!',
            'any_injuries.required' => 'Please Specify any Injuries during the incident?',
            'any_damage.required' => 'Please specify if there are any damages?',
            'cause_of_incident.required' => 'Please Provide the incident cause!',
            'actions_to_eliminate.required' => 'Please specify actions will be taken to eliminate future incident!',
            'management_comments.required' => 'Management Comments cannot be empty !',
        ];
    }
}
