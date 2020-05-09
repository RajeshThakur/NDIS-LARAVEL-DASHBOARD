<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    public $table = 'payouts';

    public $timestamps = true;

    // protected $dates = [
    //     'created_at',
    //     'updated_at'
    // ];
    
    protected $fillable = [
        'user_id',
        'timesheet_id',
        'travel_compensation_amount',
        'total_amount',
        'travelstatus_compensation_amount'        
    ];

    // protected $with = ['timesheet'];

    public function timesheet()
    {
        return $this->hasOne(\App\Timesheet::class,'id', 'timesheet_id');
    }



}
