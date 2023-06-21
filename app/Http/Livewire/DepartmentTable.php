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
    public $linkedUnit;
    public $linkedEmployee;

    public $department;
    public $unit;
    public $employee;

    public $selectForEmployee;
    public $selectForUnit;

    public function getDataDepartment($department)
    {
        $decodedDepartment = json_decode($department);
        $this->department = ['name' => $decodedDepartment->name, 'id' => $decodedDepartment->id];
    }

    public function getDataUnit($unit)
    {
        $decodedUnit = json_decode($unit);
        $this->unit = ['name' => $decodedUnit->name, 'id' => $decodedUnit];
        $this->linkedDepartment = [
            'linked' => Department::where('id', $decodedUnit->department_id)->first(),
            'all' => Department::get()
        ];
        $this->selectForUnit = $this->linkedDepartment['linked']->id;
    }

    public function getDataEmployee($employee)
    {
        $decodedEmployee = json_decode($employee);
        $this->employee = ['name' => $decodedEmployee->name, 'id' => $decodedEmployee->id];
        $this->linkedUnit = [
            'linked' => Unit::where('id', $decodedEmployee->unit_id)->first(),
            'all' => Unit::get()
        ];
        $this->selectForEmployee = $this->linkedUnit['linked']->id;
    }

    //livewire supprime la valeur de linkedVariable a chaque fois que SelectForVariable est appelé alors j'ai trouvé ca comme solution
    public function updatedSelectForEmployee($value)
    {
        $this->linkedUnit = [
            'linked' => Unit::where('id', $value)->first(),
            'all' => Unit::get()
        ];
    }

    public function updatedSelectForUnit($value)
    {
        $this->linkedDepartment = [
            'linked' => Department::where('id', $value)->first(),
            'all' => Department::get()
        ];
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
        if ($this->selectForUnit != $this->linkedDepartment['linked']['id']) {
            Unit::where('id', $this->unit['id'])->update(['department_id' => $this->selectForUnit]);
        }
    }

    public function editEmployee()
    {
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
            'linkedUnit' => $this->linkedUnit,
            'linkedEmployee' => $this->linkedEmployee,
        ]);
    }
}
