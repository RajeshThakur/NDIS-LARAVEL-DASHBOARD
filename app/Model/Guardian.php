<?php

namespace App;

use Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;


class Guardian extends Model
{
    use SoftDeletes, HasApiTokens, Notifiable;

    public $table = 'participants_guardian';

    protected $hidden = [
        'password',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
        'email_verified_at',
    ];

    protected $fillable = [
        'email',
        'password',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'email_verified_at'
    ];

    public function getEmailVerifiedAtAttribute($value)
    {
        return DBToDatetime($value);
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = datetimeToDB($value);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
