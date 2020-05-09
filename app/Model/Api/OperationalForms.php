<?php

namespace App\Model\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OperationalForms extends Model
{

    use SoftDeletes;
    
    public $table = 'opforms';
    
    protected $fillable = [
        'title',
        'date',
        'user_id',
        'provider_id',
        'template_id',
    ];


    /**
     * Get the participants
     */
    public function meta()
    {
        return $this->hasMany('App\OpformMeta', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

}
