<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Alpine extends Component
{
    public $count=5;
    
    public function render()
    {
        return view('livewire.alpine');
    }
}
