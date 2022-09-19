<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;
use Livewire\WithPagination;

class TableauComponent extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;

    public $query;

    public $name;
    public $quantity;

    public function addItem()
    {
        POST::table('item')->insert([
            'name' => $this->name,
            'quantity' => $this->quantity,
        ]);
    }

    public function updatingQuery()
    {
        $this->resetPage();
    }

    public function delete()
    {
        POST::table('item')->where('Name', '=', 'Temp')->delete();
    }


    public function render()
    {
        return view('livewire.tableau-component', [
            'items' => POST::table('item')->where('Name', 'like', '%' . $this->query . '%')->paginate($this->perPage)
        ]);
    }
}
