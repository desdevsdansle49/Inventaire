<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Item;
use App\Models\LogQuantity;
use App\Models\LogHisto;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AddTableComponent extends Component
{
    public $query;
    public $fromEdit = False;
    public $name = '';
    public $name2 = '';
    public $listItem = [];

    protected $result;

    protected $rules = [
        'name' => 'required | unique:categories| String',
    ];

    protected $messages = [
        'name.required' => 'Champ obligatoire',
        'name.unique' => 'Cette item existe déjà',
    ];

    public function updatingQuery()
    {
        $this->reset();
    }


    public function addCategory()
    {
        $this->validate();

        Category::insert([
            'name' => $this->name,
        ]);

        $this->checkHisto();
        $this->addHisto($this->name, 'Catégorie crée');
        $this->clear();
    }

    public function removeCategory()
    {
        if ($this->name == '-') {
            return;
        }

        $categoryId = Category::firstWhere('name', $this->name)->id;
        $newCategoryId = Category::firstWhere('name', '-')->id;
        Item::where('category_id', $categoryId)->update(['category_id' => $newCategoryId]);
        Category::where('Name', '=', $this->name)->delete();

        $this->checkHisto();
        $this->addHisto($this->name, 'Catégorie supprimée');
        $this->clear();
    }


    public function addHisto($name, $action, $quantity = null)
    {
        if ($quantity) {
            LogQuantity::insert([
                'name' => $name,
                'action' => $action
            ]);
        } else {
            LogHisto::insert([
                'name' => $name,
                'action' => $action
            ]);
        }
    }

    public function checkHisto()
    {
        if (LogQuantity::count() > 100) {
            LogQuantity::orderBy('id', 'asc')->first()->delete();
        }
        if (LogHisto::count() > 100) {
            LogHisto::orderBy('id', 'asc')->first()->delete();
        }
    }

    public function clear()
    {
        $this->reset(['name', 'name2']);
        $this->resetValidation();
    }

    public function false()
    {
        $this->fromEdit = false;
        $this->clear();
    }

    public function defineData($item)
    {
        $decodedItem = json_decode($item);
        $this->name = $this->name2 = $decodedItem->name;
        $this->fromEdit = true;
        $id = Category::where('name', $this->name)->first()->id;
        $this->listItem = Item::where('category_id', $id)->get();
    }


    public function render()
    {
        $this->result = Category::where('name', 'like', '%' . $this->query . '%')->orderBy('name', 'ASC')->paginate(10);

        return view('livewire.add-table-component', [
            'items' => $this->result,
            'listItem' => $this->listItem,
        ]);
    }
}
