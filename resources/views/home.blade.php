@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                    <div class="panel-body">
                        <h2>Welcome, {{Auth::user()->name}}</h2>
                        <div class="row">
                            <div class="col-md-12">
                                Click on a button below to access the application.
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <form autocomplete="off" class="interactiveSearch ">
                                    <input type="text" name="search" id="homeSearch" class="col-md-12 col-xs-12 form-control" placeholder="Name of app..."/>
                                </form>
                            </div>
                            &nbsp;
                        </div>
                        <div class="row">
                            @foreach(Auth::user()->isAdmin() ? App\Group::all() : Auth::user()->groups as $group)
                                    <div class="col-md-4 col-xs-12 apps">
                                        <a href={{route($group->route_prefix.'.index')}} class="appButton">
                                            <div class="col-md-11 btn btn-primary col-xs-12">
                                            {{$group->name}}
                                            </div>
                                        </a>
                                    </div>
                            @endforeach
                        </div>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/home.js') }}"></script>
@endsection
