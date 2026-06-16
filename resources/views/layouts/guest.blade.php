<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Gluto Management</title>

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
                        "xl": "0.75rem",
                        "2xl": "1rem",
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

        .login-canvas {
            background-color: #f9f9ff;
            background-image: radial-gradient(circle at 2px 2px, #064e3b08 1px, transparent 0);
            background-size: 24px 24px;
        }

        .soft-forest-shadow {
            box-shadow: 0px 10px 32px rgba(0, 0, 0, 0.08);
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="top-6 right-6 z-[100] fixed space-y-4 w-full max-w-sm pointer-events-none"
        wire:key="global-notification-alert-stack">

        @if (session()->has('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-4 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0 scale-100"
                x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-90 translate-y-2"
                class="flex items-start gap-3 bg-white shadow-[0px_10px_32px_rgba(6,78,59,0.08)] p-4 border border-emerald-100 border-l-4 border-l-emerald-500 rounded-2xl w-full animate-fadeIn pointer-events-auto select-none"
                role="alert">

                <div class="flex flex-shrink-0 justify-center items-center bg-emerald-50 p-2 rounded-xl text-emerald-600">
                    <span class="text-[20px] material-symbols-outlined"
                        style="font-variation-settings: 'FILL' 1;">check_circle</span>
                </div>

                <div class="flex-1 pt-0.5">
                    <h4 class="font-label-md font-bold text-primary text-xs tracking-tight">Operation Successful</h4>
                    <p class="mt-0.5 font-body-sm text-[11px] text-on-surface-variant leading-relaxed">{{ session('success') }}
                    </p>
                </div>

                <button type="button" @click="show = false"
                    class="hover:bg-surface-container p-1 rounded-full text-outline hover:text-on-surface transition-colors cursor-pointer">
                    <span class="text-[16px] material-symbols-outlined">close</span>
                </button>
            </div>
        @endif

        @if (session()->has('error') || $errors->any())
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 7000)" {{-- Extended duration for
                error reading tracking --}} x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-4 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0 scale-100"
                x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-90 translate-y-2"
                class="flex items-start gap-3 bg-white shadow-[0px_10px_32px_rgba(153,27,27,0.08)] p-4 border border-red-100 border-l-4 border-l-red-500 rounded-2xl w-full pointer-events-auto select-none"
                role="alert">

                <div class="flex flex-shrink-0 justify-center items-center bg-red-50 p-2 rounded-xl text-red-600">
                    <span class="text-[20px] material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">error</span>
                </div>

                <div class="flex-1 pt-0.5">
                    <h4 class="font-label-md font-bold text-red-900 text-xs tracking-tight">System Security Error</h4>

                    @if(session()->has('error'))
                        <p class="mt-0.5 font-body-sm text-[11px] text-on-surface-variant leading-relaxed">{{ session('error') }}
                        </p>
                    @else
                        <p class="mt-0.5 font-body-sm text-[11px] text-on-surface-variant leading-relaxed">Your input form matches
                            contain validation discrepancies. Please verify step parameters fields.</p>
                    @endif
                </div>

                <button type="button" @click="show = false"
                    class="hover:bg-surface-container p-1 rounded-full text-outline hover:text-on-surface transition-colors cursor-pointer">
                    <span class="text-[16px] material-symbols-outlined">close</span>
                </button>
            </div>
        @endif

    </div>

    {{ $slot }}


</body>

</html>
