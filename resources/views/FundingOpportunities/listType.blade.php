

@extends('layout')


@section('content')

<h1> Funding Opportunity Types</h1>
<p>
    The following are funding types that have been put into the system.  Please note: you cannot delete a funding type
    that has Funding Opportunities associated with it.
</p>

<a href="{{route('FundingOpportunityTypes.create')}}" class="btn btn-success">Create an Opportunity Type</a>
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
                    {{$type->name}}
                </td>
                <td>
                    <a href="{{route('FundingOpportunityTypes.edit', $type->id)}}" class="btn btn-info">Edit</a>
                </td>
                <td>
                    <form method="post" action="{{route('FundingOpportunityTypes.destroy', $type->id)}}"
                          onsubmit="return ConfirmDelete()">
                        {{csrf_field()}}
                        <input type="hidden" id="_method" name="_method" value="delete">
                        <button type="submit" class="btn btn-danger" style="margin-top:15px">Delete</button>
                    </form>

                </td>
            </tr>
                @endforeach
    </table>
    {{ $types->links()}}
        @else
            <p>There are currently no opportunity types available.</p>
        @endif

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

