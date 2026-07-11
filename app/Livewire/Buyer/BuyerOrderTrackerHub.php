<?php

namespace App\Livewire\Buyer;

use App\Models\BuyerOrder;
use App\Models\BuyerOrderTracker;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class BuyerOrderTrackerHub extends Component
{
    #[Layout('layouts.buyer')]

    // Component parameters
    public int $orderId;
    public BuyerOrder $order;

    // Form Input Binding Properties
    public string $replyMessage = '';
    public string $messageSubject = 'Clarification Request';

    public function mount(int $orderId)
    {
        $this->orderId = $orderId;

        // Security Lock: Ensure the requested order belongs explicitly to the authenticated buyer session
        $this->order = BuyerOrder::where('id', $this->orderId)
            ->where('buyer_profile_id', Auth::guard('buyer')->id())
            ->firstOrFail();
    }

    /**
     * Store a fresh communication tracking thread node into the database.
     */
    public function sendBuyerMessage()
    {
        $this->validate([
            'replyMessage' => 'required|string|min:2|max:5000',
            'messageSubject' => 'required|string|max:255',
        ], [
            'replyMessage.required' => 'You cannot dispatch an empty message packet payload.',
        ]);

        // Persist to buyer_order_trackers using our clean normalized schema properties
        BuyerOrderTracker::create([
            'buyer_order_id' => $this->order->id,
            'buyer_profile_id' => Auth::guard('buyer')->id(),
            'user_id' => null, // Null indicates the buyer authored this record, not an admin
            'subject' => $this->messageSubject,
            'message_content' => $this->replyMessage,
            'flagged_fields_or_docs' => null, // Initial buyer replies do not inject custom validation flags
            'resolution_status' => 'Pending Response', // Auto-toggle tracker status to prompt back-office review
            'is_internal_only' => false, // Always false so both parties share access to the line thread
        ]);

        // Reset the message input box
        $this->reset('replyMessage');

        session()->flash('success', 'Your update response message has been securely appended to this RFQ tracker thread.');
    }

    public function render()
    {
        // Query chronological communication logs while strictly filtering out back-office private scratch notes
        $trackerThreads = BuyerOrderTracker::where('buyer_order_id', $this->order->id)
            ->where('is_internal_only', false)
            ->with(['administrator']) // Eager load user relationship for admin names display formatting
            ->oldest() // Sort top-down to present a standard scrolling message conversation thread view
            ->get();

        return view('livewire.buyer.buyer-order-tracker-hub', [
            'messages' => $trackerThreads
        ]);
    }
}
