<?php

namespace App\Livewire\Supplier;

use App\Models\AdminOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProformaOrder extends Component
{
    use WithFileUploads;

    #[Layout('layouts.supplier')]

    // Modal Staging State Controls
    public bool $isInvoiceModalOpen = false;
    public ?int $activeOrderId = null;
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
     * Upload the vendor proforma invoice document and store it inside the order_meta JSON layout.
     */
    public function uploadInvoice()
    {
        $this->validate();

        $supplierId = Auth::guard('supplier')->id();

        // Fetch order matching this specific authenticated wholesale profile
        $order = AdminOrder::where('id', $this->activeOrderId)
            ->where('supplier_profile_id', $supplierId)
            ->firstOrFail();

        $meta = $order->order_meta ?? [];
        if (!is_array($meta)) {
            $meta = [];
        }

        // Drop the old file asset disk link if re-uploading
        if (isset($meta['supplier_invoice'])) {
            Storage::disk('public')->delete($meta['supplier_invoice']);
        }

        $savedPath = $this->invoice_file->store('supplier_invoices', 'public');
        $meta['supplier_invoice'] = $savedPath;

        // Save metadata changes down to disk and auto-advance status to Invoice
        $order->update([
            'order_meta'   => $meta,
            'order_status' => 'Invoice'
        ]);

        $this->closeInvoiceModal();
        session()->flash('success', "Commercial proforma invoice document successfully dispatched for Order #{$order->purchase_order_number}.");
    }

    /**
     * Dynamically update the core order processing pipeline track milestone flag.
     */
    public function updateOrderStatus(int $orderId, string $newStatus)
    {
        $supplierId = Auth::guard('supplier')->id();

        $order = AdminOrder::where('id', $orderId)
            ->where('supplier_profile_id', $supplierId)
            ->firstOrFail();

        $order->update([
            'order_status' => $newStatus
        ]);

        session()->flash('success', "Order reference #{$order->purchase_order_number} shifted to milestone status '{$newStatus}'.");
    }

    /**
     * Dynamically update the logistical freight tracking shipment parameter state flag.
     */
    public function updateShipmentStatus(int $orderId, string $newStatus)
    {
        $supplierId = Auth::guard('supplier')->id();

        $order = AdminOrder::where('id', $orderId)
            ->where('supplier_profile_id', $supplierId)
            ->firstOrFail();

        $order->update([
            'shipment_status' => $newStatus
        ]);

        session()->flash('success', "Order reference #{$order->purchase_order_number} shipment track updated to '{$newStatus}'.");
    }

    public function render()
    {
        $supplierId = Auth::guard('supplier')->id();

        // Retrieve incoming procurement bundles belonging explicitly to this vendor
        $associatedOrders = AdminOrder::where('supplier_profile_id', $supplierId)
            ->latest()
            ->get();

        return view('livewire.supplier.proforma-order', [
            'orders' => $associatedOrders
        ]);
    }
}
