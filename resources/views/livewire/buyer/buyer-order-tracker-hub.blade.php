<div class="flex-1 mx-auto my-2 p-gutter w-full max-w-[1440px]">

    <div class="flex sm:flex-row flex-col justify-between sm:items-center gap-4 mb-6 pb-4 border-b border-outline-variant/30 select-none">
        <div>
            <div class="flex items-center gap-1 mb-1 font-semibold text-on-surface-variant text-xs">
                <a href="{{ route('buyer.order') }}" wire:navigate class="hover:text-primary hover:underline">Quotations History</a>
                <span class="text-[14px] material-symbols-outlined">chevron_right</span>
                <span class="font-bold text-primary">Negotiation Track Panel</span>
            </div>
            <h2 class="font-headline-lg font-bold text-headline-lg text-primary text-2xl tracking-tight">Communication Log Desk</h2>
            <p class="mt-0.5 font-body-sm text-on-surface-variant text-sm">Review real-time counter pricing updates, flag custom field parameters, and coordinate details with platform operations.</p>
        </div>
        <div class="bg-surface-container shadow-inner px-4 py-2 border rounded-xl h-fit font-mono font-bold text-primary text-xs">
            Ticket Reference: {{ $order->order_ref_number }}
        </div>
    </div>

    @if(session()->has('success'))
        <div class="flex items-center gap-2 bg-emerald-50 mb-6 p-4 border border-emerald-200 rounded-xl font-semibold text-emerald-800 text-xs animate-fadeIn select-none">
            <span class="text-[18px] material-symbols-outlined">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="items-start gap-8 grid grid-cols-1 lg:grid-cols-3">

        <div class="space-y-4 lg:col-span-1 bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/50 text-xs select-none">
            <h3 class="flex items-center gap-1 pb-2 border-b font-bold text-[11px] text-primary uppercase tracking-wider">
                <span class="text-[16px] material-symbols-outlined">info</span> Linked RFQ Summary Details
            </h3>

            <div class="space-y-3 font-semibold text-on-surface-variant">
                <div>
                    <span class="block text-outline font-bold text-[10px] uppercase">Target Region Destination</span>
                    <span class="block mt-0.5 font-medium text-primary">{{ $order->destination_country }} (Incoterm: {{ $order->incoterms_preferred ?? 'FOB' }})</span>
                </div>
                <div>
                    <span class="block text-outline font-bold text-[10px] uppercase">Consolidated Valuation</span>
                    <strong class="block mt-0.5 font-mono text-emerald-800 text-sm">{{ $order->quotation_currency }} {{ number_format($order->grand_total_price, 2) }}</strong>
                </div>
                <div>
                    <span class="block text-outline font-bold text-[10px] uppercase">Global Status Flag</span>
                    <span class="inline-block bg-surface-container mt-1 px-2 py-0.5 border rounded-md font-mono font-bold text-[10px] text-primary">
                        {{ $order->order_progress }}
                    </span>
                </div>
            </div>

            <div class="pt-3 border-background border-t border-dashed">
                <span class="block mb-2 text-outline font-bold text-[10px] uppercase">Itemized Lines ({{ count($order->quotation_items ?? []) }})</span>
                <div class="space-y-2 pr-1 max-h-48 overflow-y-auto hide-scrollbar">
                    @foreach($order->quotation_items ?? [] as $subItem)
                        <div class="flex justify-between items-center bg-background/60 p-2.5 border rounded-xl text-[11px]">
                            <span class="max-w-[140px] font-bold text-primary truncate">{{ $subItem['product_name'] }}</span>
                            <span class="font-mono font-bold text-on-surface-variant">{{ number_format($subItem['order_quantity']) }} pcs</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-4 lg:col-span-2">

            <div class="flex flex-col space-y-4 bg-dots-pattern bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/40 h-[460px] overflow-y-auto hide-scrollbar">
                @forelse($messages as $msg)
                    @php
                        // Determine identity node structure context to toggle alignment directions rules classes
                        $isAdminMessage = !is_null($msg->user_id);
                    @endphp

                    <div class="flex flex-col {{ $isAdminMessage ? 'items-start' : 'items-end' }} w-full animate-fadeIn">

                        <div class="flex items-center gap-1.5 mb-1 px-2 font-sans font-bold text-[10px] text-on-surface-variant/70 uppercase tracking-wide select-none">
                            <span>{{ $isAdminMessage ? ($msg->administrator->name ?? 'Admin Manager Operations') : 'Me (Buyer Profile)' }}</span>
                            <span class="opacity-60 text-outline text-[6px]">•</span>
                            <span class="text-outline font-mono font-medium lowercase">{{ $msg->created_at->diffForHumans() }}</span>
                        </div>

                        <div class="max-w-[85%] rounded-[1.5rem] px-5 py-3 text-xs leading-relaxed font-medium shadow-sm border
                            {{ $isAdminMessage
                                ? 'bg-surface-container text-primary rounded-tl-sm border-outline-variant/30'
                                : 'bg-primary text-white rounded-tr-sm border-primary/10' }}">

                            <div class="flex items-center gap-1 opacity-80 mb-1.5 pb-0.5 border-b font-mono font-bold text-[9px] uppercase tracking-wider select-none">
                                <span class="text-[12px] material-symbols-outlined">label_important</span>
                                Subject: {{ $msg->subject }}
                            </div>

                            <p class="font-sans text-xs whitespace-pre-line">{{ $msg->message_content }}</p>

                            @if($isAdminMessage && !empty($msg->flagged_fields_or_docs))
                                <div class="mt-3 pt-2 border-primary/10 border-t select-none">
                                    <span class="block flex items-center gap-0.5 mb-1 font-bold text-[9px] text-red-600 uppercase tracking-wider">
                                        <span class="text-[13px] material-symbols-outlined">warning</span> Flagged Specifications Adjustments Action Items Required:
                                    </span>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($msg->flagged_fields_or_docs as $flagKey)
                                            <span class="bg-red-50 px-2 py-0.5 border border-red-200/40 rounded font-mono font-bold text-[9px] text-red-700 uppercase tracking-wide">
                                                {{ str_replace('_', ' ', $flagKey) }}
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
                        <p class="font-bold text-primary text-xs not-italic">Secure Stream Initialized</p>
                        <p class="mx-auto mt-0.5 max-w-xs text-[11px]">No chat negotiation tracker posts generated yet. Post a question below to alert the operations review desk.</p>
                    </div>
                @endforelse
            </div>

            <div class="space-y-4 bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/40">
                <div class="gap-4 grid grid-cols-1 sm:grid-cols-3 font-medium text-on-surface-variant text-xs">
                    <div class="space-y-1 sm:col-span-1 select-none">
                        <label class="block pl-0.5 font-bold text-[11px]">Topic Context Scope</label>
                        <select wire:model="messageSubject" class="bg-surface-container-low focus:bg-white px-3 py-2 border rounded-xl outline-none w-full font-bold text-primary">
                            <option value="Clarification Request">General Inquiry / Clarification</option>
                            <option value="Pricing Negotiation">Counter Pricing Proposal</option>
                            <option value="Logistics Revision">Freight Drop Adjustment</option>
                            <option value="Document Update">Document Compliance Re-upload</option>
                        </select>
                    </div>
                    <div class="space-y-1 sm:col-span-2">
                        <label class="block pl-0.5 font-bold text-[11px]">Message Body Content *</label>
                        <div class="relative">
                            <textarea wire:model.defer="replyMessage" rows="3" required class="bg-surface-container-low focus:bg-white py-3 pr-16 pl-4 border rounded-xl outline-none focus:ring-1 focus:ring-primary w-full font-sans font-medium text-xs leading-relaxed" placeholder="Type your response message data block detail to the back-office admin auditing team here..."></textarea>

                            <button type="button" wire:click="sendBuyerMessage" wire:loading.attr="disabled" class="right-3 bottom-3 absolute flex justify-center items-center bg-primary hover:bg-primary/95 shadow rounded-xl w-10 h-10 text-white active:scale-95 transition-transform cursor-pointer">
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
