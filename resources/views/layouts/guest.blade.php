<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gluto Management — Procurement & Wholesales Marketplace</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon.png') }}?v=2" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        primary: '#0F172A',
                        secondary: '#475569',
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-[#F8FAFC] selection:bg-slate-900 font-sans text-slate-800 selection:text-white antialiased">

    <header
        class="top-0 z-50 sticky bg-white/80 backdrop-blur-md border-slate-200/80 border-b transition-all select-none">
        <div class="flex justify-between items-center mx-auto px-6 sm:px-12 max-w-[1440px] h-20">

            <a href="{{ route('home') }}"
                class="flex items-center gap-2 font-extrabold text-primary text-xl tracking-tight">
                <img src="{{ asset('images/logo.png') }}" alt="Gluto Logo" class="h-[35px] md:h-[50px]">

            </a>

            <nav class="hidden md:flex items-center gap-8 font-semibold text-secondary text-sm">
                <a href="#buyers" class="hover:text-primary transition-colors">Enterprise Buyers</a>
                <a href="#suppliers" class="hover:text-primary transition-colors">Wholesale Suppliers</a>
                <a href="#features" class="hover:text-primary transition-colors">Platform Features</a>
            </nav>

            <div class="flex items-center gap-3 font-bold text-xs">
                <a href="{{ route('buyer.login') }}"
                    class="flex items-center gap-1 bg-white hover:bg-slate-50 px-4 py-2.5 border border-slate-300 rounded-xl text-slate-700 active:scale-95 transition-all">
                    <span class="text-[16px] material-symbols-outlined">person</span> Buyer Login
                </a>
                <a href="{{ route('supplier.login') }}"
                    class="flex items-center gap-1 bg-slate-900 hover:bg-slate-800 shadow-sm px-4 py-2.5 rounded-xl text-white active:scale-95 transition-all">
                    <span class="text-[16px] material-symbols-outlined">storefront</span> Supplier Portal
                </a>
            </div>
        </div>
    </header>

    {{ $slot }}

    <footer class="bg-primary py-12 border-slate-800 border-t text-slate-400 select-none">
        <div
            class="flex sm:flex-row flex-col justify-between items-center gap-6 mx-auto px-6 sm:px-12 max-w-[1440px] font-medium text-xs">

            <div class="flex items-center gap-2 font-extrabold text-white text-base tracking-tight">
                <img src="{{ asset('images/logo.png') }}" alt="Gluto Logo" class="h-[35px] md:h-[50px]">

            </div>

            <div class="flex items-center gap-6 text-slate-400">
                <a href="{{ route('buyer.login')  }}" class="hover:text-white transition-colors">Buyer Portal</a>
                <a href="{{ route('supplier.login')  }}" class="hover:text-white transition-colors">Supplier Portal</a>
                {{-- <a href="{{ route('buyer.login')  }}" class="hover:text-white transition-colors">Privacy Clause</a> --}}
            </div>

            <div class="font-mono text-[11px] text-slate-500">
                &copy; 2026 Gluto Management. Operational Procurement Architecture.
            </div>

        </div>
    </footer>

    </body>

    </html>
