<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;
use App\Models\Item;
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
    public $category;

    protected $rules = [
        'name' => 'required | unique:items',
        'quantity' => 'required | numeric | gte:0 '
    ];

    protected $messages = [
        'name.required' => 'Champ obligatoire',
        'name.unique' => 'Cette item existe déjà',
        'quantity.required' => 'Champ obligatoire',
        'quantity.gte' => 'Champ >= 0',
    ];

    public function addItem()
    {



        $this->validate();

        Item::insert([
            'name' => $this->name,
            'quantity' => $this->quantity,
            'category_id' => 1
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
        Item::where('Name', '=', $name)->delete();
    }


    public function render()
    {
        return view('livewire.tableau-component', [
            'items' => Item::where('Name', 'like', '%' . $this->query . '%')->paginate($this->perPage),
            'categories' => Category::get()
        ]);
    }
}
