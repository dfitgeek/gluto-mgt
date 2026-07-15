<div class="flex-1 mx-auto my-2 p-gutter w-full max-w-4xl">

    <div class="mb-6 pb-4 border-neutral-200 border-b select-none">
        <h2 class="font-bold text-neutral-900 text-xl tracking-tight">Account Configuration Profile</h2>
        <p class="mt-0.5 text-neutral-500 text-xs">Edit your administrative authentication access records credentials below.</p>
    </div>

    @if(session()->has('success'))
        <div class="flex items-center gap-2 bg-emerald-50 mb-6 p-4 border border-emerald-200 rounded-xl font-semibold text-emerald-800 text-xs select-none">
            <span class="text-[18px] material-symbols-outlined">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <form wire:submit.prevent="updateProfile" class="space-y-6 bg-white p-6 border border-neutral-200 rounded-[2rem] font-semibold text-neutral-700 text-xs">

        <div class="gap-6 grid grid-cols-1 md:grid-cols-2">
            <div class="space-y-1">
                <label class="block pl-0.5">Full Professional Name *</label>
                <input type="text" wire:model="name" class="bg-neutral-50 focus:bg-white px-4 py-2.5 border border-neutral-300 rounded-xl outline-none focus:ring-1 focus:ring-primary w-full font-medium text-neutral-900 text-xs">
                @error('name') <span class="block pl-0.5 font-bold text-[10px] text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-1">
                <label class="block pl-0.5">Unique Application Username *</label>
                <input type="text" wire:model="username" class="bg-neutral-50 focus:bg-white px-4 py-2.5 border border-neutral-300 rounded-xl outline-none focus:ring-1 focus:ring-primary w-full font-mono font-bold text-neutral-900 text-xs">
                @error('username') <span class="block pl-0.5 font-bold text-[10px] text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-1">
                <label class="block pl-0.5">Corporate Email Address *</label>
                <input type="email" wire:model="email" class="bg-neutral-50 focus:bg-white px-4 py-2.5 border border-neutral-300 rounded-xl outline-none focus:ring-1 focus:ring-primary w-full font-medium text-neutral-900 text-xs">
                @error('email') <span class="block pl-0.5 font-bold text-[10px] text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-1 select-none">
                <label class="block pl-0.5">Workspace Operations Privilege Level Role</label>
                @if(in_array(auth()->user()->usertype, ['superadmin', 'operationsadmin']))
                    <select wire:model="usertype" class="bg-neutral-50 focus:bg-white px-3 py-2.5 border border-neutral-300 rounded-xl outline-none focus:ring-1 focus:ring-primary w-full font-bold text-neutral-900 text-xs cursor-pointer">
                        <option value="superadmin">Superadmin Context Owner</option>
                        <option value="operationsadmin">Operations Manager</option>
                        <option value="financialofficer">Financial Officer</option>
                        <option value="staff">Standard Logistics Staff</option>
                    </select>
                @else
                    <input type="text" readonly value="{{ uppercase($usertype) }}" class="bg-neutral-100 px-4 py-2.5 border border-neutral-300 rounded-xl outline-none w-full font-mono font-bold text-neutral-400 text-xs cursor-not-allowed select-none">
                    <p class="mt-0.5 pl-0.5 text-[10px] text-neutral-400">Role modifications are locked for standard staff profiles.</p>
                @endif
            </div>
        </div>

        <div class="space-y-4 pt-4 border-neutral-100 border-t">
            <h4 class="font-bold text-[11px] text-primary uppercase tracking-wide select-none">Security Override Credential Key Phrase</h4>

            <div class="gap-6 grid grid-cols-1 md:grid-cols-2">
                <div class="space-y-1">
                    <label class="block pl-0.5 text-neutral-500">Current Validation Password</label>
                    <input type="password" wire:model="currentPassword" placeholder="••••••••••••" class="bg-neutral-50 focus:bg-white px-4 py-2.5 border border-neutral-300 rounded-xl outline-none focus:ring-1 focus:ring-primary w-full text-neutral-900 text-xs">
                    @error('currentPassword') <span class="block pl-0.5 font-bold text-[10px] text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-1">
                    <label class="block pl-0.5 text-neutral-500">New Replacement Pass Phrase Key</label>
                    <input type="password" wire:model="newPassword" placeholder="Minimum 8 characters length" class="bg-neutral-50 focus:bg-white px-4 py-2.5 border border-neutral-300 rounded-xl outline-none focus:ring-1 focus:ring-primary w-full text-neutral-900 text-xs">
                    @error('newPassword') <span class="block pl-0.5 font-bold text-[10px] text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-4 border-neutral-100 border-t select-none">
            <button type="submit" class="bg-primary hover:bg-primary/95 shadow-sm px-6 py-3 rounded-xl font-bold text-white text-xs active:scale-95 transition-all cursor-pointer">
                Save Profile Changes
            </button>
        </div>
    </form>
</div>
