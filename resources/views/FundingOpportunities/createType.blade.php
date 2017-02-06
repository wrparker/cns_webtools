@extends('layout')

@section('content')
    <form method="post" action="/FundingOpportunityType">
        {{csrf_field()}}
        <div class="form-group">
            <label for="fundingType">Opportunity Type</label>
            <input type="text" class="form-control" name="fundingType" id="fundingType" aria-describedby="fundingTypeHelp" placeholder="">
            <small id="fundingTypeHelp" class="form-text text-muted">How the funding opportunity will be identified.</small>
        </div>
        <button type="submit" class="btn btn-primary">Create Type</button>
    </form>
@endsection

