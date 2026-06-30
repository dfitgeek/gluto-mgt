<div class="flex-1 mx-auto my-2 p-gutter w-full max-w-[1440px]" x-data="{ invoiceOverlayOpen: @entangle('isInvoiceModalOpen') }">

    <div class="flex sm:flex-row flex-col justify-between sm:items-center gap-4 mb-8 pb-4 border-b border-outline-variant/30 select-none">
        <div>
            <h2 class="font-headline-lg font-bold text-headline-lg text-primary text-2xl tracking-tight">Incoming Buyer Procurement Orders</h2>
            <p class="mt-0.5 font-body-sm text-on-surface-variant text-sm">Review contract parameters initialized by B2B buyers, inspect wire remittances, and attach formal commercial billing invoices.</p>
        </div>
        <div class="bg-surface-container shadow-inner px-4 py-2 border rounded-xl h-fit font-mono font-bold text-primary text-xs select-none">
            Vendor Reference Code: {{ auth('supplier')->user()->supplier_ref_number }}
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
            <div wire:key="supplier-order-row-{{ $order->id }}" class="flex flex-col justify-between bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/50 overflow-hidden animate-fadeIn">

                <div class="flex flex-wrap justify-between items-center gap-3 pb-3 border-background border-b text-xs select-none">
                    <div class="flex items-center gap-3">
                        <span class="bg-primary/5 shadow-inner px-3 py-1 border border-primary/10 rounded-lg font-mono font-bold text-primary text-sm">
                            Request Code: {{ $order->order_ref_number }}
                        </span>
                        <span class="font-mono font-semibold text-[11px] text-on-surface-variant">SKU ID Prefix Code: {{ $order->prod_ref }}</span>
                    </div>

                    <div class="flex items-center gap-2 font-mono font-bold text-[10px] uppercase tracking-wide">
                        <span class="px-2.5 py-1 rounded-md border shadow-inner
                            {{ in_array($order->order_progress, ['Confirmed Order', 'Confirmed order', 'confirmed order']) ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : 'bg-surface-container text-on-surface-variant' }}">
                            Progress: {{ $order->order_progress }}
                        </span>
                        <span class="bg-surface-container shadow-inner px-2.5 py-1 border rounded-md text-on-surface-variant/80">
                            Shipping: {{ $order->shipment_status }}
                        </span>
                    </div>
                </div>

                <div class="gap-6 grid grid-cols-1 lg:grid-cols-4 my-4 font-semibold text-on-surface-variant text-xs">

                    <div class="space-y-1 lg:col-span-2">
                        <span class="block text-outline font-bold text-[10px] uppercase tracking-wider select-none">Purchased Commodity Profile</span>
                        <h3 class="mt-0.5 font-headline-md font-bold text-primary text-base leading-snug">{{ $order->product_names }}</h3>
                        <p class="mt-0.5 font-medium text-on-surface-variant/70 line-clamp-2 whitespace-pre-line">{{ $order->product_descriptions }}</p>
                    </div>

                    <div class="space-y-2 bg-surface-container-low/40 p-4 border rounded-2xl border-outline-variant/30 select-none">
                        <span class="block text-outline font-bold text-[10px] uppercase">Logistics & Destination Parameters</span>
                        <div class="space-y-1 font-medium text-[11px]">
                            <div>Region: <strong class="text-primary">{{ $order->destination_country }}</strong></div>
                            <div>Incoterms: <strong class="font-mono text-[10px] text-primary">{{ $order->incotermsPreferred ?? $order->incoterms_preferred ?? 'FOB' }}</strong></div>
                            <div>Carrier: <strong class="text-primary">{{ $order->preferred_shipping_method }}</strong></div>
                        </div>
                    </div>

                    <div class="flex flex-col justify-center bg-surface-container-low/80 p-4 border border-dashed rounded-2xl border-outline-variant/80 text-left select-none">
                        <span class="block text-outline font-bold text-[10px] uppercase">Gross Contract Purchase Volume Value</span>
                        <div class="flex items-baseline gap-0.5 mt-1">
                            <strong class="font-mono text-emerald-800 text-xl">₦{{ number_format($order->total_order_price, 2) }}</strong>
                        </div>
                        <span class="block mt-0.5 font-medium text-[10px] text-on-surface-variant/70">Vol: <strong>{{ number_format($order->order_quantity) }} pcs</strong> @ ₦{{ number_format($order->quoted_price_per_unit, 2) }}</span>
                    </div>
                </div>

                <div class="gap-4 grid grid-cols-1 md:grid-cols-2 mt-2 pt-3 border-background border-t">

                    <div class="relative flex justify-between items-center bg-white p-4 border rounded-2xl border-outline-variant/60 font-semibold text-xs">
                        <div class="flex items-center gap-2 max-w-[260px] truncate">
                            <div class="flex flex-shrink-0 justify-center items-center bg-primary/5 rounded-lg w-8 h-8 text-primary">
                                <span class="text-[18px] material-symbols-outlined">account_balance_wallet</span>
                            </div>
                            <div class="truncate">
                                <span class="block font-bold text-primary leading-none">Commercial Invoice Asset</span>
                                <span class="block mt-1 font-mono font-bold text-[10px] text-on-surface-variant/70">Target: Updatable by Supplier Only</span>
                            </div>
                        </div>

                        @if(isset($order->payment_meta['supplier_invoice']) && filled($order->payment_meta['supplier_invoice']))
                            <a href="{{ asset('storage/' . $order->payment_meta['supplier_invoice']) }}" target="_blank" class="flex items-center gap-0.5 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 border border-emerald-200/50 rounded-xl font-bold text-emerald-800">
                                View Invoice <span class="text-[14px] material-symbols-outlined">open_in_new</span>
                            </a>
                        @else
                            <span class="bg-red-50 px-2.5 py-1 border border-red-100 rounded-lg font-bold text-[10px] text-red-600 uppercase tracking-wide animate-pulse select-none">
                                Invoice Pending
                            </span>
                        @endif
                    </div>

                    <div class="flex justify-between items-center bg-white p-4 border rounded-2xl border-outline-variant/60 font-semibold text-xs">
                        <div class="flex items-center gap-2 max-w-[260px] truncate select-none">
                            <div class="flex flex-shrink-0 justify-center items-center bg-secondary/5 rounded-lg w-8 h-8 text-secondary">
                                <span class="text-[18px] material-symbols-outlined">cloud_done</span>
                            </div>
                            <div>
                                <span class="block font-bold text-secondary leading-none">Buyer Remitted Wire Slips Receipts</span>
                                <span class="block mt-1 font-sans font-medium text-[10px] text-on-surface-variant/70">Read-Only View Track for Vendor</span>
                            </div>
                        </div>

                        <div class="space-y-1 text-right">
                            @if(isset($order->payment_meta['receipts']) && !empty($order->payment_meta['receipts']))
                                @foreach($order->payment_meta['receipts'] as $receiptNode)
                                    <a href="{{ asset('storage/' . $receiptNode['file_path']) }}" target="_blank" class="block max-w-[140px] font-bold text-[11px] text-primary hover:underline truncate">
                                        {{ $receiptNode['file_name'] ?? 'View Receipt' }} ↗
                                    </a>
                                @endforeach
                            @else
                                <span class="pr-2 text-[10px] text-on-surface-variant/40 italic select-none">Awaiting Remittance</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap justify-end items-center gap-2.5 mt-4 pt-4 border-background border-t select-none">
                    <button type="button" wire:click="openInvoiceModal({{ $order->id }})" class="flex items-center gap-1.5 bg-primary hover:bg-primary/95 shadow-sm px-5 py-2.5 rounded-xl font-label-md font-bold text-white text-xs cursor-pointer">
                        <span class="text-[16px] material-symbols-outlined">upload_file</span>
                        {{ isset($order->payment_meta['supplier_invoice']) ? 'Replace Attached Invoice File' : 'Attach Commercial Invoice File' }}
                    </button>
                </div>

            </div>
        @empty
            <div class="bg-white p-16 border border-dashed rounded-[2.5rem] text-on-surface-variant text-center italic select-none">
                <span class="block mb-2 text-outline text-[56px] material-symbols-outlined">assignment_late</span>
                <p class="font-bold text-primary text-sm not-italic">No Active Sourcing Contract Requests</p>
                <p class="mx-auto mt-0.5 max-w-sm text-xs">There are no client buyer contract pipeline orders initialized matching your catalogue product references SKU strings yet.</p>
            </div>
        @endforelse
    </div>

    <div x-show="invoiceOverlayOpen" x-cloak class="z-[100] fixed inset-0 flex justify-center items-center bg-black/40 shadow-2xl backdrop-blur-sm p-4 animate-fadeIn">
        <div @click.outside="invoiceOverlayOpen = false; $wire.call('closeInvoiceModal')" class="space-y-4 bg-white p-6 rounded-[2.5rem] w-full max-w-md overflow-hidden animate-fadeIn transform">

            <div class="flex justify-between items-center bg-primary -m-6 mb-4 p-5 text-white select-none">
                <div class="flex items-center gap-3">
                    <span class="text-[22px] material-symbols-outlined">request_quote</span>
                    <h3 class="font-bold text-sm tracking-tight">Attach Official Invoice Document</h3>
                </div>
                <button type="button" @click="invoiceOverlayOpen = false; $wire.call('closeInvoiceModal')" class="hover:bg-white/10 p-1 rounded-full text-white cursor-pointer material-symbols-outlined">close</button>
            </div>

            <form wire:submit.prevent="uploadInvoice" class="space-y-4 font-medium text-on-surface-variant text-xs">
                <p class="leading-relaxed">Upload the itemized commercial billing invoice statement (PDF copy or image snapshot) for this order. This file will be instantly visible to the buyer on their history dashboard.</p>

                <div class="space-y-1.5">
                    <label class="block pl-0.5 font-bold">Select Billing Document File Asset *</label>
                    <input type="file" wire:model="invoice_file" required class="block hover:file:bg-primary/20 file:bg-primary/10 file:mr-3 file:px-3 file:py-1.5 file:border-0 file:rounded-xl w-full font-semibold file:text-primary text-xs cursor-pointer">
                    <p class="mt-1 pl-0.5 text-[10px] text-on-surface-variant/60 select-none">Accepts PDF, PNG, or JPG snapshots formats up to 10MB capacity size limit.</p>
                    @error('invoice_file') <span class="block mt-1 pl-0.5 font-bold text-[10px] text-red-500 animate-fadeIn">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end items-center gap-2 pt-3 border-background border-t font-bold select-none">
                    <button type="button" @click="invoiceOverlayOpen = false; $wire.call('closeInvoiceModal')" class="bg-surface-container hover:bg-surface-container-high px-4 py-2 rounded-xl text-on-surface-variant cursor-pointer">Dismiss</button>
                    <button type="submit" wire:loading.attr="disabled" class="flex items-center gap-1 bg-primary hover:bg-primary/95 shadow-md px-5 py-2 rounded-xl text-white cursor-pointer">
                        <span wire:loading.remove>Dispatch Billing Invoice</span>
                        <span wire:loading class="flex items-center gap-1 animate-pulse"><span class="inline-block border-2 border-white border-t-transparent rounded-full w-3 h-3 animate-spin"></span> Storing asset...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
