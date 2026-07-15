<div class="flex-1 mx-auto my-2 p-gutter w-full max-w-[1440px]" x-data="{ invoiceOverlayOpen: @entangle('isInvoiceModalOpen') }">

    <div class="flex sm:flex-row flex-col justify-between sm:items-center gap-4 mb-8 pb-4 border-b border-outline-variant/30 select-none">
        <div>
            <h2 class="font-headline-lg font-bold text-headline-lg text-primary text-2xl tracking-tight">Master Incoming Procurement Orders</h2>
            <p class="mt-0.5 font-body-sm text-on-surface-variant text-sm">Reviewing all incoming B2B purchase orders assigned to your company. Update progression milestones, track administrative payment wire receipts, and manage shipping stages.</p>
        </div>
        <div class="bg-surface-container shadow-inner px-4 py-2 border rounded-xl h-fit font-mono font-bold text-primary text-xs select-none">
            Vendor Code Reference: {{ auth('supplier')->user()->supplier_ref_number }}
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
            <div wire:key="vendor-order-card-{{ $order->id }}" class="flex flex-col justify-between bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/50 overflow-hidden animate-fadeIn">

                <div class="flex flex-wrap justify-between items-center gap-4 pb-3 border-neutral-200 border-b text-xs select-none">
                    <div class="flex items-center gap-3">
                        <span
                            class="bg-primary/5 shadow-inner px-3 py-1 border border-primary/10 rounded-lg font-mono font-bold text-primary text-sm">
                            PO Reference: {{ $order->purchase_order_number }}
                        </span>
                        <span class="flex items-center gap-1 font-sans font-semibold text-[11px] text-neutral-500">
                            <span class="text-[15px] material-symbols-outlined">calendar_today</span> Received:
                            {{ $order->created_at->format('M d, Y') }}
                        </span>
                    </div>

                    <div class="flex flex-wrap items-center gap-4">

                        <div class="flex items-center gap-1.5 font-bold text-[11px] text-neutral-700">
                            <span>Order Status:</span>
                            <div class="relative">
                                <select wire:change="updateOrderStatus({{ $order->id }}, $event.target.value)"
                                    class="bg-white shadow-sm px-3 py-1.5 border border-neutral-300 focus:border-primary rounded-xl outline-none focus:ring-1 focus:ring-primary min-w-[140px] font-mono font-bold text-neutral-900 text-xs tracking-tight appearance-none cursor-pointer">
                                    @foreach(['Pending', 'Invoice', 'Confirm Order', 'Processing order', 'Shipped Order', 'Completed Order'] as $statusNode)
                                        <option value="{{ $statusNode }}" {{ $order->order_status === $statusNode ? 'selected' : '' }}
                                            class="bg-white font-sans font-medium text-neutral-900">
                                            {{ $statusNode }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center gap-1.5 font-bold text-[11px] text-on-surface-variant">
                            <span>Freight/Shipment:</span>
                            <select wire:change="updateShipmentStatus({{ $order->id }}, $event.target.value)"
                                class="bg-surface-container-low focus:bg-white shadow-sm px-3 py-1.5 border rounded-xl border-outline-variant/60 outline-none focus:ring-1 focus:ring-primary font-mono font-bold text-primary text-xs tracking-tight cursor-pointer">
                                @foreach(['Unshipped', 'Shipped', 'Delivered', 'Cancelled'] as $shipStatus)
                                    <option value="{{ $shipStatus }}" {{ $order->shipment_status === $shipStatus ? 'selected' : '' }}>
                                        {{ $shipStatus }}
                                    </option>
                                @endforeach
                            </select>                  </div>

                    </div>          </div>

                <div class="gap-6 grid grid-cols-1 lg:grid-cols-3 my-4 font-semibold text-on-surface-variant text-xs">
                    <div class="space-y-2 bg-surface-container-low/40 p-4 border rounded-2xl border-outline-variant/30 select-none">
                        <span class="block text-outline font-bold text-[10px] uppercase tracking-wider">Logistical Delivery Drop Endpoints</span>
                        <div class="space-y-1 font-medium text-[11px] text-primary truncate">
                            <div class="truncate" title="{{ $order->destination_warehouse_address }}">Warehouse: <strong>{{ $order->destination_warehouse_address }}</strong></div>
                            <div>Loading Port Origin: <strong>{{ $order->loading_port_origin ?? 'Not Specified Port' }}</strong></div>
                            <div>Freight Vector Method: <strong>{{ $order->shipping_carrier_method }}</strong></div>
                        </div>
                    </div>

                    <div class="space-y-2 bg-surface-container-low/40 p-4 border rounded-2xl border-outline-variant/30 select-none">
                        <span class="block text-outline font-bold text-[10px] uppercase tracking-wider">Contractual Commercial Rules</span>
                        <div class="space-y-1 font-medium text-[11px] text-primary">
                            <div>Incoterms Clause: <strong class="font-mono text-[10px]">{{ $order->incoterms_rule }}</strong></div>
                            <div>Target Arrival Timeline: <strong>{{ $order->estimated_delivery_date ?? 'Unspecified Frame' }}</strong></div>
                            <div>Back-Office Buyer Code: <strong class="font-mono text-[10px]">#{{ $order->user_id }}</strong></div>
                        </div>
                    </div>

                    <div class="flex flex-col justify-center bg-surface-container-low/80 p-4 border border-dashed rounded-2xl border-outline-variant/80 text-left select-none">
                        <span class="block text-outline font-bold text-[10px] uppercase tracking-wider">Total Contract Procurement Price Valuation</span>
                        <div class="flex items-baseline gap-0.5 mt-1">
                            <strong class="font-mono text-emerald-800 text-xl">{{ $order->currency }} {{ number_format($order->grand_total_amount, 2) }}</strong>
                        </div>
                        <span class="block mt-1 font-sans text-[10px] text-on-surface-variant/70">Total Lines Pack: <strong>{{ count($order->order_items ?? []) }} selected items</strong></span>
                    </div>
                </div>

                <div class="bg-white my-2 border rounded-2xl overflow-hidden select-none">
                    <div class="flex items-center gap-1 bg-surface-container px-4 py-2 border-b border-outline-variant/30 font-bold text-[11px] text-primary uppercase tracking-wider">
                        <span class="text-[16px] material-symbols-outlined">list_alt</span> Itemized Sourcing Lines Fulfillment Manifest
                    </div>
                    <div class="overflow-x-auto hide-scrollbar">
                        <table class="w-full text-xs text-left border-collapse">
                            <thead>
                                <tr class="bg-surface-container-low border-b border-outline-variant/30 font-bold text-[10px] text-on-surface-variant uppercase tracking-wide">
                                    <th class="p-3">Product Catalog Specifications Title</th>
                                    <th class="p-3">SKU Code</th>
                                    <th class="p-3 text-right">Requested Quantity</th>
                                    <th class="p-3 text-right">Negotiated Rate Unit</th>
                                    <th class="p-3 text-right">Line Sub Gross Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-background font-medium text-primary">
                                @if(isset($order->order_items) && is_array($order->order_items))
                                    @foreach($order->order_items as $subItemNode)
                                        <tr class="hover:bg-background/40 transition-colors">
                                            <td class="p-3 font-bold text-primary">{{ $subItemNode['product_name'] }}</td>
                                            <td class="p-3 font-mono text-[11px] text-on-surface-variant">{{ $subItemNode['product_ref'] }}</td>
                                            <td class="p-3 font-mono font-bold text-right">{{ number_format($subItemNode['order_quantity'], 2) }}</td>
                                            <td class="p-3 font-mono text-right">{{ $order->currency }} {{ number_format($subItemNode['negotiated_price_per_unit'], 4) }}</td>
                                            <td class="p-3 font-mono font-bold text-emerald-800 text-right">{{ $order->currency }} {{ number_format($subItemNode['total_item_price'], 2) }}</td>
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
                                <span>My Dispatched Commercial Proforma Invoice</span>
                            </span>
                            @if(isset($order->order_meta['supplier_invoice']) && filled($order->order_meta['supplier_invoice']))
                                <a href="{{ asset('storage/' . $order->order_meta['supplier_invoice']) }}" target="_blank" class="flex items-center gap-0.5 bg-primary hover:bg-primary/95 shadow-sm px-4 py-1.5 rounded-lg font-bold text-[11px] text-white">
                                    View Invoice <span class="text-[14px] material-symbols-outlined">open_in_new</span>
                                </a>
                            @else
                                <span class="pr-2 font-bold text-[10px] text-red-600 uppercase tracking-wide animate-pulse select-none">Invoice Action Required</span>
                            @endif
                        </div>

                        <div class="flex justify-between items-center gap-2 bg-white shadow-sm p-3 border rounded-xl">
                            <span class="flex items-center gap-1.5 text-on-surface truncate select-none">
                                <span class="text-[18px] text-emerald-600 material-symbols-outlined">cloud_done</span>
                                <span>Admin Wire Remittance Settlement Slips</span>
                            </span>
                            @if(isset($order->order_meta['admin_payment_receipt']) && filled($order->order_meta['admin_payment_receipt']))
                                <a href="{{ asset('storage/' . $order->order_meta['admin_payment_receipt']) }}" target="_blank" class="flex items-center gap-0.5 bg-emerald-50 hover:bg-emerald-100 px-4 py-1.5 border border-emerald-200 rounded-xl font-bold text-emerald-800">
                                    View Receipt Slip <span class="text-[14px] material-symbols-outlined">download</span>
                                </a>
                            @else
                                <span class="pr-2 text-[10px] text-on-surface-variant/40 italic select-none">Awaiting Admin Remittance</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap justify-end items-center gap-2.5 mt-4 pt-4 border-background border-t select-none">
                    <a href="{{ route('supplier.orders.tracker', ['orderId' => $order->id]) }}" wire:navigate class="flex items-center gap-1.5 bg-surface-container hover:bg-surface-container-high px-5 py-2.5 border rounded-xl border-outline-variant/50 font-label-md font-bold text-primary text-xs transition-colors">
                        <span class="text-[16px] material-symbols-outlined">forum</span>
                        Open Audit Tracker Thread
                    </a>

                    <button type="button" wire:click="openInvoiceModal({{ $order->id }})" class="flex items-center gap-1.5 bg-primary hover:bg-primary/95 shadow-sm px-5 py-2.5 rounded-xl font-label-md font-bold text-white text-xs cursor-pointer">
                        <span class="text-[16px] material-symbols-outlined">upload_file</span>
                        {{ isset($order->order_meta['supplier_invoice']) ? 'Replace Attached Invoice File' : 'Attach Commercial Invoice File' }}
                    </button>
                </div>

            </div>
        @empty
            <div class="bg-white p-16 border border-dashed rounded-[2.5rem] text-on-surface-variant text-center italic select-none">
                <span class="block mb-2 text-outline text-[56px] material-symbols-outlined">assignment_late</span>
                <p class="font-bold text-primary text-sm not-italic">No Sourcing Contract Requests Registered</p>
                <p class="mx-auto mt-0.5 max-w-sm text-xs">There are no compiled historical contract purchase orders assigned to your supplier enterprise profile.</p>
            </div>
        @endforelse
    </div>

    <div x-show="invoiceOverlayOpen" x-cloak class="z-[100] fixed inset-0 flex justify-center items-center bg-black/40 shadow-2xl backdrop-blur-sm p-4 animate-fadeIn">
        <div @click.outside="invoiceOverlayOpen = false; $wire.call('closeInvoiceModal')" class="space-y-4 bg-white p-6 rounded-[2.5rem] w-full max-w-md overflow-hidden animate-fadeIn transform">

            <div class="flex justify-between items-center bg-primary -m-6 mb-4 p-5 text-white select-none">
                <div class="flex items-center gap-3">
                    <span class="text-[22px] material-symbols-outlined">request_quote</span>
                    <h3 class="font-bold text-sm tracking-tight">Attach Wholesales Proforma Invoice</h3>
                </div>
                <button type="button" @click="invoiceOverlayOpen = false; $wire.call('closeInvoiceModal')" class="flex justify-center items-center hover:bg-white/10 p-1 rounded-full text-white cursor-pointer material-symbols-outlined">close</button>
            </div>

            <form wire:submit.prevent="uploadInvoice" class="space-y-4 font-medium text-on-surface-variant text-xs">
                <p class="leading-relaxed">Select the itemized wholesales commercial invoice document copy sheet (PDF scan or image snapshot). This file will sync directly to the back-office operations audit dashboard logs tracking panel parameters stream layout.</p>

                <div class="space-y-1.5">
                    <label class="block pl-0.5 font-bold">Select Billing Document File Asset *</label>
                    <input type="file" wire:model="invoice_file" required class="block hover:file:bg-primary/20 file:bg-primary/10 file:mr-3 file:px-3 file:py-1.5 file:border-0 file:rounded-xl w-full font-semibold file:text-primary text-xs cursor-pointer">
                    <p class="mt-1 pl-0.5 text-[10px] text-on-surface-variant/60 select-none">Accepts PDF, PNG, or JPG formats up to 10MB capacities size limits.</p>
                    @error('invoice_file') <span class="block mt-1 pl-0.5 font-bold text-[10px] text-red-500 animate-fadeIn">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end items-center gap-2 pt-3 border-background border-t font-bold select-none">
                    <button type="button" @click="invoiceOverlayOpen = false; $wire.call('closeInvoiceModal')" class="bg-surface-container hover:bg-surface-container-high px-4 py-2 rounded-xl text-on-surface-variant cursor-pointer">Dismiss</button>
                    <button type="submit" wire:loading.attr="disabled" class="flex items-center gap-1 bg-primary hover:bg-primary/95 shadow-md px-5 py-2 rounded-xl text-white cursor-pointer">
                        <span wire:loading.remove>Upload Document</span>
                        <span wire:loading class="flex items-center gap-1 animate-pulse"><span class="inline-block border-2 border-white border-t-transparent rounded-full w-3 h-3 animate-spin"></span> Syncing server disk...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
