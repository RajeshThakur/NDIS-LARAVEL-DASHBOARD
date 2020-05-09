<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingCheckout extends Model
{
    public $table = 'booking_checkouts';

    protected $dates = [
        'participant_checkout_time',
        'sw_checkout_time'
    ];

    protected $fillable = [
        'booking_order_id',
        'participant_checkout',
        'participant_checkout_time',
        'participant_lat',
        'participant_lng',
        'sw_checkout',
        'sw_checkout_time',
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
    public function getParticipantCheckoutTimeAttribute($value)
    {
        return DBToDatetime($value);
    }
    public function setParticipantCheckoutTimeAttribute($value)
    {
        $this->attributes['participant_checkout_time'] = datetimeToDB($value);
    }
    
    public function getSwCheckoutTimeAttribute($value)
    {
        return DBToDatetime($value);
    }
    public function setSwCheckoutTimeAttribute($value)
    {
        $this->attributes['sw_checkout_time'] = datetimeToDB($value);
    }


}
