<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class SupplierDashboard extends Component
{
    #[Layout('layouts.supplier')]
    public function render()
    {
        return view('livewire.supplier-dashboard');
    }
}
