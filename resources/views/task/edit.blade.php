<x-layouts.app>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('task.update', $oldData->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <h6>EDIT:{{ $oldData->title }}</h6>
                    
                    <div class="mb-3">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ $oldData->title }}">
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">description</label>
                        <input type="text" name="description" id="description" class="form-control" value="{{ $oldData->description }}">
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-primary w-100" type="submit">
                            UPDATE
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</x-layouts.app>