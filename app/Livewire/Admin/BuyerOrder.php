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
    public function uploadAdminInvoice()
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

        $order = OrderModel::where('id', $orderId)
            ->where('buyer_profile_id', $this->buyerId)
            ->firstOrFail();

        $order->update([
            'order_progress' => $newStatus
        ]);

        session()->flash('success', "Order reference #{$order->order_ref_number} status updated to '{$newStatus}'.");
    }

    public function updateShipmentStatus(int $orderId, string $newStatus)
    {
        $order = OrderModel::where('id', $orderId)
            ->where('buyer_profile_id', $this->buyerId)
            ->firstOrFail();

        $order->update([
            'shipment_status' => $newStatus
        ]);

        session()->flash('success', "Order reference #{$order->order_ref_number} shipment track status switched to '{$newStatus}'.");
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
