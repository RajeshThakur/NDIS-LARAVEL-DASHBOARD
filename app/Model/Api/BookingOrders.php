<?php

namespace App\Model\Api;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingOrders extends Model
{
    use SoftDeletes;

    public $table = 'booking_orders';

    protected $dates = [
        'starts_at',
        'ends_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'booking_id',
        'starts_at',
        'ends_at',
        'timezone',
        'is_billable',
        'is_cancelled',
        'cancelled_at',
        'amount',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public function booking()
    {
        return $this->belongsTo(\App\Model\Api\Bookings::class);
    }

    public function checkin()
    {
        return $this->hasOne(\App\Model\Api\BookingCheckin::class,'booking_order_id', 'id');
    }
    
    public function checkout()
    {
        return $this->hasOne(\App\Model\Api\BookingCheckout::class,'booking_order_id', 'id');
    }

    public function message()
    {
        return $this->hasMany(\App\Model\Api\BookingMessages::class,'booking_order_id', 'id');
    }

    
    
    /**
     * Get the booking participant
     */
    public function participant()
    {
        return $this->hasOneThrough(
            'App\Model\Api\Participant',
            'App\Model\Api\Bookings',
            'participant_id', // Foreign key on bookings table...
            'user_id', // Local key on Participant table...
            'booking_id', // Foreign key on BookingOrders table...
            'participant_id' // Local key on bookings table...
        );
    }
    /**
     * Get the booking Support Worker
     */
    public function supportWorker()
    {
        return $this->hasOneThrough(
            'App\Model\Api\SupportWorker',
            'App\Model\Api\Bookings',
            'supp_wrkr_ext_serv_id', // Foreign key on bookings table...
            'user_id', // Foreign key on Participant table...
            'booking_id', // Local key on BookingOrders table...
            'supp_wrkr_ext_serv_id' // Local key on bookings table...
        );
    }
    


}
