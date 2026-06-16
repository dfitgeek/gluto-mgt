<?php

namespace App\Livewire\Supplier;

use App\Models\SupplierProfileTracker;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class SupplierTracker extends Component
{
    #[Layout('layouts.supplier')]

    // Supplier response text state property
    public string $reply_message = '';

    protected array $rules = [
        'reply_message' => 'required|string|min:5',
    ];

    /**
     * Submit the vendor's response and automatically update tracking flags.
     */
    public function submitReply()
    {
        $this->validate();

        $supplier = Auth::guard('supplier')->user();

        // 1. Persist the reply note into the tracker ledger table
        SupplierProfileTracker::create([
            'supplier_profile_id' => $supplier->id,
            'user_id' => null, // Kept null or link to user_id if needed; signifies a Supplier Response entry
            'subject' => 'Supplier Reply',
            'message_content' => $this->reply_message,
            'resolution_status' => 'Info Only', // Bounces status out of 'Pending Response'
            'is_internal_only' => false, // Must be false so admins can read it
            'flagged_fields_or_docs' => null, // Clear active flags on this reply note node
        ]);

        // 2. Loop through older pending tickets for this supplier and update their resolution states
        SupplierProfileTracker::where('supplier_profile_id', $supplier->id)
            ->where('resolution_status', 'Pending Response')
            ->update(['resolution_status' => 'Info Only']);

        $this->reset('reply_message');

        session()->flash('success', 'Your compliance feedback message has been dispatched to the review panel.');
    }

    public function render()
    {
        $supplier = Auth::guard('supplier')->user();

        // Fetch chronological stack, strictly hiding administrative internal audit logs
        $logs = SupplierProfileTracker::where('supplier_profile_id', $supplier->id)
            ->where('is_internal_only', false)
            ->latest()
            ->get();

        // Map database strings to user-friendly titles
        $documentMap = [
            'file_sales_contract' => 'Sales Contract',
            'file_commercial_invoice' => 'Commercial Invoice',
            'file_packing_list' => 'Packing List',
            'file_certificate_of_origin' => 'Certificate of Origin',
            'file_test_analysis_report' => 'Test Analysis Report',
            'product_manufacturing_certifications' => 'Manufacturing Certifications',
            'returns_warranty_policy' => 'Warranty Document',
        ];

        return view('livewire.supplier.supplier-tracker', [
            'trackers' => $logs,
            'documentMap' => $documentMap
        ]);
    }
}
