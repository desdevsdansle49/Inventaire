<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\LogHisto;
use App\Models\LogQuantity;

class LogsComponent extends Component
{
    public $altTable = False;

    public function render()
    {
        return view('livewire.logs-component', [
            'LogHisto' => LogHisto::fetchLogs(),
            'LogQuantity' => LogQuantity::orderBy('id', 'desc')->paginate(10)
        ]);
    }
}
