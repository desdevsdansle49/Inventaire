<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;
use App\Models\Item;
use App\Models\LogHisto;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class TableauComponent extends Component
{

    //les query sont probablement tres mal opti





    //rendering 
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;

    public $query;

    public $inputCategory = false;
    public $fromEdit;

    public $alerte = false;

    public $fromCreate = false;
    protected $route;

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
    public $addQuantity;
    public $fournisseur;
    public $note;

    public $nameForEdit2;
    public $category2;
    public $name2;
    public $quantity2;
    public $barcode2;
    public $lowest2;
    public $fournisseur2;
    public $note2;

    public $tableau1;
    public $tableau2;

    //


    //interaction db
    protected $rules = [
        'name' => 'required | unique:items| String',
        'quantity' => 'required | numeric | gte:0',
        'category_id' => 'required | unique:items',
        'lowest' => 'numeric | gte:0',
    ];

    protected $messages = [
        'name.required' => 'Champ obligatoire',
        'name.unique' => 'Cette item existe déjà',
        'quantity.required' => 'Champ obligatoire',
        'quantity.gte' => 'Champ > 0',
        'lowest.numeric' => 'Champ > 0'
    ];


    public function mount()
    {
        $this->route = Route::current();

        if ($this->route->uri == "create") {
            $this->fromCreate = True;
        }
    }

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
            'fournisseur' => $this->fournisseur,
            'note' => $this->note,
            'category_id' => (Category::where('name', 'like', $this->category_id)->get('id'))[0]->id
        ]);


        if (LogHisto::count() > 10) {
            LogHisto::orderBy('id', 'asc')->first()->delete();
        }

        if ($this->fromEdit == false) {
            LogHisto::insert([
                'name' => $this->name,
                'action' => 'Item crée'
            ]);
            $this->clear();
        } else {
            $this->tableau1 = [$this->nameForEdit, $this->category, $this->name, $this->quantity, $this->barcode, $this->lowest, $this->fournisseur, $this->note];
            $this->tableau2 = [$this->nameForEdit2, $this->category2, $this->name2, $this->quantity2, $this->barcode2, $this->lowest2, $this->fournisseur2, $this->note2,];
            for ($i = 0; $i < count($this->tableau1); $i++) {
                if ($this->tableau1[$i] != $this->tableau2[$i]) {
                    LogHisto::insert([
                        'name' => $this->name,
                        'action' => 'Item modifié : ' . $this->tableau2[$i] . " -> " . $this->tableau1[$i]
                    ]);
                }
            }
        }
    }

    public function addCategory()
    {
        $this->validateOnly($this->category);
        $this->inputCategory = !$this->inputCategory;

        Category::insert([
            'name' => $this->category,
        ]);

        if (LogHisto::count() > 10) {
            LogHisto::orderBy('id', 'asc')->first()->delete();
        }
        LogHisto::insert([
            'name' => $this->category,
            'action' => 'Catégorie crée'
        ]);
    }

    public function removeCategory()
    {
        if ($this->category == '-') {
            return;
        }

        Item::where('category_id', '=', Category::where('name', '=', $this->category)->get('id')[0]->id)->update(['category_id' => Category::where('name', '=', '-')->get('id')[0]->id]);
        Category::where('Name', '=', $this->category)->delete();

        if (LogHisto::count() > 10) {
            LogHisto::orderBy('id', 'asc')->first()->delete();
        }
        LogHisto::insert([
            'name' => $this->category,
            'action' => 'Catégorie supprimée'
        ]);
    }

    public function addQuantity($PorM)
    {
        if (LogHisto::count() > 10) {
            LogHisto::orderBy('id', 'asc')->first()->delete();
        }

        if (is_numeric($this->addQuantity)) {
            if ($PorM == "-") {
                Item::where('name', '=', $this->name)->decrement('quantity', $this->addQuantity);

                LogHisto::insert([
                    'name' => $this->name,
                    'action' => 'Quantité - ' . $this->addQuantity
                ]);
            } else if ($PorM == "+") {
                Item::where('name', '=', $this->name)->increment('quantity', $this->addQuantity);

                LogHisto::insert([
                    'name' => $this->name,
                    'action' => 'Quantité + ' . $this->addQuantity
                ]);
            }
        }

        $this->addQuantity = "";
    }

    public function remove()
    {
        Item::where('Name', '=', $this->name)->delete();

        if (LogHisto::count() > 10) {
            LogHisto::orderBy('id', 'asc')->first()->delete();
        }
        LogHisto::insert([
            'name' => $this->name,
            'action' => 'Item supprimé'
        ]);

        $this->clear();
    }

    //😬
    public function edit()
    {
        $this->category_id = $this->category;
        Item::where('Name', '=', $this->nameForEdit)->delete();
        $this->addItem();
        $this->nameForEdit = $this->name;
    }

    // 


    //y'a une facon bien plus clean de faire ca mais je sais plus ce que c'est
    public function defineData($category, $name, $quantity, $barcode, $lowest, $fournisseur, $note)
    {
        $this->nameForEdit = $name;
        $this->fromEdit = true;
        $this->category = $category;
        $this->name = $name;
        $this->quantity = $quantity;
        $this->barcode = $barcode;
        $this->lowest = $lowest;
        $this->fournisseur = $fournisseur;
        $this->note = $note;

        $this->nameForEdit2 = $name;
        $this->category2 = $category;
        $this->name2 = $name;
        $this->quantity2 = $quantity;
        $this->barcode2 = $barcode;
        $this->lowest2 = $lowest;
        $this->fournisseur2 = $fournisseur;
        $this->note2 = $note;
    }



    //rendering

    public function clear()
    {
        $this->name = '';
        $this->quantity = '';
        $this->barcode = '';
        $this->category = '-';
        $this->lowest = '';
        $this->fournisseur = '';
        $this->note = '';
        $this->resetValidation();
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
        //si le bouton alerte only est activé on montre que les items en dessous de la limite de quantité
        if ($this->alerte == true) {
            $this->result = Item::whereRaw('quantity < lowest')
                ->where(function ($query) {
                    $query->where('Name', 'like', '%' . $this->query . '%')
                        ->orWhere('Barcode', '=', $this->query);
                })
                ->orderBy('name', 'ASC')
                ->paginate($this->perPage);
        }
        //si la query = une categorie on l'ajoute a la recherche sinon on recherche que les items par nom
        elseif (Category::where('Name', 'like', '%' . $this->query . '%')->exists()) {
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
