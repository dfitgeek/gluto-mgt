<?php

namespace App\Livewire\Buyer;

use App\Models\BuyerOrder;
use App\Models\SupplierProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class BuyerOrderData extends Component
{
    use WithFileUploads;

    #[Layout('layouts.buyer')]

    // Structural Immutable Context Handshakes
    public int $productId;
    public SupplierProduct $product;
    public string $orderRefNumber;
    public string $initialContactDate;

    // Operational Order Information Input States (Explicitly defined camelCase)
    public $orderQuantity = 1; // Handled dynamically as loose numeric element
    public float $quotedPricePerUnit = 0.0000;
    public float $totalOrderPrice = 0.00;
    public string $preferredPaymentMethod = 'Bank Transfer';
    public ?string $estimatedMonthlyVolume = null;

    // Shipping & Destination Details Input States
    public ?string $loadingPort = null;
    public string $destinationCountry = '';
    public ?string $destinationPortAirport = null;
    public ?string $deliveryAddressWarehouse = null;
    public ?string $leadTime = null;
    public string $preferredShippingMethod = 'Sea Freight';
    public string $incotermsPreferred = 'FOB';

    // File Asset Stream Storage
    public $proof_of_payment;

    public function mount()
    {
        $this->productId = request()->query('product_id', 0);
        $this->product = SupplierProduct::with('supplier')->findOrFail($this->productId);

        // Map inherited baseline pricing parameters
        $this->quotedPricePerUnit = (float) $this->product->price_pieces;
        $this->initialContactDate = now()->toDateString();
        $this->orderRefNumber = 'ORD-' . strtoupper(Str::random(4)) . '-' . rand(1000, 9999);

        $this->calculateTotal();
    }

    /**
     * Real-time lifecycle hook capturing parameter alterations.
     */
    public function updatedOrderQuantity()
    {
        $this->calculateTotal();
    }

    /**
     * Calculate gross price with safe empty-value fallback handling.
     */
    public function calculateTotal()
    {
        // Safe protection check if a buyer completely clears out the input box field
        $qty = is_numeric($this->orderQuantity) ? (float) $this->orderQuantity : 0.00;

        if ($qty < 0) {
            $qty = 0.00;
        }

        $this->totalOrderPrice = $qty * $this->quotedPricePerUnit;
    }

    /**
     * Validate parameter inputs and save to database.
     */
    public function commitOrderManifest()
    {
        $buyer = Auth::guard('buyer')->user();

        // Run validation using strict camelCase targeting matching our public attributes
        $this->validate([
            'orderQuantity' => 'required|numeric|min:0.01',
            'preferredPaymentMethod' => 'required|string|in:MT103 TT,Crypto,Bank Transfer',
            'estimatedMonthlyVolume' => 'nullable|string|max:255',
            'loadingPort' => 'nullable|string|max:255',
            'destinationCountry' => 'required|string|max:255',
            'destinationPortAirport' => 'nullable|string|max:255',
            'deliveryAddressWarehouse' => 'nullable|string',
            'leadTime' => 'nullable|string|max:255',
            'preferredShippingMethod' => 'required|string|in:Sea Freight,Air Freight,Land Transport',
            'incotermsPreferred' => 'required|string|in:FOB,CIF,EXW,DDP',
            'proof_of_payment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $paymentMetaStructure = ['receipts' => []];
        if ($this->proof_of_payment) {
            $savedPath = $this->proof_of_payment->store('buyer_receipts', 'public');
            $paymentMetaStructure['receipts'][] = [
                'file_path' => $savedPath,
                'uploaded_at' => now()->toDateTimeString(),
                'file_name' => $this->proof_of_payment->getClientOriginalName()
            ];
        }

        BuyerOrder::create([
            'buyer_profile_id' => $buyer->id,
            'order_progress' => 'Unprocessed order',
            'order_ref_number' => $this->orderRefNumber,
            'prod_ref' => $this->product->product_ref,
            'product_names' => $this->product->product_name,
            'product_descriptions' => $this->product->product_description,
            'product_origin' => $this->product->supplier->country_of_registration ?? 'Global Pool',
            'payment_term_condition' => $this->product->payment_terms,
            'quoted_price_per_unit' => $this->quotedPricePerUnit,
            'quotation_currency' => 'NGN',
            'order_quantity' => (float) $this->orderQuantity,
            'total_order_price' => $this->totalOrderPrice,
            'preferred_payment_method' => $this->preferredPaymentMethod,
            'estimated_monthly_volume' => $this->estimatedMonthlyVolume,
            'shipment_status' => 'unshipped',
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

        return redirect()->route('buyer.order')
            ->with('success', "Procurement pipeline request '{$this->orderRefNumber}' has been initialized cleanly.");
    }

    public function render()
    {
        return view('livewire.buyer.buyer-order-data');
    }
}
