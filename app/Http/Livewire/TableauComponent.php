<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;
use Livewire\WithPagination;
use Psy\Readline\Hoa\Console;

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
        $this->name = '';
        $this->quantity = '';
    }

    public function updatingQuery()
    {
        $this->resetPage();
    }

    public function remove($test)
    {
        POST::table('item')->where('Name', '=', $test)->delete();
    }


    public function render()
    {
        return view('livewire.tableau-component', [
            'items' => POST::table('item')->where('Name', 'like', '%' . $this->query . '%')->paginate($this->perPage)
        ]);
    }
}
