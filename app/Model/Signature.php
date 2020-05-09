<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    public $table = 'signatures';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'url',
        'user_id'
    ];

    /**
     * Get the user that owns the phone.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
}
