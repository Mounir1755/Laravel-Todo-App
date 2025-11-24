<x-layouts.app>
    <form method="POST" action="{{ route('team.storeTask') }}" class="grid grid-cols-2 gap-6 p-4">
        @csrf
        <input type="hidden" name="teamId" id="teamId" value="{{ $teamId }}">
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
</x-layouts.app>