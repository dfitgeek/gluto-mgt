<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class ManageBuyers extends Component
{
    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.manage-buyers');
    }
}
