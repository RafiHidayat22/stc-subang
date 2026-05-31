{{-- resources/views/articles/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Artikel & Berita — STC Indonesia')
@section('meta_description', 'Pusat informasi pelatihan industri, standar keselamatan kerja, dan perkembangan sertifikasi BNSP di Indonesia.')

@section('content')

{{-- ================================================================
     ANIMATION STYLES
================================================================ --}}
<style>
    /* Scroll reveal */
    .art-reveal { opacity: 0; transform: translateY(32px); transition: opacity .65s cubic-bezier(.22,1,.36,1), transform .65s cubic-bezier(.22,1,.36,1); }
    .art-reveal.visible { opacity: 1; transform: none; }

    /* Card hover lift */
    .art-card { transition: transform .3s cubic-bezier(.22,1,.36,1), box-shadow .3s ease; }
    .art-card:hover { transform: translateY(-5px); box-shadow: 0 18px 36px -8px rgba(0,0,0,.14); }

    /* Category button active */
    .cat-btn.active { background-color: #2A5298; color: #fff; font-weight: 700; }
    .cat-btn.active:hover { background-color: #1e3d78; }

    /* Line clamp */
    .line-clamp-2 { display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
    .line-clamp-3 { display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden; }

    /* Float animation for icons */
    @keyframes artFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-6px)} }
    .art-float { animation: artFloat 3s ease-in-out infinite; }
</style>

{{-- ================================================================
     HERO SECTION
================================================================ --}}
<section class="relative pt-28 pb-32 overflow-hidden bg-primary" aria-label="Artikel dan Berita">
    {{-- Background image --}}
    <div class="absolute inset-0 z-0 opacity-20 bg-cover bg-center"
         style="background-image:url('{{ asset('images/hero-articles.jpg') }}')"></div>
    {{-- Right gradient accent --}}
    <div class="absolute right-0 top-0 w-1/2 h-full bg-gradient-to-l from-industrial-blue-light/30 to-transparent z-0"></div>

    <div class="max-w-container-max mx-auto px-gutter relative z-10">
        <div class="max-w-3xl">
            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 mb-6 backdrop-blur-sm">
                <span class="material-symbols-outlined text-safety-orange text-sm" aria-hidden="true">newspaper</span>
                <span class="text-white font-semibold text-xs uppercase tracking-wider">Update &amp; Wawasan</span>
            </div>

            <h1 class="text-4xl md:text-5xl font-bold text-white mb-6 leading-tight">
                Artikel &amp; <span class="text-safety-orange">Berita</span>
            </h1>

            <p class="text-lg text-white/90 mb-10 max-w-2xl leading-relaxed">
                Pusat informasi terbaru mengenai pelatihan industri, standar keselamatan kerja, dan perkembangan sertifikasi BNSP di Indonesia.
            </p>

            {{-- CTA Buttons --}}
            <div class="flex flex-wrap gap-4">
                <a
                    href="#articles-grid"
                    class="bg-safety-orange text-white px-8 py-4 rounded-lg font-semibold uppercase text-sm hover:bg-orange-600 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 inline-flex items-center gap-2"
                >
                    Baca Artikel
                    <span class="material-symbols-outlined text-sm" aria-hidden="true">arrow_downward</span>
                </a>
                <a
                    href="{{ route('home') }}#cta"
                    class="bg-white/10 text-white border border-white/30 px-8 py-4 rounded-lg font-semibold uppercase text-sm hover:bg-white/20 transition-all backdrop-blur-sm inline-flex items-center gap-2"
                >
                    Konsultasi Training
                    <span class="material-symbols-outlined text-sm" aria-hidden="true">forum</span>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     FEATURED ARTICLE HERO CARD
================================================================ --}}
@if ($featured)
<section class="max-w-container-max mx-auto px-gutter -mt-12 relative z-20 art-reveal" aria-label="Artikel Unggulan">
    <div class="bg-surface-container-lowest rounded-xl shadow-xl overflow-hidden flex flex-col md:flex-row border border-outline-variant/20">
        {{-- Image --}}
        <div class="md:w-3/5 h-64 md:h-auto overflow-hidden">
            <img
                src="{{ $featured->featured_image_url }}"
                alt="{{ e($featured->title) }}"
                class="w-full h-full object-cover transition-transform duration-700 hover:scale-105"
                loading="eager"
            />
        </div>
        {{-- Content --}}
        <div class="md:w-2/5 p-8 md:p-12 flex flex-col justify-center">
            <div class="flex items-center gap-2 mb-4 flex-wrap">
                @if ($featured->category)
                    <span class="bg-industrial-blue-light/10 text-industrial-blue-light text-[11px] font-bold px-2 py-0.5 rounded uppercase">
                        {{ e($featured->category->name) }}
                    </span>
                @endif
                <span class="text-sm text-on-surface-variant/60">{{ $featured->published_date }}</span>
            </div>
            <h2 class="text-2xl font-bold text-primary mb-6">
                {{ e($featured->title) }}
            </h2>
            <p class="text-base text-on-surface-variant mb-8 line-clamp-3">{{ e($featured->excerpt) }}</p>
            <div>
                <a
                    href="{{ route('articles.show', $featured->slug) }}"
                    class="group inline-flex items-center gap-2 text-industrial-blue-light font-bold hover:gap-4 transition-all text-base"
                >
                    Baca Selengkapnya
                    <span class="material-symbols-outlined text-sm" aria-hidden="true">arrow_forward</span>
                </a>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ================================================================
     CONTENT + SIDEBAR
