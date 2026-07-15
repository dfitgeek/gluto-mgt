<?php

namespace App\Livewire\Admin;

use App\Models\BuyerOrder as OrderModel;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;

class GeneralBuyerOrder extends Component
{
    use WithFileUploads;

    #[Layout('layouts.admin')]

    // Persist search query state inside browser history
    #[Url(history: true)]
    public string $search = '';

    // Allowed pipeline progress milestones configuration tracks
    public array $allowedStatuses = [
        'Pending',
        'Invoice',
        'Confirm Order',
        'Processing order',
        'Shipped Order',
        'Completed Order'
    ];

    // Modal view element controllers
    public bool $isInvoiceModalOpen = false;
    public ?int $activeQuoteId = null;
    public $invoice_file;

    protected array $rules = [
        'invoice_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240', // Max 10MB invoice allocations
    ];

    public function openInvoiceModal(int $quoteId)
    {
        $this->activeQuoteId = $quoteId;
        $this->reset('invoice_file');
        $this->isInvoiceModalOpen = true;
    }

    public function closeInvoiceModal()
    {
        $this->isInvoiceModalOpen = false;
        $this->reset(['activeQuoteId', 'invoice_file']);
    }

    /**
     * Upload an administrative commercial invoice asset and store it under payment_meta JSON.
     */
   /*  public function uploadAdminInvoice()
    {
        $this->validate();

        $order = OrderModel::findOrFail($this->activeQuoteId);
        $meta = $order->payment_meta ?? [];
        if (!is_array($meta)) {
            $meta = [];
        }

        if (isset($meta['supplier_invoice'])) {
            Storage::disk('public')->delete($meta['supplier_invoice']);
        }

        $savedPath = $this->invoice_file->store('supplier_invoices', 'public');
        $meta['supplier_invoice'] = $savedPath;

        $order->update([
            'payment_meta' => $meta,
            'order_progress' => 'Invoice'
        ]);

        $this->closeInvoiceModal();
        session()->flash('success', "Administrative commercial invoice successfully bound to RFQ ticket #{$order->order_ref_number}.");
    } */


    /**
     * Upload an administrative commercial invoice asset and store it under payment_meta JSON.
     */
    public function uploadAdminInvoice()
    {
        $this->validate();

        // Eager load 'buyer' so the notification service can access the email cleanly
        $order = OrderModel::with('buyer')->findOrFail($this->activeQuoteId);
        $meta = $order->payment_meta ?? [];
        if (!is_array($meta)) {
            $meta = [];
        }

        if (isset($meta['supplier_invoice'])) {
            Storage::disk('public')->delete($meta['supplier_invoice']);
        }

        $savedPath = $this->invoice_file->store('supplier_invoices', 'public');
        $fileName = $this->invoice_file->getClientOriginalName();
        $meta['supplier_invoice'] = $savedPath;

        $order->update([
            'payment_meta' => $meta,
            'order_progress' => 'Invoice'
        ]);

        try {
            // Safely resolve the buyer's email
            $buyerEmail = $order->buyer->rep_email ?? $order->buyer->email ?? 'No email provided';

            // Dispatch the alert to the buyer
            \App\Services\NotificationMailService::notifyBuyerOfAdminInvoice($order, $fileName, $buyerEmail);

            $this->closeInvoiceModal();
            session()->flash('success', "Administrative commercial invoice successfully bound to RFQ ticket #{$order->order_ref_number}.");

        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Buyer invoice notification failed: ' . $e->getMessage());

            $this->closeInvoiceModal();
            session()->flash('warning', "Administrative commercial invoice successfully bound to RFQ ticket #{$order->order_ref_number}, but we experienced an issue alerting the buyer.");
        }
    }

    /**
     * Dynamically update the overarching quote progress status milestone flag.
     */
    public function updateOrderStatus(int $orderId, string $newStatus)
    {
        if (!in_array($newStatus, $this->allowedStatuses)) {
            session()->flash('error', 'The selected pipeline progress status override value is invalid.');
            return;
        }

        // Eager load the buyer to access the email property cleanly
        $order = OrderModel::with('buyer')->findOrFail($orderId);
        $order->update(['order_progress' => $newStatus]);

        try {
            $buyerEmail = $order->buyer->rep_email ?? $order->buyer->email ?? 'No email provided';

            \App\Services\NotificationMailService::notifyBuyerOfStatusUpdate($order, 'Order Progress', $newStatus, $buyerEmail);

            session()->flash('success', "Quotation Reference #{$order->order_ref_number} switched to status milestone context '{$newStatus}'.");
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Order status notification failed: ' . $e->getMessage());

            session()->flash('warning', "Quotation Reference #{$order->order_ref_number} switched to '{$newStatus}', but we experienced an issue alerting the buyer.");
        }
    }

    /**
     * Dynamically update the logistical freight tracking shipment status flag.
     */
    public function updateShipmentStatus(int $orderId, string $newStatus)
    {
        // Eager load the buyer to access the email property cleanly
        $order = OrderModel::with('buyer')->findOrFail($orderId);
        $order->update(['shipment_status' => $newStatus]);

        try {
            $buyerEmail = $order->buyer->rep_email ?? $order->buyer->email ?? 'No email provided';

            \App\Services\NotificationMailService::notifyBuyerOfStatusUpdate($order, 'Shipment Status', $newStatus, $buyerEmail);

            session()->flash('success', "Logistical freight status for RFQ Ticket #{$order->order_ref_number} adjusted to '{$newStatus}'.");
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Shipment status notification failed: ' . $e->getMessage());

            session()->flash('warning', "Freight status for RFQ Ticket #{$order->order_ref_number} adjusted to '{$newStatus}', but we experienced an issue alerting the buyer.");
        }
    }

    public function render()
    {
        $query = OrderModel::query()->with('buyer');

        // Apply searching filters if input string contains character structures
        if (filled($this->search)) {
            $query->where(function ($sub) {
                $sub->where('order_ref_number', 'like', '%' . $this->search . '%')
                    // Deep search against nested dynamic JSON array keys mapping fields values
                    ->orWhere('quotation_items', 'like', '%' . $this->search . '%');
            });
        }

        return view('livewire.admin.general-buyer-order', [
            'quotes' => $query->latest()->get()
        ]);
    }
}
