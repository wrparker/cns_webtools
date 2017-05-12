<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;

use App\Classes\LDAP_authenticator;



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
        $this->middleware('guest', ['except' => 'logout']);
    }

    /*
     * Override the username function.
     */
    public function username()
    {
        return 'username';
    }

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function login(Request $request)
    {

        $local_lookup = \App\User::where('username', trim($request->input('username')))->get();

        if(sizeof($local_lookup) !== 1){
            $request->session()->flash('error', Lang::get('auth.not_registered'));
            return redirect::route('login')->withInput();
        }

        else if($local_lookup[0]->enabled == false){
            $request->session()->flash('error', Lang::get('auth.disabled'));
            return redirect::route('login')->withInput();
        }

        //#1: Attempt Validation with a local only account--should only be the "admin" account.
       else if (Auth::attempt(['username' => $request->input('username'), 'password' => $request->input('password')])) {
            // Authentication passed...
            return redirect()->intended($this->redirectTo);
        }

        //#2 Lets see if LDAP is enabled.  Controlled with globals in web.php
       else if(AUTH_LDAP_ENABLED === true && $local_lookup[0]->ldap_user == true){
            //#2.1 before we auth with ldap, lets make sure that ldap_connect is a function we can actually call!
           if(function_exists('ldap_connect') === false){
                $request->session()->flash('error', Lang::get('auth.ldap_fail'));
                return redirect::route('login')->withInput();
            }
            //2.2: See if the EID is in the system before trying to authenticate....
           else if (LDAP_authenticator::LDAPAuthenticateEIDPassword(trim($request->input('username')), $request->input('password'))) {
                   $request->session()->flash('Login Successful.  Welcome!');
                   return redirect()->intended($this->redirectTo);
               }
               else {
                   $request->session()->flash('error', Lang::get('auth.failed'));
                   return redirect::route('login')->withInput();
               }
           }
        else{
            $request->session()->flash('error', Lang::get('auth.failed'));
            return redirect::route('login')->withInput();
        }
    }

}

