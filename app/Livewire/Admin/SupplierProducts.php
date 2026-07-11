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

    // Active Basket Staging Array Matrix in Memory
    public array $basket = [];

    public function mount($id)
    {
        $this->supplierId = $id;
        $this->supplier = SupplierProfile::findOrFail($id);

        // Hydrate existing staged memory basket context array from the session cache
        $this->basket = session()->get('admin_procurement_basket', []);
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

    /**
     * Stage an individual catalogue listing array card item directly inside the active memory deck.
     */
    public function toggleAddToBasket(int $productId)
    {
        $product = SupplierProduct::where('id', $productId)
            ->where('supplier_profile_id', $this->supplierId)
            ->firstOrFail();

        if (isset($this->basket[$productId])) {
            unset($this->basket[$productId]);
        } else {
            $this->basket[$productId] = [
                'supplier_product_id' => $product->id,
                'supplier_profile_id' => $product->supplier_profile_id,
                'product_ref' => $product->product_ref,
                'product_name' => $product->product_name,
                'order_quantity' => $product->pcs_per_case > 0 ? $product->pcs_per_case : 100, // Safe default quantity fallback
                'negotiated_price_per_unit' => (float) $product->price_pieces,
                'total_item_price' => (float) $product->price_pieces * ($product->pcs_per_case > 0 ? $product->pcs_per_case : 100)
            ];
        }

        // Cache parameters back down to browser session memory levels
        session()->put('admin_procurement_basket', $this->basket);
    }

    /**
     * Dispatch the current staging collection straight to checkout.
     */
    public function proceedToCheckout()
    {
        if (empty($this->basket)) {
            session()->flash('error', "Your order selection basket deck is empty.");
            return;
        }

        return redirect()->route('admin.suppliers.checkout');
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
