

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

    @if(isset($items))
    <table class="table-bordered">
        <thead>
        <tr>
            <th>Lastname, Firstname</th>
            <th>Year</th>
        </tr>
        </thead>
            @foreach($items as $item)
            <tr>
                <td>
                    <a href="{{route($route.'.edit', $item->id)}}" class="list"> {{$item->lastname}}, {{$item->firstname}}</a>
                </td>
                <td>
                    {{$item->year}}
                </td>
            </tr>
                @endforeach
    </table>
    {{ $items->links()}}
        @else
            <p>There are currently no Math PhDs available.</p>
        @endif
        </div></div></div></div>

@endsection


