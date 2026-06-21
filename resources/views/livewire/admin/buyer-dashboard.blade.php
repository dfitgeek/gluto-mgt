  <!-- Content Area -->
  <main class="flex-1 bg-background min-h-screen">
    <!-- TopAppBar -->

    <!-- Dashboard Content -->
    <div class="mx-auto p-container-padding max-w-[1440px]">
        <!-- Page Header -->
        <div class="pb-stack-lg">
            <h2 class="font-headline-lg text-headline-lg text-primary">Operational Overview</h2>
            <p class="font-body-md text-body-md text-on-surface-variant">Real-time monitoring of procurement and
                buyer lifecycle.</p>
        </div>
        <!-- Metric Cards Grid (Bento Style) -->
        <div class="gap-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 mb-8">
            <!-- Total Buyers -->
            <div
                class="bg-surface-container-lowest shadow-sm hover:shadow-[0px_4px_20px_rgba(6,78,59,0.05)] p-6 border rounded-2xl border-outline-variant transition-all">
                <div class="flex justify-between items-center mb-4">
                    <div class="bg-secondary-container p-2 rounded-lg">
                        <span class="text-on-secondary-container material-symbols-outlined"
                            style="font-variation-settings: 'FILL' 1;">groups</span>
                    </div>
                    <span class="font-label-md text-label-md text-secondary">+12.5%</span>
                </div>
                <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Total
                    Buyers</p>
                <h3 class="mt-1 font-headline-md text-headline-md text-on-surface">2,842</h3>
            </div>
            <!-- Pending Orders -->
            <div
                class="bg-surface-container-lowest shadow-sm hover:shadow-[0px_4px_20px_rgba(6,78,59,0.05)] p-6 border rounded-2xl border-outline-variant transition-all">
                <div class="flex justify-between items-center mb-4">
                    <div class="bg-amber-100 p-2 rounded-lg">
                        <span class="text-amber-700 material-symbols-outlined"
                            style="font-variation-settings: 'FILL' 1;">pending</span>
                    </div>
                    <span class="font-label-md text-amber-700 text-label-md">High Priority</span>
                </div>
                <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Pending
                    Orders</p>
                <h3 class="mt-1 font-headline-md text-headline-md text-on-surface">142</h3>
            </div>
            <!-- Processed This Month -->
            <div
                class="bg-surface-container-lowest shadow-sm hover:shadow-[0px_4px_20px_rgba(6,78,59,0.05)] p-6 border rounded-2xl border-outline-variant transition-all">
                <div class="flex justify-between items-center mb-4">
                    <div class="bg-primary-fixed p-2 rounded-lg">
                        <span class="text-primary material-symbols-outlined"
                            style="font-variation-settings: 'FILL' 1;">check_circle</span>
                    </div>
                    <span class="font-label-md text-label-md text-primary">98% Success</span>
                </div>
                <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">
                    Processed Buyers</p>
                <h3 class="mt-1 font-headline-md text-headline-md text-on-surface">518</h3>
            </div>
            <!-- Revenue/Invoices -->
            <div
                class="bg-surface-container-lowest shadow-sm hover:shadow-[0px_4px_20px_rgba(6,78,59,0.05)] p-6 border rounded-2xl border-outline-variant transition-all">
                <div class="flex justify-between items-center mb-4">
                    <div class="bg-blue-100 p-2 rounded-lg">
                        <span class="text-blue-700 material-symbols-outlined"
                            style="font-variation-settings: 'FILL' 1;">receipt</span>
                    </div>
                    <span class="font-label-md text-blue-700 text-label-md">Recent</span>
                </div>
                <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Recent
                    Invoices</p>
                <h3 class="mt-1 font-headline-md text-headline-md text-on-surface">24</h3>
            </div>
        </div>
        <!-- Main Data Section -->
        <div class="gap-8 grid grid-cols-1 lg:grid-cols-3">
            <!-- Table Section (Unprocessed Buyers) -->
            <div
                class="lg:col-span-2 bg-surface-container-lowest shadow-sm border rounded-2xl border-outline-variant overflow-hidden">
                <div class="flex justify-between items-center p-6 border-b border-outline-variant">
                    <div>
                        <h3 class="font-headline-md text-headline-md text-on-surface">Recent Unprocessed Buyers
                        </h3>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Queue for verification and
                            profile activation.</p>
                    </div>
                    <button class="font-label-md text-primary hover:underline">View All Queue</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low">
                                <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant">Buyer
                                    Name</th>
                                <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant">
                                    Registration Date</th>
                                <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant">Region
                                </th>
                                <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant">Status
                                </th>
                                <th
                                    class="px-6 py-4 font-label-md text-label-md text-on-surface-variant text-right">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-outline-variant divide-y">
                            <tr class="group hover:bg-surface-container-high transition-colors">
                                <td class="px-6 py-4 border-amber-500 border-l-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex justify-center items-center bg-surface-container rounded-full w-8 h-8 font-bold text-primary">
                                            GC</div>
                                        <span class="font-body-md text-body-md text-on-surface">Global Corp
                                            S.A.</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-body-sm text-body-sm text-on-surface-variant">Oct 24,
                                    2023</td>
                                <td class="px-6 py-4 font-body-sm text-body-sm text-on-surface-variant">EMEA
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="bg-amber-100 px-3 py-1 rounded-full font-bold text-[12px] text-amber-700 uppercase tracking-wider">Pending</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button
                                        class="text-primary hover:text-secondary-container transition-colors">
                                        <span class="material-symbols-outlined">chevron_right</span>
                                    </button>
                                </td>
                            </tr>
                            <tr class="group hover:bg-surface-container-high transition-colors">
                                <td class="px-6 py-4 border-amber-500 border-l-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex justify-center items-center bg-surface-container rounded-full w-8 h-8 font-bold text-primary">
                                            NL</div>
                                        <span class="font-body-md text-body-md text-on-surface">NexGen
                                            Logistics</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-body-sm text-body-sm text-on-surface-variant">Oct 23,
                                    2023</td>
                                <td class="px-6 py-4 font-body-sm text-body-sm text-on-surface-variant">APAC
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="bg-amber-100 px-3 py-1 rounded-full font-bold text-[12px] text-amber-700 uppercase tracking-wider">Pending</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button
                                        class="text-primary hover:text-secondary-container transition-colors">
                                        <span class="material-symbols-outlined">chevron_right</span>
                                    </button>
                                </td>
                            </tr>
                            <tr class="group hover:bg-surface-container-high transition-colors">
                                <td class="px-6 py-4 border-secondary border-l-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex justify-center items-center bg-surface-container rounded-full w-8 h-8 font-bold text-primary">
                                            TI</div>
                                        <span class="font-body-md text-body-md text-on-surface">Tech-Innova
                                            Hub</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-body-sm text-body-sm text-on-surface-variant">Oct 22,
                                    2023</td>
                                <td class="px-6 py-4 font-body-sm text-body-sm text-on-surface-variant">NA</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="bg-secondary-container px-3 py-1 rounded-full font-bold text-[12px] text-on-secondary-container uppercase tracking-wider">Reviewing</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button
                                        class="text-primary hover:text-secondary-container transition-colors">
                                        <span class="material-symbols-outlined">chevron_right</span>
                                    </button>
                                </td>
                            </tr>
                            <tr class="group hover:bg-surface-container-high transition-colors">
                                <td class="px-6 py-4 border-amber-500 border-l-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex justify-center items-center bg-surface-container rounded-full w-8 h-8 font-bold text-primary">
                                            SV</div>
                                        <span class="font-body-md text-body-md text-on-surface">Summit Venture
                                            Co.</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-body-sm text-body-sm text-on-surface-variant">Oct 21,
                                    2023</td>
                                <td class="px-6 py-4 font-body-sm text-body-sm text-on-surface-variant">EMEA
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="bg-amber-100 px-3 py-1 rounded-full font-bold text-[12px] text-amber-700 uppercase tracking-wider">Pending</span>
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
                    class="relative bg-primary-container shadow-lg p-6 rounded-2xl overflow-hidden text-on-primary-container">
                    <div class="z-10 relative">
                        <h4 class="mb-2 font-headline-md text-headline-md">Efficiency Tip</h4>
                        <p class="opacity-80 mb-4 font-body-sm text-body-sm">You have 12 unprocessed buyers from
                            the last 24 hours. Processing them now can increase quarterly turnover by 4%.</p>
                        <button
                            class="bg-secondary-container px-4 py-2 rounded-xl font-label-md text-on-secondary-container hover:scale-105 active:scale-95 transition-transform">
                            Accelerate Processing
                        </button>
                    </div>
                    <span
                        class="-right-4 -bottom-4 absolute opacity-10 text-[120px] material-symbols-outlined">bolt</span>
                </div>
                <!-- System Health Card -->
                <div
                    class="bg-surface-container-lowest shadow-sm p-6 border rounded-2xl border-outline-variant">
                    <h4 class="mb-4 font-label-md text-label-md text-on-surface">Verification Health</h4>
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between mb-1 text-[12px]">
                                <span class="font-label-sm text-on-surface-variant">KYC Compliance</span>
                                <span class="font-label-sm text-primary">92%</span>
                            </div>
                            <div class="bg-surface-container-high rounded-full w-full h-2 overflow-hidden">
                                <div class="bg-primary rounded-full w-[92%] h-full"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-1 text-[12px]">
                                <span class="font-label-sm text-on-surface-variant">System Latency</span>
                                <span class="font-label-sm text-primary">24ms</span>
                            </div>
                            <div class="bg-surface-container-high rounded-full w-full h-2 overflow-hidden">
                                <div class="bg-secondary rounded-full w-[15%] h-full"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Activity Feed -->
                <div
                    class="bg-surface-container-lowest shadow-sm p-6 border rounded-2xl border-outline-variant">
                    <h4 class="mb-4 font-label-md text-label-md text-on-surface">Recent Activity</h4>
                    <div class="space-y-4">
                        <div class="flex gap-3">
                            <div class="bg-secondary mt-2 rounded-full w-2 h-2"></div>
                            <div>
                                <p class="font-body-sm text-body-sm text-on-surface"><span
                                        class="font-bold">System</span> automatically verified Buyer #9482</p>
                                <p class="text-[10px] text-on-surface-variant">2 mins ago</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="bg-primary mt-2 rounded-full w-2 h-2"></div>
                            <div>
                                <p class="font-body-sm text-body-sm text-on-surface"><span
                                        class="font-bold">Admin</span> created profile for Delta Energy</p>
                                <p class="text-[10px] text-on-surface-variant">1 hour ago</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="bg-amber-500 mt-2 rounded-full w-2 h-2"></div>
                            <div>
                                <p class="font-body-sm text-body-sm text-on-surface"><span
                                        class="font-bold">Warning:</span> Invoice #902 delayed</p>
                                <p class="text-[10px] text-on-surface-variant">3 hours ago</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
