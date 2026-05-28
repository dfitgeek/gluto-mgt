<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Gluto Management Admin Panel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Geist:wght@400;600;700&amp;family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Geist:wght@400;600;700&amp;display=swap"
            rel="stylesheet" />
        <!-- Material Symbols -->
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
            rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
            rel="stylesheet" />
        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <script id="tailwind-config">
            tailwind.config = {
                darkMode: "class",
                theme: {
                    extend: {
                        "colors": {
                            "on-secondary": "#ffffff",
                            "error": "#ba1a1a",
                            "background": "#f9f9ff",
                            "on-background": "#151c27",
                            "tertiary": "#22312c",
                            "secondary-fixed-dim": "#4edea3",
                            "surface-container-low": "#f0f3ff",
                            "on-error-container": "#93000a",
                            "on-secondary-fixed": "#002113",
                            "on-secondary-fixed-variant": "#005236",
                            "on-surface": "#151c27",
                            "tertiary-container": "#384742",
                            "surface-container-highest": "#dce2f3",
                            "error-container": "#ffdad6",
                            "outline": "#707974",
                            "on-tertiary-container": "#a4b5ae",
                            "surface-bright": "#f9f9ff",
                            "surface": "#f9f9ff",
                            "on-primary-container": "#80bea6",
                            "inverse-surface": "#2a313d",
                            "surface-container-high": "#e2e8f8",
                            "on-secondary-container": "#00714d",
                            "outline-variant": "#bfc9c3",
                            "on-primary-fixed": "#002117",
                            "on-tertiary": "#ffffff",
                            "secondary": "#006c49",
                            "on-primary-fixed-variant": "#0b513d",
                            "secondary-container": "#6cf8bb",
                            "primary": "#003527",
                            "surface-dim": "#d3daea",
                            "on-tertiary-fixed": "#101e1a",
                            "primary-fixed": "#b0f0d6",
                            "primary-container": "#064e3b",
                            "surface-container-lowest": "#ffffff",
                            "on-error": "#ffffff",
                            "inverse-primary": "#95d3ba",
                            "on-primary": "#ffffff",
                            "surface-tint": "#2b6954",
                            "surface-container": "#e7eefe",
                            "tertiary-fixed-dim": "#bacac3",
                            "secondary-fixed": "#6ffbbe",
                            "inverse-on-surface": "#ebf1ff",
                            "on-tertiary-fixed-variant": "#3b4a44",
                            "on-surface-variant": "#404944",
                            "primary-fixed-dim": "#95d3ba",
                            "surface-variant": "#dce2f3",
                            "tertiary-fixed": "#d5e6df"
                        },
                        "borderRadius": {
                            "DEFAULT": "0.25rem",
                            "lg": "0.5rem",
                            "xl": "12px",
                            "2xl": "16px",
                            "full": "9999px"
                        },
                        "spacing": {
                            "gutter": "24px",
                            "stack-lg": "48px",
                            "base": "8px",
                            "stack-sm": "12px",
                            "container-padding": "32px",
                            "stack-md": "24px"
                        },
                        "fontFamily": {
                            "body-md": ["Inter"],
                            "label-md": ["Geist"],
                            "label-sm": ["Geist"],
                            "body-sm": ["Inter"],
                            "headline-md": ["Geist"],
                            "headline-lg": ["Geist"],
                            "body-lg": ["Inter"],
                            "headline-xl": ["Geist"],
                            "headline-lg-mobile": ["Geist"]
                        },
                        "fontSize": {
                            "body-md": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                            "label-md": ["14px", { "lineHeight": "16px", "fontWeight": "600" }],
                            "label-sm": ["12px", { "lineHeight": "14px", "fontWeight": "500" }],
                            "body-sm": ["14px", { "lineHeight": "20px", "fontWeight": "400" }],
                            "headline-md": ["24px", { "lineHeight": "32px", "fontWeight": "600" }],
                            "headline-lg": ["32px", { "lineHeight": "40px", "letterSpacing": "-0.02em", "fontWeight": "600" }],
                            "body-lg": ["18px", { "lineHeight": "28px", "fontWeight": "400" }],
                            "headline-xl": ["40px", { "lineHeight": "48px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                            "headline-lg-mobile": ["28px", { "lineHeight": "36px", "fontWeight": "600" }]
                        }
                    },
                },
            }
        </script>
        <style>
            .material-symbols-outlined {
                font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            }

            .perspective-lg {
                perspective: 1000px;
            }

            .card-inner {
                transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
            }

            .glass-effect {
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
            }
        </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="{ sidebarOpen: true }"
    class="flex flex-col bg-background min-h-screen overflow-x-hidden font-body-md text-on-background">

    <!-- 1. MAIN HEADER: Always spans full width on desktop -->
    <header class="top-0 z-50 sticky bg-surface dark:bg-surface-dim shadow-[0px_4px_20px_rgba(6,78,59,0.05)] w-full">
        <div class="flex justify-between items-center mx-auto px-container-padding w-full h-20">
            <div class="flex items-center gap-4">
                <!-- Alpine Toggle Button: Only displays if an admin management portal is active -->
                @if(request()->routeIs('admin.suppliers*') || request()->routeIs('admin.buyers*'))
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="hover:bg-surface-container-high p-2 rounded-lg text-on-surface-variant material-symbols-outlined">
                        menu
                    </button>
                @endif
                {{-- <span class="dark:text-primary-fixed font-headline-md font-bold text-headline-md text-primary">GLUTO
                    Logs</span> --}}
                <img src="{{ asset('images/logo.png') }}" alt="Gluto Logo" class="h-[35px] md:h-[50px]">
            </div>

            <div class="flex items-center gap-stack-md">
                <div class="hidden md:flex items-center gap-6">
                    {{-- <span
                        class="hover:bg-surface-container-high px-3 py-1 rounded-lg font-body-md text-on-surface-variant transition-colors duration-200 cursor-pointer">Directory</span>
                    <span
                        class="hover:bg-surface-container-high px-3 py-1 rounded-lg font-body-md text-on-surface-variant transition-colors duration-200 cursor-pointer">Activity</span> --}}
                </div>
                <div class="flex items-center gap-3">
                    <button
                        class="hover:bg-surface-container-high p-2 rounded-full text-on-surface-variant active:scale-95 transition-colors cursor-pointer material-symbols-outlined"
                        data-icon="notifications">notifications</button>
                    <button
                        class="hover:bg-surface-container-high p-2 rounded-full text-on-surface-variant active:scale-95 transition-colors cursor-pointer material-symbols-outlined"
                        data-icon="settings">settings</button>
                        <div class="flex items-center gap-3">
                            <div class="hidden sm:block text-right">
                                <p class="font-label-md text-label-md text-on-surface">Admin User</p>
                                <p class="font-body-sm text-[12px] text-on-surface-variant">Super Admin</p>
                            </div>
                            <img alt="Administrator profile avatar" class="border-2 border-primary-fixed rounded-full w-10 h-10 cursor-pointer"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDAuDUHFMNN4roQWJFXXW-F4__LdLTzqc3zcw-jy26g_9uBEk1c5PB6cf79QYrPzInL-O-rqiO9qm8Rm46AaJQ-aGuOp1OAquCDsbL_y-wV6vkF6SwGRswwo6Bp4erx7-DO35x0eYygZSmqdJ4ia-f3hnx1acjxDKLINkH_dOpkYK8-ukA9ETWsPE6qiUBb4vFi1lDdTyr_edOS3HQk5PevSFPrFK2WlEtubAwSsIHFfaQ6cpNcG6ElBqk-DlAk5C1ncIO9WuZ0xg" />  </div>
                </div>
            </div>
        </div>
    </header>

    <!-- 2. WRAPPER CONTAINER: Controls sidebars and dynamic page offsets -->
    <div class="relative flex flex-1 items-stretch w-full">

        {{-- Supplier Portal Sidebar Navigation Area[cite: 1, 3] --}}
        @if(request()->routeIs('admin.suppliers*'))
            <aside x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                class="top-20 z-40 sticky flex flex-col flex-shrink-0 bg-surface-container-lowest py-stack-md border-r border-outline-variant w-[280px] h-[calc(100vh-80px)] overflow-y-auto">

                <div class="flex items-center gap-2 mb-stack-lg px-6">
                    <div class="flex justify-center items-center bg-primary-container rounded-lg w-10 h-10">
                        <span class="text-primary-fixed material-symbols-outlined"
                            style="font-variation-settings: 'FILL' 1;">analytics</span>
                    </div>
                    <div>
                        <h2 class="font-headline-md text-headline-md text-primary text-lg md:text-xl tracking-tight">Supplier Management</h2>
                        <p class="font-body-sm text-body-sm text-on-surface-variant text-sm md:text-base">Enterprise Portal</p>
                    </div>
                </div>
                <nav class="flex-1 space-y-1">
                    <a class="group flex items-center gap-3 bg-secondary-container mx-2 my-1 px-4 py-3 rounded-lg font-semibold text-on-secondary-container transition-all"
                        href="#">
                        <span class="material-symbols-outlined active-nav-indicator">dashboard</span>
                        <span class="font-label-md text-label-md">Dashboard</span>
                    </a>
                    <a class="group flex items-center gap-3 hover:bg-surface-container-high mx-2 my-1 px-4 py-3 rounded-lg text-on-surface-variant transition-all"
                        href="#">
                        <span class="material-symbols-outlined">pending_actions</span>
                        <span class="font-label-md text-label-md">Unverified Supplier</span>
                    </a>
                    <a class="group flex items-center gap-3 hover:bg-surface-container-high mx-2 my-1 px-4 py-3 rounded-lg text-on-surface-variant transition-all"
                        href="#">
                        <span class="material-symbols-outlined">done_all</span>
                        <span class="font-label-md text-label-md">Verified Suppliers</span>
                    </a>
                    <a class="group flex items-center gap-3 hover:bg-surface-container-high mx-2 my-1 px-4 py-3 rounded-lg text-on-surface-variant transition-all"
                        href="#">
                        <span class="material-symbols-outlined">person_add</span>
                        <span class="font-label-md text-label-md">Create Supplier</span>
                    </a>
                    <div class="px-6 pt-stack-md">
                        <div class="opacity-30 bg-outline-variant h-px"></div>
                    </div>
                    <a class="group flex items-center gap-3 hover:bg-surface-container-high mx-2 my-1 px-4 py-3 rounded-lg text-on-surface-variant transition-all"
                        href="#">
                        <span class="material-symbols-outlined">shopping_cart</span>
                        <span class="font-label-md text-label-md">Orders</span>
                    </a>
                    <a class="group flex items-center gap-3 hover:bg-surface-container-high mx-2 my-1 px-4 py-3 rounded-lg text-on-surface-variant transition-all"
                        href="#">
                        <span class="material-symbols-outlined">receipt_long</span>
                        <span class="font-label-md text-label-md">Invoices</span>
                    </a>
                </nav>
                <div class="space-y-1 mt-auto px-4">
                    <a href="{{ route('admin.buyers') }}" wire:navigate
                        class="flex justify-center items-center gap-2 bg-primary hover:bg-primary-container shadow-sm mb-stack-sm px-4 py-3 rounded-2xl w-full font-label-md text-white transition-colors">
                        <span class="text-[20px] material-symbols-outlined">swap_horiz</span>Switch to Buyer
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="group flex items-center gap-3 hover:bg-surface-container-high my-1 px-4 py-3 rounded-lg text-on-surface-variant transition-all">
                        @csrf
                        <span class="material-symbols-outlined">logout</span>
                        <button type="submit" class="font-label-md text-label-md">Logout</button>
                    </form>
                </div>
            </aside>
        @endif

        {{-- Buyer Portal Sidebar Navigation Area[cite: 1, 3] --}}
        @if(request()->routeIs('admin.buyers*'))
            <aside x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                class="top-20 z-40 sticky flex flex-col flex-shrink-0 bg-surface-container-lowest py-stack-md border-r border-outline-variant w-[280px] h-[calc(100vh-80px)] overflow-y-auto">

                <div class="mb-8 px-6">
                    <div class="flex items-center gap-3">
                        <div class="flex justify-center items-center bg-primary-container rounded-lg w-10 h-10">
                            <span class="text-primary-fixed material-symbols-outlined"
                                style="font-variation-settings: 'FILL' 1;">analytics</span>
                        </div>
                        <div>
                            <h1 class="font-headline-md text-headline-md text-primary text-lg md:text-xl tracking-tight">Buyer Management</h1>
                            <p class="opacity-70 font-body-sm text-body-sm text-on-surface-variant text-sm md:text-base">Enterprise Portal</p>
                        </div>
                    </div>
                </div>
                <nav class="flex-1 space-y-1 px-2">
                    <a class="group flex items-center gap-3 bg-secondary-container mx-2 my-1 px-4 py-3 rounded-lg font-semibold text-on-secondary-container transition-all"
                        href="#">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">dashboard</span>
                        <span class="font-label-md text-label-md">Dashboard</span>
                    </a>
                    <a class="group flex items-center gap-3 hover:bg-surface-container-high mx-2 my-1 px-4 py-3 rounded-lg text-on-surface-variant transition-all"
                        href="#">
                        <span class="material-symbols-outlined">pending_actions</span>
                        <span class="font-label-md text-label-md">Unprocessed Buyer</span>
                    </a>
                    <a class="group flex items-center gap-3 hover:bg-surface-container-high mx-2 my-1 px-4 py-3 rounded-lg text-on-surface-variant transition-all"
                        href="#">
                        <span class="material-symbols-outlined">done_all</span>
                        <span class="font-label-md text-label-md">Processed Buyer</span>
                    </a>
                </nav>
                <div class="space-y-1 mt-auto px-4">
                    <a href="{{ route('admin.suppliers') }}" wire:navigate
                        class="flex justify-center items-center gap-2 bg-primary hover:bg-primary-container shadow-sm mb-stack-sm px-4 py-3 rounded-2xl w-full font-label-md text-white transition-colors">
                        <span class="text-[20px] material-symbols-outlined">swap_horiz</span>Switch to Supplier
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="group flex items-center gap-3 hover:bg-surface-container-high my-1 px-4 py-3 rounded-lg text-on-surface-variant transition-all">
                        @csrf
                        <span class="material-symbols-outlined">logout</span>
                        <button type="submit" class="font-label-md text-label-md">Logout</button>
                    </form>

                </div>
            </aside>
        @endif

        <!-- 3. CONTENT AREA: Auto-calculates flex-margins based on active sidebars -->
        <main class="flex-1 p-6 transition-all duration-200">
            {{ $slot }}
        </main>

    </div>

    <!-- Floating Action Button -->
    <button
        class="right-8 bottom-8 z-50 fixed flex justify-center items-center bg-primary shadow-[0px_10px_32px_rgba(0,0,0,0.08)] rounded-full w-14 h-14 text-white hover:scale-110 active:scale-95 transition-transform">
        <span class="text-[32px] material-symbols-outlined">add</span>
    </button>

    <!-- Simple Interactivity for Navigation -->
    <script>
        document.querySelectorAll('nav a').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                document.querySelectorAll('nav a').forEach(l => {
                    l.classList.remove('bg-secondary-container', 'text-on-secondary-container', 'font-semibold');
                    l.classList.add('text-on-surface-variant', 'hover:bg-surface-container-high');
                    l.querySelector('.material-symbols-outlined').classList.remove('active-nav-indicator');
                });
                link.classList.add('bg-secondary-container', 'text-on-secondary-container', 'font-semibold');
                link.classList.remove('text-on-surface-variant', 'hover:bg-surface-container-high');
                link.querySelector('.material-symbols-outlined').classList.add('active-nav-indicator');
            });
        });
    </script>
</body>

</html>
