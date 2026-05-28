<section class="flex justify-center items-center p-gutter min-h-screen login-canvas">
    <section class="slide-in-from-bottom-4 w-full max-w-[480px] animate-in duration-700 fade-in">
        <div class="flex flex-col items-center mb-stack-lg">
            <div class="flex justify-center items-center bg-primary shadow-lg mb-stack-sm rounded-2xl w-16 h-16">
                <span class="text-[32px] text-on-primary material-symbols-outlined"
                    data-icon="admin_panel_settings">admin_panel_settings</span>
            </div>
            <h1 class="font-headline-md text-headline-md text-primary tracking-tight">GLUTO MANAGEMENT LOG</h1>
            <p class="mt-1 font-body-sm text-body-sm text-on-surface-variant">Enterprise Management Portal</p>
        </div>

        <section class="bg-surface-container-lowest soft-forest-shadow p-10 border rounded-2xl border-outline-variant/30">
            <header class="mb-stack-lg">
                <h2 class="mb-2 font-headline-sm font-bold text-[20px] text-on-surface">Welcome Back</h2>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Please enter your credentials to access the management dashboard.</p>
            </header>

            @if (session()->has('error'))
                <div class="bg-red-50 mb-4 p-3 border border-red-200 rounded-xl text-red-600 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form wire:submit.prevent="login" class="space-y-stack-md">

                <div class="space-y-2">
                    <label class="block ml-1 font-label-md text-label-md text-on-surface-variant" for="email">Email Address</label>
                    <div class="group relative">
                        <div class="left-0 absolute inset-y-0 flex items-center pl-4 pointer-events-none">
                            <span class="text-outline text-[20px] group-focus-within:text-secondary transition-colors material-symbols-outlined"
                                data-icon="person">mail</span>
                        </div>
                        <input wire:model="email"
                            class="bg-surface @error('email') @enderror focus:border-secondary border-outline-variant placeholder:text-outline-variant/60 focus:ring-secondary/20 font-body-md text-body-md w-full rounded-xl border border-red-500 py-3 pl-11 pr-4 outline-none transition-all focus:ring-2"
                            id="email" type="email" placeholder="admin@glutointernational.com" required />
                    </div>
                    @error('email') <span class="pl-1 text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center px-1">
                        <label class="block font-label-md text-label-md text-on-surface-variant" for="password">Password</label>
                        <a class="font-label-sm text-label-sm text-secondary hover:underline transition-all" href="#">Forgot Password?</a>
                    </div>
                    <div class="group relative">
                        <div class="left-0 absolute inset-y-0 flex items-center pl-4 pointer-events-none">
                            <span class="text-outline text-[20px] group-focus-within:text-secondary transition-colors material-symbols-outlined"
                                data-icon="lock">lock</span>
                        </div>
                        <input wire:model="password"
                            class="bg-surface @error('password') @enderror focus:border-secondary border-outline-variant placeholder:text-outline-variant/60 focus:ring-secondary/20 font-body-md text-body-md w-full rounded-xl border border-red-500 py-3 pl-11 pr-12 outline-none transition-all focus:ring-2"
                            id="password" placeholder="••••••••" required type="password" />

                        <button class="right-0 absolute inset-y-0 flex items-center pr-4 hover:text-outline text-outline-variant transition-colors"
                            type="button" id="togglePasswordBtn">
                            <span class="text-[20px] material-symbols-outlined" id="togglePasswordIcon">visibility</span>
                        </button>
                    </div>
                    @error('password') <span class="pl-1 text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center gap-3 px-1 pt-1">
                    <input wire:model="remember"
                        class="rounded border-outline-variant focus:ring-secondary w-5 h-5 text-secondary transition-all"
                        id="remember" type="checkbox" />
                    <label class="font-body-sm text-body-sm text-on-surface-variant cursor-pointer" for="remember">Keep me logged in</label>
                </div>

                <button class="flex justify-center items-center gap-2 bg-primary hover:bg-primary-container shadow-md mt-4 py-4 rounded-2xl w-full font-label-md text-label-md text-on-primary active:scale-[0.98] transition-all"
                    type="submit" wire:loading.attr="disabled">

                    <span wire:loading class="mr-1 border-2 border-white border-t-transparent rounded-full w-4 h-4 animate-spin"></span>
                    <span wire:loading.remove>Sign In</span>

                    <span wire:loading.remove class="text-[18px] material-symbols-outlined" data-icon="arrow_forward">arrow_forward</span>
                </button>
            </form>

            <footer class="mt-stack-lg pt-stack-md border-t border-outline-variant/20">
                <div class="flex justify-center items-center gap-2 mb-stack-sm">
                    <div class="flex-1 bg-outline-variant/30 h-px"></div>
                    <span class="px-2 font-label-sm text-label-sm text-on-surface-variant">Access Control</span>
                    <div class="flex-1 bg-outline-variant/30 h-px"></div>
                </div>
                <div class="gap-3 grid grid-cols-2">
                    <button class="flex justify-center items-center gap-2 bg-surface hover:bg-surface-container-high px-4 py-3 border rounded-xl border-outline-variant font-label-sm text-label-sm text-on-surface-variant transition-all">
                        {{-- <span class=">key</span> --}}
                        <span class="text-[18px] material-symbols-outlined" data-icon="key"">
                            bungalow                     </span>BUYER LOGIN
                    </button>
                    <button class="flex justify-center items-center gap-2 bg-surface hover:bg-surface-container-high px-4 py-3 border rounded-xl border-outline-variant font-label-sm text-label-sm text-on-surface-variant transition-all">
                        <span class="text-[18px] material-symbols-outlined" data-icon="qr_code_2">conveyor_belt</span>SUPPLIER LOGIN
                    </button>
                </div>
            </footer>
        </section>

        <div class="flex flex-col items-center mt-stack-lg">
            <div class="flex gap-stack-md">
                <a class="flex items-center gap-1 font-label-sm text-label-sm text-on-surface-variant hover:text-secondary transition-colors" href="#">
                    <span class="text-[16px] material-symbols-outlined" data-icon="support">support</span>Contact Support
                </a>
                <a class="flex items-center gap-1 font-label-sm text-label-sm text-on-surface-variant hover:text-secondary transition-colors" href="#">
                    <span class="text-[16px] material-symbols-outlined" data-icon="security">security</span>Security Policy
                </a>
            </div>
            <p class="mt-6 text-outline-variant font-body-sm text-[12px] text-center">
                © 2026 Gluto International Limited. All rights reserved.<br />
                Unauthorized access to this portal is strictly prohibited and monitored.
            </p>
        </div>
    </section>

    <div class="top-[-10%] right-[-10%] fixed bg-primary/5 blur-[120px] rounded-full w-[40%] h-[40%] pointer-events-none"></div>
    <div class="bottom-[-10%] left-[-10%] fixed bg-secondary/10 blur-[100px] rounded-full w-[30%] h-[30%] pointer-events-none"></div>

    <script>
        // Cleaned JavaScript micro-interactions for layout input scaling
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', () => { input.parentElement.closest('.group')?.classList.add('scale-[1.01]'); });
            input.addEventListener('blur', () => { input.parentElement.closest('.group')?.classList.remove('scale-[1.01]'); });
        });

        // Fixed DOM password toggle script to interact correctly alongside Livewire components
        const toggleBtn = document.getElementById('togglePasswordBtn');
        const passField = document.getElementById('password');
        const toggleIcon = document.getElementById('togglePasswordIcon');

        toggleBtn?.addEventListener('click', () => {
            const isPass = passField.type === 'password';
            passField.type = isPass ? 'text' : 'password';
            toggleIcon.innerText = isPass ? 'visibility_off' : 'visibility';
        });
    </script>
</section>
