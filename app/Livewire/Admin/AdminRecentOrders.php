<?php

namespace App\Livewire\Admin;

use App\Models\AdminOrder;
use App\Services\NotificationMailService;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminRecentOrders extends Component
{
    use WithFileUploads;

    #[Layout('layouts.admin')]

    // Persist live search input query inside the browser history track parameters
    #[Url(history: true)]
    public string $search = '';

    // Modal view window state controllers
    public bool $isReceiptModalOpen = false;
    public ?int $activeOrderId = null;

    // File upload binary handle streaming collector
    public $receipt_file;

    protected array $rules = [
        'receipt_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240', // Max 10MB payment documents
    ];

    public function openReceiptModal(int $orderId)
    {
        $this->activeOrderId = $orderId;
        $this->reset('receipt_file');
        $this->isReceiptModalOpen = true;
    }

    public function closeReceiptModal()
    {
        $this->isReceiptModalOpen = false;
        $this->reset(['activeOrderId', 'receipt_file']);
    }

    /**
     * Upload an administrative bank payment slip receipt and append it to order_meta.
     */
    public function uploadPaymentReceipt()
    {
        $this->validate();

        // Eager load the supplier profile relation to easily grab the email
        $order = AdminOrder::findOrFail($this->activeOrderId);

        $meta = $order->order_meta ?? [];
        if (!is_array($meta)) {
            $meta = [];
        }

        // Clean up previous files if replacing a single receipt snapshot instance
        if (isset($meta['admin_payment_receipt'])) {
            Storage::disk('public')->delete($meta['admin_payment_receipt']);
        }

        // Store file onto disk channels securely
        $savedPath = $this->receipt_file->store('admin_payment_receipts', 'public');
        $fileName = $this->receipt_file->getClientOriginalName();
        $meta['admin_payment_receipt'] = $savedPath;

        // dd($order->supplier);

        // Automatically update the order status tracking flag block context cleanly
        $order->update([
            'order_meta' => $meta,
            // 'order_status' => 'Accepted' // Mark as Accepted/Paid configuration milestone
        ]);

        try {
            // Safely resolve the supplier's email based on your schema (adjust property name if needed)


            $supplierEmail = $order->supplier->rep_email ?? $order->supplier->rep_email;

            // Dispatch the alert to the supplier
            NotificationMailService::notifySupplierOfAdminPaymentReceipt($order, $fileName, $supplierEmail);

            $this->closeReceiptModal();
            session()->flash('success', "Payment receipt remittance asset successfully pinned to PO ticket #{$order->purchase_order_number}.");

        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Supplier remittance notification failed: ' . $e->getMessage());

            $this->closeReceiptModal();
            session()->flash('warning', "Payment receipt remittance asset successfully pinned to PO ticket #{$order->purchase_order_number}, but we experienced an issue alerting the supplier.");
        }
    }

    public function render()
    {
        // Build base query eager loading the parent supplier relationship details
        $query = AdminOrder::query()->with('supplier');

        // Apply real-time debounced searching parameters matching user intents
        if (filled($this->search)) {
            $query->where(function ($sub) {
                $sub->where('purchase_order_number', 'like', '%' . $this->search . '%')
                    ->orWhere('order_items', 'like', '%' . $this->search . '%');
            });
        }

        return view('livewire.admin.admin-recent-orders', [
            'orders' => $query->latest()->get()
        ]);
    }
}
