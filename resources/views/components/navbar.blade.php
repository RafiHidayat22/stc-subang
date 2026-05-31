{{-- resources/views/components/navbar.blade.php --}}
<header
    id="stc-navbar"
    class="fixed top-0 left-0 w-full z-50 transition-all duration-300"
    x-data="{ mobileOpen: false }"
    role="banner"
>
    {{-- Background layer (starts transparent on hero, becomes solid on scroll) --}}
<div id="navbar-bg"
     class="absolute inset-0 bg-white/10 backdrop-blur-md border-b border-white/10 shadow-none transition-all duration-300">
</div>

    <div class="relative flex justify-between items-center w-full px-gutter max-w-container-max mx-auto h-20">
        {{-- Logo / Brand --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3 group" aria-label="STC Indonesia - Halaman Utama">
            <div class="w-13 h-13  rounded-lg flex items-center justify-center shadow-md group-hover:scale-110 transition-transform duration-200">
                <img 
                    src="{{ asset('images/logo-stc.png') }}" 
                    alt="Logo STC"
                    class="w-full h-full object-cover"
                >
            </div>
            <span id="navbar-brand" class="font-display-lg text-title-md font-bold text-white transition-colors duration-300">
                Subang Training Center
            </span>
        </a>

        {{-- Desktop Nav --}}
        <nav class="hidden md:flex gap-8 items-center" aria-label="Navigasi Utama">
            @php
                $navLinks = [
                    ['href' => '/',          'label' => 'Home'],
                    ['href' => '/about',         'label' => 'About'],
                    ['href' => '/programs',      'label' => 'Programs'],
                    ['href' => '/certification', 'label' => 'Certification'],
                    ['href' => '/articles',       'label' => 'Articles'],
                    ['href' => '/contact',       'label' => 'Contact'],
                ];
            @endphp

            @foreach ($navLinks as $link)
                <a
                    href="{{ $link['href'] }}"
                    class="nav-link text-white/90 font-medium hover:text-safety-orange transition-colors duration-200 relative py-1 after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-safety-orange after:transition-all after:duration-300 hover:after:w-full"
                    data-target="{{ $link['href'] }}"
                >
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>

        {{-- CTA Button --}}
        <div class="hidden md:flex items-center gap-3">
            <a
                href="#programs"
                class="bg-safety-orange hover:bg-orange-600 text-white px-6 py-2.5 rounded-lg font-semibold text-sm transition-all duration-200 transform hover:scale-105 active:scale-95 shadow-md hover:shadow-lg"
            >
                Daftar Sekarang
            </a>
        </div>

        {{-- Mobile Hamburger --}}
        <button
            id="navbar-hamburger"
            class="md:hidden flex flex-col justify-center items-center w-10 h-10 gap-1.5 rounded-lg hover:bg-white/10 transition-colors"
            aria-label="Buka menu navigasi"
            aria-expanded="false"
            aria-controls="mobile-menu"
            onclick="homeNavbarToggleMobile(this)"
        >
            <span class="hamburger-line block w-6 h-0.5 bg-white transition-all duration-300 origin-center"></span>
            <span class="hamburger-line block w-6 h-0.5 bg-white transition-all duration-300"></span>
            <span class="hamburger-line block w-6 h-0.5 bg-white transition-all duration-300 origin-center"></span>
        </button>
    </div>

    {{-- Mobile Menu Drawer --}}
    <div
        id="mobile-menu"
        class="md:hidden fixed top-20 left-0 w-full bg-surface-container-lowest/98 backdrop-blur-xl border-t border-outline-variant shadow-2xl transform -translate-y-full opacity-0 transition-all duration-300 pointer-events-none"
        aria-hidden="true"
    >
        <nav class="flex flex-col px-gutter py-8 gap-1" aria-label="Navigasi Mobile">
            @foreach ($navLinks as $link)
                <a
                    href="{{ $link['href'] }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg text-on-surface font-medium hover:bg-surface-container hover:text-safety-orange transition-all duration-200"
                    onclick="homeNavbarCloseMobile()"
                >
                    <span class="text-safety-orange text-sm font-bold">→</span>
                    {{ $link['label'] }}
                </a>
            @endforeach
            <div class="mt-4 pt-4 border-t border-outline-variant">
                <a
                    href="#programs"
                    class="block w-full text-center bg-safety-orange hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-bold transition-all duration-200"
                    onclick="homeNavbarCloseMobile()"
                >
                    Daftar Sekarang
                </a>
            </div>
        </nav>
    </div>
</header>
