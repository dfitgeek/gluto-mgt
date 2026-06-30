<div class="flex-1 mx-auto my-6 p-gutter w-full">

    <div class="flex justify-between items-center mb-8 pb-6 border-b border-outline-variant/30">
        <div>
            <h2 class="font-headline-lg font-bold text-headline-lg text-primary text-2xl">Onboard New Enterprise Buyer</h2>
            <p class="mt-1 font-body-sm text-body-sm text-on-surface-variant">Directly create a verified buyer profile entity card within the system database matrix.</p>
        </div>
        <a href="{{ route('admin.buyers.manage') }}" wire:navigate class="flex items-center gap-1.5 bg-surface-container-high hover:bg-surface-container-highest px-4 py-2.5 rounded-xl font-label-md font-bold text-on-surface-variant text-xs transition-all cursor-pointer">
            <span class="text-[18px] material-symbols-outlined">arrow_back</span> Back to Directory
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 mb-6 p-4 border border-red-200 rounded-xl font-medium text-red-800 text-xs animate-fadeIn">
            <p class="flex items-center gap-1 mb-1 font-bold"><span class="text-[16px] material-symbols-outlined">error</span> Mandatory fields contain missing structural values:</p>
            <ul class="space-y-0.5 opacity-95 pl-1 list-disc list-inside">
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
                @elseif($errors->hasAny(['company_reg_doc', 'id_card']))
                    this.activeStep = 3;
                @endif
            }
        }"
        class="space-y-6">
        @csrf

        @if(isset($userId) && $userId)
            <input type="hidden" name="user_id" value="{{ $userId }}">
        @endif

        <div class="bg-surface-container-low shadow-sm mb-8 p-5 border rounded-3xl border-outline-variant/20 select-none">
            <div class="relative flex justify-between items-center mx-auto px-4 max-w-2xl">
                <div class="relative flex flex-col items-center cursor-pointer" @click="activeStep = 1">
                    <div class="flex justify-center items-center rounded-full w-9 h-9 font-bold text-xs transition-all" :class="activeStep === 1 ? 'bg-primary text-white ring-4 ring-primary/20' : 'bg-white border-2 border-outline text-on-surface-variant'">1</div>
                    <span class="hidden sm:block mt-1.5 font-label-sm font-medium text-[10px]" :class="activeStep === 1 ? 'text-primary font-bold' : 'text-on-surface-variant'">Corporate Info</span>
                </div>
                <div class="flex-1 mx-1 h-0.5" :class="activeStep > 1 ? 'bg-primary' : 'bg-outline-variant'"></div>
                <div class="relative flex flex-col items-center cursor-pointer" @click="activeStep = 2">
                    <div class="flex justify-center items-center rounded-full w-9 h-9 font-bold text-xs transition-all" :class="activeStep === 2 ? 'bg-primary text-white ring-4 ring-primary/20' : 'bg-white border-2 border-outline text-on-surface-variant'">2</div>
                    <span class="hidden sm:block mt-1.5 font-label-sm font-medium text-[10px]" :class="activeStep === 2 ? 'text-primary font-bold' : 'text-on-surface-variant'">Authorized Representative</span>
                </div>
                <div class="flex-1 mx-1 h-0.5" :class="activeStep > 2 ? 'bg-primary' : 'bg-outline-variant'"></div>
                <div class="relative flex flex-col items-center cursor-pointer" @click="activeStep = 3">
                    <div class="flex justify-center items-center rounded-full w-9 h-9 font-bold text-xs transition-all" :class="activeStep === 3 ? 'bg-primary text-white ring-4 ring-primary/20' : 'bg-white border-2 border-outline text-on-surface-variant'">3</div>
                    <span class="hidden sm:block mt-1.5 font-label-sm font-medium text-[10px]" :class="activeStep === 3 ? 'text-primary font-bold' : 'text-on-surface-variant'">Documentation Vault</span>
                </div>
            </div>
        </div>

        <div x-show="activeStep === 1" class="space-y-6 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40 animate-fadeIn">
            <h3 class="flex items-center gap-2 pb-3 border-b border-outline-variant/20 font-headline-md font-bold text-primary text-lg">
                <span class="material-symbols-outlined">corporate_fare</span> Section 1: Corporate Entity Information
            </h3>
            
            <div class="gap-6 grid grid-cols-1 md:grid-cols-3">
                <div class="flex items-center gap-6 md:col-span-3 bg-surface-container-lowest p-4 border border-dashed rounded-2xl border-outline-variant w-full">
                    <div class="relative flex flex-shrink-0 justify-center items-center bg-surface-container shadow-inner rounded-2xl w-16 h-16 overflow-hidden">
                        <span class="text-outline text-[24px] material-symbols-outlined">add_photo_alternate</span>
                    </div>
                    <div class="space-y-1">
                        <label class="block font-label-md text-label-md text-primary cursor-pointer">
                            <span class="inline-block bg-primary hover:bg-primary/90 shadow-sm px-4 py-1.5 rounded-xl font-bold text-white text-xs transition-all">Upload Profile Logo Icon</span>
                            <input type="file" name="company_icon_path" class="hidden" accept="image/*" onchange="document.getElementById('icon-file-name').innerText = this.files[0] ? this.files[0].name : 'No file chosen'">
                        </label>
                        <p id="icon-file-name" class="font-semibold text-[11px] text-secondary tracking-wide">No file chosen</p>
                    </div>
                </div>

                <div class="space-y-1.5 md:col-span-2">
                    <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Company Legal Name *</label>
                    <input type="text" name="company_name" value="{{ old('company_name', isset($targetUser) ? $targetUser->name : '') }}" :required="activeStep === 1" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-medium text-sm">
                </div>

                <div class="space-y-1.5">
                    <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Country of Registration *</label>
                    <input type="text" name="country_of_registration" value="{{ old('country_of_registration') }}" :required="activeStep === 1" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-medium text-sm" placeholder="e.g., Nigeria, United Kingdom">
                </div>

                <div class="space-y-1.5">
                    <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Company Registration Number</label>
                    <input type="text" name="company_registration_number" value="{{ old('company_registration_number') }}" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-medium text-sm">
                </div>

                <div class="space-y-1.5">
                    <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">VAT / Tax ID Number</label>
                    <input type="text" name="vat_tax_id_number" value="{{ old('vat_tax_id_number') }}" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-medium text-sm" placeholder="TIN Number">
                </div>

                <div class="space-y-1.5">
                    <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Year Established</label>
                    <input type="number" name="year_established" value="{{ old('year_established') }}" min="1800" max="{{ date('Y') }}" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-medium text-sm" placeholder="YYYY">
                </div>

                <div class="space-y-1.5 md:col-span-2">
                    <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Nature of Business Operation</label>
                    <input type="text" name="nature_of_business" value="{{ old('nature_of_business') }}" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-medium text-sm" placeholder="e.g., Wholesale Distributor, Retail Chain, Procurement Agency">
                </div>

                <div class="space-y-1.5">
                    <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Corporate Website URL</label>
                    <input type="text" name="company_website" value="{{ old('company_website') }}" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-medium text-sm" placeholder="www.company.com">
                </div>

                <div class="space-y-1.5 md:col-span-3 pt-4 border-t border-dashed border-outline-variant/40">
                    <div class="space-y-1.5 max-w-md">
                        <label class="block pl-0.5 font-bold text-primary text-xs">Assign Account Password (Overrides Default)</label>
                        <input type="text" name="password" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-mono text-sm" placeholder="Leave blank to use baseline 'glutobuyer' fallback value">
                        <p class="pl-0.5 text-[10px] text-on-surface-variant">If left empty, the secure credential fallback automatically establishes as <code class="bg-surface-container px-1 rounded font-bold text-primary">glutobuyer</code></p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="button" @click="activeStep = 2" class="flex items-center gap-2 bg-primary px-5 py-2.5 rounded-xl font-bold text-white text-xs cursor-pointer">
                    Next Step <span class="text-[16px] material-symbols-outlined">arrow_forward</span>
                </button>
            </div>
        </div>

        <div x-show="activeStep === 2" x-cloak class="space-y-6 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40 animate-fadeIn">
            <h3 class="flex items-center gap-2 pb-3 border-b border-outline-variant/20 font-headline-md font-bold text-primary text-lg">
                <span class="material-symbols-outlined">badge</span> Section 2: Authorized Representative Details
            </h3>
            
            <div class="gap-6 grid grid-cols-1 md:grid-cols-2">
                <div class="space-y-1.5">
                    <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Legal Full Name *</label>
                    <input type="text" name="rep_full_name" value="{{ old('rep_full_name', isset($targetUser) ? $targetUser->name : '') }}" :required="activeStep === 2" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-medium text-sm">
                </div>

                <div class="space-y-1.5">
                    <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Official Corporate Position / Role *</label>
                    <input type="text" name="rep_position" value="{{ old('rep_position') }}" :required="activeStep === 2" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-medium text-sm" placeholder="e.g., Procurement Director, Chief Buyer">
                </div>

                <div class="space-y-1.5">
                    <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Direct Professional Email Address *</label>
                    <input type="email" name="rep_email" value="{{ old('rep_email', isset($targetUser) ? $targetUser->email : '') }}" :required="activeStep === 2" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-medium text-sm">
                </div>

                <div class="space-y-1.5">
                    <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Mobile / WhatsApp Coordinates *</label>
                    <input type="text" name="rep_mobile_whatsapp" value="{{ old('rep_mobile_whatsapp') }}" :required="activeStep === 2" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-medium text-sm" placeholder="+234 ...">
                </div>

                <div class="space-y-1.5">
                    <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Representative Nationality</label>
                    <input type="text" name="rep_nationality" value="{{ old('rep_nationality') }}" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-medium text-sm">
                </div>

                <div class="space-y-1.5">
                    <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Identity Document (ID / Passport) Number</label>
                    <input type="text" name="rep_id_passport_number" value="{{ old('rep_id_passport_number') }}" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-medium text-sm">
                </div>

                <div class="space-y-1.5 md:col-span-2">
                    <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Official Office Operations Physical Address</label>
                    <textarea name="office_address" rows="3" class="bg-surface-container-low px-4 py-2.5 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-medium text-sm">{{ old('office_address') }}</textarea>
                </div>
            </div>

            <div class="space-y-4 md:col-span-3 pt-4 border-t border-dashed border-outline-variant/60">
                <h4 class="flex items-center gap-1 font-label-md font-bold text-primary"><span class="text-[18px] material-symbols-outlined">share</span> Corporate Social Media Presences</h4>
                <div class="gap-4 grid grid-cols-1 md:grid-cols-5">
                    @foreach(['twitter' => 'X (Twitter)', 'facebook' => 'Facebook', 'instagram' => 'Instagram', 'threads' => 'Threads', 'linkedin' => 'LinkedIn'] as $slug => $label)
                        <div class="space-y-1">
                            <label class="block font-label-md text-on-surface-variant text-xs">{{ $label }}</label>
                            <input type="text" name="social_{{ $slug }}" value="{{ old('social_' . $slug) }}" class="bg-surface-container-low px-3 py-2 border rounded-xl border-outline-variant outline-none focus:ring-1 focus:ring-primary w-full font-body-sm" placeholder="@handle">
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-between pt-4">
                <button type="button" @click="activeStep = 1" class="bg-surface-container-high px-5 py-2.5 rounded-xl font-bold text-on-surface-variant text-xs">Back</button>
                <button type="button" @click="activeStep = 3" class="flex items-center gap-2 bg-primary px-5 py-2.5 rounded-xl font-bold text-white text-xs cursor-pointer">
                    Next Step <span class="text-[16px] material-symbols-outlined">arrow_forward</span>
                </button>
            </div>
        </div>

        <div x-show="activeStep === 3" x-cloak class="space-y-6 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40 animate-fadeIn">
            <h3 class="flex items-center gap-2 pb-3 border-b border-outline-variant/20 font-headline-md font-bold text-primary text-lg">
                <span class="material-symbols-outlined">cloud_upload</span> Section 3: Core Compliance Documentation Vault
            </h3>
            <p class="-mt-3 text-on-surface-variant text-xs">Attach active profiles legal verification records matching compliance structures.</p>
            
            <div class="gap-6 grid grid-cols-1 md:grid-cols-2 max-w-4xl text-xs">
                @php
                    $buyerVaultFields = [
                        'company_reg_doc' => 'Company Registration Document',
                        'id_card'         => 'Representative Identity Card / Passport',
                    ];
                @endphp

                @foreach($buyerVaultFields as $field => $label)
                    <div class="flex flex-col justify-between space-y-4 bg-surface-container-lowest shadow-sm p-5 border rounded-2xl border-outline-variant/60">
                        <div>
                            <span class="block font-bold text-primary text-sm leading-tight">{{ $label }}</span>
                            <span class="block mt-0.5 text-[10px] text-on-surface-variant/80">Accepts: PDF, DOCX, Images (Max: 5MB)</span>
                        </div>
                        <input type="file" name="{{ $field }}" class="hover:file:bg-primary/20 file:bg-primary/10 file:mr-3 file:px-3 file:py-1.5 file:border-0 file:rounded-xl w-full file:font-semibold text-[11px] text-on-surface-variant file:text-primary file:text-xs">
                    </div>
                @endforeach
            </div>

            <div class="flex sm:flex-row flex-col justify-between items-start sm:items-center gap-4 space-y-4 bg-surface-container-low shadow-inner mt-6 p-6 border rounded-2xl border-outline-variant/40">
                <div class="space-y-1">
                    <label class="block font-bold text-[11px] text-on-surface-variant uppercase tracking-wider">System Generated Core Reference Protocol Code</label>
                    <input type="text" name="buyer_ref_number" value="BUY-{{ strtoupper(Illuminate\Support\Str::random(4)) }}-{{ rand(1000,9999) }}" class="bg-white shadow-inner px-4 py-2 border rounded-xl border-outline-variant outline-none max-w-xs font-mono font-bold text-primary text-sm" readonly>
                </div>
                
                <div class="flex justify-end items-center gap-3 w-full sm:w-auto">
                    <button type="button" @click="activeStep = 2" class="bg-surface-container-high px-5 py-2.5 rounded-xl font-bold text-on-surface-variant text-xs cursor-pointer">Back</button>
                    <button type="submit" class="flex justify-center items-center gap-2 bg-primary hover:bg-primary/95 shadow-lg shadow-primary/10 px-8 py-3.5 rounded-xl w-full sm:w-auto font-label-md font-bold text-white text-xs transition-all cursor-pointer">
                        Catalog Buyer Profile <span class="text-[18px] material-symbols-outlined">save</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>