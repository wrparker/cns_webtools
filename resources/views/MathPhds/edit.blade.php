@extends('layouts.app')

@section('content')

    {{--get route prefix.--}}
    <?php $route = \App\Group::find($gid)->route_prefix ?>

    <div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">Funding Opportunities</div>

        <div class="panel-body">
            <p><a href="{{route($route.'.index')}}" > << Math PhD List</a></p>
            @if(isset($item)) {{--Update Form or Creation--}}
                <form method="post" action="{{route($route.'.update', $item->id)}}" >
                {{ method_field('PUT') }}
            @else
                <form method="post" action="{{route($route.'.store')}}" >
            @endif
            {{csrf_field()}}

        <div class="form-group">
            <label for="lastname">Last Name </label>
            <input type="text" class="form-control" name="lastname" id="lastname" aria-describedby="lastnameHelp" placeholder=""
                @if(isset($item)) value="{{$item->lastname}}"
                    @else value="{{old('lastname')}}" @endif />
            <small id="lastnameHelp" class="form-text text-muted">Last Name of Individual</small>
        </div>
        <div class="form-group">
            <label for="firstname">First Name </label>
            <input type="text" class="form-control" name="firstname" id="firstname" aria-describedby="firstnameHelp" placeholder=""
                   @if(isset($item)) value="{{$item->firstname}}"
                   @else value="{{old('firstname')}}" @endif />
            <small id="firstnameHelp" class="form-text text-muted">First Name of Individual (If you want middle name just append in this field after first name)</small>
        </div>
        <div class="form-group">
            <label for="advisors">Advisors </label>
            <input type="text" class="form-control" name="advisors" id="advisors" aria-describedby="advisorsHelp" placeholder=""
                   @if(isset($item)) value="{{$item->advisors}}"
                   @else value="{{old('advisors')}}" @endif />
            <small id="advisorsHelp" class="form-text text-muted">Comma Separated</small>
        </div>
        <div class="form-group">
            <label for="degree">Degree </label>
            <input type="text" class="form-control" name="degree" id="degree" aria-describedby="degreeHelp" placeholder=""
                   @if(isset($item)) value="{{$item->degree}}"
                   @else value="{{old('degree')}}" @endif />
            <small id="degreeHelp" class="form-text text-muted">Degree earned</small>
        </div>
        <div class="form-group">
            <label for="year">Year </label>
            <input type="text" class="form-control" name="year" id="year" aria-describedby="yearHelp" placeholder=""
                   @if(isset($item)) value="{{$item->year}}"
                   @else value="{{old('year')}}" @endif />
            <small id="yearHelp" class="form-text text-muted">Year graduated</small>
        </div>
        <div class="form-group">
            <label for="Dissertation">Dissertation </label>
            <input type="text" class="form-control" name="dissertation" id="dissertation" aria-describedby="dissertationHelp" placeholder=""
                   @if(isset($item)) value="{{$item->dissertation}}"
                   @else value="{{old('dissertation')}}" @endif />
            <small id="dissertationHelp" class="form-text text-muted">Dissertation Title</small>
        </div>
        <div class="form-group">
            <label for="job1">"Job1" </label>
            <input type="text" class="form-control" name="job1" id="job1" aria-describedby="job1Help" placeholder=""
                   @if(isset($item)) value="{{$item->job1}}"
                   @else value="{{old('job1')}}" @endif />
            <small id="job1Help" class="form-text text-muted">Job1</small>
        </div>
        <div class="form-group">
            <label for="job">Job </label>
            <input type="text" class="form-control" name="job" id="job" aria-describedby="jobHelp" placeholder=""
                   @if(isset($item)) value="{{$item->job}}"
                   @else value="{{old('job')}}" @endif />
            <small id="jobHelp" class="form-text text-muted">Job</small>
        </div>

        <div class="form-group">
            <label for="misc">Misc </label>
            <textarea class="form-control" name="job" id="job" aria-describedby="jobHelp" placeholder=""
                      @if(isset($item)) value="{{$item->misc}}"
                      @else value="{{old('job')}}" @endif > </textarea>
            <small id="jobHelp" class="form-text text-muted">Misc info</small>
        </div>

                @if(isset($item)) {{--Update Form or Creation--}}
                    <button type="submit" class="btn btn-primary" id="createSubmitButton">Edit Math Phd</button>
                @else
                    <button type="submit" class="btn btn-primary" id="createSubmitButton">Create Math Phd</button>
                @endif
                    <a href="{{route($route.'.index')}}" class="btn btn-primary" id="createSubmitButton">Cancel</a>

    </form>
                        @if(isset($item))
                         <form method="post" action="{{route($route.'.destroy', $item->id)}}"
                                  onsubmit="return ConfirmDelete()">
                                {{csrf_field()}}
                                <input type="hidden" id="_method" name="_method" value="delete">
                                <button type="submit" class="btn btn-danger delete">Delete Math Phd</button>
                            </form>
                        @endif
    </div>
    </div>
    </div>
@endsection

@section('javascript')
   <!-- <script type="text/javascript" src="{{ asset('js/funding-opportunities.js') }}"></script> -->
@endsection

