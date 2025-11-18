<x-layouts.app>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
            <h4>New Task</h4>
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" aria-label="sluiten" data-bs-dismiss="alert"></button>
                </div>
            @endif
            <div class="container">
                <div class="row">
                    <div class="col-4">
                        <h6>NEW TASK</h6>
                        <form method="POST" action="{{ route('task.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">title</label>
                                <input type="text" name="title" id="title" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">description</label>
                                <input type="text" name="description" id="description" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary">
                                MAKE
                            </button>
                        </form>
                    </div>
                    <div class="col-4">
                        <h6>NEW CATEGORY</h6>
                        <form method="POST" action="{{ route('category.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="categoryTitle" class="form-label">category title</label>
                                <input type="text" name="categoryTitle" id="categoryTitle" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="categoryDescription" class="form-label">category description</label>
                                <input type="text" name="categoryDescription" id="categoryDescription" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary">
                                MAKE
                            </button>
                        </form>
                    </div>
                    <div class="col-4">
                        <h6>LINK TASK TO CATEGORY</h6>
                        <form method="POST" action="{{ route('task.addTaskToCategory') }}">
                            @csrf

                            <div class="mb-3">
                                @if( $categories )
                                    <label for="categoryId" class="form-label">category</label>
                                    <select class="form-select" name="categoryId" id="categoryId">
                                        @foreach ( $categories as $category )
                                            <option value="{{ $category->id }}">
                                                {{ $category->categoryTitle }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else 
                                    Make a category first
                                @endif
                            </div>

                            <div class="mb-3">
                                @if( $tasks )
                                    <label for="taskId" class="form-label">task</label>
                                    <select class="form-select" name="taskId" id="taskId">
                                        @foreach ( $tasks as $task )
                                            <option value="{{ $task->id }}">
                                                {{ $task->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    Make a task first
                                @endif                        
                            </div>

                            <button type="submit" class="btn btn-primary">
                                    MAKE
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="overflow-y-auto" style="max-height: 70vh;">
                        @forelse ( $tasks as $task )
                            <div class="col-12 d-flex border rounded p-3 mt-3">
                                <div>
                                    <h5>Task: {{ $task->title }}</h5>
                                    <p class="mb-0">Description: {{ $task->description }}</p>
                                    <a href="{{ route('task.edit', $task->id)}}" class="mt-auto">edit</a>
                                </div>
                                <div class="ms-auto d-flex justify-content-center align-items-center">
                                    @if ( $task->done == 0 )
                                         <div class="border p-1 rounded-pill bg-danger text-white" style="--bs-bg-opacity: .9; --bs-border-color: black;">
                                            Nog maken
                                        </div>
                                    @else
                                        <div class="border p-1 rounded-pill bg-succes text-white" style="--bs-bg-opacity: .5; --bs-border-color: black;">
                                            AF!
                                        </div>
                                    @endif                             
                                </div>
                            </div>
                        @empty
                            <p>Niks gevonden :(</p>
                        @endforelse
                    </div>
                </div>
            </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</x-layouts.app>
