<?php

namespace App\Http\Livewire;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Unit;
use Livewire\Component;

class DepartmentTable extends Component
{

    private $resultDepartment;
    private $resultUnit;
    private $resultEmployee;
    public $query = '';

    public $linkedDepartment;
    public $allDepartment;
    public $linkedUnit;
    public $allUnit;
    public $linkedEmployee;
    public $allEmployee;

    public $departmentName;
    public $departmentName2;
    public $departmentId;
    public $unitName;
    public $unitName2;
    public $unitId;
    public $employeeName;
    public $employeeName2;
    public $employeeId;

    public $selectForEmployee;
    public $selectForUnit;
    public $test;

    public $fromEdit = false;

    protected $rules = [
        'departmentName' => 'required | unique:items| String',
        'unitName' => 'required | unique:items| String',
        'employeeName' => 'required | unique:items| String',

    ];

    protected $messages = [
        'departmentName.required' => 'Champ obligatoire',
        'departmentName.unique' => 'Cette item existe déjà',
        'unitName.required' => 'Champ obligatoire',
        'unitName.unique' => 'Cette item existe déjà',
        'employeeName.required' => 'Champ obligatoire',
        'employeeName.unique' => 'Cette item existe déjà',

    ];

    public function getDataDepartment($department)
    {
        $this->fromEdit = true;
        $decodedDepartment = json_decode($department);
        $this->departmentName = $this->departmentName2 =  $decodedDepartment->name;
        $this->departmentId = $decodedDepartment->id;
    }

    public function getDataUnit($unit)
    {
        $this->fromEdit = true;
        $decodedUnit = json_decode($unit);
        $this->unitName = $this->unitName2 = $decodedUnit->name;
        $this->unitId = $decodedUnit->id;
        $this->linkedDepartment = Department::where('id', $decodedUnit->department_id)->first();
        $this->allDepartment = Department::get();

        $this->selectForUnit = $this->linkedDepartment->id;
    }

    public function getDataEmployee($employee)
    {
        $this->fromEdit = true;
        $decodedEmployee = json_decode($employee);
        $this->employeeName = $this->employeeName2 = $decodedEmployee->name;
        $this->employeeId =  $decodedEmployee->id;
        $this->linkedUnit = Unit::where('id', $decodedEmployee->unit_id)->first();
        $this->allUnit = Unit::get();
        $this->selectForEmployee = $this->linkedUnit->id;
    }

    public function removeUnit()
    {
        Unit::removeUnit($this->unitId);
    }

    public function removeEmployee()
    {
        Employee::removeEmployee($this->employeeId);
    }

    public function removeDepartment()
    {
        Department::removeDepartment($this->departmentId);
    }

    public function editUnit()
    {
        if ($this->selectForUnit != $this->linkedDepartment['id']) {
            Unit::editUnit($this->unitId, $this->selectForUnit);
        }
        if ($this->unitName2 != $this->unitName) {
            Unit::where('id', $this->unitId)->update(['name' => $this->unitName]);
        }
    }

    public function editEmployee()
    {
        if ($this->selectForEmployee != $this->linkedUnit['id']) {
            Employee::editEmployee($this->employeeId, $this->selectForEmployee);
        }
    }

    public function editDepartment()
    {
        $this->validateOnly($this->departmentName);
        Department::where('name', $this->departmentName2)->update(['name' => $this->departmentName]);
    }

    public function render()
    {

        $this->resultDepartment = Department::searchResult($this->query);
        $this->resultUnit = Unit::where('name', 'like', '%' . $this->query . '%')->orderBy('name', 'ASC')->paginate(10);
        $this->resultEmployee = Employee::where('name', 'like', '%' . $this->query . '%')->orderBy('name', 'ASC')->paginate(10);
        return view('livewire.department-table', [
            'resultDepartment' => $this->resultDepartment,
            'resultUnit' => $this->resultUnit,
            'resultEmployee' => $this->resultEmployee,
            'linkedDepartment' => $this->linkedDepartment,
            'allDepartment' => $this->allDepartment,
            'linkedUnit' => $this->linkedUnit,
            'allUnit' => $this->allUnit,
            'linkedEmployee' => $this->linkedEmployee,
            'allEmployee' => $this->allEmployee,
        ]);
    }
}
