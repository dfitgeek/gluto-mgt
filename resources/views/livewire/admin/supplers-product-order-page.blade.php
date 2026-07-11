<div class="flex-1 mx-auto my-2 p-gutter w-full max-w-[1440px]">

    <div
        class="flex sm:flex-row flex-col justify-between sm:items-center gap-4 mb-6 pb-4 border-b border-outline-variant/30 select-none">
        <div>
            <h2 class="font-headline-lg font-bold text-headline-lg text-primary text-2xl tracking-tight">Purchase Order
                Staging Summary Gate</h2>
            <p class="mt-0.5 font-body-sm text-on-surface-variant text-sm">Fine-tune dynamic negotiated values
                adjustments, define final warehouse cargo endpoints, and issue a signed PO voucher.</p>
        </div>
    </div>

    <form wire:submit.prevent="submitPurchaseOrder" class="items-start gap-8 grid grid-cols-1 lg:grid-cols-3">

        <div class="space-y-4 lg:col-span-2">
            <div class="space-y-4 bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/40">
                <h3
                    class="flex items-center gap-1 pb-2 border-b font-bold text-[11px] text-primary uppercase tracking-wider select-none">
                    <span class="text-[16px] material-symbols-outlined">list_alt</span> Itemized Sourcing Lines Override
                    Ledgers
                </h3>

                <div class="space-y-4">
                    @foreach($orderItems as $prodId => $basketRow)
                        <div wire:key="checkout-row-{{ $prodId }}"
                            class="relative space-y-4 bg-surface-container-low/40 p-4 border rounded-2xl border-outline-variant/70 animate-fadeIn">

                            <div class="flex justify-between items-center select-none">
                                <span
                                    class="bg-primary/5 shadow-inner px-2.5 py-0.5 border rounded-md font-mono font-bold text-[10px] text-primary">SKU:
                                    {{ $basketRow['product_ref'] }}</span>
                                <button type="button" wire:click="removeLine({{ $prodId }})"
                                    class="flex items-center gap-0.5 text-outline font-bold text-[11px] hover:text-red-600 transition-colors cursor-pointer">
                                    <span class="text-[15px] material-symbols-outlined">delete_forever</span> Drop Line
                                </button>
                            </div>

                            <div class="gap-4 grid grid-cols-1 md:grid-cols-4 font-medium text-on-surface-variant text-xs">
                                <div class="space-y-1 md:col-span-2">
                                    <label class="block font-bold text-[11px]">Commodity Name</label>
                                    <div class="pt-1 font-bold text-primary text-sm">{{ $basketRow['product_name'] }}</div>
                                </div>

                                <div class="space-y-1">
                                    <label class="block font-bold text-[11px]">Quantity Override *</label>
                                    <input type="number" min="1" wire:model.live="orderItems.{{ $prodId }}.order_quantity"
                                        class="bg-white px-3 py-2 border rounded-xl border-outline-variant outline-none w-full font-mono font-bold text-primary text-xs">
                                </div>

                                <div class="space-y-1">
                                    <label class="block font-bold text-[11px]">Negotiated Unit Pricing Target *</label>
                                    <input type="number" step="0.0001" min="0"
                                        wire:model.live="orderItems.{{ $prodId }}.negotiated_price_per_unit"
                                        class="bg-white px-3 py-2 border rounded-xl border-outline-variant outline-none w-full font-mono font-bold text-primary text-xs">
                                </div>

                                <div class="flex justify-end md:col-span-4 select-none">
                                    <div class="text-right">
                                        <span class="block text-outline font-bold text-[10px] uppercase">Line Summary
                                            Price</span>
                                        <strong class="block mt-0.5 font-mono text-emerald-800 text-sm">{{ $currency }}
                                            {{ number_format($basketRow['total_item_price'], 2) }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div
                    class="flex justify-between items-center bg-emerald-50/50 p-6 border border-emerald-200 border-dashed rounded-2xl select-none">
                    <div class="font-semibold text-emerald-800 text-xs">
                        <span class="block font-bold text-sm">Aggregated Purchase Order Financial Value</span>
                        <p class="font-medium text-on-surface-variant/70">Accumulated sums metrics total values rows
                            configuration logs.</p>
                    </div>
                    <strong class="font-mono text-emerald-800 text-xl md:text-2xl">{{ $currency }}
                        {{ number_format($grandTotalAmount, 2) }}</strong>
                </div>
            </div>
        </div>

        <div class="space-y-4 lg:col-span-1">
            <div
                class="space-y-4 bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/50 font-medium text-on-surface-variant text-xs">
                <h3
                    class="flex items-center gap-1 pb-2 border-b font-bold text-[11px] text-primary uppercase tracking-wider select-none">
                    <span class="text-[16px] material-symbols-outlined">local_shipping</span> Logistical Freight
                    Envelope Details
                </h3>

                <div class="space-y-4">
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold">Destination Warehouse Address *</label>
                        <textarea wire:model.defer="destinationWarehouseAddress" required rows="3"
                            class="bg-surface-container-low focus:bg-white px-3 py-2 border rounded-xl outline-none focus:ring-1 focus:ring-primary w-full"
                            placeholder="Specify complete physical delivery drop warehouse address details..."></textarea>
                        @error('destinationWarehouseAddress') <span
                        class="block mt-0.5 font-bold text-[10px] text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold">Origin Loading Port Location</label>
                        <input type="text" wire:model.defer="loadingPortOrigin"
                            class="bg-surface-container-low focus:bg-white px-3 py-2 border rounded-xl outline-none w-full"
                            placeholder="e.g., Port of Qingdao, Port of Houston">
                    </div>

                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold">Estimated Delivery Expected Date</label>
                        <input type="date" wire:model.defer="estimatedDeliveryDate"
                            class="bg-surface-container-low focus:bg-white px-3 py-2 border rounded-xl outline-none w-full font-mono">
                        @error('estimatedDeliveryDate') <span
                        class="block mt-0.5 font-bold text-[10px] text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold">Shipping Carrier Method *</label>
                        <select wire:model="shippingCarrierMethod"
                            class="bg-surface-container-low focus:bg-white px-3 py-2 border rounded-xl outline-none w-full font-bold text-primary">
                            <option value="Sea Freight">Ocean Deep Sea Freight Shipping</option>
                            <option value="Land Transport">Cross-Border Land Trucking Fleet</option>
                            <option value="Air Freight">Express Air Freight Cargo Carrier</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold">Incoterms Framework Rules *</label>
                        <select wire:model="incotermsRule"
                            class="bg-surface-container-low focus:bg-white px-3 py-2 border rounded-xl outline-none w-full font-bold text-primary">
                            <option value="FOB">FOB (Free On Board)</option>
                            <option value="EXW">EXW (Ex Works Factory Direct)</option>
                            <option value="CIF">CIF (Cost, Insurance & Freight)</option>
                            <option value="DDP">DDP (Delivered Duty Paid)</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold">Settlement Currency Valuation *</label>
                        <select wire:model="currency"
                            class="bg-surface-container-low focus:bg-white px-3 py-2 border rounded-xl outline-none w-full font-mono font-bold text-primary">
                            <option value="NGN">NGN (₦) Base Currency</option>
                            <option value="USD">USD ($) Standard Valuation</option>
                            <option value="EUR">EUR (€) Eurozone Registry</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4 border-background border-t select-none">
                    <button type="submit" wire:loading.attr="disabled"
                        class="flex justify-center items-center gap-1.5 bg-primary hover:bg-primary/95 shadow-md px-6 py-3.5 rounded-xl w-full font-bold text-white text-center tracking-wide active:scale-95 transition-all cursor-pointer">
                        <span wire:loading.remove class="flex items-center gap-1">Submit Purchase Order <span
                                class="text-[16px] material-symbols-outlined">send</span></span>
                        <span wire:loading class="animate-pulse"><span
                                class="inline-block mr-1 border-2 border-white border-t-transparent rounded-full w-3 h-3 animate-spin"></span>
                            Processing array logs...</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
