<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Supplier Workspace Hub - Gluto Sourcing</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400;500;600&display=swap" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Geist:wght@400;600;700&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap"
        rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet" />

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
                        "body-md": ["16px", {
                            "lineHeight": "24px",
                            "fontWeight": "400"
                        }],
                        "label-md": ["14px", {
                            "lineHeight": "16px",
                            "fontWeight": "600"
                        }],
                        "label-sm": ["12px", {
                            "lineHeight": "14px",
                            "fontWeight": "500"
                        }],
                        "body-sm": ["14px", {
                            "lineHeight": "20px",
                            "fontWeight": "400"
                        }],
                        "headline-md": ["24px", {
                            "lineHeight": "32px",
                            "fontWeight": "600"
                        }],
                        "headline-lg": ["32px", {
                            "lineHeight": "40px",
                            "letterSpacing": "-0.02em",
                            "fontWeight": "600"
                        }],
                        "body-lg": ["18px", {
                            "lineHeight": "28px",
                            "fontWeight": "400"
                        }],
                        "headline-xl": ["40px", {
                            "lineHeight": "48px",
                            "letterSpacing": "-0.02em",
                            "fontWeight": "700"
                        }],
                        "headline-lg-mobile": ["28px", {
                            "lineHeight": "36px",
                            "fontWeight": "600"
                        }]
                    }
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        [x-cloak] {
            display: none !important;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex flex-col bg-background min-h-screen overflow-x-hidden font-body-md text-on-background">

    <div class="top-6 right-6 z-[100] fixed space-y-3 w-full max-w-sm pointer-events-none">
        @if (session()->has('success') || session()->has('message'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-4 scale-95"
                x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="flex justify-between items-start bg-white dark:bg-surface-dim shadow-[0px_4px_24px_rgba(0,0,0,0.06)] p-4 border-l-4 border-l-emerald-500 rounded-xl ring-1 ring-black/5 pointer-events-auto">
                <div class="flex items-start gap-3">
                    <span class="mt-0.5 text-[22px] text-emerald-600 material-symbols-outlined"
                        style="font-variation-settings: 'FILL' 1;">check_circle</span>
                    <div class="space-y-0.5">
                        <p class="font-label-md font-bold text-on-surface text-sm">Action Complete</p>
                        <p class="font-body-sm text-[13px] text-on-surface-variant leading-relaxed">
                            {{ session('success') ?? session('message') }}</p>
                    </div>
                </div>
                <button type="button" @click="show = false"
                    class="flex-shrink-0 hover:bg-surface-container-high p-1 rounded-lg text-on-surface-variant transition-colors cursor-pointer">
                    <span class="block text-[16px] material-symbols-outlined">close</span>
                </button>
            </div>
        @endif

        @if (session()->has('error') || session()->has('failure') || $errors->any())
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 7000)" x-show="show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-4 scale-95"
                x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="flex justify-between items-start bg-white dark:bg-surface-dim shadow-[0px_4px_24px_rgba(0,0,0,0.06)] p-4 border-l-4 border-l-error rounded-xl ring-1 ring-black/5 pointer-events-auto">
                <div class="flex items-start gap-3">
                    <span class="mt-0.5 text-[22px] text-error material-symbols-outlined"
                        style="font-variation-settings: 'FILL' 1;">error</span>
                    <div class="space-y-0.5">
                        <p class="font-label-md font-bold text-error text-sm">Attention Required</p>
                        <p class="font-body-sm text-[13px] text-on-surface-variant leading-relaxed">
                            {{ session('error') ?? (session('failure') ?? 'Form submission validation anomalies detected.') }}
                        </p>
                    </div>
                </div>
                <button type="button" @click="show = false"
                    class="flex-shrink-0 hover:bg-surface-container-high p-1 rounded-lg text-on-surface-variant transition-colors cursor-pointer">
                    <span class="block text-[16px] material-symbols-outlined">close</span>
                </button>
            </div>
        @endif
    </div>

    <header class="top-0 z-50 sticky bg-surface dark:bg-surface-dim shadow-[0px_4px_20px_rgba(6,78,59,0.05)] w-full">
        <div class="flex justify-between items-center mx-auto px-container-padding w-full h-20">
            <div class="flex items-center gap-4">
                <button
                    class="lg:hidden hover:bg-surface-container-high p-2 rounded-lg text-on-surface-variant material-symbols-outlined">
                    menu
                </button>
                <img src="{{ asset('images/logo.png') }}" alt="Gluto Logo" class="h-[35px] md:h-[50px]">
                <span
                    class="hidden sm:inline-block bg-primary/10 px-3 py-1 border rounded-lg font-bold text-[11px] text-primary uppercase tracking-wider">
                    Supplier Hub
                </span>
            </div>

            <div class="flex items-center gap-stack-md">
                <div class="flex items-center gap-3">
                    @if (auth('supplier')->check())
                        <div class="flex items-center gap-3">
                            <div class="hidden sm:block text-right">
                                <p
                                    class="max-w-[180px] font-label-md font-bold text-label-md text-on-surface text-sm truncate">
                                    {{ auth('supplier')->user()->company_name }}
                                </p>
                                <p
                                    class="mt-0.5 max-w-[180px] font-body-sm text-[11px] text-on-surface-variant/90 truncate">
                                    Rep: {{ auth('supplier')->user()->rep_legal_name }}
                                </p>
                            </div>

                            <div class="hidden md:flex flex-col justify-center items-end px-1">
                                @if (auth('supplier')->user()->status_label === 'Verified Supplier')
                                    <span
                                        class="inline-flex items-center gap-1 bg-emerald-50 px-2.5 py-0.5 border border-emerald-200/60 rounded-md font-bold text-[10px] text-emerald-700 uppercase tracking-wider select-none">
                                        <span class="bg-emerald-500 rounded-full w-1.5 h-1.5 animate-pulse"></span>
                                        Verified
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1 bg-amber-50 px-2.5 py-0.5 border border-amber-200/60 rounded-md font-bold text-[10px] text-amber-700 uppercase tracking-wider select-none">
                                        <span class="bg-amber-500 rounded-full w-1.5 h-1.5"></span>
                                        Unverified
                                    </span>
                                @endif
                            </div>

                            <img alt="Corporate Logo"
                                class="bg-white shadow-inner border-2 border-primary-fixed rounded-xl w-10 h-10 object-cover"
                                src="{{ auth('supplier')->user()->company_icon_path ? asset('storage/' . auth('supplier')->user()->company_icon_path) : 'https://www.w3schools.com/howto/img_avatar.png' }}" />
                        </div>
                    @endif

                    <div x-data="{ open: false }" class="relative" @click.outside="open = false">
                        <button type="button" @click="open = !open"
                            class="hover:bg-surface-container-high p-2 rounded-full text-on-surface-variant transition-colors duration-200 cursor-pointer select-none material-symbols-outlined"
                            :class="open ? 'bg-surface-container-high text-primary font-bold' : ''">
                            <span x-text="open ? 'close' : 'more_vert'">menu</span>
                        </button>

                        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                            class="right-0 z-50 absolute bg-white shadow-xl mt-2 py-1.5 border rounded-2xl border-outline-variant/60 w-56 overflow-hidden animate-fadeIn">

                            <div class="mb-1 px-4 py-2 border-b border-outline-variant/30">
                                <p class="font-bold text-[10px] text-on-surface-variant/80 uppercase tracking-wider">
                                    Account
                                    Settings</p>
                            </div>

                            <a href="{{ route('supplier.profile') }}" wire:navigate @click="open = false"
                                class="group flex items-center gap-3 hover:bg-surface-container-low px-4 py-2.5 font-semibold text-on-surface-variant hover:text-primary text-xs transition-colors">
                                <span
                                    class="text-outline text-[18px] group-hover:text-primary transition-colors material-symbols-outlined">manage_accounts</span>
                                <span>User Profile</span>
                            </a>
                            <a href="{{ route('supplier.profile.documents') }}" wire:navigate @click="open = false"
                                class="group flex items-center gap-3 hover:bg-surface-container-low px-4 py-2.5 font-semibold text-on-surface-variant hover:text-primary text-xs transition-colors">
                                <span
                                    class="text-outline text-[18px] group-hover:text-primary transition-colors material-symbols-outlined">description</span>
                                <span>Documents Library</span>
                            </a>

                            <div class="mt-1 pt-1 border-t border-outline-variant/20">
                                <form action="{{ route('supplier.logout') }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center gap-3 hover:bg-red-50 px-4 py-2.5 w-full font-semibold text-red-600 text-xs text-left transition-colors cursor-pointer">
                                        <span class="text-[18px] material-symbols-outlined">logout</span>
                                        <span>Sign Out</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="relative flex flex-1 items-stretch w-full">

        <aside
            class="hidden top-20 z-40 sticky lg:flex flex-col flex-shrink-0 bg-surface-container-lowest border-r border-outline-variant w-[280px] h-[calc(100vh-80px)] overflow-y-auto">
            <div class="flex items-center gap-2 my-6 px-6">
                <div class="flex justify-center items-center bg-primary-container rounded-lg w-10 h-10 text-white">
                    <span class="text-primary-fixed material-symbols-outlined"
                        style="font-variation-settings: 'FILL' 1;">shield_person</span>
                </div>
                <div>
                    <h2 class="font-headline-md font-bold text-headline-md text-primary text-base tracking-tight">
                        Vendor Terminal</h2>
                    <p class="font-bold text-[10px] text-on-surface-variant/70 uppercase tracking-wider">Ref:
                        {{ auth('supplier')->user()->supplier_ref_number }}</p>
                </div>
            </div>

            <nav class="flex-1 space-y-1 px-2">

                <a href="{{ route('supplier.dashboard') }}"
                    class="group flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('supplier.dashboard') ? 'bg-secondary-container text-on-secondary-container font-bold' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span class="font-label-md text-label-md">Overview Dashboard</span>
                </a>

                <a href="{{ route('supplier.products') }}"
                    class="group flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('supplier.products*') ? 'bg-secondary-container text-on-secondary-container font-bold' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
                    <span class="material-symbols-outlined">inventory_2</span>
                    <span class="font-label-md text-label-md">My Product Catalogue</span>
                </a>

                <a href="{{ route('supplier.profile.tracker') }}"
                    class="group flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('supplier.profile.tracker') ? 'bg-secondary-container text-on-secondary-container font-bold' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
                    <span class="material-symbols-outlined">inventory_2</span>
                    <span class="font-label-md text-label-md">Tracker Notes</span>
                </a>

                <a href="{{ route('supplier.product.create') }}"
                    class="group flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('supplier.product.create') ? 'bg-secondary-container text-on-secondary-container font-bold' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
                    <span class="material-symbols-outlined">create_new_folder</span>
                    <span class="font-label-md text-label-md">Create Product Catalogue
                    </span>
                </a>

                <a href="#"
                    class="group flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('supplier.invoices*') ? 'bg-secondary-container text-on-secondary-container font-bold' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
                    <span class="material-symbols-outlined">request_quote</span>
                    <span class="font-label-md text-label-md">Proforma & Billing</span>
                </a>
                <a href="#"
                    class="group flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('supplier.compliance*') ? 'bg-secondary-container text-on-secondary-container font-bold' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
                    <span class="material-symbols-outlined">verified_user</span>
                    <span class="font-label-md text-label-md">Compliance Status</span>
                </a>
            </nav>

            <div class="space-y-1 mt-auto p-4 border-background border-t">
                <form action="{{ route('supplier.logout') }}" method="POST"
                    class="group flex items-center gap-3 hover:bg-red-50/60 px-4 py-3 rounded-xl w-full text-red-600 transition-all">
                    @csrf
                    <span class="material-symbols-outlined">logout</span>
                    <button type="submit" class="font-label-md font-bold text-label-md text-xs cursor-pointer">Sign
                        Out Workspace</button>
                </form>
            </div>
        </aside>

        <main class="flex-1 p-gutter transition-all duration-200">
            {{ $slot }}
        </main>

    </div>
</body>

</html>
