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

    protected $rules = [
        'name' => 'required',
        'quantity' => 'required | numeric | gte:0 '
    ];

    protected $messages = [
        'quantity.required' => 'Champ obligatoire',
        'quantity.gte' => 'Champ >= 0',
    ];

    public function addItem()
    {

        $this->validate();

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

    public function remove($name)
    {
        POST::table('item')->where('Name', '=', $name)->delete();
    }


    public function render()
    {
        return view('livewire.tableau-component', [
            'items' => POST::table('item')->where('Name', 'like', '%' . $this->query . '%')->paginate($this->perPage)
        ]);
    }
}
