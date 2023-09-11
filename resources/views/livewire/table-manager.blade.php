<div>
    @if ($showFirstTable)
        @livewire('add-table-component')
    @else
        @livewire('department-table')
    @endif
</div>
