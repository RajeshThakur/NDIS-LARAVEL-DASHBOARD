<?php

namespace App\Model\Api;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegistrationGroup extends Model
{
    use SoftDeletes;

    public $table = 'registration_groups';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const STATUS_SELECT = [
        1   => 'Active',
        0   => 'Inactive'
    ];

    protected $fillable = [
        'title',
        'item_number',
        'parent_id',
        'status',
        'unit',
        'price_controlled',
        'quote_required',
        'price_limit',        
        'travel',        
        'cancellations',        
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    /**
     * 
     */
    public static function getAllRegGroupsBySelectedId( $groupId ){
        
        $sql = "select * FROM admin_ndis.registration_groups rg
                where rg.parent_id = ( select parent_id from admin_ndis.registration_groups where id = {$groupId} )";

        return RegistrationGroup::where(function($q) use ($groupId) {
                                            $parent = RegistrationGroup::where('id',$groupId)->select('parent_id')->first();
                                            $q->where('parent_id', $parent->parent_id);
                                        })
                    ->select('registration_groups.*')->get();
            
    }


    /**
     * Function to fetch all Registration Groups for Provider
     * @param $providerId int
     * @return Illuminate\Database\Eloquent\Builder
     */
    public static function getByProvider( $providerId ):Builder
    {
        return \App\RegistrationGroup::whereIn('registration_groups.id', function($q) use ($providerId)
                    {
                    $q->from('provider_reg_groups')
                        ->select('provider_reg_groups.parent_reg_group_id')
                        ->where('provider_reg_groups.user_id', $providerId)
                        ->groupBy('provider_reg_groups.parent_reg_group_id');
                    });
    }


    /**
     * Function to fetch all Registration Groups for Provider
     * @param $providerId int
     * @return Illuminate\Database\Eloquent\Builder
     */
    public static function getInhouseByProvider( $providerId ):Builder
    {

        return \App\RegistrationGroup::whereIn('registration_groups.id', function($q) use ($providerId)
            {
            $q->from('provider_reg_groups')
                ->select('provider_reg_groups.parent_reg_group_id')
                ->where('provider_reg_groups.inhouse', 1)
                ->where('provider_reg_groups.user_id', $providerId)
                ->groupBy('provider_reg_groups.parent_reg_group_id');
            });

    }

    /**
     * Function to fetch all Registration Groups for Provider
     * @param $providerId int
     * @return Illuminate\Database\Eloquent\Builder
     */
    public static function getExternalByProvider( $providerId ):Builder
    {

        return \App\RegistrationGroup::whereIn('registration_groups.id', function($q) use ($providerId)
            {
            $q->from('provider_reg_groups')
                ->select('provider_reg_groups.parent_reg_group_id')
                ->where('provider_reg_groups.inhouse', 0)
                ->where('provider_reg_groups.user_id', $providerId)
                ->groupBy('provider_reg_groups.parent_reg_group_id');
            });

    }



}
