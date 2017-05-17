<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Classes\LDAP_authenticator;


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

    use RegistersUsers;

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
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {


        Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        }, 'Spaces are not allowed in :attribute.');

        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'username' => 'required|min:3|unique:users|without_spaces',
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator_LDAP(array $data)
    {


        Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        }, 'Spaces are not allowed in :attribute.');

        return Validator::make($data, [
            'username' => 'required|min:3|unique:users|without_spaces',
        ]);
    }



    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'username' => $data['username'],
            'enabled' => isset($data['enabled']) ? 1 : 0,
            'ldap_user' => 0
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create_LDAP(array $data)
    {
        $ldap_UIN = LDAP_authenticator::LDAPEID2UIN($data['username']);
        if($ldap_UIN !== false){
            $info = LDAP_authenticator::LDAPGetUserInfoForUIN($ldap_UIN);
            return User::create([
                'name' =>$info[LDAP_authenticator::LDAP_USER_NAME_DISPLAY],
                'email' =>$info[LDAP_authenticator::LDAP_USER_EMAIL],
                'username' => $info[LDAP_authenticator::LDAP_USER_EID],
                'password' => -1,
                'ldap_user' => 1,
                'enabled' => isset($data['enabled']) ? 1 : 0,

            ]);
        }
        else{
            return -1;
        }
    }


    /*
     * Override the username function.
     */
    public function username()
    {
        return 'username';
    }

    public function register(Request $request)
    {
        if ($request->input('ldap_enabled') !== null) {
            $validator = $this->validator_LDAP($request->all());
            if ($validator->fails()) {
                $this->throwValidationException(
                    $request, $validator
                );
            }
            if($this->create_LDAP($request->all()) === -1){  //Using an error code of -1 incase User::create can throw an error.
                $request->session()->flash('error', 'EID not found: ' .$request->input('username'));
            }
            else{
                $request->session()->flash('status', 'Successfully created user with EID: ' .$request->input('username'));
            }
        }
        else {
            $validator = $this->validator($request->all());
            if ($validator->fails()) {
                $this->throwValidationException(
                    $request, $validator
                );
            }
            $this->create($request->all());
        }
        return redirect(route('users.index'));
    }
}
