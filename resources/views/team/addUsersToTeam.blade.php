<x-layouts.app>
    @if (session('error'))
        <div class="p-4 border border-red-400 bg-red-800 rounded-lg mt-1" role="alert">
            <h6 class="font-bold">{{ session('error') }}</h6>
        </div>
    @endif
    <h6>{{ $title }}</h6>
    <p class="text-xs text-gray-400">{{ $description}}</p>

    <form method="POST" action="{{ route('team.addUserToTeam') }}" class="grid grid-cols-1 gap-6 p-4">
        @csrf

        <input type="hidden" name="teamId" id="teamId" value="{{ $teamId }}">

        <flux:field>
            <flux:heading>Email</flux:heading>
            <flux:text class="m-[0px]">Add the email of the user you want to add to your team.</flux:text>
            <flux:text>Make sure the user is <span class="font-bold">registerd!</span></flux:text>
            <flux:input type="email" name="email" id="email"/>
        </flux:field>

        <flux:button type="submit">
            Add
        </flux:button>
    </form>
</x-layouts.app>