<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\SupportWorker;
use App\Participant;
use App\ParticipantRegGroups;
use App\RegistrationGroup;

use App\User;
use App\Guardian;
use Illuminate\Support\Facades\Hash;

#use App\Http\Controllers\Traits\Common;

class UsersApiController extends Controller
{
    public function index()
    {
        $users = User::all();

        return $users;
    }

    
    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
 
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
 
        $token = $user->createToken('NDISONLINEAPI')->accessToken;
 
        return response()->json(['status' => true, 'token' => $token ], 200);
    }
 
    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {   
        
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|min:3|max:12'
            ]);
        
            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()], 401);
            }
            
            $user = User::where('email', $request->email)->first();

            if($user){

                $credentials = [
                    'email' => $request->email,
                    'password' => $request->password
                ];

                if (auth()->attempt($credentials)) {

                    $user = auth()->user();
                    $user->load('roles');
                    
                    $loginAllowed = false;
                    //check for allowed roles
                    $allowedRoles = explode(',', config('ndis.app_roles_allowed'));
                    
                    foreach(auth()->user()->roles as $role){
                        if( in_array($role->id, $allowedRoles) ){
                            $loginAllowed = true;
                        }
                    }
    
                    if(!$loginAllowed){
                        $this->doLogout();
                        return response()->json(['status' => false, "message" => 'UnAuthorised!'], 401);
                    }
                    
                    
                    $token = $user->createToken('NDISCentral')->accessToken;



                    if( $user->roles()->get()->contains( config('ndis.participant_role_id') ) ){
                        $participant = $user->participant;
                        $participant->roles = $user->roles;

                        // pr($participant, 1);
                        unset($participant->id);
                        unset($participant->password);
                        unset($participant->remember_token);
                        
        
                        return response()->json(['status' => true, 'token' => $token, 'user'=> $participant ], 200);
                    }
                    
                    if( $user->roles()->get()->contains( config('ndis.support_worker_role_id') ) ){
                        $sw = $user->supportWorker;
                        $sw->roles = $user->roles;

                        // pr($sw, 1);
                        unset($sw->id);
                        unset($sw->password);
                        unset($sw->remember_token);
        
                        return response()->json(['status' => true, 'token' => $token, 'user'=> $sw ], 200);
                    }

                    // If not SW or Participant throw error
                    return response()->json(['status' => false, "message" => 'Please verify login credentials'], 404);
    
                } else {
                    return response()->json(['status' => false, "message" => 'Invalid Password!'], 401);
                }

            }
            else{

                $guardian = Guardian::where('email', $request->email)->first();

                if($guardian && Hash::check($request->password, $guardian->password)){

                    $user = User::where('id', $guardian->user_id)->first();

                    if($user){

                        $user->load('roles');
                        $loginAllowed = false;
                        
                        //check for allowed roles
                        $allowedRoles = explode(',', config('ndis.app_roles_allowed'));
                        
                        foreach($user->roles as $role){
                            if( in_array($role->id, $allowedRoles) ){
                                $loginAllowed = true;
                            }
                        }
                        
                        if(!$loginAllowed){
                            $this->doLogout();
                            return response()->json(['status' => false, "message" => 'UnAuthorised!'], 401);
                        }
                        
                        
                        \Auth::login($user);

                        if( auth()->check() && $user->roles()->get()->contains( config('ndis.participant_role_id') ) ){

                            $token = $user->createToken('NDISCentral')->accessToken;

                            $participant = $user->participant;
                            $participant->is_guardian = true;
    
                            // pr($participant, 1);
                            unset($participant->id);
                            unset($participant->password);
                            unset($participant->remember_token);
                            
                            return response()->json(['status' => true, 'token' => $token, 'user'=> $participant ], 200);

                        }
                        else{
                            return response()->json(['status' => false, "message" => 'Please verify login credentials'], 404);
                        }

                    }

                }else{
                    return response()->json(['status' => false, "message" => 'Please verify login credentials'], 404);
                }

            }

        }
        catch(ModelNotFoundException $e){
            return reportAndRespond( $e,  400);
        }
        catch(Exception $exception) {
            return reportAndRespond( $exception,  401);
        }
    }

    private function doLogout(){
        try{
            if (auth()->check()) {
                $accessToken = auth()->user()->token();
                if($accessToken){
                    auth()->user()->OAuthAcessToken()->delete();
                    \App\OAuthRefreshTokens::where('access_token_id', $accessToken->id)->update([
                        'revoked' => true
                    ]);
                }
            }
        }
        catch(ModelNotFoundException $e){
            return reportAndRespond( $e,  400);
        }
        catch(Exception $exception) {
            return reportAndRespond( $exception,  401);
        }
    }

    /**
     * Handles Logout Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try{
            if (auth()->check()) {
                $this->doLogout();
                return response()->json(['status' => false, 'success' => true], 200);
            }

            return response()->json(['status' => false, 'error' => 'UnAuthorised'], 401);
        }
        catch(ModelNotFoundException $e){
            return reportAndRespond( $e,  400);
        }
        catch(Exception $exception) {
            return reportAndRespond( $exception,  400);
        }
    }


    /**
     * Update the authenticated user's API token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function regenerateToken(Request $request)
    {
        try{
            $token = Str::random(60);

            // $request->user()->forceFill([
            //     'api_token' => hash('sha256', $token),
            // ])->save();

            return ['status' => false, 'token' => $token];
        }
        catch(Exception $exception) {
            return reportAndRespond( $exception,  400);
        }
        
    }


    
    /**
     * Update the authenticated User.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function update(Request $request)
    {
        
        try{
            $validator = Validator::make($request->all(), [
                'first_name'  => 'required',
                'last_name'   => 'required',
                'email'       => 'required',
                'organisation_id' => 'required',
                'ra_number' =>   'required',
                'renewal_date' => 'required',
            ]);
    
            // $request->input('password');
        
            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()], 401);
            }
            
            auth()->user()->update($request->all());
    
            return response()->json(['status' => true, 'message' => "User updated successfully!"], 200);
        }
        catch(ModelNotFoundException $e){
            return reportAndRespond( $e,  400);
        }
        catch(Exception $exception) {
            return reportAndRespond( $exception,  400);
        }
    }





    
    /**
     * Update the user with Push Token Subscribed
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function subscribe(Request $request)
    {
        
        try{
            $validator = Validator::make($request->all(), [
                'pushToken' => 'required',
                'platform' => 'required'
            ]);
        
            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()], 401);
            }

            // Logging API call to Loggly
            // \Log::critical(  $request->all() );
            // loggly( ['userId'=>auth()->user()->id, 'pushToken'=>$request->pushToken, 'platform'=>$request->platform] );

            auth()->user()->push_token = $request->pushToken;
            auth()->user()->platform = $request->platform;

            auth()->user()->push();

            return response()->json(['status' => true, 'message' => trans('msg.api.push_update') ], 200);

        }
        catch(ModelNotFoundException $e){
            return reportAndRespond( $e,  400);
        }
        catch(Exception $exception) {
            return reportAndRespond( $exception,  401);
        }

    }

    
    /**
     * Get user registration groups
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getRegistrationGroups(Request $request)
    {
        
        try{

            $user = \Auth::user();
            $reg_group = [];

            //participant
            if ( $user->roles()->first()->id == config('ndis.participant_role_id')){
                $allocated_reg_group_funds = ParticipantRegGroups::whereUserId( $user->id )->get();
                
                foreach( $allocated_reg_group_funds as $k=>$v   ){

                    if( $v->reg_group_id ){
                        $item = RegistrationGroup::whereId( $v->reg_group_id )->first();
                        $reg_group[$k]['item_group_id'] = $v->reg_group_id;
                        $reg_group[$k]['item_group_title'] = $item->title;
                        $reg_group[$k]['item_number'] = $item->item_number;
                        $reg_group[$k]['unit'] = $item->unit;
                        $reg_group[$k]['quote_required'] = $item->quote_required;
                        $reg_group[$k]['price_limit'] = $item->price_limit;
                    }
                    
                    $reg_group[$k]['item_id'] = $v->reg_item_id;
                    $reg_group[$k]['item_title'] = $v->reg_item_id ? RegistrationGroup::whereId( $v->reg_item_id )->pluck('title')[0] : null;
    
    
                    $reg_group[$k]['budget'] = $v->budget;
                    $reg_group[$k]['balance'] = $v->anual_funds_balance;
    
                    // dump( RegistrationGroup::whereId( $v->reg_group_id )->pluck('title')[0]);
                }

            }

            //supportworker
            if ( $user->roles()->first()->id == config('ndis.support_worker_role_id')){

                $sw = \App\UserRegGroup::whereUserId( $user->id )->get();
                foreach( $sw as $k=>$v   ){

                    if( $v->reg_group_id ){
                        $item = RegistrationGroup::whereId( $v->reg_group_id )->first();
                        $reg_group[$k]['item_group_id'] = $v->reg_group_id;
                        $reg_group[$k]['item_group_title'] = $item->title;
                        $reg_group[$k]['item_number'] = $item->item_number;
                        $reg_group[$k]['unit'] = $item->unit;
                        $reg_group[$k]['quote_required'] = $item->quote_required;
                        $reg_group[$k]['price_limit'] = $item->price_limit;
                    }

                }
            }
            
            // dd($allocated_reg_group_funds->toArray());
            // dd($reg_group);

            return response()->json([
                                        'status'=>true,                    
                                        'registration_groups'=> $reg_group,
                                    ],
                                200);

        }
        catch(ModelNotFoundException $e){
            return reportAndRespond( $e,  400);
        }
        catch(Exception $exception) {
            return reportAndRespond( $exception,  401);
        }

    }




}
