<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    protected function sendFailedLoginResponse(Request $request)
    {

        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ])->redirectTo("/login");

        // return redirect('/login')
        //     ->withInput($request->only($this->username(), 'remember'))
        //     ->withErrors([
        //         $this->username() => Lang::get('auth.failed'),
        //     ]);
    }


    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);

        $user = \App\User::where('email', $request->input('email'))->first();

        $collection  = collect([config('ndis.provider_role_id'), config('ndis.admin_role_id')]);
        
        if( $user && ! $collection->contains($user->roles()->pluck('id')->first()) ){
            return $this->sendFailedLoginResponse($request);
        }

    }

}
