<?php

namespace App\Livewire\Admin;

use App\Models\SupplierProfile;
use App\Models\SupplierProduct;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

class SupplierProducts extends Component
{
    #[Layout('layouts.admin')]

    public int $supplierId;
    public SupplierProfile $supplier;

    // Real-time lookup bindings
    #[Url(history: true)]
    public string $search = '';

    // Modals target state properties
    public ?SupplierProduct $activeProductSpec = null;

    public function mount($id)
    {
        $this->supplierId = $id;
        $this->supplier = SupplierProfile::findOrFail($id);
    }

    /**
     * Hydrate a selected product model and dispatch the Alpine visibility event tracker.
     */
    public function inspectProductSpecs(int $productId)
    {
        $this->activeProductSpec = SupplierProduct::where('id', $productId)
            ->where('supplier_profile_id', $this->supplierId)
            ->first();

        if ($this->activeProductSpec) {
            $this->dispatch('open-admin-product-modal');
        }
    }

    public function closeSpecModal()
    {
        $this->reset('activeProductSpec');
    }

    public function render()
    {
        $productQuery = SupplierProduct::where('supplier_profile_id', $this->supplierId);

        if (filled($this->search)) {
            $productQuery->where(function ($sub) {
                $sub->where('product_name', 'like', '%' . $this->search . '%')
                    ->orWhere('product_ref', 'like', '%' . $this->search . '%')
                    ->orWhere('ean_upc_code', 'like', '%' . $this->search . '%');
            });
        }

        return view('livewire.admin.supplier-products', [
            'products' => $productQuery->latest()->get()
        ]);
    }
}
