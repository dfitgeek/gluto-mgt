<?php

namespace App\Livewire;

use App\Models\BuyerProfile;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

class ManageBuyers extends Component
{
    #[Layout('layouts.admin')]

    #[Url(history: true)]
    public string $search = '';

    #[Url(history: true)]
    public string $statusFilter = 'All';

    // Hydration targets for the detail modal drawer
    public ?int $selectedBuyerId = null;
    public ?BuyerProfile $selectedBuyer = null;

    /**
     * Locate and hydrate the chosen buyer profile context, then trigger the view layout.
     */
    public function openBuyerModal(int $id)
    {
        $this->selectedBuyerId = $id;
        $this->selectedBuyer = BuyerProfile::findOrFail($id);

        $this->dispatch('open-buyer-preview-modal');
    }

    public function closeBuyerModal()
    {
        $this->reset(['selectedBuyerId', 'selectedBuyer']);
    }

    /**
     * Update a chosen buyer profile's active verification lifecycle status label.
     */
    public function updateStatus(int $id, string $newStatus)
    {
        $buyer = BuyerProfile::findOrFail($id);

        $buyer->update([
            'status_label' => $newStatus
        ]);

        // Re-hydrate the modal data layer state tracking if it's currently open
        if ($this->selectedBuyerId === $id) {
            $this->selectedBuyer = $buyer;
        }

        try {
            // Dispatch the compliance status update alert to the buyer
            \App\Services\NotificationMailService::notifyBuyerOfVerificationStatus($buyer, $newStatus);

            session()->flash('success', "Buyer compliance track '{$buyer->company_name}' updated to '{$newStatus}' successfully.");

        } catch (\Throwable $e) {
            // Log the error silently for backend debugging
            \Illuminate\Support\Facades\Log::error('Buyer verification status notification failed: ' . $e->getMessage());

            // Alert the admin that the database update worked, but the email failed
            session()->flash('warning', "Buyer compliance track '{$buyer->company_name}' updated to '{$newStatus}', but we experienced an issue dispatching the compliance email alert to the buyer.");
        }
    }

    public function render()
    {
        $query = BuyerProfile::query();

        // Process global keyword query strings
        if (filled($this->search)) {
            $query->where(function ($sub) {
                $sub->where('company_name', 'like', '%' . $this->search . '%')
                    ->orWhere('buyer_ref_number', 'like', '%' . $this->search . '%')
                    ->orWhere('rep_full_name', 'like', '%' . $this->search . '%')
                    ->orWhere('rep_email', 'like', '%' . $this->search . '%');
            });
        }

        // Apply status parameter filter caps
        if ($this->statusFilter !== 'All' && empty($this->search)) {
            $query->where('status_label', $this->statusFilter);
        }

        // Compute aggregate baseline statistics pills metrics
        $counts = [
            'All' => BuyerProfile::count(),
            'Unprocessed Buyer' => BuyerProfile::where('status_label', 'Unprocessed Buyer')->count(),
            'Verified Buyer' => BuyerProfile::where('status_label', 'Verified Buyer')->count(),
        ];

        return view('livewire.manage-buyers', [
            'buyers' => $query->latest()->get(),
            'statusCounts' => $counts
        ]);
    }
}
