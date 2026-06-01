{{-- resources/views/detail_gallery/index.blade.php --}}
@extends('layouts.app')

@section('title', ($categoryDecoded === 'all' ? 'Semua Foto' : 'Gallery: ' . $categoryDecoded) . ' — STC Indonesia')

@push('styles')
<style>
    /* ── Shared utilities ── */
    .cert-reveal { opacity: 0; transform: translateY(40px); transition: opacity 0.7s cubic-bezier(.22,1,.36,1), transform 0.7s cubic-bezier(.22,1,.36,1); }
    .cert-reveal.visible { opacity: 1; transform: none; }
    .stc-card-lift { transition: transform .3s cubic-bezier(.22,1,.36,1), box-shadow .3s ease; }
    .stc-card-lift:hover { transform: translateY(-6px); box-shadow: 0 20px 40px -10px rgba(0,0,0,.15); }
    .industrial-pattern { background-image: radial-gradient(rgba(42,82,152,0.08) 1px, transparent 1px); background-size: 24px 24px; }
    .gradient-text { background: linear-gradient(to right, #002046, #2A5298); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

    /* ── Sidebar category list ── */
    .cat-link {
        display: flex; align-items: center; gap: .625rem;
        padding: .625rem .875rem; border-radius: .625rem;
        font-size: .875rem; font-weight: 600;
        color: #475569; transition: all .2s ease;
        border: 1.5px solid transparent;
    }
    .cat-link:hover { background: #f1f5f9; color: #002046; border-color: #e2e8f0; }
    .cat-link.active { background: #ea580c; color: #fff; border-color: #ea580c; }
    .cat-link .count {
        margin-left: auto;
        background: rgba(0,0,0,.08); border-radius: 999px;
        padding: .1rem .5rem; font-size: .75rem; font-weight: 700;
    }
    .cat-link.active .count { background: rgba(255,255,255,.25); }

    /* ── Photo card ── */
    .photo-card {
        cursor: pointer;
        transition: transform .3s cubic-bezier(.22,1,.36,1), box-shadow .3s ease;
    }
    .photo-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px -8px rgba(0,0,0,.18); }

    /* ── Lightbox ── */
    #dtl-lightbox {
        position: fixed; inset: 0; z-index: 9999;
        background: rgba(0,15,40,.97);
        display: flex; align-items: center; justify-content: center;
        padding: 1.5rem;
        opacity: 0; pointer-events: none;
        transition: opacity .3s ease;
    }
    #dtl-lightbox.open { opacity: 1; pointer-events: all; }
    #dtl-lightbox figure {
        position: relative; max-width: 960px; width: 100%;
        display: flex; flex-direction: column; align-items: center; gap: .875rem;
    }
    #dtl-lb-img {
        max-height: 78vh; width: 100%; object-fit: contain;
        border-radius: .875rem;
        box-shadow: 0 32px 80px rgba(0,0,0,.7), 0 0 0 1px rgba(255,255,255,.07);
        transition: opacity .25s ease;
    }
    #dtl-lb-img.fading { opacity: 0; }
    #dtl-lb-caption { color: rgba(255,255,255,.92); font-size: 1rem; font-weight: 700; text-align: center; }
    #dtl-lb-meta    { color: rgba(255,255,255,.35); font-size: .78rem; font-family: monospace; letter-spacing: .1em; }

    .dtl-lb-btn {
        position: absolute; top: 50%; transform: translateY(-50%);
        background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.2);
        color: #fff; border-radius: 999px; width: 2.875rem; height: 2.875rem;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: background .2s ease, transform .2s ease;
        backdrop-filter: blur(8px);
    }
    .dtl-lb-btn:hover { background: rgba(234,88,12,.75); border-color: #ea580c; transform: translateY(-50%) scale(1.1); }
    .dtl-lb-btn:disabled { opacity: .25; cursor: not-allowed; }
    .dtl-lb-btn:disabled:hover { background: rgba(255,255,255,.08); border-color: rgba(255,255,255,.2); transform: translateY(-50%); }
    #dtl-lb-prev { left: -5rem; }
    #dtl-lb-next { right: -5rem; }
    #dtl-lb-close {
        position: absolute; top: 1rem; right: 1rem;
        background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.2);
        color: #fff; border-radius: 999px; width: 2.5rem; height: 2.5rem;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: background .2s ease; z-index: 20;
    }
    #dtl-lb-close:hover { background: rgba(239,68,68,.75); border-color: #ef4444; }

    @media (max-width: 768px) {
        #dtl-lb-prev { left: .5rem; top: auto; bottom: -4rem; transform: none; }
        #dtl-lb-next { right: .5rem; top: auto; bottom: -4rem; transform: none; }
        .dtl-lb-btn:hover { transform: scale(1.1); }
        .dtl-lb-btn:disabled:hover { transform: none; }
    }

    /* ── Card entrance animation ── */
    @keyframes photoCardIn {
        from { opacity: 0; transform: translateY(20px) scale(.97); }
        to   { opacity: 1; transform: none; }
    }
    .photo-card-anim { animation: photoCardIn .45s cubic-bezier(.22,1,.36,1) both; }

    /* ── Breadcrumb ── */
    .breadcrumb-sep { color: rgba(255,255,255,.3); margin: 0 .375rem; }
