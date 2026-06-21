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

    // Hydration parameters for structural modal inspections
    public ?int $selectedProductId = null;
    public ?SupplierProduct $selectedProduct = null;

    /**
     * Switch context categories cleanly.
     */
    public function setCategory(string $category)
    {
        $this->categoryFilter = $category;
        $this->closeModal();
    }

    public function inspectProduct(int $id)
    {
        $this->selectedProductId = $id;

        // Eager load the model relationship safely
        $this->selectedProduct = SupplierProduct::with('supplier')->findOrFail($id);

        $this->dispatch('open-marketplace-modal');
    }

    public function closeModal()
    {
        $this->reset(['selectedProductId', 'selectedProduct']);
    }

    public function render()
    {
        // Global catalog query accessible to authenticated buyers
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

        // Generate metrics for structural overview aggregates
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
