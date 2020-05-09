<?php

namespace App;

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

    


    // public static function updateProviderDetails( $data ,$userid){

    //     // pr($data,1);
    //     DB::table('provider_reg_groups')->insertGetId( [
    //         'user_id' => $userid,
    //         'state' => $data['state'],
    //         'reg_group' => $data['reg_group'],
    //         'inhouse'=>$data['in_house_reg_group'],
    //         'cost'=>$data['amount']
    //     ]);
        
    //     return Provider::where('user_id', $userid)->update(['is_onboarding_complete' => 1]);
    // }
}
