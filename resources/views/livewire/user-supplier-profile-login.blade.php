<div class="flex justify-center items-center bg-background px-4 sm:px-6 lg:px-8 py-12 min-h-screen" x-data="{ showPassword: false }">
    <div class="space-y-8 bg-white shadow-xl p-8 border rounded-[2.5rem] border-outline-variant/60 w-full max-w-md animate-fadeIn">

        <div class="text-center">
            <div class="flex justify-center items-center bg-primary/10 mx-auto mb-4 rounded-2xl w-12 h-12 text-primary">
                <span class="text-[28px] material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">local_shipping</span>
            </div>
            <h2 class="font-headline-lg font-bold text-primary text-2xl tracking-tight">Vendor Portal Access</h2>
            <p class="mt-1.5 font-body-sm text-on-surface-variant text-sm">Sign in with your corporate credentials to manage your logistics pipeline.</p>
        </div>

        @if (session()->has('success'))
            <div class="flex items-center gap-2 bg-emerald-50 p-4 border border-emerald-200 rounded-xl font-semibold text-emerald-800 text-xs animate-fadeIn">
                <span class="text-[18px] material-symbols-outlined">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form wire:submit.prevent="login" class="space-y-5 mt-8">

            <div class="space-y-1.5">
                <label for="email_address" class="block pl-1 font-bold text-on-surface-variant text-xs">Corporate Email Address</label>
                <div class="relative shadow-sm rounded-xl">
                    <div class="left-0 absolute inset-y-0 flex items-center pl-3 text-outline pointer-events-none">
                        <span class="text-[20px] material-symbols-outlined">mail</span>
                    </div>
                    <input wire:model.blur="email_address" id="email_address" type="email" autocomplete="email" required
                        class="bg-surface-container-low block w-full pl-10 pr-4 py-3 border @error('email_address') border-red-500 ring-1 ring-red-500/30 @else border-outline-variant @enderror rounded-xl outline-none text-sm transition-all focus:ring-2 focus:ring-primary focus:bg-white"
                        placeholder="logistics@yourcompany.com">
                </div>
                @error('email_address') <span class="block mt-1 pl-1 font-medium text-red-500 text-xs animate-fadeIn">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-1.5">
                <div class="flex justify-between items-center px-1">
                    <label for="password" class="block font-bold text-on-surface-variant text-xs">Account Secure Password</label>
                    <a href="#" class="font-bold text-secondary text-xs hover:underline">Forgot password?</a>
                </div>
                <div class="relative shadow-sm rounded-xl">
                    <div class="left-0 absolute inset-y-0 flex items-center pl-3 text-outline pointer-events-none">
                        <span class="text-[20px] material-symbols-outlined">lock</span>
                    </div>

                    <input wire:model.defer="password" id="password" :type="showPassword ? 'text' : 'password'" autocomplete="current-password" required
                        class="bg-surface-container-low block w-full pl-10 pr-10 py-3 border @error('password') border-red-500 ring-1 ring-red-500/30 @else border-outline-variant @enderror rounded-xl outline-none text-sm transition-all focus:ring-2 focus:ring-primary focus:bg-white"
                        placeholder="••••••••••••">

                    <button type="button" @click="showPassword = !showPassword"
                        class="right-0 absolute inset-y-0 flex items-center pr-3 text-on-surface-variant/70 hover:text-primary cursor-pointer select-none">
                        <span class="text-[20px] material-symbols-outlined" x-text="showPassword ? 'visibility_off' : 'visibility'">visibility</span>
                    </button>
                </div>
                @error('password') <span class="block mt-1 pl-1 font-medium text-red-500 text-xs animate-fadeIn">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-between items-center pt-1 pl-1">
                <label class="flex items-center gap-2.5 cursor-pointer select-none">
                    <input wire:model="remember" type="checkbox"
                        class="rounded border-outline-variant outline-none focus:ring-primary w-4 h-4 text-primary transition-colors">
                    <span class="font-semibold text-on-surface-variant text-xs">Keep my supplier session active</span>
                </label>
            </div>

            <div class="pt-2">
                <button type="submit" wire:loading.attr="disabled"
                    class="group relative flex justify-center items-center gap-2 bg-primary hover:bg-primary/95 disabled:opacity-50 shadow-md shadow-primary/10 px-4 py-3.5 rounded-xl w-full font-label-md font-bold text-white text-xs transition-all cursor-pointer disabled:cursor-not-allowed">

                    <span wire:loading.remove class="flex items-center gap-2">
                        <span>Secure Login</span>
                        <span class="text-[16px] material-symbols-outlined">vpn_key</span>
                    </span>

                    <span wire:loading class="flex items-center gap-2 animate-pulse">
                        <span class="inline-block border-2 border-white border-t-transparent rounded-full w-4 h-4 animate-spin"></span>
                        <span>Verifying Security Matrix...</span>
                    </span>
                </button>
            </div>
        </form>

        <div class="mt-6 pt-5 border-t border-outline-variant/40 text-center">
            <p class="text-[11px] text-on-surface-variant/80 leading-relaxed">
                Protected corporate ecosystem channel. Unauthorized extraction or identity emulation actions are cataloged under internal trace logs protocols.
            </p>
        </div>

    </div>
</div>
