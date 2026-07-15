<div class="flex-1 mx-auto my-2 p-gutter w-full max-w-[1440px]" x-data="{ marketModalOpen: false }">

    <div class="flex sm:flex-row flex-col justify-between sm:items-center gap-4 mb-6 pb-4 border-b border-outline-variant/30 select-none">
        <div>
            <h2 class="font-headline-lg font-bold text-headline-lg text-primary text-2xl tracking-tight">Suppliers Wholesales Catalogue</h2>
            <p class="mt-0.5 font-body-sm text-on-surface-variant text-sm">Browse vendor logistics assets, manage dynamic pricing sheets overrides, and assemble supply replenishment orders.</p>
        </div>

        @if(count($basket) > 0)
            <button type="button" wire:click="proceedToCheckout" class="flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-600/95 shadow px-6 py-3 rounded-xl font-label-md font-bold text-white text-xs active:scale-95 transition-all animate-fadeIn cursor-pointer">
                <span class="text-[18px] material-symbols-outlined">shopping_cart_checkout</span>
                Checkout Staged Order ({{ count($basket) }} items)
            </button>
        @endif
    </div>

    @if(session()->has('error'))
        <div class="flex items-center gap-2 bg-red-50 mb-6 p-4 border border-red-200 rounded-xl font-semibold text-red-800 text-xs animate-fadeIn select-none">
            <span class="text-[18px] material-symbols-outlined">error</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="space-y-4 mb-8 select-none">
        <div class="flex lg:flex-row flex-col justify-between items-center gap-4 bg-white shadow-sm p-4 border rounded-2xl border-outline-variant/60">
            <div class="flex items-center gap-1.5 pb-2 lg:pb-0 w-full lg:w-auto overflow-x-auto hide-scrollbar">
                @foreach(['All' => 'All Products', 'Organic' => 'Organic Certified', 'Gluten-Free' => 'Gluten-Free', 'Non-Gluten' => 'Standard Non-Gluten', 'FMCG' => 'FMCG Packs'] as $key => $label)
                    <button type="button" wire:click="setCategory('{{ $key }}')"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all relative cursor-pointer whitespace-nowrap flex items-center gap-2 {{ $categoryFilter === $key ? 'bg-primary text-white shadow-sm' : 'bg-surface-container-low text-on-surface-variant hover:bg-surface-container-high' }}">
                        <span>{{ $label }}</span>
                        <span class="px-1.5 py-0.5 rounded-md text-[10px] {{ $categoryFilter === $key ? 'bg-white/20 text-white' : 'bg-white/80 border text-primary font-mono font-bold' }}">
                            {{ $categoryCounts[$key] ?? 0 }}
                        </span>
                    </button>
                @endforeach
            </div>

            <div class="relative w-full lg:w-96">
                <span class="top-1/2 left-4 absolute text-outline text-[20px] -translate-y-1/2 material-symbols-outlined">search</span>
                <input wire:model.live.debounce.250ms="search" type="text"
                    class="bg-surface-container-low focus:bg-white shadow-inner py-2.5 pr-4 pl-11 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-medium text-primary text-xs"
                    placeholder="Search commodities catalog SKU registries...">
            </div>
        </div>
    </div>

    <div class="gap-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @forelse($products as $item)
            @php $inBasket = isset($basket[$item->id]); @endphp
            <div wire:key="vendor-item-{{ $item->id }}"
                class="group relative flex flex-col justify-between bg-white shadow-sm hover:shadow-md p-5 border rounded-[2rem] {{ $inBasket ? 'border-emerald-500 ring-1 ring-emerald-500' : 'border-outline-variant/50' }} transition-all animate-fadeIn duration-300">

                <div>
                    <div class="relative flex justify-center items-center bg-surface-container shadow-inner mb-4 border rounded-[1.5rem] aspect-[4/3] overflow-hidden">
                        @if(filled($item->product_images) && isset($item->product_images[0]))
                            <img alt="{{ $item->product_name }} Photo" src="{{ asset('storage/' . $item->product_images[0]) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <span class="text-outline/40 text-[56px] material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">eco</span>
                        @endif

                        <div class="top-3 left-3 absolute select-none">
                            <span class="bg-white/95 shadow-sm backdrop-blur-md px-2.5 py-1 border rounded-md font-label-md font-bold text-[9px] text-primary uppercase tracking-wide">
                                {{ $item->product_category ?? 'General' }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-1 mb-3 px-1">
                        <span class="block font-mono font-bold text-[10px] text-on-surface-variant/70 uppercase tracking-wide">SKU: {{ $item->product_ref }}</span>
                        <h3 class="min-h-[44px] font-headline-md font-bold text-primary text-base line-clamp-2 leading-snug" title="{{ $item->product_name }}">
                            {{ $item->product_name }}
                        </h3>
                        <span class="block font-medium text-[11px] text-on-surface-variant/80 truncate">Supplier: <strong class="text-primary">{{ $item->supplier->company_name ?? 'Platform Vendor' }}
                        </strong></span>

                        <div class="flex items-baseline gap-1 pt-2 select-none">
                            <span class="font-bold text-[11px] text-on-surface-variant/80">Base Rate:</span>
                            <span class="font-mono font-bold text-emerald-700 text-base">₦{{ number_format($item->price_pieces, 2) }}</span>
                            <span class="text-[10px] text-on-surface-variant/70">/ piece</span>
                        </div>
                    </div>

                    <div class="gap-2 grid grid-cols-2 px-1 pt-3 pb-4 border-background border-t text-[11px] text-on-surface-variant/90 select-none">
                        <div class="flex items-center gap-1.5 bg-surface-container-low/60 p-1.5 border rounded-lg truncate">
                            <span class="text-outline text-[15px] material-symbols-outlined">box</span>
                            <span class="truncate">Case MOQ: <strong>{{ $item->pcs_per_case }} pcs</strong></span>
                        </div>
                        <div class="flex items-center gap-1.5 bg-surface-container-low/60 p-1.5 border rounded-lg truncate">
                            <span class="text-outline text-[15px] material-symbols-outlined">public</span>
                            <span class="truncate">Origin: <strong>{{ $item->product_origin }}</strong></span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-2 border-background border-t w-full select-none">
                    <button type="button" wire:click="inspectProduct({{ $item->id }})" class="flex justify-center items-center bg-surface-container hover:bg-surface-container-high p-2.5 border rounded-xl text-primary transition-colors cursor-pointer" title="View catalog asset specifications sheets details">
                        <span class="text-[18px] material-symbols-outlined">visibility</span>
                    </button>

                    <button type="button" wire:click="toggleAddToBasket({{ $item->id }})"
                        class="flex-1 flex justify-center items-center gap-1 py-2.5 rounded-xl font-bold text-xs transition-all cursor-pointer {{ $inBasket ? 'bg-red-50 hover:bg-red-100 text-red-700 border border-red-200' : 'bg-primary hover:bg-primary/95 text-white shadow-sm' }}">
                        <span class="text-[16px] material-symbols-outlined">{{ $inBasket ? 'remove_shopping_cart' : 'add_shopping_cart' }}</span>
                        <span>{{ $inBasket ? 'Drop Item' : 'Add To Order' }}</span>
                    </button>
                </div>

            </div>
        @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3 xl:col-span-4 bg-white p-16 border border-dashed rounded-[2.5rem] text-on-surface-variant text-center italic select-none">
                <span class="block mb-2 text-outline text-[56px] material-symbols-outlined">storefront</span>
                <p class="font-bold text-primary text-sm not-italic">No Sourcing Items Listed</p>
                <p class="mx-auto mt-0.5 max-w-sm text-xs">There are no supplier catalog models matching your current search constraints.</p>
            </div>
        @endforelse
    </div>

    <div x-on:open-marketplace-modal.window="marketModalOpen = true; document.body.classList.add('overflow-hidden')"
         x-on:close-marketplace-modal.window="marketModalOpen = false; document.body.classList.remove('overflow-hidden')"
         x-on:keydown.escape.window="marketModalOpen = false; document.body.classList.remove('overflow-hidden'); $wire.call('closeModal')"
         x-show="marketModalOpen" x-cloak
         class="z-[100] fixed inset-0 flex justify-center items-center bg-black/40 backdrop-blur-sm p-4 sm:p-6 md:p-8"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        @if($selectedProduct)
            <div @click.outside="marketModalOpen = false; document.body.classList.remove('overflow-hidden'); $wire.call('closeModal')"
                 class="flex flex-col bg-white shadow-2xl rounded-[2.5rem] w-full max-w-4xl max-h-[calc(100vh-4rem)] overflow-hidden transform"
                 x-data="{ modalActiveTab: 'specs_general' }" x-show="marketModalOpen"
                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="scale-95 translate-y-4" x-transition:enter-end="scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="scale-100 translate-y-0" x-transition:leave-end="scale-95 translate-y-4">

                <div class="flex justify-between items-center bg-primary p-6 text-white select-none">
                    <div class="flex items-center gap-4">
                        <div class="flex justify-center items-center bg-white/10 rounded-2xl w-12 h-12">
                            <span class="text-[24px] material-symbols-outlined">analytics</span>
                        </div>
                        <div>
                            <span class="block font-mono font-bold text-[10px] text-white/70 uppercase tracking-wider">Product ID Token: {{ $selectedProduct->product_ref }}</span>
                            <h2 class="max-w-[520px] font-headline-md font-bold text-headline-md text-base md:text-lg truncate">{{ $selectedProduct->product_name }}</h2>
                        </div>
                    </div>
                    <button type="button" @click="marketModalOpen = false; document.body.classList.remove('overflow-hidden'); $wire.call('closeModal')" class="flex justify-center items-center hover:bg-white/10 p-2 rounded-full transition-colors cursor-pointer">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="flex items-center gap-2 bg-surface-container-low px-6 py-2 border-b font-bold text-on-surface-variant text-xs select-none">
                    <button type="button" @click="modalActiveTab = 'specs_general'" class="px-4 py-2 rounded-lg transition-colors cursor-pointer" :class="modalActiveTab === 'specs_general' ? 'bg-primary text-white shadow-sm' : 'hover:bg-surface-container-high text-on-surface-variant'">Technical Specs</button>
                    <button type="button" @click="modalActiveTab = 'specs_logistics'" class="px-4 py-2 rounded-lg transition-colors cursor-pointer" :class="modalActiveTab === 'specs_logistics' ? 'bg-primary text-white shadow-sm' : 'hover:bg-surface-container-high text-on-surface-variant'">Packing & Freight Logistics</button>
                    <button type="button" @click="modalActiveTab = 'specs_gallery'" class="px-4 py-2 rounded-lg transition-colors cursor-pointer" :class="modalActiveTab === 'specs_gallery' ? 'bg-primary text-white shadow-sm' : 'hover:bg-surface-container-high text-on-surface-variant'">Images Ledger ({{ count($selectedProduct->product_images ?? []) }})</button>
                </div>

                <div class="flex-1 space-y-6 bg-background p-8 overflow-y-auto font-medium text-on-surface-variant text-sm hide-scrollbar">

                    <div x-show="modalActiveTab === 'specs_general'" class="space-y-6 animate-fadeIn">
                        <div class="gap-6 grid grid-cols-1 md:grid-cols-3 bg-white p-6 border rounded-2xl select-none">
                            <div>
                                <span class="block font-bold text-[11px] text-on-surface-variant uppercase tracking-wider">Product Category Cluster</span>
                                <span class="block mt-0.5 font-bold text-primary text-base">{{ $selectedProduct->product_category ?? 'Unclassified' }}</span>
                            </div>
                            <div>
                                <span class="block font-bold text-[11px] text-on-surface-variant uppercase tracking-wider">UPC / EAN Code Mapping</span>
                                <span class="block mt-0.5 font-mono font-bold text-primary text-base">{{ $selectedProduct->ean_upc_code ?? 'None Hardcoded' }}</span>
                            </div>
                            <div>
                                <span class="block font-bold text-[11px] text-on-surface-variant uppercase tracking-wider">Expected Product Shelf Life</span>
                                <span class="block mt-0.5 font-bold text-primary text-base">{{ $selectedProduct->shelf_life ?? 'Not Reported' }}</span>
                            </div>
                        </div>

                        <div class="space-y-2 bg-white p-6 border rounded-2xl">
                            <h4 class="font-bold text-primary text-xs uppercase tracking-wider select-none">Item Comprehensive Description Log</h4>
                            <p class="text-on-surface-variant text-xs leading-relaxed">{{ $selectedProduct->product_description ?? 'No longform spec description text stored under this inventory tracking card index row.' }}</p>
                        </div>

                        @if($selectedProduct->product_catalogue)
                            <div class="flex justify-between items-center bg-emerald-50 p-4 border border-emerald-100 rounded-2xl animate-fadeIn select-none">
                                <div class="flex items-center gap-2 font-semibold text-emerald-800 text-xs">
                                    <span class="text-[20px] material-symbols-outlined">picture_as_pdf</span>
                                    <span>Bulk Compiled Datasheet Portfolio Sheet Attached Natively</span>
                                </div>
                                <a href="{{ asset('storage/' . $selectedProduct->product_catalogue) }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 shadow-sm px-5 py-2 rounded-xl font-bold text-white text-xs transition-colors">
                                    Download Catalog PDF File
                                </a>
                            </div>
                        @endif
                    </div>

                    <div x-show="modalActiveTab === 'specs_logistics'" x-cloak class="space-y-6 animate-fadeIn">
                        <div class="grid grid-cols-1 sm:grid-cols-3 bg-white border rounded-2xl sm:divide-x divide-y sm:divide-y-0 overflow-hidden text-center select-none">
                            <div class="p-4"><span class="block font-bold text-[10px] text-on-surface-variant uppercase tracking-wider">Pieces / Case</span><span class="block mt-1 font-mono font-bold text-primary text-base">{{ $selectedProduct->pcs_per_case }} units</span></div>
                            <div class="p-4"><span class="block font-bold text-[10px] text-on-surface-variant uppercase tracking-wider">Cases / Pallet</span><span class="block mt-1 font-mono font-bold text-primary text-base">{{ $selectedProduct->cases_per_pallet }} cases</span></div>
                            <div class="p-4"><span class="block font-bold text-[10px] text-on-surface-variant uppercase tracking-wider">Total Volume / Pallet</span><span class="block mt-1 font-mono font-bold text-primary text-base">{{ $selectedProduct->pcs_per_pallet }} pieces</span></div>
                        </div>

                        <div class="gap-6 grid grid-cols-1 md:grid-cols-2 text-xs">
                            <div class="space-y-1.5 bg-white p-5 border rounded-2xl">
                                <h4 class="font-bold text-primary uppercase tracking-wide select-none">Minimum Order Bounds (MOQ)</h4>
                                <p class="font-medium text-on-surface-variant leading-relaxed">{{ $selectedProduct->overall_moqs ?? 'Not Explicitly Stated' }}</p>
                            </div>
                            <div class="space-y-1.5 bg-white p-5 border rounded-2xl">
                                <h4 class="font-bold text-primary uppercase tracking-wide select-none">Pricing Framework Layout</h4>
                                <p class="font-medium text-on-surface-variant leading-relaxed">{{ $selectedProduct->pricing_structure_type ?? 'Standard Unit Listing Price' }}</p>
                            </div>
                            <div class="space-y-1.5 md:col-span-2 bg-white p-5 border rounded-2xl">
                                <h4 class="font-bold text-primary uppercase tracking-wide select-none">Full Truckload (FTL) Freight Carriers Constraints</h4>
                                <p class="font-medium text-on-surface-variant leading-relaxed">{{ $selectedProduct->full_truckload_details ?? 'No special cross-border heavy dispatch constraint records saved.' }}</p>
                            </div>
                            <div class="space-y-1.5 md:col-span-2 bg-white p-5 border rounded-2xl">
                                <h4 class="font-bold text-primary uppercase tracking-wide select-none">Corporate Payment Terms & Escrow Schedule Conditions</h4>
                                <p class="bg-surface-container-low/50 p-3 border border-dashed rounded-xl font-medium text-on-surface-variant leading-relaxed whitespace-pre-line">{{ $selectedProduct->payment_terms ?? 'Standard administrative baseline procurement guidelines apply.' }}</p>
                            </div>
                        </div>
                    </div>

                    <div x-show="modalActiveTab === 'specs_gallery'" x-cloak class="animate-fadeIn">
                        @if(filled($selectedProduct->product_images))
                            <div class="gap-4 grid grid-cols-2 sm:grid-cols-4">
                                @foreach($selectedProduct->product_images as $imgLink)
                                    <div class="group/admin_img relative flex justify-center items-center bg-white shadow-sm border rounded-2xl border-outline-variant/40 aspect-square overflow-hidden select-none">
                                        <img alt="Catalog Media Object Scan Asset" src="{{ asset('storage/' . $imgLink) }}" class="w-full h-full object-cover">
                                        <a href="{{ asset('storage/' . $imgLink) }}" target="_blank" class="absolute inset-0 flex justify-center items-center bg-primary/40 opacity-0 group-hover/admin_img:opacity-100 text-white transition-opacity cursor-pointer select-none">
                                            <span class="text-[22px] material-symbols-outlined">open_in_new</span>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-white p-12 border border-dashed rounded-3xl text-on-surface-variant/60 text-xs text-center italic select-none">
                                <span class="block mb-1 text-outline text-[36px] material-symbols-outlined">image_not_supported</span>
                                This catalog index listing was registered via bulk sheet uploads without visual product snapshots arrays.
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex justify-between items-center bg-white p-6 border-t border-outline-variant select-none">
                    <span class="flex items-center gap-1 font-semibold text-on-surface-variant/80 text-xs"><span class="text-[16px] material-symbols-outlined">calendar_today</span> Audit logged on {{ $selectedProduct->created_at->format('M d, Y H:i') }}</span>
                    <button type="button" @click="marketModalOpen = false; document.body.classList.remove('overflow-hidden'); $wire.call('closeModal')" class="bg-surface-container-high hover:bg-surface-container px-6 py-2.5 rounded-xl font-bold text-on-surface-variant text-xs cursor-pointer">
                        Dismiss Inspector
                    </button>
                </div>

            </div>
        @endif
    </div>

</div>
