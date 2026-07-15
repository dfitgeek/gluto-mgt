<?php

namespace App\Livewire\Admin;

use App\Models\BuyerOrder as OrderModel;
use App\Models\BuyerProfile;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;

class BuyerOrder extends Component
{
    use WithFileUploads;

    #[Layout('layouts.admin')]

    // Route identifier handshakes
    public int $buyerId;
    public BuyerProfile $buyerProfile;

    // Persist search query query-string state inside the browser history logs
    #[Url(history: true)]
    public string $search = '';

    // Allowed pipeline progression track variables
    public array $allowedStatuses = [
        'Pending',
        'Invoice',
        'Confirm Order',
        'Processing order',
        'Shipped Order',
        'Completed Order'
    ];

    // Modal view states
    public bool $isInvoiceModalOpen = false;
    public ?int $activeQuoteId = null;
    public $invoice_file;

    protected array $rules = [
        'invoice_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240', // Max 10MB invoice files
    ];

    /**
     * Hydrate component parameters directly using the URL resource model token.
     */
    public function mount(int $id)
    {
        $this->buyerId = $id;
        // Verify that the buyer profile exists in the database
        $this->buyerProfile = BuyerProfile::findOrFail($this->buyerId);
    }

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
     * Upload an administrative invoice document and bind it to payment_meta.
     */
   /*  public function uploadAdminInvoice()
    {
        $this->validate();

        // Ensure the order belongs to this specific buyer profile resource context
        $order = OrderModel::where('id', $this->activeQuoteId)
            ->where('buyer_profile_id', $this->buyerId)
            ->firstOrFail();

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
        session()->flash('success', "Administrative invoice document successfully pushed to Quote reference #{$order->order_ref_number}.");
    } */

    /**
     * Upload an administrative invoice document and bind it to payment_meta.
     */
    public function uploadAdminInvoice()
    {
        $this->validate();

        // Ensure the order belongs to this specific buyer profile resource context
        // Eager load 'buyer' so the notification service can access the email cleanly
        $order = OrderModel::with('buyer')->where('id', $this->activeQuoteId)
            ->where('buyer_profile_id', $this->buyerId)
            ->firstOrFail();

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
            $buyerEmail = $order->buyer->rep_email;

            // Dispatch the alert to the buyer
            \App\Services\NotificationMailService::notifyBuyerOfAdminInvoice($order, $fileName, $buyerEmail);

            $this->closeInvoiceModal();
            session()->flash('success', "Administrative invoice document successfully pushed to Quote reference #{$order->order_ref_number}.");

        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Buyer invoice notification failed: ' . $e->getMessage());

            $this->closeInvoiceModal();
            session()->flash('warning', "Administrative invoice document successfully pushed to Quote reference #{$order->order_ref_number}, but we experienced an issue alerting the buyer.");
        }
    }

    /**
     * Update the progress status for an explicit quote record under this buyer.
     */
    public function updateOrderStatus(int $orderId, string $newStatus)
    {
        if (!in_array($newStatus, $this->allowedStatuses)) {
            session()->flash('error', 'The selected status override value is invalid.');
            return;
        }

        // Eager load the buyer relation
        $order = OrderModel::with('buyer')->where('id', $orderId)
            ->where('buyer_profile_id', $this->buyerId)
            ->firstOrFail();

        $order->update([
            'order_progress' => $newStatus
        ]);

        try {
            $buyerEmail = $order->buyer->rep_email ?? $order->buyer->email ?? 'No email provided';

            \App\Services\NotificationMailService::notifyBuyerOfStatusUpdate($order, 'Order Progress', $newStatus, $buyerEmail);

            session()->flash('success', "Order reference #{$order->order_ref_number} status updated to '{$newStatus}'.");
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Order status notification failed: ' . $e->getMessage());

            session()->flash('warning', "Order reference #{$order->order_ref_number} status updated to '{$newStatus}', but we experienced an issue alerting the buyer.");
        }
    }

    public function updateShipmentStatus(int $orderId, string $newStatus)
    {
        // Eager load the buyer relation
        $order = OrderModel::with('buyer')->where('id', $orderId)
            ->where('buyer_profile_id', $this->buyerId)
            ->firstOrFail();

        $order->update([
            'shipment_status' => $newStatus
        ]);

        try {
            $buyerEmail = $order->buyer->rep_email ?? $order->buyer->email ?? 'No email provided';

            \App\Services\NotificationMailService::notifyBuyerOfStatusUpdate($order, 'Shipment Status', $newStatus, $buyerEmail);

            session()->flash('success', "Order reference #{$order->order_ref_number} shipment track status switched to '{$newStatus}'.");
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Shipment status notification failed: ' . $e->getMessage());

            session()->flash('warning', "Order reference #{$order->order_ref_number} shipment track status switched to '{$newStatus}', but we experienced an issue alerting the buyer.");
        }
    }

    public function render()
    {
        // Fetch only quotes that belong to the active profile id
        $query = OrderModel::where('buyer_profile_id', $this->buyerId);

        // Apply dynamic conditional search criteria when filters are applied
        if (filled($this->search)) {
            $query->where(function ($sub) {
                $sub->where('order_ref_number', 'like', '%' . $this->search . '%')
                    ->orWhere('quotation_items', 'like', '%' . $this->search . '%');
            });
        }

        return view('livewire.admin.buyer-order', [
            'quotes' => $query->latest()->get()
        ]);
    }
}