================================================================ --}}
<section class="max-w-container-max mx-auto px-gutter py-20" aria-label="Daftar Artikel">
    <div class="flex flex-col lg:flex-row gap-12">

        {{-- ── SIDEBAR ────────────────────────────────────────────────── --}}
        <aside class="lg:w-1/4" aria-label="Filter Kategori">
            <div class="sticky top-24 space-y-8">

                {{-- Category Filter --}}
                <div>
                    <h3 class="text-lg font-bold text-primary mb-6 border-l-4 border-safety-orange pl-4">
                        Kategori
                    </h3>
                    <nav class="flex flex-col gap-1" id="category-nav" aria-label="Filter kategori artikel">
                        {{-- All --}}
                        <a
                            href="{{ route('articles.index') }}"
                            class="cat-btn flex justify-between items-center px-4 py-3 rounded-lg transition-all text-sm {{ ! $activeCategory ? 'active' : 'hover:bg-surface-container-high text-on-surface-variant' }}"
                        >
                            Semua
                            <span class="text-xs {{ ! $activeCategory ? 'opacity-60' : 'text-outline' }}">
                                {{ $totalPublished }}
                            </span>
                        </a>
                        @foreach ($categories as $cat)
                            <a
                                href="{{ route('articles.index', ['category' => $cat->slug]) }}"
                                class="cat-btn flex justify-between items-center px-4 py-3 rounded-lg transition-all group text-sm {{ $activeCategory?->slug === $cat->slug ? 'active' : 'hover:bg-surface-container-high text-on-surface-variant' }}"
                            >
                                {{ e($cat->name) }}
                                <span class="text-xs {{ $activeCategory?->slug === $cat->slug ? 'opacity-60' : 'text-outline group-hover:text-industrial-blue-light' }}">
                                    {{ $cat->articles_count }}
                                </span>
                            </a>
                        @endforeach
                    </nav>
                </div>

                {{-- CTA Box --}}
                <div class="bg-surface-container p-6 rounded-xl border border-outline-variant/30">
                    <h3 class="text-lg font-bold text-primary mb-4">Butuh Pelatihan Khusus?</h3>
                    <p class="text-sm text-on-surface-variant mb-6 leading-relaxed">
                        Kami melayani in-house training sesuai dengan kebutuhan operasional perusahaan Anda.
                    </p>
                    <a
                        href="{{ route('home') }}#cta"
                        class="block text-center bg-white border border-industrial-blue-light text-industrial-blue-light py-2 rounded-lg font-bold hover:bg-industrial-blue-light hover:text-white transition-all text-sm"
                    >
                        Konsultasi Gratis
                    </a>
                </div>

            </div>
        </aside>

        {{-- ── ARTICLES GRID ───────────────────────────────────────────── --}}
        <div class="lg:w-3/4">

            @if ($activeCategory)
                <p class="text-sm text-on-surface-variant mb-6">
                    Menampilkan artikel dalam kategori
                    <span class="font-bold text-primary">{{ e($activeCategory->name) }}</span>
                    &mdash; {{ $articles->total() }} artikel ditemukan.
                </p>
            @endif

            @if ($articles->isEmpty())
                <div class="flex flex-col items-center justify-center py-24 text-center gap-4">
                    <span class="material-symbols-outlined text-outline-variant" style="font-size:64px" aria-hidden="true">article</span>
                    <p class="text-sm text-on-surface-variant">Belum ada artikel dalam kategori ini.</p>
                    <a href="{{ route('articles.index') }}" class="text-sm text-industrial-blue-light font-bold flex items-center gap-1 hover:gap-2 transition-all">
                        Lihat semua artikel
                        <span class="material-symbols-outlined text-sm" aria-hidden="true">arrow_forward</span>
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-gutter" id="articles-grid">
                    @foreach ($articles as $article)
                        <article
                            class="art-card bg-surface-container-lowest rounded-lg shadow-sm border border-outline-variant/10 overflow-hidden flex flex-col group hover:shadow-md transition-shadow"
                            aria-label="{{ e($article->title) }}"
                        >
                            {{-- Thumbnail --}}
                            <div class="h-48 overflow-hidden relative">
                                <img
                                    src="{{ $article->thumbnail_url }}"
                                    alt="{{ e($article->title) }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                    loading="lazy"
                                />
                                @if ($article->category)
                                    <span class="absolute top-4 left-4 {{ $article->category->color }} text-white text-[10px] font-bold px-2 py-1 rounded uppercase">
                                        {{ e($article->category->name) }}
                                    </span>
                                @endif
                            </div>

                            {{-- Body --}}
                            <div class="p-6 flex flex-col flex-grow">
                                <span class="text-xs text-on-surface-variant/60 mb-2">{{ $article->published_date }}</span>
                                <h4 class="text-lg font-bold text-primary mb-3 line-clamp-2 leading-tight group-hover:text-industrial-blue-light transition-colors">
                                    {{ e($article->title) }}
                                </h4>
                                <p class="text-sm text-on-surface-variant mb-6 line-clamp-3 leading-relaxed">
                                    {{ e($article->excerpt) }}
                                </p>
                                <div class="mt-auto flex items-center justify-between">
                                    <a
                                        href="{{ route('articles.show', $article->slug) }}"
                                        class="text-sm font-bold text-industrial-blue-light flex items-center gap-1 group-hover:gap-2 transition-all"
                                        aria-label="Baca artikel: {{ e($article->title) }}"
                                    >
                                        Baca Selengkapnya
                                        <span class="material-symbols-outlined text-sm" aria-hidden="true">arrow_forward</span>
                                    </a>
                                    <span class="text-xs text-outline flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm" aria-hidden="true">visibility</span>
                                        {{ number_format($article->views) }}
                                    </span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- ── PAGINATION ──────────────────────────────────────────── --}}
                @if ($articles->hasPages())
                    <div class="mt-12 flex justify-center items-center gap-2" aria-label="Navigasi halaman artikel">
                        {{-- Prev --}}
                        @if ($articles->onFirstPage())
                            <span class="w-10 h-10 flex items-center justify-center rounded-lg border border-outline-variant text-outline-variant opacity-50 cursor-not-allowed" aria-hidden="true">
                                <span class="material-symbols-outlined">chevron_left</span>
                            </span>
                        @else
                            <a
                                href="{{ $articles->previousPageUrl() }}"
                                class="w-10 h-10 flex items-center justify-center rounded-lg border border-outline-variant hover:bg-surface-container-high transition-colors text-on-surface-variant"
                                aria-label="Halaman sebelumnya"
                            >
                                <span class="material-symbols-outlined" aria-hidden="true">chevron_left</span>
                            </a>
                        @endif

                        {{-- Page numbers --}}
                        @foreach ($articles->getUrlRange(1, $articles->lastPage()) as $page => $url)
                            @if ($page === $articles->currentPage())
                                <span class="w-10 h-10 flex items-center justify-center rounded-lg bg-industrial-blue-light text-on-primary font-bold text-sm" aria-current="page">
                                    {{ $page }}
                                </span>
                            @elseif (abs($page - $articles->currentPage()) <= 2 || $page === 1 || $page === $articles->lastPage())
                                <a
                                    href="{{ $url }}"
                                    class="w-10 h-10 flex items-center justify-center rounded-lg border border-outline-variant hover:bg-surface-container-high transition-colors text-sm text-on-surface-variant"
                                    aria-label="Halaman {{ $page }}"
                                >{{ $page }}</a>
                            @elseif (abs($page - $articles->currentPage()) === 3)
                                <span class="px-2 text-sm text-on-surface-variant">…</span>
                            @endif
                        @endforeach

                        {{-- Next --}}
                        @if ($articles->hasMorePages())
                            <a
                                href="{{ $articles->nextPageUrl() }}"
                                class="w-10 h-10 flex items-center justify-center rounded-lg border border-outline-variant hover:bg-surface-container-high transition-colors text-on-surface-variant"
                                aria-label="Halaman berikutnya"
                            >
                                <span class="material-symbols-outlined" aria-hidden="true">chevron_right</span>
                            </a>
                        @else
                            <span class="w-10 h-10 flex items-center justify-center rounded-lg border border-outline-variant text-outline-variant opacity-50 cursor-not-allowed" aria-hidden="true">
                                <span class="material-symbols-outlined">chevron_right</span>
                            </span>
                        @endif
                    </div>
                @endif
            @endif

        </div>
        {{-- end articles grid --}}

    </div>
