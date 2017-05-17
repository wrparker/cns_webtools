

@extends('layouts.app')


@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">Users</div>
            <div class="container">
                <h1>User Listing</h1>
                <p><a href="{{route('users.create')}}" class="btn btn-success">Add User</a></p>
                <form method="POST" action="{{route('users.index')}}">
                <input type="text" id="search" name="search" placeholder="Search by username/EID"
                @if(isset($search)) value="{{$search}}" @endif  >
                <button type="submit" class="btn search">Go</button>
                </form>
                <table class="table-bordered">
                @if(isset($users))

                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>E-mail</th>
                        <th>Name</th>
                        <th>LDAP User?</th>
                    </tr>
                    </thead>
                @foreach($users as $user)
                <tr>
                    <td>
                        <a href="{{route('users.edit', $user->id)}}" class="list">  {{$user->username}}</a>
                    </td>
                    <td>
                        {{$user->email}}
                    </td>
                    <td>
                        {{$user->name}}
                    </td>
                    <td>
                        {{$user->ldap_user ? 'LDAP' : 'LOCAL'}}
                    </td>
                </tr>
                @endforeach
                </table>
                {{$users->links()}}
        @else
            <p>There are currently no users available.</p>
        @endif
            </div>
        </div>
    </div>
@endsection

