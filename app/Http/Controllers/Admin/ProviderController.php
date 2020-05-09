<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Task;
use App\Provider;

use App\Http\Controllers\Traits\Common;



class ProviderController extends Controller
{

    use Common;

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // public function completeOnboarding( Request $request ){
  
    //     $request->validate([
    //         'state' => 'bail|required| integer|not_in:0',
    //         'reg_group' => 'bail|required| integer|not_in:0',
    //         'in_house_reg_group' => 'bail|required| boolean',
    //         'amount' => 'bail|required|numeric'
    //     ]);
        
    //     $user = \Auth::user();
    //     $events = Task::whereNotNull('due_date')->get();

    //     $provider = new Provider();
    //     $onboarding = $provider->updateProviderDetails( $request->all() , $user->id);

    //     $regdd = Common::getDropDown('reg_group[]');
    //     $states = Common::getStates('state[]');

    //     // $onboarding = Provider::where('user_id', '=', \Auth::user()->id )->firstOrFail();
    //     // $onboarding = $onboarding->is_onboarding_complete;

    //     return view('home',compact('events','onboarding','regdd', 'states'));
    // }
}
