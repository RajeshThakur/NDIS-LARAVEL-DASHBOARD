<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class UsersToProviders extends Model
{
    use Notifiable;

    public $table = 'users_to_providers';

    public $timestamps = false;

    protected $hidden = [
        'user_id',
        'provider_id',
    ];

    protected $fillable = [
        'user_id',
        'provider_id',
    ];


    /**
     * Get the participants
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'id');
    }

}
