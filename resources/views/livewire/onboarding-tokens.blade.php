<div class="flex-1 mx-auto p-gutter w-full max-w-[1440px]" x-data="{ copyText(text) { navigator.clipboard.writeText(text); } }">

    <div class="flex sm:flex-row flex-col sm:justify-between sm:items-center gap-4 mb-stack-lg">
        <div>
            <h2 class="mb-1 font-headline-lg font-bold text-headline-lg text-primary text-2xl">Onboarding Access Tokens</h2>
            <p class="font-body-md text-body-md text-on-surface-variant text-sm">Provision and audit tokenized single-use onboarding registration routes for buyers and vendors.</p>
        </div>
    </div>

    <div class="bg-white shadow-sm mb-8 p-6 border rounded-2xl border-outline-variant/60">
        <h3 class="flex items-center gap-1.5 mb-3 font-label-md font-bold text-primary text-sm">
            <span class="text-[18px] material-symbols-outlined">key</span> Provision New Access Token
        </h3>
        <form wire:submit.prevent="generateToken" class="flex sm:flex-row flex-col items-end gap-3">
            <div class="flex-1 space-y-1.5 w-full">
                <label class="block pl-0.5 font-semibold text-on-surface-variant text-xs">Select Candidate User Account</label>
                <select wire:model="selectedUserId" class="bg-surface-container-low px-4 py-3 border rounded-xl border-outline-variant outline-none focus:ring-2 focus:ring-primary w-full font-medium text-sm">
                    <option value="">Choose an onboarding account...</option>
                    @foreach($availableUsers as $availUser)
                        <option value="{{ $availUser->id }}">{{ $availUser->name }} ({{ $availUser->email }})</option>
                    @endforeach
                </select>
                @error('selectedUserId') <span class="block mt-1 pl-0.5 text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="flex justify-center items-center gap-2 bg-primary hover:bg-primary/95 px-6 py-3 rounded-xl w-full sm:w-auto h-[46px] font-label-md font-bold text-white text-xs whitespace-nowrap transition-all cursor-pointer">
                <span class="text-[16px] material-symbols-outlined">add_circle</span> Generate Token
            </button>
        </form>
    </div>

    <div class="bg-white shadow-sm border rounded-2xl border-outline-variant w-full overflow-hidden">
        <div class="px-6 py-4 border-b border-outline-variant">
            <h3 class="font-headline-md font-bold text-primary text-base">Active Provisioning Ledger</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-surface-container-low border-b border-outline-variant/40">
                    <tr>
                        <th class="px-6 py-3.5 font-label-sm font-bold text-on-surface-variant text-xs uppercase tracking-wider">User Identity Context</th>
                        <th class="px-6 py-3.5 font-label-sm font-bold text-on-surface-variant text-xs uppercase tracking-wider">Token Security Hash String</th>
                        <th class="px-6 py-3.5 font-label-sm font-bold text-on-surface-variant text-xs uppercase tracking-wider">Onboarding Status Label</th>
                        <th class="px-6 py-3.5 font-label-sm font-bold text-on-surface-variant text-xs uppercase tracking-wider">Copy Registration Routing Links</th>
                        <th class="px-6 py-3.5 font-label-sm font-bold text-on-surface-variant text-xs text-right uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-outline-variant/30 divide-y text-sm">
                    @forelse($tokens as $tRecord)
                        <tr wire:key="token-row-{{ $tRecord }}" class="hover:bg-surface-container-lowest/40 transition-colors">

                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="font-bold text-on-surface text-sm">{{ $tRecord->user->name }}</span>
                                    <span class="mt-0.5 text-[11px] text-on-surface-variant">{{ $tRecord->user->email }}</span>
                                </div>
                            </td>

                            <td class="px-6 py-4 font-mono text-xs">
                                <span class="inline-block bg-surface-container-high shadow-inner px-2.5 py-1 rounded max-w-[140px] font-bold text-primary truncate tracking-wide" title="{{ $tRecord->token }}">
                                    {{ Str::limit($tRecord->token, 12, '...') }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                @if($tRecord->is_used)
                                    <span class="inline-flex items-center gap-1 bg-emerald-50 px-2.5 py-1 border border-emerald-100 rounded-md font-bold text-[11px] text-emerald-700 uppercase">
                                        <span class="bg-emerald-600 rounded-full w-1.5 h-1.5"></span> Used
                                    </span>
                                @elseif($tRecord->isExpired())
                                    <span class="inline-flex items-center gap-1 bg-red-50 px-2.5 py-1 border border-red-100 rounded-md font-bold text-[11px] text-red-700 uppercase">
                                        <span class="bg-red-600 rounded-full w-1.5 h-1.5"></span> Expired
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 bg-amber-50 px-2.5 py-1 border border-amber-100 rounded-md font-bold text-[11px] text-amber-700 uppercase" title="Expires {{ $tRecord->expires_at->format('M d, h:ia') }}">
                                        <span class="bg-amber-500 rounded-full w-1.5 h-1.5 animate-pulse"></span> Active
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2" x-data="{ supplierCopied: false, buyerCopied: false }">

                                    <button type="button"
                                        @click="copyText('{{ route('admin.suppliers.user.create', ['token' => $tRecord->token]) }}'); supplierCopied = true; setTimeout(() => supplierCopied = false, 2000)"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 border border-outline rounded-lg text-xs font-bold hover:bg-surface-container-low text-primary transition-colors cursor-pointer {{ $tRecord->is_used ? 'opacity-40 pointer-events-none' : '' }}">
                                        <span class="text-[15px] material-symbols-outlined" x-text="supplierCopied ? 'check' : 'local_shipping'"></span>
                                        <span x-text="supplierCopied ? 'Copied Supplier Link!' : 'Supplier Route'"></span>
                                    </button>

                                    <button type="button"
                                        @click="copyText('{{ route('admin.buyer.user.create', ['token' => $tRecord->token, 'role' => 'buyer']) }}'); buyerCopied = true; setTimeout(() => buyerCopied = false, 2000)"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 border border-outline rounded-lg text-xs font-bold hover:bg-surface-container-low text-secondary transition-colors cursor-pointer {{ $tRecord->is_used ? 'opacity-40 pointer-events-none' : '' }}">
                                        <span class="text-[15px] material-symbols-outlined" x-text="buyerCopied ? 'check' : 'shopping_bag'"></span>
                                        <span x-text="buyerCopied ? 'Copied Buyer Link!' : 'Buyer Route'"></span>
                                    </button>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <button type="button"
                                    wire:click="deleteToken({{ $tRecord->id }})"
                                    wire:confirm="Are you sure you want to permanently revoke this registration entry track token?"
                                    class="inline-flex bg-red-50 hover:bg-red-100 p-2 border border-red-100 rounded-xl text-red-600 transition-colors cursor-pointer">
                                    <span class="text-[18px] material-symbols-outlined">delete_forever</span>
                                </button>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="bg-background/20 px-6 py-12 font-body-sm text-on-surface-variant text-center italic">
                                <span class="block mb-1 text-outline text-[36px] material-symbols-outlined">vpn_key_off</span>
                                No access onboarding tokens are currently provisioned across the system directory pool tracking index sheets.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
