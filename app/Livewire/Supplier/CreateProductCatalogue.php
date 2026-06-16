<?php

namespace App\Livewire\Supplier;

use Livewire\Attributes\Layout;
use Livewire\Component;

class CreateProductCatalogue extends Component
{
    #[Layout('layouts.supplier')]

    public function render()
    {
        return view('livewire.supplier.create-product-catalogue');
    }
}
