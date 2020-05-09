<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRegGroup extends Model
{
    public $table = 'user_reg_groups';

    protected $hidden = [
    ];

    protected $dates = [
    ];

    protected $fillable = [
        'user_id',
        'provider_id',
        'reg_group_id',
    ];

    public $timestamps = false;
}
