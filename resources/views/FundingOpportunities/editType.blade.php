@extends('layout')

@section('content')
    <form method="post" action="{{route('FundingOpportunityTypes.update', $fundingOppType->id)}}" >
        {{csrf_field()}}
        <div class="form-group">
            <label for="fundingType">Opportunity Type</label>
            <input type="hidden" id="_method" name="_method" value="put">
            <input type="text" class="form-control" name="fundingType" id="fundingType" aria-describedby="fundingTypeHelp" placeholder="" value="{{$fundingOppType->name}}">
            <small id="fundingTypeHelp" class="form-text text-muted">How the funding opportunity will be identified.</small>
        </div>
        <button type="submit" class="btn btn-primary" id="EditSubmitButton">Edit Type</button>
    </form>
    <script type="text/javascript">
        $( document ).ready(function() {
            $('button[type=submit]').click(function() {
                $(this).attr('disabled', 'disabled');
                $(this).text("Updating...");
                $(this).parents('form').submit()
            })
        });
    </script>
@endsection

