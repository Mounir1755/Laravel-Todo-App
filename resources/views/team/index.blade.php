<x-layouts.app>
    {{ $title }}
    @forelse ($teams as $team) 
        <div class="border border-sky-950 rounded-lg mb-3 grid grid-cols-2 gap-6 p-2 shadow-xl"> 
            <div>
                <a href="{{ route('team.show', $team->id) }}">
                    <h6>{{$team->title}}</h6>
                    <p>{{$team->description}}</p>
                </a>
            </div>
            <div class="ms-auto me-1 content-center">
                <a href="{{ route('team.addUsersToTeam', $team->id )}}">
                    <i class="bi bi-person-plus"></i>
                </a>
            </div>
        </div>
    @empty
        <div>
            <a href="{{ route('team.create') }}">Make your first team</a>
        </div>
    @endforelse
</x-layouts.app>