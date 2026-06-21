<div class="flex-1 mx-auto my-2 p-gutter w-full max-w-[1440px]">

    <div
        class="flex sm:flex-row flex-col justify-between sm:items-center gap-4 mb-8 pb-4 border-b border-outline-variant/30 select-none">
        <div>
            <h2 class="font-headline-lg font-bold text-headline-lg text-primary text-2xl tracking-tight">Audit Tracking
                Desk</h2>
            <p class="mt-0.5 font-body-sm text-on-surface-variant text-sm">Review account compliance history threads,
                track missing verification items, and submit responses directly to the admin panel.</p>
        </div>
        <div
            class="flex items-center gap-1.5 bg-surface-container-low shadow-inner px-4 py-2 border rounded-xl h-fit font-mono font-bold text-primary text-xs">
            <span class="text-[16px] text-primary material-symbols-outlined">gavel</span> Core Ref:
            {{ auth('buyer')->user()->buyer_ref_number }}
        </div>
    </div>

    <div class="items-start gap-8 grid grid-cols-1 lg:grid-cols-3">

        <div class="space-y-4 lg:col-span-1 bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/40">
            <h3
                class="flex items-center gap-2 pb-2.5 border-b font-bold text-primary text-sm uppercase tracking-wide select-none">
                <span class="material-symbols-outlined">send</span> Send Audit Feedback
            </h3>

            <form wire:submit.prevent="submitReply" class="space-y-4 text-xs">
                <p class="font-medium text-on-surface-variant leading-relaxed">If an account manager has flagged missing
                    or rejected documents, update your records inside your <a
                        wire:navigate
                        class="font-bold text-primary hover:underline">Documents Library</a>, then submit a formal
                    response tracking memo below.</p>

                @if(session()->has('success'))
                    <div
                        class="flex items-center gap-1.5 bg-emerald-50 p-3 border border-emerald-200 rounded-xl font-semibold text-emerald-800 animate-fadeIn select-none">
                        <span class="text-[16px] material-symbols-outlined">check_circle</span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <div class="space-y-1.5">
                    <label class="block pl-0.5 font-bold text-on-surface-variant">Response Message Content *</label>
                    <textarea wire:model.defer="reply_message" rows="5"
                        class="bg-surface-container-low focus:bg-white shadow-inner px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full text-xs leading-relaxed transition-all"
                        placeholder="Type your formal verification response text here..."></textarea>
                    @error('reply_message') <span
                        class="block pl-0.5 font-bold text-[10px] text-red-500 animate-fadeIn">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" wire:loading.attr="disabled"
                    class="flex justify-center items-center gap-1.5 bg-primary hover:bg-primary/95 shadow-md py-3 rounded-xl w-full font-label-md font-bold text-white text-center active:scale-95 transition-transform cursor-pointer select-none">
                    <span wire:loading.remove class="flex items-center gap-1.5">Dispatch Verification Memo <span
                            class="text-[16px] material-symbols-outlined">send</span></span>
                    <span wire:loading class="flex items-center gap-1 animate-pulse"><span
                            class="inline-block border-2 border-white border-t-transparent rounded-full w-3 h-3 animate-spin"></span>
                        Syncing communication ledger...</span>
                </button>
            </form>
        </div>

        <div class="space-y-4 lg:col-span-2">
            <h3 class="flex items-center gap-1 pl-1 font-bold text-primary text-sm uppercase tracking-wide select-none">
                <span class="text-[20px] material-symbols-outlined">forum</span> Active Verification History Logs
            </h3>

            <div
                class="before:top-2 before:bottom-2 before:left-6 before:absolute relative space-y-4 before:bg-outline-variant/30 before:w-0.5">
                @forelse($trackers as $log)
                    @php $isBuyerReply = ($log->subject === 'Buyer Reply'); @endphp

                    <div wire:key="buyer-tracker-node-{{ $log->id }}" class="relative pl-12 animate-fadeIn">

                        <div
                            class="absolute left-3 top-4 w-6 h-6 rounded-full flex items-center justify-center ring-4 ring-background border shadow-inner select-none
                                {{ $isBuyerReply ? 'bg-secondary text-white' : ($log->resolution_status === 'Pending Response' ? 'bg-red-600 text-white' : 'bg-primary text-white') }}">
                            <span class="text-[14px] material-symbols-outlined">
                                {{ $isBuyerReply ? 'undo' : ($log->resolution_status === 'Pending Response' ? 'warning' : 'gavel') }}
                            </span>
                        </div>

                        <div
                            class="bg-white border rounded-[1.5rem] p-5 border-outline-variant/50 shadow-sm space-y-3 relative {{ $log->resolution_status === 'Pending Response' ? 'ring-2 ring-red-500/10 border-red-200 bg-red-50/5' : '' }}">

                            <div class="flex justify-between items-center pb-2 border-background border-b select-none">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="font-bold font-headline-md text-sm {{ $isBuyerReply ? 'text-secondary' : 'text-primary' }}">
                                        {{ $isBuyerReply ? 'My Sourcing Feedback' : $log->subject }}
                                    </span>

                                    @if($log->resolution_status === 'Pending Response')
                                        <span
                                            class="bg-red-50 px-2 py-0.5 border border-red-200 rounded-md font-bold text-[9px] text-red-700 uppercase tracking-wider animate-pulse">
                                            Action Required
                                        </span>
                                    @endif
                                </div>

                                <span
                                    class="px-2 py-0.5 rounded text-[10px] font-mono font-bold uppercase shadow-inner tracking-wide {{ $isBuyerReply ? 'bg-secondary/10 text-secondary' : 'bg-surface-container text-on-surface-variant' }}">
                                    {{ $isBuyerReply ? 'Client Response' : 'Admin Note' }}
                                </span>
                            </div>

                            <p class="font-medium text-on-surface-variant text-xs leading-relaxed whitespace-pre-line">
                                {{ $log->message_content }}</p>

                            @if(filled($log->flagged_fields_or_docs))
                                <div class="space-y-2 mt-2 pt-2 border-background border-t animate-fadeIn select-none">
                                    <span class="block font-bold text-[10px] text-red-700 uppercase tracking-wider">Flagged
                                        records requiring re-upload validation:</span>
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach($log->flagged_fields_or_docs as $invalidColumn)
                                            <span
                                                class="bg-red-50 shadow-sm px-2 py-0.5 border border-red-100 rounded font-mono font-bold text-[10px] text-red-800">
                                                {{ $documentMap[$invalidColumn] ?? $invalidColumn }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div
                                class="flex justify-between items-center pt-2 border-t border-outline-variant/10 font-semibold text-[10px] text-on-surface-variant/60 select-none">
                                <span class="flex items-center gap-0.5"><span
                                        class="text-[14px] material-symbols-outlined">account_circle</span> Sender:
                                    {{ $isBuyerReply ? 'Your Authorized Account' : 'Gluto Onboarding Manager' }}</span>
                                <span class="font-mono">{{ $log->created_at->format('M d, Y - H:i') }}</span>
                            </div>

                        </div>
                    </div>
                @empty
                    <div
                        class="bg-white p-12 border border-dashed rounded-[2rem] font-body-sm text-on-surface-variant text-center italic select-none">
                        <span
                            class="block mb-1 text-outline text-[48px] material-symbols-outlined">history_toggle_off</span>
                        <p class="font-bold text-primary text-sm not-italic">Account Status Clear</p>
                        <p class="mx-auto mt-0.5 max-w-xs text-xs">Your account tracking timeline is empty. There are no
                            outstanding verification action requests listed from the compliance desk.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
