<div class="p-gutter mx-auto my-12 w-full max-w-5xl flex-1">

    <div class="mb-8 text-center">
        <h2 class="font-headline-lg text-headline-lg text-primary text-2xl font-bold">Supplier Corporate Profile
            Creation</h2>
        <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Welcome, Please complete all steps below to submit your
            credentials to our compliance panel.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-xs font-medium text-red-800">
            <p class="mb-1 flex items-center gap-1 font-bold"><span
                    class="material-symbols-outlined text-[16px]">error</span> Verification fields contain validation gaps:
            </p>
            <ul class="list-inside list-disc space-y-0.5 pl-1 opacity-90">
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

        <div class="bg-surface-container-low border-outline-variant/20 mb-8 rounded-3xl border p-5 shadow-sm">
            <div class="relative mx-auto flex max-w-4xl items-center justify-between px-4">
                <div class="relative flex cursor-pointer flex-col items-center" @click="activeStep = 1">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full text-xs font-bold transition-all"
                        :class="activeStep === 1 ? 'bg-primary text-white ring-4 ring-primary/20' : 'bg-white border-2 border-outline text-on-surface-variant'">
                        1</div>
                    <span class="font-label-sm mt-1.5 hidden text-[10px] font-medium sm:block"
                        :class="activeStep === 1 ? 'text-primary font-bold' : 'text-on-surface-variant'">Company
                        Info</span>
                </div>
                <div class="mx-1 h-0.5 flex-1" :class="activeStep > 1 ? 'bg-primary' : 'bg-outline-variant'"></div>
                <div class="relative flex cursor-pointer flex-col items-center" @click="activeStep = 2">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full text-xs font-bold transition-all"
                        :class="activeStep === 2 ? 'bg-primary text-white ring-4 ring-primary/20' : 'bg-white border-2 border-outline text-on-surface-variant'">
                        2</div>
                    <span class="font-label-sm mt-1.5 hidden text-[10px] font-medium sm:block"
                        :class="activeStep === 2 ? 'text-primary font-bold' : 'text-on-surface-variant'">Legal
                        Rep</span>
                </div>
                <div class="mx-1 h-0.5 flex-1" :class="activeStep > 2 ? 'bg-primary' : 'bg-outline-variant'"></div>
                <div class="relative flex cursor-pointer flex-col items-center" @click="activeStep = 3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full text-xs font-bold transition-all"
                        :class="activeStep === 3 ? 'bg-primary text-white ring-4 ring-primary/20' : 'bg-white border-2 border-outline text-on-surface-variant'">
                        3</div>
                    <span class="font-label-sm mt-1.5 hidden text-[10px] font-medium sm:block"
                        :class="activeStep === 3 ? 'text-primary font-bold' : 'text-on-surface-variant'">Capabilities</span>
                </div>
                <div class="mx-1 h-0.5 flex-1" :class="activeStep > 3 ? 'bg-primary' : 'bg-outline-variant'"></div>
                <div class="relative flex cursor-pointer flex-col items-center" @click="activeStep = 4">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full text-xs font-bold transition-all"
                        :class="activeStep === 4 ? 'bg-primary text-white ring-4 ring-primary/20' : 'bg-white border-2 border-outline text-on-surface-variant'">
                        4</div>
                    <span class="font-label-sm mt-1.5 hidden text-[10px] font-medium sm:block"
                        :class="activeStep === 4 ? 'text-primary font-bold' : 'text-on-surface-variant'">Documentation</span>
                </div>
                <div class="mx-1 h-0.5 flex-1" :class="activeStep > 4 ? 'bg-primary' : 'bg-outline-variant'"></div>
                <div class="relative flex cursor-pointer flex-col items-center" @click="activeStep = 5">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full text-xs font-bold transition-all"
                        :class="activeStep === 5 ? 'bg-primary text-white ring-4 ring-primary/20' : 'bg-white border-2 border-outline text-on-surface-variant'">
                        5</div>
                    <span class="font-label-sm mt-1.5 hidden text-[10px] font-medium sm:block"
                        :class="activeStep === 5 ? 'text-primary font-bold' : 'text-on-surface-variant'">Compliance &
                        Sign</span>
                </div>
            </div>
        </div>

        <div x-show="activeStep === 1"
            class="border-outline-variant/40 animate-fadeIn space-y-6 rounded-[2rem] border bg-white p-8 shadow-sm">
            <h3
                class="border-outline-variant/20 font-headline-md text-primary flex items-center gap-2 border-b pb-3 text-lg font-bold">
                <span class="material-symbols-outlined">business</span> Step 1: Corporate Profile Identity</h3>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <div
                    class="bg-surface-container-lowest border-outline-variant flex w-full items-center gap-6 rounded-2xl border border-dashed p-4 md:col-span-3">
                    <div
                        class="bg-surface-container relative flex h-16 w-16 flex-shrink-0 items-center justify-center overflow-hidden rounded-2xl shadow-inner">
                        <span class="text-outline material-symbols-outlined text-[24px]">add_photo_alternate</span>
                    </div>
                    <div class="space-y-1">
                        <label class="font-label-md text-label-md text-primary block cursor-pointer">
                            <span
                                class="bg-primary hover:bg-primary/90 inline-block rounded-xl px-4 py-1.5 text-xs font-bold text-white shadow-sm transition-all">Upload
                                Profile Logo Icon</span>
                            <input type="file" name="company_icon_path" class="hidden" accept="image/*"
                                onchange="document.getElementById('icon-file-name').innerText = this.files[0] ? this.files[0].name : 'No file chosen'">
                        </label>
                        <p id="icon-file-name" class="text-secondary text-[11px] font-semibold tracking-wide">No file
                            chosen</p>
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-on-surface-variant block pl-1 text-xs font-semibold">Company Name *</label>
                    <input type="text" name="company_name" value="{{ old('company_name') }}"
                        class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2.5 text-sm outline-none">
                </div>
                <div class="space-y-1">
                    <label class="text-on-surface-variant block pl-1 text-xs font-semibold">Registration Number
                        *</label>
                    <input type="text" name="reg_number" value="{{ old('reg_number') }}"
                        class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2.5 text-sm outline-none">
                </div>
                <div class="space-y-1">
                    <label class="text-on-surface-variant block pl-1 text-xs font-semibold">Year Established</label>
                    <input type="number" name="year_established" value="{{ old('year_established') }}"
                        class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2.5 text-sm outline-none"
                        placeholder="YYYY">
                </div>
                <div class="space-y-1">
                    <label class="text-on-surface-variant block pl-1 text-xs font-semibold">Corporate Email Address
                        *</label>
                    <input type="email" name="email_address" value="{{ old('email_address', $targetUser->email) }}"
                        class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2.5 text-sm outline-none">
                </div>
                <div class="space-y-1">
                    <label class="text-on-surface-variant block pl-1 text-xs font-semibold">Phone / Telephone *</label>
                    <input type="text" name="phone_telephone" value="{{ old('phone_telephone') }}"
                        class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2.5 text-sm outline-none"
                        placeholder="+1 (555) 000-0000">
                </div>
                <div class="space-y-1">
                    <label class="text-on-surface-variant block pl-1 text-xs font-semibold">WhatsApp Contact
                        Link</label>
                    <input type="text" name="whatsapp_contact" value="{{ old('whatsapp_contact') }}"
                        class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2.5 text-sm outline-none"
                        placeholder="Mobile phone tracks">
                </div>
                <div class="space-y-1">
                    <label class="text-on-surface-variant block pl-1 text-xs font-semibold">Type of Business
                        Structure</label>
                    <select name="type_of_business"
                        class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2.5 text-sm outline-none">
                        <option value="Manufacturer">Manufacturer</option>
                        <option value="Wholesaler">Wholesaler</option>
                        <option value="Distributor">Distributor</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="text-on-surface-variant block pl-1 text-xs font-semibold">Nature of
                        Business</label>
                    <input type="text" name="nature_of_business" value="{{ old('nature_of_business') }}"
                        class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2.5 text-sm outline-none"
                        placeholder="Sourcing operations description">
                </div>
                <div class="space-y-1">
                    <label class="text-on-surface-variant block pl-1 text-xs font-semibold">Website URL</label>
                    <input type="text" name="website" value="{{ old('website') }}"
                        class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2.5 text-sm outline-none"
                        placeholder="www.domain.com">
                </div>

                <div
                    class="border-outline-variant/50 grid grid-cols-1 gap-4 border-t border-dashed pt-4 md:col-span-3 md:grid-cols-2">
                    <div class="space-y-1">
                        <label class="text-primary block pl-1 text-xs font-bold">Setup Account Password *</label>
                        <input type="password" name="password"
                            class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2.5 text-sm outline-none"
                            placeholder="Minimum 8 characters">
                    </div>
                    <div class="space-y-1">
                        <label class="text-primary block pl-1 text-xs font-bold">Confirm Account Password *</label>
                        <input type="password" name="password_confirmation"
                            class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2.5 text-sm outline-none"
                            placeholder="Re-type password strings">
                    </div>
                </div>

                <div
                    class="border-outline-variant/50 grid grid-cols-1 gap-4 border-t border-dashed pt-4 md:col-span-3 md:grid-cols-3">
                    <div class="space-y-1">
                        <label class="text-on-surface-variant block pl-1 text-xs font-semibold">Names of Board
                            Directors</label>
                        <input type="text" name="names_of_board_directors" value="{{ old('names_of_board_directors') }}"
                            class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2.5 text-sm outline-none"
                            placeholder="Primary board members list">
                    </div>
                    <div class="space-y-1">
                        <label class="text-on-surface-variant block pl-1 text-xs font-semibold">Director Position
                            Title</label>
                        <input type="text" name="director_position_title" value="{{ old('director_position_title') }}"
                            class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2.5 text-sm outline-none"
                            placeholder="e.g., Lead Chairman">
                    </div>
                    <div class="space-y-1">
                        <label class="text-on-surface-variant block pl-1 text-xs font-semibold">Director Executive
                            Email</label>
                        <input type="email" name="director_email" value="{{ old('director_email') }}"
                            class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2.5 text-sm outline-none"
                            placeholder="director@company.com">
                    </div>
                </div>

                <div class="border-outline-variant/50 space-y-3 border-t border-dashed pt-4 md:col-span-3">
                    <p class="text-primary text-xs font-bold">Corporate Social Media Channels Identifiers</p>
                    <div class="grid grid-cols-1 gap-3 text-xs sm:grid-cols-5">
                        <div><label class="mb-1 block text-[11px]">X (Twitter)</label><input type="text"
                                name="social_twitter"
                                class="bg-surface-container-low w-full rounded-lg border p-2 outline-none"
                                placeholder="@handle"></div>
                        <div><label class="mb-1 block text-[11px]">Facebook</label><input type="text"
                                name="social_facebook"
                                class="bg-surface-container-low w-full rounded-lg border p-2 outline-none"
                                placeholder="page_url"></div>
                        <div><label class="mb-1 block text-[11px]">Instagram</label><input type="text"
                                name="social_instagram"
                                class="bg-surface-container-low w-full rounded-lg border p-2 outline-none"
                                placeholder="@profile"></div>
                        <div><label class="mb-1 block text-[11px]">Threads</label><input type="text"
                                name="social_threads"
                                class="bg-surface-container-low w-full rounded-lg border p-2 outline-none"
                                placeholder="@profile"></div>
                        <div><label class="mb-1 block text-[11px]">LinkedIn</label><input type="text"
                                name="social_linkedin"
                                class="bg-surface-container-low w-full rounded-lg border p-2 outline-none"
                                placeholder="company/page"></div>
                    </div>
                </div>

                <div class="space-y-1 md:col-span-3">
                    <label class="text-on-surface-variant block pl-1 text-xs font-semibold">Registered Corporate
                        Physical Location Address *</label>
                    <textarea name="address" rows="3"
                        class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2.5 text-sm outline-none">{{ old('address') }}</textarea>
                </div>
            </div>
            <div class="flex justify-end pt-4"><button type="button" @click="activeStep = 2"
                    class="bg-primary flex cursor-pointer items-center gap-2 rounded-xl px-5 py-2.5 text-xs font-bold text-white">Next
                    Step <span class="material-symbols-outlined text-[16px]">arrow_forward</span></button></div>
        </div>

        <div x-show="activeStep === 2" x-cloak
            class="border-outline-variant/40 animate-fadeIn space-y-6 rounded-[2rem] border bg-white p-8 shadow-sm">
            <h3
                class="border-outline-variant/20 font-headline-md text-primary flex items-center gap-2 border-b pb-3 text-lg font-bold">
                <span class="material-symbols-outlined">account_circle</span> Step 2: Authorized Representative Account
                Coordinates</h3>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="space-y-1">
                    <label class="text-on-surface-variant block pl-1 text-xs font-semibold">Legal Full Name *</label>
                    <input type="text" name="rep_legal_name" value="{{ old('rep_legal_name', $targetUser->name) }}"
                        class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2.5 text-sm outline-none">
                </div>
                <div class="space-y-1">
                    <label class="text-on-surface-variant block pl-1 text-xs font-semibold">Position Official
                        Title</label>
                    <input type="text" name="rep_position_title" value="{{ old('rep_position_title') }}"
                        class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2.5 text-sm outline-none"
                        placeholder="e.g., Logistics Operations Sourcing Agent">
                </div>
                <div class="space-y-1">
                    <label class="text-on-surface-variant block pl-1 text-xs font-semibold">Direct Email Address
                        *</label>
                    <input type="email" name="rep_email" value="{{ old('rep_email', $targetUser->email) }}"
                        class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2.5 text-sm outline-none">
                </div>
                <div class="space-y-1">
                    <label class="text-on-surface-variant block pl-1 text-xs font-semibold">Direct Phone / Mobile Number
                        *</label>
                    <input type="text" name="rep_phone_number" value="{{ old('rep_phone_number') }}"
                        class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2.5 text-sm outline-none">
                </div>
            </div>
            <div class="flex justify-between pt-4">
                <button type="button" @click="activeStep = 1"
                    class="bg-surface-container-high text-on-surface-variant rounded-xl px-5 py-2.5 text-xs font-bold">Back</button>
                <button type="button" @click="activeStep = 3"
                    class="bg-primary flex cursor-pointer items-center gap-2 rounded-xl px-5 py-2.5 text-xs font-bold text-white">Next
                    Step <span class="material-symbols-outlined text-[16px]">arrow_forward</span></button>
            </div>
        </div>

        <div x-show="activeStep === 3" x-cloak
            class="border-outline-variant/40 animate-fadeIn space-y-6 rounded-[2rem] border bg-white p-8 shadow-sm">
            <h3
                class="border-outline-variant/20 font-headline-md text-primary flex items-center gap-2 border-b pb-3 text-lg font-bold">
                <span class="material-symbols-outlined">assignment_turned_in</span> Step 3: Operational Logistics
                Capabilities</h3>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <div class="space-y-1"><label class="block text-xs font-semibold">Product Categorization</label><input
                        type="text" name="categorization_of_products"
                        class="bg-surface-container-low w-full rounded-xl border px-4 py-2.5 text-sm"
                        placeholder="e.g., Dry Cargo, Frozen Goods FMCG"></div>
                <div class="space-y-1"><label class="block text-xs font-semibold">Minimum Order Quantities
                        (MOQs)</label><input type="text" name="overall_moqs"
                        class="bg-surface-container-low w-full rounded-xl border px-4 py-2.5 text-sm"
                        placeholder="Global structural minimum order metrics"></div>
                <div class="space-y-1"><label class="block text-xs font-semibold">Production Capacity</label><input
                        type="text" name="production_capacity"
                        class="bg-surface-container-low w-full rounded-xl border px-4 py-2.5 text-sm"
                        placeholder="Sizing output metrics parameters"></div>
                <div class="space-y-1"><label class="block text-xs font-semibold">Currency Accepted *</label><input
                        type="text" name="currency_accepted" value="{{ old('currency_accepted', 'Naira') }}"
                        class="bg-surface-container-low w-full rounded-xl border px-4 py-2.5 text-sm"></div>
                <div class="space-y-1"><label class="block text-xs font-semibold">Shipping Methods
                        Available</label><input type="text" name="shipping_methods_available"
                        class="bg-surface-container-low w-full rounded-xl border px-4 py-2.5 text-sm"
                        placeholder="Sea Freight, Air Freight, Overland road carriers"></div>
                <div class="space-y-1"><label class="block text-xs font-semibold">Pricing Structure Type</label><input
                        type="text" name="pricing_structure_type"
                        class="bg-surface-container-low w-full rounded-xl border px-4 py-2.5 text-sm"
                        placeholder="e.g., Bulk Tier Rates, Per Unit Fixed"></div>

                <div
                    class="bg-surface-container-lowest/60 flex items-center gap-3 rounded-xl border border-dashed p-3 pt-2 md:col-span-3">
                    <input type="checkbox" name="ability_to_provide_samples" value="1" id="samples_toggle"
                        class="text-primary h-4 w-4 rounded">
                    <label for="samples_toggle" class="text-on-surface-variant cursor-pointer text-xs font-semibold">Our
                        enterprise is fully equipped and able to provide physical samples to matching buyers</label>
                </div>

                <div class="space-y-1 md:col-span-3"><label class="block text-xs font-semibold">Manufacturing/Warehouse
                        Assembly Locations</label><input type="text" name="manufacturing_locations"
                        class="bg-surface-container-low w-full rounded-xl border px-4 py-2.5 text-sm"
                        placeholder="Full addresses of regional extraction plants or hub grids"></div>
                {{-- <div class="space-y-1 md:col-span-3"><label class="block text-xs font-semibold">Customization & OEM
                        Capabilities Log</label><textarea name="customization_options" rows="2"
                        class="bg-surface-container-low w-full rounded-xl border px-4 py-2.5 text-sm"
                        placeholder="Outline special sizing formats or private white-label assembly configurations log specs..."></textarea>
                </div> --}}
                <div class="space-y-1 md:col-span-3"><label class="block text-xs font-semibold">Payment Terms & Draft
                        Deposit Schedule Conditions</label><textarea name="payment_terms" rows="2"
                        class="bg-surface-container-low w-full rounded-xl border px-4 py-2.5 text-sm"
                        placeholder="e.g., 30% TT advance deposit upon proforma invoice issue..."></textarea></div>
            </div>
            <div class="flex justify-between pt-4">
                <button type="button" @click="activeStep = 2"
                    class="bg-surface-container-high text-on-surface-variant rounded-xl px-5 py-2.5 text-xs font-bold">Back</button>
                <button type="button" @click="activeStep = 4"
                    class="bg-primary flex cursor-pointer items-center gap-2 rounded-xl px-5 py-2.5 text-xs font-bold text-white">Next
                    Step <span class="material-symbols-outlined text-[16px]">arrow_forward</span></button>
            </div>
        </div>

        <div x-show="activeStep === 4" x-cloak
            class="border-outline-variant/40 animate-fadeIn space-y-6 rounded-[2rem] border bg-white p-8 shadow-sm">
            <h3
                class="border-outline-variant/20 font-headline-md text-primary flex items-center gap-2 border-b pb-3 text-lg font-bold">
                <span class="material-symbols-outlined">cloud_upload</span> Step 4: Core Compliance Documentation Vault
            </h3>
            <p class="text-on-surface-variant -mt-3 text-xs">Please upload clean scanned documents. If the attachment
                applies to a specific inventory catalog product, specify its Reference Number.</p>

            <div class="grid grid-cols-1 gap-6 text-xs md:grid-cols-2 lg:grid-cols-3">
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
                        class="bg-surface-container-lowest border-outline-variant/60 flex flex-col justify-between space-y-3 rounded-2xl border p-5 shadow-sm">
                        <div>
                            <span class="text-primary block text-sm font-bold leading-tight">{{ $displayLabel }}</span>
                            <span class="text-on-surface-variant/80 mt-0.5 block text-[10px]">Accepts: PDF, DOCX, Images
                                (Max: 5MB)</span>
                        </div>

                        <input type="file" name="{{ $inputName }}"
                            class="hover:file:bg-primary/20 file:bg-primary/10 text-on-surface-variant file:text-primary w-full text-[11px] file:mr-3 file:rounded-xl file:border-0 file:px-3 file:py-1.5 file:text-xs file:font-semibold">

                        <div class="border-background space-y-1 border-t pt-1.5">
                            <label
                                class="text-on-surface-variant block text-[10px] font-bold uppercase tracking-wider">Associated
                                Product Ref (Optional)</label>
                            <input type="text" name="{{ $inputName }}_prod_ref" value="{{ old($inputName . '_prod_ref') }}"
                                class="border-outline-variant focus:ring-primary text-primary w-full rounded-lg border bg-white px-3 py-1.5 font-mono text-xs outline-none focus:ring-1"
                                placeholder="e.g., PROD-4402">
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-between pt-4">
                <button type="button" @click="activeStep = 3"
                    class="bg-surface-container-high text-on-surface-variant rounded-xl px-5 py-2.5 text-xs font-bold">Back</button>
                <button type="button" @click="activeStep = 5"
                    class="bg-primary flex cursor-pointer items-center gap-2 rounded-xl px-5 py-2.5 text-xs font-bold text-white">Next
                    Step <span class="material-symbols-outlined text-[16px]">arrow_forward</span></button>
            </div>
        </div>

        <div x-show="activeStep === 5"
            class="border-outline-variant/40 animate-fadeIn space-y-6 rounded-[2rem] border bg-white p-8 shadow-sm">
            <h3
                class="border-outline-variant/20 font-headline-md text-primary flex items-center gap-2 border-b pb-3 text-lg font-bold">
                <span class="material-symbols-outlined">gavel</span> Step 5: Compliance Declarations & Attestation</h3>

            <div class="grid grid-cols-1 gap-4 text-xs md:grid-cols-2">
                <label
                    class="bg-surface-container-lowest hover:bg-surface-container-low border-outline-variant/60 flex cursor-pointer items-center gap-3 rounded-xl border p-4 transition-all">
                    <input type="checkbox" name="declares_gmo_free" value="1" class="text-primary h-4 w-4 rounded">
                    <span class="text-primary font-semibold">GMO Free Compliant Certification</span>
                </label>
                <label
                    class="bg-surface-container-lowest hover:bg-surface-container-low border-outline-variant/60 flex cursor-pointer items-center gap-3 rounded-xl border p-4 transition-all">
                    <input type="checkbox" name="declares_gluten_free" value="1" class="text-primary h-4 w-4 rounded">
                    <span class="text-primary font-semibold">Gluten-Free Ingredients Assurance</span>
                </label>
                <label
                    class="bg-surface-container-lowest hover:bg-surface-container-low border-outline-variant/60 flex cursor-pointer items-center gap-3 rounded-xl border p-4 transition-all">
                    <input type="checkbox" name="declares_non_irradiated" value="1"
                        class="text-primary h-4 w-4 rounded">
                    <span class="text-primary font-semibold">Non-Irradiated / Non-Ionised Process Declared</span>
                </label>
                <label
                    class="bg-surface-container-lowest hover:bg-surface-container-low border-outline-variant/60 flex cursor-pointer items-center gap-3 rounded-xl border p-4 transition-all">
                    <input type="checkbox" name="declares_no_nanomaterials" value="1"
                        class="text-primary h-4 w-4 rounded">
                    <span class="text-primary font-semibold">No synthetic Nanomaterials components introduced</span>
                </label>
                <label
                    class="bg-surface-container-lowest hover:bg-surface-container-low border-outline-variant/60 flex cursor-pointer items-center gap-3 rounded-xl border p-4 transition-all md:col-span-2">
                    <input type="checkbox" name="complies_haccp_gmp" value="1" class="text-primary h-4 w-4 rounded">
                    <span class="text-primary font-semibold">HACCP / GMP Program Architecture Certified
                        Frameworks</span>
                </label>
            </div>

            <div class="border-outline-variant/60 border-t border-dashed pt-4">
                <h4 class="font-label-md text-primary mb-3 flex items-center gap-1 text-sm font-bold"><span
                        class="material-symbols-outlined text-[18px]">draw</span> Authorized Execution Sign-off Block
                </h4>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div class="space-y-1">
                        <label class="text-on-surface-variant block text-xs font-semibold">Signee Legal Full Name
                            *</label>
                        <input type="text" name="declaration_authorized_person"
                            class="bg-surface-container-low w-full rounded-xl border p-2.5 text-sm outline-none"
                            placeholder="Authorized corporate officer full name">
                    </div>
                    <div class="space-y-1">
                        <label class="text-on-surface-variant block text-xs font-semibold">Official Position Title
                            *</label>
                        <input type="text" name="declaration_title"
                            class="bg-surface-container-low w-full rounded-xl border p-2.5 text-sm outline-none"
                            placeholder="e.g., Executive VP Supply Chain">
                    </div>
                    <div class="space-y-1">
                        <label class="text-on-surface-variant block text-xs font-semibold">Upload Signature Image copy
                            *</label>
                        <input type="file" name="declaration_signature_path" class="w-full pt-1.5 text-xs"
                            accept="image/*">
                    </div>
                </div>
            </div>

            <div class="border-outline-variant/60 grid grid-cols-1 gap-4 border-t border-dashed pt-4 md:grid-cols-2">
                <div class="space-y-1">
                    <label class="text-on-surface-variant block text-xs font-semibold">Your System Reference Protocol
                        Token (Auto Assigned)</label>
                    <input type="text" name="supplier_ref_number"
                        value="SUP-{{ strtoupper(Illuminate\Support\Str::random(4)) }}-{{ rand(1000, 9999) }}"
                        class="bg-surface-container text-primary w-full rounded-xl border p-2.5 font-mono text-sm font-bold shadow-inner outline-none"
                        readonly>
                </div>
            </div>

            <div class="border-outline-variant/30 flex items-center justify-between border-t pt-6">
                <button type="button" @click="activeStep = 4"
                    class="bg-surface-container-high text-on-surface-variant rounded-xl px-5 py-2.5 text-xs font-bold">Back</button>
                <button type="submit"
                    class="font-label-md flex cursor-pointer items-center gap-2 rounded-2xl bg-emerald-600 px-8 py-3.5 text-xs font-bold text-white shadow-lg shadow-emerald-600/10 hover:bg-emerald-700">
                    Finalize & Submit Sourcing Application <span
                        class="material-symbols-outlined text-[18px]">send</span>
                </button>
            </div>
        </div>
    </form>
</div>