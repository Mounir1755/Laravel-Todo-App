<x-layouts.app>
    <div class="ps-4">
        <h1 class="text-xl font-bold ms-1">{{ $title }}</h1>
        <p class="ms-1 mb-3">Members:</p>
        <div class="text-sm font-normal">
            <div class="flex items-center text-start text-sm">
                <span class="relative flex max-w-100 w-fit shrink-0 overflow-hidden rounded-lg mb-3">
                    @forelse ($teamMemberInitials as $initials)
                        <div class="shadow-xl flex min-h-8 max-h-8 min-w-8 max-w-8 p-3 ms-1 items-center uppercase justify-center rounded-lg border-[0.3px] border-gray-400 bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                            {{ $initials }}
                        </div>
                    @empty
                        {{-- fix : exclude your own initials --}}
                        No members yet!
                    @endforelse
                </span>
            </div>
        </div>
        <a href="{{ route('team.createTask', $teamId) }}">
            make a new task
        </a>   
    </div>
    <div class="overflow-y-auto p-4" style="max-height: 80vh;">
        @forelse ( $tasks as $task )
            @if ( $task->isActive === 1)
                <div class="border border-sky-950 rounded-lg mb-3 grid grid-cols-2 gap-6 p-2 shadow-xl">
                    <div>
                        <h5 class="{{ $task->done ? ' tracking-wide font-bold decoration-wavy line-through decoration-red-600 decoration-1' : ' tracking-wide font-bold' }}">Task: {{ $task->taskTitle }}</h5>
                        <p class="text-xs text-gray-400">Description: {{ $task->taskDescription }}</p>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('team.editTask', ['teamId' => $teamId, 'id' => $task->id])}}">
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
                        <div>
                            <div class="text-sm">Assigned to:</div>
                            <div>{{ $task->assignedTo }}</div>
                        </div>
                        @if ( $task->done == 0 )
                            <div class="border border-red-900 rounded-full text-xs p-1 bg-red-800 font-bold shadow-lg text-center">
                                To-do
                            </div>
                        @else
                            <div class="border border-green-900 rounded-full text-xs p-1 bg-green-800 font-bold shadow-lg text-center">
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