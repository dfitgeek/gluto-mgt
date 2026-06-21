<?php

namespace App\Livewire\Admin;

use App\Models\BuyerProfile;
use App\Models\BuyerProfileTracker;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class BuyerTracker extends Component
{
    #[Layout('layouts.admin')]

    public int $buyerId;
    public BuyerProfile $buyer;

    // Form inputs state management properties
    public string $subject = 'General Note';
    public string $message_content = '';
    public string $resolution_status = 'Info Only';
    public bool $is_internal_only = false;

    // Checkbox array tracker for flagged items
    public array $flagged_docs = [];

    protected array $rules = [
        'subject' => 'required|string|max:255',
        'message_content' => 'required|string|min:5',
        'resolution_status' => 'required|string|in:Pending Response,Resolved,Info Only',
        'is_internal_only' => 'required|boolean',
        'flagged_docs' => 'nullable|array',
    ];

    public function mount($id)
    {
        $this->buyerId = $id;
        $this->buyer = BuyerProfile::findOrFail($id);
    }

    /**
     * Commit a fresh audit entry/flag log note to the buyer tracker database ledger.
     */
    public function logTrackerNote()
    {
        $this->validate();

        BuyerProfileTracker::create([
            'buyer_profile_id' => $this->buyerId,
            'user_id' => Auth::id(), // Current Administrator Auth ID
            'subject' => $this->subject,
            'message_content' => $this->message_content,
            'resolution_status' => $this->resolution_status,
            'is_internal_only' => $this->is_internal_only,
            'flagged_fields_or_docs' => !empty($this->flagged_docs) ? array_values(array_filter($this->flagged_docs)) : null,
        ]);

        // Clean up the input state fields
        $this->reset(['message_content', 'flagged_docs']);
        $this->subject = 'General Note';
        $this->resolution_status = 'Info Only';
        $this->is_internal_only = false;

        session()->flash('success', 'Timeline action note appended to this buyer tracking portfolio.');
    }

    public function render()
    {
        // Fetch full timeline tracking history logs for this buyer
        $historyLogs = BuyerProfileTracker::with('user')
            ->where('buyer_profile_id', $this->buyerId)
            ->latest()
            ->get();

        // Specific data map matching your buyer documentation requirements
        $onboardingVaultMap = [
            'file_sales_contract' => 'Sales Contract',
            'file_commercial_invoice' => 'Commercial Invoice',
            'file_packing_list' => 'Packing List Manifest',
            'file_certificate_of_origin' => 'Certificate of Origin',
            'file_test_analysis_report' => 'Test Analysis Report',
            'file_bill_of_lading' => 'Bill of Lading Copy',
            'file_insurance_certificate' => 'Insurance Certificate',
            'file_product_spec_sheet' => 'Product Spec Sheet',
            'file_others' => 'Other Supporting Docs',
        ];

        return view('livewire.admin.buyer-tracker', [
            'trackers' => $historyLogs,
            'documentMap' => $onboardingVaultMap
        ]);
    }
}
