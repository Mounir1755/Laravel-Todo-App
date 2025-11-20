<x-layouts.app>    
    <h6>{{ $categoryInfo->categoryTitle }}</h6>
    <h6>{{ $categoryInfo->categoryDescription }}</h6>
    <div class="overflow-y-auto p-4" style="max-height: 70vh;">
        @forelse ( $categoryTasks as $task )
            @if ( $task->isActive === 1)
                <div class="border border-sky-950 rounded-lg mb-3 grid grid-cols-2 gap-6 p-2 shadow-xl">
                    <div>
                        <h5 class="{{ $task->done ? ' tracking-wide font-bold decoration-wavy line-through decoration-red-600 decoration-1' : ' tracking-wide font-bold' }}">Task: {{ $task->title }}</h5>
                        <p class="text-xs text-gray-400">Description: {{ $task->description }}</p>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('task.edit', $task->id)}}">
                                <i class="bi bi-pen cursor-pointer"></i>
                            </a>

                            <form action="{{ route('task.softdelete', $task->id)}}" 
                                method="POST" 
                                onsubmit="return confirm('are you sure you want to do this?')"
                                class="inline"
                            >
                                @csrf
                                @method('PUT')
                                <button type="submit" class="inline-flex items-center">
                                    <i class="bi bi-trash cursor-pointer"></i>
                                </button>
                            </form>

                            <form action="{{ route('task.done', $task->id )}}" method="POST">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="done" value="0">

                                
                                <input type="checkbox"
                                    name="done"
                                    value="1"
                                    onchange="this.form.submit()"
                                    {{ $task->done ? 'checked' : '' }}>
                                <label for="done">Mark as done</label>
                            </form>
                        </div>
                    </div>
                    <div class="ms-auto content-center">
                        @if ( $task->done == 0 )
                            <div class="border border-red-900 rounded-full text-xs p-1 bg-red-800 font-bold shadow-lg">
                                To-do
                            </div>
                        @else
                            <div class="border border-green-900 rounded-full text-xs p-1 bg-green-800 font-bold shadow-lg">
                                Done
                            </div>
                        @endif                             
                    </div>
                </div>
            @else
                <div></div>
            @endif
        @empty
            <p>Niks gevonden :(</p>
        @endforelse
    </div>
</x-layouts.app>