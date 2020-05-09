<?php

namespace App\Model\Api;

use Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Guardian extends Model
{
    use SoftDeletes, HasApiTokens;

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

    

}
