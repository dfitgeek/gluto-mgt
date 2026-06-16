<div class="flex-1 mx-auto my-2 p-gutter w-full max-w-[1440px]" x-data="{ currentModalOpen: @entangle('isUploadModalOpen') }">

    <!-- DASHBOARD HEADER TITLE PANEL -->
    <div class="flex sm:flex-row flex-col justify-between sm:items-center gap-4 mb-8 pb-4 border-b border-outline-variant/30">
        <div>
            <h2 class="font-headline-lg font-bold text-headline-lg text-primary text-2xl">Supplier Document Vault Library</h2>
            <p class="mt-0.5 font-body-sm text-on-surface-variant text-sm">Review corporate credentials records arrays or add updated single-product quality check certifications logs.</p>
        </div>
        <div class="flex items-center gap-1.5 bg-surface-container-low shadow-inner px-4 py-2 border rounded-xl h-fit font-mono font-bold text-primary text-xs select-none">
            <span class="text-[16px] text-emerald-600 material-symbols-outlined">verified</span> Status: {{ $supplier->status_label }}
        </div>
    </div>

    <!-- MAIN INTERFACE ACTION BANNERS FLASHLIGHTS -->
    @if(session()->has('success'))
        <div class="flex items-center gap-2 bg-emerald-50 mb-6 p-4 border border-emerald-200 rounded-xl font-semibold text-emerald-800 text-xs animate-fadeIn anonymity-banner">
            <span class="text-[18px] material-symbols-outlined">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- 13-VAULTS INTERACTIVE TRACK CARDS GRID LOOP -->
    <div class="gap-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3">
        @foreach($this->documentMap as $fieldName => $meta)
            @php $filesCollection = $supplier->{$fieldName} ?? []; @endphp

            <div class="flex flex-col justify-between bg-white shadow-sm hover:shadow-md p-6 border rounded-[2rem] border-outline-variant/50 min-h-[280px] transition-shadow animate-fadeIn">

                <div class="space-y-4">
                    <div class="flex justify-between items-center pb-3 border-background border-b select-none">
                        <div class="flex items-center gap-2">
                            <div class="flex justify-center items-center bg-primary/5 rounded-lg w-8 h-8 text-primary">
                                <span class="text-[18px] material-symbols-outlined">{{ $meta['icon'] }}</span>
                            </div>
                            <h3 class="font-label-md font-bold text-primary text-xs">{{ $meta['label'] }}</h3>
                        </div>
                        <span class="bg-surface-container px-2 py-0.5 border rounded-md font-mono font-bold text-[10px] text-on-surface-variant">
                            Count: {{ is_array($filesCollection) ? count($filesCollection) : 0 }}
                        </span>
                    </div>

                    <!-- Inner Card Vault File Listing Items Row Stack -->
                    <div class="space-y-2 pr-1 max-h-48 overflow-y-auto hide-scrollbar">
                        @if(filled($filesCollection) && is_array($filesCollection))
                            @foreach($filesCollection as $nodeIndex => $docAsset)
                                <div class="group/item relative flex justify-between items-center bg-surface-container-low hover:bg-surface-container-low/80 p-2.5 pr-10 border rounded-xl text-xs transition-colors animate-fadeIn">
                                    <a href="{{ asset('storage/' . $docAsset['file_path']) }}" target="_blank" class="flex items-center gap-1.5 max-w-[160px] font-bold text-primary hover:underline truncate">
                                        <span class="text-[16px] text-emerald-600 material-symbols-outlined">cloud_download</span>
                                        <span>Download Asset Track</span>
                                    </a>

                                    @if(!empty($docAsset['product_ref']))
                                        <span class="bg-secondary-container px-2 py-0.5 border border-secondary/20 rounded font-mono font-bold text-[9px] text-on-secondary-container uppercase tracking-wide">
                                            Ref: {{ $docAsset['product_ref'] }}
                                        </span>
                                    @else
                                        <span class="bg-surface-container-high px-1.5 py-0.5 rounded font-sans font-medium text-[9px] text-on-surface-variant/80">
                                            Global Profile
                                        </span>
                                    @endif

                                    <!-- NEW TRASH REMOVAL RECT BUTTON OVERLAY -->
                                    <button type="button"
                                        wire:click="removeDocument('{{ $fieldName }}', {{ $nodeIndex }})"
                                        wire:confirm="Are you absolutely sure you want to delete this specific file from your active document library? This will delete the archive file from our document vault stores permanently."
                                        class="top-1/2 right-2 absolute hover:bg-red-50/80 p-1.5 rounded-lg text-outline hover:text-red-600 transition-colors -translate-y-1/2 cursor-pointer"
                                        title="Delete Document">
                                        <span class="text-[16px] material-symbols-outlined">delete</span>
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <div class="flex items-center gap-2 bg-background/50 p-4 border border-dashed rounded-xl text-on-surface-variant/50 text-xs italic select-none">
                                <span class="text-[16px] material-symbols-outlined">folder_off</span>
                                <span>No verification documents added to this track.</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mt-4 pt-4 border-background border-t w-full">
                    <button type="button" wire:click="openUploadModal('{{ $fieldName }}')" class="flex justify-center items-center gap-1.5 bg-surface-container-high hover:bg-primary/10 py-2.5 rounded-xl w-full font-bold text-primary text-xs transition-colors cursor-pointer select-none">
                        <span class="text-[16px] material-symbols-outlined">add_circle</span> Append Document Variant
                    </button>
                </div>

            </div>
        @endforeach
    </div>

    <!-- APPEND OVERLAY MODAL -->
    <div x-show="currentModalOpen" x-cloak
         class="z-[100] fixed inset-0 flex justify-center items-center bg-black/40 backdrop-blur-sm p-4 sm:p-6 md:p-8"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        <div @click.outside="currentModalOpen = false; $wire.call('closeUploadModal')"
             class="flex flex-col bg-white shadow-2xl rounded-[2.5rem] w-full max-w-md overflow-hidden transform"
             x-show="currentModalOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="scale-95 translate-y-4"
             x-transition:enter-end="scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="scale-100 translate-y-0"
             x-transition:leave-end="scale-95 translate-y-4">

            <div class="flex justify-between items-center bg-primary p-5 text-white select-none">
                <div class="flex items-center gap-3">
                    <span class="text-[22px] material-symbols-outlined">cloud_upload</span>
                    <h3 class="font-headline-md font-bold text-sm tracking-tight">Append Document Entry</h3>
                </div>
                <button type="button" @click="currentModalOpen = false; $wire.call('closeUploadModal')" class="hover:bg-white/10 p-1.5 rounded-full transition-colors cursor-pointer">
                    <span class="text-[18px] material-symbols-outlined">close</span>
                </button>
            </div>

            <form wire:submit.prevent="appendDocument" class="space-y-4 p-6 text-xs">
                <div class="bg-surface-container-low/50 p-3 border border-dashed rounded-xl font-medium text-on-surface-variant select-none">
                    Target Track: <strong class="font-label-md text-primary">{{ $selectedFieldLabel }}</strong>
                </div>

                <div class="space-y-1.5">
                    <label class="block pl-0.5 font-bold text-on-surface-variant">Select File Scans *</label>
                    <input type="file" wire:model="uploaded_file" required class="block hover:file:bg-primary/20 file:bg-primary/10 file:mr-3 file:px-3 file:py-1.5 file:border-0 file:rounded-xl w-full file:font-semibold text-on-surface-variant file:text-primary file:text-xs">
                    <p class="pl-0.5 text-[10px] text-on-surface-variant/80">Accepts PDF, DOCX, or Image snapshots up to 5MB.</p>
                    @error('uploaded_file') <span class="block pl-0.5 font-bold text-[10px] text-red-500 animate-fadeIn">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block pl-0.5 font-bold text-on-surface-variant">Associate Catalog Product Reference (Optional)</label>
                    <input type="text" wire:model.defer="associated_product_ref" class="bg-surface-container-low focus:bg-white px-3 py-2 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-mono font-bold text-primary" placeholder="e.g., PROD-3902 (Leave blank if profile global)">
                    @error('associated_product_ref') <span class="block pl-0.5 font-bold text-[10px] text-red-500 animate-fadeIn">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end items-center gap-2 pt-2 border-background border-t select-none">
                    <button type="button" @click="currentModalOpen = false; $wire.call('closeUploadModal')" class="bg-surface-container hover:bg-surface-container-high px-4 py-2 rounded-xl font-bold text-on-surface-variant cursor-pointer">Dismiss</button>
                    <button type="submit" wire:loading.attr="disabled" class="flex justify-center items-center gap-1 bg-primary hover:bg-primary/95 shadow-md px-5 py-2 rounded-xl font-bold text-white cursor-pointer">
                        <span wire:loading.remove>Commit Upload</span>
                        <span wire:loading class="flex items-center gap-1 animate-pulse"><span class="inline-block border border-white border-t-transparent rounded-full w-3 h-3 animate-spin"></span> Syncing array...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
