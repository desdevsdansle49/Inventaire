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

    private $linkedDepartment;
    private $linkedUnit;
    private $linkedEmployee;

    public function getDataDepartment($name)
    {
        $departmentName = $name;
        $this->linkedDepartment = Department::with(['units.employees'])->where('name', $departmentName)->get();
    }
    public function getDataUnit($unit)
    {
        $decodedUnit = json_decode($unit);
        $this->linkedUnit = $decodedUnit->name;
        $this->linkedDepartment = Department::where('id', $decodedUnit->id)->first();
    }
    public function getDataEmployee($name)
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
        ]);
    }
}
