<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAvailabilityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return \Gate::allows('service_booking_create');
        return true;
    }

    public function rules()
    {

        $rules = [
            'user_id' => 'required|integer',
            'range' => 'required',
            'from' => [ 'date_format:' . config('panel.time_format'), 'nullable' ],
            'to' => [ 'date_format:' . config('panel.time_format'), 'nullable' ],
        ];

        // $availabiltyRange = ['monday','tuesday','wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        // $rules = [
        //     'user_id' => 'required|integer',
        //     'availability' => 'array|min:'.count($availabiltyRange),
        // ];
        // foreach($availabiltyRange as $key => $range){
        //     $rules['availability.'.$range.'.from'] = [
        //                                                 'date_format:' . config('panel.time_format'),
        //                                                 'nullable',
        //                                             ];
        //     $rules['availability.'.$range.'.to'] = [
        //                                                 'date_format:' . config('panel.time_format'),
        //                                                 'nullable',
        //                                             ];
        // }

        return $rules;
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {

        $availabiltyRange = ['monday','tuesday','wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        $msgs = [
            'user_id.required' => 'Somethign went wrong!',
            'range.required' => 'Range is required!',
            'from.required' => 'Start time is required!',
            'to.required' => 'End time is required!',
            'from.date_format' =>  "Start time is not valid",
            'to.date_format' =>  "End time is not valid "
        ];

        // foreach($availabiltyRange as $key => $range){
        //     $msgs['availability.'.$range.'.from.date_format'] = "Start time not valid for ".ucfirst($range);
        //     $msgs['availability.'.$range.'.to.date_format'] = "End time not valid for ".ucfirst($range);
        // }

        return $msgs;
    }

}
