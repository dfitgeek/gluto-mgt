<?php

namespace App\Livewire;

use App\Models\AdminOrder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class SupplierDashboard extends Component
{
    #[Layout('layouts.supplier')] // Explicit admin system theme layout definition

    /**
     * Compute and bundle transactional fulfillment metrics for the vendor view panel.
     */
    public function render()
    {
        $supplierId = Auth::guard('supplier')->id();

        // 1. Core Lifecycle Pipeline Metrics Aggregations
        $totalOrdersCount = AdminOrder::where('supplier_profile_id', $supplierId)->count();

        $pendingOrdersCount = AdminOrder::where('supplier_profile_id', $supplierId)
            ->whereIn('order_status', ['Pending', 'Invoice'])
            ->count();

        $activeProcessingCount = AdminOrder::where('supplier_profile_id', $supplierId)
            ->whereIn('order_status', ['Confirm Order', 'Processing order', 'Shipped Order'])
            ->count();

        $completedOrdersCount = AdminOrder::where('supplier_profile_id', $supplierId)
            ->where('order_status', 'Completed Order')
            ->count();

        // 2. Financial Valuation Computations (Sum total value across completed contracts)
        $totalRevenueValuation = AdminOrder::where('supplier_profile_id', $supplierId)
            ->where('order_status', 'Completed Order')
            ->sum('grand_total_amount');

        // 3. Extract the 5 most recent inbound purchase orders for dashboard preview lines
        $recentOrders = AdminOrder::where('supplier_profile_id', $supplierId)
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.supplier-dashboard', [
            'metrics' => [
                'total_orders' => $totalOrdersCount,
                'pending_action' => $pendingOrdersCount,
                'active_processing' => $activeProcessingCount,
                'completed_orders' => $completedOrdersCount,
                'total_revenue' => $totalRevenueValuation,
            ],
            'recentOrders' => $recentOrders
        ]);
    }
}
