<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Department;
use App\Models\Unit;
use App\Models\Employee;
use App\Models\Item;

class TransactionChart extends Component
{

    public function itemData()
    {
        $items = Item::select('name')->distinct()->orderBy('name')->get();
        return $items;
    }


    public function departmentData()
    {
        $departments = Department::with(['transactions.item', 'transactions.employee'])
            ->withCount('transactions')
            ->get();

        $results = [];
        foreach ($departments as $department) {
            $departmentName = $department->name;
            $items = [];

            foreach ($department->transactions as $transaction) {
                $itemName = $transaction->item->name;

                if (!array_key_exists($itemName, $items)) {
                    $items[$itemName] = [
                        'itemName' => $itemName,
                        'itemNumber' => 0,
                    ];
                }

                $items[$itemName]['itemNumber'] += 1;
            }

            $total = $department->transactions_count;

            $results[] = [
                'name' => $departmentName,
                'items' => array_values($items),
                'total' => $total,
            ];
        }


        return $results;
    }

    public function unitData()
    {
        $units = Unit::with(['transactions.item', 'transactions.employee'])
            ->withCount('transactions')
            ->get();

        $results = [];
        foreach ($units as $unit) {
            $unitName = $unit->name;
            $items = [];

            foreach ($unit->transactions as $transaction) {
                $itemName = $transaction->item->name;

                if (!array_key_exists($itemName, $items)) {
                    $items[$itemName] = [
                        'itemName' => $itemName,
                        'itemNumber' => 0,
                    ];
                }

                $items[$itemName]['itemNumber'] += 1;
            }

            $total = $unit->transactions_count;

            $results[] = [
                'name' => $unitName,
                'items' => array_values($items),
                'total' => $total,
            ];
        }

        return $results;
    }

    public function employeeData()
    {
        $employees = Employee::with(['transactions.item', 'transactions.unit'])
            ->withCount('transactions')
            ->get();

        $results = [];
        foreach ($employees as $employee) {
            $employeeName = $employee->name;
            $items = [];

            foreach ($employee->transactions as $transaction) {
                $itemName = $transaction->item->name;

                if (!array_key_exists($itemName, $items)) {
                    $items[$itemName] = [
                        'itemName' => $itemName,
                        'itemNumber' => 0,
                    ];
                }

                $items[$itemName]['itemNumber'] += 1;
            }

            $total = $employee->transactions_count;

            $results[] = [
                'name' => $employeeName,
                'items' => array_values($items),
                'total' => $total,
            ];
        }

        return $results;
    }

    public function render()
    {
        return view('livewire.transaction-chart', [
            "departments" => $this->departmentData(),
            "units" => $this->unitData(),
            "employees" => $this->employeeData(),
            "items" => $this->itemData(),
        ]);
    }
}
