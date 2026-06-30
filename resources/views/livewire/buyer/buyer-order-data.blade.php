<div class="flex-1 mx-auto my-2 p-gutter w-full max-w-[1440px]">

    <div class="flex sm:flex-row flex-col justify-between sm:items-center gap-4 mb-8 pb-4 border-b border-outline-variant/30 select-none">
        <div>
            <div class="flex items-center gap-1 mb-1 font-semibold text-on-surface-variant text-xs">
                <a href="{{ route('buyer.product') }}" class="hover:text-primary hover:underline">Sourcing Catalog</a>
                <span class="text-[14px] material-symbols-outlined">chevron_right</span>
                <span class="font-bold text-primary">Configure Procurement Quote</span>
            </div>
            <h2 class="font-headline-lg font-bold text-headline-lg text-primary text-2xl tracking-tight">Configure Logistical Order Parameters</h2>
            <p class="mt-0.5 font-body-sm text-on-surface-variant text-sm">Review locked catalog attributes, declare custom target volumes data, and provide freight drop coordinates.</p>
        </div>
        <div class="bg-surface-container shadow-inner px-4 py-2 border rounded-xl h-fit font-mono font-bold text-primary text-xs">
            System Reference Protocol: {{ $orderRefNumber }}
        </div>
    </div>

    <form wire:submit.prevent="commitOrderManifest" class="items-start gap-8 grid grid-cols-1 lg:grid-cols-3">

        <div class="space-y-6 lg:col-span-1 bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/40 select-none">
            <h3 class="flex items-center gap-1.5 pb-2 border-b font-bold text-primary text-sm uppercase tracking-wide">
                <span class="text-[20px] material-symbols-outlined">info</span> Locked Commodity Specifications
            </h3>

            <div class="space-y-4 font-semibold text-on-surface-variant text-xs">
                <div>
                    <span class="block text-outline font-bold text-[10px] uppercase">Product Item Target Mapping</span>
                    <h4 class="mt-0.5 font-bold text-primary text-base leading-snug">{{ $product->product_name }}</h4>
                </div>
                <div>
                    <span class="block text-outline font-bold text-[10px] uppercase">SKU Trace Parameter Code</span>
                    <span class="block mt-0.5 font-mono text-primary select-all">{{ $product->product_ref }}</span>
                </div>
                <div>
                    <span class="block text-outline font-bold text-[10px] uppercase">Country Origin Matrix</span>
                    <span class="block mt-0.5 text-primary">{{ $product->supplierProfile->country_of_registration ?? 'Global Wholesaler' }}</span>
                </div>
                <div>
                    <span class="block text-outline font-bold text-[10px] uppercase">Supplier Baseline Payment Terms</span>
                    <p class="bg-background mt-1 p-2.5 border border-dashed rounded-xl font-medium text-primary whitespace-pre-line">{{ $product->payment_terms ?? 'Standard security framework requirements active.' }}</p>
                </div>
                <div class="flex justify-between items-baseline pt-4 border-background border-t">
                    <span class="font-bold text-primary text-xs">Unit Rate Price:</span>
                    <div>
                        <strong class="font-mono text-emerald-700 text-lg">₦{{ number_format($product->price_pieces, 2) }}</strong>
                        <span class="text-outline text-[10px]">/ piece</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6 lg:col-span-2">

            <div class="space-y-6 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40">
                <h3 class="flex items-center gap-2 pb-2.5 border-background border-b font-headline-md font-bold text-primary text-base select-none">
                    <span class="material-symbols-outlined">analytics</span> 1. Order Quantity Valuation & Settlement Channels
                </h3>

                <div class="gap-6 grid grid-cols-1 sm:grid-cols-2 text-sm">
                    <div class="space-y-1.5">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Desired Purchase Quantity (Pieces) *</label>
                        <input type="number" step="1" min="1" wire:model.live="orderQuantity" required
                            class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl outline-none focus:ring-1 focus:ring-primary w-full font-mono font-bold text-primary">              </div>
                    <div class="space-y-1.5">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Preferred Settlement Clearing Channel *</label>
                        <select wire:model="preferredPaymentMethod" class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl outline-none focus:ring-1 focus:ring-primary w-full font-medium text-xs">
                            <option value="Bank Transfer">Bank Wire Transfer Execution</option>
                            <option value="MT103 TT">Telegraphic Transfer (MT103 TT)</option>
                            <option value="Crypto">Digital Escrow Asset (Crypto Gateway)</option>
                        </select>
                    </div>
                    <div class="space-y-1.5 sm:col-span-2">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Estimated Monthly Sourcing Volume Metrics (Optional)</label>
                        <input type="text" wire:model.defer="estimatedMonthlyVolume" class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl outline-none focus:ring-1 focus:ring-primary w-full text-xs" placeholder="e.g., 50,000 units recurring pipeline expansion">
                    </div>
                </div>

                <div class="flex justify-between items-center bg-emerald-50/50 p-5 border border-emerald-200 border-dashed rounded-2xl animate-fadeIn select-none">
                    <div class="space-y-0.5 font-medium text-xs">
                        <span class="block font-bold text-emerald-800">Consolidated Gross Valuation Contract Quote</span>
                        <p class="text-[11px] text-on-surface-variant/80">Automatic multiplication computed under local ₦ (NGN) local baseline metrics.</p>
                    </div>
                    <strong class="font-mono text-emerald-800 text-xl md:text-2xl select-all">₦{{ number_format($totalOrderPrice, 2) }}</strong>
                </div>
            </div>

            <div class="space-y-6 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40">
                <h3 class="flex items-center gap-2 pb-2.5 border-background border-b font-headline-md font-bold text-primary text-base select-none">
                    <span class="material-symbols-outlined">local_shipping</span> 2. Maritime Shipping & Drop-off Destination Channels
                </h3>

                <div class="gap-6 grid grid-cols-1 sm:grid-cols-2 text-sm">
                    <div class="space-y-1.5">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Origin Loading Port (FOB Dispatch Location)</label>
                        <input type="text" wire:model.defer="loadingPort" class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl outline-none w-full text-xs" placeholder="e.g., Port of Shanghai, Apapa Port Complex">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Target Destination Country *</label>
                        <input type="text" wire:model.defer="destinationCountry" required class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl outline-none w-full text-xs" placeholder="e.g., Nigeria, United States">
                        @error('destinationCountry') <span class="block font-bold text-[10px] text-red-500 animate-fadeIn">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1.5">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Destination Arrival Port / Airport Terminal</label>
                        <input type="text" wire:model.defer="destinationPortAirport" class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl outline-none w-full text-xs" placeholder="e.g., Onne Port, JFK Cargo Terminal">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Target Sourcing Lead Time Window</label>
                        <input type="text" wire:model.defer="leadTime" class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl outline-none w-full text-xs" placeholder="e.g., 21 to 30 Delivery Working Days">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Preferred Maritime Freight Method *</label>
                        <select wire:model="preferredShippingMethod" class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl outline-none w-full font-medium text-xs">
                            <option value="Sea Freight">Ocean Sea Freight Container Logistics</option>
                            <option value="Air Freight">Air Freight Express Logistics Carrier</option>
                            <option value="Land Transport">Cross-Border Land Transport Hub</option>
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Incoterms Preferred Rules Matrix *</label>
                        <select wire:model="incotermsPreferred" class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl outline-none w-full font-medium text-xs">
                            <option value="FOB">FOB (Free On Board Freight Rules)</option>
                            <option value="CIF">CIF (Cost, Insurance & Freight Setup)</option>
                            <option value="EXW">EXW (Ex Works Factory Direct Extraction)</option>
                            <option value="DDP">DDP (Delivered Duty Paid Depot Hub)</option>
                        </select>
                    </div>
                    <div class="space-y-1.5 sm:col-span-2">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Direct Warehouse Delivery Drop Physical Address</label>
                        <textarea wire:model.defer="deliveryAddressWarehouse" rows="2" class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl outline-none w-full text-xs leading-relaxed" placeholder="Provide complete delivery drop coordinates logs specs details..."></textarea>
                    </div>
                </div>
            </div>

            <div class="space-y-4 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40">
                <h3 class="flex items-center gap-2 pb-2.5 border-background border-b font-headline-md font-bold text-primary text-base select-none">
                    <span class="material-symbols-outlined">upload_file</span> 3. Initial Proof of Funds Document Verification (Optional)
                </h3>
                <div class="space-y-1.5 text-xs">
                    <label class="block pl-0.5 font-bold text-on-surface-variant">Select Validation Asset File Slip Sheet</label>
                    <input type="file" wire:model="proof_of_payment" class="block hover:file:bg-primary/20 file:bg-primary/10 file:mr-3 file:px-3 file:py-1.5 file:border-0 file:rounded-xl w-full font-medium file:font-semibold text-on-surface-variant file:text-primary file:text-xs">
                    <p class="mt-1 pl-0.5 text-[10px] text-on-surface-variant/70 select-none">Accepts PDF snapshots or structural image confirmation slips up to 5MB capacity sizes limits.</p>
                    @error('proof_of_payment') <span class="block font-bold text-[10px] text-red-500 animate-fadeIn">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-between items-center bg-surface-container-low shadow-inner p-5 border rounded-2xl border-outline-variant/40 font-bold text-xs select-none">
                <span class="font-mono text-on-surface-variant/80">Order Initiation Date Stamp: <strong class="text-primary">{{ $initialContactDate }}</strong></span>
                <div class="flex items-center gap-2.5 w-full sm:w-auto">
                    <a href="{{ route('buyer.product') }}" class="bg-white hover:bg-background px-5 py-3 border rounded-xl text-on-surface-variant text-center transition-colors">Abort Order</a>
                    <button type="submit" wire:loading.attr="disabled" class="flex justify-center items-center gap-1.5 bg-primary hover:bg-primary/95 shadow-md px-8 py-3.5 rounded-xl font-label-md text-white active:scale-95 transition-transform cursor-pointer">
                        <span wire:loading.remove class="flex items-center gap-1.5">Initialize Contract Procurement <span class="text-[16px] material-symbols-outlined">done_all</span></span>
                        <span wire:loading class="flex items-center gap-1 animate-pulse"><span class="inline-block border-2 border-white border-t-transparent rounded-full w-3.5 h-3.5 animate-spin"></span> Compiling order matrix data...</span>
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>
