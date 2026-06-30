<div class="flex-1 mx-auto my-2 p-gutter w-full max-w-[1440px]" x-data="{ receiptOverlayOpen: @entangle('isReceiptModalOpen') }">

    <div class="flex sm:flex-row flex-col justify-between sm:items-center gap-4 mb-8 pb-4 border-b border-outline-variant/30 select-none">
        <div>
            <h2 class="font-headline-lg font-bold text-headline-lg text-primary text-2xl tracking-tight">My Historical Procurement Requests</h2>
            <p class="mt-0.5 font-body-sm text-on-surface-variant text-sm">Track processing updates pipelines milestones, inspect verified supplier billing invoices, and attach payment verification receipts logs sheets.</p>
        </div>
        <div class="flex flex-wrap gap-2.5">
            <a href="{{ route('buyer.documents') }}" wire:navigate class="flex items-center gap-1.5 bg-surface-container-high hover:bg-primary/10 px-5 py-3 rounded-xl font-label-md font-bold text-primary text-xs transition-all cursor-pointer">
                <span class="text-[18px] material-symbols-outlined">folder_shared</span> Access Documents Library
            </a>
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
            <div wire:key="buyer-order-card-{{ $order->id }}" class="flex flex-col justify-between bg-white shadow-sm hover:shadow-md p-6 border rounded-[2rem] border-outline-variant/50 overflow-hidden transition-shadow animate-fadeIn">

                <div class="flex flex-wrap justify-between items-center gap-3 pb-3 border-background border-b text-xs select-none">
                    <div class="flex items-center gap-3">
                        <span class="bg-primary/5 shadow-inner px-3 py-1 border border-primary/10 rounded-lg font-mono font-bold text-primary text-sm">
                            Order Ref: {{ $order->order_ref_number }}
                        </span>
                        <span class="font-mono font-semibold text-[11px] text-on-surface-variant">SKU ID Match: {{ $order->prod_ref }}</span>
                    </div>

                    <div class="flex items-center gap-2 font-mono font-bold text-[10px] uppercase tracking-wide">
                        <span class="px-2.5 py-1 rounded-md border shadow-inner
                            {{ in_array($order->order_progress, ['Confirmed Order', 'Confirmed order', 'confirmed order']) ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : 'bg-surface-container text-on-surface-variant' }}">
                            Order: {{ $order->order_progress }}
                        </span>
                        <span class="px-2.5 py-1 rounded-md border shadow-inner
                            {{ $order->shipment_status === 'shipped' || $order->shipment_status === 'Shipped Order' ? 'bg-primary/10 text-primary border-primary/20' : 'bg-surface-container text-on-surface-variant/80' }}">
                            Freight: {{ $order->shipment_status }}
                        </span>
                    </div>
                </div>

                <div class="gap-6 grid grid-cols-1 lg:grid-cols-3 my-4 font-semibold text-on-surface-variant text-xs">

                    <div class="space-y-1 md:col-span-2">
                        <span class="block text-outline font-bold text-[10px] uppercase tracking-wider select-none">Enrolled Sourcing Commodity</span>
                        <h3 class="font-headline-md font-bold text-primary text-base leading-snug">{{ $order->product_names }}</h3>
                        <p class="mt-1 font-medium text-on-surface-variant/80 line-clamp-2 leading-relaxed">{{ $order->product_descriptions ?? 'No long narrative specifications details compiled under this transactional manifest line item.' }}</p>
                    </div>

                    <div class="flex flex-col justify-center bg-surface-container-low/50 p-4 border border-dashed rounded-2xl border-outline-variant/80 min-h-[90px] text-left">
                        <span class="block text-outline font-bold text-[10px] uppercase tracking-wider select-none">Total Consolidated Gross Value</span>
                        <div class="flex items-baseline gap-1 mt-0.5 select-all">
                            <h4 class="font-mono font-bold text-primary text-xl">₦{{ number_format($order->total_order_price, 2) }}</h4>
                            <span class="text-outline font-mono font-bold text-[10px]">({{ $order->quotation_currency }})</span>
                        </div>
                        <span class="block mt-1 font-sans text-[10px] text-on-surface-variant/70">Volume: <strong>{{ number_format($order->order_quantity, 2) }} units</strong> @ ₦{{ number_format($order->quoted_price_per_unit, 2) }}</span>
                    </div>
                </div>

                <div class="space-y-3 bg-background my-2 p-4 border rounded-2xl font-medium text-xs">
                    <h4 class="flex items-center gap-1 font-bold text-[11px] text-primary uppercase tracking-wider select-none"><span class="text-[16px] material-symbols-outlined">receipt_long</span> Associated Payment & Billing Documents Vault Links</h4>

                    <div class="gap-3 grid grid-cols-1 md:grid-cols-2">
                        <div class="flex justify-between items-center gap-2 bg-white shadow-sm p-3 border rounded-xl">
                            <span class="flex items-center gap-1.5 max-w-[240px] text-on-surface truncate select-none">
                                <span class="text-[18px] text-primary material-symbols-outlined">account_balance_wallet</span>
                                <span>Official Supplier Sourcing Invoice Document</span>
                            </span>
                            @if(isset($order->payment_meta['supplier_invoice']))
                                <a href="{{ asset('storage/' . $order->payment_meta['supplier_invoice']) }}" target="_blank" class="flex flex-shrink-0 items-center gap-0.5 bg-primary hover:bg-primary/95 shadow-sm px-3 py-1 rounded-lg font-bold text-[11px] text-white">
                                    View Invoice <span class="text-[14px] material-symbols-outlined">open_in_new</span>
                                </a>
                            @else
                                <span class="pr-2 text-[10px] text-on-surface-variant/40 italic select-none">Awaiting Upload</span>
                            @endif
                        </div>

                        <div class="flex flex-col justify-center gap-2 md:col-span-1 bg-white shadow-sm p-3 border rounded-xl">
                            <div class="flex justify-between items-center mb-1 pb-1.5 border-b select-none">
                                <span class="flex items-center gap-1 font-bold text-[11px] text-primary"><span class="text-[16px] text-emerald-600 material-symbols-outlined">cloud_done</span> My Remitted Payment Receipts Stack</span>
                                <span class="bg-surface-container px-1.5 border rounded-md font-mono font-bold text-[10px] text-on-surface-variant">Count: {{ count($order->payment_meta['receipts'] ?? []) }}</span>
                            </div>

                            @if(isset($order->payment_meta['receipts']) && !empty($order->payment_meta['receipts']))
                                <div class="space-y-1.5 pr-0.5 max-h-24 overflow-y-auto hide-scrollbar">
                                    @foreach($order->payment_meta['receipts'] as $indexKey => $receiptObj)
                                        <div class="group/receipt relative flex justify-between items-center bg-surface-container-low p-2 pr-8 border rounded-lg text-[11px] animate-fadeIn">
                                            <a href="{{ asset('storage/' . $receiptObj['file_path']) }}" target="_blank" class="flex items-center gap-1 max-w-[200px] font-bold text-primary hover:underline truncate">
                                                <span class="text-[15px] text-emerald-600 material-symbols-outlined">download</span>
                                                <span>{{ $receiptObj['file_name'] ?? 'Receipt_Snapshot_Asset.pdf' }}</span>
                                            </a>
                                            <button type="button"
                                                wire:click="deleteReceipt({{ $order->id }}, {{ $indexKey }})"
                                                wire:confirm="Are you sure you want to drop and erase this explicit remitted bank payment receipt copy?"
                                                class="top-1/2 right-1.5 absolute p-1 text-outline hover:text-red-600 transition-colors -translate-y-1/2 cursor-pointer"
                                                title="Delete receipt snapshot">
                                                <span class="text-[15px] material-symbols-outlined">delete</span>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="flex items-center gap-1 p-1 text-[11px] text-on-surface-variant/40 italic select-none"><span class="text-[15px] material-symbols-outlined">info</span> No validation wire payment receipts submitted for processing under this batch profile.</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap justify-end items-center gap-2.5 mt-2 pt-4 border-background border-t select-none">
                    <button type="button" wire:click="openReceiptModal({{ $order->id }})" class="flex items-center gap-1.5 bg-primary hover:bg-primary/95 shadow-sm px-5 py-2.5 rounded-xl font-label-md font-bold text-white text-xs cursor-pointer">
                        <span class="text-[16px] material-symbols-outlined">upload_file</span> Add Payment Receipt Document
                    </button>
                </div>

            </div>
        @empty
            <div class="bg-white p-16 border border-dashed rounded-[2.5rem] text-on-surface-variant text-center italic select-none">
                <span class="block mb-2 text-outline text-[56px] material-symbols-outlined">receipt_long</span>
                <p class="font-bold text-primary text-sm not-italic">Pristine Transaction Registry</p>
                <p class="mx-auto mt-0.5 max-w-sm text-xs">There are no compiled historical procurement requests records or active contract order batches registered under your buyer account track layout profile yet.</p>
            </div>
        @endforelse
    </div>

    <div x-show="receiptOverlayOpen" x-cloak
         class="z-[100] fixed inset-0 flex justify-center items-center bg-black/40 backdrop-blur-sm p-4 sm:p-6 md:p-8 animate-fadeIn"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        <div @click.outside="receiptOverlayOpen = false; $wire.call('closeReceiptModal')"
             class="flex flex-col bg-white shadow-2xl rounded-[2.5rem] w-full max-w-md overflow-hidden transform"
             x-show="receiptOverlayOpen"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="scale-95 translate-y-4" x-transition:enter-end="scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="scale-100 translate-y-0" x-transition:leave-end="scale-95 translate-y-4">

            <div class="flex justify-between items-center bg-primary p-5 text-white select-none">
                <div class="flex items-center gap-3">
                    <span class="text-[22px] material-symbols-outlined">receipt</span>
                    <h3 class="font-headline-md font-bold text-sm tracking-tight">Upload Payment Receipt</h3>
                </div>
                <button type="button" @click="receiptOverlayOpen = false; $wire.call('closeReceiptModal')" class="hover:bg-white/10 p-1.5 rounded-full transition-colors cursor-pointer">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form wire:submit.prevent="appendReceipt" class="space-y-4 p-6 text-xs">
                <p class="font-medium text-on-surface-variant leading-relaxed">Attach your remitted wire document copy scan (Bank snapshot, MT103 confirmation slip sheet). This appends directly to the active audit stack chain references.</p>

                <div class="space-y-1.5">
                    <label class="block pl-0.5 font-bold text-on-surface-variant">Select Verification File *</label>
                    <input type="file" wire:model="receipt_file" required class="block hover:file:bg-primary/20 file:bg-primary/10 file:mr-3 file:px-3 file:py-1.5 file:border-0 file:rounded-xl w-full file:font-semibold text-on-surface-variant file:text-primary file:text-xs">
                    <p class="mt-1 pl-0.5 text-[10px] text-on-surface-variant/80">Accepts PDF or image documents up to 5MB.</p>
                    @error('receipt_file') <span class="block mt-1 pl-0.5 font-bold text-[10px] text-red-500 animate-fadeIn">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end items-center gap-2 pt-2 border-background border-t select-none">
                    <button type="button" @click="receiptOverlayOpen = false; $wire.call('closeReceiptModal')" class="bg-surface-container hover:bg-surface-container-high px-4 py-2 rounded-xl font-bold text-on-surface-variant cursor-pointer">Dismiss</button>
                    <button type="submit" wire:loading.attr="disabled" class="flex justify-center items-center gap-1 bg-primary hover:bg-primary/95 shadow-md px-5 py-2 rounded-xl font-bold text-white cursor-pointer">
                        <span wire:loading.remove>Commit Upload</span>
                        <span wire:loading class="flex items-center gap-1 animate-pulse"><span class="inline-block border-2 border-white border-t-transparent rounded-full w-3 h-3 animate-spin"></span> Syncing manifest...</span>
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>
