

@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Users</div>
            <div class="container">
<h1>User Listing</h1>
<p><a href="{{route('users.create')}}" class="btn btn-success">Add a new user</a></p>

    @if(isset($users))
    <table class="table-bordered">
        <thead>
        <tr>
            <th>Username</th>
            <th>E-mail</th>
            <th>Name</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
            @foreach($users as $user)
            <tr>
                <td>
                    {{$user->username}}
                </td>
                <td>
                    {{$user->email}}
                </td>
                <td>
                    {{$user->name}}
                </td>

                <td>
                    <a href="{{route('users.edit', $user->id)}}" class="btn btn-info">Edit</a>
                </td>
                <td>
                    <form method="post" action="{{route('users.destroy', $user->id)}}"
                          onsubmit="return ConfirmDelete()">
                        {{csrf_field()}}
                        <input type="hidden" id="_method" name="_method" value="delete">
                        <button type="submit" class="btn btn-danger" style="margin-top:15px">Delete</button>
                    </form>

                </td>
            </tr>
                @endforeach
    </table>
    {{$users->links()}}
        @else
            <p>There are currently no funding opportunities available.</p>
        @endif
        </div></div></div></div>

<script>

    function ConfirmDelete()
    {
        var x = confirm("Are you sure you want to delete this record?");
        if (x)
            return true;
        else
            return false;
    }

</script>

@endsection

