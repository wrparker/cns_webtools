@extends('layouts.app')

@section('content')

    {{--get route prefix.--}}
    <?php $route = \App\Group::find($gid)->route_prefix ?>

    <div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">Funding Opportunities</div>

        <div class="panel-body">
            <p><a href="{{route($route.'.index')}}" > << Opportunity List</a></p>
            @if(isset($item)) {{--Update Form or Creation--}}
                <form method="post" action="{{route($route.'.update', $item->id)}}" >
                {{ method_field('PUT') }}
            @else
                <form method="post" action="{{route($route.'.store')}}" >
            @endif
            {{csrf_field()}}

        <div class="form-group">
            <label for="name">Last Name </label>
            <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder=""
                @if(isset($item)) value="{{$item->name}}" @endif />
            <small id="nameHelp" class="form-text text-muted">Name of opportunity</small>
        </div>

                @if(isset($item)) {{--Update Form or Creation--}}
                    <button type="submit" class="btn btn-primary" id="createSubmitButton">Edit Opportunity</button>
                @else
                    <button type="submit" class="btn btn-primary" id="createSubmitButton">Create Opportunity</button>
                @endif
                    <a href="{{route($route.'.index')}}" class="btn btn-primary" id="createSubmitButton">Cancel</a>

    </form>
                        @if(isset($item))
                         <form method="post" action="{{route($route.'.destroy', $item->id)}}"
                                  onsubmit="return ConfirmDelete()">
                                {{csrf_field()}}
                                <input type="hidden" id="_method" name="_method" value="delete">
                                <button type="submit" class="btn btn-danger delete">Delete Opportunity</button>
                            </form>
                        @endif
    </div>
    </div>
    </div>
@endsection

@section('javascript')
   <!-- <script type="text/javascript" src="{{ asset('js/funding-opportunities.js') }}"></script> -->
@endsection

