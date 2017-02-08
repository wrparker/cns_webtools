@extends('layout')

@section('content')
    <form method="post" action="{{URL::to('FundingOpportunityTypes')}}" >
        {{csrf_field()}}
        <div class="form-group">
            <label for="fundingType">Opportunity Type</label>
            <input type="text" class="form-control" name="fundingType" id="fundingType" aria-describedby="fundingTypeHelp" placeholder="">
            <small id="fundingTypeHelp" class="form-text text-muted">How the funding opportunity will be identified.</small>
        </div>
        <button type="submit" class="btn btn-primary" id="createSubmitButton">Create Type</button>
    </form>
    <script type="text/javascript">
        $( document ).ready(function() {
            $('button[type=submit]').click(function() {
                $(this).attr('disabled', 'disabled');
                $(this).text("Sending...");
                $(this).parents('form').submit()
            })
        });
    </script>
@endsection

