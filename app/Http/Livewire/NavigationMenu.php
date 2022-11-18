<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NavigationMenu extends Component
{
    public $routename = "";

    public function mount()
    {
        $this->routename = \Route::current()->uri;
    }

    public function render()
    {  
        return view('livewire.navigation-menu');
    }
}
