<div class="flex-1 mx-auto my-2 p-gutter w-full max-w-[1440px]" x-data="{ receiptOverlayOpen: @entangle('isReceiptModalOpen') }">

    <div class="flex sm:flex-row flex-col justify-between sm:items-center gap-4 mb-6 pb-4 border-b border-outline-variant/30 select-none">
        <div>
            <h2 class="font-headline-lg font-bold text-headline-lg text-primary text-2xl tracking-tight">Replenishment Purchase Orders Ledger</h2>
            <p class="mt-0.5 font-body-sm text-on-surface-variant text-sm">Monitor outward supply procurement pipelines, access vendor invoices, and upload remittance wire receipts.</p>
        </div>
    </div>

    <div class="mb-6 max-w-md select-none">
        <div class="relative w-full">
            <span class="top-1/2 left-4 absolute text-outline text-[20px] -translate-y-1/2 material-symbols-outlined">search</span>
            <input wire:model.live.debounce.250ms="search" type="text"
                class="bg-white shadow-sm py-3 pr-4 pl-11 border rounded-2xl border-outline-variant/60 outline-none focus:ring-1 focus:ring-primary w-full font-medium text-primary text-xs"
                placeholder="Search orders by PO Number or item descriptions name...">
        </div>
    </div>

    @if(session()->has('success'))
        <div class="flex items-center gap-2 bg-emerald-50 mb-6 p-4 border border-emerald-200 rounded-xl font-semibold text-emerald-800 text-xs animate-fadeIn select-none">
            <span class="text-[18px] material-symbols-outlined">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="space-y-6">
        @forelse($orders as $order)
            <div wire:key="admin-order-card-{{ $order->id }}" class="flex flex-col justify-between bg-white shadow-sm hover:shadow-md p-6 border rounded-[2rem] border-outline-variant/50 overflow-hidden transition-shadow animate-fadeIn">

                <div class="flex flex-wrap justify-between items-center gap-3 pb-3 border-background border-b text-xs select-none">
                    <div class="flex items-center gap-3">
                        <span class="bg-primary/5 shadow-inner px-3 py-1 border border-primary/10 rounded-lg font-mono font-bold text-primary text-sm">
                            Voucher Ticket: {{ $order->purchase_order_number }}
                        </span>
                        <span class="flex items-center gap-1 font-sans font-semibold text-[11px] text-on-surface-variant">
                            <span class="text-[15px] material-symbols-outlined">calendar_today</span> Dispatched: {{ $order->created_at->format('M d, Y') }}
                        </span>
                    </div>

                    <div class="flex items-center gap-2 font-mono font-bold text-[10px] uppercase tracking-wide">
                        <span class="px-2.5 py-1 rounded-md border shadow-inner
                            {{ $order->order_status === 'Accepted' ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : 'bg-surface-container text-on-surface-variant' }}">
                            Vendor Pipeline: {{ $order->order_status }}
                        </span>
                        <span class="bg-surface-container shadow-inner px-2.5 py-1 border rounded-md text-on-surface-variant/80">
                            Freight State: {{ $order->shipment_status }}
                        </span>
                    </div>
                </div>

                <div class="gap-6 grid grid-cols-1 lg:grid-cols-3 my-4 font-semibold text-on-surface-variant text-xs">
                    <div class="space-y-2 bg-surface-container-low/40 p-4 border rounded-2xl border-outline-variant/30 select-none">
                        <span class="block text-outline font-bold text-[10px] uppercase tracking-wider">Logistical Drop Destination Warehouse</span>
                        <div class="space-y-1 font-medium text-[11px] text-primary truncate">
                            <div class="truncate" title="{{ $order->destination_warehouse_address }}">Address: <strong>{{ $order->destination_warehouse_address }}</strong></div>
                            <div>Incoterm Rule: <strong class="font-mono text-[10px]">{{ $order->incoterms_rule }}</strong></div>
                            <div>Logistics Vector: <strong>{{ $order->shipping_carrier_method }}</strong></div>
                        </div>
                    </div>

                    <div class="space-y-2 bg-surface-container-low/40 p-4 border rounded-2xl border-outline-variant/30 select-none">
                        <span class="block text-outline font-bold text-[10px] uppercase tracking-wider">Target Vendor Identity Credentials</span>
                        <div class="space-y-1 font-medium text-[11px] text-primary">
                            <div>Supplier Name: <strong class="text-xs">{{ $order->supplier->company_name ?? 'Wholesale Partner Profile' }}</strong></div>
                            <div>Origin Port: <strong>{{ $order->loading_port_origin ?? 'Unlisted Port' }}</strong></div>
                            <div>Est. Arrival Target: <strong>{{ $order->estimated_delivery_date ?? 'Not Specified' }}</strong></div>
                        </div>
                    </div>

                    <div class="flex flex-col justify-center bg-surface-container-low/80 p-4 border border-dashed rounded-2xl border-outline-variant/80 min-h-[90px] text-left select-none">
                        <span class="block text-outline font-bold text-[10px] uppercase tracking-wider">Aggregated PO Contract Cost Summary</span>
                        <div class="flex items-baseline gap-1 mt-0.5 select-all">
                            <h4 class="font-mono font-bold text-primary text-xl">{{ $order->currency }} {{ number_format($order->grand_total_amount, 2) }}</h4>
                        </div>
                        <span class="block mt-1 font-sans text-[10px] text-on-surface-variant/70">Total Selected Products: <strong>{{ count($order->order_items ?? []) }} elements pack</strong></span>
                    </div>
                </div>

                <div class="bg-white my-2 border rounded-2xl overflow-hidden select-none">
                    <div class="flex items-center gap-1 bg-surface-container px-4 py-2 border-b border-outline-variant/30 font-bold text-[11px] text-primary uppercase tracking-wider">
                        <span class="text-[16px] material-symbols-outlined">list_alt</span> Replenishment Sourcing Items Manifest
                    </div>
                    <div class="overflow-x-auto hide-scrollbar">
                        <table class="w-full text-xs text-left border-collapse">
                            <thead>
                                <tr class="bg-surface-container-low border-b border-outline-variant/30 font-bold text-[10px] text-on-surface-variant uppercase tracking-wide">
                                    <th class="p-3">Product Name Descriptions Spec</th>
                                    <th class="p-3">SKU Catalog Token Mapping</th>
                                    <th class="p-3 text-right">Order Quantities Volume</th>
                                    <th class="p-3 text-right">Negotiated Contract Rate</th>
                                    <th class="p-3 text-right">Line Gross Cost</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-background font-medium text-primary">
                                @if(isset($order->order_items) && is_array($order->order_items))
                                    @foreach($order->order_items as $lineItem)
                                        <tr class="hover:bg-background/40 transition-colors">
                                            <td class="p-3 max-w-xs font-bold text-primary">{{ $lineItem['product_name'] }}</td>
                                            <td class="p-3 font-mono text-[11px] text-on-surface-variant">{{ $lineItem['product_ref'] }}</td>
                                            <td class="p-3 font-mono font-bold text-right">{{ number_format($lineItem['order_quantity'], 2) }}</td>
                                            <td class="p-3 font-mono text-right">{{ $order->currency }} {{ number_format($lineItem['negotiated_price_per_unit'], 4) }}</td>
                                            <td class="p-3 font-mono font-bold text-emerald-800 text-right">{{ $order->currency }} {{ number_format($lineItem['total_item_price'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="space-y-3 bg-background my-2 p-4 border rounded-2xl font-medium text-xs">
                    <div class="gap-3 grid grid-cols-1 md:grid-cols-2">

                        <div class="flex justify-between items-center gap-2 bg-white shadow-sm p-3 border rounded-xl">
                            <span class="flex items-center gap-1.5 text-on-surface truncate select-none">
                                <span class="text-[18px] text-primary material-symbols-outlined">account_balance_wallet</span>
                                <span>Supplier Commercial Proforma Invoice</span>
                            </span>
                            @if(isset($order->order_meta['supplier_invoice']))
                                <a href="{{ asset('storage/' . $order->order_meta['supplier_invoice']) }}" target="_blank" class="flex items-center gap-0.5 bg-primary hover:bg-primary/95 shadow-sm px-4 py-1.5 rounded-lg font-bold text-[11px] text-white">
                                    View Invoice <span class="text-[14px] material-symbols-outlined">open_in_new</span>
                                </a>
                            @else
                                <span class="pr-2 text-[10px] text-on-surface-variant/40 italic select-none">Awaiting Vendor Upload</span>
                            @endif
                        </div>

                        <div class="flex justify-between items-center gap-2 bg-white shadow-sm p-3 border rounded-xl">
                            <span class="flex items-center gap-1.5 text-on-surface truncate select-none">
                                <span class="text-[18px] text-emerald-600 material-symbols-outlined">cloud_done</span>
                                <span>Admin Payment Remittance Slip Asset</span>
                            </span>
                            @if(isset($order->order_meta['admin_payment_receipt']))
                                <a href="{{ asset('storage/' . $order->order_meta['admin_payment_receipt']) }}" target="_blank" class="flex items-center gap-0.5 bg-emerald-600 hover:bg-emerald-700 shadow-sm px-4 py-1.5 rounded-lg font-bold text-[11px] text-white">
                                    View Receipt <span class="text-[14px] material-symbols-outlined">download</span>
                                </a>
                            @else
                                <span class="pr-2 font-bold text-[10px] text-red-600 uppercase tracking-wide animate-pulse select-none">Unpaid / Awaiting Receipt</span>
                            @endif
                        </div>

                    </div>
                </div>

                <div class="flex flex-wrap justify-end items-center gap-3 mt-2 pt-4 border-background border-t select-none">
                    <a href="{{ route('admin.suppliers.orders.tracker', ['orderId' => $order->id]) }}" wire:navigate
                        class="flex items-center gap-1.5 bg-primary hover:bg-primary/95 shadow px-5 py-2.5 rounded-xl font-bold text-white text-xs active:scale-95 transition-all">
                        <span class="text-[16px] material-symbols-outlined">forum</span>
                        Open Supplier Tracker Thread                 </a>
                    <button type="button" wire:click="openReceiptModal({{ $order->id }})"
                            class="flex items-center gap-1.5 bg-primary hover:bg-primary/95 shadow-sm px-5 py-2.5 rounded-xl font-label-md font-bold text-white text-xs active:scale-95 transition-transform cursor-pointer">
                        <span class="text-[16px] material-symbols-outlined">upload_file</span>
                        {{ isset($order->order_meta['admin_payment_receipt']) ? 'Replace Payment Slip' : 'Upload Payment Receipt' }}
                    </button>
                </div>

            </div>
        @empty
            <div class="bg-white p-16 border border-dashed rounded-[2.5rem] text-on-surface-variant text-center italic select-none">
                <span class="block mb-2 text-outline text-[56px] material-symbols-outlined">receipt_long</span>
                <p class="font-bold text-primary text-sm not-italic">Procurement Ledger Empty</p>
                <p class="mx-auto mt-0.5 max-w-sm text-xs">There are no rolling replenishment purchase orders logged matching your search lookup criteria parameters pools.</p>
            </div>
        @endforelse
    </div>

    <div x-show="receiptOverlayOpen" x-cloak class="z-[100] fixed inset-0 flex justify-center items-center bg-black/40 backdrop-blur-sm p-4 animate-fadeIn">
        <div @click.outside="receiptOverlayOpen = false; $wire.call('closeReceiptModal')" class="space-y-4 bg-white p-6 rounded-[2.5rem] w-full max-w-md overflow-hidden animate-fadeIn transform">

            <div class="flex justify-between items-center bg-primary -m-6 mb-4 p-5 text-white select-none">
                <div class="flex items-center gap-3">
                    <span class="text-[22px] material-symbols-outlined">receipt_long</span>
                    <h3 class="font-bold text-sm tracking-tight">Upload Outward Bank Payment Slip</h3>
                </div>
                <button type="button" @click="receiptOverlayOpen = false; $wire.call('closeReceiptModal')" class="hover:bg-white/10 p-1 rounded-full text-white cursor-pointer material-symbols-outlined">close</button>
            </div>

            <form wire:submit.prevent="uploadPaymentReceipt" class="space-y-4 font-medium text-on-surface-variant text-xs">
                <p class="leading-relaxed">Select the remitted wire execution settlement slip document (Bank snapshot copy, MT103 advice letter sheet). This appends down natively to the target supplier data interface console mapping track records.</p>

                <div class="space-y-1.5">
                    <label class="block pl-0.5 font-bold">Select Remittance File Sheet *</label>
                    <input type="file" wire:model="receipt_file" required class="block hover:file:bg-primary/20 file:bg-primary/10 file:mr-3 file:px-3 file:py-1.5 file:border-0 file:rounded-xl w-full font-semibold file:text-primary text-xs cursor-pointer">
                    <p class="mt-1 pl-0.5 text-[10px] text-on-surface-variant/60 select-none">Accepts PDF, PNG, or JPG formats up to 10MB sizes limits.</p>
                    @error('receipt_file') <span class="block mt-1 pl-0.5 font-bold text-[10px] text-red-500 animate-fadeIn">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end items-center gap-2 pt-3 border-background border-t font-bold select-none">
                    <button type="button" @click="receiptOverlayOpen = false; $wire.call('closeReceiptModal')" class="bg-surface-container hover:bg-surface-container-high px-4 py-2 rounded-xl text-on-surface-variant cursor-pointer">Dismiss</button>
                    <button type="submit" wire:loading.attr="disabled" class="flex items-center gap-1 bg-primary hover:bg-primary/95 shadow-md px-5 py-2 rounded-xl text-white cursor-pointer">
                        <span wire:loading.remove>Commit Document</span>
                        <span wire:loading class="flex items-center gap-1 animate-pulse"><span class="inline-block border-2 border-white border-t-transparent rounded-full w-3 h-3 animate-spin"></span> Uploading...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
