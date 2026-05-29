{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="{{ $meta_description ?? 'STC Indonesia – Subang Training Center. Pusat pelatihan industri berbasis kompetensi untuk tenaga kerja profesional dan siap kerja.' }}" />
    <meta name="robots" content="index, follow" />

    {{-- CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    {{-- Open Graph --}}
    <meta property="og:title" content="{{ $meta_title ?? config('app.name') }}" />
    <meta property="og:description" content="{{ $meta_description ?? 'Pusat Pelatihan Industri Terpadu di Jawa Barat.' }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />

    <title>{{ $meta_title ?? config('app.name', 'STC Indonesia') }}</title>

    {{-- Preconnect fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet" />

    {{-- Vite: Tailwind CSS --}}
    @vite(['resources/css/app.css'])

    {{-- Stack for page-specific head assets --}}
    @stack('head')
</head>
<body class="bg-surface-gray font-body-md text-on-surface antialiased">

    {{-- Navbar Component --}}
    <x-navbar />

    {{-- Main Content --}}
    <main id="main-content" role="main">
        @yield('content')
    </main>

    {{-- Footer Component --}}
    <x-footer />

    {{-- Scroll to top button --}}
    <button
        id="scroll-to-top"
        class="fixed bottom-6 right-6 z-40 w-12 h-12 bg-safety-orange text-white rounded-full shadow-xl flex items-center justify-center opacity-0 translate-y-4 transition-all duration-300 pointer-events-none hover:bg-orange-600 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-safety-orange focus:ring-offset-2"
        aria-label="Kembali ke atas"
        onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
    >
        <span class="material-symbols-outlined" aria-hidden="true">arrow_upward</span>
    </button>

        @vite(['resources/js/navbar.js'])


    {{-- Vite: JS --}}
    @vite(['resources/js/app.js'])

    {{-- Page-specific scripts --}}
    @stack('scripts')
</body>
</html>
