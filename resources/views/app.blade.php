<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['dark' => ($appearance ?? 'system') == 'dark'])>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- SEO BASIC --}}
    <title inertia>{{ config('app.name', 'Solihah Store') }}</title>

    <meta name="description"
        content="Solihah Store menyediakan rekomendasi produk terbaik mulai dari skincare, bodycare, fashion, aksesoris, dan kebutuhan harian pilihan.">

    <meta name="keywords"
        content="affiliate store, rekomendasi produk, skincare, bodycare, fashion wanita, produk viral, shopee affiliate, tiktok affiliate">

    <meta name="robots" content="index, follow">

    <meta name="author" content="Solihah Store">

    {{-- CANONICAL --}}
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- OPEN GRAPH / FACEBOOK / WHATSAPP --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ config('app.name', 'Solihah Store') }}">
    <meta property="og:description"
        content="Temukan rekomendasi produk terbaik dan produk viral pilihan hanya di Solihah Store.">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/og-cover.jpg') }}">

    {{-- TWITTER --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ config('app.name', 'Solihah Store') }}">
    <meta name="twitter:description"
        content="Rekomendasi produk  terbaik untuk kebutuhan harian dan lifestyle.">
    <meta name="twitter:image" content="{{ asset('images/og-cover.jpg') }}">

    {{-- Inline script to detect system dark mode preference and apply it immediately --}}
    <script>
        (function() {
            const appearance = '{{ $appearance ?? "system" }}';

            if (appearance === 'system') {
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                if (prefersDark) {
                    document.documentElement.classList.add('dark');
                }
            }
        })();
    </script>

    {{-- Inline style to set the HTML background color based on our theme in app.css --}}
    <style>
        html {
            background-color: oklch(1 0 0);
        }

        html.dark {
            background-color: oklch(0.145 0 0);
        }
    </style>

    {{-- ICON --}}
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    {{-- FONT --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    {{-- VITE --}}
    @vite(['resources/css/app.css', 'resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])

    {{-- INERTIA --}}
    <x-inertia::head />
    </head>

    <body class="font-sans antialiased">
        <x-inertia::app />
    </body>
</html>