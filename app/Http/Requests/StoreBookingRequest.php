<?php

namespace App\Http\Requests;

use App\Bookings;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('service_booking_create');
    }

    public function rules()
    {

        return [
            'participant_id' => 'required|integer|participant',
            'location' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'date' => [
                // 'date_format:' . config('panel.date_format'),
                'required',
            ],
            'start_time' => [
                'date_format:' . config('panel.time_format'),
                'required',
            ],
            'end_time' => [
                'date_format:' . config('panel.time_format'),
                'required',
            ],
            // 'registration_group_id' => 'required|integer',
            'item_number' => 'required|integer',
            'supp_wrkr_ext_serv_id' => 'required|integer',
            // 'service_type' => "required|enum:support_worker,external_service",
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
            'participant_id.required' => trans('errors.service_booking.participant_id'),
            'location.required' => trans('errors.service_booking.location'),
            'lat.required' => trans('errors.service_booking.lat'),
            'lng.required' => trans('errors.service_booking.lng'),

            'date.required' => trans('errors.service_booking.date'),
            'start_time.date_format' => trans('errors.service_booking.start_time_format', ['format'=>config('panel.date_format')]),
            'start_time.required' => trans('errors.service_booking.start_time'),
            'end_time.date_format' => trans('errors.service_booking.end_time_format', ['format'=>config('panel.date_format')]),
            'end_time.required' => trans('errors.service_booking.end_time'),


            'registration_group_id.required' => trans('errors.service_booking.registration_group_id'),
            'item_number.required' => trans('errors.service_booking.item_number'),
            'supp_wrkr_ext_serv_id.required' => trans('errors.service_booking.supp_wrkr_ext_serv_id'),
            'supp_wrkr_ext_serv_id.worker' => trans('errors.service_booking.suport_wrkr_not'),
            // 'service_type.required' => trans('errors.internal_error'),

        ];
    }


}
