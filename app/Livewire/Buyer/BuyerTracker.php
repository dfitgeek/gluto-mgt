<?php

namespace App\Livewire\Buyer;

use App\Models\BuyerProfileTracker;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class BuyerTracker extends Component
{
    #[Layout('layouts.buyer')]

    // Buyer reply state variable
    public string $reply_message = '';

    protected array $rules = [
        'reply_message' => 'required|string|min:5',
    ];

    /**
     * Post a response to the admin review thread and transition pending flags.
     */
    public function submitReply()
    {
        $this->validate();

        $buyer = Auth::guard('buyer')->user();

        // 1. Log response tracking entry row
        BuyerProfileTracker::create([
            'buyer_profile_id' => $buyer->id,
            'user_id' => null, // Null signifies a Buyer/Client response context node
            'subject' => 'Buyer Reply',
            'message_content' => $this->reply_message,
            'resolution_status' => 'Info Only',
            'is_internal_only' => false,
            'flagged_fields_or_docs' => null,
        ]);

        // 2. Clear outstanding 'Pending Response' ticks to automatically bump statuses
        BuyerProfileTracker::where('buyer_profile_id', $buyer->id)
            ->where('resolution_status', 'Pending Response')
            ->update(['resolution_status' => 'Info Only']);

        $this->reset('reply_message');

        session()->flash('success', 'Your formal feedback memo has been submitted to the compliance audit desk.');
    }

    public function render()
    {
        $buyer = Auth::guard('buyer')->user();

        // Retrieve chronological ledger entries, strictly guarding internal notes
        $history = BuyerProfileTracker::where('buyer_profile_id', $buyer->id)
            ->where('is_internal_only', false)
            ->latest()
            ->get();

        // Map database json keys to clean frontend labels
        $vaultMap = [
            'file_sales_contract' => 'Sales Sourcing Contract',
            'file_commercial_invoice' => 'Commercial Invoice Scans',
            'file_packing_list' => 'Packing List Manifest',
            'file_certificate_of_origin' => 'Certificate of Origin',
            'file_test_analysis_report' => 'Test Analysis Report',
            'file_bill_of_lading' => 'Bill of Lading Copy',
            'file_insurance_certificate' => 'Insurance Certificate',
            'file_product_spec_sheet' => 'Product Specification Sheet',
            'file_others' => 'Other Supporting Docs',
        ];

        return view('livewire.buyer.buyer-tracker', [
            'trackers' => $history,
            'documentMap' => $vaultMap
        ]);
    }
}
