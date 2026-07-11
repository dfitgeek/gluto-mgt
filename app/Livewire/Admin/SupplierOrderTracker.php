<?php

namespace App\Livewire\Admin;

use App\Models\AdminOrder;
use App\Models\AdminOrderTracker;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class SupplierOrderTracker extends Component
{
    #[Layout('layouts.admin')]

    // Route identifier handshakes
    public int $orderId;
    public AdminOrder $order;

    // Form Input Binding Properties
    public string $replyMessage = '';
    public string $messageSubject = 'Clarification Request';

    // Admin Auditing Checkbox Compliance Flags Array
    public array $flaggedFields = [];

    /**
     * Fix: Parameter name $orderId here now perfectly mirrors the route parameter {orderId}
     */
    public function mount(int $orderId)
    {
        $this->orderId = $orderId;

        // Eager load parent supplier metadata profile details safely
        $this->order = AdminOrder::with('supplier')->findOrFail($this->orderId);
    }

    /**
     * Store a fresh administrative communication audit response log node.
     */
    public function sendAdminMessage()
    {
        $this->validate([
            'replyMessage' => 'required|string|min:2|max:5000',
            'messageSubject' => 'required|string|max:255',
            'flaggedFields' => 'nullable|array'
        ], [
            'replyMessage.required' => 'The administrative message payload cannot be dispatched blank.',
        ]);

        // Persist response parameters using our clean corrected schema relationships
        AdminOrderTracker::create([
            'admin_order_id' => $this->order->id,
            'user_id' => Auth::id(), // Associated back-office admin session author link
            'supplier_profile_id' => null, // Null indicates an administrative back-office origin author
            'subject' => $this->messageSubject,
            'message_content' => $this->replyMessage,
            'flagged_fields_or_docs' => !empty($this->flaggedFields) ? $this->flaggedFields : null,
            'resolution_status' => 'Pending Response', // Toggle state milestones to alert vendors
            'is_internal_only' => false, // False ensures the vendor profile has visibility access
        ]);

        // Reset the message input and compliance flags array state
        $this->reset(['replyMessage', 'flaggedFields']);

        session()->flash('success', 'Your update response has been successfully appended to this supplier tracking line thread.');
    }

    public function render()
    {
        // Query chronological communication logs while strictly filtering out private records
        $trackerThreads = AdminOrderTracker::where('admin_order_id', $this->order->id)
            ->where('is_internal_only', false)
            ->with(['supplier', 'administrator'])
            ->oldest()
            ->get();

        return view('livewire.admin.supplier-order-tracker', [
            'messages' => $trackerThreads
        ]);
    }
}
