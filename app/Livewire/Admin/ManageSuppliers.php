<?php

namespace App\Livewire\Admin;

use App\Models\SupplierProfile;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

class ManageSuppliers extends Component
{
    #[Url(history: true)]
    public string $search = '';

    #[Url(history: true)]
    public string $statusFilter = 'Verified Supplier';

    public ?SupplierProfile $selectedSupplier = null;

    public function setStatusFilter(string $status)
    {
        $this->statusFilter = $status;
        $this->closeModal();
    }

    public function loadSupplierDetails(int $id)
    {
        $this->selectedSupplier = SupplierProfile::find($id);

        if ($this->selectedSupplier) {
            $this->dispatch('open-supplier-modal');
        }
    }

    public function toggleVerification(int $id)
    {
        $supplier = SupplierProfile::find($id);

        if ($supplier) {
            if ($supplier->status_label === 'Verified Supplier') {
                $supplier->update(['status_label' => 'Unverified Supplier']);
                session()->flash('success', "{$supplier->company_name} is now unverified.");
            } else {
                $supplier->update(['status_label' => 'Verified Supplier']);
                session()->flash('success', "{$supplier->company_name} has been verified successfully!");
            }

            if ($this->selectedSupplier && $this->selectedSupplier->id === $id) {
                $this->selectedSupplier = $supplier;
            }
        }
    }

    public function closeModal()
    {
        $this->selectedSupplier = null;
    }

    public function performSearch()
    {
        // Triggers rendering re-evaluation
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $query = SupplierProfile::query();

        if (filled($this->search)) {
            $query->where(function ($subQuery) {
                $subQuery->where('company_name', 'like', '%' . $this->search . '%')
                    ->orWhere('reg_number', 'like', '%' . $this->search . '%')
                    ->orWhere('supplier_ref_number', 'like', '%' . $this->search . '%')
                    ->orWhere('email_address', 'like', '%' . $this->search . '%');
            });
        } else {
            $query->where('status_label', $this->statusFilter);
        }

        return view('livewire.admin.manage-suppliers', [
            'suppliers' => $query->latest()->get()
        ]);
    }
}
