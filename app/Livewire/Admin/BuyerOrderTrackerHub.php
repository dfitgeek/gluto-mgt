<?php

namespace App\Livewire\Admin;

use App\Models\BuyerOrder;
use App\Models\BuyerOrderTracker;
use App\Services\NotificationMailService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class BuyerOrderTrackerHub extends Component
{
    #[Layout('layouts.admin')]

    // Component parameters
    public int $orderId;
    public BuyerOrder $order;

    // Form Input Binding Properties
    public string $replyMessage = '';
    public string $messageSubject = 'Information Request';

    // Admin Auditing Checkbox Flags Array
    public array $flaggedFields = [];

    /**
     * Hydrate component parameters using the URL model token.
     */
    public function mount(int $orderId)
    {
        $this->orderId = $orderId;

        // Eager load parent buyer profile configurations safely
        $this->order = BuyerOrder::with('buyer')->findOrFail($this->orderId);
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
            'replyMessage.required' => 'The message body payload cannot be dispatched blank.',
        ]);

        $buyer = $this->order->buyer;

        // Persist response parameters into buyer_order_trackers registry schema
        BuyerOrderTracker::create([
            'buyer_order_id' => $this->order->id,
            'buyer_profile_id' => null, // Null indicates an administrative system author
            'user_id' => Auth::id(), // Associated back-office user session author link
            'subject' => $this->messageSubject,
            'message_content' => $this->replyMessage,
            'flagged_fields_or_docs' => !empty($this->flaggedFields) ? $this->flaggedFields : null,
            'resolution_status' => 'Pending Response',
            'is_internal_only' => false, // Set to false to share visibility with the buyer's console
        ]);

        try {
            NotificationMailService::notifyBuyerOfQuoteTrackerUpdate($buyer->rep_email, $this->order, $this->messageSubject, $this->replyMessage);

            // Success flash if both database save and email succeed
            session()->flash('success', 'Your administrative update message has been securely committed to the conversation thread.');

        } catch (\Throwable $e) {
            // Log the failure behind the scenes
            \Illuminate\Support\Facades\Log::error('Buyer notification email failed: ' . $e->getMessage());

            // Throw a warning/error session message to the UI
            session()->flash('warning', 'Your message was securely committed, but we experienced an issue sending the email notification to the buyer.');
        }

        // Reset the message input and compliance flags array state
        $this->reset(['replyMessage', 'flaggedFields']);
    }

    public function render()
    {
        // Fetch all shared conversation rows chronologically
        $trackerThreads = BuyerOrderTracker::where('buyer_order_id', $this->order->id)
            ->where('is_internal_only', false)
            ->with(['buyer']) // Eager load relationships for clean data presentation
            ->oldest()
            ->get();

        return view('livewire.admin.buyer-order-tracker-hub', [
            'messages' => $trackerThreads
        ]);
    }
}
