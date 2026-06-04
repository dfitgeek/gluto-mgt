<div>
    <main class="relative flex flex-grow justify-center items-center px-container-padding py-stack-lg overflow-hidden">
    <!-- Background Atmospheric Element -->
    <div
        class="top-1/2 left-1/2 -z-10 absolute bg-primary/5 blur-[120px] rounded-full w-[800px] h-[800px] -translate-x-1/2 -translate-y-1/2 pointer-events-none">
    </div>
    <div class="mx-auto w-full max-w-[1200px]">
        <div class="mb-stack-lg text-center">
            <h1 class="mb-3 font-headline-xl text-headline-xl text-primary">Welcome back, Admin</h1>
            <p class="mx-auto max-w-2xl font-body-lg text-body-lg text-on-surface-variant">Please select your
                operational area. Your access is configured for enterprise-level logistics management.</p>
        </div>
        <div class="gap-stack-md grid grid-cols-1 md:grid-cols-2 perspective-lg">
            <!-- Manage Buyers Card -->
            <div class="group relative cursor-pointer card-inner" onclick="window.location.href='#/buyers'">
                <div
                    class="relative flex flex-col items-center bg-white shadow-sm group-hover:shadow-[0px_10px_32px_rgba(6,78,59,0.12)] p-stack-lg border rounded-2xl border-outline-variant overflow-hidden text-center transition-all group-hover:-translate-y-2 duration-300">
                    <!-- Card Border Accent -->
                    <div class="top-0 bottom-0 left-0 absolute bg-secondary w-1.5"></div>
                    <div
                        class="flex justify-center items-center bg-secondary-container mb-stack-md rounded-2xl w-20 h-20 text-on-secondary-container group-hover:scale-110 transition-transform duration-300">
                        <span class="text-[48px] material-symbols-outlined"
                            style="font-variation-settings: 'FILL' 1;">shopping_bag</span>
                    </div>
                    <h2 class="mb-4 font-headline-lg text-headline-lg text-primary">Manage Buyers</h2>
                    <p class="mb-stack-lg font-body-md text-body-md text-on-surface-variant">
                        Access the buyer ecosystem to monitor procurement requests, verify profiles, and manage
                        transaction cycles for corporate clients.
                    </p>
                    <a href="{{ route('admin.buyers') }}" wire:navigate
                        class="inline-flex items-center gap-2 bg-secondary group-hover:bg-primary mt-auto px-6 py-3 rounded-2xl font-label-md text-label-md text-on-secondary transition-colors">
                        Enter Dashboard
                        <span class="text-sm material-symbols-outlined">arrow_forward</span>
                    </a>
                    <!-- Subtle Pattern Overlay -->
                    <div
                        class="-right-8 -bottom-8 absolute opacity-[0.03] group-hover:opacity-[0.06] transition-opacity">
                        <span class="text-[200px] material-symbols-outlined">pending_actions</span>
                    </div>
                </div>
            </div>
            <!-- Manage Suppliers Card -->
            <div class="group relative cursor-pointer card-inner" onclick="window.location.href='#/suppliers'">
                <div
                    class="relative flex flex-col items-center bg-white shadow-sm group-hover:shadow-[0px_10px_32px_rgba(6,78,59,0.12)] p-stack-lg border rounded-2xl border-outline-variant overflow-hidden text-center transition-all group-hover:-translate-y-2 duration-300">
                    <!-- Card Border Accent -->
                    <div class="top-0 bottom-0 left-0 absolute bg-primary-container w-1.5"></div>
                    <div
                        class="bg-primary-fixed text-on-primary-fixed flex justify-center items-center mb-stack-md rounded-2xl w-20 h-20 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-[48px] material-symbols-outlined"
                            style="font-variation-settings: 'FILL' 1;">local_shipping</span>
                    </div>
                    <h2 class="mb-4 font-headline-lg text-headline-lg text-primary">Manage Suppliers</h2>
                    <p class="mb-stack-lg font-body-md text-body-md text-on-surface-variant">
                        Oversee supplier performance, logistics partnerships, and product inventory metrics across
                        the global supply chain network.
                    </p>
                    <a href="{{ route('admin.suppliers') }}" wire:navigate
                        class="inline-flex items-center gap-2 bg-secondary group-hover:bg-primary mt-auto px-6 py-3 rounded-2xl font-label-md text-label-md text-on-secondary transition-colors">
                        Enter Dashboard
                        <span class="text-sm material-symbols-outlined">arrow_forward</span>
                    </a>
                    <!-- Subtle Pattern Overlay -->
                    <div
                        class="-right-8 -bottom-8 absolute opacity-[0.03] group-hover:opacity-[0.06] transition-opacity">
                        <span class="text-[200px] material-symbols-outlined">inventory_2</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Meta -->
        <div
            class="flex md:flex-row flex-col justify-between items-center gap-4 mt-stack-lg pt-12 border-t border-outline-variant">
            <div class="flex items-center gap-2 font-body-sm text-on-surface-variant">
                <span class="text-sm material-symbols-outlined">verified_user</span>
                Security Status: <span class="font-bold text-secondary">ENCRYPTED</span>
            </div>
            <div class="flex items-center gap-6 font-label-sm text-on-surface-variant">
                <a class="hover:text-primary transition-colors" href="#">Privacy Policy</a>
                <a class="hover:text-primary transition-colors" href="#">System Health</a>
                <a class="flex items-center gap-1 text-error" href="#">
                    <span class="text-sm material-symbols-outlined">logout</span>
                    Sign Out
                </a>
            </div>
        </div>
    </div>
</main>
<!-- Contextual Quick-Add FAB (Optional for selection screen but follows system) -->
<button
    class="right-8 bottom-8 z-50 fixed flex justify-center items-center bg-primary hover:bg-primary-container shadow-[0px_10px_32px_rgba(0,0,0,0.12)] rounded-2xl w-14 h-14 text-on-primary active:scale-90 transition-all">
    <span class="text-2xl material-symbols-outlined" data-icon="add">add</span>
</button>
<script>
    // Micro-interaction for cards
    const cards = document.querySelectorAll('.card-inner');

    cards.forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            const rotateX = (y - centerY) / 20;
            const rotateY = (centerX - x) / 20;

            card.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
        });

        card.addEventListener('mouseleave', () => {
            card.style.transform = `rotateX(0deg) rotateY(0deg)`;
        });
    });

    // Simulating the "Active" logic for the shell if it were present in a full dash
    // In this selection screen, the shell is simplified to a "Gateway" mode.
</script>
</div>
