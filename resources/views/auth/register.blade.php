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
                            <h2>User: {{$user->username}}</h2>
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
                        @if (isset($user))
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

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">{{isset($user) ? 'New Password' :'Password' }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" {{isset($user) ? '' :'required' }}>

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
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
