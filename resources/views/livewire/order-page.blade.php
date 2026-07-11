<div class="flex-1 mx-auto my-2 p-gutter w-full max-w-[1440px]">

    <div class="flex sm:flex-row flex-col justify-between sm:items-center gap-4 mb-6 pb-4 border-b border-outline-variant/30 select-none">
        <div>
            <h2 class="font-headline-lg font-bold text-headline-lg text-primary text-2xl tracking-tight">Generate Bulk Sourcing Quotation</h2>
            <p class="mt-0.5 font-body-sm text-on-surface-variant text-sm">Compile custom item descriptions sheets, specify valuation pricing targets parameters, and submit an RFQ package directly to back-office admins.</p>
        </div>
        <div class="bg-surface-container shadow-inner px-4 py-2 border rounded-xl h-fit font-mono font-bold text-primary text-xs">
            Ticket ID Protocol: {{ $orderRefNumber }}
        </div>
    </div>

    @if(session()->has('success'))
        <div class="flex items-center gap-2 bg-emerald-50 mb-6 p-4 border border-emerald-200 rounded-xl font-semibold text-emerald-800 text-xs animate-fadeIn select-none">
            <span class="text-[18px] material-symbols-outlined">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <form wire:submit.prevent="submitQuotation" class="space-y-6">

        <div class="space-y-6 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40">
            <h3 class="flex items-center gap-2 pb-3 border-background border-b font-headline-md font-bold text-primary text-base select-none">
                <span class="material-symbols-outlined">local_shipping</span> Logistical Destination & Freight Terms Configuration
            </h3>

            <div class="gap-6 grid grid-cols-1 md:grid-cols-3 text-sm">
                <div class="space-y-1.5">
                    <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Target Destination Country *</label>
                    <input type="text" wire:model.defer="destinationCountry" required class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-medium text-xs" placeholder="e.g., Nigeria, United Kingdom">
                    @error('destinationCountry') <span class="block mt-0.5 font-bold text-[10px] text-red-500 animate-fadeIn">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-1.5">
                    <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Origin Loading Port Location</label>
                    <input type="text" wire:model.defer="loadingPort" class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full text-xs" placeholder="e.g., Shanghai Port, Port of Antwerp">
                </div>
                <div class="space-y-1.5">
                    <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Destination Port / Airport Terminal</label>
                    <input type="text" wire:model.defer="destinationPortAirport" class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full text-xs" placeholder="e.g., Apapa Container Terminal">
                </div>

                <div class="space-y-1.5">
                    <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Preferred Shipping Mode *</label>
                    <select wire:model="preferredShippingMethod" class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-semibold text-xs">
                        <option value="Sea Freight">Ocean Sea Freight Shipping</option>
                        <option value="Air Freight">Air Freight Cargo Carrier</option>
                        <option value="Land Transport">Cross-Border Land Transport Hub</option>
                    </select>
                </div>
                <div class="space-y-1.5">
                    <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Preferred Incoterms Framework *</label>
                    <select wire:model="incotermsPreferred" class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-semibold text-xs">
                        <option value="FOB">FOB (Free On Board)</option>
                        <option value="CIF">CIF (Cost, Insurance & Freight)</option>
                        <option value="EXW">EXW (Ex Works Factory Direct)</option>
                        <option value="DDP">DDP (Delivered Duty Paid)</option>
                    </select>
                </div>
                <div class="space-y-1.5">
                    <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Pipeline Expected Lead Time Sizing</label>
                    <input type="text" wire:model.defer="leadTime" class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full text-xs" placeholder="e.g., 30 to 45 Delivery Days">
                </div>

                <div class="space-y-1.5">
                    <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Quotation Currency Metric *</label>
                    <select wire:model="quotationCurrency" class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-semibold text-xs">
                        <option value="USD">USD ($) Standard Valuation</option>
                        <option value="NGN">NGN (₦) Nigerian Naira</option>
                        <option value="EUR">EUR (€) Eurozone Block</option>
                        <option value="GBP">GBP (£) British Pound Sterling</option>
                    </select>
                </div>
                <div class="space-y-1.5 md:col-span-2">
                    <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Estimated Monthly Recurring Sourcing Volume Targets</label>
                    <input type="text" wire:model.defer="estimatedMonthlyVolume" class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full text-xs" placeholder="e.g., 20,000 units rolling monthly pipeline contract">
                </div>

                <div class="space-y-1.5 md:col-span-3">
                    <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Direct Warehouse Delivery Drop Physical Address Address</label>
                    <textarea wire:model.defer="deliveryAddressWarehouse" rows="2" class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-medium text-xs" placeholder="Provide complete delivery warehouse destination address guidelines details..."></textarea>
                </div>
            </div>
        </div>

        <div class="space-y-6 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40">
            <div class="flex justify-between items-center pb-3 border-background border-b select-none">
                <h3 class="flex items-center gap-2 font-headline-md font-bold text-primary text-base">
                    <span class="material-symbols-outlined">dynamic_feed</span> Sourcing Commodity Line-Items Manifest
                </h3>
                <button type="button" wire:click="addBlankRow" class="flex items-center gap-1 bg-primary/10 hover:bg-primary px-4 py-1.5 rounded-xl font-label-md font-bold text-primary hover:text-white text-xs transition-all cursor-pointer">
                    <span class="text-[16px] material-symbols-outlined">add_circle</span> Append Item Row
                </button>
            </div>

            <div class="space-y-4">
                @foreach($quotationItems as $index => $item)
                    <div wire:key="quote-row-{{ $index }}" class="relative space-y-4 bg-surface-container-low/40 p-5 border rounded-2xl border-outline-variant/70 animate-fadeIn">

                        <div class="flex justify-between items-center select-none">
                            <span class="bg-primary/5 shadow-inner px-2.5 py-1 border rounded-lg font-mono font-bold text-[11px] text-primary">Line Parameter Node #{{ $index + 1 }}</span>
                            <button type="button" wire:click="removeRow({{ $index }})" class="flex items-center gap-0.5 text-outline font-bold hover:text-red-600 text-xs transition-colors cursor-pointer">
                                <span class="text-[16px] material-symbols-outlined">delete_forever</span> Drop Line
                            </button>
                        </div>

                        <div class="gap-4 grid grid-cols-1 md:grid-cols-4 font-medium text-xs">
                            <div class="space-y-1 md:col-span-2">
                                <label class="block font-bold text-[11px] text-on-surface-variant">Commodity Product Name *</label>
                                <input type="text" wire:model.live="quotationItems.{{ $index }}.product_name" class="bg-white px-3 py-2 border rounded-xl border-outline-variant outline-none w-full font-bold text-primary" placeholder="e.g., Premium Cassava Flour Mix">
                                @error("quotationItems.{$index}.product_name") <span class="block mt-0.5 font-bold text-[10px] text-red-500 animate-fadeIn">{{ $message }}</span> @enderror
                            </div>
                            <div class="space-y-1">
                                <label class="block font-bold text-[11px] text-on-surface-variant">Country Material Origin</label>
                                <input type="text" wire:model.defer="quotationItems.{{ $index }}.product_origin" class="bg-white px-3 py-2 border rounded-xl border-outline-variant outline-none w-full" placeholder="e.g., Nigeria">
                            </div>
                            <div class="space-y-1">
                                <label class="block font-bold text-[11px] text-on-surface-variant">Target Packaging Manifest</label>
                                <input type="text" wire:model.defer="quotationItems.{{ $index }}.packaging_details" class="bg-white px-3 py-2 border rounded-xl border-outline-variant outline-none w-full" placeholder="e.g., 25kg PP Bulk Sacks Bags">
                            </div>

                            <div class="space-y-1 sm:col-span-2">
                                <label class="block font-bold text-[11px] text-on-surface-variant">Comprehensive Product Specs/Description</label>
                                <input type="text" wire:model.defer="quotationItems.{{ $index }}.product_description" class="bg-white px-3 py-2 border rounded-xl border-outline-variant outline-none w-full" placeholder="Detail color values grade sizing matrix parameters...">
                            </div>
                            <div class="space-y-1 sm:col-span-2">
                                <label class="block font-bold text-[11px] text-on-surface-variant">Preferred Custom Escrow Payment Conditions</label>
                                <input type="text" wire:model.defer="quotationItems.{{ $index }}.payment_term_condition" class="bg-white px-3 py-2 border rounded-xl border-outline-variant outline-none w-full" placeholder="e.g., 50% upfront via bank wire / 50% irrevocable LC at sight">
                            </div>

                            <div class="space-y-1">
                                <label class="block font-bold text-[11px] text-on-surface-variant">Target Order Quantity *</label>
                                <input type="number" step="0.01" min="0.01" wire:model.live="quotationItems.{{ $index }}.order_quantity" class="bg-white px-3 py-2 border rounded-xl border-outline-variant outline-none w-full font-mono font-bold text-primary">
                                @error("quotationItems.{$index}.order_quantity") <span class="block mt-0.5 font-bold text-[10px] text-red-500 animate-fadeIn">{{ $message }}</span> @enderror
                            </div>
                            <div class="space-y-1">
                                <label class="block font-bold text-[11px] text-on-surface-variant">Target Unit Base Price ($) *</label>
                                <input type="number" step="0.0001" min="0" wire:model.live="quotationItems.{{ $index }}.quoted_price_per_unit" class="bg-white px-3 py-2 border rounded-xl border-outline-variant outline-none w-full font-mono font-bold text-primary">
                                @error("quotationItems.{$index}.quoted_price_per_unit") <span class="block mt-0.5 font-bold text-[10px] text-red-500 animate-fadeIn">{{ $message }}</span> @enderror
                            </div>
                            <div class="space-y-1 md:col-span-2 select-none">
                                <label class="block text-outline font-bold text-[11px]">Computed Item Total Line Value</label>
                                <div class="flex items-center bg-surface-container shadow-inner px-4 py-2 border rounded-xl h-[38px] font-mono font-bold text-emerald-800 text-sm">
                                    {{ $quotationCurrency }} {{ number_format((float)($item['total_item_price'] ?? 0.00), 2) }}
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

            <div class="flex justify-between items-center bg-emerald-50/50 p-6 border border-emerald-200 border-dashed rounded-2xl select-none">
                <div class="space-y-0.5 font-semibold text-xs">
                    <span class="block font-bold text-emerald-800 text-sm">Consolidated RFQ Grand Valuation Estimate</span>
                    <p class="font-medium text-on-surface-variant/70">Sum aggregate of all manually specified cargo line items calculation values logs.</p>
                </div>
                <strong class="font-mono text-emerald-800 text-xl md:text-2xl">{{ $quotationCurrency }} {{ number_format($grandTotalPrice, 2) }}</strong>
            </div>
        </div>

        <div class="space-y-4 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40">
            <h3 class="flex items-center gap-2 pb-2.5 border-background border-b font-headline-md font-bold text-primary text-base select-none">
                <span class="material-symbols-outlined">upload_file</span> Supplementary Proof of Sourcing Funds / Credit Letter (Optional)
            </h3>
            <div class="space-y-1.5 font-semibold text-on-surface-variant text-xs">
                <label class="block pl-0.5">Select Validation Verification Asset File Slip Sheet</label>
                <input type="file" wire:model="proof_of_payment" class="block hover:file:bg-primary/20 file:bg-primary/10 file:mr-3 file:px-3 file:py-1.5 file:border-0 file:rounded-xl w-full font-semibold file:text-primary text-xs cursor-pointer">
                <p class="mt-1 pl-0.5 font-medium text-[10px] text-on-surface-variant/60 select-none">Accepts PDF sheets layouts, PNG, or JPG documentation snapshots up to 5MB.</p>
                @error('proof_of_payment') <span class="block mt-0.5 pl-0.5 font-bold text-[10px] text-red-500 animate-fadeIn">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex sm:flex-row flex-col justify-between items-start sm:items-center gap-4 bg-surface-container-low shadow-inner p-5 border rounded-2xl border-outline-variant/40 font-bold text-xs select-none">
            <span class="font-mono text-on-surface-variant/80">Quotation Assembly Timestamp: <strong class="text-primary">{{ $initialContactDate }}</strong></span>
            <div class="flex items-center gap-2.5 w-full sm:w-auto">
                <button type="submit" wire:loading.attr="disabled" class="flex justify-center items-center gap-1.5 bg-primary hover:bg-primary/95 shadow-md px-8 py-3.5 rounded-xl w-full sm:w-auto font-label-md text-white active:scale-95 transition-all cursor-pointer">
                    <span wire:loading.remove class="flex items-center gap-1.5">Dispatch RFQ Package Proposal <span class="text-[16px] material-symbols-outlined">send_and_archive</span></span>
                    <span wire:loading class="flex items-center gap-1 animate-pulse"><span class="inline-block border-2 border-white border-t-transparent rounded-full w-3.5 h-3.5 animate-spin"></span> Packaging quotation json structure...</span>
                </button>
            </div>
        </div>

    </form>
</div>
