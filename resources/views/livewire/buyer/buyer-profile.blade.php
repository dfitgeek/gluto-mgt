<div class="flex-1 mx-auto my-2 p-gutter w-full max-w-[1440px]" x-data="{ profileTab: 'identity' }">

    <div class="flex sm:flex-row flex-col justify-between sm:items-center gap-4 mb-6 pb-4 border-b border-outline-variant/30">
        <div>
            <h2 class="font-headline-lg font-bold text-headline-lg text-primary text-2xl tracking-tight">Account Profile Settings</h2>
            <p class="mt-0.5 font-body-sm text-on-surface-variant text-sm">Manage corporate identities details, update primary delegates contacts, and rotate security access passwords.</p>
        </div>

        <div class="flex bg-surface-container p-1 border rounded-xl border-outline-variant/20 w-fit font-bold text-on-surface-variant text-xs select-none">
            <button type="button" @click="profileTab = 'identity'" class="px-4 py-2 rounded-lg transition-all cursor-pointer" :class="profileTab === 'identity' ? 'bg-white text-primary shadow-sm' : 'hover:text-primary'"><span class="flex items-center gap-1"><span class="text-[16px] material-symbols-outlined">business</span> Company Details</span></button>
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
                    <span class="material-symbols-outlined">corporate_fare</span> 1. Company Information & Brand Identity
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
                                <span class="inline-block bg-primary hover:bg-primary/95 shadow-sm px-4 py-1.5 rounded-xl font-bold text-white text-xs transition-all">Upload Corporate Logo</span>
                                <input type="file" wire:model="new_company_icon" class="hidden" accept="image/*">
                            </label>
                            <p class="text-[10px] text-on-surface-variant">Accepts PNG, JPG formats up to 2MB. Real-time background sync processing rendering loops active.</p>
                            @error('new_company_icon') <span class="block font-bold text-red-500 text-xs animate-fadeIn">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Company Legal Name *</label>
                        <input type="text" wire:model.defer="company_name" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium">
                        @error('company_name') <span class="block pl-0.5 font-medium text-red-500 text-xs animate-fadeIn">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Country of Registration *</label>
                        <input type="text" wire:model.defer="country_of_registration" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium">
                        @error('country_of_registration') <span class="block pl-0.5 font-medium text-red-500 text-xs animate-fadeIn">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Company Registration Number</label>
                        <input type="text" wire:model.defer="company_registration_number" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium">
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">VAT / Tax ID Number</label>
                        <input type="text" wire:model.defer="vat_tax_id_number" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium" placeholder="TIN Number">
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Year Established</label>
                        <input type="number" wire:model.defer="year_established" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium" placeholder="YYYY">
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Corporate Website URL</label>
                        <input type="text" wire:model.defer="company_website" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium" placeholder="https://www.company.com">
                        @error('company_website') <span class="block pl-0.5 font-medium text-red-500 text-xs animate-fadeIn">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1 md:col-span-3">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Nature of Sourcing Operation</label>
                        <input type="text" wire:model.defer="nature_of_business" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium" placeholder="e.g., Wholesale Distributor, Retail Chain Procurement Network Agency">
                    </div>
                </div>

                <div class="space-y-3 pt-4 border-t border-dashed border-outline-variant/50">
                    <h4 class="flex items-center gap-1 font-bold text-primary text-xs uppercase tracking-wide"><span class="text-[16px] material-symbols-outlined">share</span> Corporate Social Network Presences Handles</h4>
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
                    <span class="material-symbols-outlined">badge</span> 2. Authorized Representative Contact Specifications Card
                </h3>

                <div class="gap-6 grid grid-cols-1 md:grid-cols-2 text-sm">
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Representative Full legal Name *</label>
                        <input type="text" wire:model.defer="rep_full_name" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium">
                        @error('rep_full_name') <span class="block pl-0.5 font-medium text-red-500 text-xs animate-fadeIn">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Official Corporate Position / Role *</label>
                        <input type="text" wire:model.defer="rep_position" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium">
                        @error('rep_position') <span class="block pl-0.5 font-medium text-red-500 text-xs animate-fadeIn">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Direct Core Communications Email (Login Handle ID) *</label>
                        <input type="email" wire:model.defer="rep_email" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium">
                        @error('rep_email') <span class="block pl-0.5 font-medium text-red-500 text-xs animate-fadeIn">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Mobile / WhatsApp Coordinates *</label>
                        <input type="text" wire:model.defer="rep_mobile_whatsapp" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium">
                        @error('rep_mobile_whatsapp') <span class="block pl-0.5 font-medium text-red-500 text-xs animate-fadeIn">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Representative Nationality</label>
                        <input type="text" wire:model.defer="rep_nationality" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium">
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Identity Document (ID / Passport) Number</label>
                        <input type="text" wire:model.defer="rep_id_passport_number" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium">
                    </div>
                    <div class="space-y-1 md:col-span-2">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Official Office Operations Physical Address Address</label>
                        <textarea wire:model.defer="office_address" rows="2" class="bg-surface-container-low focus:bg-white px-4 py-2 border rounded-xl border-outline-variant outline-none w-full font-medium"></textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center bg-surface-container-low shadow-inner p-5 border rounded-2xl border-outline-variant/40">
                <span class="font-mono text-on-surface-variant/80 text-xs select-none">Buyer System Identifier Reference: <strong class="text-primary">{{ $buyer_ref_number }}</strong></span>
                <button type="submit" wire:loading.attr="disabled" class="bg-primary hover:bg-primary/95 shadow-md px-8 py-3 rounded-xl font-label-md font-bold text-white text-xs active:scale-95 transition-all cursor-pointer">
                    <span wire:loading.remove>Commit General Profile Changes</span>
                    <span wire:loading class="flex items-center gap-1.5 animate-pulse"><span class="inline-block border-2 border-white border-t-transparent rounded-full w-3.5 h-3.5 animate-spin"></span> Saving parameters modifications...</span>
                </button>
            </div>
        </form>
    </div>

    <div x-show="profileTab === 'security'" x-cloak class="space-y-6 animate-fadeIn">
        <form wire:submit.prevent="updateSecurityPassword" class="space-y-6">
            <div class="space-y-6 bg-white shadow-sm p-8 border rounded-[2rem] border-outline-variant/40">
                <h3 class="flex items-center gap-2 pb-2.5 border-background border-b font-headline-md font-bold text-primary text-base">
                    <span class="material-symbols-outlined">lock_reset</span> 3. Security Access Matrix (Rotate Account Password)
                </h3>
                <p class="-mt-3 pl-0.5 text-on-surface-variant/80 text-xs">Regularly rotate your password string. Modifying this securely resets active session cookies across secondary active desktop frames.</p>

                <div class="gap-6 grid grid-cols-1 md:grid-cols-3 max-w-4xl text-sm">
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-on-surface-variant text-xs">Current Active Account Password *</label>
                        <input type="password" wire:model.defer="current_password" class="bg-surface-container-low focus:bg-white p-2.5 border rounded-xl border-outline-variant outline-none w-full">
                        @error('current_password') <span class="block pl-0.5 font-medium text-red-500 text-xs animate-fadeIn">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-primary text-xs">New Workspace Security Password *</label>
                        <input type="password" wire:model.defer="new_password" class="bg-surface-container-low focus:bg-white p-2.5 border rounded-xl border-outline-variant outline-none w-full" placeholder="Minimum 8 elements">
                        @error('new_password') <span class="block pl-0.5 font-medium text-red-500 text-xs animate-fadeIn">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="block pl-0.5 font-bold text-primary text-xs">Confirm New Workspace Security Password *</label>
                        <input type="password" wire:model.defer="new_password_confirmation" class="bg-surface-container-low focus:bg-white p-2.5 border rounded-xl border-outline-variant outline-none w-full" placeholder="Re-type string matching key">
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center bg-surface-container-low shadow-inner p-5 border rounded-2xl border-outline-variant/40 select-none">
                <div class="flex items-center gap-2 font-semibold text-on-surface-variant text-xs">
                    <span class="text-[16px] text-amber-600 material-symbols-outlined">security_alert</span>
                    <span>Modifying this will terminate session access locks. Verification check active.</span>
                </div>
                <button type="submit" wire:loading.attr="disabled" class="bg-primary hover:bg-primary/95 shadow-md px-8 py-3 rounded-xl font-label-md font-bold text-white text-xs active:scale-95 transition-all cursor-pointer">
                    <span wire:loading.remove>Rotate Account Login Token</span>
                    <span wire:loading class="animate-pulse"><span class="inline-block mr-1 border-2 border-white border-t-transparent rounded-full w-3 h-3 animate-spin"></span> Applying secure patch layers...</span>
                </button>
            </div>
        </form>
    </div>

</div>
