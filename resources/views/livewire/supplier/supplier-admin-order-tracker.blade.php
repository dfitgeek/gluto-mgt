<div class="flex-1 mx-auto my-2 p-gutter w-full max-w-[1440px]">

    <div class="flex sm:flex-row flex-col justify-between sm:items-center gap-4 mb-6 pb-4 border-b border-outline-variant/30 select-none">
        <div>
            <div class="flex items-center gap-1 mb-1 font-semibold text-on-surface-variant text-xs">
                <span>Vendor Hub Console</span>
                <span class="text-[14px] material-symbols-outlined">chevron_right</span>
                <span class="font-bold text-primary">Dialogue Thread Tracker</span>
            </div>
            <h2 class="font-headline-lg font-bold text-headline-lg text-primary text-2xl tracking-tight">Audit Negotiation Hub</h2>
            <p class="mt-0.5 font-body-sm text-on-surface-variant text-sm">Review administration feedback logs, resolve flagged compliance issues, and confirm wholesale term updates.</p>
        </div>
        <div class="bg-surface-container shadow-inner px-4 py-2 border rounded-xl h-fit font-mono font-bold text-primary text-xs">
            PO Voucher Number: {{ $order->purchase_order_number }}
        </div>
    </div>

    @if(session()->has('success'))
        <div class="flex items-center gap-2 bg-emerald-50 mb-6 p-4 border border-emerald-200 rounded-xl font-semibold text-emerald-800 text-xs animate-fadeIn select-none">
            <span class="text-[18px] material-symbols-outlined">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="items-start gap-8 grid grid-cols-1 lg:grid-cols-3">
        
        <div class="space-y-6 lg:col-span-1 text-xs select-none">
            <div class="space-y-4 bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/50">
                <h3 class="flex items-center gap-1 pb-2 border-b font-bold text-[11px] text-primary uppercase tracking-wider">
                    <span class="text-[16px] material-symbols-outlined">assignment</span> Procurement Details Summary
                </h3>
                <div class="space-y-3 font-semibold text-on-surface-variant">
                    <div>
                        <span class="block text-outline font-bold text-[10px] uppercase">Total Contract Valuation</span>
                        <strong class="block mt-0.5 font-mono text-emerald-800 text-base">{{ $order->currency }} {{ number_format($order->grand_total_amount, 2) }}</strong>
                    </div>
                    <div>
                        <span class="block text-outline font-bold text-[10px] uppercase">Target Delivery Drop Endpoint</span>
                        <span class="block mt-1 font-medium text-primary leading-relaxed">{{ $order->destination_warehouse_address }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/50">
                <span class="block mb-3 text-outline font-bold text-[10px] uppercase">Itemized Contract Lines Manifest ({{ count($order->order_items ?? []) }})</span>
                <div class="space-y-2 pr-1 max-h-56 overflow-y-auto hide-scrollbar">
                    @foreach($order->order_items ?? [] as $lineItem)
                        <div class="flex justify-between items-center bg-background p-2.5 border rounded-xl border-outline-variant/30 text-[11px]">
                            <div class="max-w-[150px] truncate">
                                <span class="block font-bold text-primary truncate">{{ $lineItem['product_name'] }}</span>
                                <span class="block mt-0.5 font-mono text-[10px] text-on-surface-variant">Rate: {{ $order->currency }}{{ number_format($lineItem['negotiated_price_per_unit'], 2) }}</span>
                            </div>
                            <span class="bg-white shadow-sm px-2 py-0.5 border rounded-md font-mono font-bold text-[10px] text-primary">{{ number_format($lineItem['order_quantity']) }} units</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-4 lg:col-span-2">
            
            <div class="flex flex-col space-y-4 bg-dots-pattern bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/40 h-[460px] overflow-y-auto hide-scrollbar">
                @forelse($messages as $msg)
                    @php
                        // True if authored by supplier workspace session, False if authored by administrative office team
                        $isMyMsg = !is_null($msg->supplier_profile_id);
                    @endphp

                    <div class="flex flex-col {{ $isMyMsg ? 'items-end' : 'items-start' }} w-full animate-fadeIn">
                        
                        <div class="flex items-center gap-1.5 mb-1 px-2 font-sans font-bold text-[10px] text-on-surface-variant/70 uppercase tracking-wide select-none">
                            <span>{{ $isMyMsg ? 'Me (Wholesale Team)' : 'Operations Admin Team' }}</span>
                            <span class="opacity-60 text-outline text-[6px]">•</span>
                            <span class="text-outline font-mono font-medium lowercase">{{ $msg->created_at->diffForHumans() }}</span>
                        </div>

                        <div class="max-w-[85%] rounded-[1.5rem] px-5 py-3 text-xs leading-relaxed font-medium shadow-sm border 
                            {{ $isMyMsg 
                                ? 'bg-primary text-white rounded-tr-sm border-primary/10' 
                                : 'bg-surface-container text-primary rounded-tl-sm border-outline-variant/30' }}">
                            
                            <div class="flex items-center gap-1 opacity-80 mb-1.5 pb-0.5 border-b font-mono font-bold text-[9px] uppercase tracking-wider select-none">
                                <span class="text-[12px] material-symbols-outlined">label_important</span> 
                                Subject Topic: {{ $msg->subject }}
                            </div>

                            <p class="font-sans text-xs whitespace-pre-line">{{ $msg->message_content }}</p>

                            @php
                                // COMPREHENSIVE SCAN REGISTER MAP: Checks every possible dynamic custom document column inside row logs
                                $docFields = [
                                    'product_manufacturing_certifications',
                                    'returns_warranty_policy',
                                    'file_sales_contract',
                                    'file_commercial_invoice',
                                    'file_packing_list',
                                    'file_certificate_of_origin',
                                    'file_test_analysis_report',
                                    'supplier_invoice',
                                    'proforma_invoice',
                                    'file_bill_of_lading',
                                    'file_insurance_certificate',
                                    'file_product_spec_sheet',
                                    'file_others'
                                ];
                                $attachedDoc = null;
                                $attachedField = '';
                                foreach ($docFields as $f) {
                                    if (!empty($msg->{$f}) && isset($msg->{$f}['file_path'])) {
                                        $attachedDoc = $msg->{$f};
                                        $attachedField = $f;
                                        break;
                                    }
                                }
                            @endphp

                            @if($attachedDoc)
                                <div class="flex justify-between items-center gap-3 bg-white shadow-sm mt-2.5 p-3 border border-neutral-200 rounded-xl text-neutral-800 text-xs animate-fadeIn">
                                    <div class="flex items-center gap-2 truncate">
                                        <span class="flex-shrink-0 text-[20px] text-primary material-symbols-outlined">article</span>
                                        <div class="truncate">
                                            <span class="block font-bold text-[9px] text-primary uppercase leading-none tracking-wide">
                                                {{ ucwords(str_replace(['file_', '_'], ' ', $attachedField)) }}
                                            </span>
                                            <span class="block mt-1 font-mono text-[10px] text-neutral-500 truncate">{{ $attachedDoc['file_name'] }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ asset('storage/' . $attachedDoc['file_path']) }}" target="_blank" 
                                       class="flex items-center gap-0.5 bg-primary hover:bg-primary/95 shadow-sm px-3 py-1.5 rounded-lg font-bold text-[10px] text-white whitespace-nowrap active:scale-95 transition-transform cursor-pointer">
                                        Open File <span class="text-[13px] material-symbols-outlined">open_in_new</span>
                                    </a>
                                </div>
                            @endif

                            @if(!empty($msg->flagged_fields_or_docs))
                                <div class="mt-3 pt-2 border-t {{ $isMyMsg ? 'border-white/10' : 'border-primary/10' }} select-none">
                                    <span class="block font-bold text-[9px] uppercase tracking-wider mb-1 flex items-center gap-0.5 {{ $isMyMsg ? 'text-red-100' : 'text-red-600' }}">
                                        <span class="text-[13px] material-symbols-outlined">warning</span> Action Flags Appended:
                                    </span>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($msg->flagged_fields_or_docs as $flagNode)
                                            <span class="text-[9px] px-2 py-0.5 rounded font-mono font-bold uppercase tracking-wide border 
                                                {{ $isMyMsg 
                                                    ? 'bg-red-900/40 text-red-100 border-red-400/20' 
                                                    : 'bg-red-50 text-red-700 border-red-200/60' }}">
                                                {{ str_replace('_', ' ', $flagNode) }}
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
                        <p class="font-bold text-primary text-xs not-italic">Discussion Timeline Clean</p>
                        <p class="mx-auto mt-0.5 max-w-xs text-[11px]">There are no operational entries logged against this message board channel thread layout.</p>
                    </div>
                @endforelse
            </div>

            <div class="space-y-4 bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/40">
                <div class="gap-6 grid grid-cols-1 md:grid-cols-3 font-medium text-on-surface-variant text-xs">
                    
                    <div class="space-y-4 md:col-span-1">
                        <div class="space-y-1 select-none">
                            <label class="block pl-0.5 font-bold text-[11px]">Response Context</label>
                            <select wire:model="messageSubject" class="bg-surface-container-low focus:bg-white px-3 py-2 border rounded-xl outline-none w-full font-bold text-primary text-xs">
                                <option value="Document Update Submission">Document Provision</option>
                                <option value="Clarification Response">Information Provision</option>
                                <option value="Pricing Negotiation Counter">Negotiation Response</option>
                                <option value="Freight Update Info">Freight Update Dispatch</option>
                            </select>
                        </div>

                        <div class="space-y-3 bg-surface-container-low p-4 border border-dashed rounded-xl">
                            <span class="block flex items-center gap-0.5 mb-1 font-bold text-[10px] text-primary uppercase tracking-wider select-none">
                                <span class="text-[14px] material-symbols-outlined">cloud_upload</span> Upload Vault File
                            </span>
                            
                            <div class="space-y-2">
                                <div class="space-y-1 select-none">
                                    <label class="block font-semibold text-[10px] text-neutral-500">Target Type Slot</label>
                                    <select wire:model="targetFileField" class="bg-white px-2 py-1 border rounded-lg outline-none w-full font-bold text-[11px] text-neutral-800">
                                        <option value="file_commercial_invoice">Commercial Invoice</option>
                                        <option value="file_packing_list">Packing List</option>
                                        <option value="file_certificate_of_origin">Certificate of Origin</option>
                                        <option value="file_bill_of_lading">Bill of Lading</option>
                                        <option value="file_product_spec_sheet">Product Spec Sheet</option>
                                        <option value="product_manufacturing_certifications">Manufacturing Certs</option>
                                        <option value="file_others">Other Supporting Files</option>
                                    </select>
                                </div>

                                <div class="space-y-1">
                                    <label class="block font-semibold text-[10px] text-neutral-500 select-none">Choose File Asset</label>
                                    <input type="file" wire:model="uploadedFile" class="block file:bg-primary/10 file:mr-2 file:px-2.5 file:py-1 file:border-0 file:rounded w-full font-sans file:font-bold text-[10px] file:text-[10px] file:text-primary cursor-pointer">
                                    @error('uploadedFile') <span class="block mt-1 font-bold text-[10px] text-red-500 animate-fadeIn">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-1 md:col-span-2">
                        <label class="block pl-0.5 font-bold text-[11px]">Write Response Message Content *</label>
                        <div class="relative">
                            <textarea wire:model.defer="replyMessage" rows="7" required class="bg-surface-container-low focus:bg-white py-3 pr-16 pl-4 border rounded-xl outline-none focus:ring-1 focus:ring-primary w-full font-sans font-medium text-xs leading-relaxed" placeholder="Type your confirmation details notes directly to the administrative audit team desk..."></textarea>
                            
                            <button type="button" wire:click="sendSupplierReply" wire:loading.attr="disabled" class="right-4 bottom-4 absolute flex justify-center items-center bg-primary hover:bg-primary/95 shadow rounded-xl w-10 h-10 text-white active:scale-95 transition-transform cursor-pointer">
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