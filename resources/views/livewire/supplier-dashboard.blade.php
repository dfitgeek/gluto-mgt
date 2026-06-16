<main class="min-h-screen">
        <!-- Main Dashboard Content -->
    <div class="mx-auto p-container-padding max-w-[1440px]">
        <div class="mb-stack-lg">
            <h2 class="font-headline-lg text-headline-lg text-primary">Dashboard Overview</h2>
            <p class="font-body-md text-body-md text-on-surface-variant">Real-time logistics and supply chain
                performance metrics.</p>
        </div>
        <!-- Summary Cards Bento Grid -->
        <section class="gap-gutter grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 mb-stack-lg">
            <div
                class="flex flex-col justify-between bg-surface-container-lowest soft-forest-shadow p-stack-md border rounded-2xl border-outline-variant">
                <div>
                    <p class="mb-1 font-label-md text-label-md text-on-surface-variant">Total Revenue</p>
                    <h3 class="font-headline-md text-headline-md text-primary">$128,450.00</h3>
                </div>
                <div class="flex items-center mt-4 font-bold text-secondary text-sm">
                    <span class="mr-1 text-sm material-symbols-outlined">trending_up</span>
                    +12.5% vs last month
                </div>
            </div>
            <div
                class="flex flex-col justify-between bg-surface-container-lowest soft-forest-shadow p-stack-md border rounded-2xl border-outline-variant">
                <div>
                    <p class="mb-1 font-label-md text-label-md text-on-surface-variant">Active Orders</p>
                    <h3 class="font-headline-md text-headline-md text-primary">42</h3>
                </div>
                <div class="flex items-center mt-4 font-bold text-on-primary-container text-sm">
                    <span class="mr-1 text-sm material-symbols-outlined">schedule</span>
                    8 processing now
                </div>
            </div>
            <div
                class="flex flex-col justify-between bg-surface-container-lowest soft-forest-shadow p-stack-md border rounded-2xl border-outline-variant">
                <div>
                    <p class="mb-1 font-label-md text-label-md text-on-surface-variant">Pending Shipments</p>
                    <h3 class="font-headline-md text-headline-md text-primary">15</h3>
                </div>
                <div class="flex items-center mt-4 font-bold text-on-surface-variant text-sm">
                    <span class="mr-1 text-sm material-symbols-outlined">inventory</span>
                    Awaiting carrier pickup
                </div>
            </div>
            <div
                class="flex flex-col justify-between bg-surface-container-lowest soft-forest-shadow p-stack-md border border-l-4 border-l-error rounded-2xl border-outline-variant">
                <div>
                    <p class="mb-1 font-label-md text-label-md text-on-surface-variant">Low Stock Alerts</p>
                    <h3 class="font-headline-md text-error text-headline-md">3 Items</h3>
                </div>
                <div class="flex items-center mt-4 font-bold text-error text-sm">
                    <span class="mr-1 text-sm material-symbols-outlined">warning</span>
                    Reorder recommended
                </div>
            </div>
        </section>
        <!-- Main Layout: Performance & Quick Actions -->
        <div class="gap-gutter grid grid-cols-1 lg:grid-cols-3 mb-stack-lg">
            <!-- Performance Overview -->
            <div
                class="lg:col-span-2 bg-surface-container-lowest soft-forest-shadow p-stack-md border rounded-2xl border-outline-variant">
                <div class="flex justify-between items-center mb-stack-md">
                    <h4 class="font-headline-md text-headline-md text-primary">Performance Overview</h4>
                    <select
                        class="bg-surface-container-low px-3 py-1 rounded-lg border-outline-variant font-label-md text-sm">
                        <option>Last 7 Days</option>
                        <option>Last 30 Days</option>
                        <option>Year to Date</option>
                    </select>
                </div>
                <div
                    class="relative flex justify-between items-end bg-surface-container-low p-4 rounded-xl w-full h-[300px] overflow-hidden">
                    <!-- Simulated Chart Grid -->
                    <div class="absolute inset-0 gap-4 grid grid-cols-7 opacity-10">
                        <div class="border-outline border-r h-full"></div>
                        <div class="border-outline border-r h-full"></div>
                        <div class="border-outline border-r h-full"></div>
                        <div class="border-outline border-r h-full"></div>
                        <div class="border-outline border-r h-full"></div>
                        <div class="border-outline border-r h-full"></div>
                    </div>
                    <!-- Simulated Chart Area (Using simple bars for visualization) -->
                    <div class="bg-primary hover:opacity-80 rounded-t-lg w-8 transition-all" style="height: 40%">
                    </div>
                    <div class="bg-primary hover:opacity-80 rounded-t-lg w-8 transition-all" style="height: 60%">
                    </div>
                    <div class="bg-secondary hover:opacity-80 rounded-t-lg w-8 transition-all" style="height: 45%">
                    </div>
                    <div class="bg-primary hover:opacity-80 rounded-t-lg w-8 transition-all" style="height: 75%">
                    </div>
                    <div class="bg-primary-container hover:opacity-80 rounded-t-lg w-8 transition-all"
                        style="height: 55%"></div>
                    <div class="bg-primary hover:opacity-80 rounded-t-lg w-8 transition-all" style="height: 85%">
                    </div>
                    <div class="bg-secondary hover:opacity-80 rounded-t-lg w-8 transition-all" style="height: 65%">
                    </div>
                </div>
                <div class="flex justify-between mt-4 px-2 font-label-sm text-on-surface-variant">
                    <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
                </div>
            </div>
            <!-- Quick Actions Grid -->
            <div
                class="bg-surface-container-lowest soft-forest-shadow p-stack-md border rounded-2xl border-outline-variant">
                <h4 class="mb-stack-md font-headline-md text-headline-md text-primary">Quick Actions</h4>
                <div class="gap-3 grid grid-cols-1">
                    <button
                        class="flex items-center gap-4 bg-primary hover:opacity-90 p-4 rounded-xl font-label-md text-white transition-all">
                        <span class="material-symbols-outlined">add_circle</span>
                        Add New Product
                    </button>
                    <button
                        class="bg-tertiary-fixed hover:bg-primary-fixed flex items-center gap-4 p-4 rounded-xl font-label-md text-primary transition-all">
                        <span class="material-symbols-outlined">sync_alt</span>
                        Update Inventory
                    </button>
                    <button
                        class="bg-tertiary-fixed hover:bg-primary-fixed flex items-center gap-4 p-4 rounded-xl font-label-md text-primary transition-all">
                        <span class="material-symbols-outlined">description</span>
                        Generate Report
                    </button>
                    <button
                        class="flex items-center gap-4 bg-surface-container-high hover:bg-surface-container-highest p-4 rounded-xl font-label-md text-on-surface transition-all">
                        <span class="material-symbols-outlined">support_agent</span>
                        Contact Support
                    </button>
                </div>
                <div class="mt-stack-md pt-stack-md border-t border-outline-variant">
                    <p class="mb-3 font-label-sm text-label-sm text-on-surface-variant uppercase">System Health</p>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-on-surface-variant">API Connection</span>
                        <span class="flex items-center gap-1 font-bold text-secondary">Stable <span
                                class="bg-secondary rounded-full w-2 h-2"></span></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Recent Orders Table -->
        <section
            class="bg-surface-container-lowest soft-forest-shadow border rounded-2xl border-outline-variant overflow-hidden">
            <div
                class="flex justify-between items-center bg-surface-container-low/50 p-stack-md border-b border-outline-variant">
                <h4 class="font-headline-md text-headline-md text-primary">Recent Orders</h4>
                <button class="font-label-md text-label-md text-secondary hover:underline">View All Orders</button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-surface-container-low border-b border-outline-variant">
                            <th class="px-stack-md py-4 font-label-md text-[12px] text-on-surface-variant uppercase">
                                Order ID</th>
                            <th class="px-stack-md py-4 font-label-md text-[12px] text-on-surface-variant uppercase">
                                Customer Name</th>
                            <th class="px-stack-md py-4 font-label-md text-[12px] text-on-surface-variant uppercase">
                                Date</th>
                            <th class="px-stack-md py-4 font-label-md text-[12px] text-on-surface-variant uppercase">
                                Amount</th>
                            <th class="px-stack-md py-4 font-label-md text-[12px] text-on-surface-variant uppercase">
                                Status</th>
                            <th class="px-stack-md py-4 font-label-md text-[12px] text-on-surface-variant uppercase">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-outline-variant divide-y">
                        <tr class="hover:bg-surface-container-low/30 transition-colors">
                            <td class="px-stack-md py-4 font-label-md">#LOG-8921</td>
                            <td class="px-stack-md py-4 font-body-sm">Northwood Lumber Ltd.</td>
                            <td class="px-stack-md py-4 font-body-sm">Oct 12, 2023</td>
                            <td class="px-stack-md py-4 font-label-md">$12,450.00</td>
                            <td class="px-stack-md py-4">
                                <span
                                    class="bg-secondary-container/30 px-3 py-1 rounded-full font-bold text-[10px] text-secondary uppercase">Shipped</span>
                            </td>
                            <td class="px-stack-md py-4">
                                <button class="p-1 hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined">visibility</span>
                                </button>
                            </td>
                        </tr>
                        <tr class="hover:bg-surface-container-low/30 transition-colors">
                            <td class="px-stack-md py-4 font-label-md">#LOG-8922</td>
                            <td class="px-stack-md py-4 font-body-sm">Skyline Builders</td>
                            <td class="px-stack-md py-4 font-body-sm">Oct 14, 2023</td>
                            <td class="px-stack-md py-4 font-label-md">$8,200.00</td>
                            <td class="px-stack-md py-4">
                                <span
                                    class="bg-primary-container/20 px-3 py-1 rounded-full font-bold text-[10px] text-on-primary-container uppercase">Processing</span>
                            </td>
                            <td class="px-stack-md py-4">
                                <button class="p-1 hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined">visibility</span>
                                </button>
                            </td>
                        </tr>
                        <tr class="hover:bg-surface-container-low/30 transition-colors">
                            <td class="px-stack-md py-4 font-label-md">#LOG-8923</td>
                            <td class="px-stack-md py-4 font-body-sm">Evergreen Partners</td>
                            <td class="px-stack-md py-4 font-body-sm">Oct 15, 2023</td>
                            <td class="px-stack-md py-4 font-label-md">$2,100.00</td>
                            <td class="px-stack-md py-4">
                                <span
                                    class="bg-error-container/30 px-3 py-1 rounded-full font-bold text-[10px] text-error uppercase">Delayed</span>
                            </td>
                            <td class="px-stack-md py-4">
                                <button class="p-1 hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined">visibility</span>
                                </button>
                            </td>
                        </tr>
                        <tr class="hover:bg-surface-container-low/30 transition-colors">
                            <td class="px-stack-md py-4 font-label-md">#LOG-8924</td>
                            <td class="px-stack-md py-4 font-body-sm">Coastal Developments</td>
                            <td class="px-stack-md py-4 font-body-sm">Oct 15, 2023</td>
                            <td class="px-stack-md py-4 font-label-md">$15,700.00</td>
                            <td class="px-stack-md py-4">
                                <span
                                    class="bg-secondary-container/30 px-3 py-1 rounded-full font-bold text-[10px] text-secondary uppercase">Shipped</span>
                            </td>
                            <td class="px-stack-md py-4">
                                <button class="p-1 hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined">visibility</span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
    <!-- Management Quick-Add FAB -->
    <button
        class="right-8 bottom-8 z-50 fixed flex justify-center items-center bg-primary level-3-shadow rounded-full w-14 h-14 text-white hover:scale-110 active:scale-95 transition-all">
        <span class="scale-125 material-symbols-outlined">add</span>
    </button>

    <script>
        // Micro-interaction for summary cards hover
        document.querySelectorAll('.soft-forest-shadow').forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-4px)';
                card.style.transition = 'all 0.3s ease';
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
            });
        });

        // Simple table filtering simulation or row highlight
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            row.addEventListener('click', () => {
                // Potential interaction: open order details
                console.log('Order clicked');
            });
        });
    </script>
</main>
