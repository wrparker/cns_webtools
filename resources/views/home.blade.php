@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                    <div class="panel-body">
                        <h2>Welcome, {{Auth::user()->name}}</h2>
                        <?php $user = Auth::user(); ?>
                        You are a member of:
                        @foreach ($user->groups as $group)
                            <p>{{$group->name}}</p>
                        @endforeach
                </div>
            </div>
        </div>
    </div>


</div>
@endsection
