<div class="flex-1 mx-auto p-gutter w-full max-w-[1440px]">

    <div class="flex md:flex-row flex-col justify-between md:items-center gap-4 mb-6 pb-4 border-b border-outline-variant/30">
        <div>
            <h2 class="font-headline-lg font-bold text-headline-lg text-primary text-2xl">Product Catalogue Inventory</h2>
            <p class="mt-0.5 font-body-sm text-on-surface-variant text-sm">Audit your corporate listed commodity stock sheets, logistics configurations, and custom asset certifications blueprints.</p>
        </div>

        <a href="{{ route('supplier.product.create') }}" wire:navigate class="flex justify-center items-center gap-2 bg-primary hover:bg-primary/95 shadow-md shadow-primary/10 px-5 py-3 rounded-xl w-full md:w-auto font-label-md font-bold text-white text-xs transition-all cursor-pointer">
            <span class="text-[18px] material-symbols-outlined">add_circle</span> Add New Product Listing
        </a>
    </div>

    <div class="space-y-4 mb-8">
        <div class="flex lg:flex-row flex-col justify-between items-center gap-4 bg-white shadow-sm p-4 border rounded-2xl border-outline-variant/60">

            <div class="flex items-center gap-1.5 pb-2 lg:pb-0 w-full lg:w-auto overflow-x-auto hide-scrollbar">
                @foreach(['All' => 'All Items', 'Organic' => 'Organic', 'Gluten-Free' => 'Gluten-Free', 'Non-Gluten' => 'Non-Gluten', 'FMCG' => 'FMCG Packs'] as $key => $label)
                    <button type="button" wire:click="setCategoryFilter('{{ $key }}')"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all relative cursor-pointer whitespace-nowrap flex items-center gap-2 {{ $categoryFilter === $key ? 'bg-primary text-white shadow-sm font-bold' : 'bg-surface-container-low text-on-surface-variant hover:bg-surface-container-high' }}">
                        <span>{{ $label }}</span>
                        <span class="px-1.5 py-0.5 rounded-md text-[10px] {{ $categoryFilter === $key ? 'bg-white/20 text-white' : 'bg-white/80 border text-primary font-mono font-bold' }}">
                            {{ $categoryCounts[$key] ?? 0 }}
                        </span>
                    </button>
                @endforeach
            </div>

            <div class="relative w-full lg:w-96">
                <span class="top-1/2 left-4 absolute text-outline text-[20px] -translate-y-1/2 material-symbols-outlined">search</span>
                <input wire:model.live.debounce.300ms="search" type="text"
                    class="bg-surface-container-low focus:bg-white shadow-inner py-2.5 pr-4 pl-11 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-medium text-xs"
                    placeholder="Search name, barcode ean, or product ref tracking codes...">
            </div>
        </div>
    </div>

    @if(session()->has('success'))
        <div class="flex items-center gap-2 bg-emerald-50 mb-6 p-4 border border-emerald-200 rounded-xl font-semibold text-emerald-800 text-xs animate-fadeIn">
            <span class="text-[18px] material-symbols-outlined">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="gap-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @forelse($products as $prod)
            <div wire:key="product-card-{{ $prod->id }}"
                class="group relative flex flex-col justify-between bg-white shadow-sm hover:shadow-md p-5 border rounded-[2rem] border-outline-variant/50 overflow-hidden transition-all animate-fadeIn duration-300">

                <div>
                    <div class="relative flex justify-center items-center bg-surface-container shadow-inner mb-4 border rounded-[1.5rem] aspect-[4/3] overflow-hidden">
                        @if(filled($prod->product_images) && isset($prod->product_images[0]))
                            <img alt="{{ $prod->product_name }} Preview Image" src="{{ asset('storage/' . $prod->product_images[0]) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <span class="text-outline/40 text-[56px] material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">egg_alt</span>
                        @endif

                        <div class="top-3 left-3 absolute flex flex-col items-start gap-1.5">
                            <span class="bg-white/90 shadow-sm backdrop-blur-md px-2.5 py-1 border rounded-md font-label-md font-bold text-[10px] text-primary uppercase tracking-wide">
                                {{ $prod->product_category ?? 'General' }}
                            </span>
                        </div>

                        @if($prod->ability_to_provide_samples)
                            <div class="right-3 bottom-3 absolute">
                                <span class="bg-emerald-600/95 backdrop-blur-md px-2 py-0.5 border border-emerald-500/20 rounded-md font-bold text-[9px] text-white uppercase tracking-wider">
                                    Samples Available
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="space-y-1 mb-4 px-1">
                        <span class="block font-mono font-bold text-[10px] text-on-surface-variant/70 uppercase tracking-wide">Code Ref: {{ $prod->product_ref }}</span>
                        <h3 class="min-h-[44px] font-headline-md font-bold text-primary text-base line-clamp-2 leading-snug" title="{{ $prod->product_name }}">
                            {{ $prod->product_name }}
                        </h3>

                        <div class="flex items-baseline gap-1 pt-2">
                            <span class="font-bold text-[11px] text-on-surface-variant">Base Valuation:</span>
                            <span class="font-mono font-bold text-emerald-700 text-lg">₦{{ number_format($prod->price_pieces, 2) }}</span>
                            <span class="text-[10px] text-on-surface-variant/80">/ piece</span>
                        </div>
                    </div>

                    <div class="gap-2 grid grid-cols-2 px-1 pt-3 pb-4 border-background border-t text-[11px] text-on-surface-variant/90">
                        <div class="flex items-center gap-1.5 bg-surface-container-low/60 p-1.5 border rounded-lg">
                            <span class="text-outline text-[15px] material-symbols-outlined">box</span>
                            <span class="truncate">Pack: <strong>{{ $prod->pcs_per_case }} pcs</strong></span>
                        </div>
                        <div class="flex items-center gap-1.5 bg-surface-container-low/60 p-1.5 border rounded-lg">
                            <span class="text-outline text-[15px] material-symbols-outlined">hourglass_empty</span>
                            <span class="truncate">Life: <strong>{{ $prod->shelf_life ?? 'Unlisted' }}</strong></span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-2 border-background border-t w-full">
                    <button type="button" wire:click="viewProduct({{ $prod->id }})"
                        class="flex flex-1 justify-center items-center gap-1 bg-surface-container-high hover:bg-surface-container-highest px-3 py-2.5 rounded-xl font-bold text-primary text-xs transition-colors cursor-pointer">
                        <span class="text-[16px] material-symbols-outlined">visibility</span> View Full
                    </button>

                    <a href="{{ route('supplier.product.edit', ['id' => $prod->id]) }}"
                        class="flex justify-center items-center bg-surface-container hover:bg-primary/10 p-2.5 rounded-xl text-on-surface-variant hover:text-primary transition-colors cursor-pointer"
                        title="Modify Item Specs">
                        <span class="text-[18px] material-symbols-outlined">edit_square</span>                 </a>

                    <button type="button" wire:click="deleteProduct({{ $prod->id }})"
                        wire:confirm="Are you absolutely certain you want to permanently delete this product asset tracking entry?"
                        class="flex justify-center items-center bg-red-50 hover:bg-red-100 p-2.5 border border-red-100/50 rounded-xl text-red-600 transition-colors cursor-pointer" title="Purge Record">
                        <span class="text-[18px] material-symbols-outlined">delete</span>
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3 xl:col-span-4 bg-white p-16 border border-dashed rounded-[2.5rem] font-body-sm text-on-surface-variant text-center italic select-none">
                <span class="block mb-2 text-outline text-[56px] material-symbols-outlined">inventory_2</span>
                <p class="font-bold text-primary text-sm not-italic">No Inventory Listings Found</p>
                <p class="mx-auto mt-0.5 max-w-md text-xs">There are no matching asset entries cataloged across your active inventory matrix sheet directories.</p>
            </div>
        @endforelse
    </div>

    <div x-data="{ isModalOpen: false }"
         x-on:open-product-preview-modal.window="isModalOpen = true; document.body.classList.add('overflow-hidden')"
         x-on:close-product-preview-modal.window="isModalOpen = false; document.body.classList.remove('overflow-hidden')"
         x-on:keydown.escape.window="isModalOpen = false; document.body.classList.remove('overflow-hidden'); $wire.call('closeModal')"
         x-show="isModalOpen"
         x-cloak
         class="z-[100] fixed inset-0 flex justify-center items-center bg-black/40 backdrop-blur-sm p-4 sm:p-6 md:p-8"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        @if($selectedProduct)
            <div @click.outside="isModalOpen = false; document.body.classList.remove('overflow-hidden'); $wire.call('closeModal')"
                 class="flex flex-col bg-white shadow-2xl rounded-[2.5rem] w-full max-w-4xl max-h-[calc(100vh-4rem)] overflow-hidden transform"
                 x-data="{ modalTab: 'general' }"
                 x-show="isModalOpen"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="scale-95 translate-y-4"
                 x-transition:enter-end="scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="scale-100 translate-y-0"
                 x-transition:leave-end="scale-95 translate-y-4">

                <div class="flex justify-between items-center bg-primary p-6 text-white select-none">
                    <div class="flex items-center gap-4">
                        <div class="flex justify-center items-center bg-white/10 rounded-2xl w-12 h-12">
                            <span class="text-[24px] material-symbols-outlined">shopping_bag</span>
                        </div>
                        <div>
                            <span class="block font-mono font-bold text-[10px] text-white/70 uppercase tracking-wider">Ref Profile ID Token: {{ $selectedProduct->product_ref }}</span>
                            <h2 class="max-w-[480px] font-headline-md font-bold text-headline-md text-lg md:text-xl truncate">{{ $selectedProduct->product_name }}</h2>
                        </div>
                    </div>
                    <button type="button" @click="isModalOpen = false; document.body.classList.remove('overflow-hidden'); $wire.call('closeModal')" class="hover:bg-white/10 p-2 rounded-full transition-colors cursor-pointer">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="flex items-center gap-2 bg-surface-container-low px-6 py-2 border-b font-bold text-on-surface-variant text-xs select-none">
                    <button type="button" @click="modalTab = 'general'" class="px-4 py-2 rounded-lg transition-colors cursor-pointer" :class="modalTab === 'general' ? 'bg-primary text-white shadow-sm' : 'hover:bg-surface-container-high text-on-surface-variant'">General Specs</button>
                    <button type="button" @click="modalTab = 'logistics'" class="px-4 py-2 rounded-lg transition-colors cursor-pointer" :class="modalTab === 'logistics' ? 'bg-primary text-white shadow-sm' : 'hover:bg-surface-container-high text-on-surface-variant'">Logistics & Packaging</button>
                    <button type="button" @click="modalTab = 'gallery'" class="px-4 py-2 rounded-lg transition-colors cursor-pointer" :class="modalTab === 'gallery' ? 'bg-primary text-white shadow-sm' : 'hover:bg-surface-container-high text-on-surface-variant'">Images Archive ({{ count($selectedProduct->product_images ?? []) }})</button>
                </div>

                <div class="flex-1 space-y-6 bg-background p-8 overflow-y-auto text-sm hide-scrollbar">

                    <div x-show="modalTab === 'general'" class="space-y-6 animate-fadeIn">
                        <div class="gap-6 grid grid-cols-1 md:grid-cols-3 bg-white p-6 border rounded-2xl">
                            <div>
                                <span class="block font-bold text-[11px] text-on-surface-variant uppercase tracking-wider">Categorization Group</span>
                                <span class="block mt-0.5 font-bold text-primary text-base">{{ $selectedProduct->product_category ?? 'Unclassified Entry' }}</span>
                            </div>
                            <div>
                                <span class="block font-bold text-[11px] text-on-surface-variant uppercase tracking-wider">EAN / UPC Barcode Tracker</span>
                                <span class="block mt-0.5 font-mono font-bold text-primary text-base">{{ $selectedProduct->ean_upc_code ?? 'None Hardcoded' }}</span>
                            </div>
                            <div>
                                <span class="block font-bold text-[11px] text-on-surface-variant uppercase tracking-wider">Expected Product Shelf Life</span>
                                <span class="block mt-0.5 font-bold text-primary text-base">{{ $selectedProduct->shelf_life ?? 'No Expiration Metric Saved' }}</span>
                            </div>
                        </div>

                        <div class="space-y-2 bg-white p-6 border rounded-2xl">
                            <h4 class="font-bold text-primary text-xs uppercase tracking-wider">Item Blueprint Overview Descriptions</h4>
                            <p class="text-on-surface-variant text-xs leading-relaxed">{{ $selectedProduct->product_description ?? 'No structured narrative descriptions cataloged under this file index slot.' }}</p>
                        </div>

                        @if($selectedProduct->product_catalogue)
                            <div class="flex justify-between items-center bg-emerald-50 p-4 border border-emerald-100 rounded-2xl">
                                <div class="flex items-center gap-2 font-semibold text-emerald-800 text-xs">
                                    <span class="text-[20px] material-symbols-outlined">picture_as_pdf</span>
                                    <span>Bulk Compiled Datasheet Portfolio Sheet Attached Completely</span>
                                </div>
                                <a href="{{ asset('storage/' . $selectedProduct->product_catalogue) }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 shadow-sm px-4 py-1.5 rounded-lg font-bold text-white text-xs transition-colors">
                                    Download Catalog PDF
                                </a>
                            </div>
                        @endif
                    </div>

                    <div x-show="modalTab === 'logistics'" x-cloak class="space-y-6 animate-fadeIn">
                        <div class="grid grid-cols-1 sm:grid-cols-3 bg-white border rounded-2xl sm:divide-x divide-y sm:divide-y-0 overflow-hidden text-center">
                            <div class="p-4"><span class="block font-bold text-[10px] text-on-surface-variant uppercase tracking-wider">Pieces Per Case</span><span class="block mt-1 font-mono font-bold text-primary text-lg">{{ $selectedProduct->pcs_per_case }} pcs</span></div>
                            <div class="p-4"><span class="block font-bold text-[10px] text-on-surface-variant uppercase tracking-wider">Cases Per Pallet</span><span class="block mt-1 font-mono font-bold text-primary text-lg">{{ $selectedProduct->cases_per_pallet }} cases</span></div>
                            <div class="p-4"><span class="block font-bold text-[10px] text-on-surface-variant uppercase tracking-wider">Total Pieces / Pallet</span><span class="block mt-1 font-mono font-bold text-primary text-lg">{{ $selectedProduct->pcs_per_pallet }} units</span></div>
                        </div>

                        <div class="gap-6 grid grid-cols-1 md:grid-cols-2 text-xs">
                            <div class="space-y-2 bg-white p-5 border rounded-2xl">
                                <h4 class="font-bold text-primary uppercase tracking-wide">Global Minimum Order Bounds</h4>
                                <p class="font-medium text-on-surface-variant leading-relaxed">{{ $selectedProduct->overall_moqs ?? 'Not Specified' }}</p>
                            </div>
                            <div class="space-y-2 bg-white p-5 border rounded-2xl">
                                <h4 class="font-bold text-primary uppercase tracking-wide">Pricing Framework Configuration</h4>
                                <p class="font-medium text-on-surface-variant leading-relaxed">{{ $selectedProduct->pricing_structure_type ?? 'Default Unit Rates' }}</p>
                            </div>
                            <div class="space-y-2 md:col-span-2 bg-white p-5 border rounded-2xl">
                                <h4 class="font-bold text-primary uppercase tracking-wide">Full Truckload (FTL) Freight Constraints Matrix</h4>
                                <p class="font-medium text-on-surface-variant leading-relaxed">{{ $selectedProduct->full_truckload_details ?? 'No detailed carrier constraints maps updated yet.' }}</p>
                            </div>
                            <div class="space-y-2 md:col-span-2 bg-white p-5 border rounded-2xl">
                                <h4 class="font-bold text-primary uppercase tracking-wide">Product Origin</h4>
                                <p class="font-medium text-on-surface-variant leading-relaxed">{{ $selectedProduct->product_origin ?? 'No product origin provided.' }}</p>
                            </div>
                            <div class="space-y-2 md:col-span-2 bg-white p-5 border rounded-2xl">
                                <h4 class="font-bold text-primary uppercase tracking-wide">Payment Settlement Terms Blueprint Code</h4>
                                <p class="bg-surface-container-low/50 p-3 border border-dashed rounded-xl font-medium text-on-surface-variant leading-relaxed whitespace-pre-line">{{ $selectedProduct->payment_terms ?? 'Default enterprise onboarding guidelines apply.' }}</p>
                            </div>
                        </div>
                    </div>

                    <div x-show="modalTab === 'gallery'" x-cloak class="animate-fadeIn">
                        @if(filled($selectedProduct->product_images))
                            <div class="gap-4 grid grid-cols-2 sm:grid-cols-4">
                                @foreach($selectedProduct->product_images as $storedImagePath)
                                    <div class="group/img relative flex justify-center items-center bg-white shadow-sm border rounded-2xl border-outline-variant/40 aspect-square overflow-hidden">
                                        <img alt="Catalog Attachment Image" src="{{ asset('storage/' . $storedImagePath) }}" class="w-full h-full object-cover">
                                        <a href="{{ asset('storage/' . $storedImagePath) }}" target="_blank" class="absolute inset-0 flex justify-center items-center bg-primary/40 opacity-0 group-hover/img:opacity-100 text-white transition-opacity cursor-pointer select-none">
                                            <span class="text-[24px] material-symbols-outlined">open_in_new</span>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-white p-12 border border-dashed rounded-3xl text-on-surface-variant/60 text-xs text-center italic">
                                <span class="block mb-1 text-outline text-[36px] material-symbols-outlined">image_not_supported</span>
                                This record was provisioned via bulk datasheet upload without supporting visual image files arrays.
                            </div>
                        @endif
                    </div>

                </div>

                <div class="flex sm:flex-row flex-col justify-between items-center gap-4 bg-white p-6 border-t border-outline-variant select-none">
                    <span class="flex items-center gap-1 font-semibold text-on-surface-variant/80 text-xs"><span class="text-[16px] material-symbols-outlined">calendar_today</span> Listed entry row on {{ $selectedProduct->created_at->format('M d, Y') }}</span>

                    <div class="flex items-center gap-2.5 w-full sm:w-auto">
                        <button type="button" @click="isModalOpen = false; document.body.classList.remove('overflow-hidden'); $wire.call('closeModal')" class="bg-surface-container-high hover:bg-surface-container px-6 py-2.5 rounded-xl font-bold text-on-surface-variant text-xs cursor-pointer">
                            Dismiss Preview
                        </button>
                        <button type="button" wire:click="deleteProduct({{ $selectedProduct->id }})" wire:confirm="Are you certain you want to permanently strip this item specification card away from your catalogue?" class="bg-red-50 hover:bg-red-100 px-5 py-2.5 border border-red-100 rounded-xl font-bold text-red-600 text-xs transition-colors cursor-pointer">
                            Purge Asset Card
                        </button>
                    </div>
                </div>

            </div>
        @endif
    </div>

</div>
