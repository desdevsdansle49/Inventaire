<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;
use App\Models\Item;
use Livewire\WithPagination;
use Psy\Readline\Hoa\Console;
use Illuminate\Support\Facades\Validator;

class TableauComponent extends Component
{

    //rendering 
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;

    public $query;

    public $inputCategory = false;
    public $fromEdit;
    //

    //interaction db

    public $name;
    public $nameForEdit;
    public $quantity;
    public $category = '-';
    public $category_id;
    public $barcode;
    public $lowest;
    protected $result;


    //


    //interaction db
    protected $rules = [
        'name' => 'required | unique:items',
        'quantity' => 'required | numeric | gte:0 ',
        'category_id' => 'required | unique:items',
    ];

    protected $messages = [
        'name.required' => 'Champ obligatoire',
        'name.unique' => 'Cette item existe déjà',
        'quantity.required' => 'Champ obligatoire',
        'quantity.gte' => 'Champ >= 0',
    ];

    public function addItem()
    {

        $this->category_id = $this->category;
        $this->validate();

        if (!$this->lowest) {
            $this->lowest = 0;
        }

        Item::insert([
            'name' => $this->name,
            'quantity' => $this->quantity,
            'barcode' => $this->barcode,
            'lowest' => $this->lowest,
            'category_id' => (Category::where('name', 'like', $this->category_id)->get('id'))[0]->id
        ]);
        if ($this->fromEdit == false) {

            $this->clear();
        }
    }

    public function addCategory()
    {
        $this->validateOnly($this->category);
        $this->inputCategory = !$this->inputCategory;

        Category::insert([
            'name' => $this->category,
        ]);
    }

    public function removeCategory()
    {
        if ($this->category == '-') {
            return;
        }

        Item::where('category_id', '=', Category::where('name', '=', $this->category)->get('id')[0]->id)->update(['category_id' => Category::where('name', '=', '-')->get('id')[0]->id]);
        Category::where('Name', '=', $this->category)->delete();
    }

    public function remove()
    {
        Item::where('Name', '=', $this->name)->delete();
        $this->clear();
    }

    public function edit()
    {
        Item::where('Name', '=', $this->nameForEdit)->delete();
        $this->addItem();
        $this->nameForEdit = $this->name;
    }

    // 

    public function defineData($category, $name, $quantity, $barcode, $lowest)
    {
        $this->nameForEdit = $name;
        $this->fromEdit = true;
        $this->category = $category;
        $this->name = $name;
        $this->quantity = $quantity;
        $this->barcode = $barcode;
        $this->lowest = $lowest;
    }



    //rendering

    public function clear()
    {
        $this->name = '';
        $this->quantity = '';
        $this->barcode = '';
        $this->category = '-';
        $this->lowest = '';
    }

    public function false()
    {
        $this->fromEdit = false;
        $this->clear();
    }


    public function updatingQuery()
    {
        $this->resetPage();
    }

    public function showInput()
    {
        $this->category = '';
        $this->inputCategory = !$this->inputCategory;
    }


    public function render()
    {
        //si une category == query exist on ajoute a la recherche sinon on recherche que les items par nom
        if (Category::where('Name', 'like', '%' . $this->query . '%')->exists()) {
            $this->result = Item::where('Name', 'like', '%' . $this->query . '%')
                ->orWhere('Barcode', '=', $this->query)
                ->orWhere('category_id', 'like', (Category::where('Name', 'like', '%' . $this->query . '%')->get('id')[0]->id))
                ->orderBy('name', 'ASC')
                ->paginate($this->perPage);
        } else {
            $this->result = Item::where('Name', 'like', '%' . $this->query . '%')
                ->orWhere('Barcode', '=', $this->query)
                ->orderBy('name', 'ASC')
                ->paginate($this->perPage);
        }

        return view('livewire.tableau-component', [
            'items' => $this->result,
            'categories' => Category::orderBy('name', 'ASC')->get(),
        ]);
    }

    //
}
