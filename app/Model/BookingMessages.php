<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingMessages extends Model
{
    public $table = 'booking_messages';

    public $timestamps = false;
    
    protected $fillable = [
        'booking_order_id',
        'message_thread_id',
    ];

    
}
