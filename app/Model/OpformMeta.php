<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OpformMeta extends Model
{
    public $table = 'opforms_meta';
    //protected $hidden = ['meta_value'];
    public $timestamps = false;
    protected $fillable = [
        'opform_id',
        'meta_key',
        'meta_value'
    ];

    

}
