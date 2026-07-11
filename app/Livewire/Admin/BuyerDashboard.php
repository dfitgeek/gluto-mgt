<?php

namespace App\Livewire\Admin;

use App\Models\BuyerOrder;
use App\Models\BuyerProfile;
use Livewire\Attributes\Layout;
use Livewire\Component;

class BuyerDashboard extends Component
{
    #[Layout('layouts.admin')]

    public int $totalBuyersCount = 0;
    public int $verifiedBuyersCount = 0;
    public int $unverifiedBuyersCount = 0;
    public float $totalQuotesValue = 0.00;

    /**
     * Run lifecycle initialization to compute metrics parameters.
     */
    public function mount()
    {
        // 1. Gather total buyer profile data allocations
        $this->totalBuyersCount = BuyerProfile::count();

        // 2. Count verified vs unverified buyers based on profile statuses/verification flags
        // Adjust column name (e.g., 'status_label', 'is_verified', or 'email_verified_at') to match your schema
        $this->verifiedBuyersCount = BuyerProfile::where('status_label', 'Verified Buyer')->count();
        $this->unverifiedBuyersCount = BuyerProfile::where('status_label', '!=', 'Verified Buyer')->count();

        // 3. Compute absolute mathematical sum total of all quotes placed platform-wide
        $this->totalQuotesValue = (float) BuyerOrder::sum('grand_total_price');
    }

    public function render()
    {
        // Fetch the 5 most recent sourcing quotations, eager loading their company profiles
        $recentOrders = BuyerOrder::with('buyer')
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.admin.buyer-dashboard', [
            'recentOrders' => $recentOrders
        ]);
    }
}
