<x-layouts.app>
        <!-- RIGHT -->
        <div class="pl-4">
            @if (session('Success'))
                <div class="p-4 border border-green-400 bg-green-800 rounded-lg mt-1" role="alert">
                    <h6 class="font-bold">{{ session('Success') }}</h6>
                </div>
                <meta http-equiv="refresh" content="2;url={{ route('dashboard') }}">
            @endif
        </div>

    <div class="pl-4">
        <button type="button" onclick="showCategoryForm()" class="cursor-pointer"><h6>Link task to category.</h6></button>
    </div>

    <div id="categoryFormModal" class="hidden">
        <div id="dialog" aria-labelledby="dialog-title" class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
            
            <div class="fixed inset-0 bg-zinc-950/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></div>

            <div tabindex="0" class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-zinc-800 text-left shadow-xl outline -outline-offset-1 outline-white/10 transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full sm:max-w-lg data-closed:sm:translate-y-0 data-closed:sm:scale-95">
                    <div class="bg-zinc-900/75 light px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <form method="POST" id="linkTask" action="{{ route('task.addTaskToCategory') }}" class="grid grid-cols-2 gap-6 p-4">
                            @csrf

                            <flux:field>
                                <flux:label for="categoryId">category</flux:label>
                                <flux:select name="categoryId" id="categoryId">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->categoryTitle }}</option>
                                    @endforeach
                                </flux:select>
                            </flux:field>

                            <flux:field>
                                <flux:label for="taskId">task</flux:label>
                                <flux:select name="taskId" id="taskId">
                                    @foreach ($tasks as $task)
                                        <option value="{{ $task->id }}">{{ $task->title }}</option>
                                    @endforeach
                                </flux:select>
                            </flux:field>
                        </form>
                    </div>
                    <div class="bg-zinc-800 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <flux:button form="linkTask" type="submit" class="ms-1">
                                MAKE
                        </flux:button>
                        <button type="button" onclick="showCategoryForm()" class="rounded-md bg-red-500 px-4 text-sm font-semibold text-white hover:bg-red-400">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pl-4">
        <button type="button" onclick="showTaskForm()" class="cursor-pointer"><h6>Make a new task.</h6></button>
    </div>

    <div id="taskFormModal" class="hidden">
        <div id="dialog" aria-labelledby="dialog-title" class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
            
            <div class="fixed inset-0 bg-zinc-950/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></div>

            <div tabindex="0" class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-zinc-800 text-left shadow-xl outline -outline-offset-1 outline-white/10 transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full sm:max-w-lg data-closed:sm:translate-y-0 data-closed:sm:scale-95">
                    <div class="bg-zinc-900/75 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <form method="POST" action="{{ route('task.store') }}" class="grid grid-cols-2 gap-6 p-4" id="MakeTask">
                            @csrf

                            <flux:field>
                                <flux:label for="title">title</flux:label>
                                <flux:input type="text" name="title" id="title"/>
                            </flux:field>

                            <flux:field>
                                <flux:label for="description">description</flux:label>
                                <flux:input type="text" name="description" id="description"/>
                            </flux:field>
                        </form>
                    </div>
                    <div class="bg-zinc-800 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <flux:button form="MakeTask" type="submit" class="ms-1">
                                MAKE
                        </flux:button>
                        <button type="button" onclick="showTaskForm()" class="rounded-md bg-red-500 px-4 text-sm font-semibold text-white hover:bg-red-400">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
           
    <div class="overflow-y-auto p-4" style="max-height: 70vh;">
        @forelse ( $tasks as $task )
            @if ( $task->isActive === 1)
                <div class="border border-white rounded-lg mb-3 grid grid-cols-2 gap-6 p-2 shadow-xl">
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
            <div class="flex justify-center">
                <button class="cursor-pointer" onclick="showTaskForm()" id="newTaskForm">
                    No tasks yet, <span class="underline">Create your first task!</span>
                </button>
            </div>
        @endforelse
    </div>
    <script src="{{ asset('modal.js') }}"></script>
</x-layouts.app>
