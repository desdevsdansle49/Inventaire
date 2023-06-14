<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Department;
use App\Models\Unit;
use App\Models\Employee;
use App\Models\Item;
use App\Models\Transaction;

class TransactionChart extends Component
{

    public $itemName;

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
                if ($transaction->item) {
                    $itemName = $transaction->item->name;

                    if (!array_key_exists($itemName, $items)) {
                        $items[$itemName] = [
                            'itemName' => $itemName,
                            'itemNumber' => 0,
                        ];
                    }

                    $items[$itemName]['itemNumber'] += 1;
                }
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
                // Vérifiez que la relation 'item' n'est pas null
                if ($transaction->item) {
                    $itemName = $transaction->item->name;

                    if (!array_key_exists($itemName, $items)) {
                        $items[$itemName] = [
                            'itemName' => $itemName,
                            'itemNumber' => 0,
                        ];
                    }

                    $items[$itemName]['itemNumber'] += 1;
                }
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
                // Vérifiez que la relation 'item' n'est pas null
                if ($transaction->item) {
                    $itemName = $transaction->item->name;

                    if (!array_key_exists($itemName, $items)) {
                        $items[$itemName] = [
                            'itemName' => $itemName,
                            'itemNumber' => 0,
                        ];
                    }

                    $items[$itemName]['itemNumber'] += 1;
                }
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

    public function transactionData()
    {
        $date = date('Y-m-d H:i:s', strtotime('-30 days'));

        if ($this->itemName) {
            $item = Item::where("name", $this->itemName)->first("id");
            $transactions = Transaction::where("item_id", $item->id)->select(Transaction::raw('DATE(created_at) as date'), Transaction::raw('count(*) as count'))
                ->where('created_at', '>=', $date)
                ->groupBy('date')
                ->get();
        } else {
            $transactions = Transaction::select(Transaction::raw('DATE(created_at) as date'), Transaction::raw('count(*) as count'))
                ->where('created_at', '>=', $date)
                ->groupBy('date')
                ->get();
        }

        return $transactions;
    }

    public function render()
    {
        return view('livewire.transaction-chart', [
            "departments" => $this->departmentData(),
            "units" => $this->unitData(),
            "employees" => $this->employeeData(),
            "items" => $this->itemData(),
            "transactions" => $this->transactionData(),
        ]);
    }
}
