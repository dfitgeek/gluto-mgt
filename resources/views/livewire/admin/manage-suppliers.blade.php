<div>
    <main class="flex min-h-screen flex-1 flex-col">
        
        <div class="p-gutter mx-auto w-full flex-1">
            
            <div class="mb-stack-sm">
                <h2 class="font-headline-lg text-headline-lg text-primary mb-6 font-bold">Manage Suppliers</h2>
                <div class="bg-surface-container-low flex w-fit items-center gap-1 rounded-2xl p-1">
                    <button wire:click="setStatusFilter('Verified Supplier')"
                        class="px-6 py-2.5 rounded-xl font-label-md text-label-md transition-all cursor-pointer {{ $statusFilter === 'Verified Supplier' ? 'bg-white shadow-sm text-primary font-bold' : 'text-on-surface-variant hover:bg-white/50' }}">
                        Verified Suppliers
                    </button>
                    <button wire:click="setStatusFilter('Unverified Supplier')"
                        class="px-6 py-2.5 rounded-xl font-label-md text-label-md transition-all cursor-pointer {{ $statusFilter === 'Unverified Supplier' ? 'bg-white shadow-sm text-primary font-bold' : 'text-on-surface-variant hover:bg-white/50' }}">
                        Unverified Suppliers
                    </button>
                </div>
            </div>

            <header class="bg-surface dark:bg-surface-dim my-[10px] rounded-2xl shadow-[0px_4px_20px_rgba(6,78,59,0.05)]"
                wire:key="global-search-toolbar-wrapper">
                <div class="px-container-padding mx-auto flex h-20 w-full max-w-[1440px] items-center">
            
                    <form wire:submit.prevent="performSearch" class="flex w-full flex-col items-center gap-3 md:flex-row">
                        <div class="relative block flex-1">
                            <span
                                class="text-on-surface-variant material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2">search</span>
            
                            <input wire:model="search"
                                class="bg-surface-container-low focus:ring-primary font-body-sm text-body-sm w-full rounded-xl border-none py-3 pl-12 pr-4 shadow-inner outline-none focus:ring-2"
                                placeholder="Search global corporate profiles repository..." type="text">
                        </div>
            
                        <button type="submit"
                            class="bg-primary hover:bg-primary/95 font-label-md flex cursor-pointer items-center gap-2 whitespace-nowrap rounded-xl px-6 py-3 text-xs font-bold text-white shadow-md transition-all">
                            <span>Search Directory</span>
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </button>
                    </form>
            
                </div>   </header>

                @if(filled($search))
                    <div
                        class="bg-surface-container-low border-outline-variant/40 text-on-surface-variant animate-fadeIn mb-4 flex items-center justify-between rounded-xl border p-4 text-xs font-medium">
                        <div class="flex items-center gap-2">
                            <span class="text-primary material-symbols-outlined text-[18px]">manage_search</span>
                            <span>Showing global matching directory results for "<strong class="text-primary">{{ $search }}</strong>" across
                                both Verified and Unverified entries.</span>
                        </div>
                        <button type="button" wire:click="$set('search', '')"
                            class="text-primary ml-4 cursor-pointer font-bold hover:underline">Clear Filters</button>
                    </div>
                @endif
            
            <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse($suppliers as $supplier)
                    <div wire:key="supplier-card-{{ $supplier->id }}"
                        class="group shadow-sm hover:shadow-md p-6 border-l-4 {{ $supplier->status_label === 'Verified Supplier' ? 'border-l-emerald-500' : 'border-l-amber-500' }} rounded-2xl transition-all bg-white flex flex-col justify-between">
                        
                        <div>
                            <div class="mb-4 flex items-start justify-between">
                                <div class="bg-surface-container flex h-16 w-16 items-center justify-center overflow-hidden rounded-xl shadow-inner">
                                    @if($supplier->company_icon_path)
                                        <img alt="{{ $supplier->company_name }} Logo" src="{{ asset('storage/' . $supplier->company_icon_path) }}" class="h-full w-full object-cover">
                                    @else
                                        <span class="text-outline material-symbols-outlined text-[28px]">business</span>
                                    @endif
                                </div>
                                <span class="px-3 py-1 rounded-full font-bold text-[10px] uppercase tracking-wider {{ $supplier->status_label === 'Verified Supplier' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                    {{ $supplier->status_label === 'Verified Supplier' ? 'Verified' : 'Unverified' }}
                                </span>
                            </div>

                            <div class="mb-6 space-y-3">
                                <h3 class="font-headline-md text-headline-md text-primary truncate text-lg font-bold">{{ $supplier->company_name }}</h3>
                                <div class="space-y-1">
                                    <p class="text-body-sm text-on-surface-variant flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[18px]">verified</span>
                                        Reg: {{ $supplier->reg_number }}
                                    </p>
                                    <p class="text-body-sm text-on-surface-variant flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[18px]">tag</span>
                                        Ref: {{ $supplier->supplier_ref_number }}
                                    </p>
                                    <p class="text-body-sm text-on-surface-variant flex items-center gap-2 truncate">
                                        <span class="material-symbols-outlined text-[18px]">mail</span>
                                        {{ $supplier->email_address }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <button wire:click="loadSupplierDetails({{ $supplier->id }})"
                            class="bg-primary hover:bg-primary/90 font-label-md text-label-md flex w-full cursor-pointer items-center justify-center gap-2 rounded-2xl py-3 text-white transition-all group-hover:gap-3">
                            View Full Profile
                            <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                        </button>
                    </div>
                @empty
                    <div class="bg-surface-container-lowest border-outline-variant/60 font-body-sm text-on-surface-variant col-span-1 rounded-3xl border border-dashed p-12 text-center md:col-span-2 lg:col-span-3">
                        <span class="text-outline material-symbols-outlined mb-2 text-[48px]">inventory</span>
                        <p>No records matched your search parameters.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>

    <div class="fixed inset-0 z-[100] flex hidden items-center justify-center bg-black/40 p-4 opacity-0 backdrop-blur-sm transition-opacity duration-300 sm:p-6 md:p-8"
        id="modalBackdrop" wire:ignore.self>
    
        @if($selectedSupplier)
                                                                                <div class="flex max-h-[calc(100vh-4rem)] w-full max-w-5xl scale-95 flex-col overflow-hidden rounded-[2rem] bg-white shadow-2xl transition-transform duration-300"
                                                                                    id="modalContainer">

                                                                                    <div class="flex justify-between items-center {{ $selectedSupplier->status_label === 'Verified Supplier' ? 'bg-emerald-700' : 'bg-primary' }} p-6 text-white transition-colors duration-300">
                                                                                        <div class="flex items-center gap-4">
                                                                                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/20">
                                                                                                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">store</span>
                                                                                            </div>
                                                                                            <div>
                                                                                                <h2 class="font-headline-md text-headline-md text-xl font-bold">{{ $selectedSupplier->company_name }}</h2>
                                                                                                <p class="text-sm font-medium text-white/80">Ref Number token: {{ $selectedSupplier->supplier_ref_number }}</p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <button class="cursor-pointer rounded-full p-2 transition-colors hover:bg-white/10" onclick="closeModal()">
                                                                                            <span class="material-symbols-outlined">close</span>
                                                                                        </button>
                                                                                    </div>

                                                                                    <div class="bg-background p-gutter hide-scrollbar flex-1 space-y-8 overflow-y-auto">

                                                                                        <section class="space-y-4">
                                                                                            <h3 class="font-headline-md text-primary flex items-center gap-2 font-bold">
                                                                                                <span class="material-symbols-outlined">account_circle</span> Representative & Contact Channels
                                                                                            </h3>
                                                                                            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                                                                                                <div class="border-outline-variant flex flex-col justify-between rounded-2xl border bg-white p-6 lg:col-span-1">
                                                                                                    <div class="flex flex-col items-center text-center">
                                                                                                        <div class="bg-surface-container border-secondary-container mb-4 flex h-20 w-20 items-center justify-center overflow-hidden rounded-full border-4">
                                                                                                            <span class="text-outline material-symbols-outlined text-[40px]">person</span>
                                                                                                        </div>
                                                                                                        <h4 class="font-headline-md text-primary text-base font-bold">{{ $selectedSupplier->rep_legal_name }}</h4>
                                                                                                        <p class="text-on-surface-variant text-xs">{{ $selectedSupplier->rep_position_title ?? 'Authorized Representative Agent' }}</p>
                                                                                                    </div>
                                                                                                    <div class="border-outline-variant/40 text-on-surface-variant mt-4 space-y-2.5 border-t pt-4 text-[13px]">
                                                                                                        <div class="flex items-center gap-3 truncate"><span class="text-secondary material-symbols-outlined text-[18px]">mail</span>{{ $selectedSupplier->rep_email }}</div>
                                                                                                        <div class="flex items-center gap-3"><span class="text-secondary material-symbols-outlined text-[18px]">call</span>{{ $selectedSupplier->rep_phone_number }}</div>
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:col-span-2">
                                                                                                    @if($selectedSupplier->whatsapp_contact)
                                                                                                        <div class="border-outline-variant/50 flex items-center justify-between rounded-xl border bg-white p-4">
                                                                                                            <span class="font-label-md flex items-center gap-2 text-sm"><span class="mdi mdi-whatsapp text-[#25D366]"></span> WhatsApp</span>
                                                                                                            <span class="text-on-surface-variant text-xs font-medium">{{ $selectedSupplier->whatsapp_contact }}</span>
                                                                                                        </div>
                                                                                                    @endif

                                                                                                    @php
    $socials = $selectedSupplier->social_media;

    // If the model casting failed and it's still a JSON string, decode it manually here
    if (is_string($socials)) {
        $socials = json_decode($socials, true);
    }
                                                                                                    @endphp

                                                                                                    @if(isset($socials['twitter']) && filled($socials['twitter']))
                                                                                                        <div class="border-outline-variant/50 flex items-center justify-between rounded-xl border bg-white p-4">
                                                                                                            <span class="font-label-md flex items-center gap-2 text-sm"><span class="mdi mdi-twitter text-[#1DA1F2]"></span> Twitter (X)</span>
                                                                                                            <span class="text-on-surface-variant text-xs font-medium">{{ $socials['twitter'] }}</span>
                                                                                                        </div>
                                                                                                    @endif

                                                                                                    @if(isset($socials['facebook']) && filled($socials['facebook']))
                                                                                                        <div class="border-outline-variant/50 flex items-center justify-between rounded-xl border bg-white p-4">
                                                                                                            <span class="font-label-md flex items-center gap-2 text-sm"><span class="mdi mdi-facebook text-[#4267B2]"></span> Facebook</span>
                                                                                                            <span class="text-on-surface-variant text-xs font-medium">{{ $socials['facebook'] }}</span>
                                                                                                        </div>
                                                                                                    @endif

                                                                                                    @if(isset($socials['instagram']) && filled($socials['instagram']))
                                                                                                        <div class="border-outline-variant/50 flex items-center justify-between rounded-xl border bg-white p-4">
                                                                                                            <span class="font-label-md flex items-center gap-2 text-sm"><span class="mdi mdi-instagram text-[#C13584]"></span> Instagram</span>
                                                                                                            <span class="text-on-surface-variant text-xs font-medium">{{ $socials['instagram'] }}</span>
                                                                                                        </div>
                                                                                                    @endif

                                                                                                    @if(isset($socials['threads']) && filled($socials['threads']))
                                                                                                        <div class="border-outline-variant/50 flex items-center justify-between rounded-xl border bg-white p-4">
                                                                                                            <span class="font-label-md flex items-center gap-2 text-sm"><span class="material-symbols-outlined text-[13px] text-black">alternate_email</span> Threads</span>
                                                                                                            <span class="text-on-surface-variant text-xs font-medium">{{ $socials['threads'] }}</span>
                                                                                                        </div>
                                                                                                    @endif

                                                                                                    @if(isset($socials['linkedin']) && filled($socials['linkedin']))
                                                                                                        <div class="border-outline-variant/50 flex items-center justify-between rounded-xl border bg-white p-4">
                                                                                                            <span class="font-label-md flex items-center gap-2 text-sm"><span class="mdi mdi-linkedin text-[#0077B5]"></span> LinkedIn</span>
                                                                                                            <span class="text-on-surface-variant text-xs font-medium">{{ $socials['linkedin'] }}</span>
                                                                                                        </div>
                                                                                                    @endif
                                                                                                </div>
                                                                                            </div>
                                                                                        </section>

                                                                                        <section class="space-y-4">
                                                                                            <h3 class="font-headline-md text-primary flex items-center gap-2 font-bold">
                                                                                                <span class="material-symbols-outlined">business</span> Business Core Parameters
                                                                                            </h3>
                                                                                            <div class="border-outline-variant grid grid-cols-1 overflow-hidden rounded-2xl border bg-white md:grid-cols-2">
                                                                                                <div class="border-outline-variant space-y-4 border-b p-6 md:border-b-0 md:border-r">
                                                                                                    <div>
                                                                                                        <p class="text-label-sm text-on-surface-variant text-xs font-semibold uppercase tracking-wide">Product Categorization</p>
                                                                                                        <p class="text-body-md text-primary mt-0.5 font-bold">{{ $selectedSupplier->categorization_of_products ?? 'Not Categorized' }}</p>
                                                                                                    </div>
                                                                                                    <div>
                                                                                                        <p class="text-label-sm text-on-surface-variant text-xs font-semibold uppercase tracking-wide">Minimum Order Quantities (MOQs)</p>
                                                                                                        <p class="text-body-md text-primary mt-0.5 font-medium">{{ $selectedSupplier->overall_moqs ?? 'No Fixed Parameters Specified' }}</p>
                                                                                                    </div>
                                                                                                    <div>
                                                                                                        <p class="text-label-sm text-on-surface-variant text-xs font-semibold uppercase tracking-wide">Monthly Production Capacity</p>
                                                                                                        <p class="text-body-md text-primary mt-0.5 font-medium">{{ $selectedSupplier->production_capacity ?? 'Unreported Sizing Output Metrics' }}</p>
                                                                                                    </div>
                                                                                                    <div>
                                                                                                        <p class="text-label-sm text-on-surface-variant text-xs font-semibold uppercase tracking-wide">Shipping Methods Available</p>
                                                                                                        <p class="text-body-md text-primary mt-0.5 font-medium">{{ $selectedSupplier->shipping_methods_available ?? 'Logistics Carrier Options Pending' }}</p>
                                                                                                    </div>
                                                                                                    <div>
                                                                                                        <p class="text-label-sm text-on-surface-variant text-xs font-semibold uppercase tracking-wide">Pricing Structure Configuration Type</p>
                                                                                                        <p class="text-body-md text-primary mt-0.5 font-medium">{{ $selectedSupplier->pricing_structure_type ?? 'Default Standard Catalog Rates' }}</p>
                                                                                                    </div>
                                                                                                    <div class="bg-background border-outline-variant/30 flex items-center justify-between rounded-xl border p-3">
                                                                                                        <span class="text-on-surface-variant text-xs font-semibold">Able to Provide Product Samples:</span>
                                                                                                        <span class="px-2.5 py-1 text-[11px] font-bold uppercase rounded-md {{ $selectedSupplier->ability_to_provide_samples ? 'bg-emerald-100 text-emerald-800' : 'bg-surface-container-high text-on-surface-variant' }}">
                                                                                                            {{ $selectedSupplier->ability_to_provide_samples ? 'YES' : 'NO' }}
                                                                                                        </span>
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="bg-surface-container-lowest/20 flex flex-col justify-between space-y-4 p-6">
                                                                                                    <div>
                                                                                                        <p class="text-label-sm text-on-surface-variant text-xs font-semibold uppercase tracking-wide">Registered Company Addresses</p>
                                                                                                        <p class="text-primary mt-1 text-sm font-medium leading-relaxed">{{ $selectedSupplier->address }}</p>
                                                                                                    </div>
                                                                                                    <div>
                                                                                                        <p class="text-label-sm text-on-surface-variant text-xs font-semibold uppercase tracking-wide">Manufacturing Locations (Plants & Warehouses)</p>
                                                                                                        <p class="text-primary mt-1 text-sm font-medium leading-relaxed">{{ $selectedSupplier->manufacturing_locations ?? 'No separate production site tracks reported' }}</p>
                                                                                                    </div>
                                                                                                    <div class="border-outline-variant/40 border-t pt-3">
                                                                                                        <p class="text-label-sm text-on-surface-variant text-xs font-semibold uppercase tracking-wide">Primary Lead Board Directors</p>
                                                                                                        @if($selectedSupplier->names_of_board_directors)
                                                                                                            <div class="mt-1 flex items-center justify-between rounded-xl border bg-white p-3 text-xs">
                                                                                                                <div class="flex flex-col"><span class="text-primary font-bold">{{ $selectedSupplier->names_of_board_directors }}</span><span class="text-on-surface-variant/80">{{ $selectedSupplier->director_email }}</span></div>
                                                                                                                <span class="bg-secondary-container text-on-secondary-container rounded px-2 py-0.5 text-[10px] font-bold uppercase">{{ $selectedSupplier->director_position_title ?? 'Board Member' }}</span>
                                                                                                            </div>
                                                                                                        @else
                                                                                                            <p class="text-on-surface-variant mt-1 text-xs italic">No execution directorship logs recorded.</p>
                                                                                                        @endif
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </section>

                                                                                        <section class="space-y-4">
                                                                                            <h3 class="font-headline-md text-primary flex items-center gap-2 font-bold">
                                                                                                <span class="material-symbols-outlined">gavel</span> Compliance Standards & Legal Affirmations
                                                                                            </h3>
                                                                                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-4">

                                                                                                <div class="p-4 rounded-xl border flex items-center gap-3 bg-white {{ $selectedSupplier->declares_gmo_free ? 'border-emerald-200 bg-emerald-50/20' : 'border-outline-variant/60 opacity-60' }}">
                                                                                                    <span class="material-symbols-outlined text-[20px] {{ $selectedSupplier->declares_gmo_free ? 'text-emerald-600' : 'text-outline' }}">
                                                                                                        {{ $selectedSupplier->declares_gmo_free ? 'verified' : 'circle' }}
                                                                                                    </span>
                                                                                                    <span class="text-primary text-xs font-bold">GMO Free Certified</span>
                                                                                                </div>

                                                                                                <div class="p-4 rounded-xl border flex items-center gap-3 bg-white {{ $selectedSupplier->declares_gluten_free ? 'border-emerald-200 bg-emerald-50/20' : 'border-outline-variant/60 opacity-60' }}">
                                                                                                    <span class="material-symbols-outlined text-[20px] {{ $selectedSupplier->declares_gluten_free ? 'text-emerald-600' : 'text-outline' }}">
                                                                                                        {{ $selectedSupplier->declares_gluten_free ? 'verified' : 'circle' }}
                                                                                                    </span>
                                                                                                    <span class="text-primary text-xs font-bold">Gluten-Free Ingredients</span>
                                                                                                </div>

                                                                                                <div class="p-4 rounded-xl border flex items-center gap-3 bg-white {{ $selectedSupplier->declares_non_irradiated ? 'border-emerald-200 bg-emerald-50/20' : 'border-outline-variant/60 opacity-60' }}">
                                                                                                    <span class="material-symbols-outlined text-[20px] {{ $selectedSupplier->declares_non_irradiated ? 'text-emerald-600' : 'text-outline' }}">
                                                                                                        {{ $selectedSupplier->declares_non_irradiated ? 'verified' : 'circle' }}
                                                                                                    </span>
                                                                                                    <span class="text-primary text-xs font-bold">Non-Irradiated Process</span>
                                                                                                </div>

                                                                                                <div class="p-4 rounded-xl border flex items-center gap-3 bg-white {{ $selectedSupplier->complies_haccp_gmp ? 'border-emerald-200 bg-emerald-50/20' : 'border-outline-variant/60 opacity-60' }}">
                                                                                                    <span class="material-symbols-outlined text-[20px] {{ $selectedSupplier->complies_haccp_gmp ? 'text-emerald-600' : 'text-outline' }}">
                                                                                                        {{ $selectedSupplier->complies_haccp_gmp ? 'verified' : 'circle' }}
                                                                                                    </span>
                                                                                                    <span class="text-primary text-xs font-bold">HACCP / GMP Architecture</span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </section>

                                                                                        <section class="space-y-4">
                                                                                            <h3 class="font-headline-md text-primary flex items-center gap-2 font-bold">
                                                                                                <span class="material-symbols-outlined">inventory_2</span> Onboarding Attachments Vault
                                                                                            </h3>
                                                                                            <div class="grid grid-cols-2 gap-4 sm:grid-cols-4 lg:grid-cols-4">
                                                                                                @php
    $fullVaultMap = [
        'file_sales_contract' => 'Sales Contract',
        'file_commercial_invoice' => 'Commercial Invoice',
        'file_packing_list' => 'Packing List',
        'file_product_spec_sheet' => 'Product Spec Sheet',
        'file_test_analysis_report' => 'Test Analysis Report',
        'product_manufacturing_certifications' => 'Manufacturing Cert',
        'returns_warranty_policy' => 'Returns Policy Doc'
    ];
                                                                                                @endphp

                                                                                                @foreach($fullVaultMap as $field => $label)
                                                                                                    <div class="flex flex-col items-center justify-between bg-white p-4 border rounded-xl border-outline-variant text-center min-h-[100px] {{ $selectedSupplier->$field ? 'border-primary/30 shadow-sm' : 'opacity-40 grayscale bg-background/50' }}">
                                                                                                        @if($selectedSupplier->$field)
                                                                                                            <span class="material-symbols-outlined text-[22px] text-emerald-600" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                                                                                            @if(Str::contains($selectedSupplier->$field, ['/', '.']))
                                                                                                                <a href="{{ asset('storage/' . $selectedSupplier->$field) }}" target="_blank" class="text-primary mt-1 block text-[11px] font-bold leading-tight hover:underline">{{ $label }}</a>
                                                                                                            @else
                                                                                                                <button type="button" @click="alert('Plain Text Entry Found:\n\n' + '{{ addslashes($selectedSupplier->$field) }}')" class="text-primary mt-1 block text-[11px] font-bold leading-tight hover:underline">{{ $label }} (Text View)</button>
                                                                                                            @endif
                                                                                                        @else
                                                                                                            <span class="text-outline material-symbols-outlined text-[22px]">pending</span>
                                                                                                            <span class="text-on-surface-variant mt-1 block text-[11px] font-medium leading-tight">{{ $label }}</span>
                                                                                                        @endif
                                                                                                    </div>
                                                                                                @endforeach
                                                                                            </div>
                                                                                        </section>

                                                                                        <section class="border-outline-variant/40 grid grid-cols-1 gap-6 border-t pt-6 md:grid-cols-3">

                                                                                            <div class="border-outline-variant/60 space-y-3 rounded-2xl border bg-white p-5 md:col-span-2">
                                                                                                <h4 class="font-label-md text-primary flex items-center gap-1 text-sm font-bold"><span class="material-symbols-outlined text-[18px]">analytics</span> Secure Audit Management Logs</h4>
                                                                                                <div class="grid grid-cols-1 gap-4 pt-1 text-xs sm:grid-cols-2">
                                                                                                    <div>
                                                                                                        <span class="text-on-surface-variant/80 block font-semibold">Account Manager assigned:</span>
                                                                                                        <span class="text-primary mt-0.5 block text-sm font-bold">{{ $selectedSupplier->assigned_manager ?? 'Unassigned Internal Queue' }}</span>
                                                                                                    </div>
                                                                                                    <div>
                                                                                                        <span class="text-on-surface-variant/80 block font-semibold">Onboarding Route Origin:</span>
                                                                                                        <span class="text-primary mt-0.5 block text-sm font-medium">{{ $selectedSupplier->lead_source ?? 'Direct Portal Entry' }}</span>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="border-outline-variant/60 flex flex-col justify-between rounded-2xl border bg-white p-5">
                                                                                                <div class="space-y-1">
                                                                                                    <h4 class="font-label-md text-primary flex items-center gap-1 text-sm font-bold"><span class="material-symbols-outlined text-[18px]">draw</span> Sign-off Execution</h4>
                                                                                                    <p class="text-primary pt-1 text-xs font-bold">{{ $selectedSupplier->declaration_authorized_person ?? 'No Name Signed' }}</p>
                                                                                                    <p class="text-on-surface-variant text-[11px] leading-tight">{{ $selectedSupplier->declaration_title ?? 'Title Unreported' }}</p>
                                                                                                </div>

                                                                                                <div class="bg-background border-outline-variant/60 mt-3 flex h-16 items-center justify-center overflow-hidden rounded-xl border border-dashed p-1">
                                                                                                    @if($selectedSupplier->declaration_signature_path)
                                                                                                        <img alt="Signature Authorization Graphic Copy" src="{{ asset('storage/' . $selectedSupplier->declaration_signature_path) }}" class="max-h-full max-w-full object-contain filter dark:invert">
                                                                                                    @else
                                                                                                        <span class="text-on-surface-variant/60 text-[11px] font-medium italic">Signature missing</span>
                                                                                                    @endif
                                                                                                </div>
                                                                                            </div>
                                                                                        </section>
                                                                                    </div>

                                                                                    <div class="border-outline-variant flex flex-col items-center justify-between gap-4 border-t bg-white p-6 sm:flex-row">
                                                                                        <div class="text-label-sm text-on-surface-variant flex items-center gap-2 text-xs font-medium">
                                                                                            <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                                                                                            Cataloged profile on {{ $selectedSupplier->created_at->format('F d, Y') }}
                                                                                        </div>

                                                                                        <div class="flex w-full items-center gap-3 sm:w-auto">
                                                                                            <button type="button" wire:click="toggleVerification({{ $selectedSupplier->id }})"
                                                                                                class="flex justify-center items-center gap-2 shadow-sm px-6 py-3 rounded-xl w-full sm:w-auto font-label-md text-xs font-bold transition-all duration-300 cursor-pointer {{ $selectedSupplier->status_label === 'Verified Supplier' ? 'bg-emerald-600 hover:bg-emerald-700 text-white' : 'bg-surface-container-high hover:bg-surface-container-highest border border-outline text-on-surface' }}">
                                                                                                <span>{{ $selectedSupplier->status_label === 'Verified Supplier' ? 'Unverify Supplier' : 'Verify Supplier' }}</span>
                                                                                                <span class="material-symbols-outlined text-[18px]">
                                                                                                    {{ $selectedSupplier->status_label === 'Verified Supplier' ? 'cancel' : 'verified' }}
                                                                                                </span>
                                                                                            </button>


                                                                                            <button
                                                                                                class="bg-secondary hover:bg-secondary/90 font-label-md text-on-secondary flex w-full cursor-pointer items-center justify-center gap-2 rounded-xl px-6 py-3 text-xs font-bold shadow-sm transition-all sm:w-auto">
                                                                                                Supplier Tracker Notes
                                                                                                <span class="material-symbols-outlined text-[18px]">note_stack</span>
                                                                                            </button>

                                                                                            <button class="bg-secondary hover:bg-secondary/90 font-label-md text-on-secondary flex w-full cursor-pointer items-center justify-center gap-2 rounded-xl px-6 py-3 text-xs font-bold shadow-sm transition-all sm:w-auto">
                                                                                                View Supplier Products
                                                                                                <span class="material-symbols-outlined text-[18px]">inventory_2</span>
                                                                                            </button>


                                                                                        </div>
                                                                                    </div>
                                                                                </div>
        @endif
    </div>

    {{-- <a href="{{ route('admin.suppliers.create') }}" wire:navigate
        class="bg-primary group fixed bottom-8 right-8 z-40 flex h-16 w-16 items-center justify-center rounded-full text-white shadow-[0px_10px_32px_rgba(0,0,0,0.15)] transition-all hover:scale-110 active:scale-95">
        <span class="material-symbols-outlined text-[32px] transition-transform duration-300 group-hover:rotate-90">add</span>
    </a> --}}

    <script>
        const backdrop = document.getElementById('modalBackdrop');
        let container = null;

        window.addEventListener('open-supplier-modal', () => {
            backdrop.classList.remove('hidden');
            setTimeout(() => {
                container = document.getElementById('modalContainer');
                backdrop.classList.add('opacity-100');
                if(container) {
                    container.classList.remove('scale-95');
                    container.classList.add('scale-100');
                }
            }, 15);
            document.body.classList.add('overflow-hidden');
        });

        function closeModal() {
            backdrop.classList.remove('opacity-100');
            if(container) {
                container.classList.remove('scale-100');
                container.classList.add('scale-95');
            }
            setTimeout(() => {
                backdrop.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                @this.call('closeModal'); 
            }, 250);
        }

        window.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });
        backdrop.addEventListener('click', (e) => { if (e.target === backdrop) closeModal(); });
    </script>
</div>