<div class="flex-1 mx-auto my-2 p-gutter w-full max-w-[1440px]" x-data="{ profileTab: 'identity' }">

    <div class="flex sm:flex-row flex-col justify-between sm:items-center gap-4 mb-6 pb-4 border-b border-outline-variant/30">
        <div>
            <h2 class="font-headline-lg font-bold text-headline-lg text-primary text-2xl">Supplier Profile Settings</h2>
            <p class="mt-0.5 font-body-sm text-on-surface-variant text-sm">Manage your legal entity identities, authorized representatives coordinates, and account security verification credentials.</p>
        </div>

        <div class="flex bg-surface-container p-1 border rounded-xl border-outline-variant/20 w-fit font-bold text-on-surface-variant text-xs select-none">
            <button type="button" @click="profileTab = 'identity'" class="px-4 py-2 rounded-lg transition-all cursor-pointer" :class="profileTab === 'identity' ? 'bg-white text-primary shadow-sm' : 'hover:text-primary'"><span class="flex items-center gap-1"><span class="text-[16px] material-symbols-outlined">business</span> Corporate Info</span></button>
            <button type="button" @click="profileTab = 'terms'" class="px-4 py-2 rounded-lg transition-all cursor-pointer" :class="profileTab === 'terms' ? 'bg-white text-primary shadow-sm' : 'hover:text-primary'"><span class="flex items-center gap-1"><span class="text-[16px] material-symbols-outlined">local_shipping</span> Capabilities</span></button>
            <button type="button" @click="profileTab = 'compliance'" class="px-4 py-2 rounded-lg transition-all cursor-pointer" :class="profileTab === 'compliance' ? 'bg-white text-primary shadow-sm' : 'hover:text-primary'"><span class="flex items-center gap-1"><span class="text-[16px] material-symbols-outlined">gavel</span> Declarations</span></button>
            <button type="button" @click="profileTab = 'security'" class="px-4 py-2 rounded-lg transition-all cursor-pointer" :class="profileTab === 'security' ? 'bg-white text-primary shadow-sm' : 'hover:text-primary'"><span class="flex items-center gap-1"><span class="text-[16px] material-symbols-outlined">lock</span> Password & Security</span></button>
        </div>
    </div>

    @if(session()->has('success'))
        <div class="flex items-center gap-2 bg-emerald-50 mb-6 p-4 border border-emerald-200 rounded-xl font-semibold text-emerald-800 text-xs animate-fadeIn">
            <span class="text-[18px] material-symbols-outlined">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div x-show="profileTab === 'identity'" class="space-y-6 animate-fadeIn">
        <form wire:submit.prevent="updateProfile" class="space-y-6">

            <div class="space-y-6 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40">
                <h3 class="flex items-center gap-2 pb-2.5 border-background border-b font-headline-md font-bold text-primary text-base">
                    <span class="material-symbols-outlined">corporate_fare</span> 1. Company Information & Brand Assets
                </h3>

                <div class="gap-6 grid grid-cols-1 md:grid-cols-3 text-sm">
                    <div class="flex items-center gap-5 md:col-span-3 bg-surface-container-low/40 p-4 border border-dashed rounded-xl border-outline-variant/80 w-full">
                        <div class="relative flex flex-shrink-0 justify-center items-center bg-surface-container shadow-inner border rounded-xl w-16 h-16 overflow-hidden">
                            @if($new_company_icon)
                                <img src="{{ $new_company_icon->temporaryUrl() }}" class="w-full h-full object-cover">
                            @elseif($current_icon_path)
                                <img src="{{ asset('storage/' . $current_icon_path) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-outline text-[24px] material-symbols-outlined">business</span>
                            @endif
                        </div>
                        <div class="space-y-1">
                            <label class="block font-label-md text-primary cursor-pointer">
                                <span class="inline-block bg-primary hover:bg-primary/95 shadow-sm px-4 py-1.5 rounded-xl font-bold text-white text-xs transition-all">Replace Brand Logo Icon</span>
                                <input type="file" wire:model="new_company_icon" class="hidden" accept="image/*">
                            </label>
                            <p class="text-[10px] text-on-surface-variant">Accepts PNG, JPG formats up to 2MB. Dynamic real-time previewing active hooks loops.</p>
                            @error('new_company_icon') <span class="block font-bold text-red-500 text-xs animate-fadeIn">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Legal Corporate Name *</label>
                        <input type="text" wire:model.defer="company_name" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium">
                        @error('company_name') <span class="block pl-0.5 font-medium text-red-500 text-xs animate-fadeIn">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Registration Number *</label>
                        <input type="text" wire:model.defer="reg_number" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium">
                        @error('reg_number') <span class="block pl-0.5 font-medium text-red-500 text-xs animate-fadeIn">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Year Established</label>
                        <input type="number" wire:model.defer="year_established" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium" placeholder="YYYY">
                        @error('year_established') <span class="block pl-0.5 font-medium text-red-500 text-xs animate-fadeIn">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Corporate Email Address *</label>
                        <input type="email" wire:model.defer="email_address" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium">
                        @error('email_address') <span class="block pl-0.5 font-medium text-red-500 text-xs animate-fadeIn">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Telephone Number *</label>
                        <input type="text" wire:model.defer="phone_telephone" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium">
                        @error('phone_telephone') <span class="block pl-0.5 font-medium text-red-500 text-xs animate-fadeIn">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">WhatsApp Direct Contact Coordinate</label>
                        <input type="text" wire:model.defer="whatsapp_contact" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium">
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Type of Business Structure *</label>
                        <select wire:model.defer="type_of_business" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium">
                            <option value="Manufacturer">Manufacturer</option>
                            <option value="Wholesaler">Wholesaler</option>
                            <option value="Distributor">Distributor</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Nature of Sourcing Operation *</label>
                        <input type="text" wire:model.defer="nature_of_business" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium">
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Website URL Domain Link</label>
                        <input type="text" wire:model.defer="website" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium" placeholder="https://www.company.com">
                        @error('website') <span class="block pl-0.5 font-medium text-red-500 text-xs animate-fadeIn">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1 md:col-span-3">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Registered Physical Address Location *</label>
                        <textarea wire:model.defer="address" rows="2" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium"></textarea>
                        @error('address') <span class="block pl-0.5 font-medium text-red-500 text-xs animate-fadeIn">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="space-y-4 pt-4 border-t border-dashed border-outline-variant/50">
                    <h4 class="flex items-center gap-1 font-bold text-primary text-xs uppercase tracking-wide"><span class="text-[16px] material-symbols-outlined">groups</span> Board Directors Representation</h4>
                    <div class="gap-6 grid grid-cols-1 md:grid-cols-3 text-sm">
                        <div class="space-y-1">
                            <label class="block pl-0.5 font-semibold text-on-surface-variant text-xs">Names of Executive Board Directors</label>
                            <input type="text" wire:model.defer="names_of_board_directors" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium">
                        </div>
                        <div class="space-y-1">
                            <label class="block pl-0.5 font-semibold text-on-surface-variant text-xs">Director Position Title</label>
                            <input type="text" wire:model.defer="director_position_title" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium">
                        </div>
                        <div class="space-y-1">
                            <label class="block pl-0.5 font-semibold text-on-surface-variant text-xs">Director Communication Email</label>
                            <input type="email" wire:model.defer="director_email" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium">
                        </div>
                    </div>
                </div>

                <div class="space-y-3 pt-4 border-t border-dashed border-outline-variant/50">
                    <h4 class="flex items-center gap-1 font-bold text-primary text-xs uppercase tracking-wide"><span class="text-[16px] material-symbols-outlined">share</span> Corporate Social Presences Handles</h4>
                    <div class="gap-3 grid grid-cols-2 sm:grid-cols-5 text-xs">
                        <div><label class="block mb-1 pl-0.5 text-on-surface-variant">X (Twitter)</label><input type="text" wire:model.defer="social_twitter" class="bg-surface-container-low p-2 border rounded-xl outline-none w-full font-medium"></div>
                        <div><label class="block mb-1 pl-0.5 text-on-surface-variant">Facebook</label><input type="text" wire:model.defer="social_facebook" class="bg-surface-container-low p-2 border rounded-xl outline-none w-full font-medium"></div>
                        <div><label class="block mb-1 pl-0.5 text-on-surface-variant">Instagram</label><input type="text" wire:model.defer="social_instagram" class="bg-surface-container-low p-2 border rounded-xl outline-none w-full font-medium"></div>
                        <div><label class="block mb-1 pl-0.5 text-on-surface-variant">Threads</label><input type="text" wire:model.defer="social_threads" class="bg-surface-container-low p-2 border rounded-xl outline-none w-full font-medium"></div>
                        <div><label class="block mb-1 pl-0.5 text-on-surface-variant">LinkedIn</label><input type="text" wire:model.defer="social_linkedin" class="bg-surface-container-low p-2 border rounded-xl outline-none w-full font-medium"></div>
                    </div>
                </div>
            </div>

            <div class="space-y-6 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40">
                <h3 class="flex items-center gap-2 pb-2.5 border-background border-b font-headline-md font-bold text-primary text-base">
                    <span class="material-symbols-outlined">badge</span> 2. Authorized Account Representative Details
                </h3>

                <div class="gap-6 grid grid-cols-1 md:grid-cols-2 text-sm">
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Legal Representative Full Name *</label>
                        <input type="text" wire:model.defer="rep_legal_name" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium">
                        @error('rep_legal_name') <span class="block pl-0.5 font-medium text-red-500 text-xs animate-fadeIn">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Official Sourcing Role / Title *</label>
                        <input type="text" wire:model.defer="rep_position_title" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium">
                        @error('rep_position_title') <span class="block pl-0.5 font-medium text-red-500 text-xs animate-fadeIn">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Direct Core Communications Email (Used for Login Gateway Authentication) *</label>
                        <input type="email" wire:model.defer="rep_email" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium">
                        @error('rep_email') <span class="block pl-0.5 font-medium text-red-500 text-xs animate-fadeIn">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Direct Phone Mobile Number *</label>
                        <input type="text" wire:model.defer="rep_phone_number" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium">
                        @error('rep_phone_number') <span class="block pl-0.5 font-medium text-red-500 text-xs animate-fadeIn">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center bg-surface-container-low shadow-inner p-5 border rounded-2xl border-outline-variant/40">
                <span class="font-mono text-on-surface-variant/80 text-xs">System Protocol Token ID: {{ $supplier_ref_number }}</span>
                <button type="submit" wire:loading.attr="disabled" class="bg-primary hover:bg-primary/95 shadow-md px-8 py-3 rounded-xl font-label-md font-bold text-white text-xs active:scale-95 transition-all cursor-pointer">
                    <span wire:loading.remove>Commit General Updates</span>
                    <span wire:loading class="flex items-center gap-1.5 animate-pulse"><span class="inline-block border-2 border-white border-t-transparent rounded-full w-3.5 h-3.5 animate-spin"></span> Processing updates...</span>
                </button>
            </div>
        </form>
    </div>

    <div x-show="profileTab === 'terms'" x-cloak class="space-y-6 animate-fadeIn">
        <form wire:submit.prevent="updateProfile" class="space-y-6">
            <div class="space-y-6 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40">
                <h3 class="flex items-center gap-2 pb-2.5 border-background border-b font-headline-md font-bold text-primary text-base">
                    <span class="material-symbols-outlined">assignment_turned_in</span> 3. Capabilities, Logistical Parameters & Commercial Terms
                </h3>

                <div class="gap-6 grid grid-cols-1 md:grid-cols-3 text-sm">
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Product Categorization Range</label>
                        <input type="text" wire:model.defer="categorization_of_products" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium" placeholder="e.g., Dried Goods, Packaged Spices FMCG">
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Overall Minimum Order Quantities (MOQs)</label>
                        <input type="text" wire:model.defer="overall_moqs" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium">
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Monthly Sourcing Production Capacity</label>
                        <input type="text" wire:model.defer="production_capacity" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium">
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Pricing Structure Core Type</label>
                        <input type="text" wire:model.defer="pricing_structure_type" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium" placeholder="e.g., Bulk Volume Tier Rates">
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Baseline Settled Currency Accepted</label>
                        <input type="text" wire:model.defer="currency_accepted" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium">
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Shipping Freight Methods Available</label>
                        <input type="text" wire:model.defer="shipping_methods_available" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium" placeholder="e.g., Overland Cargo, Air Freight">
                    </div>

                    <div class="flex items-center gap-3 md:col-span-3 bg-surface-container-low/40 p-4 px-4 border border-dashed rounded-xl select-none">
                        <input type="checkbox" wire:model="ability_to_provide_samples" id="terms_samples_toggle" class="rounded w-4 h-4 text-primary cursor-pointer">
                        <label for="terms_samples_toggle" class="font-semibold text-on-surface-variant text-xs cursor-pointer">Our manufacturing facilities are fully authorized and capable of dispersing physical sample lots to corporate buyers</label>
                    </div>

                    <div class="space-y-1 md:col-span-3">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Manufacturing Assembly Plants / Warehouses Locations Details</label>
                        <textarea wire:model.defer="manufacturing_locations" rows="2" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium" placeholder="Provide geographical addresses coordinates of assembly lines..."></textarea>
                    </div>
                    <div class="space-y-1 md:col-span-3">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Customization, Tailoring & OEM Capability Options Description</label>
                        <textarea wire:model.defer="customization_options" rows="2" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium" placeholder="Specify capacity limits for private white-labeling requests..."></textarea>
                    </div>
                    <div class="space-y-1 md:col-span-3">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Standard Contract Payment Terms Framework Description</label>
                        <textarea wire:model.defer="payment_terms" rows="2" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium" placeholder="e.g., 30% Advance TT Deposit, 70% against full maritime shipping document copies scans..."></textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end bg-surface-container-low shadow-inner p-5 border rounded-2xl border-outline-variant/40">
                <button type="submit" wire:loading.attr="disabled" class="bg-primary hover:bg-primary/95 shadow-md px-8 py-3 rounded-xl font-label-md font-bold text-white text-xs active:scale-95 transition-all cursor-pointer">
                    <span wire:loading.remove>Commit Commercial Terms</span>
                    <span wire:loading class="flex items-center gap-1.5 animate-pulse"><span class="inline-block border-2 border-white border-t-transparent rounded-full w-3.5 h-3.5 animate-spin"></span> Syncing terms...</span>
                </button>
            </div>
        </form>
    </div>

    <div x-show="profileTab === 'compliance'" x-cloak class="space-y-6 animate-fadeIn">
        <form wire:submit.prevent="updateProfile" class="space-y-6">
            <div class="space-y-6 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40">
                <h3 class="flex items-center gap-2 pb-2.5 border-background border-b font-headline-md font-bold text-primary text-base">
                    <span class="material-symbols-outlined">gavel</span> 4. Compliance Affidavits, Assurances & Declarations Status
                </h3>
                <p class="-mt-3 pl-0.5 text-on-surface-variant/80 text-xs">Toggle the active operational checkboxes matching your legal auditing sign-off structures. These choices directly affect your automated matrix lookup filtering score within the client buyer database repository queries.</p>

                <div class="gap-4 grid grid-cols-1 md:grid-cols-2 text-xs">
                    <label class="flex items-center gap-3 bg-surface-container-low/40 hover:bg-surface-container-low p-4 border rounded-xl border-outline-variant/60 transition-all cursor-pointer select-none">
                        <input type="checkbox" wire:model="declares_gmo_free" class="rounded w-4 h-4 text-primary cursor-pointer">
                        <span class="font-bold text-primary">GMO Free Certification Compliance Guaranteed</span>
                    </label>
                    <label class="flex items-center gap-3 bg-surface-container-low/40 hover:bg-surface-container-low p-4 border rounded-xl border-outline-variant/60 transition-all cursor-pointer select-none">
                        <input type="checkbox" wire:model="declares_gluten_free" class="rounded w-4 h-4 text-primary cursor-pointer">
                        <span class="font-bold text-primary">Gluten-Free Facility Formulation Verification Assurance</span>
                    </label>
                    <label class="flex items-center gap-3 bg-surface-container-low/40 hover:bg-surface-container-low p-4 border rounded-xl border-outline-variant/60 transition-all cursor-pointer select-none">
                        <input type="checkbox" wire:model="declares_non_irradiated" class="rounded w-4 h-4 text-primary cursor-pointer">
                        <span class="font-bold text-primary">Non-Irradiated / Non-Ionised Process Method Affirmation</span>
                    </label>
                    <label class="flex items-center gap-3 bg-surface-container-low/40 hover:bg-surface-container-low p-4 border rounded-xl border-outline-variant/60 transition-all cursor-pointer select-none">
                        <input type="checkbox" wire:model="declares_no_nanomaterials" class="rounded w-4 h-4 text-primary cursor-pointer">
                        <span class="font-bold text-primary">Zero Synthetic Engineered Nanomaterials Declaration</span>
                    </label>
                    <label class="flex items-center gap-3 md:col-span-2 bg-surface-container-low/40 hover:bg-surface-container-low p-4 border rounded-xl border-outline-variant/60 transition-all cursor-pointer select-none">
                        <input type="checkbox" wire:model="complies_haccp_gmp" class="rounded w-4 h-4 text-primary cursor-pointer">
                        <span class="font-bold text-primary">Active Active Certification Program under global HACCP / GMP Quality Architecture controls</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end bg-surface-container-low shadow-inner p-5 border rounded-2xl border-outline-variant/40">
                <button type="submit" wire:loading.attr="disabled" class="bg-primary hover:bg-primary/95 shadow-md px-8 py-3 rounded-xl font-label-md font-bold text-white text-xs active:scale-95 transition-all cursor-pointer">
                    Commit Affidavits Stand
                </button>
            </div>
        </form>
    </div>

    <div x-show="profileTab === 'security'" x-cloak class="space-y-6 animate-fadeIn">
        <form wire:submit.prevent="updateSecurityPassword" class="space-y-6">
            <div class="space-y-6 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40">
                <h3 class="flex items-center gap-2 pb-2.5 border-background border-b font-headline-md font-bold text-primary text-base">
                    <span class="material-symbols-outlined">lock_reset</span> 5. Security Access Matrix (Rotate Account Password)
                </h3>
                <p class="-mt-3 pl-0.5 text-on-surface-variant/80 text-xs">Rotate your cryptographic access security token string regularly. Changing your password updates validation sessions across all active active endpoints instantly.</p>

                <div class="gap-6 grid grid-cols-1 md:grid-cols-3 max-w-4xl text-sm">
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Current Account Password *</label>
                        <input type="password" wire:model.defer="current_password" class="bg-surface-container-low focus:bg-white p-2.5 border rounded-xl border-outline-variant outline-none w-full">
                        @error('current_password') <span class="block pl-0.5 font-medium text-red-500 text-xs animate-fadeIn">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-primary text-xs">New Security Password *</label>
                        <input type="password" wire:model.defer="new_password" class="bg-surface-container-low focus:bg-white p-2.5 border rounded-xl border-outline-variant outline-none w-full" placeholder="Minimum 8 elements">
                        @error('new_password') <span class="block pl-0.5 font-medium text-red-500 text-xs animate-fadeIn">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-primary text-xs">Confirm New Security Password *</label>
                        <input type="password" wire:model.defer="new_password_confirmation" class="bg-surface-container-low focus:bg-white p-2.5 border rounded-xl border-outline-variant outline-none w-full" placeholder="Re-type string key">
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center bg-surface-container-low shadow-inner p-5 border rounded-2xl border-outline-variant/40 select-none">
                <div class="flex items-center gap-2 font-semibold text-on-surface-variant text-xs">
                    <span class="text-[16px] text-amber-600 material-symbols-outlined">security_alert</span>
                    <span>Modifying this will terminate secondary active session cookies frames logs on submission.</span>
                </div>
                <button type="submit" wire:loading.attr="disabled" class="bg-primary hover:bg-primary/95 shadow-md px-8 py-3 rounded-xl font-label-md font-bold text-white text-xs active:scale-95 transition-all cursor-pointer">
                    <span wire:loading.remove>Rotate Login Token</span>
                    <span wire:loading class="animate-pulse"><span class="inline-block mr-1 border-2 border-white border-t-transparent rounded-full w-3 h-3 animate-spin"></span> Processing security patch...</span>
                </button>
            </div>
        </form>
    </div>

</div>
