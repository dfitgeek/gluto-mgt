<?php

namespace App\Livewire\Admin;

use App\Models\SupplierProfile;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

class ManageSuppliers extends Component
{
    // Keeps track of search queries and maps them seamlessly to the browser URL string
    #[Url(history: true)]
    public string $search = '';



    // Dictates the active collection filter state bucket ('Verified Supplier' or 'Unverified Supplier')
    #[Url(history: true)]
    public string $statusFilter = 'Verified Supplier';

    // Holds the active supplier profile selected for the details modal layout panel
    public ?SupplierProfile $selectedSupplier = null;

    /**
     * Set the running active filter state criteria.
     */
    public function setStatusFilter(string $status)
    {
        $this->statusFilter = $status;
        $this->closeModal(); // Cleanly resets modal focus upon changing tab orientation tracking
    }



    /**
     * Fetch a targeted record file and hydrate the running detail modal panel.
     */
    public function loadSupplierDetails(int $id)
    {
        $this->selectedSupplier = SupplierProfile::find($id);

        if ($this->selectedSupplier) {
            // Emits an event down to your view frame script listener to activate the vanilla visual transitions
            $this->dispatch('open-supplier-modal');
        }
    }

    /**
     * Formless single-action method to instantly switch a supplier verification level.
     */
    public function toggleVerification(int $id)
    {
        $supplier = SupplierProfile::find($id);

        if ($supplier) {
            // Evaluates matching string tokens to process modifications cleanly
            if ($supplier->status_label === 'Verified Supplier') {
                $supplier->update(['status_label' => 'Unverified Supplier']);
                session()->flash('success', "{$supplier->company_name} is now unverified.");
            } else {
                $supplier->update(['status_label' => 'Verified Supplier']);
                session()->flash('success', "{$supplier->company_name} has been verified successfully!");
            }

            // Sync the model modifications straight into the opened modal viewport if active
            if ($this->selectedSupplier && $this->selectedSupplier->id === $id) {
                $this->selectedSupplier = $supplier;
            }
        }
    }

    public function closeModal()
    {
        $this->selectedSupplier = null;
    }

    /**
     * Triggered explicitly when the form is submitted or the search button is clicked.
     */
    public function performSearch()
    {
        // This method can remain empty!
        // Simply submitting the form or firing this method forces Livewire
        // to sync the input text state and re-run the render() pipeline automatically.
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $query = SupplierProfile::query();

        // ARCHITECTURAL OVERRIDE CORE LOGIC:
        // If an explicit search term is submitted, ignore the status tab filter constraints
        // and scan the entire database so related profiles appear regardless of status.
        if (filled($this->search)) {
            $query->where(function ($subQuery) {
                $subQuery->where('company_name', 'like', '%' . $this->search . '%')
                    ->orWhere('reg_number', 'like', '%' . $this->search . '%')
                    ->orWhere('supplier_ref_number', 'like', '%' . $this->search . '%')
                    ->orWhere('email_address', 'like', '%' . $this->search . '%');
            });
        } else {
            // Default pristine layout state behavior: scope strictly to the active tab selection
            $query->where('status_label', $this->statusFilter);
        }

        return view('livewire.admin.manage-suppliers', [
            'suppliers' => $query->latest()->get()
        ]);
    }
}
