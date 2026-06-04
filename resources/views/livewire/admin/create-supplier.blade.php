<div class="flex-1 mx-auto p-gutter w-full max-w-[1440px]">

    <div class="mb-stack-lg">
        <h2 class="mb-1 font-headline-lg text-headline-lg text-primary">Supplier Registration</h2>
        <p class="font-body-sm text-body-sm text-on-surface-variant">Please provide accurate corporate capability parameters and legal declarations to complete onboarding.</p>
    </div>

    <form action="{{ route('admin.suppliers.store') }}" method="post" enctype="multipart/form-data"
    x-data="{ 
        activeStep: 1,
        init() {
            {{-- Pure server-side Blade evaluations output clean JavaScript integers on execution --}}
            @if($errors->hasAny(['company_name', 'reg_number', 'year_established', 'email_address', 'phone_telephone', 'whatsapp_contact', 'address', 'company_icon_path', 'names_of_board_directors', 'director_position_title', 'director_email', 'social_twitter', 'social_facebook', 'social_instagram', 'social_threads', 'social_linkedin']))
                this.activeStep = 1;
            @elseif($errors->hasAny(['rep_legal_name', 'rep_position_title', 'rep_email', 'rep_phone_number']))
                this.activeStep = 2;
            @elseif($errors->hasAny(['currency_accepted', 'manufacturing_locations', 'product_manufacturing_certifications', 'returns_warranty_policy', 'pricing_structure_type']))
                this.activeStep = 3;
            @elseif($errors->hasAny(['file_sales_contract', 'file_commercial_invoice', 'file_packing_list', 'file_product_spec_sheet', 'file_test_analysis_report']))
                this.activeStep = 4;
            @elseif($errors->hasAny(['assigned_manager', 'declaration_authorized_person', 'declaration_title', 'declaration_signature_path']))
                this.activeStep = 5;
            @endif
        }
    }" 
    class="space-y-6">
        
        @csrf

        <div class="bg-surface-container-low shadow-sm mb-8 p-5 border rounded-3xl border-outline-variant/20">
            <div class="relative flex justify-between items-center mx-auto px-4 max-w-4xl">
                <div class="z-10 relative flex flex-col items-center cursor-pointer" @click="activeStep = 1">
                    <div class="flex justify-center items-center rounded-full w-10 h-10 font-bold text-sm transition-all duration-300" :class="activeStep === 1 ? 'bg-primary text-white ring-4 ring-primary/20' : 'bg-white border-2 border-outline text-on-surface-variant'">1</div>
                    <span class="hidden sm:block mt-2 font-label-sm font-medium text-[11px]" :class="activeStep === 1 ? 'text-primary font-bold' : 'text-on-surface-variant'">Company Info</span>
                </div>
                <div class="flex-1 mx-2 h-0.5 transition-colors duration-300" :class="activeStep > 1 ? 'bg-primary' : 'bg-outline-variant'"></div>

                <div class="z-10 relative flex flex-col items-center cursor-pointer" @click="activeStep = 2">
                    <div class="flex justify-center items-center rounded-full w-10 h-10 font-bold text-sm transition-all duration-300" :class="activeStep === 2 ? 'bg-primary text-white ring-4 ring-primary/20' : 'bg-white border-2 border-outline text-on-surface-variant'">2</div>
                    <span class="hidden sm:block mt-2 font-label-sm font-medium text-[11px]" :class="activeStep === 2 ? 'text-primary font-bold' : 'text-on-surface-variant'">Legal Rep</span>
                </div>
                <div class="flex-1 mx-2 h-0.5 transition-colors duration-300" :class="activeStep > 2 ? 'bg-primary' : 'bg-outline-variant'"></div>

                <div class="z-10 relative flex flex-col items-center cursor-pointer" @click="activeStep = 3">
                    <div class="flex justify-center items-center rounded-full w-10 h-10 font-bold text-sm transition-all duration-300" :class="activeStep === 3 ? 'bg-primary text-white ring-4 ring-primary/20' : 'bg-white border-2 border-outline text-on-surface-variant'">3</div>
                    <span class="hidden sm:block mt-2 font-label-sm font-medium text-[11px]" :class="activeStep === 3 ? 'text-primary font-bold' : 'text-on-surface-variant'">Commercial Terms</span>
                </div>
                <div class="flex-1 mx-2 h-0.5 transition-colors duration-300" :class="activeStep > 3 ? 'bg-primary' : 'bg-outline-variant'"></div>

                <div class="z-10 relative flex flex-col items-center cursor-pointer" @click="activeStep = 4">
                    <div class="flex justify-center items-center rounded-full w-10 h-10 font-bold text-sm transition-all duration-300" :class="activeStep === 4 ? 'bg-primary text-white ring-4 ring-primary/20' : 'bg-white border-2 border-outline text-on-surface-variant'">4</div>
                    <span class="hidden sm:block mt-2 font-label-sm font-medium text-[11px]" :class="activeStep === 4 ? 'text-primary font-bold' : 'text-on-surface-variant'">Attachments</span>
                </div>
                <div class="flex-1 mx-2 h-0.5 transition-colors duration-300" :class="activeStep > 4 ? 'bg-primary' : 'bg-outline-variant'"></div>

                <div class="z-10 relative flex flex-col items-center cursor-pointer" @click="activeStep = 5">
                    <div class="flex justify-center items-center rounded-full w-10 h-10 font-bold text-sm transition-all duration-300" :class="activeStep === 5 ? 'bg-primary text-white ring-4 ring-primary/20' : 'bg-white border-2 border-outline text-on-surface-variant'">5</div>
                    <span class="hidden sm:block mt-2 font-label-sm font-medium text-[11px]" :class="activeStep === 5 ? 'text-primary font-bold' : 'text-on-surface-variant'">Declarations</span>
                </div>
            </div>
        </div>

        <div x-show="activeStep === 1" x-cloak
            x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            class="space-y-6 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40">

            <h3 class="flex items-center gap-2 pb-3 border-b border-outline-variant/20 font-headline-md text-primary">
                <span class="material-symbols-outlined">business</span> Company Information
            </h3>

            <div class="gap-6 grid grid-cols-1 md:grid-cols-3">
                <div class="flex items-center gap-6 md:col-span-3 bg-surface-container-lowest p-4 border border-dashed rounded-2xl border-outline-variant w-full">
                    <div class="relative flex flex-shrink-0 justify-center items-center bg-surface-container shadow-inner rounded-2xl w-20 h-20 overflow-hidden">
                        <span class="text-outline text-[32px] material-symbols-outlined">add_photo_alternate</span>
                    </div>
                    <div class="space-y-1">
                        <label class="block font-label-md text-label-md text-primary cursor-pointer">
                            <span class="inline-block bg-primary hover:bg-primary/90 shadow-sm px-4 py-2 rounded-xl text-white transition-all">Upload Company Brand Icon</span>
                            <input type="file" name="company_icon_path" class="hidden" accept="image/*"
                                onchange="document.getElementById('icon-file-name').innerText = this.files[0] ? this.files[0].name : 'No file chosen'">
                        </label>
                        <p id="icon-file-name" class="mt-1 px-1 font-semibold text-secondary text-xs tracking-wide">No file chosen</p>
                        <p class="text-on-surface-variant text-xs">PNG, JPG, WEBP formats up to 2MB.</p>
                        @error('company_icon_path') <span class="block mt-1 text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block pl-1 font-label-md text-on-surface-variant">Company Name *</label>
                    <input type="text" name="company_name" value="{{ old('company_name') }}" class="bg-surface-container-low @error('company_name') @else border-outline-variant focus:ring-primary @enderror font-body-sm w-full rounded-xl border border-red-500 px-4 py-3 outline-none ring-2 ring-red-100 focus:ring-2 focus:ring-red-200">
                    @error('company_name') <span class="block mt-1 pl-1 text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="block pl-1 font-label-md text-on-surface-variant">Registration Number *</label>
                    <input type="text" name="reg_number" value="{{ old('reg_number') }}" class="bg-surface-container-low @error('reg_number') @else border-outline-variant focus:ring-primary @enderror font-body-sm w-full rounded-xl border border-red-500 px-4 py-3 outline-none ring-2 ring-red-100 focus:ring-2 focus:ring-red-200">
                    @error('reg_number') <span class="block mt-1 pl-1 text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="block pl-1 font-label-md text-on-surface-variant">Year Established</label>
                    <input type="number" name="year_established" value="{{ old('year_established') }}" class="bg-surface-container-low px-4 py-3 border rounded-xl border-outline-variant outline-none focus:ring-2 focus:ring-primary w-full font-body-sm">
                </div>

                <div class="space-y-2">
                    <label class="block pl-1 font-label-md text-on-surface-variant">Corporate Email Address *</label>
                    <input type="email" name="email_address" value="{{ old('email_address') }}" class="bg-surface-container-low @error('email_address') @else border-outline-variant focus:ring-primary @enderror font-body-sm w-full rounded-xl border border-red-500 px-4 py-3 outline-none ring-2 ring-red-100 focus:ring-2 focus:ring-red-200">
                    @error('email_address') <span class="block mt-1 pl-1 text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="block pl-1 font-label-md text-on-surface-variant">Phone / Telephone *</label>
                    <input type="text" name="phone_telephone" value="{{ old('phone_telephone') }}" class="bg-surface-container-low @error('phone_telephone') @else border-outline-variant focus:ring-primary @enderror font-body-sm w-full rounded-xl border border-red-500 px-4 py-3 outline-none ring-2 ring-red-100 focus:ring-2 focus:ring-red-200">
                    @error('phone_telephone') <span class="block mt-1 pl-1 text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="block pl-1 font-label-md text-on-surface-variant">WhatsApp Contact</label>
                    <input type="text" name="whatsapp_contact" value="{{ old('whatsapp_contact') }}" class="bg-surface-container-low px-4 py-3 border rounded-xl border-outline-variant outline-none focus:ring-2 focus:ring-primary w-full font-body-sm">
                </div>

                <div class="space-y-2">
                    <label class="block pl-1 font-label-md text-on-surface-variant">Type of Business</label>
                    <select name="type_of_business" class="bg-surface-container-low px-4 py-3 border rounded-xl border-outline-variant outline-none focus:ring-2 focus:ring-primary w-full font-body-sm">
                        <option value="">Select category...</option>
                        <option value="Manufacturer" {{ old('type_of_business') === 'Manufacturer' ? 'selected' : '' }}>Manufacturer</option>
                        <option value="Wholesaler" {{ old('type_of_business') === 'Wholesaler' ? 'selected' : '' }}>Wholesaler</option>
                        <option value="Distributor" {{ old('type_of_business') === 'Distributor' ? 'selected' : '' }}>Distributor</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block pl-1 font-label-md text-on-surface-variant">Nature of Business</label>
                    <input type="text" name="nature_of_business" value="{{ old('nature_of_business') }}" class="bg-surface-container-low px-4 py-3 border rounded-xl border-outline-variant outline-none focus:ring-2 focus:ring-primary w-full font-body-sm">
                </div>

                <div class="space-y-2">
                    <label class="block pl-1 font-label-md text-on-surface-variant">Website URL</label>
                    <input type="text" name="website" value="{{ old('website') }}" class="bg-surface-container-low px-4 py-3 border rounded-xl border-outline-variant outline-none focus:ring-2 focus:ring-primary w-full font-body-sm">
                </div>

                <div class="space-y-4 md:col-span-3 pt-4 border-t border-dashed border-outline-variant/60">
                    <h4 class="flex items-center gap-1 font-label-md font-bold text-primary"><span class="text-[18px] material-symbols-outlined">groups</span> Board of Directors (Primary Lead)</h4>
                    <div class="gap-4 grid grid-cols-1 md:grid-cols-3">
                        <div class="space-y-1">
                            <label class="block font-label-md text-on-surface-variant text-xs">Names of Board Directors</label>
                            <input type="text" name="names_of_board_directors" value="{{ old('names_of_board_directors') }}" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none w-full font-body-sm" placeholder="Full legal name">
                        </div>
                        <div class="space-y-1">
                            <label class="block font-label-md text-on-surface-variant text-xs">Director Position Title</label>
                            <input type="text" name="director_position_title" value="{{ old('director_position_title') }}" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none w-full font-body-sm" placeholder="e.g., Chairman">
                        </div>
                        <div class="space-y-1">
                            <label class="block font-label-md text-on-surface-variant text-xs">Director Email Address</label>
                            <input type="email" name="director_email" value="{{ old('director_email') }}" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none w-full font-body-sm" placeholder="director@company.com">
                        </div>
                    </div>
                </div>

                <div class="space-y-4 md:col-span-3 pt-4 border-t border-dashed border-outline-variant/60">
                    <h4 class="flex items-center gap-1 font-label-md font-bold text-primary"><span class="text-[18px] material-symbols-outlined">share</span> Corporate Social Media Presences</h4>
                    <div class="gap-4 grid grid-cols-1 md:grid-cols-5">
                        <div class="space-y-1">
                            <label class="block font-label-md text-on-surface-variant text-xs">X (Twitter)</label>
                            <input type="text" name="social_twitter" value="{{ old('social_twitter') }}" class="bg-surface-container-low px-3 py-2 border rounded-xl border-outline-variant outline-none w-full font-body-sm" placeholder="@profile">
                        </div>
                        <div class="space-y-1">
                            <label class="block font-label-md text-on-surface-variant text-xs">Facebook</label>
                            <input type="text" name="social_facebook" value="{{ old('social_facebook') }}" class="bg-surface-container-low px-3 py-2 border rounded-xl border-outline-variant outline-none w-full font-body-sm" placeholder="username">
                        </div>
                        <div class="space-y-1">
                            <label class="block font-label-md text-on-surface-variant text-xs">Instagram</label>
                            <input type="text" name="social_instagram" value="{{ old('social_instagram') }}" class="bg-surface-container-low px-3 py-2 border rounded-xl border-outline-variant outline-none w-full font-body-sm" placeholder="@profile">
                        </div>
                        <div class="space-y-1">
                            <label class="block font-label-md text-on-surface-variant text-xs">Threads</label>
                            <input type="text" name="social_threads" value="{{ old('social_threads') }}" class="bg-surface-container-low px-3 py-2 border rounded-xl border-outline-variant outline-none w-full font-body-sm" placeholder="@profile">
                        </div>
                        <div class="space-y-1">
                            <label class="block font-label-md text-on-surface-variant text-xs">LinkedIn</label>
                            <input type="text" name="social_linkedin" value="{{ old('social_linkedin') }}" class="bg-surface-container-low px-3 py-2 border rounded-xl border-outline-variant outline-none w-full font-body-sm" placeholder="company/page">
                        </div>
                    </div>
                </div>

                <div class="space-y-2 md:col-span-3">
                    <label class="block pl-1 font-label-md text-on-surface-variant">Registered Corporate Address *</label>
                    <textarea name="address" rows="3" class="bg-surface-container-low @error('address') @else border-outline-variant focus:ring-primary @enderror font-body-sm w-full rounded-xl border border-red-500 px-4 py-3 outline-none ring-2 ring-red-100 focus:ring-2 focus:ring-red-200" placeholder="Full legal location address details...">{{ old('address') }}</textarea>
                    @error('address') <span class="block mt-1 pl-1 text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="button" @click="activeStep = 2" class="flex items-center gap-2 bg-primary hover:bg-primary/90 px-6 py-3 rounded-xl font-label-md text-label-md text-white transition-all">
                    Next Step <span class="text-[18px] material-symbols-outlined">arrow_forward</span>
                </button>
            </div>
        </div>

        <div x-show="activeStep === 2" x-cloak
            x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            class="space-y-6 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40">
            <h3 class="flex items-center gap-2 pb-3 border-b border-outline-variant/20 font-headline-md text-primary">
                <span class="material-symbols-outlined">account_circle</span> Authorized Representative Details
            </h3>

            <div class="gap-6 grid grid-cols-1 md:grid-cols-2">
                <div class="space-y-2">
                    <label class="block pl-1 font-label-md text-on-surface-variant">Legal Full Name *</label>
                    <input type="text" name="rep_legal_name" value="{{ old('rep_legal_name') }}" class="bg-surface-container-low @error('rep_legal_name') @else border-outline-variant focus:ring-primary @enderror font-body-sm w-full rounded-xl border border-red-500 px-4 py-3 outline-none ring-2 ring-red-100 focus:ring-2 focus:ring-red-200">
                    @error('rep_legal_name') <span class="block mt-1 pl-1 text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-2">
                    <label class="block pl-1 font-label-md text-on-surface-variant">Position Title *</label>
                    <input type="text" name="rep_position_title" value="{{ old('rep_position_title') }}" class="bg-surface-container-low px-4 py-3 border rounded-xl border-outline-variant outline-none focus:ring-2 focus:ring-primary w-full font-body-sm">
                </div>
                <div class="space-y-2">
                    <label class="block pl-1 font-label-md text-on-surface-variant">Direct Email Address *</label>
                    <input type="email" name="rep_email" value="{{ old('rep_email') }}" class="bg-surface-container-low @error('rep_email') @else border-outline-variant focus:ring-primary @enderror font-body-sm w-full rounded-xl border border-red-500 px-4 py-3 outline-none ring-2 ring-red-100 focus:ring-2 focus:ring-red-200">
                    @error('rep_email') <span class="block mt-1 pl-1 text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-2">
                    <label class="block pl-1 font-label-md text-on-surface-variant">Direct Phone Number *</label>
                    <input type="text" name="rep_phone_number" value="{{ old('rep_phone_number') }}" class="bg-surface-container-low @error('rep_phone_number') @else border-outline-variant focus:ring-primary @enderror font-body-sm w-full rounded-xl border border-red-500 px-4 py-3 outline-none ring-2 ring-red-100 focus:ring-2 focus:ring-red-200">
                    @error('rep_phone_number') <span class="block mt-1 pl-1 text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-between pt-4">
                <button type="button" @click="activeStep = 1" class="bg-surface-container-high hover:bg-surface-container px-6 py-3 rounded-xl font-label-md text-label-md text-on-surface-variant transition-all">Back</button>
                <button type="button" @click="activeStep = 3" class="flex items-center gap-2 bg-primary hover:bg-primary/90 px-6 py-3 rounded-xl font-label-md text-label-md text-white transition-all">
                    Next Step <span class="text-[18px] material-symbols-outlined">arrow_forward</span>
                </button>
            </div>
        </div>

        <div x-show="activeStep === 3" x-cloak
            x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            class="space-y-6 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40">
            <h3 class="flex items-center gap-2 pb-3 border-b border-outline-variant/20 font-headline-md text-primary">
                <span class="material-symbols-outlined">assignment_turned_in</span> Capabilities & Commercial Terms
            </h3>

            <div class="gap-6 grid grid-cols-1 md:grid-cols-3">
                <div class="space-y-2">
                    <label class="block pl-1 font-label-md text-on-surface-variant">Product Categorization</label>
                    <input type="text" name="categorization_of_products" value="{{ old('categorization_of_products') }}" class="bg-surface-container-low px-4 py-3 border rounded-xl border-outline-variant outline-none focus:ring-2 focus:ring-primary w-full font-body-sm">
                </div>
                <div class="space-y-2">
                    <label class="block pl-1 font-label-md text-on-surface-variant">Minimum Order Quantities (MOQs)</label>
                    <input type="text" name="overall_moqs" value="{{ old('overall_moqs') }}" class="bg-surface-container-low px-4 py-3 border rounded-xl border-outline-variant outline-none focus:ring-2 focus:ring-primary w-full font-body-sm">
                </div>
                <div class="space-y-2">
                    <label class="block pl-1 font-label-md text-on-surface-variant">Production Capacity</label>
                    <input type="text" name="production_capacity" value="{{ old('production_capacity') }}" class="bg-surface-container-low px-4 py-3 border rounded-xl border-outline-variant outline-none focus:ring-2 focus:ring-primary w-full font-body-sm">
                </div>
                <div class="space-y-2">
                    <label class="block pl-1 font-label-md text-on-surface-variant">Currency Accepted *</label>
                    <input type="text" name="currency_accepted" value="{{ old('currency_accepted', 'Naira') }}" class="bg-surface-container-low @error('currency_accepted') @else border-outline-variant focus:ring-primary @enderror font-body-sm w-full rounded-xl border border-red-500 px-4 py-3 outline-none ring-2 ring-red-100 focus:ring-2 focus:ring-red-200">
                    @error('currency_accepted') <span class="block mt-1 pl-1 text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-2">
                    <label class="block pl-1 font-label-md text-on-surface-variant">Shipping Methods Available</label>
                    <input type="text" name="shipping_methods_available" value="{{ old('shipping_methods_available') }}" class="bg-surface-container-low px-4 py-3 border rounded-xl border-outline-variant outline-none focus:ring-2 focus:ring-primary w-full font-body-sm">
                </div>
                <div class="space-y-2">
                    <label class="block pl-1 font-label-md text-on-surface-variant">Pricing Structure Type</label>
                    <input type="text" name="pricing_structure_type" value="{{ old('pricing_structure_type') }}" class="bg-surface-container-low px-4 py-3 border rounded-xl border-outline-variant outline-none focus:ring-2 focus:ring-primary w-full font-body-sm" placeholder="e.g., Bulk, Per Unit">
                </div>

                <div class="flex items-center gap-3 px-1 pt-8">
                    <input type="checkbox" name="ability_to_provide_samples" value="1" id="samples_toggle" {{ old('ability_to_provide_samples') ? 'checked' : '' }} class="rounded border-outline-variant focus:ring-primary w-5 h-5 text-primary transition-all">
                    <label for="samples_toggle" class="font-body-sm text-body-sm text-on-surface-variant cursor-pointer">Able to provide samples</label>
                </div>

                <div class="space-y-2 md:col-span-3">
                    <label class="block pl-1 font-label-md text-on-surface-variant">Manufacturing Locations</label>
                    <input type="text" name="manufacturing_locations" value="{{ old('manufacturing_locations') }}" class="bg-surface-container-low px-4 py-3 border rounded-xl border-outline-variant outline-none focus:ring-2 focus:ring-primary w-full font-body-sm" placeholder="Full addresses of assembly lines / manufacturing layouts">
                </div>
                
                {{-- <div class="space-y-2 md:col-span-3">
                    <label class="block pl-1 font-label-md text-on-surface-variant">Product Manufacturing Certifications</label>
                    <textarea name="product_manufacturing_certifications" rows="2" class="bg-surface-container-low px-4 py-3 border rounded-xl border-outline-variant outline-none focus:ring-2 focus:ring-primary w-full font-body-sm" placeholder="e.g., ISO 9001, NAFDAC approved facilities logs...">{{ old('product_manufacturing_certifications') }}</textarea>
                </div> --}}

                {{-- <div class="space-y-2 md:col-span-3">
                    <label class="block pl-1 font-label-md text-on-surface-variant">Returns & Warranty Policy Log</label>
                    <textarea name="returns_warranty_policy" rows="2" class="bg-surface-container-low px-4 py-3 border rounded-xl border-outline-variant outline-none focus:ring-2 focus:ring-primary w-full font-body-sm" placeholder="Specify logistical terms for returning items components...">{{ old('returns_warranty_policy') }}</textarea>
                </div> --}}

                <div class="space-y-2 md:col-span-3">
                    <label class="block pl-1 font-label-md text-on-surface-variant">Payment Terms Description</label>
                    <textarea name="payment_terms" rows="2" class="bg-surface-container-low px-4 py-3 border rounded-xl border-outline-variant outline-none focus:ring-2 focus:ring-primary w-full font-body-sm" placeholder="e.g., 30% advance deposit...">{{ old('payment_terms') }}</textarea>
                </div>
            </div>

            <div class="flex justify-between pt-4">
                <button type="button" @click="activeStep = 2" class="bg-surface-container-high hover:bg-surface-container px-6 py-3 rounded-xl font-label-md text-label-md text-on-surface-variant transition-all">Back</button>
                <button type="button" @click="activeStep = 4" class="flex items-center gap-2 bg-primary hover:bg-primary/90 px-6 py-3 rounded-xl font-label-md text-label-md text-white transition-all">
                    Next Step <span class="text-[18px] material-symbols-outlined">arrow_forward</span>
                </button>
            </div>
        </div>

        <div x-show="activeStep === 4" x-cloak
            x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            class="space-y-6 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40">

            <h3 class="flex items-center gap-2 pb-3 border-b border-outline-variant/20 font-headline-md text-primary">
                <span class="material-symbols-outlined">description</span> Core Onboarding Attachments
            </h3>

            <div class="gap-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                <div class="flex flex-col justify-between gap-3 bg-surface-container-lowest p-4 border rounded-2xl border-outline-variant/60">
                    <div class="flex items-start gap-3">
                        <span class="text-[28px] text-primary material-symbols-outlined">shield_with_heart</span>
                        <div>
                            <p class="font-label-md font-bold text-primary">Sales Contract</p>
                            <p class="text-[11px] text-on-surface-variant">Accepts: PDF, DOCX, JPG (Max: 5MB)</p>
                        </div>
                    </div>
                    <input type="file" name="file_sales_contract" class="w-full text-xs">
                    @error('file_sales_contract') <span class="block mt-1 text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col justify-between gap-3 bg-surface-container-lowest p-4 border rounded-2xl border-outline-variant/60">
                    <div class="flex items-start gap-3">
                        <span class="text-[28px] text-primary material-symbols-outlined">receipt</span>
                        <div>
                            <p class="font-label-md font-bold text-primary">Commercial Invoice</p>
                            <p class="text-[11px] text-on-surface-variant">Accepts: PDF, DOCX, JPG (Max: 5MB)</p>
                        </div>
                    </div>
                    <input type="file" name="file_commercial_invoice" class="w-full text-xs">
                </div>

                <div class="flex flex-col justify-between gap-3 bg-surface-container-lowest p-4 border rounded-2xl border-outline-variant/60">
                    <div class="flex items-start gap-3">
                        <span class="text-[28px] text-primary material-symbols-outlined">inventory</span>
                        <div>
                            <p class="font-label-md font-bold text-primary">Packing List</p>
                            <p class="text-[11px] text-on-surface-variant">Accepts: PDF, DOCX, JPG (Max: 5MB)</p>
                        </div>
                    </div>
                    <input type="file" name="file_packing_list" class="w-full text-xs">
                </div>

                <div class="flex flex-col justify-between gap-3 bg-surface-container-lowest p-4 border rounded-2xl border-outline-variant/60">
                    <div class="flex items-start gap-3">
                        <span class="text-[28px] text-primary material-symbols-outlined">assignment</span>
                        <div>
                            <p class="font-label-md font-bold text-primary">Product Specification Sheet</p>
                            <p class="text-[11px] text-on-surface-variant">Accepts: PDF, DOCX, JPG (Max: 5MB)</p>
                        </div>
                    </div>
                    <input type="file" name="file_product_spec_sheet" class="w-full text-xs">
                </div>

                <div class="flex flex-col justify-between gap-3 bg-surface-container-lowest p-4 border rounded-2xl border-outline-variant/60">
                    <div class="flex items-start gap-3">
                        <span class="text-[28px] text-primary material-symbols-outlined">biotech</span>
                        <div>
                            <p class="font-label-md font-bold text-primary">Test Analysis Report</p>
                            <p class="text-[11px] text-on-surface-variant">Accepts: PDF, DOCX, JPG (Max: 5MB)</p>
                        </div>
                    </div>
                    <input type="file" name="file_test_analysis_report" class="w-full text-xs">
                </div>
                <div class="flex flex-col justify-between gap-3 bg-surface-container-lowest p-4 border rounded-2xl border-outline-variant/60">
                    <div class="flex items-start gap-3">
                        <span class="text-[28px] text-primary material-symbols-outlined">receipt</span>
                        <div>
                            <p class="font-label-md font-bold text-primary">Product Manufacturing Certification</p>
                            <p class="text-[11px] text-on-surface-variant">Accepts: PDF, DOCX, JPG (Max: 5MB)</p>
                        </div>
                    </div>
                    <input type="file" name="product_manufacturing_certifications" class="w-full text-xs">
                </div>
                <div class="flex flex-col justify-between gap-3 bg-surface-container-lowest p-4 border rounded-2xl border-outline-variant/60">
                    <div class="flex items-start gap-3">
                        <span class="text-[28px] text-primary material-symbols-outlined">receipt</span>
                        <div>
                            <p class="font-label-md font-bold text-primary">Return and Warranty Policy Document</p>
                            <p class="text-[11px] text-on-surface-variant">Accepts: PDF, DOCX, JPG (Max: 5MB)</p>
                        </div>
                    </div>
                    <input type="file" name="returns_warranty_policy" class="w-full text-xs">
                </div>
            </div>

            <div class="flex justify-between pt-4">
                <button type="button" @click="activeStep = 3" class="bg-surface-container-high hover:bg-surface-container px-6 py-3 rounded-xl font-label-md text-label-md text-on-surface-variant transition-all">Back</button>
                <button type="button" @click="activeStep = 5" class="flex items-center gap-2 bg-primary hover:bg-primary/90 px-6 py-3 rounded-xl font-label-md text-label-md text-white transition-all">
                    Next Step <span class="text-[18px] material-symbols-outlined">arrow_forward</span>
                </button>
            </div>
        </div>

        <div x-show="activeStep === 5" x-cloak
            x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            class="space-y-6 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40">

            <div>
                <h3 class="flex items-center gap-2 mb-4 pb-3 border-b border-outline-variant/20 font-headline-md text-primary">
                    <span class="material-symbols-outlined">gavel</span> Compliance & Declarations Status
                </h3>
                <div class="gap-4 grid grid-cols-1 md:grid-cols-2">
                    <label class="flex items-center gap-3 bg-surface-container-lowest hover:bg-surface-container-low p-4 border rounded-xl transition-all cursor-pointer">
                        <input type="checkbox" name="declares_gmo_free" value="1" {{ old('declares_gmo_free') ? 'checked' : '' }} class="rounded border-outline-variant w-5 h-5 text-primary">
                        <span class="font-semibold text-body-sm text-primary">GMO Free Compliant Certification</span>
                    </label>
                    <label class="flex items-center gap-3 bg-surface-container-lowest hover:bg-surface-container-low p-4 border rounded-xl transition-all cursor-pointer">
                        <input type="checkbox" name="declares_gluten_free" value="1" {{ old('declares_gluten_free') ? 'checked' : '' }} class="rounded border-outline-variant w-5 h-5 text-primary">
                        <span class="font-semibold text-body-sm text-primary">Gluten-Free Ingredients Assurance</span>
                    </label>
                    <label class="flex items-center gap-3 bg-surface-container-lowest hover:bg-surface-container-low p-4 border rounded-xl transition-all cursor-pointer">
                        <input type="checkbox" name="complies_haccp_gmp" value="1" {{ old('complies_haccp_gmp') ? 'checked' : '' }} class="rounded border-outline-variant w-5 h-5 text-primary">
                        <span class="font-semibold text-body-sm text-primary">HACCP / GMP Program Architecture Certified</span>
                    </label>
                    <label class="flex items-center gap-3 bg-surface-container-lowest hover:bg-surface-container-low p-4 border rounded-xl transition-all cursor-pointer">
                        <input type="checkbox" name="declares_non_irradiated" value="1" {{ old('declares_non_irradiated') ? 'checked' : '' }} class="rounded border-outline-variant w-5 h-5 text-primary">
                        <span class="font-semibold text-body-sm text-primary">Non-Irradiated / Non-Ionised Process Declared</span>
                    </label>
                </div>
            </div>

            <div class="pt-4 border-t border-dashed border-outline-variant/60">
                <h3 class="flex items-center gap-2 mb-4 pb-3 border-b border-outline-variant/20 font-headline-md text-primary">
                    <span class="material-symbols-outlined">draw</span> Authorized Declaration Sign-off
                </h3>
                <div class="gap-6 grid grid-cols-1 md:grid-cols-3">
                    <div class="space-y-2">
                        <label class="block pl-1 font-label-md text-on-surface-variant">Declaration Authorized Person Full Name</label>
                        <input type="text" name="declaration_authorized_person" value="{{ old('declaration_authorized_person') }}" class="bg-surface-container-low px-4 py-3 border rounded-xl border-outline-variant outline-none focus:ring-2 focus:ring-primary w-full font-body-sm" placeholder="Legal full name">
                    </div>
                    <div class="space-y-2">
                        <label class="block pl-1 font-label-md text-on-surface-variant">Declaration Official Title</label>
                        <input type="text" name="declaration_title" value="{{ old('declaration_title') }}" class="bg-surface-container-low px-4 py-3 border rounded-xl border-outline-variant outline-none focus:ring-2 focus:ring-primary w-full font-body-sm" placeholder="e.g., Director of Compliance Operations">
                    </div>
                    <div class="space-y-2">
                        <label class="block pl-1 font-label-md text-on-surface-variant">Upload Signature Image Copy</label>
                        <input type="file" name="declaration_signature_path" class="pt-3 w-full text-xs">
                        @error('declaration_signature_path') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-dashed border-outline-variant/60">
                <h3 class="flex items-center gap-2 mb-4 pb-3 border-b border-outline-variant/20 font-headline-md text-primary">
                    <span class="material-symbols-outlined">analytics</span> Secure Registration Metadata
                </h3>
                <div class="gap-6 grid grid-cols-1 md:grid-cols-3">
                    <div class="space-y-2">
                        <label class="block pl-1 font-label-md text-on-surface-variant">System Generated Reference Token (Auto)</label>
                        <input type="text" name="supplier_ref_number" value="{{ old('supplier_ref_number', 'SUP-' . strtoupper(Illuminate\Support\Str::random(4)) . '-' . rand(1000, 9999)) }}" class="bg-surface-container shadow-inner px-4 py-3 border rounded-xl border-outline-variant outline-none w-full font-body-sm font-bold text-primary" readonly>
                    </div>
                    <div class="space-y-2">
                        <label class="block pl-1 font-label-md text-on-surface-variant">Assigned Account Manager</label>
                        <input type="text" name="assigned_manager" value="{{ old('assigned_manager') }}" class="bg-surface-container-low px-4 py-3 border rounded-xl border-outline-variant outline-none focus:ring-2 focus:ring-primary w-full font-body-sm" placeholder="Internal Gluto Account Manager">
                    </div>
                    <div class="space-y-2">
                        <label class="block pl-1 font-label-md text-on-surface-variant">Onboarding Sourcing Route</label>
                        <input type="text" name="lead_source" value="{{ old('lead_source', 'Direct Organic Registration Form') }}" class="bg-surface-container-low px-4 py-3 border rounded-xl border-outline-variant outline-none focus:ring-2 focus:ring-primary w-full font-body-sm">
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center gap-4 pt-6 border-t border-outline-variant/30">
                <button type="button" @click="activeStep = 4" class="bg-surface-container-high hover:bg-surface-container px-6 py-3 rounded-xl font-label-md text-label-md text-on-surface-variant transition-all">Back</button>
                <button type="submit" class="flex items-center gap-2 bg-primary hover:bg-primary/90 shadow-lg shadow-primary/20 px-8 py-3.5 rounded-2xl font-label-md text-label-md text-white transition-all">
                    Submit Sourcing Application <span class="text-[20px] material-symbols-outlined">send</span>
                </button>
            </div>
        </div>
    </form>
</div>