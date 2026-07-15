<div class="flex-1 mx-auto my-2 p-gutter w-full max-w-[1440px]">

    <div
        class="flex sm:flex-row flex-col justify-between sm:items-center gap-4 mb-6 pb-4 border-b border-outline-variant/30 select-none">
        <div>
            <div class="flex items-center gap-1 mb-1 font-semibold text-on-surface-variant text-xs">
                <span>Vendor Hub Console</span>
                <span class="text-[14px] material-symbols-outlined">chevron_right</span>
                <a href="{{ route('supplier.orders.index') }}" wire:navigate class="hover:underline">Orders Index</a>
                <span class="text-[14px] material-symbols-outlined">chevron_right</span>
                <span class="font-bold text-primary">Dialogue Thread Tracker</span>
            </div>
            <h2 class="font-headline-lg font-bold text-headline-lg text-primary text-2xl tracking-tight">Audit
                Negotiation Hub</h2>
            <p class="mt-0.5 font-body-sm text-on-surface-variant text-sm">Review administration feedback logs, resolve
                flagged compliance issues, and confirm wholesale term updates.</p>
        </div>
        <div
            class="bg-surface-container shadow-inner px-4 py-2 border rounded-xl h-fit font-mono font-bold text-primary text-xs">
            PO Voucher Number: {{ $order->purchase_order_number }}
        </div>
    </div>

    @if(session()->has('success'))
        <div
            class="flex items-center gap-2 bg-emerald-50 mb-6 p-4 border border-emerald-200 rounded-xl font-semibold text-emerald-800 text-xs animate-fadeIn select-none">
            <span class="text-[18px] material-symbols-outlined">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="items-start gap-8 grid grid-cols-1 lg:grid-cols-3">

        <div class="space-y-6 lg:col-span-1 text-xs select-none">
            <div class="space-y-4 bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/50">
                <h3
                    class="flex items-center gap-1 pb-2 border-b font-bold text-[11px] text-primary uppercase tracking-wider">
                    <span class="text-[16px] material-symbols-outlined">assignment</span> Procurement Details Summary
                </h3>
                <div class="space-y-3 font-semibold text-on-surface-variant">
                    <div>
                        <span class="block text-outline font-bold text-[10px] uppercase">Total Contract Valuation</span>
                        <strong class="block mt-0.5 font-mono text-emerald-800 text-base">{{ $order->currency }}
                            {{ number_format($order->grand_total_amount, 2) }}</strong>
                    </div>
                    <div>
                        <span class="block text-outline font-bold text-[10px] uppercase">Target Delivery Drop
                            Endpoint</span>
                        <span
                            class="block mt-1 font-medium text-primary leading-relaxed">{{ $order->destination_warehouse_address }}</span>
                    </div>
                    <div>
                        <span class="block text-outline font-bold text-[10px] uppercase">Logistical Carrier
                            Channel</span>
                        <span class="block mt-0.5 font-sans text-primary">{{ $order->shipping_carrier_method }}
                            ({{ $order->incoterms_rule }})</span>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/50">
                <span class="block mb-3 text-outline font-bold text-[10px] uppercase">Itemized Contract Lines Manifest
                    ({{ count($order->order_items ?? []) }})</span>
                <div class="space-y-2 pr-1 max-h-56 overflow-y-auto hide-scrollbar">
                    @foreach($order->order_items ?? [] as $lineItem)
                        <div
                            class="flex justify-between items-center bg-background p-2.5 border rounded-xl border-outline-variant/30 text-[11px]">
                            <div class="max-w-[150px] truncate">
                                <span class="block font-bold text-primary truncate">{{ $lineItem['product_name'] }}</span>
                                <span class="block mt-0.5 font-mono text-[10px] text-on-surface-variant">Rate:
                                    {{ $order->currency }}{{ number_format($lineItem['negotiated_price_per_unit'], 2) }}</span>
                            </div>
                            <span
                                class="bg-white shadow-sm px-2 py-0.5 border rounded-md font-mono font-bold text-[10px] text-primary">{{ number_format($lineItem['order_quantity']) }}
                                units</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-4 lg:col-span-2">

            <div
                class="flex flex-col space-y-4 bg-dots-pattern bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/40 h-[460px] overflow-y-auto hide-scrollbar">
                @forelse($messages as $msg)
                            @php
                                // Identify message origin: True means authored by supplier, False means back-office administration origin
                                $isMyMsg = !is_null($msg->supplier_profile_id);
                            @endphp

                            <div
                                class="flex flex-col {{ $isMyMsg ? 'items-end' : 'items-start' }} w-full anonymity_wrap animate-fadeIn">

                                <div
                                    class="flex items-center gap-1.5 mb-1 px-2 font-sans font-bold text-[10px] text-on-surface-variant/70 uppercase tracking-wide select-none">
                                    <span>{{ $isMyMsg ? 'Me (Wholesale Team)' : 'Operations Admin Team' }}</span>
                                    <span class="opacity-60 text-outline text-[6px]">•</span>
                                    <span
                                        class="text-outline font-mono font-medium lowercase">{{ $msg->created_at->diffForHumans() }}</span>
                                </div>

                                <div class="max-w-[85%] rounded-[1.5rem] px-5 py-3 text-xs leading-relaxed font-medium shadow-sm border
                                        {{ $isMyMsg
                    ? 'bg-primary text-white rounded-tr-sm border-primary/10'
                    : 'bg-surface-container text-primary rounded-tl-sm border-outline-variant/30' }}">

                                    <div
                                        class="flex items-center gap-1 opacity-80 mb-1.5 pb-0.5 border-b font-mono font-bold text-[9px] uppercase tracking-wider select-none Regal_Tag">
                                        <span class="text-[12px] material-symbols-outlined">label_important</span>
                                        Subject: {{ $msg->subject }}
                                    </div>

                                    <p class="font-sans text-xs whitespace-pre-line">{{ $msg->message_content }}</p>

                                    @if(!empty($msg->flagged_fields_or_docs))
                                        <div
                                            class="mt-3 pt-2 border-t {{ $isMyMsg ? 'border-white/10' : 'border-primary/10' }} select-none">
                                            <span
                                                class="block font-bold text-[9px] uppercase tracking-wider mb-1 flex items-center gap-0.5 {{ $isMyMsg ? 'text-red-100' : 'text-red-600' }}">
                                                <span class="text-[13px] material-symbols-outlined">warning</span> Operational
                                                Corrections Required:
                                            </span>
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($msg->flagged_fields_or_docs as $flagNode)
                                                                    <span class="text-[9px] px-2 py-0.5 rounded font-mono font-bold uppercase tracking-wide border
                                                                                    {{ $isMyMsg
                                                    ? 'bg-red-900/40 text-red-100 border-red-400/20'
                                                    : 'bg-red-50 text-red-700 border-red-200/60' }}">
                                                                        {{ str_replace('_', ' ', $flagNode) }}
                                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>

                            </div>
                @empty
                    <div
                        class="flex flex-col flex-1 justify-center items-center text-on-surface-variant/60 text-center italic select-none">
                        <span class="block opacity-40 mb-1 text-outline text-[48px] material-symbols-outlined">forum</span>
                        <p class="font-bold text-primary text-xs not-italic">Discussion Timeline Clear</p>
                        <p class="mx-auto mt-0.5 max-w-xs text-[11px]">There are no operational entries logged against this
                            message board channel thread layout.</p>
                    </div>
                @endforelse
            </div>



        </div>
    </div>

    <div class="space-y-3 bg-neutral-50 p-4 border border-neutral-200 rounded-2xl">
        <span class="block flex items-center gap-0.5 font-bold text-[10px] text-primary uppercase tracking-wider">
            <span class="text-[14px] material-symbols-outlined">cloud_upload</span> Attach Compliance Vault Asset
        </span>

        <div class="space-y-2">
            <div>
                <label class="block mb-1 font-semibold text-[10px] text-neutral-500">Select Target Type Slot</label>
                <select wire:model="targetFileField" class="bg-white px-2.5 py-1.5 border rounded-lg outline-none w-full font-sans font-bold text-neutral-800 text-xs">
                    <option value="file_commercial_invoice">Commercial Invoice</option>
                    <option value="file_packing_list">Packing List</option>
                    <option value="file_certificate_of_origin">Certificate of Origin</option>
                    <option value="file_bill_of_lading">Bill of Lading</option>
                    <option value="file_product_spec_sheet">Product Spec Sheet</option>
                    <option value="product_manufacturing_certifications">Manufacturing Certifications</option>
                </select>
            </div>

            <div>
                <label class="block mb-1 font-semibold text-[10px] text-neutral-500">Choose Document File File</label>
                <input type="file" wire:model="uploadedFile" class="block file:bg-primary/10 file:mr-2 file:px-3 file:py-1 file:border-0 file:rounded-md w-full font-sans file:font-bold file:text-[10px] file:text-primary text-xs cursor-pointer">
                @error('uploadedFile') <span class="block mt-1 font-bold text-[10px] text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

</div>
