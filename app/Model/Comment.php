<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $table = 'comments';

    protected $fillable = [
        'relatation_id',
        'author_ip',
        'content',
        'approved',
        'type',
        'parent',
        'user_id'
    ];

    /**
     * The "booting" method of the model.
     * @return void
     */
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::addGlobalScope('select', function (Builder $builder) {
    //         $columns = ['id', 'content', 'parent','user_id','created_at'];
    //         $builder->get($columns);
    //     });
    // }
}
