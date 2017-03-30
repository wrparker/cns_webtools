@extends('layouts.app')

@section('content')

    <div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">Funding Opportunities</div>

        <div class="panel-body">
            @if(isset($fundingOpp)) {{--Update Form or Creation--}}
                <form method="post" action="{{route('FundingOpportunities.update', $fundingOpp->id)}}" >
                {{ method_field('PUT') }}
            @else
                <form method="post" action="{{route('FundingOpportunities.store')}}" >
            @endif
            {{csrf_field()}}

        <div class="form-group">
            <label for="name">Opportunity Name</label>
            <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder=""
                @if(isset($fundingOpp)) value="{{$fundingOpp->name}}" @endif />
            <small id="nameHelp" class="form-text text-muted">Name of opportunity</small>
        </div>

        <div class="form-group">
            <label for="visible">Visibility:</label>
        <select class="visible colorchanger" name="visible" id="visible" style="background-color:greenyellow">
            <option selected value="1" style="background-color:greenyellow">Visible</option>
            <option value="0" style="background-color:orangered"
                    @if(isset($fundingOpp)&&$fundingOpp->visible == 0) selected @endif>Hidden</option>
        </select>
            <small id="visibleHelp" class="form-text text-muted">Controls whether displayed</small>
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select class="status colorchanger" name="status" id="status" style="background-color:greenyellow">
                <option selected value="1" style="background-color:greenyellow">Open</option>
                <option value="0" style="background-color:orangered"
                        @if(isset($fundingOpp)&&$fundingOpp->status == 0) selected @endif
                >Closed/Recurring</option>
            </select>
        </div>

        <div class="form-group">
            <label for="limited_submission">Limited Submission?</label>
            <select class="limited_submission" name="limited_submission" id="limited_submission">
                <option selected value="1">Yes</option>
                <option value="0"
                        @if(isset($fundingOpp)&&$fundingOpp->limited_submission == 0) selected @endif>No</option>
            </select>
        </div>



        <div class="form-group">
            <label for="funding_type">Funding Type:</label>
            <input type="text" class="form-control" name="funding_type" id="funding_type" aria-describedby="funding_type" placeholder=""
                   @if(isset($fundingOpp)) value="{{$fundingOpp->funding_type}}" @endif />
            <small id="funding_type" class="form-text text-muted">Funding Type</small>
        </div>

        <div class="form-group">
            <label for="link_external">External Documentation Link</label>
            <input type="text" class="form-control" name="link_external" id="link_external" aria-describedby="link_externalHelp" placeholder=""
                   @if(isset($fundingOpp)) value="{{$fundingOpp->link_external}}" @endif />
            <small id="link_externalHelp" class="form-text text-muted">Funding Agency Documentation</small>
        </div>
        <div class="form-group">
            <label for="link_internal">Internal (UT shared Box) Documentation Link</label>
            <input type="text" class="form-control" name="link_internal" id="link_internal" aria-describedby="link_internalHelp" placeholder=""
                   @if(isset($fundingOpp)) value="{{$fundingOpp->link_internal}}" @endif />
            <small id="link_internalHelp" class="form-text text-muted">UT box Link, or UT webpage, etc...</small>
        </div>

        <div class="form-group">
            <label for="announced">Announced</label>
            <input class="form-control datepick" id="announced" name="announced" placeholder="MM/DD/YYYY" type="text"
                   @if(isset($fundingOpp)) value="{{$fundingOpp->announced}}" @endif />
            <small id="announcedHelp" class="form-text text-muted">UT box Link, or UT webpage, etc...</small>
            <span class="glyphicon glyphicon-calendar"></span>
        </div>

        <div class="form-group">
            <label for="sponsor_deadline">Sponsor Deadline</label>
            <input type="text" class="form-control datepick" name="sponsor_deadline" id="sponsor_deadline" aria-describedby="sponsor_deadlineHelp" placeholder="MM/DD/YYYY"
                   @if(isset($fundingOpp)) value="{{$fundingOpp->sponsor_deadline}}" @endif />
            <span class="glyphicon glyphicon-calendar"></span>
            <small id="sponsor_deadlineHelp" class="form-text text-muted">UT box Link, or UT webpage, etc...</small>
        </div>

        <div class="form-group">
            <label for="internal_deadline">Internal Deadline</label>
            <input type="text" class="form-control datepick" name="internal_deadline" id="internal_deadline" aria-describedby="internal_deadlineHelp" placeholder="MM/DD/YYYY"
                   @if(isset($fundingOpp)) value="{{$fundingOpp->internal_deadline}}" @endif />
            <span class="glyphicon glyphicon-calendar"></span>
            <small id="internal_deadlineHelp" class="form-text text-muted">UT box Link, or UT webpage, etc...</small>
        </div>
                @if(isset($fundingOpp)) {{--Update Form or Creation--}}
                    <button type="submit" class="btn btn-primary" id="createSubmitButton">Edit Opportunity</button>
                @else
                    <button type="submit" class="btn btn-primary" id="createSubmitButton">Create Opportunity</button>
                @endif
                    <a href="{{route('FundingOpportunities.index')}}" class="btn btn-primary" id="createSubmitButton">Cancel</a>

    </form>
    </div>
    </div>
    </div>
    <script type="text/javascript">
        $( document ).ready(function() {
            $('button[type=submit]').click(function() {
                $(this).attr('disabled', 'disabled');
                $(this).text("Sending...");
                $(this).parents('form').submit()
            });
            //init
                var color = $('.colorchanger');
                var state =color.val();
                if(state == "0"){
                    color.css('background-color', 'orangered');
                }
                else{
                    color.css('background-color', 'greenyellow');
                }



            $('.colorchanger').change(function() {
               var state =$(this).val();
               if(state == "0"){
                   $(this).css('background-color', 'orangered');
               }
               else{
                   $(this).css('background-color', 'greenyellow');
               }
            });


        });
    </script>
@endsection

