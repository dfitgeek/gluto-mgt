<div class="flex-1 mx-auto my-2 p-gutter w-full max-w-4xl">

    <div class="mb-6 pb-4 border-neutral-200 border-b select-none">
        <h2 class="font-bold text-neutral-900 text-xl tracking-tight">Provision New Workspace Operator</h2>
        <p class="mt-0.5 text-neutral-500 text-xs">Create a separate back-office operator line and assign their access permissions.</p>
    </div>

    @if(session()->has('success'))
        <div class="flex items-center gap-2 bg-emerald-50 mb-6 p-4 border border-emerald-200 rounded-xl font-semibold text-emerald-800 text-xs select-none">
            <span class="text-[18px] material-symbols-outlined">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <form wire:submit.prevent="createAdmin" class="space-y-6 bg-white p-6 border border-neutral-200 rounded-[2rem] font-semibold text-neutral-700 text-xs">

        <div class="gap-6 grid grid-cols-1 md:grid-cols-2">
            <div class="space-y-1">
                <label class="block pl-0.5">Operator Real Name *</label>
                <input type="text" wire:model="name" placeholder="John Doe" class="bg-neutral-50 focus:bg-white px-4 py-2.5 border border-neutral-300 rounded-xl outline-none focus:ring-1 focus:ring-primary w-full font-medium text-neutral-900 text-xs">
                @error('name') <span class="block pl-0.5 font-bold text-[10px] text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-1">
                <label class="block pl-0.5">Assigned Login Username *</label>
                <input type="text" wire:model="username" placeholder="johndoe_ops" class="bg-neutral-50 focus:bg-white px-4 py-2.5 border border-neutral-300 rounded-xl outline-none focus:ring-1 focus:ring-primary w-full font-mono font-bold text-neutral-900 text-xs">
                @error('username') <span class="block pl-0.5 font-bold text-[10px] text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-1">
                <label class="block pl-0.5">Operator Primary Corporate Email Address *</label>
                <input type="email" wire:model="email" placeholder="johndoe@enterprise.com" class="bg-neutral-50 focus:bg-white px-4 py-2.5 border border-neutral-300 rounded-xl outline-none focus:ring-1 focus:ring-primary w-full font-medium text-neutral-900 text-xs">
                @error('email') <span class="block pl-0.5 font-bold text-[10px] text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-1 select-none">
                <label class="block pl-0.5">Operational Permission Assignment Rule *</label>
                <select wire:model="usertype" class="bg-neutral-50 focus:bg-white px-3 py-2.5 border border-neutral-300 rounded-xl outline-none focus:ring-1 focus:ring-primary w-full font-bold text-neutral-900 text-xs cursor-pointer">
                    <option value="staff">Standard Logistics Staff User</option>
                    <option value="financialofficer">Financial Officer User</option>
                    <option value="operationsadmin">Operations Manager User</option>
                    <option value="superadmin">Superadmin Workspace Co-Owner</option>
                </select>
                @error('usertype') <span class="block pl-0.5 font-bold text-[10px] text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-1 md:col-span-2">
                <label class="block pl-0.5">Initial Access Password Key Phrase *</label>
                <input type="text" wire:model="password" placeholder="Create a strong phrase with at least 8 characters" class="bg-neutral-50 focus:bg-white px-4 py-2.5 border border-neutral-300 rounded-xl outline-none focus:ring-1 focus:ring-primary w-full font-mono text-neutral-900 text-xs">
                @error('password') <span class="block pl-0.5 font-bold text-[10px] text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex justify-end pt-4 border-neutral-100 border-t select-none">
            <button type="submit" class="bg-primary hover:bg-primary/95 shadow-sm px-6 py-3 rounded-xl font-bold text-white text-xs active:scale-95 transition-all cursor-pointer">
                Initialize System Account
            </button>
        </div>
    </form>
</div>
