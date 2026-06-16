<?php

namespace App\Livewire\Supplier;

use App\Models\SupplierProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

class ManageProductCatalogue extends Component
{
    #[Layout('layouts.supplier')]

    #[Url(history: true)]
    public string $search = '';

    #[Url(history: true)]
    public string $categoryFilter = 'All';

    public ?int $selectedProductId = null;
    public ?SupplierProduct $selectedProduct = null;

    public function setCategoryFilter(string $category)
    {
        $this->categoryFilter = $category;
        $this->closeModal();
    }

    /**
     * Fetch targeted product specifications and dispatch the global Alpine trigger.
     */
    public function viewProduct(int $id)
    {
        $this->selectedProductId = $id;

        $this->selectedProduct = SupplierProduct::where('id', $id)
            ->where('supplier_profile_id', Auth::guard('supplier')->user()->id)
            ->first();

        if ($this->selectedProduct) {
            // Natively notifies the browser DOM that product parameters are hydrated and ready
            $this->dispatch('open-product-preview-modal');
        }
    }

    public function deleteProduct(int $id)
    {
        $product = SupplierProduct::where('id', $id)
            ->where('supplier_profile_id', Auth::guard('supplier')->user()->id)
            ->firstOrFail();

        if ($product->product_catalogue) {
            Storage::disk('public')->delete($product->product_catalogue);
        }

        if (is_array($product->product_images)) {
            foreach ($product->product_images as $imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        $product->delete();

        if ($this->selectedProductId === $id) {
            $this->closeModal();
        }

        session()->flash('success', "Product tracking entry '{$product->product_name}' was purged from the corporate ledger.");
    }

    public function closeModal()
    {
        $this->reset(['selectedProductId', 'selectedProduct']);
    }

    public function render()
    {
        $query = SupplierProduct::where('supplier_profile_id', Auth::guard('supplier')->user()->id);

        if (filled($this->search)) {
            $query->where(function ($subQuery) {
                $subQuery->where('product_name', 'like', '%' . $this->search . '%')
                    ->orWhere('product_ref', 'like', '%' . $this->search . '%')
                    ->orWhere('ean_upc_code', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->categoryFilter !== 'All' && empty($this->search)) {
            $query->where('product_category', $this->categoryFilter);
        }

        $supplierId = Auth::guard('supplier')->user()->id;
        $counts = [
            'All' => SupplierProduct::where('supplier_profile_id', $supplierId)->count(),
            'Organic' => SupplierProduct::where('supplier_profile_id', $supplierId)->where('product_category', 'Organic')->count(),
            'Gluten-Free' => SupplierProduct::where('supplier_profile_id', $supplierId)->where('product_category', 'Gluten-Free')->count(),
            'Non-Gluten' => SupplierProduct::where('supplier_profile_id', $supplierId)->where('product_category', 'Non-Gluten')->count(),
            'FMCG' => SupplierProduct::where('supplier_profile_id', $supplierId)->where('product_category', 'FMCG')->count(),
        ];

        return view('livewire.supplier.manage-product-catalogue', [
            'products' => $query->latest()->get(),
            'categoryCounts' => $counts
        ]);
    }
}
