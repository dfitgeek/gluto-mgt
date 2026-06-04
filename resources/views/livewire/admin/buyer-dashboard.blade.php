  <!-- Content Area -->
  <main class="bg-background min-h-screen flex-1">
    <!-- TopAppBar -->

    <!-- Dashboard Content -->
    <div class="p-container-padding mx-auto max-w-[1440px]">
        <!-- Page Header -->
        <div class="pb-stack-lg">
            <h2 class="font-headline-lg text-headline-lg text-primary">Operational Overview</h2>
            <p class="font-body-md text-body-md text-on-surface-variant">Real-time monitoring of procurement and
                buyer lifecycle.</p>
        </div>
        <!-- Metric Cards Grid (Bento Style) -->
        <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
            <!-- Total Buyers -->
            <div
                class="bg-surface-container-lowest border-outline-variant rounded-2xl border p-6 shadow-sm transition-all hover:shadow-[0px_4px_20px_rgba(6,78,59,0.05)]">
                <div class="mb-4 flex items-center justify-between">
                    <div class="bg-secondary-container rounded-lg p-2">
                        <span class="text-on-secondary-container material-symbols-outlined"
                            style="font-variation-settings: 'FILL' 1;">groups</span>
                    </div>
                    <span class="font-label-md text-label-md text-secondary">+12.5%</span>
                </div>
                <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Total
                    Buyers</p>
                <h3 class="font-headline-md text-headline-md text-on-surface mt-1">2,842</h3>
            </div>
            <!-- Pending Orders -->
            <div
                class="bg-surface-container-lowest border-outline-variant rounded-2xl border p-6 shadow-sm transition-all hover:shadow-[0px_4px_20px_rgba(6,78,59,0.05)]">
                <div class="mb-4 flex items-center justify-between">
                    <div class="rounded-lg bg-amber-100 p-2">
                        <span class="material-symbols-outlined text-amber-700"
                            style="font-variation-settings: 'FILL' 1;">pending</span>
                    </div>
                    <span class="font-label-md text-label-md text-amber-700">High Priority</span>
                </div>
                <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Pending
                    Orders</p>
                <h3 class="font-headline-md text-headline-md text-on-surface mt-1">142</h3>
            </div>
            <!-- Processed This Month -->
            <div
                class="bg-surface-container-lowest border-outline-variant rounded-2xl border p-6 shadow-sm transition-all hover:shadow-[0px_4px_20px_rgba(6,78,59,0.05)]">
                <div class="mb-4 flex items-center justify-between">
                    <div class="bg-primary-fixed rounded-lg p-2">
                        <span class="text-primary material-symbols-outlined"
                            style="font-variation-settings: 'FILL' 1;">check_circle</span>
                    </div>
                    <span class="font-label-md text-label-md text-primary">98% Success</span>
                </div>
                <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">
                    Processed Buyers</p>
                <h3 class="font-headline-md text-headline-md text-on-surface mt-1">518</h3>
            </div>
            <!-- Revenue/Invoices -->
            <div
                class="bg-surface-container-lowest border-outline-variant rounded-2xl border p-6 shadow-sm transition-all hover:shadow-[0px_4px_20px_rgba(6,78,59,0.05)]">
                <div class="mb-4 flex items-center justify-between">
                    <div class="rounded-lg bg-blue-100 p-2">
                        <span class="material-symbols-outlined text-blue-700"
                            style="font-variation-settings: 'FILL' 1;">receipt</span>
                    </div>
                    <span class="font-label-md text-label-md text-blue-700">Recent</span>
                </div>
                <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Recent
                    Invoices</p>
                <h3 class="font-headline-md text-headline-md text-on-surface mt-1">24</h3>
            </div>
        </div>
        <!-- Main Data Section -->
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            <!-- Table Section (Unprocessed Buyers) -->
            <div
                class="bg-surface-container-lowest border-outline-variant overflow-hidden rounded-2xl border shadow-sm lg:col-span-2">
                <div class="border-outline-variant flex items-center justify-between border-b p-6">
                    <div>
                        <h3 class="font-headline-md text-headline-md text-on-surface">Recent Unprocessed Buyers
                        </h3>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Queue for verification and
                            profile activation.</p>
                    </div>
                    <button class="font-label-md text-primary hover:underline">View All Queue</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-left">
                        <thead>
                            <tr class="bg-surface-container-low">
                                <th class="font-label-md text-label-md text-on-surface-variant px-6 py-4">Buyer
                                    Name</th>
                                <th class="font-label-md text-label-md text-on-surface-variant px-6 py-4">
                                    Registration Date</th>
                                <th class="font-label-md text-label-md text-on-surface-variant px-6 py-4">Region
                                </th>
                                <th class="font-label-md text-label-md text-on-surface-variant px-6 py-4">Status
                                </th>
                                <th
                                    class="font-label-md text-label-md text-on-surface-variant px-6 py-4 text-right">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-outline-variant divide-y">
                            <tr class="hover:bg-surface-container-high group transition-colors">
                                <td class="border-l-4 border-amber-500 px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="bg-surface-container text-primary flex h-8 w-8 items-center justify-center rounded-full font-bold">
                                            GC</div>
                                        <span class="font-body-md text-body-md text-on-surface">Global Corp
                                            S.A.</span>
                                    </div>
                                </td>
                                <td class="font-body-sm text-body-sm text-on-surface-variant px-6 py-4">Oct 24,
                                    2023</td>
                                <td class="font-body-sm text-body-sm text-on-surface-variant px-6 py-4">EMEA
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="rounded-full bg-amber-100 px-3 py-1 text-[12px] font-bold uppercase tracking-wider text-amber-700">Pending</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button
                                        class="text-primary hover:text-secondary-container transition-colors">
                                        <span class="material-symbols-outlined">chevron_right</span>
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-surface-container-high group transition-colors">
                                <td class="border-l-4 border-amber-500 px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="bg-surface-container text-primary flex h-8 w-8 items-center justify-center rounded-full font-bold">
                                            NL</div>
                                        <span class="font-body-md text-body-md text-on-surface">NexGen
                                            Logistics</span>
                                    </div>
                                </td>
                                <td class="font-body-sm text-body-sm text-on-surface-variant px-6 py-4">Oct 23,
                                    2023</td>
                                <td class="font-body-sm text-body-sm text-on-surface-variant px-6 py-4">APAC
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="rounded-full bg-amber-100 px-3 py-1 text-[12px] font-bold uppercase tracking-wider text-amber-700">Pending</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button
                                        class="text-primary hover:text-secondary-container transition-colors">
                                        <span class="material-symbols-outlined">chevron_right</span>
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-surface-container-high group transition-colors">
                                <td class="border-secondary border-l-4 px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="bg-surface-container text-primary flex h-8 w-8 items-center justify-center rounded-full font-bold">
                                            TI</div>
                                        <span class="font-body-md text-body-md text-on-surface">Tech-Innova
                                            Hub</span>
                                    </div>
                                </td>
                                <td class="font-body-sm text-body-sm text-on-surface-variant px-6 py-4">Oct 22,
                                    2023</td>
                                <td class="font-body-sm text-body-sm text-on-surface-variant px-6 py-4">NA</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="bg-secondary-container text-on-secondary-container rounded-full px-3 py-1 text-[12px] font-bold uppercase tracking-wider">Reviewing</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button
                                        class="text-primary hover:text-secondary-container transition-colors">
                                        <span class="material-symbols-outlined">chevron_right</span>
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-surface-container-high group transition-colors">
                                <td class="border-l-4 border-amber-500 px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="bg-surface-container text-primary flex h-8 w-8 items-center justify-center rounded-full font-bold">
                                            SV</div>
                                        <span class="font-body-md text-body-md text-on-surface">Summit Venture
                                            Co.</span>
                                    </div>
                                </td>
                                <td class="font-body-sm text-body-sm text-on-surface-variant px-6 py-4">Oct 21,
                                    2023</td>
                                <td class="font-body-sm text-body-sm text-on-surface-variant px-6 py-4">EMEA
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="rounded-full bg-amber-100 px-3 py-1 text-[12px] font-bold uppercase tracking-wider text-amber-700">Pending</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button
                                        class="text-primary hover:text-secondary-container transition-colors">
                                        <span class="material-symbols-outlined">chevron_right</span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Side Insights Section -->
            <div class="space-y-6">
                <!-- Quick Add Task Card -->
                <div
                    class="bg-primary-container text-on-primary-container relative overflow-hidden rounded-2xl p-6 shadow-lg">
                    <div class="relative z-10">
                        <h4 class="font-headline-md text-headline-md mb-2">Efficiency Tip</h4>
                        <p class="font-body-sm text-body-sm mb-4 opacity-80">You have 12 unprocessed buyers from
                            the last 24 hours. Processing them now can increase quarterly turnover by 4%.</p>
                        <button
                            class="bg-secondary-container font-label-md text-on-secondary-container rounded-xl px-4 py-2 transition-transform hover:scale-105 active:scale-95">
                            Accelerate Processing
                        </button>
                    </div>
                    <span
                        class="material-symbols-outlined absolute -bottom-4 -right-4 text-[120px] opacity-10">bolt</span>
                </div>
                <!-- System Health Card -->
                <div
                    class="bg-surface-container-lowest border-outline-variant rounded-2xl border p-6 shadow-sm">
                    <h4 class="font-label-md text-label-md text-on-surface mb-4">Verification Health</h4>
                    <div class="space-y-4">
                        <div>
                            <div class="mb-1 flex justify-between text-[12px]">
                                <span class="font-label-sm text-on-surface-variant">KYC Compliance</span>
                                <span class="font-label-sm text-primary">92%</span>
                            </div>
                            <div class="bg-surface-container-high h-2 w-full overflow-hidden rounded-full">
                                <div class="bg-primary h-full w-[92%] rounded-full"></div>
                            </div>
                        </div>
                        <div>
                            <div class="mb-1 flex justify-between text-[12px]">
                                <span class="font-label-sm text-on-surface-variant">System Latency</span>
                                <span class="font-label-sm text-primary">24ms</span>
                            </div>
                            <div class="bg-surface-container-high h-2 w-full overflow-hidden rounded-full">
                                <div class="bg-secondary h-full w-[15%] rounded-full"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Activity Feed -->
                <div
                    class="bg-surface-container-lowest border-outline-variant rounded-2xl border p-6 shadow-sm">
                    <h4 class="font-label-md text-label-md text-on-surface mb-4">Recent Activity</h4>
                    <div class="space-y-4">
                        <div class="flex gap-3">
                            <div class="bg-secondary mt-2 h-2 w-2 rounded-full"></div>
                            <div>
                                <p class="font-body-sm text-body-sm text-on-surface"><span
                                        class="font-bold">System</span> automatically verified Buyer #9482</p>
                                <p class="text-on-surface-variant text-[10px]">2 mins ago</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="bg-primary mt-2 h-2 w-2 rounded-full"></div>
                            <div>
                                <p class="font-body-sm text-body-sm text-on-surface"><span
                                        class="font-bold">Admin</span> created profile for Delta Energy</p>
                                <p class="text-on-surface-variant text-[10px]">1 hour ago</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="mt-2 h-2 w-2 rounded-full bg-amber-500"></div>
                            <div>
                                <p class="font-body-sm text-body-sm text-on-surface"><span
                                        class="font-bold">Warning:</span> Invoice #902 delayed</p>
                                <p class="text-on-surface-variant text-[10px]">3 hours ago</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>