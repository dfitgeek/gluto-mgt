<div class="flex-1 mx-auto my-12 p-gutter w-full max-w-5xl">

    <div class="mb-8 text-center">
        <h2 class="font-headline-lg font-bold text-headline-lg text-primary text-2xl">Supplier Corporate Profile
            Creation</h2>
        <p class="mt-1 font-body-sm text-body-sm text-on-surface-variant">Welcome, Please complete all steps below to submit your
            credentials to our compliance panel.</p>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 mb-6 p-4 border border-red-200 rounded-xl font-medium text-red-800 text-xs">
            <p class="flex items-center gap-1 mb-1 font-bold"><span
                    class="text-[16px] material-symbols-outlined">error</span> Verification fields contain validation gaps:
            </p>
            <ul class="space-y-0.5 opacity-90 pl-1 list-disc list-inside">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.suppliers.user.store', ['token' => $token]) }}" method="post"
        enctype="multipart/form-data" x-data="{
            activeStep: 1,
            init() {
                @if($errors->hasAny(['company_name', 'reg_number', 'year_established', 'email_address', 'phone_telephone', 'address', 'password', 'names_of_board_directors', 'director_email']))
                    this.activeStep = 1;
                @elseif($errors->hasAny(['rep_legal_name', 'rep_position_title', 'rep_email', 'rep_phone_number']))
                    this.activeStep = 2;
                @elseif($errors->hasAny(['currency_accepted', 'categorization_of_products', 'overall_moqs', 'production_capacity']))
                    this.activeStep = 3;
                @elseif($errors->hasAny(['file_sales_contract', 'file_commercial_invoice', 'file_packing_list', 'file_product_spec_sheet', 'file_test_analysis_report', 'product_manufacturing_certifications', 'returns_warranty_policy', 'file_others', 'supplier_invoice', 'proforma_invoice']))
                    this.activeStep = 4;
                @elseif($errors->hasAny(['declaration_authorized_person', 'declaration_title', 'declaration_signature_path']))
                    this.activeStep = 5;
                @endif
            }
        }" class="space-y-6">

        @csrf

        <div class="bg-surface-container-low shadow-sm mb-8 p-5 border rounded-3xl border-outline-variant/20">
            <div class="relative flex justify-between items-center mx-auto px-4 max-w-4xl">
                <div class="relative flex flex-col items-center cursor-pointer" @click="activeStep = 1">
                    <div class="flex justify-center items-center rounded-full w-9 h-9 font-bold text-xs transition-all"
                        :class="activeStep === 1 ? 'bg-primary text-white ring-4 ring-primary/20' : 'bg-white border-2 border-outline text-on-surface-variant'">
                        1</div>
                    <span class="hidden sm:block mt-1.5 font-label-sm font-medium text-[10px]"
                        :class="activeStep === 1 ? 'text-primary font-bold' : 'text-on-surface-variant'">Company
                        Info</span>
                </div>
                <div class="flex-1 mx-1 h-0.5" :class="activeStep > 1 ? 'bg-primary' : 'bg-outline-variant'"></div>
                <div class="relative flex flex-col items-center cursor-pointer" @click="activeStep = 2">
                    <div class="flex justify-center items-center rounded-full w-9 h-9 font-bold text-xs transition-all"
                        :class="activeStep === 2 ? 'bg-primary text-white ring-4 ring-primary/20' : 'bg-white border-2 border-outline text-on-surface-variant'">
                        2</div>
                    <span class="hidden sm:block mt-1.5 font-label-sm font-medium text-[10px]"
                        :class="activeStep === 2 ? 'text-primary font-bold' : 'text-on-surface-variant'">Legal
                        Rep</span>
                </div>
                <div class="flex-1 mx-1 h-0.5" :class="activeStep > 2 ? 'bg-primary' : 'bg-outline-variant'"></div>
                <div class="relative flex flex-col items-center cursor-pointer" @click="activeStep = 3">
                    <div class="flex justify-center items-center rounded-full w-9 h-9 font-bold text-xs transition-all"
                        :class="activeStep === 3 ? 'bg-primary text-white ring-4 ring-primary/20' : 'bg-white border-2 border-outline text-on-surface-variant'">
                        3</div>
                    <span class="hidden sm:block mt-1.5 font-label-sm font-medium text-[10px]"
                        :class="activeStep === 3 ? 'text-primary font-bold' : 'text-on-surface-variant'">Capabilities</span>
                </div>
                <div class="flex-1 mx-1 h-0.5" :class="activeStep > 3 ? 'bg-primary' : 'bg-outline-variant'"></div>
                <div class="relative flex flex-col items-center cursor-pointer" @click="activeStep = 4">
                    <div class="flex justify-center items-center rounded-full w-9 h-9 font-bold text-xs transition-all"
                        :class="activeStep === 4 ? 'bg-primary text-white ring-4 ring-primary/20' : 'bg-white border-2 border-outline text-on-surface-variant'">
                        4</div>
                    <span class="hidden sm:block mt-1.5 font-label-sm font-medium text-[10px]"
                        :class="activeStep === 4 ? 'text-primary font-bold' : 'text-on-surface-variant'">Documentation</span>
                </div>
                <div class="flex-1 mx-1 h-0.5" :class="activeStep > 4 ? 'bg-primary' : 'bg-outline-variant'"></div>
                <div class="relative flex flex-col items-center cursor-pointer" @click="activeStep = 5">
                    <div class="flex justify-center items-center rounded-full w-9 h-9 font-bold text-xs transition-all"
                        :class="activeStep === 5 ? 'bg-primary text-white ring-4 ring-primary/20' : 'bg-white border-2 border-outline text-on-surface-variant'">
                        5</div>
                    <span class="hidden sm:block mt-1.5 font-label-sm font-medium text-[10px]"
                        :class="activeStep === 5 ? 'text-primary font-bold' : 'text-on-surface-variant'">Compliance &
                        Sign</span>
                </div>
            </div>
        </div>

        <div x-show="activeStep === 1"
            class="space-y-6 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40 animate-fadeIn">
            <h3
                class="flex items-center gap-2 pb-3 border-b border-outline-variant/20 font-headline-md font-bold text-primary text-lg">
                <span class="material-symbols-outlined">business</span> Step 1: Corporate Profile Identity</h3>

            <div class="gap-6 grid grid-cols-1 md:grid-cols-3">
                <div
                    class="flex items-center gap-6 md:col-span-3 bg-surface-container-lowest p-4 border border-dashed rounded-2xl border-outline-variant w-full">
                    <div
                        class="relative flex flex-shrink-0 justify-center items-center bg-surface-container shadow-inner rounded-2xl w-16 h-16 overflow-hidden">
                        <span class="text-outline text-[24px] material-symbols-outlined">add_photo_alternate</span>
                    </div>
                    <div class="space-y-1">
                        <label class="block font-label-md text-label-md text-primary cursor-pointer">
                            <span
                                class="inline-block bg-primary hover:bg-primary/90 shadow-sm px-4 py-1.5 rounded-xl font-bold text-white text-xs transition-all">Upload
                                Profile Logo Icon</span>
                            <input type="file" name="company_icon_path" class="hidden" accept="image/*"
                                onchange="document.getElementById('icon-file-name').innerText = this.files[0] ? this.files[0].name : 'No file chosen'">
                        </label>
                        <p id="icon-file-name" class="font-semibold text-[11px] text-secondary tracking-wide">No file
                            chosen</p>
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="block pl-1 font-semibold text-on-surface-variant text-xs">Company Name *</label>
                    <input type="text" name="company_name" value="{{ old('company_name') }}"
                        class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none w-full text-sm">
                </div>
                <div class="space-y-1">
                    <label class="block pl-1 font-semibold text-on-surface-variant text-xs">Registration Number
                        *</label>
                    <input type="text" name="reg_number" value="{{ old('reg_number') }}"
                        class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none w-full text-sm">
                </div>
                <div class="space-y-1">
                    <label class="block pl-1 font-semibold text-on-surface-variant text-xs">Year Established</label>
                    <input type="number" name="year_established" value="{{ old('year_established') }}"
                        class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none w-full text-sm"
                        placeholder="YYYY">
                </div>
                <div class="space-y-1">
                    <label class="block pl-1 font-semibold text-on-surface-variant text-xs">Corporate Email Address
                        *</label>
                    <input type="email" name="email_address" value="{{ old('email_address', $targetUser->email) }}"
                        class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none w-full text-sm">
                </div>
                <div class="space-y-1">
                    <label class="block pl-1 font-semibold text-on-surface-variant text-xs">Phone / Telephone *</label>
                    <input type="text" name="phone_telephone" value="{{ old('phone_telephone') }}"
                        class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none w-full text-sm"
                        placeholder="+1 (555) 000-0000">
                </div>
                <div class="space-y-1">
                    <label class="block pl-1 font-semibold text-on-surface-variant text-xs">WhatsApp Contact
                        Link</label>
                    <input type="text" name="whatsapp_contact" value="{{ old('whatsapp_contact') }}"
                        class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none w-full text-sm"
                        placeholder="Mobile phone tracks">
                </div>
                <div class="space-y-1">
                    <label class="block pl-1 font-semibold text-on-surface-variant text-xs">Type of Business
                        Structure</label>
                    <select name="type_of_business"
                        class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none w-full text-sm">
                        <option value="Manufacturer">Manufacturer</option>
                        <option value="Wholesaler">Wholesaler</option>
                        <option value="Distributor">Distributor</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="block pl-1 font-semibold text-on-surface-variant text-xs">Nature of
                        Business</label>
                    <input type="text" name="nature_of_business" value="{{ old('nature_of_business') }}"
                        class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none w-full text-sm"
                        placeholder="Sourcing operations description">
                </div>
                <div class="space-y-1">
                    <label class="block pl-1 font-semibold text-on-surface-variant text-xs">Website URL</label>
                    <input type="text" name="website" value="{{ old('website') }}"
                        class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none w-full text-sm"
                        placeholder="www.domain.com">
                </div>

                <div
                    class="gap-4 grid grid-cols-1 md:grid-cols-2 md:col-span-3 pt-4 border-t border-dashed border-outline-variant/50">
                    <div class="space-y-1">
                        <label class="block pl-1 font-bold text-primary text-xs">Setup Account Password *</label>
                        <input type="password" name="password"
                            class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none w-full text-sm"
                            placeholder="Minimum 8 characters">
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-1 font-bold text-primary text-xs">Confirm Account Password *</label>
                        <input type="password" name="password_confirmation"
                            class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none w-full text-sm"
                            placeholder="Re-type password strings">
                    </div>
                </div>

                <div
                    class="gap-4 grid grid-cols-1 md:grid-cols-3 md:col-span-3 pt-4 border-t border-dashed border-outline-variant/50">
                    <div class="space-y-1">
                        <label class="block pl-1 font-semibold text-on-surface-variant text-xs">Names of Board
                            Directors</label>
                        <input type="text" name="names_of_board_directors" value="{{ old('names_of_board_directors') }}"
                            class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none w-full text-sm"
                            placeholder="Primary board members list">
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-1 font-semibold text-on-surface-variant text-xs">Director Position
                            Title</label>
                        <input type="text" name="director_position_title" value="{{ old('director_position_title') }}"
                            class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none w-full text-sm"
                            placeholder="e.g., Lead Chairman">
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-1 font-semibold text-on-surface-variant text-xs">Director Executive
                            Email</label>
                        <input type="email" name="director_email" value="{{ old('director_email') }}"
                            class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none w-full text-sm"
                            placeholder="director@company.com">
                    </div>
                </div>

                <div class="space-y-3 md:col-span-3 pt-4 border-t border-dashed border-outline-variant/50">
                    <p class="font-bold text-primary text-xs">Corporate Social Media Channels Identifiers</p>
                    <div class="gap-3 grid grid-cols-1 sm:grid-cols-5 text-xs">
                        <div><label class="block mb-1 text-[11px]">X (Twitter)</label><input type="text"
                                name="social_twitter"
                                class="bg-surface-container-low p-2 border rounded-lg outline-none w-full"
                                placeholder="@handle"></div>
                        <div><label class="block mb-1 text-[11px]">Facebook</label><input type="text"
                                name="social_facebook"
                                class="bg-surface-container-low p-2 border rounded-lg outline-none w-full"
                                placeholder="page_url"></div>
                        <div><label class="block mb-1 text-[11px]">Instagram</label><input type="text"
                                name="social_instagram"
                                class="bg-surface-container-low p-2 border rounded-lg outline-none w-full"
                                placeholder="@profile"></div>
                        <div><label class="block mb-1 text-[11px]">Threads</label><input type="text"
                                name="social_threads"
                                class="bg-surface-container-low p-2 border rounded-lg outline-none w-full"
                                placeholder="@profile"></div>
                        <div><label class="block mb-1 text-[11px]">LinkedIn</label><input type="text"
                                name="social_linkedin"
                                class="bg-surface-container-low p-2 border rounded-lg outline-none w-full"
                                placeholder="company/page"></div>
                    </div>
                </div>

                <div class="space-y-1 md:col-span-3">
                    <label class="block pl-1 font-semibold text-on-surface-variant text-xs">Registered Corporate
                        Physical Location Address *</label>
                    <textarea name="address" rows="3"
                        class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none w-full text-sm">{{ old('address') }}</textarea>
                </div>
            </div>
            <div class="flex justify-end pt-4"><button type="button" @click="activeStep = 2"
                    class="flex items-center gap-2 bg-primary px-5 py-2.5 rounded-xl font-bold text-white text-xs cursor-pointer">Next
                    Step <span class="text-[16px] material-symbols-outlined">arrow_forward</span></button></div>
        </div>

        <div x-show="activeStep === 2" x-cloak
            class="space-y-6 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40 animate-fadeIn">
            <h3
                class="flex items-center gap-2 pb-3 border-b border-outline-variant/20 font-headline-md font-bold text-primary text-lg">
                <span class="material-symbols-outlined">account_circle</span> Step 2: Authorized Representative Account
                Coordinates</h3>
            <div class="gap-6 grid grid-cols-1 md:grid-cols-2">
                <div class="space-y-1">
                    <label class="block pl-1 font-semibold text-on-surface-variant text-xs">Legal Full Name *</label>
                    <input type="text" name="rep_legal_name" value="{{ old('rep_legal_name', $targetUser->name) }}"
                        class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none w-full text-sm">
                </div>
                <div class="space-y-1">
                    <label class="block pl-1 font-semibold text-on-surface-variant text-xs">Position Official
                        Title</label>
                    <input type="text" name="rep_position_title" value="{{ old('rep_position_title') }}"
                        class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none w-full text-sm"
                        placeholder="e.g., Logistics Operations Sourcing Agent">
                </div>
                <div class="space-y-1">
                    <label class="block pl-1 font-semibold text-on-surface-variant text-xs">Direct Email Address
                        *</label>
                    <input type="email" name="rep_email" value="{{ old('rep_email', $targetUser->email) }}"
                        class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none w-full text-sm">
                </div>
                <div class="space-y-1">
                    <label class="block pl-1 font-semibold text-on-surface-variant text-xs">Direct Phone / Mobile Number
                        *</label>
                    <input type="text" name="rep_phone_number" value="{{ old('rep_phone_number') }}"
                        class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none w-full text-sm">
                </div>
            </div>
            <div class="flex justify-between pt-4">
                <button type="button" @click="activeStep = 1"
                    class="bg-surface-container-high px-5 py-2.5 rounded-xl font-bold text-on-surface-variant text-xs">Back</button>
                <button type="button" @click="activeStep = 3"
                    class="flex items-center gap-2 bg-primary px-5 py-2.5 rounded-xl font-bold text-white text-xs cursor-pointer">Next
                    Step <span class="text-[16px] material-symbols-outlined">arrow_forward</span></button>
            </div>
        </div>

        <div x-show="activeStep === 3" x-cloak
            class="space-y-6 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40 animate-fadeIn">
            <h3
                class="flex items-center gap-2 pb-3 border-b border-outline-variant/20 font-headline-md font-bold text-primary text-lg">
                <span class="material-symbols-outlined">assignment_turned_in</span> Step 3: Operational Logistics
                Capabilities</h3>
            <div class="gap-6 grid grid-cols-1 md:grid-cols-3">
                <div class="space-y-1"><label class="block font-semibold text-xs">Product Categorization</label><input
                        type="text" name="categorization_of_products"
                        class="bg-surface-container-low px-4 py-2.5 border rounded-xl w-full text-sm"
                        placeholder="e.g., Dry Cargo, Frozen Goods FMCG"></div>
                <div class="space-y-1"><label class="block font-semibold text-xs">Minimum Order Quantities
                        (MOQs)</label><input type="text" name="overall_moqs"
                        class="bg-surface-container-low px-4 py-2.5 border rounded-xl w-full text-sm"
                        placeholder="Global structural minimum order metrics"></div>
                <div class="space-y-1"><label class="block font-semibold text-xs">Production Capacity</label><input
                        type="text" name="production_capacity"
                        class="bg-surface-container-low px-4 py-2.5 border rounded-xl w-full text-sm"
                        placeholder="Sizing output metrics parameters"></div>
                <div class="space-y-1"><label class="block font-semibold text-xs">Currency Accepted *</label><input
                        type="text" name="currency_accepted" value="{{ old('currency_accepted', 'Naira') }}"
                        class="bg-surface-container-low px-4 py-2.5 border rounded-xl w-full text-sm"></div>
                <div class="space-y-1"><label class="block font-semibold text-xs">Shipping Methods
                        Available</label><input type="text" name="shipping_methods_available"
                        class="bg-surface-container-low px-4 py-2.5 border rounded-xl w-full text-sm"
                        placeholder="Sea Freight, Air Freight, Overland road carriers"></div>
                <div class="space-y-1"><label class="block font-semibold text-xs">Pricing Structure Type</label><input
                        type="text" name="pricing_structure_type"
                        class="bg-surface-container-low px-4 py-2.5 border rounded-xl w-full text-sm"
                        placeholder="e.g., Bulk Tier Rates, Per Unit Fixed"></div>

                <div
                    class="flex items-center gap-3 md:col-span-3 bg-surface-container-lowest/60 p-3 pt-2 border border-dashed rounded-xl">
                    <input type="checkbox" name="ability_to_provide_samples" value="1" id="samples_toggle"
                        class="rounded w-4 h-4 text-primary">
                    <label for="samples_toggle" class="font-semibold text-on-surface-variant text-xs cursor-pointer">Our
                        enterprise is fully equipped and able to provide physical samples to matching buyers</label>
                </div>

                <div class="space-y-1 md:col-span-3"><label class="block font-semibold text-xs">Manufacturing/Warehouse
                        Assembly Locations</label><input type="text" name="manufacturing_locations"
                        class="bg-surface-container-low px-4 py-2.5 border rounded-xl w-full text-sm"
                        placeholder="Full addresses of regional extraction plants or hub grids"></div>
                {{-- <div class="space-y-1 md:col-span-3"><label class="block font-semibold text-xs">Customization & OEM
                        Capabilities Log</label><textarea name="customization_options" rows="2"
                        class="bg-surface-container-low px-4 py-2.5 border rounded-xl w-full text-sm"
                        placeholder="Outline special sizing formats or private white-label assembly configurations log specs..."></textarea>
                </div> --}}
                <div class="space-y-1 md:col-span-3"><label class="block font-semibold text-xs">Payment Terms & Draft
                        Deposit Schedule Conditions</label><textarea name="payment_terms" rows="2"
                        class="bg-surface-container-low px-4 py-2.5 border rounded-xl w-full text-sm"
                        placeholder="e.g., 30% TT advance deposit upon proforma invoice issue..."></textarea></div>
            </div>
            <div class="flex justify-between pt-4">
                <button type="button" @click="activeStep = 2"
                    class="bg-surface-container-high px-5 py-2.5 rounded-xl font-bold text-on-surface-variant text-xs">Back</button>
                <button type="button" @click="activeStep = 4"
                    class="flex items-center gap-2 bg-primary px-5 py-2.5 rounded-xl font-bold text-white text-xs cursor-pointer">Next
                    Step <span class="text-[16px] material-symbols-outlined">arrow_forward</span></button>
            </div>
        </div>

        <div x-show="activeStep === 4" x-cloak
            class="space-y-6 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40 animate-fadeIn">
            <h3
                class="flex items-center gap-2 pb-3 border-b border-outline-variant/20 font-headline-md font-bold text-primary text-lg">
                <span class="material-symbols-outlined">cloud_upload</span> Step 4: Core Compliance Documentation Vault
            </h3>
            <p class="-mt-3 text-on-surface-variant text-xs">Please upload clean scanned documents. If the attachment
                applies to a specific inventory catalog product, specify its Reference Number.</p>

            <div class="gap-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 text-xs">
                @php
                    $personalVaultMap = [
                        'file_sales_contract' => 'Sales Sourcing Contract',
                        'file_commercial_invoice' => 'Commercial Invoice',
                        'file_packing_list' => 'Packing List Manifest',
                        'file_product_spec_sheet' => 'Product Specification Sheet',
                        'file_test_analysis_report' => 'Test Analysis Report',
                        'product_manufacturing_certifications' => 'Manufacturing Certification',
                        'returns_warranty_policy' => 'Returns & Warranty Policy',
                        'file_others' => 'Other Supporting Documents',
                        'supplier_invoice' => 'Supplier Invoice Log',
                        'proforma_invoice' => 'Proforma Invoice Document',
                    ];
                @endphp

                @foreach($personalVaultMap as $inputName => $displayLabel)
                    <div
                        class="flex flex-col justify-between space-y-3 bg-surface-container-lowest shadow-sm p-5 border rounded-2xl border-outline-variant/60">
                        <div>
                            <span class="block font-bold text-primary text-sm leading-tight">{{ $displayLabel }}</span>
                            <span class="block mt-0.5 text-[10px] text-on-surface-variant/80">Accepts: PDF, DOCX, Images
                                (Max: 5MB)</span>
                        </div>

                        <input type="file" name="{{ $inputName }}"
                            class="hover:file:bg-primary/20 file:bg-primary/10 file:mr-3 file:px-3 file:py-1.5 file:border-0 file:rounded-xl w-full file:font-semibold text-[11px] text-on-surface-variant file:text-primary file:text-xs">

                        <div class="space-y-1 pt-1.5 border-background border-t">
                            <label
                                class="block font-bold text-[10px] text-on-surface-variant uppercase tracking-wider">Associated
                                Product Ref (Optional)</label>
                            <input type="text" name="{{ $inputName }}_prod_ref" value="{{ old($inputName . '_prod_ref') }}"
                                class="bg-white px-3 py-1.5 border rounded-lg border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-mono text-primary text-xs"
                                placeholder="e.g., PROD-4402">
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-between pt-4">
                <button type="button" @click="activeStep = 3"
                    class="bg-surface-container-high px-5 py-2.5 rounded-xl font-bold text-on-surface-variant text-xs">Back</button>
                <button type="button" @click="activeStep = 5"
                    class="flex items-center gap-2 bg-primary px-5 py-2.5 rounded-xl font-bold text-white text-xs cursor-pointer">Next
                    Step <span class="text-[16px] material-symbols-outlined">arrow_forward</span></button>
            </div>
        </div>

        <div x-show="activeStep === 5"
            class="space-y-6 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40 animate-fadeIn">
            <h3
                class="flex items-center gap-2 pb-3 border-b border-outline-variant/20 font-headline-md font-bold text-primary text-lg">
                <span class="material-symbols-outlined">gavel</span> Step 5: Compliance Declarations & Attestation</h3>

            <div class="gap-4 grid grid-cols-1 md:grid-cols-2 text-xs">
                <label
                    class="flex items-center gap-3 bg-surface-container-lowest hover:bg-surface-container-low p-4 border rounded-xl border-outline-variant/60 transition-all cursor-pointer">
                    <input type="checkbox" name="declares_gmo_free" value="1" class="rounded w-4 h-4 text-primary">
                    <span class="font-semibold text-primary">GMO Free Compliant Certification</span>
                </label>
                <label
                    class="flex items-center gap-3 bg-surface-container-lowest hover:bg-surface-container-low p-4 border rounded-xl border-outline-variant/60 transition-all cursor-pointer">
                    <input type="checkbox" name="declares_gluten_free" value="1" class="rounded w-4 h-4 text-primary">
                    <span class="font-semibold text-primary">Gluten-Free Ingredients Assurance</span>
                </label>
                <label
                    class="flex items-center gap-3 bg-surface-container-lowest hover:bg-surface-container-low p-4 border rounded-xl border-outline-variant/60 transition-all cursor-pointer">
                    <input type="checkbox" name="declares_non_irradiated" value="1"
                        class="rounded w-4 h-4 text-primary">
                    <span class="font-semibold text-primary">Non-Irradiated / Non-Ionised Process Declared</span>
                </label>
                <label
                    class="flex items-center gap-3 bg-surface-container-lowest hover:bg-surface-container-low p-4 border rounded-xl border-outline-variant/60 transition-all cursor-pointer">
                    <input type="checkbox" name="declares_no_nanomaterials" value="1"
                        class="rounded w-4 h-4 text-primary">
                    <span class="font-semibold text-primary">No synthetic Nanomaterials components introduced</span>
                </label>
                <label
                    class="flex items-center gap-3 md:col-span-2 bg-surface-container-lowest hover:bg-surface-container-low p-4 border rounded-xl border-outline-variant/60 transition-all cursor-pointer">
                    <input type="checkbox" name="complies_haccp_gmp" value="1" class="rounded w-4 h-4 text-primary">
                    <span class="font-semibold text-primary">HACCP / GMP Program Architecture Certified
                        Frameworks</span>
                </label>
            </div>

            <div class="pt-4 border-t border-dashed border-outline-variant/60">
                <h4 class="flex items-center gap-1 mb-3 font-label-md font-bold text-primary text-sm"><span
                        class="text-[18px] material-symbols-outlined">draw</span> Authorized Execution Sign-off Block
                </h4>
                <div class="gap-4 grid grid-cols-1 md:grid-cols-3">
                    <div class="space-y-1">
                        <label class="block font-semibold text-on-surface-variant text-xs">Signee Legal Full Name
                            *</label>
                        <input type="text" name="declaration_authorized_person"
                            class="bg-surface-container-low p-2.5 border rounded-xl outline-none w-full text-sm"
                            placeholder="Authorized corporate officer full name">
                    </div>
                    <div class="space-y-1">
                        <label class="block font-semibold text-on-surface-variant text-xs">Official Position Title
                            *</label>
                        <input type="text" name="declaration_title"
                            class="bg-surface-container-low p-2.5 border rounded-xl outline-none w-full text-sm"
                            placeholder="e.g., Executive VP Supply Chain">
                    </div>
                    <div class="space-y-1">
                        <label class="block font-semibold text-on-surface-variant text-xs">Upload Signature Image copy
                            *</label>
                        <input type="file" name="declaration_signature_path" class="pt-1.5 w-full text-xs"
                            accept="image/*">
                    </div>
                </div>
            </div>

            <div class="gap-4 grid grid-cols-1 md:grid-cols-2 pt-4 border-t border-dashed border-outline-variant/60">
                <div class="space-y-1">
                    <label class="block font-semibold text-on-surface-variant text-xs">Your System Reference Protocol
                        Token (Auto Assigned)</label>
                    <input type="text" name="supplier_ref_number"
                        value="SUP-{{ strtoupper(Illuminate\Support\Str::random(4)) }}-{{ rand(1000, 9999) }}"
                        class="bg-surface-container shadow-inner p-2.5 border rounded-xl outline-none w-full font-mono font-bold text-primary text-sm"
                        readonly>
                </div>
            </div>

            <div class="flex justify-between items-center pt-6 border-t border-outline-variant/30">
                <button type="button" @click="activeStep = 4"
                    class="bg-surface-container-high px-5 py-2.5 rounded-xl font-bold text-on-surface-variant text-xs">Back</button>
                <button type="submit"
                    class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 shadow-emerald-600/10 shadow-lg px-8 py-3.5 rounded-2xl font-label-md font-bold text-white text-xs cursor-pointer">
                    Finalize & Submit Sourcing Application <span
                        class="text-[18px] material-symbols-outlined">send</span>
                </button>
            </div>
        </div>
    </form>
</div>
