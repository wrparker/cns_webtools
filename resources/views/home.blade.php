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
                        <div class="row">
                            <div class="col-md-12">
                                Click on the following below to acccess the application.
                                <hr>
                            </div>
                        </div>
                        @foreach ($user->groups as $group)
                            <div class="col-md-4">
                                <p>{{$group->name}}</p>
                            </div>
                        @endforeach

                </div>
            </div>
        </div>
    </div>


</div>
@endsection
