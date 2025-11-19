<form action="{{ route('task.softdelete', $task->id)}}" 
    method="POST" 
    onsubmit="return confirm('are you sure you want to do this?')"
>
    @csrf
    @method('PUT')
    <button type="submit">delete</button>
</form>