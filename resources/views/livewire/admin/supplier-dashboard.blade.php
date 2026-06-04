<!-- Main Content Area -->
<main class="flex flex-col min-h-screen">
    <!-- Page Canvas -->
    <section class="flex-1 mx-auto p-container-padding pb-stack-lg w-full max-w-[1440px]">

        <!-- Header Section -->
        <div class="mb-stack-lg">
            <h2 class="mb-1 font-headline-lg font-bold text-headline-lg text-primary">Supplier Overview</h2>
            <p class="font-body-md text-body-md text-on-surface-variant">Monitor and manage the vetting process for vendor logistics and inventory items catalogs.</p>
        </div>

        <!-- Bento Grid Metrics Matrix -->
        <div class="gap-gutter grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 mb-stack-lg">

            <!-- Metric 1: Unverified Card -->
            <div class="group relative bg-white shadow-sm hover:shadow-[0px_4px_20px_rgba(6,78,59,0.05)] p-6 border rounded-2xl border-outline-variant overflow-hidden transition-all">
                <div class="top-0 left-0 absolute bg-amber-500 w-1 h-full"></div>
                <div class="flex justify-between items-start mb-4">
                    <div class="bg-amber-50 p-3 rounded-xl text-amber-600">
                        <span class="material-symbols-outlined">pending</span>
                    </div>
                    <span class="bg-amber-50 px-2 py-1 rounded-full font-label-sm font-bold text-[10px] text-amber-600 uppercase tracking-wider">Attention</span>
                </div>
                <h3 class="mb-1 font-body-sm text-on-surface-variant text-xs">Unverified Suppliers</h3>
                <p class="font-headline-lg font-bold text-headline-lg text-on-background text-2xl">{{ number_format($unverifiedCount) }}</p>
            </div>

            <!-- Metric 2: Verified Card -->
            <div class="group relative bg-white shadow-sm hover:shadow-[0px_4px_20px_rgba(6,78,59,0.05)] p-6 border rounded-2xl border-outline-variant overflow-hidden transition-all">
                <div class="top-0 left-0 absolute bg-emerald-600 w-1 h-full"></div>
                <div class="flex justify-between items-start mb-4">
                    <div class="bg-emerald-50 p-3 rounded-xl text-emerald-600">
                        <span class="material-symbols-outlined">verified</span>
                    </div>
                    <span class="bg-emerald-50 px-2 py-1 rounded-full font-label-sm font-bold text-[10px] text-emerald-700 uppercase tracking-wider">Active</span>
                </div>
                <h3 class="mb-1 font-body-sm text-on-surface-variant text-xs">Total Verified</h3>
                <p class="font-headline-lg font-bold text-headline-lg text-on-background text-2xl">{{ number_format($verifiedCount) }}</p>
            </div>

            <!-- Metric 3: Products Catalog Card -->
            <div class="group relative bg-white shadow-sm hover:shadow-[0px_4px_20px_rgba(6,78,59,0.05)] p-6 border rounded-2xl border-outline-variant overflow-hidden transition-all">
                <div class="top-0 left-0 absolute bg-secondary w-1 h-full"></div>
                <div class="flex justify-between items-start mb-4">
                    <div class="bg-secondary-container/20 p-3 rounded-xl text-secondary">
                        <span class="material-symbols-outlined">inventory_2</span>
                    </div>
                    <span class="bg-secondary-container/20 px-2 py-1 rounded-full font-label-sm font-bold text-[10px] text-secondary uppercase tracking-wider">Inventory</span>
                </div>
                <h3 class="mb-1 font-body-sm text-on-surface-variant text-xs">Total Products</h3>
                <p class="font-headline-lg font-bold text-headline-lg text-on-background text-2xl">{{ number_format($totalProducts) }}</p>
            </div>

            <!-- Metric 4: Create Profile Card (Interactive Call to Action) -->
            <div class="group relative flex justify-between items-center bg-primary-container shadow-sm p-6 rounded-2xl overflow-hidden">
                <div class="z-10 relative">
                    <h3 class="mb-1 font-headline-md font-bold text-headline-md text-primary text-base">Onboard New Supplier</h3>
                    <p class="mb-4 max-w-[200px] font-body-sm text-on-primary-container text-xs leading-relaxed">Initiate the verification flow for new logistics partners.</p>
                    <a href="{{ route('admin.suppliers.create') }}" wire:navigate
                        class="flex items-center gap-2 bg-primary hover:bg-primary/95 px-4 py-2.5 rounded-xl w-fit font-label-md font-bold text-white text-xs transition-colors">
                        <span class="text-[18px] material-symbols-outlined">add_circle</span>
                        Begin Verification
                    </a>
                </div>
                <div class="top-[-10px] right-[-30px] absolute opacity-10 scale-125 pointer-events-none">
                    <span class="text-[18px] text-white material-symbols-outlined" style="font-size: 160px;">person_add</span>
                </div>
            </div>
        </div>

        <!-- Main Content Layout Section -->
        <div class="w-full">
            <!-- Recently Unverified Table Area (Full Width Layout) -->
            <div class="bg-white shadow-sm border rounded-2xl border-outline-variant w-full overflow-hidden">
                <div class="flex justify-between items-center px-6 py-5 border-b border-outline-variant">
                    <div>
                        <h3 class="font-headline-md font-bold text-headline-md text-primary text-base">Pending Verification</h3>
                        <p class="mt-0.5 font-body-sm text-on-surface-variant text-xs">Suppliers registered within the last 72 hours awaiting corporate document review</p>
                    </div>
                    <a href="{{ route('admin.suppliers.manage', ['statusFilter' => 'Unverified Supplier']) }}" wire:navigate
                       class="font-label-md font-bold text-secondary text-xs hover:underline cursor-pointer">
                        View All Pending
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-surface-container-low border-b border-outline-variant/40">
                            <tr>
                                <th class="px-6 py-3.5 font-label-sm font-bold text-on-surface-variant text-xs uppercase tracking-wider">Supplier Details</th>
                                <th class="px-6 py-3.5 font-label-sm font-bold text-on-surface-variant text-xs uppercase tracking-wider">Type of Business</th>
                                <th class="px-6 py-3.5 font-label-sm font-bold text-on-surface-variant text-xs uppercase tracking-wider">Ref Token / Code</th>
                                <th class="px-6 py-3.5 font-label-sm font-bold text-on-surface-variant text-xs text-right uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-outline-variant/30 divide-y text-sm">
                            @forelse($pendingSuppliers as $pending)
                                <tr wire:key="pending-row-{{ $pending->id }}" class="group hover:bg-surface-container-lowest transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex justify-center items-center bg-surface-container-high shadow-inner rounded-xl w-10 h-10 overflow-hidden font-body-md font-bold text-primary">
                                                @if($pending->company_icon_path)
                                                    <img src="{{ asset('storage/' . $pending->company_icon_path) }}" class="w-full h-full object-cover">
                                                @else
                                                    {{ strtoupper(substr($pending->company_name, 0, 1)) }}
                                                @endif
                                            </div>
                                            <div>
                                                <p class="font-label-md font-bold text-on-surface text-sm">{{ $pending->company_name }}</p>
                                                <p class="mt-0.5 font-body-sm text-[11px] text-on-surface-variant">{{ $pending->email_address }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-body-sm font-medium text-on-surface-variant">{{ $pending->type_of_business ?? 'Not Specified' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-block bg-surface-container-high px-2.5 py-1 rounded font-mono font-bold text-[11px] text-primary tracking-wide">
                                            {{ $pending->supplier_ref_number }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <!-- Navigates directly into the management panel where the details modal opens up instantly -->
                                        <a href="{{ route('admin.suppliers.manage', ['statusFilter' => 'Unverified Supplier']) }}" wire:navigate
                                            class="inline-flex bg-secondary-container/10 hover:bg-secondary-container/40 p-2 rounded-xl text-secondary transition-colors cursor-pointer">
                                            <span class="text-[20px] material-symbols-outlined">rate_review</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 font-body-sm text-on-surface-variant text-center italic">
                                        <span class="block mb-1 text-outline text-[36px] material-symbols-outlined">verified_user</span>
                                        No unverified suppliers have registered within the last 72 hours.
                                    </td>
                                {{-- endtr> --}}
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>
