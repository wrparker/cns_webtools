
Task List:
@foreach ($tasks as $task)
    <a href="/tasks/{{$task->id}}">{{$task->body}}</a><hr>
    @endforeach