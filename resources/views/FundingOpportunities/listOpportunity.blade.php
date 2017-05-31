

@extends('layouts.app')


@section('content')
    {{--get route prefix.--}}
    <?php $route = \App\Group::find(APP_FUNDINGOPPORTUNITIES)->route_prefix ?>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Funding Opportunities</div>
            <div class="container">
<h1> Funding Opportunities</h1>
<p>
    The following are funding types that have been put into the system.
</p>

<p><a href="{{route($route.'.create')}}" class="btn btn-success">Create a Funding Opportunity</a></p>

<form method="get" action="{{route($route.'.index')}}">
    <input type="text" id="search" name="search" placeholder="Search by Type Name"
           @if(isset($search)) value="{{$search}}" @endif  >
    <button type="submit" class="btn search">Go</button>
</form>

    @if(isset($FundingOpportunities))
    <table class="table-bordered">
        <thead>
        <tr>
            <th>Opportunity Name</th>
            <th>Type</th>
            <th>Visibility</th>
            <th>Created:</th>
            <th>Updated:</th>
        </tr>
        </thead>
            @foreach($FundingOpportunities as $FundingOpportunity)
            <tr>
                <td>
                    <a href="{{route($route.'.edit', $FundingOpportunity->id)}}" class="list"> {{$FundingOpportunity->name}}</a>
                </td>
                <td>
                    {{$FundingOpportunity->funding_type}}
                </td>
                <td>
                  {{$FundingOpportunity->visible ? 'Visible' : 'Hidden'}}
                </td>
                <td>
                    {{$FundingOpportunity->created_at}}
                </td>
                <td>
                    {{$FundingOpportunity->updated_at}}
                </td>
            </tr>
                @endforeach
    </table>
    {{ $FundingOpportunities->links()}}
        @else
            <p>There are currently no funding opportunities available.</p>
        @endif
        </div></div></div></div>

@endsection


