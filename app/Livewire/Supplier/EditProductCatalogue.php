<?php

namespace App\Livewire\Supplier;

use App\Models\SupplierProduct;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class EditProductCatalogue extends Component
{
    #[Layout('layouts.supplier')]

    public int $productId;
    public SupplierProduct $product;
    public string $initialMethod = 'manual';

    public function mount($id)
    {
        $this->productId = $id;

        // Scope defensively to guarantee a vendor cannot inject another supplier's integer ID
        $this->product = SupplierProduct::where('id', $id)
            ->where('supplier_profile_id', Auth::guard('supplier')->user()->id)
            ->firstOrFail();

        // Dynamically detect creation method state for Alpine's frontend container toggles
        $this->initialMethod = $this->product->product_catalogue ? 'upload' : 'manual';
    }

    public function render()
    {
        return view('livewire.supplier.edit-product-catalogue');
    }
}
