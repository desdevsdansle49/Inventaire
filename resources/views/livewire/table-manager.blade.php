<div>
    @if ($showFirstTable)
        @livewire('add-table-component')
    @else
        @livewire('department-table')
    @endif
    <button wire:click="toggleTable">Basculer le tableau</button>
</div>
