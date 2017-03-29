@extends('layouts.app')

@section('content')
    <div class="container">
    <form method="post" action="{{route('FundingOpportunities.store')}}" >
        {{csrf_field()}}
        <div class="form-group">
            <label for="name">Opportunity Name</label>
            <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder="">
            <small id="nameHelp" class="form-text text-muted">Name of opportunity</small>
        </div>

        <div class="form-group">
            <label for="visible">Visibility:</label>
        <select class="visible colorchanger" name="visible" id="visible" style="background-color:greenyellow">
            <option selected value="1" style="background-color:greenyellow">Visible</option>
            <option value="0" style="background-color:orangered">Hidden</option>
        </select>
            <small id="visibleHelp" class="form-text text-muted">Controls whether displayed</small>
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select class="status colorchanger" name="status" id="status" style="background-color:greenyellow">
                <option selected value="1" style="background-color:greenyellow">Open</option>
                <option value="0" style="background-color:orangered">Closed/Recurring</option>
            </select>
        </div>

        <div class="form-group">
            <label for="limited_submission">Limited Submission?</label>
            <select class="limited_submission" name="limited_submission" id="limited_submission">
                <option selected value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>



        <div class="form-group">
            <label for="funding_type">Funding Type:</label>
            <input type="text" class="form-control" name="funding_type" id="funding_type" aria-describedby="funding_type" placeholder="">
            <small id="funding_type" class="form-text text-muted">Funding Type</small>
        </div>

        <div class="form-group">
            <label for="link_external">External Documentation Link</label>
            <input type="text" class="form-control" name="link_external" id="link_external" aria-describedby="link_externalHelp" placeholder="">
            <small id="link_externalHelp" class="form-text text-muted">Funding Agency Documentation</small>
        </div>
        <div class="form-group">
            <label for="link_internal">Internal (UT shared Box) Documentation Link</label>
            <input type="text" class="form-control" name="link_internal" id="link_internal" aria-describedby="link_internalHelp" placeholder="">
            <small id="link_internalHelp" class="form-text text-muted">UT box Link, or UT webpage, etc...</small>
        </div>

        <div class="form-group">
            <label for="announced">Announced</label>
            <input class="form-control datepick" id="announced" name="announced" placeholder="MM/DD/YYYY" type="text"/>
            <small id="announcedHelp" class="form-text text-muted">UT box Link, or UT webpage, etc...</small>
            <span class="glyphicon glyphicon-calendar"></span>
        </div>

        <div class="form-group">
            <label for="sponsor_deadline">Sponsor Deadline</label>
            <input type="text" class="form-control datepick" name="sponsor_deadline" id="sponsor_deadline" aria-describedby="sponsor_deadlineHelp" placeholder="MM/DD/YYYY">
            <span class="glyphicon glyphicon-calendar"></span>
            <small id="sponsor_deadlineHelp" class="form-text text-muted">UT box Link, or UT webpage, etc...</small>
        </div>

        <div class="form-group">
            <label for="internal_deadline">Internal Deadline</label>
            <input type="text" class="form-control datepick" name="internal_deadline" id="internal_deadline" aria-describedby="internal_deadlineHelp" placeholder="MM/DD/YYYY">
            <span class="glyphicon glyphicon-calendar"></span>
            <small id="internal_deadlineHelp" class="form-text text-muted">UT box Link, or UT webpage, etc...</small>
        </div>

        <button type="submit" class="btn btn-primary" id="createSubmitButton">Create Opportunity</button>
    </form>
    </div>
    <script type="text/javascript">
        $( document ).ready(function() {
            $('button[type=submit]').click(function() {
                $(this).attr('disabled', 'disabled');
                $(this).text("Sending...");
                $(this).parents('form').submit()
            })

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

