

@extends('layouts.app')


@section('content')
    {{--get route prefix.--}}
    <?php $route = \App\Group::find($gid)->route_prefix ?>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">{{\App\Group::find($gid)->name}}</div>
            <div class="container">
<h1> {{\App\Group::find($gid)->name}}</h1>
<p>
    The following are funding types that have been put into the system.
</p>

<p><a href="{{route($route.'.create')}}" class="btn btn-success">Create {{\App\Group::find($gid)->name}}</a></p>

<form method="get" action="{{route($route.'.index')}}">
    <input type="text" id="search" name="search" placeholder="Search by Type Name"
           @if(isset($search)) value="{{$search}}" @endif  >
    <button type="submit" class="btn search">Go</button>
</form>

    @if(isset($FundingOpportunities))
<form>
    <table class="table-bordered">
        <thead>
        <tr>
            <th>Opportunity Name</th>
            <th>Type</th>
            <th>Visibility</th>
            <th>Created:</th>
            <th>Updated:</th>
            <th>ID</th>
            <th>&nbsp;</th>
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
                <td>
                    {{$FundingOpportunity->id}}
                </td>
                <td>
                    <input type="checkbox" id="item_{{$FundingOpportunity->id}}" name="item_{{$FundingOpportunity->id}}" class="rowSelection" />
                </td>
            </tr>
                @endforeach

    </table>
    {{ $FundingOpportunities->links()}}
        @else
            <p>There are currently no funding opportunities available.</p>
        @endif
    <input type="submit" name="delete_bulk" id="delete_bulk" value="Delete selected" class="btn btn-danger delete" />
</form>

        </div></div></div></div>

@endsection


