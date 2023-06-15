<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Department;
use App\Models\Unit;
use App\Models\Employee;
use Livewire\Component;
use App\Models\Item;
use App\Models\LogHisto;
use App\Models\LogQuantity;
use App\Models\Transaction;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;
use phpDocumentor\Reflection\PseudoTypes\True_;

class TableauComponent extends Component
{

    //rendering 
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;

    public $query;

    public $inputDepartment = false;
    public $inputUnit = false;
    public $inputEmployee = false;
    public $inputCategory = false;
    public $fromEdit;

    public $alerte = false;

    public $fromCreate = false;
    //

    //interaction db

    public $name;
    public $item_id;
    public $nameForEdit;
    public $quantity;
    public $category = '-';
    public $category_id;
    public $category_inc;
    public $barcode;
    public $lowest;
    public $addQuantity;
    public $fournisseur;
    public $note;
    public $emplacement;

    public $nameForEdit2;
    public $category2;
    public $name2;
    public $quantity2;
    public $barcode2;
    public $lowest2;
    public $fournisseur2;
    public $note2;
    public $emplacement2;

    public $department;
    public $unit;
    public $employee;


    //



    //interaction db
    protected $rules = [
        'name' => 'required | unique:items| String',
        'quantity' => 'required | numeric | gte:0',
        // 'category_id' => 'required | unique:categories',
        'lowest' => 'nullable | numeric | gte:0',
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
        $route = Route::current();

        if ($route->uri == "create") {
            $this->fromCreate = True;
        }
    }

