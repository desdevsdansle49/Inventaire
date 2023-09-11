<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TableManager extends Component
{
    public $showFirstTable = true;
    protected $listeners = ['toggleTableEvent' => 'toggleTable'];

    public function toggleTable()
    {
        $this->showFirstTable = !$this->showFirstTable;
    }

    public function render()
    {
        return view('livewire.table-manager');
    }
}