</section>

{{-- ================================================================
     NEWSLETTER CTA
================================================================ --}}
<section id="consultation" class="py-16 bg-primary" aria-label="Konsultasi Sertifikasi">
    <div class="max-w-container-max mx-auto px-gutter">
        <div class="bg-white/5 border border-safety-orange/30 rounded-2xl p-8 flex flex-col md:flex-row items-center justify-between gap-6 cert-reveal">
            <div class="flex items-start gap-5">
                <span class="material-symbols-outlined text-safety-orange stc-float flex-shrink-0" style="font-size:48px" aria-hidden="true">handshake</span>
                <div>
                    <h3 class="text-xl font-bold text-white mb-2">Butuh Program Sertifikasi untuk Perusahaan Anda?</h3>
                    <p class="text-outline-variant text-base">Kami menyediakan in-house training dan program sertifikasi sesuai kebutuhan spesifik industri Anda.</p>
                </div>
            </div>
            <a href="{{ route('contact.send') }}"
               class="whitespace-nowrap bg-safety-orange hover:bg-orange-600 text-white px-7 py-3.5 rounded-xl text-base font-bold transition-all duration-200 hover:-translate-y-1 shadow-xl flex items-center gap-3">
                <span class="material-symbols-outlined text-xl" aria-hidden="true">forum</span>
                Konsultasi Sekarang
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
    @vite(['resources/js/articles.js'])
@endpush