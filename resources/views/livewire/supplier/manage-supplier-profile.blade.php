<div class="p-gutter mx-auto my-2 w-full max-w-[1440px] flex-1" x-data="{ profileTab: 'identity' }">

    <div class="border-outline-variant/30 mb-6 flex flex-col justify-between gap-4 border-b pb-4 sm:flex-row sm:items-center">
        <div>
            <h2 class="font-headline-lg text-headline-lg text-primary text-2xl font-bold">Supplier Profile Settings</h2>
            <p class="font-body-sm text-on-surface-variant mt-0.5 text-sm">Manage your legal entity identities, authorized representatives coordinates, and account security verification credentials.</p>
        </div>

        <div class="bg-surface-container border-outline-variant/20 text-on-surface-variant flex w-fit select-none rounded-xl border p-1 text-xs font-bold">
            <button type="button" @click="profileTab = 'identity'" class="cursor-pointer rounded-lg px-4 py-2 transition-all" :class="profileTab === 'identity' ? 'bg-white text-primary shadow-sm' : 'hover:text-primary'"><span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">business</span> Corporate Info</span></button>
            <button type="button" @click="profileTab = 'terms'" class="cursor-pointer rounded-lg px-4 py-2 transition-all" :class="profileTab === 'terms' ? 'bg-white text-primary shadow-sm' : 'hover:text-primary'"><span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">local_shipping</span> Capabilities</span></button>
            <button type="button" @click="profileTab = 'compliance'" class="cursor-pointer rounded-lg px-4 py-2 transition-all" :class="profileTab === 'compliance' ? 'bg-white text-primary shadow-sm' : 'hover:text-primary'"><span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">gavel</span> Declarations</span></button>
            <button type="button" @click="profileTab = 'security'" class="cursor-pointer rounded-lg px-4 py-2 transition-all" :class="profileTab === 'security' ? 'bg-white text-primary shadow-sm' : 'hover:text-primary'"><span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">lock</span> Password & Security</span></button>
        </div>
    </div>

    @if(session()->has('success'))
        <div class="animate-fadeIn mb-6 flex items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-xs font-semibold text-emerald-800">
            <span class="material-symbols-outlined text-[18px]">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div x-show="profileTab === 'identity'" class="animate-fadeIn space-y-6">
        <form wire:submit.prevent="updateProfile" class="space-y-6">
            
            <div class="border-outline-variant/40 space-y-6 rounded-[2rem] border bg-white p-8 shadow-sm">
                <h3 class="font-headline-md text-primary border-background flex items-center gap-2 border-b pb-2.5 text-base font-bold">
                    <span class="material-symbols-outlined">corporate_fare</span> 1. Company Information & Brand Assets
                </h3>

                <div class="grid grid-cols-1 gap-6 text-sm md:grid-cols-3">
                    <div class="bg-surface-container-low/40 border-outline-variant/80 flex w-full items-center gap-5 rounded-xl border border-dashed p-4 md:col-span-3">
                        <div class="bg-surface-container relative flex h-16 w-16 flex-shrink-0 items-center justify-center overflow-hidden rounded-xl border shadow-inner">
                            @if($new_company_icon)
                                <img src="{{ $new_company_icon->temporaryUrl() }}" class="h-full w-full object-cover">
                            @elseif($current_icon_path)
                                <img src="{{ asset('storage/' . $current_icon_path) }}" class="h-full w-full object-cover">
                            @else
                                <span class="text-outline material-symbols-outlined text-[24px]">business</span>
                            @endif
                        </div>
                        <div class="space-y-1">
                            <label class="font-label-md text-primary block cursor-pointer">
                                <span class="bg-primary hover:bg-primary/95 inline-block rounded-xl px-4 py-1.5 text-xs font-bold text-white shadow-sm transition-all">Replace Brand Logo Icon</span>
                                <input type="file" wire:model="new_company_icon" class="hidden" accept="image/*">
                            </label>
                            <p class="text-on-surface-variant text-[10px]">Accepts PNG, JPG formats up to 2MB. Dynamic real-time previewing active hooks loops.</p>
                            @error('new_company_icon') <span class="animate-fadeIn block text-xs font-bold text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Legal Corporate Name *</label>
                        <input type="text" wire:model.defer="company_name" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2 font-medium outline-none focus:bg-white">
                        @error('company_name') <span class="animate-fadeIn block pl-0.5 text-xs font-medium text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Registration Number *</label>
                        <input type="text" wire:model.defer="reg_number" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2 font-medium outline-none focus:bg-white">
                        @error('reg_number') <span class="animate-fadeIn block pl-0.5 text-xs font-medium text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Year Established</label>
                        <input type="number" wire:model.defer="year_established" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2 font-medium outline-none focus:bg-white" placeholder="YYYY">
                        @error('year_established') <span class="animate-fadeIn block pl-0.5 text-xs font-medium text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Corporate Email Address *</label>
                        <input type="email" wire:model.defer="email_address" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2 font-medium outline-none focus:bg-white">
                        @error('email_address') <span class="animate-fadeIn block pl-0.5 text-xs font-medium text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Telephone Number *</label>
                        <input type="text" wire:model.defer="phone_telephone" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2 font-medium outline-none focus:bg-white">
                        @error('phone_telephone') <span class="animate-fadeIn block pl-0.5 text-xs font-medium text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">WhatsApp Direct Contact Coordinate</label>
                        <input type="text" wire:model.defer="whatsapp_contact" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2 font-medium outline-none focus:bg-white">
                    </div>
                    <div class="space-y-1">
                        <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Type of Business Structure *</label>
                        <select wire:model.defer="type_of_business" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2 font-medium outline-none focus:bg-white">
                            <option value="Manufacturer">Manufacturer</option>
                            <option value="Wholesaler">Wholesaler</option>
                            <option value="Distributor">Distributor</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Nature of Sourcing Operation *</label>
                        <input type="text" wire:model.defer="nature_of_business" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2 font-medium outline-none focus:bg-white">
                    </div>
                    <div class="space-y-1">
                        <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Website URL Domain Link</label>
                        <input type="text" wire:model.defer="website" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2 font-medium outline-none focus:bg-white" placeholder="https://www.company.com">
                        @error('website') <span class="animate-fadeIn block pl-0.5 text-xs font-medium text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1 md:col-span-3">
                        <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Registered Physical Address Location *</label>
                        <textarea wire:model.defer="address" rows="2" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2 font-medium outline-none focus:bg-white"></textarea>
                        @error('address') <span class="animate-fadeIn block pl-0.5 text-xs font-medium text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="border-outline-variant/50 space-y-4 border-t border-dashed pt-4">
                    <h4 class="text-primary flex items-center gap-1 text-xs font-bold uppercase tracking-wide"><span class="material-symbols-outlined text-[16px]">groups</span> Board Directors Representation</h4>
                    <div class="grid grid-cols-1 gap-6 text-sm md:grid-cols-3">
                        <div class="space-y-1">
                            <label class="text-on-surface-variant block pl-0.5 text-xs font-semibold">Names of Executive Board Directors</label>
                            <input type="text" wire:model.defer="names_of_board_directors" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2 font-medium outline-none focus:bg-white">
                        </div>
                        <div class="space-y-1">
                            <label class="text-on-surface-variant block pl-0.5 text-xs font-semibold">Director Position Title</label>
                            <input type="text" wire:model.defer="director_position_title" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2 font-medium outline-none focus:bg-white">
                        </div>
                        <div class="space-y-1">
                            <label class="text-on-surface-variant block pl-0.5 text-xs font-semibold">Director Communication Email</label>
                            <input type="email" wire:model.defer="director_email" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2 font-medium outline-none focus:bg-white">
                        </div>
                    </div>
                </div>

                <div class="border-outline-variant/50 space-y-3 border-t border-dashed pt-4">
                    <h4 class="text-primary flex items-center gap-1 text-xs font-bold uppercase tracking-wide"><span class="material-symbols-outlined text-[16px]">share</span> Corporate Social Presences Handles</h4>
                    <div class="grid grid-cols-2 gap-3 text-xs sm:grid-cols-5">
                        <div><label class="text-on-surface-variant mb-1 block pl-0.5">X (Twitter)</label><input type="text" wire:model.defer="social_twitter" class="bg-surface-container-low w-full rounded-xl border p-2 font-medium outline-none"></div>
                        <div><label class="text-on-surface-variant mb-1 block pl-0.5">Facebook</label><input type="text" wire:model.defer="social_facebook" class="bg-surface-container-low w-full rounded-xl border p-2 font-medium outline-none"></div>
                        <div><label class="text-on-surface-variant mb-1 block pl-0.5">Instagram</label><input type="text" wire:model.defer="social_instagram" class="bg-surface-container-low w-full rounded-xl border p-2 font-medium outline-none"></div>
                        <div><label class="text-on-surface-variant mb-1 block pl-0.5">Threads</label><input type="text" wire:model.defer="social_threads" class="bg-surface-container-low w-full rounded-xl border p-2 font-medium outline-none"></div>
                        <div><label class="text-on-surface-variant mb-1 block pl-0.5">LinkedIn</label><input type="text" wire:model.defer="social_linkedin" class="bg-surface-container-low w-full rounded-xl border p-2 font-medium outline-none"></div>
                    </div>
                </div>
            </div>

            <div class="border-outline-variant/40 space-y-6 rounded-[2rem] border bg-white p-8 shadow-sm">
                <h3 class="font-headline-md text-primary border-background flex items-center gap-2 border-b pb-2.5 text-base font-bold">
                    <span class="material-symbols-outlined">badge</span> 2. Authorized Account Representative Details
                </h3>

                <div class="grid grid-cols-1 gap-6 text-sm md:grid-cols-2">
                    <div class="space-y-1">
                        <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Legal Representative Full Name *</label>
                        <input type="text" wire:model.defer="rep_legal_name" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2 font-medium outline-none focus:bg-white">
                        @error('rep_legal_name') <span class="animate-fadeIn block pl-0.5 text-xs font-medium text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Official Sourcing Role / Title *</label>
                        <input type="text" wire:model.defer="rep_position_title" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2 font-medium outline-none focus:bg-white">
                        @error('rep_position_title') <span class="animate-fadeIn block pl-0.5 text-xs font-medium text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Direct Core Communications Email (Used for Login Gateway Authentication) *</label>
                        <input type="email" wire:model.defer="rep_email" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2 font-medium outline-none focus:bg-white">
                        @error('rep_email') <span class="animate-fadeIn block pl-0.5 text-xs font-medium text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Direct Phone Mobile Number *</label>
                        <input type="text" wire:model.defer="rep_phone_number" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2 font-medium outline-none focus:bg-white">
                        @error('rep_phone_number') <span class="animate-fadeIn block pl-0.5 text-xs font-medium text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="bg-surface-container-low border-outline-variant/40 flex items-center justify-between rounded-2xl border p-5 shadow-inner">
                <span class="text-on-surface-variant/80 font-mono text-xs">System Protocol Token ID: {{ $supplier_ref_number }}</span>
                <button type="submit" wire:loading.attr="disabled" class="bg-primary hover:bg-primary/95 font-label-md cursor-pointer rounded-xl px-8 py-3 text-xs font-bold text-white shadow-md transition-all active:scale-95">
                    <span wire:loading.remove>Commit General Updates</span>
                    <span wire:loading class="flex animate-pulse items-center gap-1.5"><span class="inline-block h-3.5 w-3.5 animate-spin rounded-full border-2 border-white border-t-transparent"></span> Processing updates...</span>
                </button>
            </div>
        </form>
    </div>

    <div x-show="profileTab === 'terms'" x-cloak class="animate-fadeIn space-y-6">
        <form wire:submit.prevent="updateProfile" class="space-y-6">
            <div class="border-outline-variant/40 space-y-6 rounded-[2rem] border bg-white p-8 shadow-sm">
                <h3 class="font-headline-md text-primary border-background flex items-center gap-2 border-b pb-2.5 text-base font-bold">
                    <span class="material-symbols-outlined">assignment_turned_in</span> 3. Capabilities, Logistical Parameters & Commercial Terms
                </h3>

                <div class="grid grid-cols-1 gap-6 text-sm md:grid-cols-3">
                    <div class="space-y-1">
                        <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Product Categorization Range</label>
                        <input type="text" wire:model.defer="categorization_of_products" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2 font-medium outline-none focus:bg-white" placeholder="e.g., Dried Goods, Packaged Spices FMCG">
                    </div>
                    <div class="space-y-1">
                        <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Overall Minimum Order Quantities (MOQs)</label>
                        <input type="text" wire:model.defer="overall_moqs" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2 font-medium outline-none focus:bg-white">
                    </div>
                    <div class="space-y-1">
                        <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Monthly Sourcing Production Capacity</label>
                        <input type="text" wire:model.defer="production_capacity" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2 font-medium outline-none focus:bg-white">
                    </div>
                    <div class="space-y-1">
                        <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Pricing Structure Core Type</label>
                        <input type="text" wire:model.defer="pricing_structure_type" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2 font-medium outline-none focus:bg-white" placeholder="e.g., Bulk Volume Tier Rates">
                    </div>
                    <div class="space-y-1">
                        <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Baseline Settled Currency Accepted</label>
                        <input type="text" wire:model.defer="currency_accepted" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2 font-medium outline-none focus:bg-white">
                    </div>
                    <div class="space-y-1">
                        <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Shipping Freight Methods Available</label>
                        <input type="text" wire:model.defer="shipping_methods_available" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2 font-medium outline-none focus:bg-white" placeholder="e.g., Overland Cargo, Air Freight">
                    </div>

                    <div class="bg-surface-container-low/40 flex select-none items-center gap-3 rounded-xl border border-dashed p-4 px-4 md:col-span-3">
                        <input type="checkbox" wire:model="ability_to_provide_samples" id="terms_samples_toggle" class="text-primary h-4 w-4 cursor-pointer rounded">
                        <label for="terms_samples_toggle" class="text-on-surface-variant cursor-pointer text-xs font-semibold">Our manufacturing facilities are fully authorized and capable of dispersing physical sample lots to corporate buyers</label>
                    </div>

                    <div class="space-y-1 md:col-span-3">
                        <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Manufacturing Assembly Plants / Warehouses Locations Details</label>
                        <textarea wire:model.defer="manufacturing_locations" rows="2" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2 font-medium outline-none focus:bg-white" placeholder="Provide geographical addresses coordinates of assembly lines..."></textarea>
                    </div>
                    <div class="space-y-1 md:col-span-3">
                        <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Customization, Tailoring & OEM Capability Options Description</label>
                        <textarea wire:model.defer="customization_options" rows="2" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2 font-medium outline-none focus:bg-white" placeholder="Specify capacity limits for private white-labeling requests..."></textarea>
                    </div>
                    <div class="space-y-1 md:col-span-3">
                        <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Standard Contract Payment Terms Framework Description</label>
                        <textarea wire:model.defer="payment_terms" rows="2" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2 font-medium outline-none focus:bg-white" placeholder="e.g., 30% Advance TT Deposit, 70% against full maritime shipping document copies scans..."></textarea>
                    </div>
                </div>
            </div>

            <div class="bg-surface-container-low border-outline-variant/40 flex justify-end rounded-2xl border p-5 shadow-inner">
                <button type="submit" wire:loading.attr="disabled" class="bg-primary hover:bg-primary/95 font-label-md cursor-pointer rounded-xl px-8 py-3 text-xs font-bold text-white shadow-md transition-all active:scale-95">
                    <span wire:loading.remove>Commit Commercial Terms</span>
                    <span wire:loading class="flex animate-pulse items-center gap-1.5"><span class="inline-block h-3.5 w-3.5 animate-spin rounded-full border-2 border-white border-t-transparent"></span> Syncing terms...</span>
                </button>
            </div>
        </form>
    </div>

    <div x-show="profileTab === 'compliance'" x-cloak class="animate-fadeIn space-y-6">
        <form wire:submit.prevent="updateProfile" class="space-y-6">
            <div class="border-outline-variant/40 space-y-6 rounded-[2rem] border bg-white p-8 shadow-sm">
                <h3 class="font-headline-md text-primary border-background flex items-center gap-2 border-b pb-2.5 text-base font-bold">
                    <span class="material-symbols-outlined">gavel</span> 4. Compliance Affidavits, Assurances & Declarations Status
                </h3>
                <p class="text-on-surface-variant/80 -mt-3 pl-0.5 text-xs">Toggle the active operational checkboxes matching your legal auditing sign-off structures. These choices directly affect your automated matrix lookup filtering score within the client buyer database repository queries.</p>

                <div class="grid grid-cols-1 gap-4 text-xs md:grid-cols-2">
                    <label class="bg-surface-container-low/40 hover:bg-surface-container-low border-outline-variant/60 flex cursor-pointer select-none items-center gap-3 rounded-xl border p-4 transition-all">
                        <input type="checkbox" wire:model="declares_gmo_free" class="text-primary h-4 w-4 cursor-pointer rounded">
                        <span class="text-primary font-bold">GMO Free Certification Compliance Guaranteed</span>
                    </label>
                    <label class="bg-surface-container-low/40 hover:bg-surface-container-low border-outline-variant/60 flex cursor-pointer select-none items-center gap-3 rounded-xl border p-4 transition-all">
                        <input type="checkbox" wire:model="declares_gluten_free" class="text-primary h-4 w-4 cursor-pointer rounded">
                        <span class="text-primary font-bold">Gluten-Free Facility Formulation Verification Assurance</span>
                    </label>
                    <label class="bg-surface-container-low/40 hover:bg-surface-container-low border-outline-variant/60 flex cursor-pointer select-none items-center gap-3 rounded-xl border p-4 transition-all">
                        <input type="checkbox" wire:model="declares_non_irradiated" class="text-primary h-4 w-4 cursor-pointer rounded">
                        <span class="text-primary font-bold">Non-Irradiated / Non-Ionised Process Method Affirmation</span>
                    </label>
                    <label class="bg-surface-container-low/40 hover:bg-surface-container-low border-outline-variant/60 flex cursor-pointer select-none items-center gap-3 rounded-xl border p-4 transition-all">
                        <input type="checkbox" wire:model="declares_no_nanomaterials" class="text-primary h-4 w-4 cursor-pointer rounded">
                        <span class="text-primary font-bold">Zero Synthetic Engineered Nanomaterials Declaration</span>
                    </label>
                    <label class="bg-surface-container-low/40 hover:bg-surface-container-low border-outline-variant/60 flex cursor-pointer select-none items-center gap-3 rounded-xl border p-4 transition-all md:col-span-2">
                        <input type="checkbox" wire:model="complies_haccp_gmp" class="text-primary h-4 w-4 cursor-pointer rounded">
                        <span class="text-primary font-bold">Active Active Certification Program under global HACCP / GMP Quality Architecture controls</span>
                    </label>
                </div>
            </div>

            <div class="bg-surface-container-low border-outline-variant/40 flex justify-end rounded-2xl border p-5 shadow-inner">
                <button type="submit" wire:loading.attr="disabled" class="bg-primary hover:bg-primary/95 font-label-md cursor-pointer rounded-xl px-8 py-3 text-xs font-bold text-white shadow-md transition-all active:scale-95">
                    Commit Affidavits Stand
                </button>
            </div>
        </form>
    </div>

    <div x-show="profileTab === 'security'" x-cloak class="animate-fadeIn space-y-6">
        <form wire:submit.prevent="updateSecurityPassword" class="space-y-6">
            <div class="border-outline-variant/40 space-y-6 rounded-[2rem] border bg-white p-8 shadow-sm">
                <h3 class="font-headline-md text-primary border-background flex items-center gap-2 border-b pb-2.5 text-base font-bold">
                    <span class="material-symbols-outlined">lock_reset</span> 5. Security Access Matrix (Rotate Account Password)
                </h3>
                <p class="text-on-surface-variant/80 -mt-3 pl-0.5 text-xs">Rotate your cryptographic access security token string regularly. Changing your password updates validation sessions across all active active endpoints instantly.</p>

                <div class="grid max-w-4xl grid-cols-1 gap-6 text-sm md:grid-cols-3">
                    <div class="space-y-1">
                        <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Current Account Password *</label>
                        <input type="password" wire:model.defer="current_password" class="bg-surface-container-low border-outline-variant w-full rounded-xl border p-2.5 outline-none focus:bg-white">
                        @error('current_password') <span class="animate-fadeIn block pl-0.5 text-xs font-medium text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="text-primary block pl-0.5 text-xs font-bold">New Security Password *</label>
                        <input type="password" wire:model.defer="new_password" class="bg-surface-container-low border-outline-variant w-full rounded-xl border p-2.5 outline-none focus:bg-white" placeholder="Minimum 8 elements">
                        @error('new_password') <span class="animate-fadeIn block pl-0.5 text-xs font-medium text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="text-primary block pl-0.5 text-xs font-bold">Confirm New Security Password *</label>
                        <input type="password" wire:model.defer="new_password_confirmation" class="bg-surface-container-low border-outline-variant w-full rounded-xl border p-2.5 outline-none focus:bg-white" placeholder="Re-type string key">
                    </div>
                </div>
            </div>

            <div class="bg-surface-container-low border-outline-variant/40 flex select-none items-center justify-between rounded-2xl border p-5 shadow-inner">
                <div class="text-on-surface-variant flex items-center gap-2 text-xs font-semibold">
                    <span class="material-symbols-outlined text-[16px] text-amber-600">security_alert</span>
                    <span>Modifying this will terminate secondary active session cookies frames logs on submission.</span>
                </div>
                <button type="submit" wire:loading.attr="disabled" class="bg-primary hover:bg-primary/95 font-label-md cursor-pointer rounded-xl px-8 py-3 text-xs font-bold text-white shadow-md transition-all active:scale-95">
                    <span wire:loading.remove>Rotate Login Token</span>
                    <span wire:loading class="animate-pulse"><span class="mr-1 inline-block h-3 w-3 animate-spin rounded-full border-2 border-white border-t-transparent"></span> Processing security patch...</span>
                </button>
            </div>
        </form>
    </div>

</div>