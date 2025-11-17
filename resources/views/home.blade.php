<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @if (Route::has('login'))
        <nav class="flex items-center justify-end gap-4">
            @auth
                <a href="{{ url('/dashboard') }}">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}">
                    Log in
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">
                        Register
                    </a>
                @endif
            @endauth
        </nav>
    @endif
    <h1>hallo</h1>

    @forelse ($tasks as $task)
        <div>
            <h5>Task: {{ $task->title }}</h5>
            <p>Description: {{ $task->description }}</p>
            <p>
                @if ( $task->done == 0)
                    <p>Nog maken</p>
                @else
                    <p>AF!</p>
                @endif
            </p>
        </div>
    @empty
        <p>Niks gevonden :(</p>
    @endforelse
    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif
</body>
</html>
            

