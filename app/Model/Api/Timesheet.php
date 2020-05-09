<?php

namespace App\Model\Api;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    
    public $table = 'timesheet';

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'travel_compensation' => 'array'
    ];
    
    protected $fillable = [
        'booking_order_id',
        'total_time',
        'travel_compensation',
        'total_amount',
        'payable_amount',
        'is_billed'
    ];

}