    public function addItem()
    {

        $this->category_inc = $this->category;

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
            'emplacement' => $this->emplacement,
            'category_id' => (Category::where('name', 'like', $this->category_inc)->get('id'))[0]->id
        ]);


        $this->checkHisto();

        if ($this->fromEdit == false) {
            $this->addHisto($this->name, 'Item crée');
            $this->clear();
        } else {
            $tableau1 = [$this->nameForEdit, $this->category, $this->name, $this->quantity, $this->barcode, $this->lowest, $this->fournisseur, $this->note, $this->emplacement];
            $tableau2 = [$this->nameForEdit2, $this->category2, $this->name2, $this->quantity2, $this->barcode2, $this->lowest2, $this->fournisseur2, $this->note2, $this->emplacement2];
            for ($i = 0; $i < count($tableau1); $i++) {
                if ($tableau1[$i] != $tableau2[$i]) {
                    $this->addHisto($this->name, 'Item modifié : ' . $tableau2[$i] . " -> " . $tableau1[$i]);
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

    public function addDUE($DUE)
    {
        // $this->validateOnly($this->$DUE);
        $inputName = 'input' . ucfirst($DUE);
        $this->$inputName = !$this->$inputName;


        if ($DUE == 'department')
            Department::insert([
                'name' => $this->$DUE,
            ]);
        elseif ($DUE == 'unit')
            Unit::insert([
                'name' => $this->$DUE,
                'department_id' => Department::where('name', '=', $this->department)->get('id')[0]->id
            ]);
        elseif ($DUE == 'employee')
            Employee::insert([
                'name' => $this->$DUE,
                'unit_id' => Unit::where('name', '=', $this->unit)->get('id')[0]->id
            ]);

        $this->checkHisto();
        $this->addHisto($this->$DUE, $DUE . ' crée');
    }

    public function removeDUE($DUE)
    {
        $inputName = 'input' . ucfirst($DUE);

        if ($DUE == 'department')
            Department::where('name', $this->$DUE)->delete();
        elseif ($DUE == 'unit')
            Unit::where('name', $this->$DUE)->delete();
        elseif ($DUE == 'employee')
            Employee::where('name', $this->$DUE)->delete();

        $this->checkHisto();
        $this->addHisto($this->$DUE, $DUE . ' supprimé');
    }

    public function addQuantity($PorM)
    {
        $this->checkHisto();

        if (is_numeric($this->addQuantity)) {
            if ($PorM == "-") {
                Item::where('name', '=', $this->name)->decrement('quantity', $this->addQuantity);
                $this->addHisto($this->name, 'Quantité - ' . $this->addQuantity, True);
            } else if ($PorM == "+") {
                Item::where('name', '=', $this->name)->increment('quantity', $this->addQuantity);
                $this->addHisto($this->name, 'Quantité - ' . $this->addQuantity, True);
            }
        }
        $this->createTransaction();
        $this->addQuantity = "";
    }

    public function createTransaction()
    {
        Transaction::insert([
            'item_id' => $this->item_id,
            'category_id' => $this->category_id,
            'department_id' => Department::where('name', $this->department)->get('id')[0]->id,
            'unit_id' => Unit::where('name', $this->unit)->get('id')[0]->id,
            'employee_id' => Employee::where('name', $this->employee)->get('id')[0]->id,

        ]);
    }

    public function remove()
    {
        Item::where('Name', '=', $this->name)->delete();

        $this->checkHisto();
        $this->addHisto($this->name, 'Item supprimé');

        $this->clear();
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

    //😬
    public function edit()
    {
        $this->category_inc = $this->category;
        Item::where('Name', '=', $this->nameForEdit)->delete();
        $this->addItem();
        $this->nameForEdit = $this->name;
    }

    // 


    //y'a une facon bien plus clean de faire ca mais je sais plus ce que c'est
    public function defineData($item)
    {
        $decodedItem = json_decode($item);
        $this->item_id = $decodedItem->id;
        $this->fromEdit = true;
        $this->nameForEdit2 = $this->nameForEdit = $decodedItem->name;
        $this->category2 = $this->category = $decodedItem->category->name;
        $this->category_id = $decodedItem->category->id;
        $this->name2 = $this->name = $decodedItem->name;
        $this->quantity2 = $this->quantity = $decodedItem->quantity;
        $this->barcode2 = $this->barcode = $decodedItem->barcode;
        $this->lowest2 = $this->lowest = $decodedItem->lowest;
        $this->fournisseur2 = $this->fournisseur = $decodedItem->fournisseur;
        $this->note2 = $this->note = $decodedItem->note;
        $this->emplacement2 = $this->emplacement = $decodedItem->emplacement;
        $this->department = $this->employee = $this->unit = '-';
    }



    //rendering

    public function clear()
    {
        $this->reset(['name', 'quantity', 'barcode', 'category', 'lowest', 'fournisseur', 'note', 'emplacement']);
        $this->resetValidation();
    }

    public function false()
    {
        $this->fromEdit = false;
        $this->clear();
    }




    public function showInput($inputName)
    {
        $this->$inputName = '';
        $inputBool = 'input' . ucfirst($inputName);
        $this->$inputBool = !$this->$inputBool;
    }

    public function updatedEmployee()
    {
        if ($this->inputDepartment || $this->inputUnit || $this->inputEmployee || $this->employee == '-') {
            return;
        }
        $tmp = Employee::where('name', '=', $this->employee)->first();
        $this->unit = (($tmp)->unit)->name;
        $this->updatedUnit();
    }

    public function updatedUnit()
    {
        if ($this->inputDepartment || $this->inputUnit || $this->inputEmployee || $this->unit == '-') {
            return;
        }
        $tmp = Unit::where('name', '=', $this->unit)->first();
        $this->department = (($tmp)->department)->name;
    }

    private function getItems()
    {
        // Votre code initial pour récupérer les éléments
        if ($this->alerte == true) {
            $result = Item::whereRaw('quantity < lowest')
                ->where(function ($query) {
                    $query->where('Name', 'like', '%' . $this->query . '%')
                        ->orWhere('Barcode', '=', $this->query);
                });
        } elseif (Category::where('Name', 'like', '%' . $this->query . '%')->exists()) {
            $result = Item::where('Name', 'like', '%' . $this->query . '%')
                ->orWhere('Barcode', '=', $this->query)
                ->orWhere('category_id', 'like', (Category::where('Name', 'like', '%' . $this->query . '%')->get('id')[0]->id));
        } else {
            $result = Item::where('Name', 'like', '%' . $this->query . '%')
                ->orWhere('Barcode', '=', $this->query);
        }

        return $result->orderBy('name', 'ASC')->paginate($this->perPage);
    }


    private function getUnits()
    {
        $result = Unit::query()
            ->when($this->department !== null && $this->department !== '-' && $this->inputDepartment == false, function ($query) {
                $departmentID = Department::where('name', $this->department)->first()->id;
                return $query->where('department_id', $departmentID)->orWhere('name', '-');
            });

        return $result->orderBy('name', 'ASC')->get();
    }

    private function getEmployees()
    {
        $result = Employee::query()
            ->when($this->unit !== null && $this->unit !== '-' && $this->inputUnit == false, function ($query) {
                $unitID = Unit::where('name', $this->unit)->first()->id;
                return $query->where('unit_id', $unitID)->orWhere('name', '-');
            }, function ($query) {
                return $query->when($this->department !== null && $this->department !== '-' && $this->inputDepartment == false && $this->inputEmployee == false, function ($query) {
                    $departmentID = Department::where('name', $this->department)->first()->id;
                    $unitIds = Unit::where('department_id', $departmentID)->orWhere('name', '-')->pluck('id');
                    return $query->whereIn('unit_id', $unitIds)->orWhere('name', '-');
                });
            });

        return $result->orderBy('name', 'ASC')->get();
    }

    public function render()
    {
        $items = $this->getItems();
        $categories = Category::orderBy('name', 'ASC')->get();
        $departments = Department::orderBy('name', 'ASC')->get();
        $units = $this->getUnits();
        $employees = $this->getEmployees();

        return view('livewire.tableau-component', compact('items', 'categories', 'departments', 'units', 'employees'));
    }



    //
}
