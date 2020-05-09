<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingIncidents extends Model
{
    public $table = 'booking_incidents';


    protected $dates = [
        'datetime',
        'date_of_sign',
        'created_at',
        'updated_at'
    ];
    
    protected $fillable = [
        'datetime',
        'incident_details',
        'any_injuries',
        'any_damage',
        'cause_of_incident',
        'actions_to_eliminate',
        'management_comments',
        'management_sign',
        'date_of_sign',
        'booking_order_id',
        'user_id',
        'provider_id',
        'created_by',
    ];

    protected $with = array('comments');


    public function comments()
    {
        return $this->hasMany(\App\Comment::class, 'relatation_id', 'id')->where('comments.type','=', 'incident');
    }


    public function getDateOfSignAttribute($value)
    {
        return DBToDate($value);
    }

    public function setDateOfSignAttribute($value)
    {
        $this->attributes['date_of_sign'] = dateToDB($value);
    }


    public function getDatetimeAttribute($value)
    {
        return DBToDatetime($value);
    }

    public function setDatetimeAttribute($value)
    {
        $this->attributes['datetime'] = datetimeToDB($value);
    }


    /**
     * Scope a query to fetch all bookings incidents of user from all bookings
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function ScopeGetAllIncidents($query)
    {
        return $query->leftJoin('bookings', 'bookings.id', '=', 'booking_incidents.booking_id')
                    ->select(
                                'booking_incidents.booking_id',
                                'booking_incidents.id as incident_id',
                                'booking_incidents.incident_details',
                                'booking_incidents.any_injuries',
                                'booking_incidents.any_damage',
                                'booking_incidents.cause_of_incident',
                                'booking_incidents.actions_to_eliminate',
                                'booking_incidents.management_comments'
                            )
                    ->get();
    }


}
