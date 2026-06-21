<div class="flex-1 mx-auto my-2 p-gutter w-full max-w-[1440px]">

    <div
        class="flex md:flex-row flex-col justify-between md:items-center gap-4 mb-8 pb-6 border-b border-outline-variant/30">
        <div>
            <div class="flex items-center gap-1.5 mb-1 font-semibold text-on-surface-variant text-xs select-none">
                <a href="{{ route('admin.buyers.manage') }}" wire:navigate
                    class="hover:text-primary hover:underline">Buyers Directory</a>
                <span class="text-[14px] material-symbols-outlined">chevron_right</span>
                <span class="font-bold text-primary">{{ $buyer->company_name }}</span>
            </div>
            <h2 class="font-headline-lg font-bold text-headline-lg text-primary text-2xl tracking-tight">Buyer Audit
                Ledger & Notes</h2>
            <p class="mt-0.5 font-body-sm text-on-surface-variant text-sm">Log onboarding action requirements, flag
                invalid documents, or manage internal-only reviews for reference index <strong
                    class="font-mono text-primary">{{ $buyer->buyer_ref_number }}</strong></p>
        </div>

        <a href="{{ route('admin.buyers.manage') }}" wire:navigate
            class="flex items-center gap-1.5 bg-surface-container-high hover:bg-surface-container-highest px-4 py-2.5 rounded-xl w-fit h-fit font-label-md font-bold text-on-surface-variant text-xs transition-all cursor-pointer select-none">
            <span class="text-[18px] material-symbols-outlined">arrow_back</span> Back to Directory
        </a>
    </div>

    @if(session()->has('success'))
        <div
            class="flex items-center gap-2 bg-emerald-50 mb-6 p-4 border border-emerald-200 rounded-xl font-semibold text-emerald-800 text-xs animate-fadeIn select-none">
            <span class="text-[18px] material-symbols-outlined">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="items-start gap-8 grid grid-cols-1 lg:grid-cols-3">

        <div class="space-y-5 lg:col-span-1 bg-white shadow-sm p-6 border rounded-[2rem] border-outline-variant/40">
            <h3
                class="flex items-center gap-2 pb-2.5 border-b font-bold text-primary text-sm uppercase tracking-wide select-none">
                <span class="material-symbols-outlined">note_add</span> Append Timeline Note
            </h3>

            <form wire:submit.prevent="logTrackerNote" class="space-y-4 text-xs">

                <div class="space-y-1.5">
                    <label class="block pl-0.5 font-bold text-on-surface-variant">Interaction Subject Context *</label>
                    <select wire:model="subject"
                        class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-medium text-xs">
                        <option value="General Note">General Note Log</option>
                        <option value="Document Rejection">Document Rejection Action</option>
                        <option value="Clarification Request">Clarification Request Message</option>
                        <option value="System Update">System Update Record</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="block pl-0.5 font-bold text-on-surface-variant">Resolution Process Level Status
                        *</label>
                    <select wire:model="resolution_status"
                        class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-medium text-xs">
                        <option value="Info Only">Info Only (No Response Needed)</option>
                        <option value="Pending Response">Pending Response Required From Buyer</option>
                        <option value="Resolved">Resolved / Closed Entry</option>
                    </select>
                </div>

                <div class="space-y-2 bg-surface-container-low/50 p-4 border rounded-xl border-outline-variant/40"
                    x-data="{ openFlags: false }">
                    <button type="button" @click="openFlags = !openFlags"
                        class="flex justify-between items-center w-full font-bold text-on-surface-variant cursor-pointer select-none">
                        <span>Flag Defective Documents (Optional)</span>
                        <span class="text-[16px] material-symbols-outlined"
                            x-text="openFlags ? 'expand_less' : 'expand_more'">expand_more</span>
                    </button>

                    <div x-show="openFlags" x-cloak class="space-y-2 mt-2 pt-2 border-t border-dashed animate-fadeIn">
                        @foreach($documentMap as $colName => $lblText)
                            <label class="flex items-center gap-2 cursor-pointer select-none">
                                <input type="checkbox" wire:model="flagged_docs" value="{{ $colName }}"
                                    class="rounded w-3.5 h-3.5 text-primary">
                                <span
                                    class="font-medium text-[11px] text-on-surface-variant hover:text-primary">{{ $lblText }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div
                    class="flex justify-between items-center bg-surface-container-low p-3.5 border rounded-xl select-none">
                    <div class="space-y-0.5 pr-2">
                        <span class="block font-bold text-primary">Internal Admin-Only Note</span>
                        <span class="block text-[10px] text-on-surface-variant/80 leading-tight">True makes this
                            invisible to the client buyer workspace panels.</span>
                    </div>
                    <label class="inline-flex relative items-center cursor-pointer">
                        <input type="checkbox" wire:model="is_internal_only" value="1" class="sr-only peer">
                        <div
                            class="peer after:top-[2px] after:left-[2px] after:absolute after:bg-white peer-checked:bg-primary after:border peer-checked:after:border-white rounded-full after:rounded-full bg-outline-variant after:border-outline-variant peer-focus:outline-none w-9 after:w-4 h-5 after:h-4 after:content-[''] after:transition-all peer-checked:after:translate-x-full">
                        </div>
                    </label>
                </div>

                <div class="space-y-1.5">
                    <label class="block pl-0.5 font-bold text-on-surface-variant">Message Content / Instructions Sheet
                        *</label>
                    <textarea wire:model.defer="message_content" rows="4"
                        class="bg-surface-container-low focus:bg-white px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full text-xs placeholder:italic"
                        placeholder="Provide clear feedback or describe additional verification steps needed..."></textarea>
                    @error('message_content') <span
                        class="block pl-0.5 font-bold text-[10px] text-red-500 animate-fadeIn">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit"
                    class="bg-primary hover:bg-primary/95 shadow-md py-3 rounded-xl w-full font-label-md font-bold text-white text-center active:scale-95 transition-transform cursor-pointer">
                    Commit Action Log Note
                </button>
            </form>
        </div>

        <div class="space-y-4 lg:col-span-2">
            <h3 class="flex items-center gap-1 pl-1 font-bold text-primary text-sm uppercase tracking-wide select-none">
                <span class="text-[20px] material-symbols-outlined">history_toggle_off</span> Audit Timeline Audit
                History Stack
            </h3>

            <div
                class="before:top-2 before:bottom-2 before:left-6 before:absolute relative space-y-4 before:bg-outline-variant/30 before:w-0.5">
                @forelse($trackers as $track)
                    @php $isAdminNote = ($track->subject !== 'Buyer Reply'); @endphp
                    <div wire:key="tracker-card-{{ $track->id }}" class="relative pl-12 animate-fadeIn">

                        <div
                            class="absolute left-3 top-4 w-6 h-6 rounded-full flex items-center justify-center ring-4 ring-background border shadow-inner select-none
                                {{ !$isAdminNote ? 'bg-secondary text-white' : ($track->is_internal_only ? 'bg-amber-600 text-white' : 'bg-primary text-white') }}">
                            <span class="text-[14px] material-symbols-outlined">
                                {{ !$isAdminNote ? 'undo' : ($track->is_internal_only ? 'lock' : 'gavel') }}
                            </span>
                        </div>

                        <div
                            class="relative space-y-3 bg-white shadow-sm p-6 border rounded-[1.5rem] border-outline-variant/50 {{ $track->resolution_status === 'Pending Response' ? 'ring-2 ring-red-500/10 border-red-200' : '' }}">

                            <div
                                class="flex flex-wrap justify-between items-center gap-2 pb-2 border-background border-b select-none">
                                <div class="flex items-center gap-2">
                                    <span class="font-headline-md font-bold text-primary text-sm">
                                        {{ !$isAdminNote ? 'Buyer System Feedback Memo' : $track->subject }}
                                    </span>

                                    <span
                                        class="px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider border
                                            {{ !$isAdminNote ? 'bg-secondary/10 text-secondary border-secondary/20' : ($track->is_internal_only ? 'bg-amber-50 text-amber-800 border-amber-200/50' : 'bg-primary/5 text-primary border-primary/10') }}">
                                        {{ !$isAdminNote ? 'Client Memo' : ($track->is_internal_only ? 'Internal Only' : 'Shared with Buyer') }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-1.5 font-medium text-on-surface-variant/80 text-xs">
                                    <span
                                        class="px-2 py-0.5 rounded text-[10px] font-bold font-mono uppercase tracking-wide shadow-inner
                                            {{ $track->resolution_status === 'Pending Response' ? 'bg-red-50 text-red-700 border border-red-100' : ($track->resolution_status === 'Resolved' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-surface-container text-on-surface-variant') }}">
                                        {{ $track->resolution_status }}
                                    </span>
                                </div>
                            </div>

                            <p class="font-medium text-on-surface-variant text-xs leading-relaxed whitespace-pre-line">
                                {{ $track->message_content }}</p>

                            @if(filled($track->flagged_fields_or_docs))
                                <div class="flex flex-wrap items-center gap-1.5 pt-1.5 text-[10px] select-none">
                                    <span class="flex items-center gap-0.5 font-bold text-red-700 uppercase tracking-wide"><span
                                            class="text-[14px] material-symbols-outlined">flag</span> Action Required:</span>
                                    @foreach($track->flagged_fields_or_docs as $flaggedColumn)
                                        <span
                                            class="bg-red-50 px-2 py-0.5 border border-red-100 rounded font-mono font-bold text-red-800">
                                            {{ $documentMap[$flaggedColumn] ?? $flaggedColumn }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            <div
                                class="flex justify-between items-center pt-2 border-t border-outline-variant/20 font-semibold text-[10px] text-on-surface-variant/70 select-none">
                                <span class="flex items-center gap-1"><span
                                        class="text-[14px] material-symbols-outlined">account_box</span> Origin:
                                    {{ $track->user_id ? (optional($track->user)->name ?? 'Management Desk') : 'Client Dashboard Entry' }}</span>
                                <span class="font-mono">{{ $track->created_at->format('M d, Y - H:i') }}</span>
                            </div>

                        </div>
                    </div>
                @empty
                    <div
                        class="bg-white p-12 border border-dashed rounded-[2rem] font-body-sm text-on-surface-variant text-center italic select-none">
                        <span class="block mb-1 text-outline text-[48px] material-symbols-outlined">history</span>
                        <p class="font-bold text-primary text-sm not-italic">Pristine Tracker History</p>
                        <p class="mx-auto mt-0.5 max-w-xs text-xs">There are no compiled historical verification interaction
                            trace records cataloged for this buyer account profile yet.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
