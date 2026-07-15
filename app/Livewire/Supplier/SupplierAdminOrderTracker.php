<?php

namespace App\Livewire\Supplier;

use App\Models\AdminOrder;
use App\Models\AdminOrderTracker;
use App\Services\NotificationMailService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class SupplierAdminOrderTracker extends Component
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
        $supplierId = Auth::guard('supplier')->user()->id;

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
            'supplier_profile_id' => \Illuminate\Support\Facades\Auth::guard('supplier')->user()->id,
            'subject' => $this->messageSubject,
            'message_content' => $this->replyMessage,
            'resolution_status' => 'Pending Response',
            'is_internal_only' => false,
        ];

        // Dynamically append file reference into the selected column if a file exists
        if ($filePayload) {
            $insertData[$this->targetFileField] = $filePayload;
        }

        try {
            // Wrap your database creation routine in a secure transaction
            \Illuminate\Support\Facades\DB::transaction(function () use ($insertData) {

                $tracker = \App\Models\AdminOrderTracker::create($insertData);

                if ($tracker) {
                    // Isolate mail delivery completely to safeguard component execution from connection timeouts
                    try {
                        // Trigger A (DYNAMIC FIX): Notifies back-office admins with the precise dynamic subject and message body text
                        \App\Services\NotificationMailService::notifyAdminOfSupplierConversation(
                            $this->order,
                            $this->messageSubject,
                            $this->replyMessage
                        );

                        // Trigger B: Notify the supplier themselves confirming safe receipt of the file
                        // \App\Services\NotificationMailService::notifySupplierOfInvoiceConfirmation($this->order);

                    } catch (\Exception $mailException) {
                        // 1. Log the system exception for backend review
                        \Illuminate\Support\Facades\Log::error('Gluto Email Service Delivery Failure: ' . $mailException->getMessage(), [
                            'order_id' => $this->order->id,
                            'supplier_id' => \Illuminate\Support\Facades\Auth::guard('supplier')->id()
                        ]);

                        // 2. Flash an operational warning to display on the frontend UI
                        session()->flash('mail_warning', 'Your updates were saved successfully, but Gluto International encountered a mail delivery delay.');
                    }
                }
            });

            $this->reset(['replyMessage', 'uploadedFile']);
            session()->flash('success', 'Your message and supporting document asset have been cleanly appended to the thread.');

        } catch (\Exception $dbException) {
            // Handle critical failures such as database drops or column constraint rejections
            \Illuminate\Support\Facades\Log::critical('Database Tracker Writing Failure: ' . $dbException->getMessage());

            $this->addError('replyMessage', 'System failed to register your tracker entry. Please check your file inputs and try again.');
        }
    }

    public function render()
    {
        $discussionTrail = AdminOrderTracker::where('admin_order_id', $this->order->id)
            ->where('is_internal_only', false)
            ->with(['supplier', 'administrator'])
            ->oldest()
            ->get();

        return view('livewire.supplier.supplier-admin-order-tracker', [
            'messages' => $discussionTrail
        ]);
    }
}
