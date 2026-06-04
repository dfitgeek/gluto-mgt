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
        href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css"     rel="stylesheet" />
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

            [x-cloak] { display: none !important; }
        </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-background font-body-md text-on-background flex min-h-screen flex-col overflow-x-hidden">

    <div class="pointer-events-none fixed right-6 top-6 z-[100] w-full max-w-sm space-y-3">

        @if (session()->has('success') || session()->has('message'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-4 scale-95"
                x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="bg-surface dark:bg-surface-dim pointer-events-auto flex items-start justify-between rounded-xl border-l-4 border-l-emerald-500 p-4 shadow-[0px_4px_24px_rgba(0,0,0,0.06)] ring-1 ring-black/5">

                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined mt-0.5 text-[22px] text-emerald-600">check_circle</span>
                    <div class="space-y-0.5">
                        <p class="font-label-md text-on-surface text-sm font-bold">Action Complete</p>
                        <p class="font-body-sm text-on-surface-variant text-[13px] leading-relaxed">
                            {{ session('success') ?? session('message') }}</p>
                    </div>
                </div>

                <button type="button" @click="show = false"
                    class="hover:bg-surface-container-high text-on-surface-variant ml-3 flex-shrink-0 cursor-pointer rounded-lg p-1 transition-colors">
                    <span class="material-symbols-outlined block text-[16px]">close</span>
                </button>
            </div>
        @endif

        @if (session()->has('error') || session()->has('failure'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 7000)" x-show="show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-4 scale-95"
                x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="bg-surface dark:bg-surface-dim border-l-error pointer-events-auto flex items-start justify-between rounded-xl border-l-4 p-4 shadow-[0px_4px_24px_rgba(0,0,0,0.06)] ring-1 ring-black/5">

                <div class="flex items-start gap-3">
                    <span class="text-error material-symbols-outlined mt-0.5 text-[22px]">error</span>
                    <div class="space-y-0.5">
                        <p class="font-label-md text-error text-sm font-bold">Execution Blocked</p>
                        <p class="font-body-sm text-on-surface-variant text-[13px] leading-relaxed">
                            {{ session('error') ?? session('failure') }}</p>
                    </div>
                </div>

                <button type="button" @click="show = false"
                    class="hover:bg-surface-container-high text-on-surface-variant ml-3 flex-shrink-0 cursor-pointer rounded-lg p-1 transition-colors">
                    <span class="material-symbols-outlined block text-[16px]">close</span>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-4 scale-95"
                x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="bg-surface dark:bg-surface-dim pointer-events-auto flex w-full flex-col rounded-xl border-l-4 border-l-amber-500 p-4 shadow-[0px_4px_24px_rgba(0,0,0,0.06)] ring-1 ring-black/5">

                <div class="mb-2 flex w-full items-start justify-between">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[22px] text-amber-600">warning</span>
                        <p class="font-label-md text-on-surface text-sm font-bold">Validation Issues ({{ $errors->count() }})
                        </p>
                    </div>
                    <button type="button" @click="show = false"
                        class="hover:bg-surface-container-high text-on-surface-variant flex-shrink-0 cursor-pointer rounded-lg p-1 transition-colors">
                        <span class="material-symbols-outlined block text-[16px]">close</span>
                    </button>
                </div>

                <ul
                    class="border-outline-variant/30 text-on-surface-variant/90 hide-scrollbar max-h-48 list-inside list-disc space-y-1 overflow-y-auto border-t pl-1 pt-2 text-[12px]">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        </div>

    <header class="bg-surface dark:bg-surface-dim sticky top-0 z-50 w-full shadow-[0px_4px_20px_rgba(6,78,59,0.05)]">
        <div class="px-container-padding mx-auto flex h-20 w-full items-center justify-between">
            <div class="flex items-center gap-4">

                @if(request()->routeIs('admin.suppliers*') || request()->routeIs('admin.buyers*'))
                    <a href="{{ request()->fullUrlWithQuery(['sidebar' => request()->query('sidebar', 'open') === 'open' ? 'closed' : 'open']) }}"
                        wire:navigate
                        class="hover:bg-surface-container-high text-on-surface-variant material-symbols-outlined rounded-lg p-2">
                        menu
                    </a>
                @endif
                <img src="{{ asset('images/logo.png') }}" alt="Gluto Logo" class="h-[35px] md:h-[50px]">
            </div>

            <div class="gap-stack-md flex items-center">
                <div class="flex items-center gap-3">

                    

                    {{-- <button
                        class="hover:bg-surface-container-high text-on-surface-variant material-symbols-outlined cursor-pointer rounded-full p-2">notifications</button> --}}
                    <button
                        {{-- class="hover:bg-surface-container-high text-on-surface-variant material-symbols-outlined cursor-pointer rounded-full p-2"></button> --}}

                    <div class="flex items-center gap-3">
                        <div class="hidden text-right sm:block">
                            <p class="font-label-md text-label-md text-on-surface text-sm font-bold capitalize">
                                {{ $layoutUser->username }}</p>
                            <p class="font-body-sm text-on-surface-variant mt-0.5 text-[11px] capitalize">
                                {{ $layoutUser->usertype }}</p>
                        </div>
                        <img alt="Profile avatar" class="border-primary-fixed h-10 w-10 rounded-full border-2 object-cover"
                            src="https://www.w3schools.com/howto/img_avatar.png" />
                    </div>
                    <div x-data="{ open: false }" class="relative" @click.outside="open = false">

                        <button type="button" @click="open = !open"
                            class="hover:bg-surface-container-high text-on-surface-variant material-symbols-outlined cursor-pointer select-none rounded-full p-2 transition-colors duration-200"
                            :class="open ? 'bg-surface-container-high text-primary font-bold' : ''">
                            <span x-text="open ? 'close' : 'menu'">menu</span>
                        </button>

                        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                            class="border-outline-variant/60 animate-fadeIn absolute right-0 z-50 mt-2 w-56 overflow-hidden rounded-2xl border bg-white py-1.5 shadow-xl">

                            <div class="border-outline-variant/30 mb-1 border-b px-4 py-2">
                                <p class="text-on-surface-variant/80 text-[10px] font-bold uppercase tracking-wider">Admin Core
                                    Utilities</p>
                            </div>

                            <a href="{{ route('admin.suppliers.manage') }}" wire:navigate @click="open = false"
                    class="hover:bg-surface-container-low text-on-surface-variant hover:text-primary group flex items-center gap-3 px-4 py-2.5 text-xs font-semibold transition-colors">
                    <span class="text-outline group-hover:text-primary material-symbols-outlined text-[18px] transition-colors">admin_panel_settings</span>
                    <span>Manage Admins</span>
                </a>
                            

                            <a href="{{ route('admin.onboarding.tokens') }}" wire:navigate @click="open = false"
                                class="hover:bg-surface-container-low text-on-surface-variant hover:text-primary group flex items-center gap-3 px-4 py-2.5 text-xs font-semibold transition-colors">
                                <span
                                    class="text-outline group-hover:text-primary material-symbols-outlined text-[18px] transition-colors">vpn_key</span>
                                <span>Manage Tokens</span>
                            </a>

                            <a href="" wire:navigate @click="open = false"
                                class="hover:bg-surface-container-low text-on-surface-variant hover:text-primary group flex items-center gap-3 px-4 py-2.5 text-xs font-semibold transition-colors">
                                <span
                                    class="text-outline group-hover:text-primary material-symbols-outlined text-[18px] transition-colors">person_add</span>
                                <span>Create a New Admin</span>
                            </a>
                            <a href="" wire:navigate @click="open = false"
                                class="hover:bg-surface-container-low text-on-surface-variant hover:text-primary group flex items-center gap-3 px-4 py-2.5 text-xs font-semibold transition-colors">
                                <span
                                    class="text-outline group-hover:text-primary material-symbols-outlined text-[18px] transition-colors">settings</span>
                                <span>Settings</span>
                            </a>
                        </div>
                    </div>

                </div>      </div>
        </div>
    </header>

    <div class="relative flex w-full flex-1 items-stretch">

        {{-- Supplier Portal Sidebar --}}
        @if(request()->routeIs('admin.suppliers*') && request()->query('sidebar', 'open') === 'open')
            <aside
                class="bg-surface-container-lowest py-stack-md border-outline-variant sticky top-20 z-40 flex h-[calc(100vh-80px)] w-[280px] flex-shrink-0 flex-col overflow-y-auto border-r">
                <div class="mb-stack-lg flex items-center gap-2 px-6">
                    <div class="bg-primary-container flex h-10 w-10 items-center justify-center rounded-lg">
                        <span class="text-primary-fixed material-symbols-outlined"
                            style="font-variation-settings: 'FILL' 1;">analytics</span>
                    </div>
                    <div>
                        <h2 class="font-headline-md text-headline-md text-primary text-lg tracking-tight">Supplier
                            Management</h2>
                    </div>
                </div>

                <nav class="flex-1 space-y-1">
                    <a href="{{ route('admin.suppliers', ['sidebar' => request()->query('sidebar', 'open')]) }}"

                        class="group flex items-center gap-3 mx-2 my-1 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.suppliers') ? 'bg-secondary-container text-on-secondary-container font-semibold' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
                        <span class="material-symbols-outlined">dashboard</span>
                        <span class="font-label-md text-label-md">Dashboard</span>
                    </a>
                    <a href="{{ route('admin.suppliers.manage', ['sidebar' => request()->query('sidebar', 'open')]) }}"

                        class="group flex items-center gap-3 mx-2 my-1 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.suppliers.manage') ? 'bg-secondary-container text-on-secondary-container font-semibold' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
                        <span class="material-symbols-outlined">done_all</span>
                        <span class="font-label-md text-label-md">Manage Suppliers</span>
                    </a>


                    <a href="{{ route('admin.suppliers.create', ['sidebar' => request()->query('sidebar', 'open')]) }}"

                        class="group flex items-center gap-3 mx-2 my-1 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.suppliers.create') ? 'bg-secondary-container text-on-secondary-container font-semibold' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
                        <span class="material-symbols-outlined">add</span>
                        <span class="font-label-md text-label-md">Create Supplier</span>
                    </a>


                </nav>

                <div class="mt-auto space-y-1 px-4 pb-4">
                    <a href="{{ route('admin.buyers') }}" wire:navigate
                    class="bg-primary hover:bg-primary-container mb-stack-sm font-label-md flex w-full items-center justify-center gap-2 rounded-2xl px-4 py-3 text-white shadow-sm transition-colors">
                    <span class="material-symbols-outlined text-[20px]">swap_horiz</span>Switch to Buyer
                </a>
                    <form action="{{ route('logout') }}" method="POST"
                        class="hover:bg-surface-container-high text-on-surface-variant group my-1 flex items-center gap-3 rounded-lg px-4 py-3 transition-all">
                        @csrf
                        <span class="material-symbols-outlined">logout</span>
                        <button type="submit" class="font-label-md text-label-md">Logout</button>
                    </form>
                </div>
            </aside>
        @endif

        @if(request()->routeIs('admin.buyers*') && request()->query('sidebar', 'open') === 'open')
            <aside  x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                class="bg-surface-container-lowest py-stack-md border-outline-variant sticky top-20 z-40 flex h-[calc(100vh-80px)] w-[280px] flex-shrink-0 flex-col overflow-y-auto border-r">

                <div class="mb-8 px-6">
                    <div class="flex items-center gap-3">
                        <div class="bg-primary-container flex h-10 w-10 items-center justify-center rounded-lg">
                            <span class="text-primary-fixed material-symbols-outlined"
                                style="font-variation-settings: 'FILL' 1;">analytics</span>
                        </div>
                        <div>
                            <h1 class="font-headline-md text-headline-md text-primary text-lg tracking-tight md:text-xl">
                                Buyer Management</h1>
                            <p class="font-body-sm text-body-sm text-on-surface-variant text-sm opacity-70 md:text-base">
                                Enterprise Portal</p>
                        </div>
                    </div>
                </div>

                <nav class="flex-1 space-y-1 px-2">
                    <a class="group flex items-center gap-3 mx-2 my-1 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.buyers') ? 'bg-secondary-container text-on-secondary-container font-semibold' : 'text-on-surface-variant hover:bg-surface-container-high' }} " href="{{ route('admin.buyers') }}"">

                        <span class="material-symbols-outlined">dashboard</span>
                        <span class="font-label-md text-label-md">Dashboard</span>
                    </a>
                    <a class="group flex items-center gap-3 mx-2 my-1 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.buyers.manage') ? 'bg-secondary-container text-on-secondary-container font-semibold' : 'text-on-surface-variant hover:bg-surface-container-high' }} "
                        href="{{ route('admin.buyers.manage') }}"">
                        <span class="material-symbols-outlined">done_all</span>
                        <span class="font-label-md text-label-md">Manage Buyers</span>
                    </a>
                    <a class="group flex items-center gap-3 mx-2 my-1 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.buyers.create') ? 'bg-secondary-container text-on-secondary-container font-semibold' : 'text-on-surface-variant hover:bg-surface-container-high' }} "
                        href="{{ route('admin.buyers.create') }}"">
                        <span class="material-symbols-outlined">shopping_cart</span>
                        <span class="font-label-md text-label-md">Create Buyer Profile</span>
                    </a>

                    <a class="hover:bg-surface-container-high text-on-surface-variant group mx-2 my-1 flex items-center gap-3 rounded-lg px-4 py-3 transition-all"
                        href="#">
                        <span class="material-symbols-outlined">shopping_cart</span>
                        <span class="font-label-md text-label-md">Orders</span>
                    </a>

                    <a class="hover:bg-surface-container-high text-on-surface-variant group mx-2 my-1 flex items-center gap-3 rounded-lg px-4 py-3 transition-all"
                        href="#">
                        <span class="material-symbols-outlined">receipt_long</span>
                        <span class="font-label-md text-label-md">Invoices</span>
                    </a>
                </nav>

                <div class="mt-auto space-y-1 px-4">
                    <a href="{{ route('admin.suppliers') }}" wire:navigate
                        class="bg-primary hover:bg-primary-container mb-stack-sm font-label-md flex w-full items-center justify-center gap-2 rounded-2xl px-4 py-3 text-white shadow-sm transition-colors">
                        <span class="material-symbols-outlined text-[20px]">swap_horiz</span>Switch to Supplier
                    </a>
                    <form action="{{ route('logout') }}" method="POST"
                        class="hover:bg-surface-container-high text-on-surface-variant group my-1 flex items-center gap-3 rounded-lg px-4 py-3 transition-all">
                        @csrf
                        <span class="material-symbols-outlined">logout</span>
                        <button type="submit" class="font-label-md text-label-md">Logout</button>
                    </form>
                </div>
            </aside>
        @endif

        <main class="flex-1 p-6 transition-all duration-200">
            {{ $slot }}
        </main>

        <div x-data="{ open: false }" class="fixed bottom-8 right-8 z-50 flex flex-col items-center gap-3">
        
            <a href="{{ route('admin.buyers.manage') }}" wire:navigate x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-4 scale-75"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 scale-75"
                class="bg-secondary hover:bg-secondary/95 text-on-secondary group relative flex h-12 w-12 cursor-pointer items-center justify-center rounded-full shadow-md transition-transform hover:scale-110 active:scale-95"
                title="Buyer Dashboard">
        
                <span class="material-symbols-outlined text-[22px]">shopping_bag</span>
        
                <span
                    class="bg-surface-container border-outline-variant font-label-md text-primary pointer-events-none absolute right-14 whitespace-nowrap rounded-xl border px-3 py-1.5 text-[11px] font-bold opacity-0 shadow-sm transition-opacity group-hover:opacity-100">
                    Buyer Dashboard
                </span>
            </a>
        
            <a href="{{ route('admin.suppliers.manage') }}" wire:navigate x-show="open"
                x-transition:enter="transition ease-out duration-200 delay-[50ms]"
                x-transition:enter-start="opacity-0 translate-y-4 scale-75"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 scale-75"
                class="group relative flex h-12 w-12 cursor-pointer items-center justify-center rounded-full bg-emerald-600 text-white shadow-md transition-transform hover:scale-110 hover:bg-emerald-700 active:scale-95"
                title="Supplier Dashboard">
        
                <span class="material-symbols-outlined text-[22px]">local_shipping</span>
        
                <span
                    class="bg-surface-container border-outline-variant font-label-md text-primary pointer-events-none absolute right-14 whitespace-nowrap rounded-xl border px-3 py-1.5 text-[11px] font-bold opacity-0 shadow-sm transition-opacity group-hover:opacity-100">
                    Supplier Dashboard
                </span>
            </a>
        
            <button type="button" @click="open = !open"
                class="bg-primary flex h-14 w-14 cursor-pointer select-none items-center justify-center rounded-full text-white shadow-[0px_10px_32px_rgba(0,0,0,0.15)] outline-none transition-transform duration-300 hover:scale-105 active:scale-95">
        
                <span class="material-symbols-outlined transform text-[32px] transition-transform duration-300"
                    :class="open ? 'rotate-45 font-bold text-red-200' : 'rotate-0'">
                    add
                </span>
            </button>  </div>

    </div>
</body>

</html>
</html>
