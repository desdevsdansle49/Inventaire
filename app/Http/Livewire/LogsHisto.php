<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\LogHisto;

class LogsHisto extends Component
{

    public function render()
    {
        return view('livewire.logs-histo', [
            'items' => LogHisto::orderBy('id', 'desc')->paginate(10)
        ]);
    }
}
