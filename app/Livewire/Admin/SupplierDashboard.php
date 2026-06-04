<?php

namespace App\Livewire\Admin;

use App\Models\SupplierProduct; // Assuming this model maps to your products table
use App\Models\SupplierProfile;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

class SupplierDashboard extends Component
{
    #[Layout('layouts.admin')]
    public function render()
    {
        // 1. Compute dynamic metrics counts straight from database layers
        $unverifiedCount = SupplierProfile::where('status_label', 'Unverified Supplier')->count();
        $verifiedCount = SupplierProfile::where('status_label', 'Verified Supplier')->count();

        // Dynamic product counter (Safely fallbacks to 0 if inventory table isn't populated yet)
        $totalProducts = class_exists(SupplierProduct::class) ? SupplierProduct::count() : 0;

        // 2. Fetch submissions initialized within the last 72 hours that are unverified
        $pendingSuppliers = SupplierProfile::where('status_label', 'Unverified Supplier')
            ->where('created_at', '>=', Carbon::now()->subHours(72))
            ->latest()
            ->take(5) // Limit payload footprint on dashboard view index
            ->get();

        return view('livewire.admin.supplier-dashboard', [
            'unverifiedCount' => $unverifiedCount,
            'verifiedCount' => $verifiedCount,
            'totalProducts' => $totalProducts,
            'pendingSuppliers' => $pendingSuppliers,
        ]);
    }
}
