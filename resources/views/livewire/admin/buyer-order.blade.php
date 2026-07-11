<div class="flex-1 mx-auto my-2 p-gutter w-full max-w-[1440px]" x-data="{ invoiceOverlayOpen: @entangle('isInvoiceModalOpen') }">

    <div class="flex sm:flex-row flex-col justify-between sm:items-center gap-4 mb-6 pb-4 border-b border-outline-variant/30 select-none">
        <div>
            <div class="flex items-center gap-1 mb-1 font-semibold text-on-surface-variant text-xs">
                <span>Global Overview</span>
                <span class="text-[14px] material-symbols-outlined">chevron_right</span>
                <span class="font-bold text-primary">Buyer Workspace Hub</span>
            </div>
            <h2 class="font-headline-lg font-bold text-headline-lg text-primary text-2xl tracking-tight">Quotations Repository: {{ $buyerProfile->company_name ?? 'Corporate Account' }}</h2>
            <p class="mt-0.5 font-body-sm text-on-surface-variant text-sm">Review incoming multi-item payloads, attach official invoices, manage status changes, and track active negotiations threads.</p>
        </div>
        <div class="bg-surface-container shadow-inner px-4 py-2 border rounded-xl h-fit font-mono font-bold text-primary text-xs select-none">
            Profile Lookup ID Code: #{{ $buyerId }}
        </div>
    </div>

    <div class="mb-6 max-w-md select-none">
        <div class="relative w-full">
            <span class="top-1/2 left-4 absolute text-outline text-[20px] -translate-y-1/2 material-symbols-outlined">search</span>
            <input wire:model.live.debounce.250ms="search" type="text"
                class="bg-white shadow-sm py-3 pr-4 pl-11 border rounded-2xl border-outline-variant/60 outline-none focus:ring-1 focus:ring-primary w-full font-medium text-primary text-xs"
                placeholder="Search quotes by RFQ Reference or unique product name...">
        </div>
    </div>

    @if(session()->has('success'))
        <div class="flex items-center gap-2 bg-emerald-50 mb-6 p-4 border border-emerald-200 rounded-xl font-semibold text-emerald-800 text-xs animate-fadeIn select-none">
            <span class="text-[18px] material-symbols-outlined">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session()->has('error'))
        <div class="flex items-center gap-2 bg-red-50 mb-6 p-4 border border-red-200 rounded-xl font-semibold text-red-800 text-xs animate-fadeIn select-none">
            <span class="text-[18px] material-symbols-outlined">error</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="space-y-6">
        @forelse($quotes as $quote)
            <div wire:key="admin-quote-card-{{ $quote->id }}" class="flex flex-col justify-between bg-white shadow-sm hover:shadow-md p-6 border rounded-[2rem] border-outline-variant/50 overflow-hidden transition-shadow animate-fadeIn">

                <div class="flex flex-wrap justify-between items-center gap-4 pb-3 border-background border-b text-xs select-none">
                    <div class="flex items-center gap-3">
                        <span class="bg-primary/5 shadow-inner px-3 py-1 border border-primary/10 rounded-lg font-mono font-bold text-primary text-sm">
                            RFQ Reference: {{ $quote->order_ref_number }}
                        </span>
                        <span class="flex items-center gap-1 font-sans font-semibold text-[11px] text-on-surface-variant">
                            <span class="text-[15px] material-symbols-outlined">calendar_today</span> Received: {{ $quote->created_at->format('M d, Y') }}
                        </span>
                    </div>

                    <div class="flex flex-wrap items-center gap-4">
                        <div class="flex items-center gap-1.5 font-bold text-[11px] text-on-surface-variant">
                            <span>Quote Status:</span>
                            <select wire:change="updateOrderStatus({{ $quote->id }}, $event.target.value)"
                                    class="bg-surface-container-low focus:bg-white shadow-sm px-3 py-1.5 border rounded-xl border-outline-variant/60 outline-none focus:ring-1 focus:ring-primary font-mono font-bold text-primary text-xs tracking-tight cursor-pointer">
                                @foreach($allowedStatuses as $statusNode)
                                    <option value="{{ $statusNode }}" {{ $quote->order_progress === $statusNode ? 'selected' : '' }}>
                                        {{ $statusNode }}
                                            </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center gap-1.5 font-bold text-[11px] text-on-surface-variant">
                            <span>Freight/Shipment:</span>
                            <select wire:change="updateShipmentStatus({{ $quote->id }}, $event.target.value)"
                                    class="bg-surface-container-low focus:bg-white shadow-sm px-3 py-1.5 border rounded-xl border-outline-variant/60 outline-none focus:ring-1 focus:ring-primary font-mono font-bold text-primary text-xs tracking-tight cursor-pointer">
                                @foreach(['unshipped', 'Shipped Order', 'shipped', 'delivered', 'cancelled'] as $shipStatus)
                                    <option value="{{ $shipStatus }}" {{ $quote->shipment_status === $shipStatus ? 'selected' : '' }}>
                                        {{ ucwords($shipStatus) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="gap-6 grid grid-cols-1 lg:grid-cols-3 my-4 font-semibold text-on-surface-variant text-xs">
                    <div class="space-y-2 bg-surface-container-low/40 p-4 border rounded-2xl border-outline-variant/30 select-none">
                        <span class="block text-outline font-bold text-[10px] uppercase tracking-wider">Logistical Routing Specifications</span>
                        <div class="space-y-1 font-medium text-[11px] text-primary">
                            <div>Target Country: <strong>{{ $quote->destination_country }}</strong></div>
                            <div>Preferred Incoterm: <strong class="font-mono text-[10px]">{{ $quote->incoterms_preferred ?? 'FOB' }}</strong></div>
                            <div>Shipping Channel: <strong>{{ $quote->preferred_shipping_method }}</strong></div>
                        </div>
                    </div>

                    <div class="space-y-2 bg-surface-container-low/40 p-4 border rounded-2xl border-outline-variant/30 select-none">
                        <span class="block text-outline font-bold text-[10px] uppercase tracking-wider">Commercial Settings Parameters</span>
                        <div class="space-y-1 font-medium text-[11px] text-primary">
                            <div>Payment Terms Channel: <strong>{{ $quote->preferred_payment_method ?? 'Bank Transfer' }}</strong></div>
                            <div>Target Monthly Volume: <strong>{{ $quote->estimated_monthly_volume ?? 'Not Specified' }}</strong></div>
                            <div>Origin Loading Port: <strong>{{ $quote->loading_port ?? 'Unspecified Port' }}</strong></div>
                        </div>
                    </div>

                    <div class="flex flex-col justify-center bg-surface-container-low/80 p-4 border border-dashed rounded-2xl border-outline-variant/80 min-h-[90px] text-left select-none">
                        <span class="block text-outline font-bold text-[10px] uppercase tracking-wider">RFQ Target Valuation Total</span>
                        <div class="flex items-baseline gap-1 mt-0.5 select-all">
                            <h4 class="font-mono font-bold text-primary text-xl">{{ $quote->quotation_currency }} {{ number_format($quote->grand_total_price, 2) }}</h4>
                        </div>
                        <span class="block mt-1 font-sans text-[10px] text-on-surface-variant/70">Total Item Count: <strong>{{ count($quote->quotation_items ?? []) }} lines</strong></span>
                    </div>
                </div>

                <div class="bg-white my-2 border rounded-2xl overflow-hidden select-none">
                    <div class="flex items-center gap-1 bg-surface-container px-4 py-2 border-b border-outline-variant/30 font-bold text-[11px] text-primary uppercase tracking-wider">
                        <span class="text-[16px] material-symbols-outlined">list_alt</span> Itemized Quotation Details Ledger
                    </div>
                    <div class="overflow-x-auto hide-scrollbar">
                        <table class="w-full text-xs text-left border-collapse">
                            <thead>
                                <tr class="bg-surface-container-low border-b border-outline-variant/30 font-bold text-[10px] text-on-surface-variant uppercase tracking-wide">
                                    <th class="p-3">Product Specifications Title</th>
                                    <th class="p-3">Origin / Packaging</th>
                                    <th class="p-3 text-right">Target Volume</th>
                                    <th class="p-3 text-right">Unit Target Rate</th>
                                    <th class="p-3 text-right">Line Gross Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-background font-medium text-primary">
                                @if(isset($quote->quotation_items) && is_array($quote->quotation_items))
                                    @foreach($quote->quotation_items as $lineItem)
                                        <tr class="hover:bg-background/40 transition-colors">
                                            <td class="p-3 max-w-xs">
                                                <div class="font-bold text-primary">{{ $lineItem['product_name'] }}</div>
                                                @if(!empty($lineItem['product_description']))
                                                    <p class="mt-0.5 text-[10px] text-on-surface-variant line-clamp-1" title="{{ $lineItem['product_description'] }}">{{ $lineItem['product_description'] }}</p>
                                                @endif
                                            </td>
                                            <td class="p-3 text-[11px] text-on-surface-variant">
                                                <div>Origin: {{ $lineItem['product_origin'] ?: 'Unlisted' }}</div>
                                                <div class="opacity-80 text-[10px]">Pack: {{ $lineItem['packaging_details'] ?: 'Bulk standard' }}</div>
                                            </td>
                                            <td class="p-3 font-mono font-bold text-right">{{ number_format($lineItem['order_quantity'], 2) }}</td>
                                            <td class="p-3 font-mono text-right">{{ $quote->quotation_currency }} {{ number_format($lineItem['quoted_price_per_unit'], 4) }}</td>
                                            <td class="p-3 font-mono font-bold text-emerald-800 text-right">{{ $quote->quotation_currency }} {{ number_format($lineItem['total_item_price'], 2) }}</td>
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
                                <span>Official Settlement Commercial Invoice</span>
                            </span>
                            @if(isset($quote->payment_meta['supplier_invoice']))
                                <a href="{{ asset('storage/' . $quote->payment_meta['supplier_invoice']) }}" target="_blank" class="bg-primary hover:bg-primary/95 shadow-sm px-3 py-1.5 rounded-lg font-bold text-[11px] text-white">
                                    View Invoice <span class="text-[14px] material-symbols-outlined">open_in_new</span>
                                </a>
                            @else
                                <span class="pr-2 font-bold text-[10px] text-red-600 uppercase tracking-wide animate-pulse select-none">Awaiting Upload</span>
                            @endif
                        </div>

                        <div class="flex flex-col justify-center gap-1.5 bg-white shadow-sm p-3 border rounded-xl">
                            <div class="flex justify-between items-center pb-1 border-b select-none">
                                <span class="flex items-center gap-1.5 font-bold text-on-surface text-primary">
                                    <span class="text-[18px] text-emerald-600 material-symbols-outlined">cloud_done</span>
                                    <span>Buyer Remitted Wire Slips Receipts Stack</span>
                                </span>
                                <span class="bg-surface-container px-2.5 py-0.5 border rounded-md font-mono font-bold text-[10px] text-primary">
                                    Count: {{ count($quote->payment_meta['receipts'] ?? []) }}
                                </span>
                            </div>

                            @if(isset($quote->payment_meta['receipts']) && !empty($quote->payment_meta['receipts']))
                                <div class="space-y-1 pr-0.5 max-h-20 overflow-y-auto hide-scrollbar">
                                    @foreach($quote->payment_meta['receipts'] as $receiptNode)
                                        <div class="flex justify-between items-center bg-surface-container-low p-1.5 border rounded-lg text-[11px]">
                                            <a href="{{ asset('storage/' . $receiptNode['file_path']) }}" target="_blank" class="flex items-center gap-1 max-w-[280px] font-bold text-primary hover:underline truncate">
                                                <span class="text-[14px] material-symbols-outlined">download</span>
                                                <span class="truncate">{{ $receiptNode['file_name'] ?? 'View Verification Wire' }}</span>
                                            </a>
                                            <span class="font-mono text-[9px] text-on-surface-variant/60 select-none">{{ \Carbon\Carbon::parse($receiptNode['uploaded_at'])->format('M d, H:i') }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="p-1 text-[11px] text-on-surface-variant/40 italic select-none">No client remitted wire payments uploaded yet.</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap justify-end items-center gap-3 mt-2 pt-4 border-background border-t select-none">
                    <button type="button" wire:click="openInvoiceModal({{ $quote->id }})"
                            class="flex items-center gap-1.5 bg-surface-container hover:bg-surface-container-high px-5 py-2.5 border rounded-xl border-outline-variant/40 font-label-md font-bold text-on-surface-variant text-xs transition-colors cursor-pointer">
                        <span class="text-[16px] material-symbols-outlined">request_quote</span>
                        {{ isset($quote->payment_meta['supplier_invoice']) ? 'Replace Billing Invoice' : 'Attach Billing Invoice' }}
                    </button>

                    <a href="{{ route('admin.buyers.orders.tracker', ['orderId' => $quote->id]) }}"
                       wire:navigate
                       class="flex items-center gap-1.5 bg-primary hover:bg-primary/95 shadow-sm px-6 py-2.5 rounded-xl font-label-md font-bold text-white text-xs active:scale-95 transition-all cursor-pointer">
                        <span class="text-[16px] material-symbols-outlined">forum</span>
                        Open Negotiation Tracker Thread
                    </a>
                </div>

            </div>
        @empty
            <div class="bg-white p-16 border border-dashed rounded-[2.5rem] text-on-surface-variant text-center italic select-none">
                <span class="block mb-2 text-outline text-[56px] material-symbols-outlined">assignment_late</span>
                <p class="font-bold text-primary text-sm not-italic">No Sourcing Proposals Registered</p>
                <p class="mx-auto mt-0.5 max-w-sm text-xs">There are no compiled custom quotations matching your lookup criteria under this buyer profile.</p>
            </div>
        @endforelse
    </div>

    <div x-show="invoiceOverlayOpen" x-cloak class="z-[100] fixed inset-0 flex justify-center items-center bg-black/40 shadow-2xl backdrop-blur-sm p-4 animate-fadeIn">
        <div @click.outside="invoiceOverlayOpen = false; $wire.call('closeInvoiceModal')" class="space-y-4 bg-white p-6 rounded-[2.5rem] w-full max-w-md overflow-hidden animate-fadeIn transform">

            <div class="flex justify-between items-center bg-primary -m-6 mb-4 p-5 text-white select-none">
                <div class="flex items-center gap-3">
                    <span class="text-[22px] material-symbols-outlined">upload_file</span>
                    <h3 class="font-bold text-sm tracking-tight">Attach Official Sourcing Invoice</h3>
                </div>
                <button type="button" @click="invoiceOverlayOpen = false; $wire.call('closeInvoiceModal')" class="hover:bg-white/10 p-1 rounded-full text-white cursor-pointer material-symbols-outlined">close</button>
            </div>

            <form wire:submit.prevent="uploadAdminInvoice" class="space-y-4 font-medium text-on-surface-variant text-xs">
                <p class="leading-relaxed">Select the itemized platform commercial invoice billing statement document sheet (PDF layout copy or image snapshot) for this order context.</p>

                <div class="space-y-1.5">
                    <label class="block pl-0.5 font-bold">Select Billing Document File Asset *</label>
                    <input type="file" wire:model="invoice_file" required class="block hover:file:bg-primary/20 file:bg-primary/10 file:mr-3 file:px-3 file:py-1.5 file:border-0 file:rounded-xl w-full font-semibold file:text-primary text-xs cursor-pointer">
                    <p class="mt-1 pl-0.5 text-[10px] text-on-surface-variant/60 select-none">Accepts PDF, PNG, or JPG formats up to 10MB sizes.</p>
                    @error('invoice_file') <span class="block mt-1 pl-0.5 font-bold text-[10px] text-red-500 animate-fadeIn">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end items-center gap-2 pt-3 border-background border-t font-bold select-none">
                    <button type="button" @click="invoiceOverlayOpen = false; $wire.call('closeInvoiceModal')" class="bg-surface-container hover:bg-surface-container-high px-4 py-2 rounded-xl text-on-surface-variant cursor-pointer">Dismiss</button>
                    <button type="submit" wire:loading.attr="disabled" class="flex items-center gap-1 bg-primary hover:bg-primary/95 shadow-md px-5 py-2 rounded-xl text-white cursor-pointer">
                        <span wire:loading.remove>Dispatch Invoice</span>
                        <span wire:loading class="flex items-center gap-1 animate-pulse"><span class="inline-block border-2 border-white border-t-transparent rounded-full w-3 h-3 animate-spin"></span> Uploading...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
