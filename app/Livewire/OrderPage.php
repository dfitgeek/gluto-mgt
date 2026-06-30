<?php

namespace App\Livewire;

use App\Models\SupplierProduct;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

class OrderPage extends Component
{
    #[Layout('layouts.buyer')]

    #[Url(history: true)]
    public string $search = '';

    #[Url(history: true)]
    public string $categoryFilter = 'All';

    public ?int $selectedProductId = null;
    public ?SupplierProduct $selectedProduct = null;

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
    }

    /**
     * Redirect the active session directly into the specific Order Quoting Provisioning Sheet.
     */
    public function initiateOrderFlow()
    {
        return redirect()->route('orders.create', [
            'product_id' => $this->selectedProductId
        ]);
    }

    public function render()
    {
        $query = SupplierProduct::query();

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

        return view('livewire.order-page', [
            'products' => $query->latest()->get(),
            'categoryCounts' => $counts
        ]);
    }
}