</style>
@endpush

@section('content')

{{-- ── HERO ─────────────────────────────────────────────────────────────── --}}
<section class="relative pt-28 pb-28 overflow-hidden bg-primary" aria-label="Gallery detail header">
    <div class="absolute inset-0 z-0 opacity-15 bg-cover bg-center"
         style="background-image:url('{{ asset('images/gallery/hero-bg.jpg') }}')"></div>
    <div class="absolute right-0 top-0 w-1/2 h-full bg-gradient-to-l from-industrial-blue-light/20 to-transparent z-0"></div>

    <div class="max-w-container-max mx-auto px-gutter relative z-10">

        {{-- Breadcrumb --}}
        <nav class="flex items-center text-sm mb-7 text-white/60" aria-label="Breadcrumb">
            <a href="{{ route('gallery.index') }}" class="hover:text-white transition-colors">Gallery</a>
            <span class="breadcrumb-sep" aria-hidden="true">/</span>
            <span class="text-white font-semibold truncate max-w-xs">
                {{ $categoryDecoded === 'all' ? 'Semua Foto' : $categoryDecoded }}
            </span>
        </nav>

        <div class="max-w-2xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 mb-5 backdrop-blur-sm">
                <span class="material-symbols-outlined text-safety-orange text-sm" aria-hidden="true">photo_library</span>
                <span class="text-white font-semibold text-xs uppercase tracking-wider">
                    {{ $categoryDecoded === 'all' ? 'Semua Kategori' : 'Kategori' }}
                </span>
            </div>

            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 leading-tight">
                @if ($categoryDecoded === 'all')
                    Semua <span class="text-safety-orange">Foto</span>
                @else
                    {{ $categoryDecoded }}
                @endif
            </h1>

            <p class="text-base text-white/80 mb-8 max-w-xl leading-relaxed">
                @if ($categoryDecoded === 'all')
                    Seluruh dokumentasi kegiatan pelatihan dan sertifikasi Subang Training Center.
                @else
                    Dokumentasi foto kegiatan <strong class="text-white">{{ $categoryDecoded }}</strong>
                    di Subang Training Center Indonesia.
                @endif
            </p>

            {{-- Stats chips --}}
            <div class="flex flex-wrap gap-3">
                <span class="inline-flex items-center gap-1.5 bg-white/10 border border-white/20 text-white text-sm font-semibold px-4 py-2 rounded-full backdrop-blur-sm">
                    <span class="material-symbols-outlined text-safety-orange text-base" aria-hidden="true">collections</span>
                    {{ $photos->count() }} Foto
                </span>
                <span class="inline-flex items-center gap-1.5 bg-white/10 border border-white/20 text-white text-sm font-semibold px-4 py-2 rounded-full backdrop-blur-sm">
                    <span class="material-symbols-outlined text-safety-orange text-base" aria-hidden="true">label</span>
                    {{ $categories->count() }} Kategori
                </span>
                <a href="{{ route('gallery.index') }}"
                   class="inline-flex items-center gap-1.5 bg-white/10 border border-white/20 text-white text-sm font-semibold px-4 py-2 rounded-full backdrop-blur-sm hover:bg-white/20 transition-colors">
                    <span class="material-symbols-outlined text-safety-orange text-base" aria-hidden="true">grid_view</span>
                    Lihat Semua
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ── MAIN CONTENT: Sidebar + Grid ───────────────────────────────────────── --}}
<section class="py-16 bg-surface-gray industrial-pattern" aria-label="Foto gallery">
    <div class="max-w-container-max mx-auto px-gutter">
        <div class="flex gap-10 items-start">

            {{-- ── Sidebar ──────────────────────────────────────────────── --}}
            <aside class="hidden lg:block w-64 shrink-0 sticky top-24" aria-label="Filter kategori">
                <div class="bg-white rounded-2xl shadow-sm border border-surface-variant overflow-hidden">
                    <div class="px-5 py-4 bg-primary">
                        <h2 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                            <span class="material-symbols-outlined text-safety-orange text-base" aria-hidden="true">label</span>
                            Kategori
                        </h2>
                    </div>
                    <nav class="p-3 flex flex-col gap-1" aria-label="Daftar kategori gallery">
                        {{-- "Semua" link --}}
                        <a href="{{ route('gallery.detail', 'all') }}"
                           class="cat-link {{ $categoryDecoded === 'all' ? 'active' : '' }}">
                            <span class="material-symbols-outlined text-base" aria-hidden="true">photo_library</span>
                            Semua Foto
                            <span class="count">{{ $totalAll }}</span>
                        </a>

                        @foreach ($categories as $cat)
                            @php
                                $catCount = \App\Models\Gallery::active()
                                    ->where('category', $cat)->count();
                            @endphp
                            <a href="{{ route('gallery.detail', urlencode($cat)) }}"
                               class="cat-link {{ $categoryDecoded === $cat ? 'active' : '' }}">
                                <span class="material-symbols-outlined text-base" aria-hidden="true">folder</span>
                                {{ $cat }}
                                <span class="count">{{ $catCount }}</span>
                            </a>
                        @endforeach
                    </nav>

                    {{-- Back to main gallery --}}
                    <div class="px-4 pb-4">
                        <a href="{{ route('gallery.index') }}"
                           class="w-full flex items-center justify-center gap-2 text-sm font-semibold text-primary border border-primary/20 rounded-lg px-4 py-2.5 hover:bg-primary hover:text-white transition-all">
                            <span class="material-symbols-outlined text-base" aria-hidden="true">arrow_back</span>
                            Kembali ke Gallery
                        </a>
                    </div>
                </div>
            </aside>

            {{-- ── Photo Grid ──────────────────────────────────────────── --}}
            <div class="flex-1 min-w-0">

                {{-- Mobile category filter (horizontal scroll) --}}
                <div class="flex gap-2 overflow-x-auto pb-2 mb-6 lg:hidden scrollbar-hide snap-x">
                    <a href="{{ route('gallery.detail', 'all') }}"
                       class="shrink-0 snap-start px-4 py-2 rounded-full text-sm font-bold border-2 transition-all
                              {{ $categoryDecoded === 'all' ? 'bg-safety-orange border-safety-orange text-white' : 'border-slate-300 text-slate-600 bg-white' }}">
                        Semua
                    </a>
                    @foreach ($categories as $cat)
                        <a href="{{ route('gallery.detail', urlencode($cat)) }}"
                           class="shrink-0 snap-start px-4 py-2 rounded-full text-sm font-bold border-2 transition-all
                                  {{ $categoryDecoded === $cat ? 'bg-safety-orange border-safety-orange text-white' : 'border-slate-300 text-slate-600 bg-white' }}">
                            {{ $cat }}
                        </a>
                    @endforeach
                </div>

                {{-- Result count --}}
                @if ($photos->count())
                    <p class="text-sm text-on-surface-variant mb-6 font-medium">
                        Menampilkan <strong class="text-on-surface">{{ $photos->count() }}</strong> foto
                        @if ($categoryDecoded !== 'all')
                            dalam kategori <strong class="text-safety-orange">{{ $categoryDecoded }}</strong>
                        @endif
                    </p>
                @endif

                {{-- Grid --}}
                @if ($photos->count())
                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6"
                        id="dtl-photo-grid"
                        role="list"
                        aria-label="Foto {{ $categoryDecoded }}"
                    >
                        @foreach ($photos as $i => $photo)
                            @php
                                $src = Str::startsWith($photo->image, 'http')
                                    ? $photo->image
                                    : Storage::url($photo->image);
                            @endphp
                            <article
                                class="photo-card photo-card-anim group rounded-2xl overflow-hidden bg-white shadow-sm border border-surface-variant"
                                data-src="{{ $src }}"
                                data-caption="{{ e($photo->caption) }}"
                                data-idx="{{ $i }}"
                                style="animation-delay: {{ ($i % 12) * 55 }}ms"
                                role="listitem"
                                tabindex="0"
                                aria-label="Foto: {{ e($photo->caption) }}"
                            >
                                {{-- Thumbnail --}}
                                <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">
                                    <img
                                        src="{{ $src }}"
                                        alt="{{ e($photo->caption) }}"
                                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-108"
                                        loading="lazy"
                                    />
                                    {{-- Category badge --}}
                                    @if ($photo->category && $categoryDecoded === 'all')
                                        <span class="absolute top-3 left-3 bg-safety-orange/90 backdrop-blur-sm text-white text-xs font-bold px-2.5 py-1 rounded-full">
                                            {{ e($photo->category) }}
                                        </span>
                                    @endif
                                </div>

                                {{-- Caption strip --}}
                                <div class="px-4 py-3">
                                    <p class="text-sm font-semibold text-on-surface line-clamp-2 leading-snug">
                                        {{ e($photo->caption) }}
                                    </p>
                                    @if ($photo->created_at)
                                        <p class="text-xs text-on-surface-variant mt-1">
                                            {{ $photo->created_at->translatedFormat('d M Y') }}
                                        </p>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>

                @else
                    {{-- Empty state --}}
                    <div class="flex flex-col items-center justify-center py-24 text-center gap-4">
                        <span class="material-symbols-outlined text-7xl text-slate-300" aria-hidden="true">image_not_supported</span>
                        <h3 class="text-2xl font-bold text-on-surface">Belum Ada Foto</h3>
                        <p class="text-on-surface-variant max-w-sm">
                            Foto untuk kategori <strong>{{ $categoryDecoded }}</strong> belum tersedia saat ini.
                        </p>
                        <a href="{{ route('gallery.index') }}"
                           class="mt-2 inline-flex items-center gap-2 bg-safety-orange text-white px-6 py-3 rounded-xl font-bold text-sm hover:bg-orange-600 transition-colors">
                            <span class="material-symbols-outlined text-base" aria-hidden="true">arrow_back</span>
                            Kembali ke Gallery
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>


{{-- ── CTA ───────────────────────────────────────────────────────────────── --}}
<section class="py-16 bg-primary" aria-label="Konsultasi">
    <div class="max-w-container-max mx-auto px-gutter">
        <div class="bg-white/5 border border-safety-orange/30 rounded-2xl p-8 flex flex-col md:flex-row items-center justify-between gap-6 cert-reveal">
            <div class="flex items-start gap-5">
                <span class="material-symbols-outlined text-safety-orange flex-shrink-0" style="font-size:48px" aria-hidden="true">photo_camera</span>
                <div>
                    <h3 class="text-xl font-bold text-white mb-2">Tertarik dengan Program Pelatihan Kami?</h3>
                    <p class="text-outline-variant text-base">
                        Kami siap mendampingi kebutuhan pelatihan K3 dan sertifikasi tenaga kerja perusahaan Anda.
                    </p>
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
<script src="{{ asset('js/detail_gallery.js') }}"></script>
@endpush