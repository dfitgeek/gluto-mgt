<div class="flex-1 mx-auto my-2 p-gutter w-full max-w-[1440px]">

    <div class="flex sm:flex-row flex-col justify-between sm:items-center gap-4 mb-8 pb-4 border-b border-outline-variant/30 select-none">
        <div>
            <h2 class="font-headline-lg font-bold text-headline-lg text-primary text-2xl tracking-tight">Buyer Analytics Control Console</h2>
            <p class="mt-0.5 font-body-sm text-on-surface-variant text-sm">Monitor system-wide platform user growth metrics, review customer verification ratios, and trace historical sourcing valuations.</p>
        </div>
    </div>

    <div class="gap-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 mb-8 select-none">

        <div class="flex items-center gap-4 bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/40 animate-fadeIn">
            <div class="flex flex-shrink-0 justify-center items-center bg-primary/5 border border-primary/10 rounded-2xl w-12 h-12 text-primary">
                <span class="text-[24px] material-symbols-outlined">group</span>
            </div>
            <div>
                <span class="block text-outline font-bold text-[10px] uppercase tracking-wider">Total B2B Buyers</span>
                <strong class="block mt-0.5 font-mono text-primary text-xl md:text-2xl">{{ number_format($totalBuyersCount) }}</strong>
            </div>
        </div>

        <div class="flex items-center gap-4 bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/40 animate-fadeIn">
            <div class="flex flex-shrink-0 justify-center items-center bg-emerald-50 border border-emerald-100 rounded-2xl w-12 h-12 text-emerald-700">
                <span class="text-[24px] material-symbols-outlined">verified</span>
            </div>
            <div>
                <span class="block text-outline font-bold text-[10px] uppercase tracking-wider">Verified Accounts</span>
                <strong class="block mt-0.5 font-mono text-emerald-800 text-xl md:text-2xl">{{ number_format($verifiedBuyersCount) }}</strong>
            </div>
        </div>

        <div class="flex items-center gap-4 bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/40 animate-fadeIn">
            <div class="flex flex-shrink-0 justify-center items-center bg-amber-50 border border-amber-100 rounded-2xl w-12 h-12 text-amber-700">
                <span class="text-[24px] material-symbols-outlined">gpp_maybe</span>
            </div>
            <div>
                <span class="block text-outline font-bold text-[10px] uppercase tracking-wider">Unverified Accounts</span>
                <strong class="block mt-0.5 font-mono text-amber-800 text-xl md:text-2xl">{{ number_format($unverifiedBuyersCount) }}</strong>
            </div>
        </div>

        <div class="flex items-center gap-4 bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/40 animate-fadeIn">
            <div class="flex flex-shrink-0 justify-center items-center bg-indigo-50 border border-indigo-100 rounded-2xl w-12 h-12 text-indigo-700">
                <span class="text-[24px] material-symbols-outlined">analytics</span>
            </div>
            <div>
                <span class="block text-outline font-bold text-[10px] uppercase tracking-wider">Total Pipeline Value</span>
                <strong class="block mt-0.5 font-mono text-indigo-800 text-lg md:text-xl" title="Aggregate cumulative quote value gross sum">NGN {{ number_format($totalQuotesValue, 2) }}</strong>
            </div>
        </div>

    </div>

    <div class="bg-white shadow-sm border rounded-[2rem] border-outline-variant/50 overflow-hidden animate-fadeIn">
        <div class="flex justify-between items-center bg-surface-container px-6 py-4 border-b border-outline-variant/30 font-bold text-primary text-xs uppercase tracking-wider select-none">
            <span class="flex items-center gap-1.5"><span class="text-[18px] material-symbols-outlined">history</span> Real-time Recent Quotation Submissions Stream</span>
            <a href="{{ route('admin.buyers.orders') }}" wire:navigate class="font-sans font-bold text-[11px] text-primary hover:underline normal-case">View Master Ledger →</a>
        </div>

        <div class="overflow-x-auto hide-scrollbar">
            <table class="w-full font-medium text-on-surface-variant text-xs text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low border-b border-outline-variant/30 font-bold text-[10px] text-primary uppercase tracking-wide select-none">
                        <th class="p-4">Voucher Ticket</th>
                        <th class="p-4">Buyer Enterprise</th>
                        <th class="p-4">Manifest Sample Items</th>
                        <th class="p-4 text-right">Package Valuation</th>
                        <th class="p-4 text-center">Milestone Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-background text-primary">
                    @forelse($recentOrders as $order)
                        <tr wire:key="dashboard-recent-order-{{ $order->id }}" class="hover:bg-background/20 transition-colors">

                            <td class="p-4 font-mono whitespace-nowrap">
                                <span class="block font-bold text-primary">{{ $order->order_ref_number }}</span>
                                <span class="block mt-0.5 font-sans text-[10px] text-on-surface-variant/70">{{ $order->created_at->diffForHumans() }}</span>
                            </td>

                            <td class="p-4 max-w-xs truncate">
                                <div class="font-bold text-primary text-xs">{{ $order->buyer->company_name ?? 'Corporate Buyer Entity' }}</div>
                                <span class="block mt-0.5 font-mono text-[10px] text-on-surface-variant/60">Profile Ref: #{{ $order->buyer_profile_id }}</span>
                            </td>

                            <td class="p-4 max-w-xs">
                                @if(is_array($order->quotation_items) && !empty($order->quotation_items))
                                    <span class="font-bold text-primary">{{ $order->quotation_items[0]['product_name'] ?? 'Custom Commodity Item' }}</span>
                                    @if(count($order->quotation_items) > 1)
                                        <span class="block mt-0.5 font-medium text-[10px] text-on-surface-variant/70 italic">+ {{ count($order->quotation_items) - 1 }} alternative line products...</span>
                                    @endif
                                @else
                                    <span class="text-outline/50 text-[11px] italic">Empty Manifest Deck</span>
                                @endif
                            </td>

                            <td class="p-4 font-mono font-bold text-emerald-800 text-right whitespace-nowrap select-all">
                                {{ $order->quotation_currency }} {{ number_format($order->grand_total_price, 2) }}
                            </td>

                            <td class="p-4 whitespace-nowrap select-none">
                                <div class="flex justify-center items-center">
                                    <span class="px-2.5 py-1 rounded-md text-[10px] font-mono font-bold tracking-tight uppercase shadow-inner border
                                        {{ $order->order_progress === 'Invoice' ? 'bg-indigo-50 text-indigo-700 border-indigo-100' : '' }}
                                        {{ in_array($order->order_progress, ['Confirm Order', 'Completed Order']) ? 'bg-emerald-50 text-emerald-800 border-emerald-100' : '' }}
                                        {{ !in_array($order->order_progress, ['Invoice', 'Confirm Order', 'Completed Order']) ? 'bg-surface-container text-on-surface-variant' : '' }}">
                                        {{ $order->order_progress }}
                                    </span>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-on-surface-variant text-center italic select-none">
                                <div class="opacity-40 mb-1 text-outline text-[40px] material-symbols-outlined">query_stats</div>
                                <span class="block font-bold text-primary text-xs not-italic">No Quotes Logged Recently</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
