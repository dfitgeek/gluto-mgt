<div>
    <main class="flex flex-col flex-1 min-h-screen">
        
        <div class="flex-1 mx-auto p-gutter w-full">
            
            <div class="mb-stack-sm">
                <h2 class="mb-6 font-headline-lg font-bold text-headline-lg text-primary">Manage Suppliers</h2>
                <div class="flex items-center gap-1 bg-surface-container-low p-1 rounded-2xl w-fit">
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

            <header class="bg-surface dark:bg-surface-dim shadow-[0px_4px_20px_rgba(6,78,59,0.05)] my-[10px] rounded-2xl" wire:key="global-search-toolbar-wrapper">
                <div class="flex items-center mx-auto px-container-padding w-full max-w-[1440px] h-20">
                    <form wire:submit.prevent="performSearch" class="flex md:flex-row flex-col items-center gap-3 w-full">
                        <div class="block relative flex-1">
                            <span class="top-1/2 left-4 absolute text-on-surface-variant -translate-y-1/2 material-symbols-outlined">search</span>
                            <input wire:model="search" class="bg-surface-container-low shadow-inner py-3 pr-4 pl-12 border-none rounded-xl outline-none focus:ring-2 focus:ring-primary w-full font-body-sm text-body-sm" placeholder="Search global corporate profiles repository..." type="text">
                        </div>
                        <button type="submit" class="flex items-center gap-2 bg-primary hover:bg-primary/95 shadow-md px-6 py-3 rounded-xl font-label-md font-bold text-white text-xs whitespace-nowrap transition-all cursor-pointer">
                            <span>Search Directory</span>
                            <span class="text-[16px] material-symbols-outlined">arrow_forward</span>
                        </button>
                    </form>
                </div>
            </header>

            @if(filled($search))
                <div class="flex justify-between items-center bg-surface-container-low mb-4 p-4 border rounded-xl border-outline-variant/40 font-medium text-on-surface-variant text-xs animate-fadeIn">
                    <div class="flex items-center gap-2">
                        <span class="text-[18px] text-primary material-symbols-outlined">manage_search</span>
                        <span>Showing global matching directory results for "<strong class="text-primary">{{ $search }}</strong>" across both Verified and Unverified entries.</span>
                    </div>
                    <button type="button" wire:click="$set('search', '')" class="ml-4 font-bold text-primary hover:underline cursor-pointer">Clear Filters</button>
                </div>
            @endif
            
            <div class="gap-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 mt-6">
                @forelse($suppliers as $supplier)
                    <div wire:key="supplier-card-{{ $supplier->id }}" class="group shadow-sm hover:shadow-md p-6 border-l-4 {{ $supplier->status_label === 'Verified Supplier' ? 'border-l-emerald-500' : 'border-l-amber-500' }} rounded-2xl transition-all bg-white flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex justify-center items-center bg-surface-container shadow-inner rounded-xl w-16 h-16 overflow-hidden">
                                    @if($supplier->company_icon_path)
                                        <img alt="{{ $supplier->company_name }} Logo" src="{{ asset('storage/' . $supplier->company_icon_path) }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-outline text-[28px] material-symbols-outlined">business</span>
                                    @endif
                                </div>
                                <span class="px-3 py-1 rounded-full font-bold text-[10px] uppercase tracking-wider {{ $supplier->status_label === 'Verified Supplier' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                    {{ $supplier->status_label === 'Verified Supplier' ? 'Verified' : 'Unverified' }}
                                </span>
                            </div>

                            <div class="space-y-3 mb-6">
                                <h3 class="font-headline-md font-bold text-headline-md text-primary text-lg truncate">{{ $supplier->company_name }}</h3>
                                <div class="space-y-1">
                                    <p class="flex items-center gap-2 text-body-sm text-on-surface-variant"><span class="text-[18px] material-symbols-outlined">verified</span>Reg: {{ $supplier->reg_number }}</p>
                                    <p class="flex items-center gap-2 text-body-sm text-on-surface-variant"><span class="text-[18px] material-symbols-outlined">tag</span>Ref: {{ $supplier->supplier_ref_number }}</p>
                                    <p class="flex items-center gap-2 text-body-sm text-on-surface-variant truncate"><span class="text-[18px] material-symbols-outlined">mail</span>{{ $supplier->email_address }}</p>
                                </div>
                            </div>
                        </div>

                        <button wire:click="loadSupplierDetails({{ $supplier->id }})" class="flex justify-center items-center gap-2 group-hover:gap-3 bg-primary hover:bg-primary/90 py-3 rounded-2xl w-full font-label-md text-label-md text-white transition-all cursor-pointer">
                            View Full Profile <span class="text-[20px] material-symbols-outlined">arrow_forward</span>
                        </button>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 bg-surface-container-lowest p-12 border border-dashed rounded-3xl border-outline-variant/60 font-body-sm text-on-surface-variant text-center">
                        <span class="mb-2 text-outline text-[48px] material-symbols-outlined">inventory</span>
                        <p>No records matched your search parameters.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>

    <div class="hidden z-[100] fixed inset-0 flex justify-center items-center bg-black/40 opacity-0 backdrop-blur-sm p-4 sm:p-6 md:p-8 transition-opacity duration-300" id="modalBackdrop" wire:ignore.self>
    
        @if($selectedSupplier)
                            <div class="flex flex-col bg-white shadow-2xl rounded-[2rem] w-full max-w-5xl max-h-[calc(100vh-4rem)] overflow-hidden scale-95 transition-transform duration-300" id="modalContainer">

                                <div class="flex justify-between items-center {{ $selectedSupplier->status_label === 'Verified Supplier' ? 'bg-emerald-700' : 'bg-primary' }} p-6 text-white transition-colors duration-300">
                                    <div class="flex items-center gap-4">
                                        <div class="flex justify-center items-center bg-white/20 rounded-xl w-12 h-12">
                                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">store</span>
                                        </div>
                                        <div>
                                            <h2 class="font-headline-md font-bold text-headline-md text-xl">{{ $selectedSupplier->company_name }}</h2>
                                            <p class="font-medium text-white/80 text-sm">Ref Number token: {{ $selectedSupplier->supplier_ref_number }}</p>
                                        </div>
                                    </div>
                                    <button class="hover:bg-white/10 p-2 rounded-full transition-colors cursor-pointer" onclick="closeModal()">
                                        <span class="material-symbols-outlined">close</span>
                                    </button>
                                </div>

                                <div class="flex-1 space-y-8 bg-background p-gutter overflow-y-auto hide-scrollbar">

                                    <section class="space-y-4">
                                        <h3 class="flex items-center gap-2 font-headline-md font-bold text-primary">
                                            <span class="material-symbols-outlined">account_circle</span> Representative & Contact Channels
                                        </h3>
                                        <div class="gap-6 grid grid-cols-1 lg:grid-cols-3">
                                            <div class="flex flex-col justify-between lg:col-span-1 bg-white p-6 border rounded-2xl border-outline-variant">
                                                <div class="flex flex-col items-center text-center">
                                                    <div class="flex justify-center items-center bg-surface-container mb-4 border-4 border-secondary-container rounded-full w-20 h-20 overflow-hidden">
                                                        <span class="text-outline text-[40px] material-symbols-outlined">person</span>
                                                    </div>
                                                    <h4 class="font-headline-md font-bold text-primary text-base">{{ $selectedSupplier->rep_legal_name }}</h4>
                                                    <p class="text-on-surface-variant text-xs">{{ $selectedSupplier->rep_position_title ?? 'Authorized Representative Agent' }}</p>
                                                </div>
                                                <div class="space-y-2.5 mt-4 pt-4 border-t border-outline-variant/40 text-[13px] text-on-surface-variant">
                                                    <div class="flex items-center gap-3 truncate"><span class="text-[18px] text-secondary material-symbols-outlined">mail</span>{{ $selectedSupplier->rep_email }}</div>
                                                    <div class="flex items-center gap-3"><span class="text-[18px] text-secondary material-symbols-outlined">call</span>{{ $selectedSupplier->rep_phone_number }}</div>
                                                </div>
                                            </div>

                                            <div class="gap-4 grid grid-cols-1 sm:grid-cols-2 lg:col-span-2">
                                                @if($selectedSupplier->whatsapp_contact)
                                                    <div class="flex justify-between items-center bg-white p-4 border rounded-xl border-outline-variant/50">
                                                        <span class="flex items-center gap-2 font-label-md text-sm"><span class="text-[#25D366] material-symbols-outlined">chat</span> WhatsApp</span>
                                                        <span class="font-medium text-on-surface-variant text-xs">{{ $selectedSupplier->whatsapp_contact }}</span>
                                                    </div>
                                                @endif

                                                @php
            $socials = $selectedSupplier->social_media;
            if (is_string($socials)) {
                $socials = json_decode($socials, true);
            }
                                                @endphp

                                                @if(isset($socials['twitter']) && filled($socials['twitter']))
                                                    <div class="flex justify-between items-center bg-white p-4 border rounded-xl border-outline-variant/50">
                                                        <span class="flex items-center gap-2 font-label-md text-sm"><span class="text-[#1DA1F2] material-symbols-outlined">share</span> Twitter (X)</span>
                                                        <span class="font-medium text-on-surface-variant text-xs">{{ $socials['twitter'] }}</span>
                                                    </div>
                                                @endif

                                                @if(isset($socials['facebook']) && filled($socials['facebook']))
                                                    <div class="flex justify-between items-center bg-white p-4 border rounded-xl border-outline-variant/50">
                                                        <span class="flex items-center gap-2 font-label-md text-sm"><span class="text-[#4267B2] material-symbols-outlined">public</span> Facebook</span>
                                                        <span class="font-medium text-on-surface-variant text-xs">{{ $socials['facebook'] }}</span>
                                                    </div>
                                                @endif

                                                @if(isset($socials['instagram']) && filled($socials['instagram']))
                                                    <div class="flex justify-between items-center bg-white p-4 border rounded-xl border-outline-variant/50">
                                                        <span class="flex items-center gap-2 font-label-md text-sm"><span class="text-[#C13584] material-symbols-outlined">photo_camera</span> Instagram</span>
                                                        <span class="font-medium text-on-surface-variant text-xs">{{ $socials['instagram'] }}</span>
                                                    </div>
                                                @endif

                                                @if(isset($socials['threads']) && filled($socials['threads']))
                                                    <div class="flex justify-between items-center bg-white p-4 border rounded-xl border-outline-variant/50">
                                                        <span class="flex items-center gap-2 font-label-md text-sm"><span class="text-[13px] text-black material-symbols-outlined">alternate_email</span> Threads</span>
                                                        <span class="font-medium text-on-surface-variant text-xs">{{ $socials['threads'] }}</span>
                                                    </div>
                                                @endif

                                                @if(isset($socials['linkedin']) && filled($socials['linkedin']))
                                                    <div class="flex justify-between items-center bg-white p-4 border rounded-xl border-outline-variant/50">
                                                        <span class="flex items-center gap-2 font-label-md text-sm"><span class="text-[#0077B5] material-symbols-outlined">link</span> LinkedIn</span>
                                                        <span class="font-medium text-on-surface-variant text-xs">{{ $socials['linkedin'] }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </section>

                                    <section class="space-y-4">
                                        <h3 class="flex items-center gap-2 font-headline-md font-bold text-primary">
                                            <span class="material-symbols-outlined">business</span> Business Core Parameters
                                        </h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 bg-white border rounded-2xl border-outline-variant overflow-hidden">
                                            <div class="space-y-4 p-6 md:border-r border-b md:border-b-0 border-outline-variant">
                                                <div>
                                                    <p class="font-semibold text-label-sm text-on-surface-variant text-xs uppercase tracking-wide">Product Categorization</p>
                                                    <p class="mt-0.5 font-bold text-body-md text-primary">{{ $selectedSupplier->categorization_of_products ?? 'Not Categorized' }}</p>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-label-sm text-on-surface-variant text-xs uppercase tracking-wide">Minimum Order Quantities (MOQs)</p>
                                                    <p class="mt-0.5 font-medium text-body-md text-primary">{{ $selectedSupplier->overall_moqs ?? 'No Fixed Parameters Specified' }}</p>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-label-sm text-on-surface-variant text-xs uppercase tracking-wide">Monthly Production Capacity</p>
                                                    <p class="mt-0.5 font-medium text-body-md text-primary">{{ $selectedSupplier->production_capacity ?? 'Unreported Sizing Output Metrics' }}</p>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-label-sm text-on-surface-variant text-xs uppercase tracking-wide">Shipping Methods Available</p>
                                                    <p class="mt-0.5 font-medium text-body-md text-primary">{{ $selectedSupplier->shipping_methods_available ?? 'Logistics Carrier Options Pending' }}</p>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-label-sm text-on-surface-variant text-xs uppercase tracking-wide">Pricing Structure Configuration Type</p>
                                                    <p class="mt-0.5 font-medium text-body-md text-primary">{{ $selectedSupplier->pricing_structure_type ?? 'Default Standard Catalog Rates' }}</p>
                                                </div>
                                                <div class="flex justify-between items-center bg-background p-3 border rounded-xl border-outline-variant/30">
                                                    <span class="font-semibold text-on-surface-variant text-xs">Able to Provide Product Samples:</span>
                                                    <span class="px-2.5 py-1 text-[11px] font-bold uppercase rounded-md {{ $selectedSupplier->ability_to_provide_samples ? 'bg-emerald-100 text-emerald-800' : 'bg-surface-container-high text-on-surface-variant' }}">
                                                        {{ $selectedSupplier->ability_to_provide_samples ? 'YES' : 'NO' }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="flex flex-col justify-between space-y-4 bg-surface-container-lowest/20 p-6">
                                                <div>
                                                    <p class="font-semibold text-label-sm text-on-surface-variant text-xs uppercase tracking-wide">Registered Company Addresses</p>
                                                    <p class="mt-1 font-medium text-primary text-sm leading-relaxed">{{ $selectedSupplier->address }}</p>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-label-sm text-on-surface-variant text-xs uppercase tracking-wide">Manufacturing Locations (Plants & Warehouses)</p>
                                                    <p class="mt-1 font-medium text-primary text-sm leading-relaxed">{{ $selectedSupplier->manufacturing_locations ?? 'No separate production site tracks reported' }}</p>
                                                </div>
                                                <div class="pt-3 border-t border-outline-variant/40">
                                                    <p class="font-semibold text-label-sm text-on-surface-variant text-xs uppercase tracking-wide">Primary Lead Board Directors</p>
                                                    @if($selectedSupplier->names_of_board_directors)
                                                        <div class="flex justify-between items-center bg-white mt-1 p-3 border rounded-xl text-xs">
                                                            <div class="flex flex-col"><span class="font-bold text-primary">{{ $selectedSupplier->names_of_board_directors }}</span><span class="text-on-surface-variant/80">{{ $selectedSupplier->director_email }}</span></div>
                                                            <span class="bg-secondary-container px-2 py-0.5 rounded font-bold text-[10px] text-on-secondary-container uppercase">{{ $selectedSupplier->director_position_title ?? 'Board Member' }}</span>
                                                        </div>
                                                    @else
                                                        <p class="mt-1 text-on-surface-variant text-xs italic">No execution directorship logs recorded.</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                    <section class="space-y-4">
                                        <h3 class="flex items-center gap-2 font-headline-md font-bold text-primary">
                                            <span class="material-symbols-outlined">gavel</span> Compliance Standards & Legal Affirmations
                                        </h3>
                                        <div class="gap-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4">
                                            <div class="p-4 rounded-xl border flex items-center gap-3 bg-white {{ $selectedSupplier->declares_gmo_free ? 'border-emerald-200 bg-emerald-50/20' : 'border-outline-variant/60 opacity-60' }}">
                                                <span class="material-symbols-outlined text-[20px] {{ $selectedSupplier->declares_gmo_free ? 'text-emerald-600' : 'text-outline' }}">{{ $selectedSupplier->declares_gmo_free ? 'verified' : 'circle' }}</span>
                                                <span class="font-bold text-primary text-xs">GMO Free Certified</span>
                                            </div>
                                            <div class="p-4 rounded-xl border flex items-center gap-3 bg-white {{ $selectedSupplier->declares_gluten_free ? 'border-emerald-200 bg-emerald-50/20' : 'border-outline-variant/60 opacity-60' }}">
                                                <span class="material-symbols-outlined text-[20px] {{ $selectedSupplier->declares_gluten_free ? 'text-emerald-600' : 'text-outline' }}">{{ $selectedSupplier->declares_gluten_free ? 'verified' : 'circle' }}</span>
                                                <span class="font-bold text-primary text-xs">Gluten-Free Ingredients</span>
                                            </div>
                                            <div class="p-4 rounded-xl border flex items-center gap-3 bg-white {{ $selectedSupplier->declares_non_irradiated ? 'border-emerald-200 bg-emerald-50/20' : 'border-outline-variant/60 opacity-60' }}">
                                                <span class="material-symbols-outlined text-[20px] {{ $selectedSupplier->declares_non_irradiated ? 'text-emerald-600' : 'text-outline' }}">{{ $selectedSupplier->declares_non_irradiated ? 'verified' : 'circle' }}</span>
                                                <span class="font-bold text-primary text-xs">Non-Irradiated Process</span>
                                            </div>
                                            <div class="p-4 rounded-xl border flex items-center gap-3 bg-white {{ $selectedSupplier->complies_haccp_gmp ? 'border-emerald-200 bg-emerald-50/20' : 'border-outline-variant/60 opacity-60' }}">
                                                <span class="material-symbols-outlined text-[20px] {{ $selectedSupplier->complies_haccp_gmp ? 'text-emerald-600' : 'text-outline' }}">{{ $selectedSupplier->complies_haccp_gmp ? 'verified' : 'circle' }}</span>
                                                <span class="font-bold text-primary text-xs">HACCP / GMP Architecture</span>
                                            </div>
                                        </div>
                                    </section>

                                    <section class="space-y-4">
                                        <h3 class="flex items-center gap-2 font-headline-md font-bold text-primary">
                                            <span class="material-symbols-outlined">folder_open</span> Step 4: Corporate File Library & Product Allocations
                                        </h3>

                                        <div class="gap-6 grid grid-cols-1 md:grid-cols-2">
                                            @php
            $vaultFieldsList = [
                'file_sales_contract' => ['label' => 'Sales Contract', 'icon' => 'gavel'],
                'file_commercial_invoice' => ['label' => 'Commercial Invoice', 'icon' => 'receipt_long'],
                'file_packing_list' => ['label' => 'Packing List', 'icon' => 'inventory_2'],
                'file_product_spec_sheet' => ['label' => 'Product Spec Sheet', 'icon' => 'assignment'],
                'file_test_analysis_report' => ['label' => 'Test Analysis Report', 'icon' => 'biotech'],
                'product_manufacturing_certifications' => ['label' => 'Manufacturing Certifications', 'icon' => 'workspace_premium'],
                'returns_warranty_policy' => ['label' => 'Returns & Warranty Policy', 'icon' => 'assignment_return'],
                'file_others' => ['label' => 'Supplementary/Other files', 'icon' => 'note_add'],
                'supplier_invoice' => ['label' => 'Supplier Invoice', 'icon' => 'account_balance_wallet'],
                'proforma_invoice' => ['label' => 'Proforma Invoice Document', 'icon' => 'request_quote'],
            ];
                                            @endphp

                                            @foreach($vaultFieldsList as $columnName => $meta)
                                                <div class="flex flex-col justify-between space-y-3 bg-white p-4 border rounded-2xl border-outline-variant">
                                                    <div class="flex items-center gap-2 pb-2 border-background border-b">
                                                        <span class="text-[20px] text-primary material-symbols-outlined">{{ $meta['icon'] }}</span>
                                                        <h4 class="font-bold text-primary text-xs">{{ $meta['label'] }}</h4>
                                                    </div>

                                                    <div class="flex-1 space-y-2">
                                                        @php $filesArray = $selectedSupplier->$columnName; @endphp

                                                        @if(filled($filesArray) && is_array($filesArray))
                                                            @foreach($filesArray as $documentNode)
                                                                <div class="flex justify-between items-center bg-surface-container-low p-2.5 border rounded-xl border-outline-variant/30 text-xs">
                                                                    <a href="{{ asset('storage/' . $documentNode['file_path']) }}" target="_blank" class="flex items-center gap-1.5 max-w-[240px] font-bold text-primary hover:underline truncate">
                                                                        <span class="text-[16px] text-emerald-600 material-symbols-outlined">download_for_offline</span>
                                                                        <span>Download File Asset</span>
                                                                    </a>

                                                                    @if(!empty($documentNode['product_ref']))
                                                                        <span class="bg-secondary-container px-2 py-0.5 border border-secondary/20 rounded font-mono font-bold text-[10px] text-on-secondary-container">
                                                                            Ref: {{ $documentNode['product_ref'] }}
                                                                        </span>
                                                                    @else
                                                                        <span class="bg-surface-container-high px-2 py-0.5 rounded font-sans font-semibold text-[10px] text-on-surface-variant">
                                                                            Global Profile
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <div class="flex items-center gap-2 bg-background/50 p-3 border border-dashed rounded-xl text-on-surface-variant/60 text-xs italic">
                                                                <span class="text-[16px] material-symbols-outlined">rule</span>
                                                                <span>No attachments cataloged under this file track.</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </section>

                                    <section class="gap-6 grid grid-cols-1 md:grid-cols-3 pt-6 border-t border-outline-variant/40">
                                        <div class="space-y-3 md:col-span-2 bg-white p-5 border rounded-2xl border-outline-variant/60">
                                            <h4 class="flex items-center gap-1 font-label-md font-bold text-primary text-sm"><span class="text-[18px] material-symbols-outlined">analytics</span> Secure Audit Management Logs</h4>
                                            <div class="gap-4 grid grid-cols-1 sm:grid-cols-2 pt-1 text-xs">
                                                <div>
                                                    <span class="block font-semibold text-on-surface-variant/80">Account Manager assigned:</span>
                                                    <span class="block mt-0.5 font-bold text-primary text-sm">{{ $selectedSupplier->assigned_manager ?? 'Unassigned Internal Queue' }}</span>
                                                </div>
                                                <div>
                                                    <span class="block font-semibold text-on-surface-variant/80">Onboarding Route Origin:</span>
                                                    <span class="block mt-0.5 font-medium text-primary text-sm">{{ $selectedSupplier->lead_source ?? 'Direct Portal Entry' }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex flex-col justify-between bg-white p-5 border rounded-2xl border-outline-variant/60">
                                            <div class="space-y-1">
                                                <h4 class="flex items-center gap-1 font-label-md font-bold text-primary text-sm"><span class="text-[18px] material-symbols-outlined">draw</span> Sign-off Execution</h4>
                                                <p class="pt-1 font-bold text-primary text-xs">{{ $selectedSupplier->declaration_authorized_person ?? 'No Name Signed' }}</p>
                                                <p class="text-[11px] text-on-surface-variant leading-tight">{{ $selectedSupplier->declaration_title ?? 'Title Unreported' }}</p>
                                            </div>
                                            <div class="flex justify-center items-center bg-background mt-3 p-1 border border-dashed rounded-xl border-outline-variant/60 h-16 overflow-hidden">
                                                @if($selectedSupplier->declaration_signature_path)
                                                    <img alt="Signature Authorization Graphic Copy" src="{{ asset('storage/' . $selectedSupplier->declaration_signature_path) }}" class="dark:invert max-w-full max-h-full object-contain filter">
                                                @else
                                                    <span class="font-medium text-[11px] text-on-surface-variant/60 italic">Signature missing</span>
                                                @endif
                                            </div>
                                        </div>
                                    </section>
                                </div>

                                <div class="flex sm:flex-row flex-col justify-between items-center gap-4 bg-white p-6 border-t border-outline-variant">
                                    <div class="flex items-center gap-2 font-medium text-label-sm text-on-surface-variant text-xs">
                                        <span class="text-[18px] material-symbols-outlined">calendar_today</span>
                                        Cataloged profile on {{ $selectedSupplier->created_at->format('F d, Y') }}
                                    </div>

                                    <div class="flex items-center gap-3 w-full sm:w-auto">
                                        <button type="button" wire:click="toggleVerification({{ $selectedSupplier->id }})"
                                            class="flex justify-center items-center gap-2 shadow-sm px-6 py-3 rounded-xl w-full sm:w-auto font-label-md text-xs font-bold transition-all duration-300 cursor-pointer {{ $selectedSupplier->status_label === 'Verified Supplier' ? 'bg-emerald-600 hover:bg-emerald-700 text-white' : 'bg-surface-container-high hover:bg-surface-container-highest border border-outline text-on-surface' }}">
                                            <span>{{ $selectedSupplier->status_label === 'Verified Supplier' ? 'Unverify Supplier' : 'Verify Supplier' }}</span>
                                            <span class="text-[18px] material-symbols-outlined">
                                                {{ $selectedSupplier->status_label === 'Verified Supplier' ? 'cancel' : 'verified' }}
                                            </span>
                                        </button>

                                        <a href="{{ route('admin.suppliers.track', ['id' => $selectedSupplier->id]) }}" wire:navigate
                                            class="flex justify-center items-center gap-2 bg-secondary hover:bg-secondary/90 shadow-sm px-6 py-3 rounded-xl w-full sm:w-auto font-label-md font-bold text-on-secondary text-xs text-center transition-all cursor-pointer">
                                            Supplier Tracker Notes <span class="text-[18px] material-symbols-outlined">note_stack</span>                             </a>

                                        
                                        <a href="{{ route('admin.suppliers.products', ['id' => $selectedSupplier->id]) }}" wire:navigate
                                            class="flex justify-center items-center gap-2 bg-secondary hover:bg-secondary/90 shadow-sm px-6 py-3 rounded-xl w-full sm:w-auto font-label-md font-bold text-on-secondary text-xs text-center transition-all cursor-pointer">
                                            View Supplier Products <span class="text-[18px] material-symbols-outlined">inventory_2</span>                     </a>
                                    </div>
                                </div>
                            </div>
        @endif
    </div>

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