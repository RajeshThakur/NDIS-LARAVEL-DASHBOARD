<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingComplaints extends Model
{
    public $table = 'booking_complaints';


    protected $dates = [
        'created_at',
        'updated_at'
    ];
    
    protected $fillable = [
        'complaint_details',       
        'booking_order_id',
        'user_id',
        'provider_id',
        'created_by',
    ];

    protected $with = array('comments');

    
    public function comments()
    {
        return $this->hasMany(\App\Comment::class, 'relatation_id', 'id')->where('comments.type','=', 'complaint');
    }

}
