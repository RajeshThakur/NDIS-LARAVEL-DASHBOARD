<?php

namespace App\Model\Api;

use Illuminate\Database\Eloquent\Model;

class OpformMeta extends Model
{
    public $table = 'opforms_meta';
    
    protected $fillable = [
        'opform_id',
        'meta_key',
        'meta_value'
    ];

}
