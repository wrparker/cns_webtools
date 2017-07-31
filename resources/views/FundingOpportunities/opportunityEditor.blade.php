@extends('layouts.app')

@section('content')

    {{--get route prefix.--}}
    <?php $route = \App\Group::find($gid)->route_prefix ?>

    <div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">Funding Opportunities</div>

        <div class="panel-body">
            <p><a href="{{route($route.'.index')}}" > << Opportunity List</a></p>
            @if(isset($funding_opportunity)) {{--Update Form or Creation--}}
                <form method="post" action="{{route($route.'.update', $funding_opportunity->id)}}" >
                {{ method_field('PUT') }}
            @else
                <form method="post" action="{{route($route.'.store')}}" >
            @endif
            {{csrf_field()}}

        <div class="form-group">
            <label for="name">Opportunity Name</label>
            <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder=""
                @if(isset($funding_opportunity)) value="{{$funding_opportunity->name}}" @endif
            value="{{old('name')}}"/>
            <small id="nameHelp" class="form-text text-muted">Name of opportunity</small>
        </div>

        <div class="form-group">
            <label for="visible">Visibility:</label>
        <select class="visible colorchanger" name="visible" id="visible" style="background-color:greenyellow">
            <option selected value="1" style="background-color:greenyellow">Visible</option>
            <option value="0" style="background-color:orangered"
                    @if(isset($funding_opportunity)&&$funding_opportunity->visible == 0) selected @endif>Hidden</option>
        </select>
            <small id="visibleHelp" class="form-text text-muted">Controls whether displayed</small>
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select class="status colorchanger" name="status" id="status" style="background-color:greenyellow">
                <option selected value="1" style="background-color:greenyellow">Open</option>
                <option value="0" style="background-color:orangered"
                        @if(isset($funding_opportunity)&&$funding_opportunity->status == 0) selected @endif>Closed/Recurring</option>
            </select>
        </div>

        <div class="form-group">
            <label for="limited_submission">Limited Submission?</label>
            <select class="limited_submission" name="limited_submission" id="limited_submission">
                <option selected value="1">Yes</option>
                <option value="0"
                        @if(isset($funding_opportunity)&&$funding_opportunity->limited_submission == 0) selected @endif>No</option>
            </select>
        </div>

        <div class="form-group">
            <label for="agency">Funding Agency:</label>
            <input type="text" class="form-control" name="funding_type" id="funding_type" aria-describedby="agency" placeholder=""
                   @if(isset($funding_opportunity)) value="{{$funding_opportunity->agency}}"
                   @else value="{{old('agency')}}" @endif />
            <small id="agency" class="form-text text-muted">The funding agency supporting the grant (e.x. NIH, NSF, etc..)</small>
        </div>

        <div class="form-group">
            <label for="funding_type">Funding Type:</label>
            <input type="text" class="form-control" name="funding_type" id="funding_type" aria-describedby="funding_type" placeholder=""
                   @if(isset($funding_opportunity)) value="{{$funding_opportunity->funding_type}}"
                   @else value="{{old('funding_type')}}" @endif />
            <small id="funding_type" class="form-text text-muted">Funding Type</small>
        </div>

        <div class="form-group">
            <label for="link_external">External Documentation Link</label>
            <input type="text" class="form-control" name="link_external" id="link_external" aria-describedby="link_externalHelp" placeholder="https://example.com"
                   @if(isset($funding_opportunity)) value="{{$funding_opportunity->link_external}}"
                   @else value="{{old('link_external')}}" @endif />
            <small id="link_externalHelp" class="form-text text-muted">Funding Agency Documentation (not required)</small>
        </div>
        <div class="form-group">
            <label for="link_internal">Internal (UT shared Box) Documentation Link</label>
            <input type="text" class="form-control" name="link_internal" id="link_internal" aria-describedby="link_internalHelp" placeholder="https://utexas.apps.box.com/...."
                   @if(isset($funding_opportunity)) value="{{$funding_opportunity->link_internal}}"
                   @else value="{{old('link_internal')}}" @endif />
            <small id="link_internalHelp" class="form-text text-muted">UT box Link, or UT webpage, etc (not required)</small>
        </div>

        <div class="form-group">
            <label for="announced">Announced</label>
            <input class="form-control datepick" id="announced" name="announced" placeholder="MM/DD/YYYY" type="text"
                   @if(isset($funding_opportunity)) value="{{$funding_opportunity->announced}}"
                   @else value="{{old('announced')}}" @endif />
            <span class="glyphicon glyphicon-calendar"></span>
            <small id="announcedHelp" class="form-text text-muted">Announcement Date</small>

        </div>

        <div class="form-group">
            <label for="sponsor_deadline">Sponsor Deadline</label>
            <input type="text" class="form-control datepick" name="sponsor_deadline" id="sponsor_deadline" aria-describedby="sponsor_deadlineHelp" placeholder="MM/DD/YYYY"
                   @if(isset($funding_opportunity)) value="{{$funding_opportunity->sponsor_deadline}}"
                   @else value="{{old('sponsor_deadline')}}" @endif />
            <span class="glyphicon glyphicon-calendar"></span>
            <small id="sponsor_deadlineHelp" class="form-text text-muted">Sponsor Deadline Date</small>
        </div>

        <div class="form-group">
            <label for="internal_deadline">Internal Deadline</label>
            <input type="text" class="form-control datepick" name="internal_deadline" id="internal_deadline" aria-describedby="internal_deadlineHelp" placeholder="MM/DD/YYYY"
                   @if(isset($funding_opportunity)) value="{{$funding_opportunity->internal_deadline}}"
                   @else value="{{old('internal_deadline')}}" @endif />
            <span class="glyphicon glyphicon-calendar"></span>
            <small id="internal_deadlineHelp" class="form-text text-muted">Internal Deadline Date</small>
        </div>
                @if(isset($funding_opportunity)) {{--Update Form or Creation--}}
                    <button type="submit" class="btn btn-primary" id="createSubmitButton">Edit Opportunity</button>
                @else
                    <button type="submit" class="btn btn-primary" id="createSubmitButton">Create Opportunity</button>
                @endif
                    <a href="{{route($route.'.index')}}" class="btn btn-primary" id="createSubmitButton">Cancel</a>

    </form>
                        @if(isset($funding_opportunity))
                         <form method="post" action="{{route($route.'.destroy', $funding_opportunity->id)}}"
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
    <script type="text/javascript" src="{{ asset('js/funding-opportunities.js') }}"></script>
@endsection

