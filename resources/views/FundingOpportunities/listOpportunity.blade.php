

@extends('layouts.app')


@section('content')
<div class="container">
<h1> Funding Opportunities</h1>
<p>
    The following are funding types that have been put into the system.  Please note: you cannot delete a funding type
    that has Funding Opportunities associated with it.
</p>

<p><a href="{{route('FundingOpportunities.create')}}" class="btn btn-success">Create a Funding Opportunity</a></p>

    @if(isset($FundingOpportunities))
    <table class="table-bordered">
        <thead>
        <tr>
            <th>Type Name</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
            @foreach($FundingOpportunities as $FundingOpportunity)
            <tr>
                <td>
                    {{$FundingOpportunity->name}}
                </td>
                <td>
                    <a href="{{route('FundingOpportunities.edit', $FundingOpportunity->id)}}" class="btn btn-info">Edit</a>
                </td>
                <td>
                    <form method="post" action="{{route('FundingOpportunities.destroy', $FundingOpportunity->id)}}"
                          onsubmit="return ConfirmDelete()">
                        {{csrf_field()}}
                        <input type="hidden" id="_method" name="_method" value="delete">
                        <button type="submit" class="btn btn-danger" style="margin-top:15px">Delete</button>
                    </form>

                </td>
            </tr>
                @endforeach
    </table>
    {{ $FundingOpportunities->links()}}
        @else
            <p>There are currently no funding opportunities available.</p>
        @endif
</div>

<script>

    function ConfirmDelete()
    {
        var x = confirm("Are you sure you want to delete this record?");
        if (x)
            return true;
        else
            return false;
    }

</script>

@endsection

