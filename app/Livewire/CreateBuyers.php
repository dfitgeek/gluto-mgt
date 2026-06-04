<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class CreateBuyers extends Component
{
    #[Layout('layouts.admin')]

    public function render()
    {
        return view('livewire.create-buyers');
    }
}
