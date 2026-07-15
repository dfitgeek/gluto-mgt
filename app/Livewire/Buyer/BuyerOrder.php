<?php

namespace App\Livewire\Buyer;

use App\Models\BuyerOrder as OrderModel;
use App\Services\NotificationMailService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class BuyerOrder extends Component
{
    use WithFileUploads;

    #[Layout('layouts.buyer')]

    // Modal state controllers
    public bool $isReceiptModalOpen = false;
    public ?int $activeOrderId = null;

    // Asynchronous file streaming collectors
    public $receipt_file;

    protected array $rules = [
        'receipt_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB per upload instance
    ];

    /**
     * Display the contextual popup upload box for a target order item node.
     */
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
     * Upload and append a fresh verification receipt node to the order's payment metadata array.
     */
    public function appendReceipt()
    {
        $this->validate();

        $buyer = Auth::guard('buyer')->user();

        $order = OrderModel::where('id', $this->activeOrderId)
            ->where('buyer_profile_id', $buyer->id)
            ->firstOrFail();

        // Stream binary upload payload straight to public disk channels
        $savedPath = $this->receipt_file->store('buyer_receipts', 'public');
        $fileName = $this->receipt_file->getClientOriginalName();

        // Parse existing payment_meta payloads data safely
        $meta = $order->payment_meta ?? [];
        if (!is_array($meta)) {
            $meta = [];
        }

        // Initialize structured attachment subarrays if not currently built on the model
        if (!isset($meta['receipts'])) {
            $meta['receipts'] = [];
        }

        // Append fresh metadata track object
        $meta['receipts'][] = [
            'file_path' => $savedPath,
            'uploaded_at' => now()->toDateTimeString(),
            'file_name' => $fileName
        ];

        $order->update([
            'payment_meta' => $meta
        ]);

        try {
            // Resolve the email to prevent null type errors
            $buyerEmail = $buyer->rep_email ?? $buyer->email ?? 'System Upload';

            // Dispatch the alert to the admin network
            NotificationMailService::notifyAdminOfBuyerReceiptUpload($order, $fileName, $buyerEmail);

            $this->closeReceiptModal();
            session()->flash('success', 'Your payment verification receipt has been appended to the order ledger context successfully.');

        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Admin receipt notification failed: ' . $e->getMessage());

            $this->closeReceiptModal();
            session()->flash('warning', 'Your payment verification receipt has been saved successfully, but we experienced an issue alerting the admin team.');
        }
    }

    /**
     * Purge an explicitly specified receipt index element from the model's structural array history.
     */
    public function deleteReceipt(int $orderId, int $receiptIndex)
    {
        $order = OrderModel::where('id', $orderId)
            ->where('buyer_profile_id', Auth::guard('buyer')->id())
            ->firstOrFail();

        $meta = $order->payment_meta;

        if (isset($meta['receipts'][$receiptIndex])) {
            // Delete raw asset from storage container disk cleanly
            Storage::disk('public')->delete($meta['receipts'][$receiptIndex]['file_path']);

            // Unset data block item node
            unset($meta['receipts'][$receiptIndex]);

            // Re-index layout values sequence frames cleanly
            $meta['receipts'] = array_values($meta['receipts']);

            $order->update([
                'payment_meta' => $meta
            ]);

            session()->flash('success', 'The targeted billing receipt asset reference has been deleted from the profile ledger.');
        }
    }

    public function render()
    {
        // Fetch all specific corporate orders associated strictly with the active logged-in buyer session
        $historicalOrders = OrderModel::where('buyer_profile_id', Auth::guard('buyer')->id())
            ->latest()
            ->get();

        return view('livewire.buyer.buyer-order', [
            'orders' => $historicalOrders
        ]);
    }
}
