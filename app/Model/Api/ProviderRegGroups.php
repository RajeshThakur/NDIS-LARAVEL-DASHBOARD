<?php

namespace App\Model\Api;

use Illuminate\Database\Eloquent\Model;

// use App\Provider;

class ProviderRegGroups extends Model
{
    public $table = 'provider_reg_groups';

    protected $hidden = [
        
    ];

    protected $dates = [
        // 'created_at',
        // 'updated_at',
        // 'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'state_id',
        'parent_reg_group_id',
        'reg_group_id',
        'inhouse',
        'cost'
    ];

    protected $primaryKey = 'reg_group_id';

    public $timestamps = false;
    
}
