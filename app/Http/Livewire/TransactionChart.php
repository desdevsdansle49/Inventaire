<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Department;
use App\Models\Unit;
use App\Models\Employee;
use App\Models\Item;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;



class TransactionChart extends Component
{

    public $selectedItem = null;
    public $items;

    public function mount()
    {
        $this->items = Item::all();
    }
    public function updatedSelectedItem()
    {
        $this->dispatchBrowserEvent('contentChanged');
    }


    public function render()
    {
        $query = DB::table('transactions')
            ->where('created_at', '>=', now()->subDays(30))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date');

        if ($this->selectedItem) {
            $query->where('item_id', $this->selectedItem);
        }
        $transactions = $query->get()
            ->map(function ($transaction) {
                return (array) $transaction;
            });

        return view('livewire.transaction-chart', ['transactions' => collect($transactions)]);
    }
}
