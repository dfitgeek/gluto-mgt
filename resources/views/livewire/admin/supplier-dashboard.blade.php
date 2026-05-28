  <!-- Main Content Area -->
  <main class="flex flex-col min-h-screen">
    <!-- Top App Bar (Anchored from JSON) -->
    {{-- <header class="top-0 z-40 sticky bg-surface shadow-[0px_4px_20px_rgba(6,78,59,0.05)] h-20">
        <div class="flex justify-start md:justify-end items-center mx-auto px-container-padding w-full max-w-[1440px] h-full">
                <div
                    class="flex items-center bg-surface-container-low ml-10 px-4 py-2 border rounded-full border-outline-variant/30">
                    <span class="mr-2 text-on-surface-variant material-symbols-outlined">search</span>
                    <input class="bg-transparent border-none focus:ring-0 w-64 font-body-sm text-on-surface"
                        placeholder="Search suppliers or IDs..." type="text" />
                </div>

        </div>
    </header> --}}
    <!-- Page Canvas -->
    <section class="flex-1 mx-auto p-container-padding pb-stack-lg w-full max-w-[1440px]">
        <!-- Header Section -->
        <div class="mb-stack-lg">
            <h2 class="mb-1 font-headline-lg text-headline-lg text-primary">Supplier Overview</h2>
            <p class="font-body-md text-body-md text-on-surface-variant">Monitor and manage the vetting process for
                global vendor logistics.</p>
        </div>
        <!-- Bento Grid Metrics -->
        <div class="gap-gutter grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 mb-stack-lg">
            <!-- Unverified Card -->
            <div
                class="group relative bg-white shadow-sm hover:shadow-[0px_4px_20px_rgba(6,78,59,0.05)] p-6 border rounded-2xl border-outline-variant overflow-hidden transition-all">
                <div class="top-0 left-0 absolute bg-amber-500 w-1 h-full"></div>
                <div class="flex justify-between items-start mb-4">
                    <div class="bg-amber-50 p-3 rounded-xl text-amber-600">
                        <span class="material-symbols-outlined">pending</span>
                    </div>
                    <span
                        class="bg-amber-50 px-2 py-1 rounded-full font-label-sm font-bold text-[10px] text-amber-600 uppercase tracking-wider">Attention</span>
                </div>
                <h3 class="mb-1 font-body-sm text-on-surface-variant">Unverified Suppliers</h3>
                <p class="font-headline-lg text-headline-lg text-on-background">14</p>
                <div class="flex items-center gap-1 mt-4 text-error">
                    <span class="text-[16px] material-symbols-outlined">trending_up</span>
                    <span class="font-semibold text-[12px]">+3 this week</span>
                </div>
            </div>
            <!-- Verified Card -->
            <div
                class="group relative bg-white shadow-sm hover:shadow-[0px_4px_20px_rgba(6,78,59,0.05)] p-6 border rounded-2xl border-outline-variant overflow-hidden transition-all">
                <div class="top-0 left-0 absolute bg-secondary w-1 h-full"></div>
                <div class="flex justify-between items-start mb-4">
                    <div class="bg-secondary-container/20 p-3 rounded-xl text-secondary">
                        <span class="material-symbols-outlined">verified</span>
                    </div>
                    <span
                        class="bg-secondary-container/20 px-2 py-1 rounded-full font-label-sm font-bold text-[10px] text-secondary uppercase tracking-wider">Active</span>
                </div>
                <h3 class="mb-1 font-body-sm text-on-surface-variant">Total Verified</h3>
                <p class="font-headline-lg text-headline-lg text-on-background">1,284</p>
                <div class="flex items-center gap-1 mt-4 text-secondary">
                    <span class="text-[16px] material-symbols-outlined">trending_up</span>
                    <span class="font-semibold text-[12px]">+12% growth</span>
                </div>
            </div>
            <!-- Create Profile Card (Interactive) -->
            <div
                class="group relative flex justify-between items-center lg:col-span-2 bg-primary-container shadow-sm p-6 rounded-2xl overflow-hidden">
                <div class="z-10 relative">
                    <h3 class="text-primary-fixed mb-2 font-headline-md text-headline-md">Onboard New Supplier</h3>
                    <p class="mb-6 max-w-[280px] font-body-sm text-on-primary-container">Initiate the verification
                        flow for new logistics partners.</p>
                    <button
                        class="bg-primary-fixed flex items-center gap-2 hover:bg-white px-6 py-3 rounded-2xl font-label-md text-primary transition-colors">
                        <span class="material-symbols-outlined">add_circle</span>
                        Begin Verification
                    </button>
                </div>
                <div class="top-[-20px] right-[-40px] absolute opacity-10 scale-150 pointer-events-none">
                    <span class="text-[240px] text-white material-symbols-outlined">person_add</span>
                </div>
            </div>
        </div>
        <!-- Main Content Layout (Log Table & Insights) -->
        <div class="gap-gutter grid grid-cols-1 lg:grid-cols-3">
            <!-- Recently Unverified Table Area -->
            <div class="lg:col-span-2 bg-white shadow-sm border rounded-2xl border-outline-variant overflow-hidden">
                <div class="flex justify-between items-center px-6 py-5 border-b border-outline-variant">
                    <div>
                        <h3 class="font-headline-md text-headline-md text-primary">Pending Verification</h3>
                        <p class="font-body-sm text-on-surface-variant">Suppliers awaiting document review (last
                            48h)</p>
                    </div>
                    <button class="font-label-md text-secondary hover:underline">View All</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-surface-container-low">
                            <tr>
                                <th
                                    class="px-6 py-4 font-label-sm text-on-surface-variant uppercase tracking-wider">
                                    Supplier Name</th>
                                <th
                                    class="px-6 py-4 font-label-sm text-on-surface-variant uppercase tracking-wider">
                                    Region</th>
                                <th
                                    class="px-6 py-4 font-label-sm text-on-surface-variant uppercase tracking-wider">
                                    Risk Level</th>
                                <th
                                    class="px-6 py-4 font-label-sm text-on-surface-variant uppercase tracking-wider">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-outline-variant/30 divide-y">
                            <tr class="group hover:bg-surface-container-lowest transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex justify-center items-center bg-surface-container-high rounded-lg w-10 h-10 font-bold text-primary">
                                            N</div>
                                        <div>
                                            <p class="font-label-md text-on-surface">Nordic Logistics GmbH</p>
                                            <p class="font-body-sm text-[12px] text-on-surface-variant">ID: SUP-2910
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-body-sm text-on-surface-variant">Western Europe</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-block bg-amber-100 px-3 py-1 rounded-full font-bold text-[11px] text-amber-800 uppercase">Medium</span>
                                </td>
                                <td class="px-6 py-4">
                                    <button
                                        class="bg-secondary-container/20 hover:bg-secondary-container p-2 rounded-xl text-secondary transition-colors">
                                        <span class="material-symbols-outlined">rate_review</span>
                                    </button>
                                </td>
                            </tr>
                            <tr class="group hover:bg-surface-container-lowest transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex justify-center items-center bg-surface-container-high rounded-lg w-10 h-10 font-bold text-primary">
                                            A</div>
                                        <div>
                                            <p class="font-label-md text-on-surface">Atlas Global Port</p>
                                            <p class="font-body-sm text-[12px] text-on-surface-variant">ID: SUP-4402
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-body-sm text-on-surface-variant">East Asia</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-block bg-error-container px-3 py-1 rounded-full font-bold text-[11px] text-on-error-container uppercase">High</span>
                                </td>
                                <td class="px-6 py-4">
                                    <button
                                        class="bg-secondary-container/20 hover:bg-secondary-container p-2 rounded-xl text-secondary transition-colors">
                                        <span class="material-symbols-outlined">rate_review</span>
                                    </button>
                                </td>
                            </tr>
                            <tr class="group hover:bg-surface-container-lowest transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex justify-center items-center bg-surface-container-high rounded-lg w-10 h-10 font-bold text-primary">
                                            S</div>
                                        <div>
                                            <p class="font-label-md text-on-surface">Swift Road Carriers</p>
                                            <p class="font-body-sm text-[12px] text-on-surface-variant">ID: SUP-8812
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-body-sm text-on-surface-variant">North America</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-block bg-secondary-container/30 px-3 py-1 rounded-full font-bold text-[11px] text-on-secondary-container uppercase">Low</span>
                                </td>
                                <td class="px-6 py-4">
                                    <button
                                        class="bg-secondary-container/20 hover:bg-secondary-container p-2 rounded-xl text-secondary transition-colors">
                                        <span class="material-symbols-outlined">rate_review</span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Secondary Column: Geographical / Quick Info -->
            <div class="space-y-gutter">
                <!-- Map Preview Card -->
                <div class="bg-white shadow-sm p-6 border rounded-2xl border-outline-variant">
                    <h3 class="flex items-center gap-2 mb-4 font-label-md text-primary">
                        <span class="text-[20px] material-symbols-outlined">map</span>
                        Global Network
                    </h3>
                    <div class="relative bg-surface-container-high mb-4 rounded-xl w-full h-48 overflow-hidden">
                        <img class="opacity-80 w-full h-full object-cover"
                            data-alt="A stylized minimalist digital world map designed for a high-end corporate dashboard. The continents are rendered in a deep forest green color with glowing node connections between major logistics hubs. The oceans are a clean, light grey representing a modern light-mode interface. The overall lighting is soft and professional with a focus on geographic data visualization."
                            data-location="Berlin"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuA-WaFgjU-sAG2Ci824nbIqm1zwPi70ey55fxUEjh0GZydc9iwvH-MEXpGwEngbi2wDGHph2E4cENyjqBiRMpDwE4adzwUj8bUj_wg1EVn5yU2IzslQ-Hx9zwvutp6G6Z8XWs7EZnL-6dzqdr55h0W9kaDs9kFE8BWcPaBeLyeJYR2JL8LfGXtPFxnacbEdNZgVENwJ8CKwrHTpcHegkF2TQukQbJ3wo9L9NFKjlU-mxkZrpixfr1VVJW5ZjpPLt9dSplFPFBEnuQ" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center text-[13px]">
                            <span class="text-on-surface-variant">APAC Region</span>
                            <span class="font-bold text-secondary">42%</span>
                        </div>
                        <div class="bg-surface-container-high rounded-full w-full h-2 overflow-hidden">
                            <div class="bg-secondary h-full" style="width: 42%"></div>
                        </div>
                        <div class="flex justify-between items-center text-[13px]">
                            <span class="text-on-surface-variant">EMEA Region</span>
                            <span class="font-bold text-secondary">38%</span>
                        </div>
                        <div class="bg-surface-container-high rounded-full w-full h-2 overflow-hidden">
                            <div class="bg-secondary h-full" style="width: 38%"></div>
                        </div>
                    </div>
                </div>
                <!-- Notification Log -->
                <div class="bg-surface-container-lowest p-6 border rounded-2xl border-outline-variant">
                    <h3 class="mb-4 font-label-md text-primary">Recent Activity</h3>
                    <div class="space-y-4">
                        <div class="flex gap-3">
                            <div class="bg-secondary mt-2 rounded-full w-2 h-2 shrink-0"></div>
                            <div>
                                <p class="font-body-sm text-[13px] text-on-surface"><strong>Audit Passed:</strong>
                                    Zenith Maritime documentation verified by compliance.</p>
                                <p class="mt-1 text-[11px] text-on-surface-variant">2 hours ago</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="bg-amber-500 mt-2 rounded-full w-2 h-2 shrink-0"></div>
                            <div>
                                <p class="font-body-sm text-[13px] text-on-surface"><strong>Flagged:</strong> Global
                                    Express missing ISO 9001 certificate renewal.</p>
                                <p class="mt-1 text-[11px] text-on-surface-variant">5 hours ago</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
