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
    {{ $slot }}
</body>

</html>
