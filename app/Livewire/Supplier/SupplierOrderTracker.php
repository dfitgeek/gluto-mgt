<?php

namespace App\Livewire\Supplier;

use App\Models\AdminOrder;
use App\Models\AdminOrderTracker;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class SupplierOrderTracker extends Component
{
    use WithFileUploads;

    #[Layout('layouts.supplier')]

    public int $orderId;
    public AdminOrder $order;

    // Form Input Properties
    public string $replyMessage = '';
    public string $messageSubject = 'Document Update Submission';

    // File Upload Targets mapping to Migration Schema JSON Columns
    public $uploadedFile;
    public string $targetFileField = 'file_commercial_invoice';

    public function mount(int $orderId)
    {
        $this->orderId = $orderId;
        $supplierId = Auth::guard('supplier')->id();

        $this->order = AdminOrder::where('id', $this->orderId)
            ->where('supplier_profile_id', $supplierId)
            ->firstOrFail();
    }

    public function sendSupplierReply()
    {
        $this->validate([
            'replyMessage' => 'required|string|min:2|max:5000',
            'messageSubject' => 'required|string|max:255',
            'uploadedFile' => 'nullable|file|mimes:pdf,jpg,jpeg,png,xlsx|max:12288', // Max 12MB
        ]);

        $filePayload = null;
        if ($this->uploadedFile) {
            $path = $this->uploadedFile->store('order_audit_vault', 'public');
            $filePayload = [
                'file_path' => $path,
                'file_name' => $this->uploadedFile->getClientOriginalName(),
                'uploaded_at' => now()->toDateTimeString()
            ];
        }

        // Base structural insert map
        $insertData = [
            'admin_order_id' => $this->order->id,
            'user_id' => null,
            'supplier_profile_id' => Auth::guard('supplier')->id(),
            'subject' => $this->messageSubject,
            'message_content' => $this->replyMessage,
            'resolution_status' => 'Pending Response',
            'is_internal_only' => false,
        ];

        // Dynamically append file reference into the selected column if a file exists
        if ($filePayload) {
            $insertData[$this->targetFileField] = $filePayload;
        }

        AdminOrderTracker::create($insertData);

        $this->reset(['replyMessage', 'uploadedFile']);
        session()->flash('success', 'Your message and supporting document asset have been cleanly appended to the thread.');
    }

    public function render()
    {
        $discussionTrail = AdminOrderTracker::where('admin_order_id', $this->order->id)
            ->where('is_internal_only', false)
            ->with(['supplier', 'administrator'])
            ->oldest()
            ->get();

        return view('livewire.supplier.supplier-order-tracker', [
            'messages' => $discussionTrail
        ]);
    }
}
