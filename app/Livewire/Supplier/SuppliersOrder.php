<?php

namespace App\Livewire\Supplier;

use App\Models\AdminOrder;
use App\Services\NotificationMailService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class SuppliersOrder extends Component
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

        $supplier = Auth::guard('supplier')->user();
        $supplierId = $supplier->id;

        // Security check: Verify order belongs explicitly to the logged-in supplier
        // Eager load 'supplier' so the notification service can access the email property cleanly
        $order = AdminOrder::with('supplier')->where('id', $this->activeOrderId)
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
            'order_meta' => $meta,
            'order_status' => 'Invoice'
        ]);

        try {
            // Safely resolve the uploader's email
            $supplierEmail = $supplier->rep_email;

            // 1. Alert the Admin network that an invoice is ready for review
            NotificationMailService::notifyAdminOfSupplierInvoice($order, $supplierEmail);

            // 2. Dispatch the acknowledgment receipt to the Supplier
            NotificationMailService::notifySupplierOfInvoiceConfirmation($order);

            $this->closeInvoiceModal();
            session()->flash('success', "Commercial proforma invoice document successfully dispatched for Order #{$order->purchase_order_number}.");

        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Invoice upload notifications failed: ' . $e->getMessage());

            $this->closeInvoiceModal();
            session()->flash('warning', "Commercial proforma invoice document successfully dispatched for Order #{$order->purchase_order_number}, but we experienced an issue dispatching the email notifications.");
        }
    }

    /**
     * Dynamically update the core order processing pipeline track milestone flag.
     */
    public function updateOrderStatus(int $orderId, string $newStatus)
    {
        $supplierId = Auth::guard('supplier')->user()->id;

        // Authorize and pull order matching the supplier profile context
        // Eager load the supplier relation for safe email retrieval
        $order = AdminOrder::with('supplier')->where('id', $orderId)
            ->where('supplier_profile_id', $supplierId)
            ->firstOrFail();

        $order->update([
            'order_status' => $newStatus
        ]);

        try {
            // Safely resolve the supplier's email
            $supplierEmail = $order->supplier->rep_email ?? $order->supplier->email ?? 'No email provided';

            // Dispatch the alert to the admin network
            NotificationMailService::notifyAdminOfSupplierStatusUpdate($order, 'Order Progress', $newStatus, $supplierEmail);

            session()->flash('success', "Order reference #{$order->purchase_order_number} shifted to milestone status '{$newStatus}'.");

        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Admin status notification failed: ' . $e->getMessage());

            session()->flash('warning', "Order reference #{$order->purchase_order_number} shifted to milestone status '{$newStatus}', but we experienced an issue alerting the administrative team.");
        }
    }

    /**
     * Dynamically update the logistical freight tracking shipment parameter state flag.
     */
    public function updateShipmentStatus(int $orderId, string $newStatus)
    {
        $supplierId = Auth::guard('supplier')->user()->id;

        // Authorize and pull order matching the supplier profile context
        // Eager load the supplier relation for safe email retrieval
        $order = AdminOrder::with('supplier')->where('id', $orderId)
            ->where('supplier_profile_id', $supplierId)
            ->firstOrFail();

        $order->update([
            'shipment_status' => $newStatus
        ]);

        try {
            // Safely resolve the supplier's email
            $supplierEmail = $order->supplier->rep_email ?? $order->supplier->email ?? 'No email provided';

            // Dispatch the alert to the admin network
            NotificationMailService::notifyAdminOfSupplierStatusUpdate($order, 'Shipment Status', $newStatus, $supplierEmail);

            session()->flash('success', "Order reference #{$order->purchase_order_number} shipment track updated to '{$newStatus}'.");

        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Admin shipment notification failed: ' . $e->getMessage());

            session()->flash('warning', "Order reference #{$order->purchase_order_number} shipment track updated to '{$newStatus}', but we experienced an issue alerting the administrative team.");
        }
    }

    public function render()
    {
        $supplierId = Auth::guard('supplier')->user()->id;

        // Pull all orders targeted to this supplier, regardless of which admin (user_id) created it
        $associatedOrders = AdminOrder::where('supplier_profile_id', $supplierId)
            ->latest()
            ->get();

        return view('livewire.supplier.suppliers-order', [
            'orders' => $associatedOrders
        ]);
    }
}
