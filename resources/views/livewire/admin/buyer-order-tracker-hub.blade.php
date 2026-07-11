<div class="flex-1 mx-auto my-2 p-gutter w-full max-w-[1440px]">

    <div class="flex sm:flex-row flex-col justify-between sm:items-center gap-4 mb-6 pb-4 border-b border-outline-variant/30 select-none">
        <div>
            <div class="flex items-center gap-1 mb-1 font-semibold text-on-surface-variant text-xs">
                <span>Management Center</span>
                <span class="text-[14px] material-symbols-outlined">chevron_right</span>
                <span class="font-bold text-primary">Buyer OrderTracker Thread</span>
            </div>
            <h2 class="font-headline-lg font-bold text-headline-lg text-primary text-2xl tracking-tight">Buyer Order Tracker </h2>
            <p class="mt-0.5 font-body-sm text-on-surface-variant text-sm">Coordinate terms, post counter-pricing offers, and flag specific quotation fields requiring buyer adjustment updates.</p>
        </div>
        <div class="bg-surface-container shadow-inner px-4 py-2 border rounded-xl h-fit font-mono font-bold text-primary text-xs">
            Quotation Code: {{ $order->order_ref_number }}
        </div>
    </div>

    @if(session()->has('success'))
        <div class="flex items-center gap-2 bg-emerald-50 mb-6 p-4 border border-emerald-200 rounded-xl font-semibold text-emerald-800 text-xs animate-fadeIn select-none">
            <span class="text-[18px] material-symbols-outlined">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="items-start gap-8 grid grid-cols-1 lg:grid-cols-3">

        <div class="space-y-6 lg:col-span-1 text-xs">
            <div class="space-y-4 bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/50">
                <h3 class="flex items-center gap-1 pb-2 border-b font-bold text-[11px] text-primary uppercase tracking-wider select-none">
                    <span class="text-[16px] material-symbols-outlined">account_circle</span> Client Company Context
                </h3>
                <div class="space-y-2.5 font-semibold text-on-surface-variant">
                    <div>
                        <span class="block text-outline font-bold text-[10px] uppercase select-none">Corporate Buyer Account</span>
                        <span class="block mt-0.5 font-bold text-primary text-sm">{{ $order->buyer->company_name ?? 'Corporate Entity' }}</span>
                    </div>
                    <div>
                        <span class="block text-outline font-bold text-[10px] uppercase select-none">Grand Sourcing Pricing Total</span>
                        <strong class="block font-mono text-emerald-800 text-base select-all">{{ $order->quotation_currency }} {{ number_format($order->grand_total_price, 2) }}</strong>
                    </div>
                    <div>
                        <span class="block text-outline font-bold text-[10px] uppercase select-none">Logistical Destination Matrix</span>
                        <span class="block mt-0.5 font-medium text-primary">{{ $order->destination_country }} via {{ $order->preferred_shipping_method }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/50 select-none">
                <span class="block mb-3 text-outline font-bold text-[10px] uppercase">Itemized Submissions Manifest ({{ count($order->quotation_items ?? []) }})</span>
                <div class="space-y-2 pr-1 max-h-56 overflow-y-auto hide-scrollbar">
                    @foreach($order->quotation_items ?? [] as $subItem)
                        <div class="flex justify-between items-center bg-background p-2.5 border rounded-xl border-outline-variant/30 text-[11px]">
                            <div class="max-w-[150px] truncate">
                                <span class="block font-bold text-primary truncate">{{ $subItem['product_name'] }}</span>
                                <span class="block mt-0.5 font-mono text-[10px] text-on-surface-variant">Rate: {{ $order->quotation_currency }}{{ number_format($subItem['quoted_price_per_unit'], 2) }}</span>
                            </div>
                            <span class="bg-white shadow-sm px-2 py-0.5 border rounded-md font-mono font-bold text-[10px] text-primary">{{ number_format($subItem['order_quantity']) }} units</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-4 lg:col-span-2">

            <div class="flex flex-col space-y-4 bg-dots-pattern bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/40 h-[460px] overflow-y-auto hide-scrollbar">
                @forelse($messages as $msg)
                    @php
                        // Identify message origin parameters to align components orientations properly
                        $isAdminMsg = !is_null($msg->user_id);
                    @endphp

                    <div class="flex flex-col {{ $isAdminMsg ? 'items-end' : 'items-start' }} w-full anonymity_wrap animate-fadeIn">

                        <div class="flex items-center gap-1.5 mb-1 px-2 font-sans font-bold text-[10px] text-on-surface-variant/70 uppercase tracking-wide select-none">
                            <span>{{ $isAdminMsg ? 'Me (Back-Office Team)' : ($order->buyer->company_name ?? 'Client Account Buyer') }}</span>
                            <span class="opacity-60 text-outline text-[6px]">•</span>
                            <span class="text-outline font-mono font-medium lowercase">{{ $msg->created_at->diffForHumans() }}</span>
                        </div>

                        <div class="max-w-[85%] rounded-[1.5rem] px-5 py-3 text-xs leading-relaxed font-medium shadow-sm border
                            {{ $isAdminMsg
                                ? 'bg-primary text-white rounded-tr-sm border-primary/10'
                                : 'bg-surface-container text-primary rounded-tl-sm border-outline-variant/30' }}">

                            <div class="flex items-center gap-1 opacity-80 mb-1.5 pb-0.5 border-b font-mono font-bold text-[9px] uppercase tracking-wider select-none">
                                <span class="text-[12px] material-symbols-outlined">label_important</span>
                                Subject Topic: {{ $msg->subject }}
                            </div>

                            <p class="font-sans text-xs whitespace-pre-line">{{ $msg->message_content }}</p>

                            @if(!empty($msg->flagged_fields_or_docs))
                                <div class="mt-3 pt-2 border-white/10 border-t select-none">
                                    <span class="block flex items-center gap-0.5 mb-1 font-bold text-[9px] text-red-100 uppercase tracking-wider">
                                        <span class="text-[13px] material-symbols-outlined">warning</span> Targeted Compliance Invalidation Warning Flags Appended:
                                    </span>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($msg->flagged_fields_or_docs as $flagElement)
                                            <span class="bg-red-900/40 px-2 py-0.5 border border-red-400/20 rounded font-mono font-bold text-[9px] text-red-100 uppercase tracking-wide">
                                                {{ str_replace('_', ' ', $flagElement) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>
                @empty
                    <div class="flex flex-col flex-1 justify-center items-center text-on-surface-variant/60 text-center italic select-none">
                        <span class="block opacity-40 mb-1 text-outline text-[48px] material-symbols-outlined">forum</span>
                        <p class="font-bold text-primary text-xs not-italic">Dialogue Timeline Clean</p>
                        <p class="mx-auto mt-0.5 max-w-xs text-[11px]">There are no operational entries logged against this tracking ticket channel registry workspace grid.</p>
                    </div>
                @endforelse
            </div>

            <div class="space-y-4 bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/40">
                <div class="gap-6 grid grid-cols-1 sm:grid-cols-3 font-medium text-on-surface-variant text-xs">

                    <div class="space-y-4 sm:col-span-1 select-none">
                        <div class="space-y-1">
                            <label class="block pl-0.5 font-bold text-[11px]">Topic Scope Context</label>
                            <select wire:model="messageSubject" class="bg-surface-container-low focus:bg-white px-3 py-2 border rounded-xl outline-none w-full font-bold text-primary text-xs">
                                <option value="Payment Request">Payment Request</option>
                                <option value="Clarification Request">Information Request</option>
                                <option value="Pricing Negotiation">Counter Pricing Offer</option>
                                <option value="Logistics Revision">Freight Term Adjustments</option>
                                <option value="Document Update">Document Rejection Notice</option>
                                {{-- <option value="Document Update">Document Rejection Notice</option> --}}
                            </select>
                        </div>

                        <div class="space-y-1.5 bg-surface-container-low p-3.5 border border-dashed rounded-xl">
                            <span class="block flex items-center gap-0.5 mb-1 font-bold text-[10px] text-primary uppercase tracking-wider">
                                <span class="text-[13px] material-symbols-outlined">flag</span> Flag Invalidation Errors
                            </span>
                            <div class="space-y-1 text-[11px]">
                                <label class="flex items-center gap-2 hover:text-primary cursor-pointer"><input type="checkbox" value="item_quantities" wire:model="flaggedFields" class="rounded focus:ring-0 text-primary"> <span>Order Quantities</span></label>
                                <label class="flex items-center gap-2 hover:text-primary cursor-pointer"><input type="checkbox" value="pricing_per_unit" wire:model="flaggedFields" class="rounded focus:ring-0 text-primary"> <span>Target Unit Rate Price</span></label>
                                <label class="flex items-center gap-2 hover:text-primary cursor-pointer"><input type="checkbox" value="freight_incoterms" wire:model="flaggedFields" class="rounded focus:ring-0 text-primary"> <span>Incoterms/Shipping</span></label>
                                <label class="flex items-center gap-2 hover:text-primary cursor-pointer"><input type="checkbox" value="compliance_documents" wire:model="flaggedFields" class="rounded focus:ring-0 text-primary"> <span>Proof Files Documents</span></label>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-1 sm:col-span-2">
                        <label class="block pl-0.5 font-bold text-[11px]">Audit Message Response Content *</label>
                        <div class="relative">
                            <textarea wire:model.defer="replyMessage" rows="6" required class="bg-surface-container-low focus:bg-white py-3 pr-16 pl-4 border rounded-xl outline-none focus:ring-1 focus:ring-primary w-full font-sans font-medium text-xs leading-relaxed" placeholder="Type your negotiation or critique comments update notes packet directly to the customer client console layout panel..."></textarea>

                            <button type="button" wire:click="sendAdminMessage" wire:loading.attr="disabled" class="right-4 bottom-4 absolute flex justify-center items-center bg-primary hover:bg-primary/95 shadow rounded-xl w-10 h-10 text-white active:scale-95 transition-transform cursor-pointer">
                                <span wire:loading.remove class="text-[18px] material-symbols-outlined">send</span>
                                <span wire:loading class="inline-block border-2 border-white border-t-transparent rounded-full w-3.5 h-3.5 animate-spin"></span>
                            </button>
                        </div>
                        @error('replyMessage') <span class="block mt-0.5 pl-0.5 font-bold text-[10px] text-red-500 animate-fadeIn">{{ $message }}</span> @enderror
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>
