<?php

namespace App\Livewire\Admin;

use App\Models\SupplierProduct;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

class SuppliersProductCatalogue extends Component
{
    #[Layout('layouts.admin')]

    #[Url(history: true)]
    public string $search = '';

    #[Url(history: true)]
    public string $categoryFilter = 'All';

    public ?int $selectedProductId = null;
    public ?SupplierProduct $selectedProduct = null;

    // Active Basket Staging Array Matrix in Memory
    public array $basket = [];

    public function mount()
    {
        $this->basket = session()->get('admin_procurement_basket', []);
    }

    public function setCategory(string $category)
    {
        $this->categoryFilter = $category;
        $this->closeModal();
    }

    public function inspectProduct(int $id)
    {
        $this->selectedProductId = $id;
        $this->selectedProduct = SupplierProduct::with('supplier')->findOrFail($id);
        $this->dispatch('open-marketplace-modal');
    }

    public function closeModal()
    {
        $this->reset(['selectedProductId', 'selectedProduct']);
        $this->dispatch('close-marketplace-modal');
    }

    /**
     * Stage an individual catalog listing directly into the basket (Multi-Vendor Allowed).
     */
    public function toggleAddToBasket(int $productId)
    {
        $product = SupplierProduct::findOrFail($productId);

        if (isset($this->basket[$productId])) {
            unset($this->basket[$productId]);
        } else {
            $this->basket[$productId] = [
                'supplier_product_id' => $product->id,
                'supplier_profile_id' => $product->supplier_profile_id,
                'product_ref' => $product->product_ref,
                'product_name' => $product->product_name,
                'order_quantity' => $product->pcs_per_case > 0 ? $product->pcs_per_case : 100,
                'negotiated_price_per_unit' => (float) $product->price_pieces,
                'total_item_price' => (float) $product->price_pieces * ($product->pcs_per_case > 0 ? $product->pcs_per_case : 100)
            ];
        }

        session()->put('admin_procurement_basket', $this->basket);
    }

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
        $query = SupplierProduct::query()->with('supplier');

        if (filled($this->search)) {
            $query->where(function ($sub) {
                $sub->where('product_name', 'like', '%' . $this->search . '%')
                    ->orWhere('product_ref', 'like', '%' . $this->search . '%')
                    ->orWhere('ean_upc_code', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->categoryFilter !== 'All' && empty($this->search)) {
            $query->where('product_category', $this->categoryFilter);
        }

        $counts = [
            'All' => SupplierProduct::count(),
            'Organic' => SupplierProduct::where('product_category', 'Organic')->count(),
            'Gluten-Free' => SupplierProduct::where('product_category', 'Gluten-Free')->count(),
            'Non-Gluten' => SupplierProduct::where('product_category', 'Non-Gluten')->count(),
            'FMCG' => SupplierProduct::where('product_category', 'FMCG')->count(),
        ];

        return view('livewire.admin.suppliers-product-catalogue', [
            'products' => $query->latest()->get(),
            'categoryCounts' => $counts
        ]);
    }
}
