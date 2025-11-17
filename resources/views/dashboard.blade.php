<x-layouts.app>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
            <h4>New Task</h4>
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" aria-label="sluiten" data-bs-dismiss="alert"></button>
                </div>
            @endif
            <form method="POST" action="{{ route('task.store') }}">
                @csrf
                <div class="d-flex">
                    <label for="title">title</label>
                    <input type="text" name="title" id="title">
                </div>

                <div class="">
                    <label for="description">description</label>
                    <input type="text" name="description" id="description">
                </div>

                <button type="submit" class="btn btn-primary">
                    MAKE
                </button>
            </form>

            <div class="container">
                <div class="row">
                    <div class="overflow-y-auto" style="max-height: 70vh;">
                        @forelse ($tasks as $task)
                            <div class="col-12 d-flex border p-3 mt-3">
                                
                                <div>
                                    <h5>Task: {{ $task->title }}</h5>
                                    <p class="mb-0">Description: {{ $task->description }}</p>
                                </div>
                                <div class="ms-auto d-flex justify-content-center align-items-center">
                                    @if ( $task->done == 0)
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
