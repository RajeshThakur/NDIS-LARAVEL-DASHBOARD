<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateProviderPricingRequest;
use Symfony\Component\HttpFoundation\Request;
use App\Role;
use App\User;
use App\Provider;
use App\Documents;
use App\ProviderRegGroups;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Traits\UserProvidersTrait; 
use App\Notifications\UserActivation;




class UsersController extends Controller
{
    use UserProvidersTrait;

    public function index()
    {
        abort_unless(\Gate::allows('user_access'), 403);

        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('user_create'), 403);

        $roles = Role::all()->pluck('title', 'id');

        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        abort_unless(\Gate::allows('user_create'), 403);

        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index')->with('success',   trans('msg.user_add.success') );
    }

    public function edit(User $user)
    {
        abort_unless(\Gate::allows('user_edit'), 403);

        $roles = Role::all()->pluck('title', 'id');

        $user->load('roles');

        return view('admin.users.edit', compact('roles', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        //dd($request->request);
        //abort_unless(\Gate::allows('user_edit'), 403);

        $user->update($request->all());

        $user->roles()->sync($request->input('roles', []));

            
        if( array_key_exists( config('provider_role_id'), $request->input('roles', []) ) ){
            \App\Provider::updateOrCreate(
                ['user_id' => '', 'organisation_id' => ''],
                ['ra_number' => '', 'renewal_date' => '']
            );
        }

        return redirect()->route('admin.users.index')->with('success',   trans('msg.user_update.success') );;
    }

    public function show(User $user)
    {
        abort_unless(\Gate::allows('user_show'), 403);

        $user->load('roles');

        return view('admin.users.show', compact('user'));
    }


    public function profile()
    {

        abort_unless(\Gate::allows('user_profile'), 403);

        $user = \Auth::user();

        if( in_array( 'Admin', $user->getRoles() ) )
            return redirect()->route('admin.users.edit', $user->id);
        
        $user->provider = (new Provider)->providerDetails();

        $onboardingStatus =$user->provider->is_onboarding_complete;
    
        $providerRegGrps = ProviderRegGroups::where('user_id', $user->id)->get()->toArray();
        // dd($providerRegGrps);
        $regGrps = [];
        //dd($providerRegGrps);
        if( !empty($providerRegGrps) ){
            
            foreach( $providerRegGrps as $val) {

                if( array_key_exists($val['state_id'], $regGrps) ){
                    
                    if(array_key_exists($val['parent_reg_group_id'], $regGrps[$val['state_id']])){
                        
                        $regGrps[ $val ['state_id'] ] [$val['parent_reg_group_id']]['child_grp'][] =  array( 
                            'cost'=> $val['cost'] , 
                            'reg_group_id'=> $val['reg_group_id']
                        );
                        
                    }else{
    
                        $regGrps[ $val ['state_id']] [$val['parent_reg_group_id']]  =  array( 
                            'state'=> $val['state_id'] , 
                            'inhouse'=> $val['inhouse'],
                            'parent_id'=>$val ['parent_reg_group_id'], 
                            'child_grp' => array(
                                                array( 
                                                        'cost'=> $val['cost'] , 
                                                        'reg_group_id'=> $val['reg_group_id']
                                                    )
                                                )
                        );
    
                    }
                    
                }else{
                    $regGrps[ $val ['state_id']] [$val['parent_reg_group_id']]  =  array( 
                                                                    'state'=> $val['state_id'] , 
                                                                    'inhouse'=> $val['inhouse'],
                                                                    'parent_id'=>$val ['parent_reg_group_id'], 
                                                                    'child_grp' => array(
                                                                                        array( 
                                                                                                'cost'=> $val['cost'] , 
                                                                                                'reg_group_id'=> $val['reg_group_id']
                                                                                            )
                                                                                        )
                                                                );
                }
            }
            // $onboardingStatus = 1;
        }
        // pr($user->provider, 1);

        return view('admin.users.profile', compact('user', 'onboardingStatus','regGrps'));
    }
    

    public function profile_update( UpdateProfileRequest $request )
    {

        $user = \Auth::user();
        
        if( request('password') == null){
            $request->request->remove('password');
        }

        // pr($request->all());

        $user->update( $request->all() );


        if( isset($request->ndis_cert) )
        {
            //Save Document
            $_doc = Documents::saveDoc( $request->ndis_cert, [
                'title'=>'NDIS Certificate',
                'user_id'=>$user->id,
                'provider_id'=>$user->id,
            ]);
            $user->profile->ndis_cert = $_doc->id;
        }
            
        $user->profile->organisation_id = request('organisation_id');
        $user->profile->ra_number = request('ra_number');
        $user->profile->renewal_date = request('renewal_date');
        $user->profile->business_name = request('business_name');
        $user->profile->save();

        if(isset($request->parent_reg_group)){
            
            //Add/Update the Provider Reg Groups
            $this->addUpdateRegGroups($request);

            $providerRegGroups = \App\RegistrationGroup::getProviderGroupForPrice($user->id)->get();
        
            return view('admin.users.reg_grps_cost', compact('user', 'providerRegGroups'))->with('success','Successfully save');
            
        }else{
            ProviderRegGroups::where('user_id', $user->id )->delete();
        }

        $user->provider = (new Provider)->providerDetails();

        return redirect()->route('admin.home');
    }

    public function editRates(Request $request){

        $user = \Auth::user();

        if(!$user->provider->is_onboarding_complete)
            return redirect()->route('admin.home')->withErrors('Please complete onboarding first!');

        $providerRegGroups = \App\RegistrationGroup::getProviderGroupForPrice( $user->id )->get();
    
        return view('admin.users.reg_grps_cost', compact('user', 'providerRegGroups'));
    }


    public function destroy(User $user)
    {
        abort_unless(\Gate::allows('user_delete'), 403);

        $user->delete();

        return back();
    }

    public function reg_update(UpdateProviderPricingRequest $request){

        $provider = \Auth::user();
        
        $reg_groups = $request->input('reg_groups');

        foreach($reg_groups as $reg_group){
            ProviderRegGroups::where('state_id', $reg_group['state_id'])
                                ->where('parent_reg_group_id', $reg_group['parent_reg_group_id'])
                                ->where('reg_group_id', $reg_group['reg_group_id'])
                                ->update(['cost' => $reg_group['cost'] ]);
        }

        $onboardingStatus = 1;
        //update Provider;s Onboarding Status
        \App\Provider::where('user_id', $provider->id)->update(['is_onboarding_complete' => $onboardingStatus]);
        
        return redirect()->route('admin.home')->withSuccess('Rates updated successfully');
    }



    public function saveAvatar( Request $request){

        // AWS file upload and return object key

        $file = $request->file('file');
        $user_id = $request->input('user_id');

        $provider = \Auth::user();

        //Save Document
        $document = Documents::saveDoc( $file, [
                                                'title'=>'profile_image',
                                                'user_id'=>$user_id,
                                                'provider_id'=>0,
                                                ]);
        if( isset($document->url) ){
            //Save Avatar
            User::findOrFail($user_id)->update(['avatar'=>$document->id]);
            echo json_encode( array( "status"=>true, "id" => $document->id, 'url'=>$document->url ) );

        }else{
            echo json_encode( array( "status"=>false, "error" => $document ) );
        }
        
        die();

    }

    public function ajax_resendActivationMail( Request $request){

        $messages = [
            'user_id'   => "No user id found.",
        ];

        $data = Validator::make( $request->all(), [
                            'user_id' => 'required|int'
                            ], $messages);

        if($data->fails()):
            return response()->json([ 'status'=>false, 'message'=>"User id not found." ]);
        endif;
                        
        // dd($request->all());

        $user = \App\User::find($request->user_id);

        $user->notify(new UserActivation($user));

        return response()->json([ 'status'=>true, 'message'=>"Activation mail sent to " . $user->first_name . ' ' . $user->last_name  ]);

    }


}
