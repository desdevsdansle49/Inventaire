<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Item;
use App\Models\LogQuantity;
use App\Models\LogHisto;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CatTab extends Component
{
    public $query;

    public $fromEdit = False;

    protected $result;

    protected $MyCategory;

    protected $rules = [
        'name' => 'required | unique:items| String',
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
        $this->validateOnly($this->category);

        Category::insert([
            'name' => $this->category,
        ]);

        $this->checkHisto();
        $this->addHisto($this->category, 'Catégorie crée');
    }

    public function removeCategory()
    {
        if ($this->category == '-') {
            return;
        }

        Item::where('category_id', '=', Category::where('name', '=', $this->category)->get('id')[0]->id)->update(['category_id' => Category::where('name', '=', '-')->get('id')[0]->id]);
        Category::where('Name', '=', $this->category)->delete();

        $this->checkHisto();
        $this->addHisto($this->category, 'Catégorie supprimée');
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



    public function render()
    {
        $this->result = Category::where('name', 'like', '%' . $this->query . '%')->orderBy('name', 'ASC')->paginate(10);

        return view('livewire.cat-tab', [
            'items' => $this->result
        ]);
    }
}
