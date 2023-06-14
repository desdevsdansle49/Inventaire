<div>
    @if ($showFirstTable)
        @livewire('cat-tab')
    @else
        @livewire('department-table')
    @endif
    <button wire:click="toggleTable">Basculer le tableau</button>
</div>
