<x-layouts.app>
    <div class="grid grid-cols-2 gap-6 p-4">
        <!-- LEFT -->
        <div>
            <h6 class="mb-2">NEW CATEGORY</h6>
            <form method="POST" action="{{ route('category.store') }}" class="space-y-4">
                @csrf

                <flux:field>
                    <flux:label for="categoryTitle">category title</flux:label>
                    <flux:input type="text" name="categoryTitle" id="categoryTitle" />
                </flux:field>

                <flux:field>
                    <flux:label for="categoryDescription">category description</flux:label>
                    <flux:input type="text" name="categoryDescription" id="categoryDescription" />
                </flux:field>

                <flux:button type="submit">MAKE</flux:button>
            </form>
        </div>

        <!-- RIGHT -->
        <div>
            <h6 class="mb-2">LINK TASK TO CATEGORY</h6>
            <form method="POST" action="{{ route('task.addTaskToCategory') }}" class="space-y-4">
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

                <flux:button type="submit">MAKE</flux:button>
            </form>
        </div>
    </div>

    <h6 class="pl-4">Make a new task.</h6>
    <form method="POST" action="{{ route('task.store') }}" class="grid grid-cols-2 gap-6 p-4">
        @csrf

        <flux:field>
            <flux:label for="title">title</flux:label>
            <flux:input type="text" name="title" id="title"/>
        </flux:field>

        <flux:field>
            <flux:label for="description">description</flux:label>
            <flux:input type="text" name="description" id="description"/>
        </flux:field>

        <flux:button type="submit" class="col-span-2">
            MAKE
        </flux:button>
    </form>
           
    <div class="overflow-y-auto p-4" style="max-height: 70vh;">
        @forelse ( $tasks as $task )
            @if ( $task->isActive === 1)
                <div class="border border-sky-950 rounded-lg mb-3 grid grid-cols-2 gap-6 p-2">
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
                            <div class="border border-red-900 rounded-full text-xs p-1 bg-red-800 font-bold">
                                To-do
                            </div>
                        @else
                            <div class="border border-green-900 rounded-full text-xs p-1 bg-green-800 font-bold">
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
