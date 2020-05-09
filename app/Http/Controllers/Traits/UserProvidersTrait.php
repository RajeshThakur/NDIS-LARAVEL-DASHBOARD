<?php

namespace App\Http\Controllers\Traits;
use Illuminate\Support\Arr;

trait UserProvidersTrait
{
    /**
     * The current access token for the authentication user.
     *
     * @var \User\Roles
     */
    protected $_roles;


    private function deleteRegGroupNotInStates( $states ){
        $provider = \Auth::user();
        \App\ProviderRegGroups::where('user_id', $provider->id)->whereNotIn('state_id', $states )->delete();
    }
    
    private function deleteRegGroupInStates( $states ){
        $provider = \Auth::user();
        \App\ProviderRegGroups::where('user_id', $provider->id)->whereIn('state_id', $states )->delete();
    }
    
    private function deleteRegGroupParentNotIn( $state_id, $parentIds ){
        $provider = \Auth::user();
        \App\ProviderRegGroups::where('user_id', $provider->id)->where('state_id', $state_id)->whereNotIn('parent_reg_group_id', $parentIds )->delete();
    }



    public function addUpdateRegGroups( $request ){

        $user = \Auth::user();

        $newStateArr = request('state');
        $newParentArr = request('parent_reg_group');
        $newInHouse = request('in_house');
        $stateWiseParentId = [];

        //Delete all existing reg groups for states which aren't submitted anymore
        $this->deleteRegGroupNotInStates($newStateArr);

        $_providrRegGrpsArr = [];
        // Loop Through the states submitted
        foreach($newStateArr as $key => $state){
            
            $parentRegGrps = $newParentArr[$key];
            $inHouseArr = $newInHouse[$key];
            // pr($inHouseArr, 1);

            //Now save reg Groups for this State
            // $regGroupItems = \App\RegistrationGroup::whereIn('parent_id', $parentRegGrps)->get()->toArray();
            $regGroupItems = \App\RegistrationGroup::selectRaw('registration_groups.*, ( 
                                                                                            select cost from provider_reg_groups 
                                                                                            where provider_reg_groups.state_id = '.$state.' and 
                                                                                            provider_reg_groups.user_id = '.$user->id.' and 
                                                                                            registration_groups.id = provider_reg_groups.reg_group_id 
                                                                                        ) as cost')
                                    ->whereIn('parent_id', $parentRegGrps)->get()->toArray();

            foreach( $regGroupItems as $regGroupItem ){
                $inHouse = in_array($regGroupItem['parent_id'], $inHouseArr)?'1':'0';
                $_providrRegGrpsArr[]=[
                                        'user_id'       => $user->id,
                                        'state_id'       => $state,
                                        'parent_reg_group_id'  => $regGroupItem['parent_id'],
                                        'reg_group_id'  => $regGroupItem['id'],
                                        'inhouse'   => $inHouse,
                                        'cost'    => $regGroupItem['cost']??0
                                    ];
            }

            //Delete all existing reg groups for states
            $this->deleteRegGroupInStates([$state]);

        }

        
        //Insert all updated groups into the DB
        $all = \App\ProviderRegGroups::insert($_providrRegGrpsArr);
        // pr($_providrRegGrpsArr);
        return $_providrRegGrpsArr;

    }

}
