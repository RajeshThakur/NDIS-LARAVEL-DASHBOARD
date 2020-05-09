<?php

namespace App\Http\Controllers\Admin;

use App\ProviderRegGroups;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Task;
use App\Provider;

use App\Http\Controllers\Traits\Common;


class ProviderRegGroupsController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'state.*' => 'bail|required| integer|not_in:0',         
            'item.*.amount.*' => 'bail|required| numeric|not_in:0',
            'inhouse.*' => 'bail|required| boolean',  
        ]);
        
        $user = \Auth::user();        
        $toInsert = [];        
        $count = 0;
        foreach( $data['item'] as $key=> $val ){           
            foreach( $data['item'][$key]['amount'] as $id=>$cost){                    
                $toInsert[$count]['reg_group_id']  = $id;
                $toInsert[$count]['cost']  = $cost;
                $toInsert[$count]['state_id'] = $data['state'][$key];
                $toInsert[$count]['inhouse']  = $data['inhouse'][$key];
                $toInsert[$count]['user_id']  = $user->id;
                $count++;
            }
        }       

        ProviderRegGroups::insert($toInsert);

        Provider::where('user_id', $user->id)->update(['is_onboarding_complete' => 1]);

        $events = Task::whereNotNull('due_date')->get();

        return redirect('home');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProviderRegGroups  $providerRegGroups
     * @return \Illuminate\Http\Response
     */
    public function show(ProviderRegGroups $providerRegGroups)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProviderRegGroups  $providerRegGroups
     * @return \Illuminate\Http\Response
     */
    public function edit(ProviderRegGroups $providerRegGroups)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProviderRegGroups  $providerRegGroups
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProviderRegGroups $providerRegGroups)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProviderRegGroups  $providerRegGroups
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProviderRegGroups $providerRegGroups)
    {
        //
    }

    public function completeOnboarding( Request $request ){
  
        $request->validate([
            'state' => 'bail|required| integer|not_in:0',
            'reg_group' => 'bail|required| integer|not_in:0',
            'in_house_reg_group' => 'bail|required| boolean',
            'amount' => 'bail|required|numeric'
        ]);
        
        $user = \Auth::user();
        $events = Task::whereNotNull('due_date')->get();

        $provider = new Provider();
        $onboarding = $provider->updateProviderDetails( $request->all() , $user->id);

        $regdd = Common::getDropDown('reg_group[]');
        $states = Common::getStates('state[]');

        // $onboarding = Provider::where('user_id', '=', \Auth::user()->id )->firstOrFail();
        // $onboarding = $onboarding->is_onboarding_complete;

        return view('home',compact('events','onboarding','regdd', 'states'));
    }
}
