<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $currentUser = User::findOrFail(Auth::id());
        if($currentUser->isAdmin()) {
            $users = User::orderBy('name')->paginate(25);
            return view('users.listUsers', compact('users'));
        }
        else{
            $request->session()->flash('error', 'You are not authorized to view the User List');
           return redirect('/');
        }
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $currentUser = User::findOrFail(Auth::id());
        if($currentUser->isAdmin()) {
            return view('auth.register');
        }
        else{
            $request->session()->flash('error', 'You are not authorized to create users');
            return redirect('/');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate request
        dd($request->input('ldap_enabled'));

        if($request->input('ldap_enabled') === true){
            dd($request->input('ldap_enabled'));
        }
        $this->validate($request, [
            'name' => 'required',
            'visible' => 'required|boolean',
            'status' => 'required|boolean',
            'limited_submission' => 'required|boolean',
            'announced' => 'required|date_format:m/d/Y',
            'sponsor_deadline'=> 'required|date_format:m/d/Y',
            'internal_deadline'=> 'required|date_format:m/d/Y',
            'internal_deadline'=> 'required|date_format:m/d/Y',
            'funding_type'=> 'required',  //Uncomment when fixed...
        ]);



        $user = new User();

        //populate
        /* $fundingOpp->name = $request->input('name');
         $fundingOpp->timestamps;
         $fundingOpp->announced = $request->input('announced');
         $fundingOpp->sponsor_deadline = $request->input('sponsor_deadline');
         $fundingOpp->internal_deadline = $request->input('internal_deadline');
         $fundingOpp->link_internal = $request->input('link_internal');
         $fundingOpp->link_external = $request->input('link_external');
         $fundingOpp->visible = $request->input('visible');
         $fundingOpp->limited_submission = $request->input('limited_submission');
         $fundingOpp->status = $request->input('status');
         $fundingOpp->user = -1;
         $fundingOpp->funding_type = $request->input('funding_type');
         $fundingOpp->timestamps;
        */
        //save.

        $user->save();
        $request->session()->flash('status', 'Successfully created user ' .$user->username);
        return redirect(route('FundingOpportunities.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, Request $request)
    {
        //
        $currentUser = User::findOrFail(Auth::id());
        if($currentUser->id == $user->id || $currentUser->isAdmin()){ //userid= 1 is super user
            return view('auth.register', compact('user'));
        }
        else{
            $request->session()->flash('error', 'You are not authorized to edit profile: ' . $user->name);
            return redirect('/');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $currentUser = User::findOrFail(Auth::id());
        if ($currentUser->id == $user->id || $currentUser->isAdmin() && $user->ldap_enabled === false) {
            $validRules = [
                'name' => 'required|max:255',
            ];
            if ($request->input('email') != $user->email) {
                $validRules['email'] = 'required|email|max:255|unique:users';
            }

            if ($request->input('password') != null || $request->input('old_password') != null) {
                $validRules['password'] = 'min:6|confirmed';
            }
            $this->validate($request, $validRules);

            //Other stuff
            $user->name = $request->input('name');
            $user->email = $request->input('email');

            if (array_key_exists('password', $validRules)) {
                if (Hash::make($request->input('old_password')) == $user->password) {
                    $user->password = Hash::make($request->input('password'));
                } else {
                    $request->session()->flash('error', 'Bad Old Password -- Password not updated.' . $user->name);
                }
            }
            $user->save();

            //Only allow super users to make user group changes.
            if($currentUser->isAdmin()){
                if($request->input('groups') === null){  //Detach it all if there is nothing there.
                    $user->groups()->detach();
                }
                else{
                    $user->groups()->sync($request->input('groups'));
                }
            }

            $request->session()->flash('status', 'Successfully updated user: ' . $user->name);
            return $currentUser->isAdmin() ? redirect(route('users.edit', $user->id)) : redirect('/');
        }
        else if ($user->ldap_enabled){
            echo "ROUTINE TO UPDATE LDAP USER HERE.";
        }
        else{
            $request->session()->flash('error', 'You are not authorized to edit profile: ' . $user->name);
            return redirect('/');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Request $request)
    {

        $currentUser = User::findOrFail(Auth::id());
        if($currentUser->isAdmin()) { //userid= 1 is super user
            //delete user
            $user->delete();
        }
        else{
            $request->session()->flash('error', 'You are not authorized to delete users');
            return redirect('/');
        }
        //
    }

}
