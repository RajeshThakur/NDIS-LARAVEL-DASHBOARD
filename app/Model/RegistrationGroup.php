<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegistrationGroup extends Model
{
    use SoftDeletes;

    public $table = 'registration_groups';

    protected $appends = array('parent');

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



    public function getParentAttribute()
    {
        return $this->find($this->parent_id);
    }


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
    public static function getProviderGroupForPrice( $providerId ):Builder
    {
        return \App\RegistrationGroup::select(  'registration_groups.id',
                                                'registration_groups.title',
                                                'registration_groups.item_number',
                                                'registration_groups.parent_id',
                                                'provider_reg_groups.inhouse',
                                                'provider_reg_groups.cost',
                                                'registration_groups.price_controlled',
                                                'registration_groups.quote_required',
                                                'registration_groups.price_limit',
                                                'registration_groups.unit',
                                                'states.id as state_id',
                                                'states.short_name',
                                                'states.full_name')
                                        ->leftJoin('provider_reg_groups', 'registration_groups.id', '=', 'provider_reg_groups.reg_group_id')
                                        ->leftJoin('states', 'provider_reg_groups.state_id', '=', 'states.id')
                                        ->where('registration_groups.price_limit', '>', 0)
                                        ->where('provider_reg_groups.user_id', $providerId);
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
     * Function to fetch all Registration Groups for Participant NDIS agreement with provider
     * @param  $providerId int, $participantId int
     * @return Illuminate\Database\Eloquent\Builder
     */ 
    public static function getByParticipant( $providerId, $participantId ):Builder
    {
        return \App\RegistrationGroup::whereIn('registration_groups.id', function($q) use ($providerId, $participantId)
                    {
                    $q->from('participants_reg_groups')
                        ->select('participants_reg_groups.reg_group_id')
                        ->where('participants_reg_groups.user_id', $participantId)
                        ->where('participants_reg_groups.provider_id', $providerId)
                        ->groupBy('participants_reg_groups.reg_group_id');
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
                ->where('provider_reg_groups.inhouse', '1')
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
                ->where('provider_reg_groups.inhouse', '0')
                ->where('provider_reg_groups.user_id', $providerId)
                ->groupBy('provider_reg_groups.parent_reg_group_id');
            });

    }


    /**
     * Function to fetch all Registration Groups for Provider
     * @param $regGroups array
     * @return Illuminate\Database\Eloquent\Builder
     */
    public static function getRegItemsForParents( $regGroups, $childGrp ):Builder
    {
        return \App\RegistrationGroup::select(  'registration_groups.id',
                                                'registration_groups.title',
                                                'registration_groups.item_number',
                                                'registration_groups.parent_id',
                                                'registration_groups.price_controlled',
                                                'registration_groups.quote_required',
                                                'registration_groups.price_limit',
                                                'registration_groups.unit'
                                                )
                                        // ->where('registration_groups.price_limit', '>', 0)
                                        ->whereIn('registration_groups.parent_id', $regGroups )
                                        ->whereIn('registration_groups.id', $childGrp );

        
    }

    /**
     * Function to fetch all child items of Registration Groups for selection
     * @param $regGroups array
     * @return Illuminate\Database\Eloquent\Builder
     */
    public static function getRegItemsForSelection( $regGroups ):Builder
    {
        return \App\RegistrationGroup::select(  'registration_groups.id',
                                                'registration_groups.parent_id',
                                                'registration_groups.title'
                                            )
                                        ->whereIn('registration_groups.parent_id', $regGroups );
 
    }

    public static function getRegItemsForSelectionEdit( $providerId, $participantId ):Builder
    {
        return \App\RegistrationGroup::whereIn('registration_groups.id', function($q) use ($providerId, $participantId)
                    {
                    $q->from('participants_reg_groups')
                        ->select('participants_reg_groups.reg_item_id')
                        ->where('participants_reg_groups.user_id', $participantId)
                        ->where('participants_reg_groups.provider_id', $providerId)
                        ->groupBy('participants_reg_groups.reg_item_id');
                    });
    }





}
