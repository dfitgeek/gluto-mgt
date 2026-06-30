<?php

namespace App\Livewire\Supplier;

use App\Models\BuyerOrder;
use App\Models\SupplierProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProformaOrder extends Component
{
    use WithFileUploads;

    #[Layout('layouts.supplier')]

    // Modal state parameters
    public bool $isInvoiceModalOpen = false;
    public ?int $activeOrderId = null;

    // File stream uploaded property
    public $invoice_file;

    protected array $rules = [
        'invoice_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240', // Max 10MB invoice files
    ];

    public function openInvoiceModal(int $orderId)
    {
        $this->activeOrderId = $orderId;
        $this->reset('invoice_file');
        $this->isInvoiceModalOpen = true;
    }

    public function closeInvoiceModal()
    {
        $this->isInvoiceModalOpen = false;
        $this->reset(['activeOrderId', 'invoice_file']);
    }

    /**
     * Upload and bind/replace the 'supplier_invoice' asset string token inside payment_meta JSON.
     */
    public function uploadInvoice()
    {
        $this->validate();

        $supplierId = Auth::guard('supplier')->id();

        // Security Lock: Ensure the order maps strictly back to a product belonging to this supplier
        $allowedProductRefs = SupplierProduct::where('supplier_profile_id', $supplierId)
            ->pluck('product_ref')
            ->toArray();

        $order = BuyerOrder::where('id', $this->activeOrderId)
            ->whereIn('prod_ref', $allowedProductRefs)
            ->firstOrFail();

        $meta = $order->payment_meta ?? [];
        if (!is_array($meta)) {
            $meta = [];
        }

        // Defensive Clean up: Erase old invoice from storage disk if replacing
        if (isset($meta['supplier_invoice'])) {
            Storage::disk('public')->delete($meta['supplier_invoice']);
        }

        // Store new asset stream snap
        $savedPath = $this->invoice_file->store('supplier_invoices', 'public');
        $meta['supplier_invoice'] = $savedPath;

        // Auto-advance order progression status context level to guide buyer flow if desired
        $order->update([
            'payment_meta' => $meta,
            'order_progress' => $order->order_progress === 'Unprocessed order' ? 'Processed Buyer' : $order->order_progress
        ]);

        $this->closeInvoiceModal();
        session()->flash('success', "Commercial invoice successfully dispatched to Order reference #{$order->order_ref_number}.");
    }

    public function render()
    {
        $supplierId = Auth::guard('supplier')->id();

        // 1. Gather all product reference protocol strings registered under this explicit supplier profile ID
        $myProductRefs = SupplierProduct::where('supplier_profile_id', $supplierId)
            ->pluck('product_ref')
            ->toArray();

        // 2. Fetch order rows matching those keys chronologically
        $associatedOrders = BuyerOrder::whereIn('prod_ref', $myProductRefs)
            ->latest()
            ->get();

        return view('livewire.supplier.proforma-order', [
            'orders' => $associatedOrders
        ]);
    }
}
