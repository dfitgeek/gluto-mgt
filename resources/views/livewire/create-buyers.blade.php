<div class="p-gutter mx-auto my-6 w-full max-w-5xl flex-1">

    <div class="border-outline-variant/30 mb-8 flex items-center justify-between border-b pb-6">
        <div>
            <h2 class="font-headline-lg text-headline-lg text-primary text-2xl font-bold">Onboard New Enterprise Buyer</h2>
            <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Directly create a verified buyer profile entity card within the system database matrix.</p>
        </div>
        <a href="{{ route('admin.suppliers.manage') }}" wire:navigate class="bg-surface-container-high hover:bg-surface-container-highest font-label-md text-on-surface-variant flex cursor-pointer items-center gap-1.5 rounded-xl px-4 py-2.5 text-xs font-bold transition-all">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span> Back to Directory
        </a>
    </div>

    @if ($errors->any())
        <div class="animate-fadeIn mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-xs font-medium text-red-800">
            <p class="mb-1 flex items-center gap-1 font-bold"><span class="material-symbols-outlined text-[16px]">error</span> Mandatory fields contain missing structural values:</p>
            <ul class="list-inside list-disc space-y-0.5 pl-1 opacity-95">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.buyers.store') }}" method="post" enctype="multipart/form-data"
        x-data="{
            activeStep: 1,
            init() {
                @if($errors->hasAny(['company_name', 'country_of_registration', 'company_registration_number', 'vat_tax_id_number', 'year_established', 'nature_of_business', 'company_website', 'password']))
                    this.activeStep = 1;
                @elseif($errors->hasAny(['rep_full_name', 'rep_position', 'rep_email', 'rep_mobile_whatsapp', 'rep_nationality', 'rep_id_passport_number', 'office_address']))
                    this.activeStep = 2;
                @elseif($errors->hasAny(['file_sales_contract', 'file_commercial_invoice', 'file_packing_list', 'file_certificate_of_origin', 'file_test_analysis_report', 'file_bill_of_lading', 'file_insurance_certificate', 'file_product_spec_sheet', 'file_others']))
                    this.activeStep = 3;
                @endif
            }
        }"
        class="space-y-6">
        @csrf

        @if($userId)
            <input type="hidden" name="user_id" value="{{ $userId }}">
        @endif

        <div class="bg-surface-container-low border-outline-variant/20 mb-8 select-none rounded-3xl border p-5 shadow-sm">
            <div class="relative mx-auto flex max-w-2xl items-center justify-between px-4">
                <div class="relative flex cursor-pointer flex-col items-center" @click="activeStep = 1">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full text-xs font-bold transition-all" :class="activeStep === 1 ? 'bg-primary text-white ring-4 ring-primary/20' : 'bg-white border-2 border-outline text-on-surface-variant'">1</div>
                    <span class="font-label-sm mt-1.5 hidden text-[10px] font-medium sm:block" :class="activeStep === 1 ? 'text-primary font-bold' : 'text-on-surface-variant'">Corporate Info</span>
                </div>
                <div class="mx-1 h-0.5 flex-1" :class="activeStep > 1 ? 'bg-primary' : 'bg-outline-variant'"></div>
                <div class="relative flex cursor-pointer flex-col items-center" @click="activeStep = 2">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full text-xs font-bold transition-all" :class="activeStep === 2 ? 'bg-primary text-white ring-4 ring-primary/20' : 'bg-white border-2 border-outline text-on-surface-variant'">2</div>
                    <span class="font-label-sm mt-1.5 hidden text-[10px] font-medium sm:block" :class="activeStep === 2 ? 'text-primary font-bold' : 'text-on-surface-variant'">Authorized Representative</span>
                </div>
                <div class="mx-1 h-0.5 flex-1" :class="activeStep > 2 ? 'bg-primary' : 'bg-outline-variant'"></div>
                <div class="relative flex cursor-pointer flex-col items-center" @click="activeStep = 3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full text-xs font-bold transition-all" :class="activeStep === 3 ? 'bg-primary text-white ring-4 ring-primary/20' : 'bg-white border-2 border-outline text-on-surface-variant'">3</div>
                    <span class="font-label-sm mt-1.5 hidden text-[10px] font-medium sm:block" :class="activeStep === 3 ? 'text-primary font-bold' : 'text-on-surface-variant'">Documentation Vault</span>
                </div>
            </div>
        </div>

        <div x-show="activeStep === 1" class="border-outline-variant/40 animate-fadeIn space-y-6 rounded-[2rem] border bg-white p-8 shadow-sm">
            <h3 class="border-outline-variant/20 font-headline-md text-primary flex items-center gap-2 border-b pb-3 text-lg font-bold">
                <span class="material-symbols-outlined">corporate_fare</span> Section 1: Corporate Entity Information
            </h3>
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <div class="space-y-1.5 md:col-span-2">
                    <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Company Legal Name *</label>
                    <input type="text" name="company_name" value="{{ old('company_name', optional($targetUser)->name) }}" :required="activeStep === 1" class="bg-surface-container-low @error('company_name') @else border-outline-variant @enderror w-full rounded-xl border border-red-500 px-4 py-2.5 text-sm font-medium outline-none">
                </div>

                <div class="space-y-1.5">
                    <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Country of Registration *</label>
                    <input type="text" name="country_of_registration" value="{{ old('country_of_registration') }}" :required="activeStep === 1" class="bg-surface-container-low @error('country_of_registration') @else border-outline-variant @enderror w-full rounded-xl border border-red-500 px-4 py-2.5 text-sm font-medium outline-none" placeholder="e.g., Nigeria, United Kingdom">
                </div>

                <div class="space-y-1.5">
                    <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Company Registration Number</label>
                    <input type="text" name="company_registration_number" value="{{ old('company_registration_number') }}" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2.5 text-sm font-medium outline-none">
                </div>

                <div class="space-y-1.5">
                    <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">VAT / Tax ID Number</label>
                    <input type="text" name="vat_tax_id_number" value="{{ old('vat_tax_id_number') }}" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2.5 text-sm font-medium outline-none" placeholder="TIN Number">
                </div>

                <div class="space-y-1.5">
                    <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Year Established</label>
                    <input type="number" name="year_established" value="{{ old('year_established') }}" min="1800" max="{{ date('Y') }}" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2.5 text-sm font-medium outline-none" placeholder="YYYY">
                </div>

                <div class="space-y-1.5 md:col-span-2">
                    <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Nature of Business Operation</label>
                    <input type="text" name="nature_of_business" value="{{ old('nature_of_business') }}" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2.5 text-sm font-medium outline-none" placeholder="e.g., Wholesale Distributor, Retail Chain, Procurement Agency">
                </div>

                <div class="space-y-1.5">
                    <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Corporate Website URL</label>
                    <input type="text" name="company_website" value="{{ old('company_website') }}" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2.5 text-sm font-medium outline-none" placeholder="www.company.com">
                </div>

                <div class="border-outline-variant/40 space-y-1.5 border-t border-dashed pt-4 md:col-span-3">
                    <div class="max-w-md space-y-1.5">
                        <label class="text-primary block pl-0.5 text-xs font-bold">Assign Account Password (Overrides Default)</label>
                        <input type="text" name="password" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2.5 font-mono text-sm outline-none" placeholder="Leave blank to use baseline 'glutobuyer' fallback value">
                        <p class="text-on-surface-variant pl-0.5 text-[10px]">If left empty, the secure credential fallback automatically establishes as <code class="bg-surface-container text-primary rounded px-1 font-bold">glutobuyer</code></p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="button" @click="activeStep = 2" class="bg-primary flex cursor-pointer items-center gap-2 rounded-xl px-5 py-2.5 text-xs font-bold text-white">
                    Next Step <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </button>
            </div>
        </div>

        <div x-show="activeStep === 2" x-cloak class="border-outline-variant/40 animate-fadeIn space-y-6 rounded-[2rem] border bg-white p-8 shadow-sm">
            <h3 class="border-outline-variant/20 font-headline-md text-primary flex items-center gap-2 border-b pb-3 text-lg font-bold">
                <span class="material-symbols-outlined">badge</span> Section 2: Authorized Representative Details
            </h3>
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="space-y-1.5">
                    <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Legal Full Name *</label>
                    <input type="text" name="rep_full_name" value="{{ old('rep_full_name', optional($targetUser)->name) }}" :required="activeStep === 2" class="bg-surface-container-low @error('rep_full_name') @else border-outline-variant @enderror w-full rounded-xl border border-red-500 px-4 py-2.5 text-sm font-medium outline-none">
                </div>

                <div class="space-y-1.5">
                    <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Official Corporate Position / Role *</label>
                    <input type="text" name="rep_position" value="{{ old('rep_position') }}" :required="activeStep === 2" class="bg-surface-container-low @error('rep_position') @else border-outline-variant @enderror w-full rounded-xl border border-red-500 px-4 py-2.5 text-sm font-medium outline-none" placeholder="e.g., Procurement Director, Chief Buyer">
                </div>

                <div class="space-y-1.5">
                    <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Direct Professional Email Address *</label>
                    <input type="email" name="rep_email" value="{{ old('rep_email', optional($targetUser)->email) }}" :required="activeStep === 2" class="bg-surface-container-low @error('rep_email') @else border-outline-variant @enderror w-full rounded-xl border border-red-500 px-4 py-2.5 text-sm font-medium outline-none">
                </div>

                <div class="space-y-1.5">
                    <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Mobile / WhatsApp Coordinates *</label>
                    <input type="text" name="rep_mobile_whatsapp" value="{{ old('rep_mobile_whatsapp') }}" :required="activeStep === 2" class="bg-surface-container-low @error('rep_mobile_whatsapp') @else border-outline-variant @enderror w-full rounded-xl border border-red-500 px-4 py-2.5 text-sm font-medium outline-none" placeholder="+234 ...">
                </div>

                <div class="space-y-1.5">
                    <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Representative Nationality</label>
                    <input type="text" name="rep_nationality" value="{{ old('rep_nationality') }}" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2.5 text-sm font-medium outline-none">
                </div>

                <div class="space-y-1.5">
                    <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Identity Document (ID / Passport) Number</label>
                    <input type="text" name="rep_id_passport_number" value="{{ old('rep_id_passport_number') }}" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2.5 text-sm font-medium outline-none">
                </div>

                <div class="space-y-1.5 md:col-span-2">
                    <label class="text-on-surface-variant block pl-0.5 text-xs font-bold">Official Office Operations Physical Address</label>
                    <textarea name="office_address" rows="3" class="bg-surface-container-low border-outline-variant w-full rounded-xl border px-4 py-2.5 text-sm font-medium outline-none">{{ old('office_address') }}</textarea>
                </div>
            </div>

            <div class="flex justify-between pt-4">
                <button type="button" @click="activeStep = 1" class="bg-surface-container-high text-on-surface-variant rounded-xl px-5 py-2.5 text-xs font-bold">Back</button>
                <button type="button" @click="activeStep = 3" class="bg-primary flex cursor-pointer items-center gap-2 rounded-xl px-5 py-2.5 text-xs font-bold text-white">
                    Next Step <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </button>
            </div>
        </div>

        <div x-show="activeStep === 3" x-cloak class="border-outline-variant/40 animate-fadeIn space-y-6 rounded-[2rem] border bg-white p-8 shadow-sm">
            <h3 class="border-outline-variant/20 font-headline-md text-primary flex items-center gap-2 border-b pb-3 text-lg font-bold">
                <span class="material-symbols-outlined">cloud_upload</span> Section 3: Core Compliance Documentation Vault
            </h3>
            <p class="text-on-surface-variant -mt-3 text-xs">Attach active corporate records. Link them to a specific system product identifier if required.</p>
            
            <div class="grid grid-cols-1 gap-6 text-xs md:grid-cols-2 lg:grid-cols-3">
                @php
                    $buyerVaultFields = [
                        'file_sales_contract'        => 'Sales Sourcing Contract',
                        'file_commercial_invoice'    => 'Commercial Invoice Scans',
                        'file_packing_list'          => 'Packing List Manifest',
                        'file_certificate_of_origin' => 'Certificate of Origin',
                        'file_test_analysis_report'  => 'Test Analysis Report',
                        'file_bill_of_lading'        => 'Bill of Lading Copy',
                        'file_insurance_certificate' => 'Insurance Certificate',
                        'file_product_spec_sheet'    => 'Product Specification Sheet',
                        'file_others'                => 'Other Supporting Documents',
                    ];
                @endphp

                @foreach($buyerVaultFields as $field => $label)
                    <div class="bg-surface-container-lowest border-outline-variant/60 flex flex-col justify-between space-y-3 rounded-2xl border p-5 shadow-sm">
                        <div>
                            <span class="text-primary block text-sm font-bold leading-tight">{{ $label }}</span>
                            <span class="text-on-surface-variant/80 mt-0.5 block text-[10px]">Accepts: PDF, DOCX, Images (Max: 5MB)</span>
                        </div>
                        
                        <input type="file" name="{{ $field }}" class="text-on-surface-variant file:bg-primary/10 file:text-primary hover:file:bg-primary/20 w-full text-[11px] file:mr-3 file:rounded-xl file:border-0 file:px-3 file:py-1.5 file:text-xs file:font-semibold">
                        
                        <div class="border-background space-y-1 border-t pt-1.5">
                            <label class="text-on-surface-variant block text-[10px] font-bold uppercase tracking-wider">Associated Product Ref (Optional)</label>
                            <input type="text" name="{{ $field }}_prod_ref" value="{{ old($field . '_prod_ref') }}" class="border-outline-variant text-primary focus:ring-primary w-full rounded-lg border bg-white px-3 py-1.5 font-mono text-xs outline-none focus:ring-1" placeholder="e.g., PROD-7104">
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="bg-surface-container-low border-outline-variant/40 mt-6 flex flex-col items-start justify-between gap-4 space-y-4 rounded-2xl border p-6 shadow-inner sm:flex-row sm:items-center">
                <div class="space-y-1">
                    <label class="text-on-surface-variant block text-[11px] font-bold uppercase tracking-wider">System Generated Core Reference Protocol Code</label>
                    <input type="text" name="buyer_ref_number" value="BUY-{{ strtoupper(Illuminate\Support\Str::random(4)) }}-{{ rand(1000,9999) }}" class="border-outline-variant text-primary max-w-xs rounded-xl border bg-white px-4 py-2 font-mono text-sm font-bold shadow-inner outline-none" readonly>
                </div>
                
                <div class="flex w-full items-center justify-end gap-3 sm:w-auto">
                    <button type="button" @click="activeStep = 2" class="bg-surface-container-high text-on-surface-variant cursor-pointer rounded-xl px-5 py-2.5 text-xs font-bold">Back</button>
                    <button type="submit" class="bg-primary hover:bg-primary/95 shadow-primary/10 font-label-md flex w-full cursor-pointer items-center justify-center gap-2 rounded-xl px-8 py-3.5 text-xs font-bold text-white shadow-lg transition-all sm:w-auto">
                        Catalog Buyer Profile <span class="material-symbols-outlined text-[18px]">save</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>