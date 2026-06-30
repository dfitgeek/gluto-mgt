<div class="flex-1 mx-auto my-2 p-gutter w-full max-w-[1440px]" x-data="{ buyerModalOpen: false }">

    <div class="flex sm:flex-row flex-col justify-between sm:items-center gap-4 mb-6 pb-4 border-b border-outline-variant/30 select-none">
        <div>
            <h2 class="font-headline-lg font-bold text-headline-lg text-primary text-2xl">Enterprise Buyers Directory</h2>
            <p class="mt-0.5 font-body-sm text-on-surface-variant text-sm">Audit operational buyer profiles, monitor compliance documentation vaults, and handle user proxy masquerades.</p>
        </div>
        <a href="{{ route('admin.buyers.create') }}" wire:navigate class="flex justify-center items-center gap-2 bg-primary hover:bg-primary/95 shadow-md shadow-primary/10 px-5 py-3 rounded-xl w-full sm:w-auto font-label-md font-bold text-white text-xs transition-all cursor-pointer">
            <span class="text-[18px] material-symbols-outlined">person_add</span> Onboard New Buyer
        </a>
    </div>

    <div class="space-y-4 mb-8 select-none">
        <div class="flex lg:flex-row flex-col justify-between items-center gap-4 bg-white shadow-sm p-4 border rounded-2xl border-outline-variant/60">

            <div class="flex items-center gap-1.5 pb-2 lg:pb-0 w-full lg:w-auto overflow-x-auto hide-scrollbar">
                @foreach(['All' => 'All Buyers', 'Unprocessed Buyer' => 'Unprocessed', 'Verified Buyer' => 'Verified Entities'] as $key => $label)
                    <button type="button" wire:click="$set('statusFilter', '{{ $key }}')"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all relative cursor-pointer whitespace-nowrap flex items-center gap-2 {{ $statusFilter === $key ? 'bg-primary text-white shadow-sm' : 'bg-surface-container-low text-on-surface-variant hover:bg-surface-container-high' }}">
                        <span>{{ $label }}</span>
                        <span class="px-1.5 py-0.5 rounded-md text-[10px] {{ $statusFilter === $key ? 'bg-white/20 text-white' : 'bg-white/80 border text-primary font-mono font-bold' }}">
                            {{ $statusCounts[$key] ?? 0 }}
                        </span>
                    </button>
                @endforeach
            </div>

            <div class="relative w-full lg:w-96">
                <span class="top-1/2 left-4 absolute text-outline text-[20px] -translate-y-1/2 material-symbols-outlined">search</span>
                <input wire:model.live.debounce.250ms="search" type="text"
                    class="bg-surface-container-low focus:bg-white shadow-inner py-2.5 pr-4 pl-11 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-medium text-xs"
                    placeholder="Search company name, reference code, or representative email...">
            </div>
        </div>
    </div>

    @if(session()->has('success'))
        <div class="flex items-center gap-2 bg-emerald-50 mb-6 p-4 border border-emerald-200 rounded-xl font-semibold text-emerald-800 text-xs animate-fadeIn select-none">
            <span class="text-[18px] material-symbols-outlined">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="gap-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @forelse($buyers as $buyer)
            <div wire:key="buyer-card-{{ $buyer->id }}"
                class="group relative flex flex-col justify-between bg-white shadow-sm hover:shadow-md p-6 border rounded-[2rem] border-outline-variant/50 transition-all animate-fadeIn">

                <div>
                    <div class="flex justify-between items-center gap-2 mb-4 select-none">
                        <span class="block font-mono font-bold text-[10px] text-on-surface-variant/70 uppercase tracking-wide">Protocol: {{ $buyer->buyer_ref_number }}</span>

                        <span class="px-2.5 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider border font-label-sm
                            {{ $buyer->status_label === 'Verified Buyer' ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : 'bg-amber-50 text-amber-800 border-amber-200' }}">
                            {{ $buyer->status_label === 'Verified Buyer' ? 'Verified Entity' : 'Unprocessed' }}
                        </span>
                    </div>

                    <div class="flex items-start gap-3.5 mb-4 pb-3 border-background border-b">
                        <div class="flex flex-shrink-0 justify-center items-center bg-surface-container shadow-inner border rounded-2xl w-12 h-12 overflow-hidden select-none">
                            @if($buyer->company_icon_path)
                                <img src="{{ asset('storage/' . $buyer->company_icon_path) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-outline text-[20px] material-symbols-outlined">corporate_fare</span>
                            @endif
                        </div>
                        <div class="space-y-0.5 min-w-0">
                            <h3 class="font-headline-md font-bold text-primary text-base truncate line-clamp-1" title="{{ $buyer->company_name }}">
                                {{ $buyer->company_name }}
                            </h3>
                            <p class="flex items-center gap-1 text-[11px] text-on-surface-variant truncate">
                                <span class="text-outline text-[13px] material-symbols-outlined">public</span>
                                <span>{{ $buyer->country_of_registration }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="space-y-1.5 bg-surface-container-low/60 p-3 border rounded-xl text-on-surface-variant text-xs">
                        <div class="flex items-center gap-1.5 font-semibold text-primary">
                            <span class="text-outline text-[16px] material-symbols-outlined">badge</span>
                            <span class="truncate">{{ $buyer->rep_full_name }}</span>
                        </div>
                        <div class="flex items-center gap-1.5 pl-5 text-[11px] truncate">
                            <span class="text-outline/70 text-[14px] material-symbols-outlined">mail</span>
                            <span>{{ $buyer->rep_email }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-4 border-background border-t w-full select-none">
                    <button type="button" wire:click="openBuyerModal({{ $buyer->id }})"
                        class="flex justify-center items-center gap-1.5 bg-surface-container-high hover:bg-primary/10 py-2.5 rounded-xl w-full font-bold text-primary text-xs transition-colors cursor-pointer">
                        <span class="text-[16px] material-symbols-outlined">person_search</span> Inspect Complete Profile
                    </button>
                </div>

            </div>
        @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3 xl:col-span-4 bg-white p-16 border border-dashed rounded-[2.5rem] text-on-surface-variant text-center italic select-none">
                <span class="block mb-2 text-outline text-[56px] material-symbols-outlined">face</span>
                <p class="font-bold text-primary text-sm not-italic">No Enterprise Buyers Found</p>
                <p class="mx-auto mt-0.5 max-w-sm text-xs">There are no matching corporate buyer entries tracked across your current index database listings parameters filters.</p>
            </div>
        @endforelse
    </div>

    <div x-on:open-buyer-preview-modal.window="buyerModalOpen = true; document.body.classList.add('overflow-hidden')"
         x-on:close-buyer-preview-modal.window="buyerModalOpen = false; document.body.classList.remove('overflow-hidden')"
         x-on:keydown.escape.window="buyerModalOpen = false; document.body.classList.remove('overflow-hidden'); $wire.call('closeBuyerModal')"
         x-show="buyerModalOpen" x-cloak
         class="z-[100] fixed inset-0 flex justify-center items-center bg-black/40 backdrop-blur-sm p-4 sm:p-6 md:p-8"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        @if($selectedBuyer)
            <div @click.outside="buyerModalOpen = false; document.body.classList.remove('overflow-hidden'); $wire.call('closeBuyerModal')"
                 class="flex flex-col bg-white shadow-2xl rounded-[2.5rem] w-full max-w-4xl max-h-[calc(100vh-4rem)] overflow-hidden transform"
                 x-data="{ buyerTab: 'corp_identity' }" x-show="buyerModalOpen"
                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="scale-95 translate-y-4" x-transition:enter-end="scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="scale-100 translate-y-0" x-transition:leave-end="scale-95 translate-y-4">
                
                <div class="flex justify-between items-center bg-primary p-6 text-white select-none">
                    <div class="flex items-center gap-4">
                        <div class="flex flex-shrink-0 justify-center items-center bg-white/10 shadow-inner rounded-2xl w-12 h-12 overflow-hidden">
                            @if($selectedBuyer->company_icon_path)
                                <img src="{{ asset('storage/' . $selectedBuyer->company_icon_path) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-[24px] material-symbols-outlined">corporate_fare</span>
                            @endif
                        </div>
                        <div>
                            <span class="block font-mono font-bold text-[10px] text-white/70 uppercase tracking-wider">Buyer Identifier Track: {{ $selectedBuyer->buyer_ref_number }}</span>
                            <h2 class="max-w-[500px] font-headline-md font-bold text-headline-md text-base md:text-lg truncate">{{ $selectedBuyer->company_name }}</h2>
                        </div>
                    </div>
                    <button type="button" @click="buyerModalOpen = false; document.body.classList.remove('overflow-hidden'); $wire.call('closeBuyerModal')" class="hover:bg-white/10 p-2 rounded-full transition-colors cursor-pointer">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="flex items-center gap-2 bg-surface-container-low px-6 py-2 border-b font-bold text-on-surface-variant text-xs select-none">
                    <button type="button" @click="buyerTab = 'corp_identity'" class="px-4 py-2 rounded-lg transition-colors cursor-pointer" :class="buyerTab === 'corp_identity' ? 'bg-primary text-white shadow-sm' : 'hover:bg-surface-container-high text-on-surface-variant'">Corporate Identity</button>
                    <button type="button" @click="buyerTab = 'vault_attachments'" class="px-4 py-2 rounded-lg transition-colors cursor-pointer" :class="buyerTab === 'vault_attachments' ? 'bg-primary text-white shadow-sm' : 'hover:bg-surface-container-high text-on-surface-variant'">Documentation Attachments</button>
                </div>

                <div class="flex-1 space-y-6 bg-background p-8 overflow-y-auto text-sm hide-scrollbar">

                    <div x-show="buyerTab === 'corp_identity'" class="space-y-6 animate-fadeIn">
                        <div class="gap-6 grid grid-cols-1 md:grid-cols-3 bg-white p-6 border rounded-2xl font-medium text-xs">
                            <div><span class="block mb-0.5 font-bold text-[10px] text-on-surface-variant uppercase tracking-wider">Registration Number</span><span class="block font-mono font-bold text-primary text-sm">{{ $selectedBuyer->company_registration_number ?? 'Not Filled' }}</span></div>
                            <div><span class="block mb-0.5 font-bold text-[10px] text-on-surface-variant uppercase tracking-wider">VAT / Tax ID (TIN)</span><span class="block font-mono font-bold text-primary text-sm">{{ $selectedBuyer->vat_tax_id_number ?? 'Not Provided' }}</span></div>
                            <div><span class="block mb-0.5 font-bold text-[10px] text-on-surface-variant uppercase tracking-wider">Year Corporate Established</span><span class="block font-bold text-primary text-sm">{{ $selectedBuyer->year_established ?? 'Unlisted' }}</span></div>
                            <div class="md:col-span-2"><span class="block mb-0.5 font-bold text-[10px] text-on-surface-variant uppercase tracking-wider">Nature of Sourcing Operation</span><span class="block font-bold text-primary text-sm">{{ $selectedBuyer->nature_of_business ?? 'General Commercial Account' }}</span></div>
                            <div><span class="block mb-0.5 font-bold text-[10px] text-on-surface-variant uppercase tracking-wider">Website Domain URL</span><span class="block font-bold text-secondary text-sm truncate select-all">{{ $selectedBuyer->company_website ?? 'No Site Linked' }}</span></div>
                        </div>

                        @if($selectedBuyer->social_media)
                            <div class="space-y-2 bg-white px-6 py-4 border rounded-2xl select-none">
                                <h4 class="flex items-center gap-1 font-bold text-primary text-xs uppercase tracking-wider"><span class="text-[16px] material-symbols-outlined">share</span> Corporate Social Network Nodes</h4>
                                <div class="flex flex-wrap gap-2.5 font-semibold text-on-surface-variant text-xs">
                                    @foreach($selectedBuyer->social_media as $platform => $handle)
                                        @if(filled($handle))
                                            <div class="flex items-center gap-1.5 bg-surface-container-low px-3 py-1.5 border rounded-xl capitalize">
                                                <span class="bg-primary/40 rounded-full w-1.5 h-1.5"></span>
                                                <span>{{ $platform }}: <strong class="font-mono font-bold text-primary select-all">{{ $handle }}</strong></span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="space-y-4 bg-white p-6 border rounded-[1.5rem]">
                            <h4 class="flex items-center gap-1.5 pb-2 border-b font-bold text-primary text-xs uppercase tracking-wider"><span class="text-[16px] material-symbols-outlined">account_box</span> Authorized Representative Specifications Card</h4>
                            <div class="gap-4 grid grid-cols-1 md:grid-cols-2 font-medium text-xs">
                                <div><span class="block text-on-surface-variant">Full Legal Name:</span> <strong class="block mt-0.5 text-primary text-sm">{{ $selectedBuyer->rep_full_name }}</strong></div>
                                <div><span class="block text-on-surface-variant">Corporate Assignment Position:</span> <strong class="block mt-0.5 text-primary">{{ $selectedBuyer->rep_position }}</strong></div>
                                <div><span class="block text-on-surface-variant">Direct Comms Email Address:</span> <strong class="block mt-0.5 font-mono text-primary select-all">{{ $selectedBuyer->rep_email }}</strong></div>
                                <div><span class="block text-on-surface-variant">Mobile / WhatsApp Coordinates:</span> <strong class="block mt-0.5 font-mono text-primary">{{ $selectedBuyer->rep_mobile_whatsapp }}</strong></div>
                                <div><span class="block text-on-surface-variant">Representative Nationality:</span> <strong class="block mt-0.5 text-primary">{{ $selectedBuyer->rep_nationality ?? 'Unreported' }}</strong></div>
                                <div><span class="block text-on-surface-variant">ID Passport Reference String:</span> <strong class="block mt-0.5 font-mono text-primary">{{ $selectedBuyer->rep_id_passport_number ?? 'Not Indexed' }}</strong></div>
                                <div class="md:col-span-2 pt-2 border-background border-t"><span class="block mb-1 text-on-surface-variant">Official Office Operations Physical Address:</span> <p class="bg-background px-3 py-2 border border-dashed rounded-lg font-medium text-primary text-xs leading-relaxed">{{ $selectedBuyer->office_address ?? 'No physical operating office address cataloged.' }}</p></div>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1 space-y-6" x-show="buyerTab === 'vault_attachments'" x-cloak class="animate-fadeIn">
                        <div class="gap-6 grid grid-cols-1 sm:grid-cols-2">
                            @php
                                $documentationVaultArrayMap = [
                                    'company_reg_doc' => ['lbl' => 'Company Registration Document', 'icn' => 'gavel'],
                                    'id_card'         => ['lbl' => 'Representative ID / Passport', 'icn' => 'badge'],
                                ];
                            @endphp

                            @foreach($documentationVaultArrayMap as $dbField => $meta)
                                @php $fileStackNode = $selectedBuyer->{$dbField} ?? null; @endphp

                                <div class="flex flex-col justify-between bg-white p-5 border rounded-3xl border-outline-variant/60 min-h-[160px] font-semibold text-xs">
                                    <div class="flex items-center gap-2 pb-2 border-background border-b select-none">
                                        <div class="flex flex-shrink-0 justify-center items-center bg-primary/5 rounded-lg w-8 h-8 text-primary">
                                            <span class="text-[18px] material-symbols-outlined">{{ $meta['icn'] }}</span>
                                        </div>
                                        <div>
                                            <span class="block font-bold text-primary leading-tight">{{ $meta['lbl'] }}</span>
                                            <span class="block mt-0.5 font-medium text-[9px] text-on-surface-variant/70">Global Profile Vault</span>
                                        </div>
                                    </div>

                                    <div class="space-y-1.5 my-3 max-h-24 overflow-y-auto hide-scrollbar">
                                        @if(filled($fileStackNode) && is_array($fileStackNode))
                                            @foreach($fileStackNode as $fileIndex => $fileData)
                                                <div class="flex justify-between items-center bg-surface-container-low p-2 border rounded-xl">
                                                    <span class="text-outline max-w-[180px] font-mono text-[11px] truncate">File Version #{{ $fileIndex + 1 }}</span>
                                                    <a href="{{ asset('storage/' . $fileData['file_path']) }}" target="_blank" class="flex flex-shrink-0 justify-center items-center gap-0.5 bg-primary/10 hover:bg-primary px-3 py-1 rounded-xl font-label-sm font-bold text-[10px] text-primary hover:text-white transition-colors">
                                                        View File <span class="text-[12px] material-symbols-outlined">open_in_new</span>
                                                    </a>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="flex items-center gap-1 bg-background p-2 border border-dashed rounded-xl text-[11px] text-on-surface-variant/40 italic select-none">
                                                <span class="text-[15px] material-symbols-outlined">folder_off</span> Empty Document Ledger
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-row flex-col justify-between items-center gap-4 bg-white p-6 border-t border-outline-variant select-none">

                    <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
                        <a href="{{ route('admin.buyers.masquerade', ['id' => $selectedBuyer->id]) }}" 
                            class="flex justify-center items-center gap-1.5 bg-primary hover:bg-primary/95 shadow-sm px-4 py-2.5 rounded-xl font-bold text-white text-xs active:scale-95 transition-transform cursor-pointer">
                             <span class="text-[16px] material-symbols-outlined">login</span> 
                             Sign-In As Buyer proxy
                         </a>

                        <a href="#" class="flex justify-center items-center gap-1.5 bg-surface-container hover:bg-primary/10 px-4 py-2.5 rounded-xl font-bold text-primary text-xs transition-colors">
                            <span class="text-[16px] material-symbols-outlined">shopping_cart</span> Buyers Order
                        </a>

                        <a href="{{ route('admin.buyers.track', ['id' => $selectedBuyer->id]) }}" wire:navigate @click="buyerModalOpen = false; document.body.classList.remove('overflow-hidden')" class="flex justify-center items-center gap-1.5 bg-surface-container hover:bg-primary/10 px-4 py-2.5 rounded-xl font-bold text-primary text-xs transition-colors">
                            <span class="text-[16px] material-symbols-outlined">quick_reference</span> Buyer Tracker Notes
                        </a>

                        <div class="inline-block relative text-left" x-data="{ openStatusMenu: false }">
                            <button type="button" @click="openStatusMenu = !openStatusMenu" class="flex items-center gap-1 bg-surface-container-high hover:bg-surface-container-highest px-4 py-2.5 border rounded-xl font-bold text-on-surface-variant text-xs transition-colors cursor-pointer">
                                <span class="text-[16px] text-primary material-symbols-outlined">published_with_changes</span>
                                Status: <span class="font-bold text-primary">{{ $selectedBuyer->status_label }}</span>
                                <span class="text-[14px] material-symbols-outlined">expand_more</span>
                            </button>

                            <div x-show="openStatusMenu" @click.outside="openStatusMenu = false" x-cloak class="bottom-12 left-0 z-50 absolute bg-white shadow-xl mt-2 py-1.5 border rounded-xl border-outline-variant/60 w-56 overflow-hidden animate-fadeIn">
                                <button type="button" wire:click="updateStatus({{ $selectedBuyer->id }}, 'Unprocessed Buyer')" @click="openStatusMenu = false" class="flex items-center gap-2 hover:bg-amber-50 px-4 py-2 w-full font-semibold text-amber-700 text-xs text-left">
                                    <span class="bg-amber-500 rounded-full w-2 h-2"></span> Mark as Unprocessed
                                </button>
                                <button type="button" wire:click="updateStatus({{ $selectedBuyer->id }}, 'Verified Buyer')" @click="openStatusMenu = false" class="flex items-center gap-2 hover:bg-emerald-50 px-4 py-2 w-full font-semibold text-emerald-700 text-xs text-left">
                                    <span class="bg-emerald-500 rounded-full w-2 h-2"></span> Mark as Verified Entity
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="button" @click="buyerModalOpen = false; document.body.classList.remove('overflow-hidden'); $wire.call('closeBuyerModal')" class="bg-surface-container-high hover:bg-surface-container px-5 py-2.5 rounded-xl w-full md:w-auto font-bold text-on-surface-variant text-xs cursor-pointer">
                        Dismiss Portfolio
                    </button>
                </div>

            </div>
        @endif
    </div>

</div>