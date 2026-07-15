<div class="flex-1 mx-auto my-2 p-gutter w-full max-w-[1440px]" x-data="{ accountModalOpen: @entangle('isEditModalOpen') }">

    <div class="flex sm:flex-row flex-col justify-between sm:items-center gap-4 mb-6 pb-4 border-neutral-200 border-b select-none">
        <div>
            <h2 class="font-bold text-neutral-900 text-xl tracking-tight">System Operator Accounts Ledger</h2>
            <p class="mt-0.5 text-neutral-500 text-xs">Audit system permissions, modify security key pass phrases, and oversee account designations across the platform.</p>
        </div>
        <a href="{{ route('create') }}" wire:navigate class="flex items-center gap-1 bg-primary hover:bg-primary/95 shadow-sm px-5 py-2.5 rounded-xl font-bold text-white text-xs active:scale-95 transition-all">
            <span class="text-[16px] material-symbols-outlined">person_add</span> Create New Account
        </a>
    </div>

    @if(session()->has('success'))
        <div class="flex items-center gap-2 bg-emerald-50 mb-6 p-4 border border-emerald-200 rounded-xl font-semibold text-emerald-800 text-xs select-none">
            <span class="text-[18px] material-symbols-outlined">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white shadow-sm border border-neutral-200 rounded-[2rem] overflow-hidden font-medium text-neutral-800">
        <div class="overflow-x-auto hide-scrollbar">
            <table class="w-full text-xs text-left border-collapse">
                <thead>
                    <tr class="bg-neutral-50 border-neutral-200 border-b font-bold text-[10px] text-neutral-500 uppercase tracking-wide select-none">
                        <th class="p-4">Staff Operator Name</th>
                        <th class="p-4">Username Index</th>
                        <th class="p-4">Primary Contact Email</th>
                        <th class="p-4">Permission Privilege Status Role</th>
                        <th class="p-4 text-right">Actions Panel</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100 font-sans text-neutral-900">
                    @forelse($admins as $adminRow)
                        <tr class="hover:bg-neutral-50/50 transition-colors">
                            <td class="p-4 font-bold text-neutral-900">{{ $adminRow->name }}</td>
                            <td class="p-4 font-mono font-bold text-neutral-500">@ {{ $adminRow->username }}</td>
                            <td class="p-4 font-medium text-neutral-600 select-all">{{ $adminRow->email }}</td>
                            <td class="p-4 select-none">
                                <span class="px-2.5 py-0.5 rounded-md font-mono font-bold text-[10px] uppercase border tracking-tight
                                    {{ $adminRow->usertype === 'superadmin' ? 'bg-purple-50 text-purple-700 border-purple-200' : '' }}
                                    {{ $adminRow->usertype === 'operationsadmin' ? 'bg-blue-50 text-blue-700 border-blue-200' : '' }}
                                    {{ $adminRow->usertype === 'financialofficer' ? 'bg-amber-50 text-amber-700 border-amber-200' : '' }}
                                    {{ $adminRow->usertype === 'staff' ? 'bg-neutral-100 text-neutral-600 border-neutral-300' : '' }}
                                ">
                                    {{ $adminRow->usertype }}
                                </span>
                            </td>
                            <td class="p-4 text-right select-none">
                                <button type="button" wire:click="openEditModal({{ $adminRow->id }})" class="bg-neutral-100 hover:bg-primary shadow-inner px-3.5 py-1.5 border border-neutral-300/60 rounded-xl font-bold text-[11px] text-neutral-700 hover:text-white transition-all cursor-pointer">
                                    Edit Account Info
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 font-medium text-neutral-400 text-center italic select-none">
                                There are no back-office administrative user account rows logged under the system context.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($admins->hasPages())
            <div class="bg-neutral-50 p-4 border-neutral-200 border-t select-none">
                {{ $admins->links() }}
            </div>
        @endif
    </div>

    <div x-show="accountModalOpen" x-cloak class="z-[100] fixed inset-0 flex justify-center items-center bg-black/40 shadow-2xl backdrop-blur-sm p-4 animate-fadeIn">
        <div @click.outside="accountModalOpen = false; $wire.call('closeEditModal')" class="bg-white shadow-2xl rounded-[2.5rem] w-full max-w-xl overflow-hidden animate-fadeIn transform">

            <div class="flex justify-between items-center bg-primary p-5 text-white select-none">
                <div class="flex items-center gap-2">
                    <span class="text-[20px] material-symbols-outlined">manage_accounts</span>
                    <h3 class="font-bold text-sm tracking-tight">Modify Operator Account Index</h3>
                </div>
                <button type="button" @click="accountModalOpen = false; $wire.call('closeEditModal')" class="flex justify-center items-center hover:bg-white/10 p-1 rounded-full text-white cursor-pointer material-symbols-outlined">close</button>
            </div>

            <form wire:submit.prevent="saveAdminChanges" class="space-y-4 p-6 font-semibold text-neutral-700 text-xs">

                <div class="gap-4 grid grid-cols-1 sm:grid-cols-2">
                    <div class="space-y-1">
                        <label class="block pl-0.5">Operator Name</label>
                        <input type="text" wire:model="name" class="bg-neutral-50 focus:bg-white px-3 py-2 border border-neutral-300 rounded-xl outline-none focus:ring-1 focus:ring-primary w-full font-medium text-neutral-900">
                        @error('name') <span class="block font-bold text-[10px] text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="block pl-0.5">Username Handle</label>
                        <input type="text" wire:model="username" class="bg-neutral-50 focus:bg-white px-3 py-2 border border-neutral-300 rounded-xl outline-none focus:ring-1 focus:ring-primary w-full font-mono font-bold text-neutral-900">
                        @error('username') <span class="block font-bold text-[10px] text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="block pl-0.5">Email Address</label>
                        <input type="email" wire:model="email" class="bg-neutral-50 focus:bg-white px-3 py-2 border border-neutral-300 rounded-xl outline-none focus:ring-1 focus:ring-primary w-full font-medium text-neutral-900">
                        @error('email') <span class="block font-bold text-[10px] text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1 select-none">
                        <label class="block pl-0.5">Privilege Assignment Designation</label>
                        <select wire:model="usertype" class="bg-neutral-50 focus:bg-white px-2 py-2 border border-neutral-300 rounded-xl outline-none focus:ring-1 focus:ring-primary w-full font-bold text-neutral-900 cursor-pointer">
                            <option value="superadmin">superadmin</option>
                            <option value="operationsadmin">operationsadmin</option>
                            <option value="financialofficer">financialofficer</option>
                            <option value="staff">staff</option>
                        </select>
                        @error('usertype') <span class="block font-bold text-[10px] text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1 sm:col-span-2">
                        <label class="block pl-0.5 text-neutral-500">Reset Password String (Leave blank to preserve current)</label>
                        <input type="text" wire:model="newPassword" placeholder="Enter new minimum 8 characters pass phrase key string" class="bg-neutral-50 focus:bg-white px-3 py-2 border border-neutral-300 rounded-xl outline-none focus:ring-1 focus:ring-primary w-full font-mono text-neutral-900">
                        @error('newPassword') <span class="block font-bold text-[10px] text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex justify-end items-center gap-2 pt-4 border-neutral-100 border-t select-none">
                    <button type="button" @click="accountModalOpen = false; $wire.call('closeEditModal')" class="bg-neutral-100 hover:bg-neutral-200 px-4 py-2 rounded-xl font-bold text-neutral-700 cursor-pointer">Dismiss</button>
                    <button type="submit" class="bg-primary hover:bg-primary/95 shadow-md px-5 py-2 rounded-xl font-bold text-white cursor-pointer">Save Account Overrides</button>
                </div>
            </form>
        </div>
    </div>

</div>
