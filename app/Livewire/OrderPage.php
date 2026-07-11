<?php

namespace App\Livewire;

use App\Models\BuyerOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class OrderPage extends Component
{
    use WithFileUploads;

    #[Layout('layouts.buyer')]

    // Global Overarching Quote Settings
    public string $orderRefNumber;
    public string $initialContactDate;
    public string $quotationCurrency = 'USD';
    public ?string $estimatedMonthlyVolume = null;

    // Logistical Destination Array Parameters
    public ?string $loadingPort = null;
    public string $destinationCountry = '';
    public ?string $destinationPortAirport = null;
    public ?string $deliveryAddressWarehouse = null;
    public ?string $leadTime = null;
    public string $preferredShippingMethod = 'Sea Freight';
    public string $incotermsPreferred = 'FOB';

    // File Upload Handlers
    public $proof_of_payment;

    // Multi-Item Quotation State Array Deck
    public array $quotationItems = [];
    public float $grandTotalPrice = 0.00;

    // Single Row Item Input Form Model Binds
    public string $newItemName = '';
    public ?string $newItemDescription = null;
    public ?string $newItemOrigin = null;
    public ?string $newItemPackaging = null;
    public $newItemQuantity = 1;
    public $newItemPricePerUnit = 0.00;

    public function mount()
    {
        $this->initialContactDate = now()->toDateString();
        $this->orderRefNumber = 'RFQ-' . strtoupper(Str::random(4)) . '-' . rand(1000, 9999);

        // Seed form with an initial blank entry row for clean presentation layout
        $this->addBlankRow();
    }

    /**
     * Appends an unpopulated line item row context dictionary to the active memory array deck.
     */
    public function addBlankRow()
    {
        $this->quotationItems[] = [
            'product_name' => '',
            'product_description' => '',
            'product_origin' => '',
            'packaging_details' => '',
            'order_quantity' => 1,
            'quoted_price_per_unit' => 0.0000,
            'total_item_price' => 0.00
        ];

        $this->recalculateGrandTotal();
    }

    /**
     * Remove a targeted line item index row from the matrix cache.
     */
    public function removeRow(int $index)
    {
        unset($this->quotationItems[$index]);
        $this->quotationItems = array_values($this->quotationItems);

        if (empty($this->quotationItems)) {
            $this->addBlankRow();
        } else {
            $this->recalculateGrandTotal();
        }
    }

    /**
     * Lifecycle listener tracking item updates to keep calculations in sync.
     */
    public function updatedQuotationItems($value, $key)
    {
        // Capture subkey patterns like: quotationItems.0.order_quantity
        preg_match('/^(\d+)\.(order_quantity|quoted_price_per_unit)$/', $key, $matches);

        if (!empty($matches)) {
            $index = (int) $matches[1];
            $qty = (float) ($this->quotationItems[$index]['order_quantity'] ?? 0);
            $unitPrice = (float) ($this->quotationItems[$index]['quoted_price_per_unit'] ?? 0);

            $this->quotationItems[$index]['total_item_price'] = $qty * $unitPrice;
        }

        $this->recalculateGrandTotal();
    }

    /**
     * Compute financial summary sums across all present item matrix nodes.
     */
    public function recalculateGrandTotal()
    {
        $total = 0.00;
        foreach ($this->quotationItems as $item) {
            $total += (float) ($item['total_item_price'] ?? 0.00);
        }
        $this->grandTotalPrice = $total;
    }

    /**
     * Validate the entire payload configuration and create the quotation.
     */
    public function submitQuotation()
    {
        $buyer = Auth::guard('buyer')->user();

        // Enforce validations rules against root fields and nested arrays elements
        $this->validate([
            'destinationCountry' => 'required|string|max:255',
            'quotationCurrency' => 'required|string|max:3',
            'preferredShippingMethod' => 'required|string',
            'incotermsPreferred' => 'required|string',
            'estimatedMonthlyVolume' => 'nullable|string|max:255',
            'loadingPort' => 'nullable|string|max:255',
            'destinationPortAirport' => 'nullable|string|max:255',
            'deliveryAddressWarehouse' => 'nullable|string',
            'leadTime' => 'nullable|string|max:255',
            'proof_of_payment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',

            'quotationItems' => 'required|array|min:1',
            'quotationItems.*.product_name' => 'required|string|max:255',
            'quotationItems.*.order_quantity' => 'required|numeric|min:0.01',
            'quotationItems.*.quoted_price_per_unit' => 'required|numeric|min:0',
        ], [
            'quotationItems.*.product_name.required' => 'The product description name is mandatory for all item rows.',
        ]);

        // Process proof vault file metadata properties
        $paymentMetaStructure = ['receipts' => []];
        if ($this->proof_of_payment) {
            $savedPath = $this->proof_of_payment->store('buyer_receipts', 'public');
            $paymentMetaStructure['receipts'][] = [
                'file_path' => $savedPath,
                'uploaded_at' => now()->toDateTimeString(),
                'file_name' => $this->proof_of_payment->getClientOriginalName()
            ];
        }

        // Clean arrays nodes casting formatting values explicitly before DB insertion
        $finalItems = array_map(function ($item) {
            return [
                'product_name' => (string) $item['product_name'],
                'product_description' => (string) ($item['product_description'] ?? ''),
                'product_origin' => (string) ($item['product_origin'] ?? ''),
                'packaging_details' => (string) ($item['packaging_details'] ?? ''),
                'order_quantity' => (float) $item['order_quantity'],
                'quoted_price_per_unit' => (float) $item['quoted_price_per_unit'],
                'total_item_price' => (float) $item['total_item_price'],
                'payment_term_condition' => (string) ($item['payment_term_condition'] ?? '')
            ];
        }, $this->quotationItems);

        BuyerOrder::create([
            'buyer_profile_id' => $buyer->id,
            'order_progress' => 'Unprocessed order',
            'shipment_status' => 'unshipped',
            'order_ref_number' => $this->orderRefNumber,

            // Core JSON payload assignment
            'quotation_items' => $finalItems,

            'grand_total_price' => $this->grandTotalPrice,
            'quotation_currency' => $this->quotationCurrency,
            'estimated_monthly_volume' => $this->estimatedMonthlyVolume,
            'loading_port' => $this->loadingPort,
            'destination_country' => $this->destinationCountry,
            'destination_port_airport' => $this->destinationPortAirport,
            'delivery_address_warehouse' => $this->deliveryAddressWarehouse,
            'lead_time' => $this->leadTime,
            'preferred_shipping_method' => $this->preferredShippingMethod,
            'incoterms_preferred' => $this->incotermsPreferred,
            'payment_meta' => $paymentMetaStructure,
            'date_of_initial_contact' => $this->initialContactDate,
        ]);

        session()->flash('success', "Quotation proposal package '{$this->orderRefNumber}' successfully submitted to administrative operations.");
        return redirect()->route('buyer.order');
    }

    public function render()
    {
        return view('livewire.order-page');
    }
}
