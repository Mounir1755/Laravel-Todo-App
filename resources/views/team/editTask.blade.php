<x-layouts.app>        
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form method="POST" action="{{ route('team.updateTask') }}" class="grid grid-cols-2 gap-6 p-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="taskId" id="taskId" value="{{ $oldData->id }}">
                    <flux:field>
                        <flux:label for="title">title</flux:label>
                        <flux:input type="text" name="title" id="title" value="{{ $oldData->taskTitle }}" />
                    </flux:field>
                    <flux:field>
                        <flux:label for="description">description</flux:label>
                        <flux:input type="text" name="description" id="description" value="{{ $oldData->taskDescription }}"/>
                    </flux:field>
                    <flux:field class="col-span-2">
                        <flux:label for="assignedTo">Assigned to</flux:label>
                        <flux:select name="assignedTo" id="assignedTo">
                            @foreach ($teamMembers as $teamMember)
                                <option value="{{ $teamMember->userId }}">{{ $teamMember->name }}</option>
                            @endforeach
                        </flux:select>
                    </flux:field>
                    <flux:button type="submit" class="col-span-2">
                        MAKE
                    </flux:button>
                </form>
            </div>
        </div>
    </div>  
</x-layouts.app>