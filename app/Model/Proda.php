<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Proda extends Model
{
    
    public $table = 'proda';

    protected $fillable = [
        'title'
    ];


    public function timesheet()
    {
        return $this->belongsToMany(Timesheet::class);
    }

    public function getProdaRecords($service_type)
    {

        $records = $this->all();

        $service = '';

        foreach($records as $record) {

            foreach($record->timesheet as $timesheet){

                $service = DB::table('booking_orders')
                ->select('bookings.service_type')
                ->leftJoin('bookings', 'booking_orders.booking_id', '=', 'bookings.id')
                ->where('booking_orders.id', $timesheet->booking_order_id)
                ->where('bookings.service_type', $service_type)
                ->first();
            }
            
            if(isset($service->service_type)){

                if($service->service_type == $service_type){
                    $record['service_type'] = true;
                }else{
                    $record['service_type'] = false;
                }


            }else{
                $record['service_type'] = false;
            }
            
                
        }

        return $records;
        
    }

    public function get_Participant_id($id, $service_type){

        
        
        $data = DB::table('booking_orders')
            ->select('bookings.participant_id')
            ->leftJoin('bookings', 'booking_orders.booking_id', '=', 'bookings.id')
            ->where('booking_orders.id', $id)
            ->where('bookings.service_type', $service_type)
            ->first();

        
        return $data->participant_id;

    }
}
