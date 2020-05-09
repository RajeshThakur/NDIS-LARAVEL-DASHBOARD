<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParticipantRegGroups extends Model
{
    //
    public $table = 'participants_reg_groups';

    protected $primaryKey = 'reg_group_id';

    public $incrementing = false;

    public $timestamps = false;

    protected $dates = [
        // 'created_at',
        // 'updated_at',
        // 'deleted_at',
    ];

    protected $fillable = [
        'reg_group_id',
        'reg_item_id',
        'user_id',
        'provider_id',
        'budget',
        'monthly_budget',
        'anual_funds_balance',
        'frequency'
    ];

}
