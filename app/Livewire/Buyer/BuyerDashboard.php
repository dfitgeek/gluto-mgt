<?php

namespace App\Livewire\Buyer;

use App\Models\BuyerOrder;
use App\Models\SupplierProfileTracker; // The shared CRM tracking model layout layer
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class BuyerDashboard extends Component
{
    #[Layout('layouts.buyer')]

    public function render()
    {
        $buyer = Auth::guard('buyer')->user();

        // 1. Calculate Aggregate Financial Procurement Volumes
       /*  $totalPurchases = BuyerOrder::where('buyer_profile_id', $buyer->id)
            ->whereIn('status_label', ['Completed', 'Delivered', 'Dispatched'])
            ->sum('total_valuation_price'); */
        $totalPurchases = 0;

        // 2. Fetch the Single Latest Order Profile Entry Card
        $latestOrder = BuyerOrder::where('buyer_profile_id', $buyer->id)
            ->latest()
            ->first();

        // 3. Extract the Single Latest Direct Buyer-Admin CRM Track Highlight
        // Scoped to filter notes exchanged directly between this Buyer profile and the internal Admin panel
        $latestTracking = SupplierProfileTracker::where('supplier_profile_id', $buyer->id)
            ->where('is_internal_only', false)
            ->where(function ($query) {
                // Captures both administrative instructions and buyer's response memos
                $query->where('subject', '!=', 'Supplier Reply')
                    ->orWhereNull('user_id');
            })
            ->latest()
            ->first();

        return view('livewire.buyer.buyer-dashboard', [
            'totalPurchases' => $totalPurchases,
            'latestOrder' => $latestOrder,
            'latestTracking' => $latestTracking,
            'buyer' => $buyer,
        ]);
    }
}
