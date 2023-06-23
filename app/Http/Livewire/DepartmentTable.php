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
        'name' => 'required | unique:items| String',
        'quantity' => 'required | numeric | gte:0',
        'lowest' => 'nullable | numeric | gte:0',
    ];

    protected $messages = [
        'name.required' => 'Champ obligatoire',
        'name.unique' => 'Cette item existe déjà',
        'quantity.required' => 'Champ obligatoire',
        'quantity.gte' => 'Champ > 0',
        'lowest.numeric' => 'Champ > 0'
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
        Employee::where('unit_id', $this->unit['id'])->update(['unit_id' => '1']);
        Unit::where('id', $this->unit['id'])->delete();
    }

    public function removeEmployee()
    {
        Employee::where('id', $this->employee['id'])->delete();
    }

    public function removeDepartment()
    {
        Unit::where('department_id', $this->department['id'])->update(['department_id' => '1']);
        Department::where('id', $this->department['id'])->delete();
    }

    public function editUnit()
    {
        if ($this->selectForUnit != $this->linkedDepartment['id']) {
            Unit::where('id', $this->unit['id'])->update(['department_id' => $this->selectForUnit]);
        }
    }

    public function editEmployee()
    {
        if ($this->selectForEmployee != $this->linkedUnit['id']) {
            Employee::where('id', $this->employee['id'])->update(['unit_id' => $this->selectForEmployee]);
        }
    }

    public function editDepartment()
    {
    }

    public function render()
    {

        $this->resultDepartment = Department::where('name', 'like', '%' . $this->query . '%')->orderBy('name', 'ASC')->paginate(10);
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
