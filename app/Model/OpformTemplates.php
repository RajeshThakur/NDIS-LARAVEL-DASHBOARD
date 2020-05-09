<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OpformTemplates extends Model
{

    public $table = 'opforms_templates';
    
    protected $fillable = [
        'title',
        'status'
    ];


    /**
     * Get the participants
     */
    public function forms()
    {
        return $this->hasMany('App\OperationalForms', 'id');
    }


}
