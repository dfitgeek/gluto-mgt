<?php

namespace App\Livewire\Admin;

use App\Models\SupplierProfile;
use App\Models\SupplierProfileTracker;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class SupplierTracker extends Component
{
    #[Layout('layouts.admin')]

    public int $supplierId;
    public SupplierProfile $supplier;

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
        $this->supplierId = $id;
        $this->supplier = SupplierProfile::findOrFail($id);
    }

    /**
     * Commit a fresh audit entry/flag log note to the supplier tracker database ledger.
     */
    public function logTrackerNote()
    {
        $this->validate();

        // Save entry row directly through relationship layers
        SupplierProfileTracker::create([
            'supplier_profile_id' => $this->supplierId,
            'user_id' => Auth::id(), // Maps current administrator auth ID
            'subject' => $this->subject,
            'message_content' => $this->message_content,
            'resolution_status' => $this->resolution_status,
            'is_internal_only' => $this->is_internal_only,
            // Filter array variables to strip unchecked boxes
            'flagged_fields_or_docs' => !empty($this->flagged_docs) ? array_values(array_filter($this->flagged_docs)) : null,
        ]);

        // Clean form properties out of components state memory
        $this->reset(['message_content', 'flagged_docs']);
        $this->subject = 'General Note';
        $this->resolution_status = 'Info Only';
        $this->is_internal_only = false;

        session()->flash('success', 'Timeline action note appended to this supplier tracking portfolio.');
    }

    public function render()
    {
        // Fetch full timeline historical ledger tracks
        $historyLogs = SupplierProfileTracker::with('user')
            ->where('supplier_profile_id', $this->supplierId)
            ->latest()
            ->get();

        // Dictate dictionary of audit-flagged elements targets
        $onboardingVaultMap = [
            'file_sales_contract' => 'Sales Contract',
            'file_commercial_invoice' => 'Commercial Invoice',
            'file_packing_list' => 'Packing List',
            'file_certificate_of_origin' => 'Certificate of Origin',
            'file_test_analysis_report' => 'Test Analysis Report',
            'product_manufacturing_certifications' => 'Manufacturing Certs',
            'returns_warranty_policy' => 'Warranty Document',
        ];

        return view('livewire.admin.supplier-tracker', [
            'trackers' => $historyLogs,
            'documentMap' => $onboardingVaultMap
        ]);
    }
}
