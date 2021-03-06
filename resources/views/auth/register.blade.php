@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{isset($user) ? 'Edit a User' : 'Register a new User' }}
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST"
                          action="{{ isset($user) ? route('users.update', $user->id) :  route('register') }}">
                        {{ csrf_field() }}
                           @if(isset($user))
                           {{ method_field('PUT') }}
                            @endif

                        @if(isset($user))
                            <a href="{{route('users.index')}}" > << User List</a>
                            <h2>User: {{$user->username}}</h2>
                            <h3> Status: {{$user->ldap_user ? 'LDAP USER' : 'Local Account'}}</h3>
                        @else
                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username" class="col-md-4 control-label">User Name</label>
                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>


                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @if(env('AUTH_LDAP_ENABLED') == 1)
                            <div class="form-group{{ $errors->has('ldap_enabled') ? ' has-error' : '' }}">
                                <label for="ldap_enabled" class="col-md-4 control-label">LDAP/EID Authenticated User?</label>
                                <div class="col-md-6">
                                    <input id="ldap_enabled" name="ldap_enabled" type="checkbox" {{env('AUTH_LDAP_ENABLED') == 1 ?  'checked' : ''}}>
                                    <span class="help-block">If LDAP user you only need to put in an EID on this form under 'User Name'.  Leave rest blank (except for enabled if you want to enable the account).</span>
                                    @if ($errors->has('ldap_enabled'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('ldap_enabled') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif
                        @endif



                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{isset($user) ? $user->name : old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>



                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{isset($user) ? $user->email : old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @if (isset($user) && !$user->ldap_user)
                            <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                                <label for="old_password" class="col-md-4 control-label">Old Password</label>

                                <div class="col-md-6">
                                    <input id="old_password" type="password" class="form-control" name="old_password" >

                                    @if ($errors->has('old_password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('old_password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                        @if(!isset($user) || !$user->ldap_user)
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">{{isset($user) ? 'New Password' :'Password' }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" >

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" {{isset($user) ? '' :'required' }}>
                            </div>
                        </div>
                        @endif

                        @if(Auth::user()->isAdmin())
                        <div class="form-group{{ $errors->has('enabled') ? ' has-error' : '' }}">
                            <label for="enabled" class="col-md-4 control-label">Enabled?</label>
                            <div class="col-md-6">
                                <input id="enabled" name="enabled" type="checkbox" {{isset($user) && $user->enabled ? 'checked': '' }} >
                                <span class="help-block">Disabled users cannot log in.</span>
                                @if ($errors->has('enabled'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('enabled') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @else
                            <div class="col-md-4">User Status</div><div class="col-md-6">{{$user->enabled}}</div>
                        @endif



                        @if (isset($user))
                            @if(Auth::user()->isAdmin())
                                <div class="form-group">
                                    <h3>User Groups</h3>
                                @forelse(App\Group::all() as $group)
                                    <div class="checkbox col-md-4">
                                        <label><input type="checkbox" value="{{$group->id}}" {{isset($user) && $user->groups->contains($group->id) ? "checked" : ""}} name="groups[]">{{$group->name}}</label>
                                    </div>
                                 @empty
                                    <p>There are no user groups!</p>
                                @endforelse
                               </div>
                            @else
                                <h3>You belong to:</h3>
                            <div class="row">
                                @forelse($user->groups as $group)
                                        <div class="col-md-4">{{$group->name}}</div>
                                @empty
                                    <p>You do not belong to any groups!</p>
                                @endforelse
                            </div><p>&nbsp;</p>
                                <p class="col-md-12">Do not see right user group or don't have access to a particular application?
                                    <a href="https://cns.utexas.edu/help">Contact the web team to get access</a>.</p>
                            @endif
                        @endif

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    @if(isset($user))
                                        Edit User
                                    @else
                                        Register User
                                    @endif
                                </button>
                            </div>
                        </div>
                    </form>

                        @if(isset($user) && Auth::user()->isAdmin())
                         <form method="post" action="{{route('users.destroy', $user->id)}}"
                            onsubmit="return ConfirmDelete()">
                             {{csrf_field()}}
                             <input type="hidden" id="_method" name="_method" value="delete">
                             <button type="submit" class="btn btn-danger delete">Delete User</button>
                         </form>
                         @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
    @if(!isset($user))
        <script type="text/javascript" src="{{ asset('js/register-user.js') }}"></script>
    @endif
@endsection

