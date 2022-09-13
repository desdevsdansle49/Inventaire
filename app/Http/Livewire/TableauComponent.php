<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;

class TableauComponent extends Component
{
    public function render()
    {
        return view('livewire.tableau-component', [
            'items' => POST::table('item')->get()
        ]);
    }

    public function delete()
    {
        POST::table('item')->where('Name', '=', 'Temp')->delete();
    }

    public function add()
    {
        POST::table('item')->insert([
            'Name' => 'Temp',
            'Quantity' => 10
        ]);
    }
}
