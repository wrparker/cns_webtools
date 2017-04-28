<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;



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
       else if(AUTH_LDAP_ENABLED === true && $local_lookup[0]->ldap_user === true){
            //#2.1 before we auth with ldap, lets make sure that ldap_connect is a function we can actually call!
           if(function_exists('ldap_connect') === false){
                $request->session()->flash('error', Lang::get('auth.ldap_fail'));
                return redirect::route('login')->withInput();
            }
            //2.2: See if the EID is in the system before trying to authenticate....
           else if (LDAP_authenticator::LDAPAuthenticateEIDPassword(trim($request->input('username')), $request->input('password'))) {
                   $request->session()->flash('WELCOME BACK WOOHOO');
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

class LDAP_authenticator{

    //This is prety specific for UT... it can be adopted into something else if needed.

// ----------------------------------------------------------------------
// Keys for the associative array returned by LDAPGetUserInfoForUIN()
// ----------------------------------------------------------------------
const LDAP_USER_NAME_DISPLAY = 'nameForDisplay';
const LDAP_USER_NAME_SORT  = 'nameSortOrder';
const LDAP_USER_EMAIL = 'email';
const LDAP_USER_EID = 'eid';
// ----------------------------------------------------------------------

// ----------------------------------------------------------------------
// FUNCTION:    LDAPAuthenticateEIDPassword
//
// Authenticate an EID/password pair
//
// GIVEN:       (string)    The EID to authenticate
//
//              (string)    The password to check
//
// RETURNS:     (Boolean)   TRUE if the pair is valid; FALSE otherwise
// ----------------------------------------------------------------------
public static function LDAPAuthenticateEIDPassword ( $eid, $password )
{
    $authenticated = FALSE;

// Before we even mess with LDAP, ensure that the EID looks reasonable
// (non-empty, alphanumeric, proper length) and that the password isn't blank.
    $eid  = strtolower ( trim ( $eid ) );
    $password =   trim ( $password   );
    if  (  ( $password != '' ) && ( strlen ( $eid ) < 16 )
        && ( preg_match ( '/^[a-zA-Z0-9]+$/', $eid ) === 1 ) )
    {
        // Connect to the TED (not BILL) LDAP server:
        $ldapConn = @ldap_connect ( env('LDAP_HOST'), env('LDAP_PORT'));

        if  ( $ldapConn !== FALSE )
        {
            // First, we need to authenticate using a Service-Level EID (tm),
            // which will give us access to the TED records.  Afterward, we
            // will authenticate the user.

            // Set up variables that will be used for LDAP authentication:

            // The User Distinguished Name contains the EID that is connecting
            // to TED.  In this case, it is a Service-Level EID, with mighty
            // powers.
            $userDistinguishedName = 'uid=' . env('LDAP_USERNAME') . ',ou=services';

            // The Distinguished Name used for binding to LDAP consists of
            // the User Distinguised Name followed by the Base Distinguised
            // Name.
            $ldapUserName = $userDistinguishedName . ',' . env('LDAP_BDN');

            // Now attempt to bind to our LDAP connection:
            if  (@ldap_bind ( $ldapConn, $ldapUserName, env('LDAP_PASSWORD') ) )
            {
                // If the bind was successful, we will next attempt another
                // bind, this time using the user-submitted EID and password.
                // This second bind will fail if the EID/password combination
                // was bogus or if the EID is blocked by ITS from logging in.
                //
                // Doing it this way is the recommended practice per
                // https://www.utexas.edu/its/help/ted/683 .
                // NOTE 2016-10-31:  That document seems to be gone now, sorry!
                // But trust me, it was the recommended practice.  It's all good.

                // Perform an LDAP search on the EID provided.  Searches can
                // also be performed on other TED fields; a list of all fields
                // is found at:  https://www.utexas.edu/its/help/ted/1064
                // NOTE 2016-10-31:  That one's gone now, too.  Sorry again!
                $search = @ldap_search ( $ldapConn, env('LDAP_BDN'),
                    'utexasEduPersonEid=' . $eid );

                // Retrieve the entries from the search result.  This can give
                // us various useful stuff such as the user's name, etc.; but
                // the part that concerns us here is $entries [ 0 ][ 'dn' ],
                // which will contain the LDAP username of the EID, if it exists.
                $entries = @ldap_get_entries ( $ldapConn, $search );

                // Assuming that we got a record back, continue:
                if  (    is_array ( $entries ) && isset ( $entries [ 'count' ] )
                    && ( $entries [ 'count'  ] == 1 ) )
                {
                    // Attempt to bind using the provided EID and password.
                    $authenticated = @ldap_bind ( $ldapConn, $entries [ 0 ][ 'dn' ], $password );
                }
            }

            // Close our LDAP session handle and clean up any associated resources:
            @ldap_close ( $ldapConn );
        }
    }

    return $authenticated;
}
// ----------------------------------------------------------------------



// ----------------------------------------------------------------------
// FUNCTION:    LDAPEID2UIN
//
// Find the UIN associated with a given EID.  This will search previously
// used EIDs as well as currently active ones, in case a user has changed
// his or her EID at some point in the past.
//
// GIVEN:       (string)    The EID to look up.
//
// RETURNS:     (string)    The associated UIN; or FALSE if the lookup
//                          failed (LDAP error or no such EID).
// ----------------------------------------------------------------------
public static function LDAPEID2UIN ( $eid )
{
//
// Most of this code is very similar to the code for
// LDAPAuthenticateEIDPassword(), above; see that function
// for more detailed commentary on what we are doing here.
//
    $uin   = FALSE;
    $eid   = strtolower ( trim ( $eid ) );
    if  (  ( strlen ( $eid ) < 16 )
        && ( preg_match ( '/^[a-zA-Z0-9]+$/', $eid ) === 1 ) )
    {
        $ldapConn = @ldap_connect ( env('LDAP_HOST'), env('LDAP_PORT'));

        if  ( $ldapConn !== FALSE )
        {
            $userDistinguishedName = 'uid=' . env('LDAP_USERNAME') . ',ou=services';
            $ldapUserName = $userDistinguishedName . ',' . env('LDAP_BDN');
            if  ( @ldap_bind ( $ldapConn, $ldapUserName, env('LDAP_PASSWORD') ) )
            {
                // Match against either the current EID or any previously used EID:
                $search = @ldap_search ( $ldapConn, env('LDAP_BDN'),
                    '(| (utexasEduPersonEid='      . $eid
                    .') (utexasEduPersonPriorEid=' . $eid . ') )' );

                $entries = @ldap_get_entries ( $ldapConn, $search );
                if  (    is_array ( $entries )
                    && isset      ( $entries [ 'count' ] )
                    && ( $entries [ 'count'  ] == 1 )
                    && isset      ( $entries [ 0 ][ 'utexasedupersonuin' ] )
                    && is_array   ( $entries [ 0 ][ 'utexasedupersonuin' ] )
                    && ( count    ( $entries [ 0 ][ 'utexasedupersonuin' ] > 0 ) ) )
                    $uin = strtoupper ( trim ( $entries [ 0 ][ 'utexasedupersonuin' ][ 0 ] ) );

            }

            ldap_close ( $ldapConn );
        }
    }

    return $uin;
}
// ----------------------------------------------------------------------


// ----------------------------------------------------------------------
// FUNCTION:    LDAPGetUserInfoForUIN
//
// Look up a user's name and email address, based on his or her UIN.
//
// GIVEN:       (string)    The UIN of the user.
//
// RETURNS:     (array)     An associative array containing the user's
//                          name (in display and sort orders) and email
//                          address, using the LDAP_USER_xxx constants
//                          as keys; or FALSE on failure.  Note that
//                          if an array is returned, all keys are
//                          guaranteed to be present, but some values
//                          may be empty strings (if no corresponding
//                          value is returned by the LDAP service).
// ----------------------------------------------------------------------
public static function LDAPGetUserInfoForUIN ( $uin )
{
//
// Most of this code is very similar to the code for
// LDAPAuthenticateEIDPassword() and LDAPEID2UIN(), above; see those
// functions for more detailed commentary on what we are doing here.
//
    $info     = array ();
    $ldapConn = @ldap_connect ( env('LDAP_HOST'), env('LDAP_PORT') );
    if  ( $ldapConn !== FALSE )
    {
        $userDistinguishedName = 'uid=' . env('LDAP_USERNAME') . ',ou=services';
        $ldapUserName = $userDistinguishedName . ',' .env('LDAP_BDN');
        if  ( @ldap_bind ( $ldapConn, $ldapUserName, env('_LDAP_SLPASS') ) )
        {
            $search = @ldap_search ( $ldapConn, env('LDAP_BDN'),
                '(| (utexasEduPersonUin='      . $uin
                .') (utexasEduPersonPriorUin=' . $uin . ') )' );

            $entries = @ldap_get_entries ( $ldapConn, $search );

            if  (      is_array ( $entries )
                &&     isset    ( $entries [ 'count' ] )
                &&   ( $entries [ 'count'  ] ==   1  ) )
            {
                $info [ self::LDAP_USER_NAME_DISPLAY ] =
                    (     isset ( $entries [ 0 ][ 'displayname' ] )
                        && is_array ( $entries [ 0 ][ 'displayname' ] )
                        && (  count ( $entries [ 0 ][ 'displayname' ] ) > 0 ) )
                        ?      trim ( $entries [ 0 ][ 'displayname' ][    0 ] )
                        :      '';

                $info [ self::LDAP_USER_NAME_SORT    ] =
                    (     isset ( $entries [ 0 ][ 'utexasedupersonsortname' ] )
                        && is_array ( $entries [ 0 ][ 'utexasedupersonsortname' ] )
                        && (  count ( $entries [ 0 ][ 'utexasedupersonsortname' ] ) > 0 ) )
                        ?      trim ( $entries [ 0 ][ 'utexasedupersonsortname' ][    0 ] )
                        :     $info [ self::LDAP_USER_NAME_DISPLAY ];

                $info [ self::LDAP_USER_EMAIL ] =
                    (     isset ( $entries [ 0 ][ 'mail' ] )
                        && is_array ( $entries [ 0 ][ 'mail' ] )
                        && (  count ( $entries [ 0 ][ 'mail' ] ) > 0 ) )
                        ?      trim ( $entries [ 0 ][ 'mail' ][    0 ] )
                        :      '';

                $info [ self::LDAP_USER_EID ] =
                    (     isset ( $entries [ 0 ][ 'utexasedupersoneid' ] )
                        && is_array ( $entries [ 0 ][ 'utexasedupersoneid' ] )
                        && (  count ( $entries [ 0 ][ 'utexasedupersoneid' ] ) > 0 ) )
                        ?      trim ( $entries [ 0 ][ 'utexasedupersoneid' ][    0 ] )
                        :      '';
            }

        }

        @ldap_close ( $ldapConn );
    }

    return ( count ( $info ) == 0 ) ? FALSE : $info;
}
// ----------------------------------------------------------------------
}
