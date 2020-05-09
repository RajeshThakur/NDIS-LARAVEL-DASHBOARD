<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


class Provider extends Model
{
    use SoftDeletes;

    public $table = 'provider_details';

    protected $hidden = [

        "created_at",
        "updated_at",
        "deleted_at",
        
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'organisation_id',
        'ra_number',
        'renewal_date',
        'ndis_cert',
        'business_name',        
    ];

    protected $primaryKey = 'user_id';


    /**
     * Set Attributes
     */
    public function getRenewalDateAttribute($value)
    {
        return DBToDate($value);
    }

    public function setRenewalDateAttribute($value)
    {
        $this->attributes['renewal_date'] = dateToDB($value);
    }

   

    //-------------- Core Overrides ----------------------

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return $this->getQualifiedKeyName();
    }

    //-------------- End of Core Overrides ----------------------


    // Relationship with Service Bookings
    public function bookings()
    {
        return $this->hasMany('App\Bookings', 'provider_id');
    }

    /**
     * Relationship with Signatures
     */
    public function signature()
    {
        return $this->hasOne(\App\Signature::class, 'user_id', 'user_id');
    }

    public function profile()
    {
        return $this->belongsTo('App\User');
    }

    
    // Get provider details 
    public function providerDetails(){

        $user = \Auth::user();

        return $this->where('user_id' , '=' , $user->id)->first();
    }

}
