<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;

class CatTab extends Component
{
    public $query;

    protected $result;

    protected $MyCategory;

    public function updatingQuery()
    {
        $this->reset();
    }

    public function render()
    {
        $this->result = Category::where('name', 'like', '%' . $this->query . '%')->orderBy('name', 'ASC')->paginate(10);

        return view('livewire.cat-tab', [
            'items' => $this->result
        ]);
    }
}
