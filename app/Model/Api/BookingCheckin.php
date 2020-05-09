<?php

namespace App\Model\Api;

use Illuminate\Database\Eloquent\Model;

class BookingCheckin extends Model
{
    
    public $table = 'booking_checkins';

    protected $dates = [
        'participant_checkin_time',
        'sw_checkin_time'       
    ];

    protected $fillable = [
        'booking_order_id',
        'participant_checkin',
        'participant_checkin_time',
        'participant_lat',
        'participant_lng',
        'sw_checkin',
        'sw_checkin_time',
        'sw_lat',
        'sw_lng',        
    ];

    // public function booking()
    // {
    //     return $this->belongsTo(\App\Model\Api\BookingOrders::class);
    // }


    /**
     * Set Attributes
     */
    public function getParticipantCheckinTimeAttribute($value)
    {
        return DBToDatetime($value);
    }
    public function setParticipantCheckinTimeAttribute($value)
    {
        $this->attributes['participant_checkin_time'] = datetimeToDB($value);
    }
    
    public function getSwCheckinTimeAttribute($value)
    {
        return DBToDatetime($value);
    }
    public function setSwCheckinTimeAttribute($value)
    {
        $this->attributes['sw_checkin_time'] = datetimeToDB($value);
    }

}
