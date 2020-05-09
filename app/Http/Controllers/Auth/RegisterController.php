<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Guardian;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Requests\UpdateUserPassword;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use App\Provider;
use App\Documents;

use Notification;
use App\Notifications\ParticipantActive;
use App\Notifications\GuardianActivated;
use App\Notifications\SupportWorkerActive;

use App\Notifications\WelcomeEmail;

use Mail;

use Laravel\Cashier\Billable;




class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, Billable;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // pr($data,1);

        $messages = [
            'email.required' => 'Follow standard email validation rules',
            'organisation_id.required' => 'Follow standards of NDIS Organisation ID',
            'ra_number.required' => 'Follow standards of RA Number',
        ];

        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'business_name' => ['required', 'string', 'max:50'],
            'organisation_id' => ['required', 'integer'],
            'ra_number' => ['required', 'string', 'max:255'],
            'renewal_date' => ['required', 'date'],
            'tnc' => ['required', 'boolean'],
          
        ],$messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // pr($data,1);
         $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'active' => User::ACTIVE
        ]);
        

        if(isset($data['ndis_cert'])){
            //Save Document
            $ndisCert = Documents::saveDoc( $data['ndis_cert'], [
                'title'=>'NDIS Certificate',
                'user_id'=>$user->id,
                'provider_id'=>$user->id,
            ]);
            $ndisCertId = $ndisCert->id;
        }else
            $ndisCertId = null;
        
        
        if( $user->id ){
            Provider::create([
                'user_id' => $user->id,
                'organisation_id' => $data['organisation_id'],
                'ra_number' => $data['ra_number'],
                'business_name' => $data['business_name'],
                'renewal_date' =>  date('Y-m-d', strtotime(str_replace('/', '-', $data['renewal_date']))),
                'ndis_cert' => $ndisCertId
                // 'tnc' => $data['tnc'],
            ]);
            
            DB::table('role_user')->insert(
                ['user_id' =>  $user->id, 'role_id' => 2]
            );

        }

        $user->notify(new WelcomeEmail($user));

        $user->createAsStripeCustomer(); //create stripe customer


        return $user;
    }


    /**
     * @param $token
     */
    public function activate($token = null)
    {
        
        $user = User::where('token', $token)->first();

        if(!$user)
            abort(404);

        if (empty($user)) {
            return redirect()->to('/')
                ->with(['error' => 'Your activation code is either expired or invalid']);
        }

        return view( 'auth.passwords.activate', compact('user') );
        
    }


    /**
     * @param $token
     */
    public function activateUser(UpdateUserPassword $request)
    {

        $token = $request->input('token');

        $user = User::with('UserProvider')->where('token', $token)->first();

        if(!$user)
            abort(404);
        
        $provider = User::find( $user->UserProvider[0]->provider_id );

        User::where('id', $user->id )->update([
                                                'password' => Hash::make($request->input('password')),
                                                'token' => NULL,
                                                'active' => User::ACTIVE,
                                                'email_verified_at' => Carbon::now()
                                            ]);


        if( $user->roles()->get()->contains( config('ndis.participant_role_id') ) )
            $provider->notify(new ParticipantActive($user));

        if( $user->roles()->get()->contains( config('ndis.support_worker_role_id') ) )
            $provider->notify(new SupportWorkerActive($user));

        return view( 'auth.passwords.password_update_success');

    }

    /**
     * @param $token activate participant advocate
     */
    public function activateAdvocate($token = null)
    {
        
        $user = Guardian::where('token', $token)->first();
        
        if(!$user)
            abort(404);

        if (empty($user)) {
            return redirect()->to('/')
                ->with(['error' => 'Your activation code is either expired or invalid']);
        }

        return view( 'auth.passwords.activate_advocate', compact('user') );
        
    }


    /**
     * @param $token
     */
    public function activateAdvocateAccount(UpdateUserPassword $request)
    {

        $token = $request->input('token');

        $guardianRes = Guardian::where('token', $token);
        $guardian = $guardianRes->first();

        if(!$guardian)
            abort(404);

        
        $guardianRes->update([
                                'password' => Hash::make($request->input('password')),
                                'token' => NULL
                            ]);

        $guardian->notify(new GuardianActivated());

        return view( 'auth.passwords.password_update_success');

    }



    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $field = $this->field($request);

        return [
            $field => $request->get($this->username()),
            'password' => $request->get('password'),
            'active' => User::ACTIVE,
        ];
    }

    /**
     * Determine if the request field is email or username.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function field(Request $request)
    {
        $email = $this->username();

        return filter_var($request->get($email), FILTER_VALIDATE_EMAIL) ? $email : 'username';
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $field = $this->field($request);

        $messages = ["{$this->username()}.exists" => 'The account you are trying to login is not activated or it has been disabled.'];

        $this->validate($request, [
            $this->username() => "required|exists:users,{$field},active," . User::ACTIVE,
            'password' => 'required',
        ], $messages);
    }


}
