<div class="flex-1 mx-auto my-2 p-gutter w-full max-w-[1440px]">

    <div class="flex sm:flex-row flex-col justify-between sm:items-center gap-4 mb-8 pb-4 border-b border-outline-variant/30 select-none">
        <div>
            <h2 class="font-headline-lg font-bold text-headline-lg text-primary text-2xl tracking-tight">Supplier Operations Dashboard</h2>
            <p class="mt-0.5 font-body-sm text-on-surface-variant text-sm">Monitor inbound commercial demand channels, optimize logistical delivery pipelines, and track escrow settlements summary data flags.</p>
        </div>
        <div class="flex items-center gap-2 bg-surface-container shadow-inner px-4 py-2 border rounded-xl h-fit font-mono font-bold text-primary text-xs select-none">
            <span class="bg-emerald-500 rounded-full w-2 h-2 animate-pulse"></span>
            Fulfillment Link Online
        </div>
    </div>

    <div class="gap-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 mb-8 select-none">

        <div class="flex flex-col justify-between bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/50 min-h-[130px]">
            <div class="flex justify-between items-center">
                <span class="text-outline font-bold text-[10px] uppercase tracking-wider">Settled Valuation Volume</span>
                <span class="text-[20px] text-emerald-600 material-symbols-outlined">payments</span>
            </div>
            <div class="mt-2">
                <h3 class="font-mono font-bold text-neutral-900 text-2xl truncate">₦{{ number_format($metrics['total_revenue'], 2) }}</h3>
                <p class="mt-0.5 font-medium text-[11px] text-on-surface-variant">Aggregated Gross Completed Revenue</p>
            </div>
        </div>

        <div class="flex flex-col justify-between bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/50 min-h-[130px]">
            <div class="flex justify-between items-center">
                <span class="text-outline font-bold text-[10px] uppercase tracking-wider">Total Contract Vouchers</span>
                <span class="text-[20px] text-primary material-symbols-outlined">inventory_2</span>
            </div>
            <div class="mt-2">
                <h3 class="font-mono font-bold text-neutral-900 text-2xl">{{ number_format($metrics['total_orders']) }}</h3>
                <p class="mt-0.5 font-medium text-[11px] text-on-surface-variant">Lifetime Registered Purchase Orders</p>
            </div>
        </div>

        <div class="flex flex-col justify-between bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/50 min-h-[130px]">
            <div class="flex justify-between items-center">
                <span class="text-outline font-bold text-[10px] uppercase tracking-wider">Awaiting Billing Action</span>
                <span class="text-[20px] text-amber-600 material-symbols-outlined">request_quote</span>
            </div>
            <div class="mt-2">
                <h3 class="flex items-center gap-1.5 font-mono font-bold text-neutral-900 text-2xl">
                    {{ number_format($metrics['pending_action']) }}
                    @if($metrics['pending_action'] > 0)
                        <span class="inline-block bg-amber-500 rounded-full w-2 h-2 animate-ping"></span>
                    @endif
                </h3>
                <p class="mt-0.5 font-medium text-[11px] text-on-surface-variant">Staged or Awaiting Invoices</p>
            </div>
        </div>

        <div class="flex flex-col justify-between bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/50 min-h-[130px]">
            <div class="flex justify-between items-center">
                <span class="text-outline font-bold text-[10px] uppercase tracking-wider">Logistical Carriers Dispatched</span>
                <span class="text-[20px] text-purple-600 material-symbols-outlined">local_shipping</span>
            </div>
            <div class="mt-2">
                <h3 class="font-mono font-bold text-neutral-900 text-2xl">{{ number_format($metrics['active_processing']) }}</h3>
                <p class="mt-0.5 font-medium text-[11px] text-on-surface-variant">Active Midstream Freight Operations</p>
            </div>
        </div>

    </div>

    <div class="items-start gap-8 grid grid-cols-1 lg:grid-cols-3">

        <div class="lg:col-span-2 bg-white shadow-sm border rounded-[2rem] border-outline-variant/40 overflow-hidden">
            <div class="flex justify-between items-center bg-surface-container px-6 py-4 border-b border-outline-variant/30 font-bold text-primary text-xs uppercase tracking-wider select-none">
                <span class="flex items-center gap-1"><span class="text-[18px] material-symbols-outlined">history</span> Latest Inbound Procurements Stream</span>
                <a href="{{ route('supplier.orders') }}" wire:navigate class="bg-white hover:bg-primary px-3 py-1 border rounded-lg font-sans font-bold text-[10px] hover:text-white normal-case transition-colors">View Full Index</a>
            </div>

            <div class="overflow-x-auto hide-scrollbar">
                <table class="w-full font-medium text-neutral-800 text-xs text-left border-collapse">
                    <thead>
                        <tr class="bg-neutral-50/70 border-b border-outline-variant/20 font-bold text-[10px] text-on-surface-variant uppercase tracking-wide select-none">
                            <th class="p-4">PO Reference</th>
                            <th class="p-4">Date Issued</th>
                            <th class="p-4 text-right">Contract Price Value</th>
                            <th class="p-4">Milestone Progress</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100 font-sans text-neutral-900">
                        @forelse($recentOrders as $order)
                            <tr class="hover:bg-neutral-50/40 transition-colors">
                                <td class="p-4 font-mono font-bold text-primary select-all">#{{ $order->purchase_order_number }}</td>
                                <td class="p-4 font-medium text-neutral-500 select-none">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="p-4 font-mono font-bold text-emerald-800 text-right">{{ $order->currency }} {{ number_format($order->grand_total_amount, 2) }}</td>
                                <td class="p-4 select-none">
                                    <span class="px-2 py-0.5 rounded-md font-mono text-[9px] uppercase font-bold border tracking-tight
                                        {{ $order->order_status === 'Pending' ? 'bg-amber-50 text-amber-700 border-amber-200' : '' }}
                                        {{ $order->order_status === 'Invoice' ? 'bg-blue-50 text-blue-700 border-blue-200' : '' }}
                                        {{ $order->order_status === 'Completed Order' ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : '' }}
                                        {{ !in_array($order->order_status, ['Pending', 'Invoice', 'Completed Order']) ? 'bg-neutral-100 text-neutral-700 border-neutral-300' : '' }}
                                    ">
                                        {{ $order->order_status }}
                                    </span>
                                </td>
                                <td class="p-4 text-right select-none">
                                    <a href="{{ route('supplier.orders.tracker', ['orderId' => $order->id]) }}" wire:navigate class="inline-block bg-neutral-100 hover:bg-primary shadow-inner px-3 py-1 border rounded-lg font-sans font-bold text-[10px] text-neutral-700 hover:text-white transition-colors">
                                        Track Audit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr class="select-none">
                                <td colspan="5" class="p-12 font-medium text-on-surface-variant/50 text-center italic">
                                    No administrative purchase or procurement orders listed under your supplier entity profile yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-6 lg:col-span-1 select-none">

            <div class="space-y-4 bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/50">
                <h4 class="flex items-center gap-1 pb-2 border-b font-bold text-[11px] text-primary uppercase tracking-wider">
                    <span class="text-[16px] material-symbols-outlined">bolt</span> Quick Workspace Links
                </h4>

                <div class="flex flex-col gap-2 font-bold text-xs">
                    <a href="{{ route('supplier.orders') }}" wire:navigate class="group flex justify-between items-center bg-neutral-50 hover:bg-primary/5 p-3 border rounded-xl w-full text-neutral-700 hover:text-primary transition-all">
                        <span class="flex items-center gap-2">
                            <span class="text-[18px] text-neutral-400 group-hover:text-primary material-symbols-outlined">assignment_turned_in</span>
                            <span>Fulfill Admin Orders</span>
                        </span>
                        <span class="text-[14px] text-neutral-300 transition-transform group-hover:translate-x-0.5 material-symbols-outlined">arrow_forward_ios</span>
                    </a>

                    <a href="#" onclick="alert('Wholesale Product Catalogue asset manager profile interface upcoming configuration node!')" class="group flex justify-between items-center bg-neutral-50 hover:bg-primary/5 p-3 border rounded-xl w-full text-neutral-700 hover:text-primary transition-all">
                        <span class="flex items-center gap-2">
                            <span class="text-[18px] text-neutral-400 group-hover:text-primary material-symbols-outlined">storefront</span>
                            <span>My Catalog Items</span>
                        </span>
                        <span class="text-[14px] text-neutral-300 transition-transform group-hover:translate-x-0.5 material-symbols-outlined">arrow_forward_ios</span>
                    </a>
                </div>
            </div>

            <div class="bg-gradient-to-br from-primary/5 to-primary/10 p-6 border border-primary/20 rounded-[2rem] font-medium text-primary text-xs leading-relaxed">
                <span class="block flex items-center gap-0.5 mb-1 font-bold text-[10px] text-primary/70 uppercase tracking-wider">
                    <span class="text-[14px] material-symbols-outlined">gavel</span> System Guard Guideline
                </span>
                Please remember to upload official proforma billing invoices immediately upon checking new orders. This allows the back-office compliance and operations financial desk to wire payment settlement slips without delay.
            </div>

        </div>

    </div>

</div>
