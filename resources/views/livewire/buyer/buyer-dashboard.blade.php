<div class="flex-1 mx-auto my-2 p-gutter w-full max-w-[1440px]">

    <!-- TOP DASHBOARD WELCOME HEADER BAR -->
    <div class="flex sm:flex-row flex-col justify-between sm:items-center gap-4 mb-8 pb-4 border-b border-outline-variant/30 select-none">
        <div>
            <h2 class="font-headline-lg font-bold text-headline-lg text-primary text-2xl tracking-tight">Buyer Dashboard</h2>
            <p class="mt-0.5 font-body-sm text-on-surface-variant text-sm">Welcome back! Review your enterprise financial tracking, open logistical batches, and quality control indicators.</p>
        </div>
        <div class="flex gap-2 select-none">
            <a href="{{ route('buyer.product') }}" class="flex items-center gap-2 bg-primary hover:bg-primary/95 shadow-md px-5 py-3 rounded-xl font-label-md font-bold text-white text-xs transition-all cursor-pointer">
                <span class="text-[18px] material-symbols-outlined">add_shopping_cart</span> Place New Request Order
            </a>
        </div>
    </div>

    <!-- MAIN SUMMARY CARD MATRIX GRID -->
    <div class="gap-6 grid grid-cols-1 md:grid-cols-3">

        <!-- CARD 1: AGGREGATE PROCUREMENT FINANCIAL MATRIX -->
        <div class="flex flex-col justify-between bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/50 overflow-hidden animate-fadeIn">
            <div class="space-y-4">
                <div class="flex justify-between items-center pb-3 border-background border-b select-none">
                    <div class="flex items-center gap-2">
                        <div class="flex justify-center items-center bg-emerald-50 rounded-lg w-8 h-8 text-emerald-700">
                            <span class="text-[18px] material-symbols-outlined">payments</span>
                        </div>
                        <h3 class="font-label-md font-bold text-primary text-xs">Total Purchases Made So Far</h3>
                    </div>
                </div>

                <div class="py-4">
                    <span class="block font-bold text-[11px] text-on-surface-variant/70 uppercase tracking-wide select-none">Settled Procurement Capital</span>
                    <h4 class="mt-1 font-mono font-bold text-primary text-3xl">₦{{ number_format($totalPurchases, 2) }}</h4>
                </div>
            </div>

            <div class="pt-4 border-background border-t select-none">
                <a href="#" class="flex items-center gap-1 font-bold text-secondary text-xs hover:underline">
                    <span>Audit complete billing ledgers</span>
                    <span class="text-[14px] material-symbols-outlined">arrow_right_alt</span>
                </a>
            </div>
        </div>

        <!-- CARD 2: REAL-TIME LATEST ORDER STATUS INDICATOR -->
        <div class="flex flex-col justify-between bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/50 overflow-hidden animate-fadeIn">
            <div class="space-y-4">
                <div class="flex justify-between items-center pb-3 border-background border-b select-none">
                    <div class="flex items-center gap-2">
                        <div class="flex justify-center items-center bg-primary/5 rounded-lg w-8 h-8 text-primary">
                            <span class="text-[18px] material-symbols-outlined">local_shipping</span>
                        </div>
                        <h3 class="font-label-md font-bold text-primary text-xs">Latest Request Status</h3>
                    </div>

                    @if($latestOrder)
                        <span class="bg-secondary-container px-2 py-0.5 border border-secondary/20 rounded font-mono font-bold text-[9px] text-on-secondary-container uppercase tracking-wide select-none">
                            Ref: {{ $latestOrder->order_tracking_reference ?? 'Pending' }}
                        </span>
                    @endif
                </div>

                <div class="py-2">
                    @if($latestOrder)
                        <div class="space-y-1">
                            <span class="block font-medium text-on-surface-variant text-xs truncate">Consignment: <strong class="text-primary">{{ $latestOrder->commodity_item_name ?? 'Bulk Shipment batch' }}</strong></span>

                            <div class="flex items-center gap-2 pt-2 select-none">
                                <span class="font-semibold text-[11px] text-on-surface-variant">Lifecycle Stage:</span>
                                <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase font-mono shadow-inner tracking-wide
                                    {{ $latestOrder->status_label === 'Completed' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : ($latestOrder->status_label === 'Pending' ? 'bg-amber-50 text-amber-700 border border-amber-100' : 'bg-surface-container text-on-surface-variant') }}">
                                    {{ $latestOrder->status_label ?? 'Processing' }}
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-2 bg-background/50 p-3 border border-dashed rounded-xl text-on-surface-variant/50 text-xs italic select-none">
                            <span class="text-[16px] material-symbols-outlined">shopping_cart_off</span>
                            <span>No procurement request batches filed yet.</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="pt-4 border-background border-t select-none">
                <a href="#" class="flex items-center gap-1 font-bold text-secondary text-xs hover:underline">
                    <span>View full corporate listings tracking</span>
                    <span class="text-[14px] material-symbols-outlined">arrow_right_alt</span>
                </a>
            </div>
        </div>

        <!-- CARD 3: AUDIT TIMELINE TRACK HIGHLIGHT REMINDER -->
        <div class="flex flex-col justify-between bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/50 overflow-hidden animate-fadeIn">
            <div class="space-y-4">
                <div class="flex justify-between items-center pb-3 border-background border-b select-none">
                    <div class="flex items-center gap-2">
                        <div class="flex justify-center items-center bg-amber-50 rounded-lg w-8 h-8 text-amber-800">
                            <span class="text-[18px] material-symbols-outlined">notification_important</span>
                        </div>
                        <h3 class="font-label-md font-bold text-primary text-xs">Latest Tracker Highlight</h3>
                    </div>
                </div>

                <div class="py-1">
                    @if($latestTracking)
                        <div class="space-y-1">
                            <div class="flex items-center gap-1.5 select-none">
                                <span class="max-w-[160px] font-bold text-[11px] text-primary truncate">{{ $latestTracking->subject }}</span>
                                @if($latestTracking->resolution_status === 'Pending Response')
                                    <span class="bg-red-50 px-1.5 py-0.5 border border-red-100 rounded font-bold text-[8px] text-red-700 uppercase tracking-wider animate-pulse">Action Required</span>
                                @endif
                            </div>
                            <p class="mt-1 font-medium text-[11px] text-on-surface-variant line-clamp-2 leading-relaxed">{{ $logNode ?? $latestTracking->message_content }}</p>
                        </div>
                    @else
                        <div class="flex items-center gap-2 bg-background/50 p-3 border border-dashed rounded-xl text-on-surface-variant/50 text-xs italic select-none">
                            <span class="text-[16px] material-symbols-outlined">assignment_turned_in</span>
                            <span>Compliance evaluation status is clear.</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="pt-4 border-background border-t select-none">
                <a href="#" class="flex items-center gap-1 font-bold text-secondary text-xs hover:underline">
                    <span>Open compliance action center</span>
                    <span class="text-[14px] material-symbols-outlined">arrow_right_alt</span>
                </a>
            </div>
        </div>

    </div>
</div>
