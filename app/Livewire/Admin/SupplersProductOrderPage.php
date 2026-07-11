<?php

namespace App\Livewire\Admin;

use App\Models\AdminOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

class SupplersProductOrderPage extends Component
{
    #[Layout('layouts.admin')]

    public array $orderItems = [];
    public float $grandTotalAmount = 0.00;

    // Logistical Parameters Form Binds
    public ?string $loadingPortOrigin = null;
    public string $destinationWarehouseAddress = '';
    public ?string $estimatedDeliveryDate = null;
    public string $shippingCarrierMethod = 'Sea Freight';
    public string $incotermsRule = 'FOB';
    public string $currency = 'NGN';

    public function mount()
    {
        $this->orderItems = session()->get('admin_procurement_basket', []);

        if (empty($this->orderItems)) {
            return redirect()->route('admin.suppliers.catalogue');
        }

        $this->recalculateGrandTotal();
    }

    public function updatedOrderItems($value, $key)
    {
        preg_match('/^(\d+)\.(order_quantity|negotiated_price_per_unit)$/', $key, $matches);

        if (!empty($matches)) {
            $productId = (int) $matches[1];
            $qty = (float) ($this->orderItems[$productId]['order_quantity'] ?? 0);
            $rate = (float) ($this->orderItems[$productId]['negotiated_price_per_unit'] ?? 0);

            $this->orderItems[$productId]['total_item_price'] = $qty * $rate;
        }

        $this->recalculateGrandTotal();
        session()->put('admin_procurement_basket', $this->orderItems);
    }

    public function removeLine(int $productId)
    {
        unset($this->orderItems[$productId]);
        session()->put('admin_procurement_basket', $this->orderItems);

        if (empty($this->orderItems)) {
            return redirect()->route('admin.suppliers.catalogue');
        }

        $this->recalculateGrandTotal();
    }

    public function recalculateGrandTotal()
    {
        $sum = 0.00;
        foreach ($this->orderItems as $row) {
            $sum += (float) ($row['total_item_price'] ?? 0.00);
        }
        $this->grandTotalAmount = $sum;
    }

    /**
     * Splits order items by supplier and creates unique PO vouchers dynamically.
     */
    public function submitPurchaseOrder()
    {
        $this->validate([
            'destinationWarehouseAddress' => 'required|string|min:5',
            'loadingPortOrigin' => 'nullable|string|max:255',
            'estimatedDeliveryDate' => 'nullable|date|after_or_equal:today',
            'shippingCarrierMethod' => 'required|string',
            'incotermsRule' => 'required|string',
            'currency' => 'required|string|max:3',

            'orderItems' => 'required|array|min:1',
            'orderItems.*.order_quantity' => 'required|numeric|min:1',
            'orderItems.*.negotiated_price_per_unit' => 'required|numeric|min:0',
        ]);

        // Group items by supplier_profile_id in real-time
        $groupedBySupplier = [];
        foreach ($this->orderItems as $item) {
            $supplierId = $item['supplier_profile_id'];
            $groupedBySupplier[$supplierId][] = [
                'supplier_product_id' => (int) $item['supplier_product_id'],
                'product_ref' => (string) $item['product_ref'],
                'product_name' => (string) $item['product_name'],
                'order_quantity' => (float) $item['order_quantity'],
                'negotiated_price_per_unit' => (float) $item['negotiated_price_per_unit'],
                'total_item_price' => (float) $item['total_item_price'],
            ];
        }

        // Generate separate PO database records per unique supplier profile group
        foreach ($groupedBySupplier as $supplierId => $itemsPayload) {
            $poSubTotal = array_sum(array_column($itemsPayload, 'total_item_price'));

            AdminOrder::create([
                'user_id' => Auth::id(),
                'supplier_profile_id' => $supplierId,
                'order_status' => 'Unprocessed order',
                'shipment_status' => 'Unshipped',
                'purchase_order_number' => 'PO-' . strtoupper(Str::random(4)) . '-' . rand(1000, 9999),
                'order_items' => $itemsPayload,
                'grand_total_amount' => $poSubTotal,
                'currency' => $this->currency,
                'loading_port_origin' => $this->loadingPortOrigin,
                'destination_warehouse_address' => $this->destinationWarehouseAddress,
                'estimated_delivery_date' => $this->estimatedDeliveryDate,
                'shipping_carrier_method' => $this->shippingCarrierMethod,
                'incoterms_rule' => $this->incotermsRule,
                'order_meta' => null
            ]);
        }

        // Flush basket values out of memory cache
        session()->forget('admin_procurement_basket');

        session()->flash('success', 'Procurement split-checkout successful: Generated ' . count($groupedBySupplier) . ' separate supplier purchase orders.');

        return redirect()->route('admin.suppliers.catalogue');
    }

    public function render()
    {
        return view('livewire.admin.supplers-product-order-page');
    }
}
