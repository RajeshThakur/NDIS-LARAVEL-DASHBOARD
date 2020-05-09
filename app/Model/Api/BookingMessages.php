<?php

namespace App\Model\Api;

use Illuminate\Database\Eloquent\Model;

class BookingMessages extends Model
{
    public $table = 'booking_messages';

    public $timestamps = false;
    
    protected $fillable = [
        'message_id',
        'booking_id'
    ];

    
}
