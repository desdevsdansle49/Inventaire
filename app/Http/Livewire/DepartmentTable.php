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

    public $departmentName;
    public $unitName;
    public $employeeName;

    public function getDataDepartment($department)
    {
        $decodedDepartment = json_decode($department);
        $this->departmentName = $decodedDepartment->name;
    }

    public function getDataUnit($unit)
    {
        $decodedUnit = json_decode($unit);
        $this->unitName = $decodedUnit->name;
        $this->linkedDepartment = [
            'linked' => Department::where('id', $decodedUnit->department_id)->first(),
            'all' => Department::get()
        ];
    }
    public function getDataEmployee($employee)
    {
        $decodedEmployee = json_decode($employee);
        $this->employeeName = $decodedEmployee->name;
        $this->linkedUnit = [
            'linked' => Unit::where('id', $decodedEmployee->unit_id)->first(),
            'all' => Unit::get()
        ];
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
