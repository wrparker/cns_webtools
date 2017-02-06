@extends('layout')

@section('content')
<h1> Funding Opportunity Types</h1>
<p>
    The following are funding types that have been put into the system.  Please note: you cannot delete a funding type
    that has Funding Opportunities associated with it.
</p>

<a href="FundingOpportunityType/create" class="btn btn-success">Create an Opportunity Type</a>
<p>&nbsp;</p>
    @if(isset($types))
    <table class="table-bordered">
        <thead>
        <tr>
            <th>Type Name</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
            @foreach($types as $type)
            <tr>
                <td>
                    {{$type->type}}
                </td>
                <td>
                    
                    <form method="DELETE" action="/FundingOpportunityType">
                        <button type="submit" class="btn btn-primary">Del</button>
                    </form>
                </td>
                <td>
                    <a href='#' class="btn btn-danger">Delete</a>
                </td>
            </tr>
                @endforeach
    </table>
        @else
            <p>There are currently no opportunity types available.</p>
        @endif


@endsection

