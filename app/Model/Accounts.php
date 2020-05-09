<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Accounts extends Model
{
    


    public function get_timesheet_records($status, $service_type, $is_billed){

        
        $records = DB::table('timesheet')
            ->select('timesheet.id', 'timesheet.booking_order_id', 'timesheet.total_amount', 'bookings.participant_id', 'bookings.supp_wrkr_ext_serv_id', 'bookings.item_number as item_id', 'booking_orders.booking_type', 'booking_orders.starts_at', 'booking_orders.ends_at', 'registration_groups.title','registration_groups.item_number')
            ->leftJoin('booking_orders', 'timesheet.booking_order_id', '=', 'booking_orders.id')
            ->leftJoin('bookings', 'bookings.id', '=', 'booking_orders.booking_id')
            ->leftJoin('registration_groups', 'registration_groups.id', '=', 'bookings.item_number')
            ->where('is_billed', $is_billed)
            ->where('booking_orders.status', $status)
            ->where('bookings.service_type', $service_type)
            ->get();

        
        return $records;

    }
}
