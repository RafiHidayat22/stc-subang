{{-- resources/views/gallery/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Gallery Training — STC Indonesia')

@push('styles')
<style>
    /* ── Shared utilities (mirror certification) ── */
    .cert-reveal { opacity: 0; transform: translateY(40px); transition: opacity 0.7s cubic-bezier(.22,1,.36,1), transform 0.7s cubic-bezier(.22,1,.36,1); }
    .cert-reveal.visible { opacity: 1; transform: none; }
    .stc-card-lift { transition: transform .3s cubic-bezier(.22,1,.36,1), box-shadow .3s ease; }
    .stc-card-lift:hover { transform: translateY(-6px); box-shadow: 0 20px 40px -10px rgba(0,0,0,.15); }
    .industrial-pattern { background-image: radial-gradient(rgba(42,82,152,0.08) 1px, transparent 1px); background-size: 24px 24px; }
    .gradient-text { background: linear-gradient(to right, #002046, #2A5298); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    @keyframes stcFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
    .stc-float { animation: stcFloat 3s ease-in-out infinite; }

    /* ── Gallery Card (mirrors cert-card exactly) ── */
    .gal-card {
        transition: opacity .3s ease, transform .3s ease, box-shadow .3s ease;
    }

    /* ── Controls bar ── */
    .gal-controls {
        background: #0d1e35;
        border-top: 1px solid rgba(255,255,255,.12);
        border-bottom: 1px solid rgba(255,255,255,.12);
    }

    /* ── Search bar ── */
    .gal-search-wrap { position: relative; }
    .gal-search-wrap .icon {
        position: absolute; left: .875rem; top: 50%; transform: translateY(-50%);
        color: #7a9abf; pointer-events: none; font-size: 1.2rem;
    }
    #gal-search {
        padding-left: 2.75rem !important;
        background: rgba(255,255,255,.1) !important;
        border: 1.5px solid rgba(255,255,255,.25) !important;
        color: #f1f5f9 !important;
        border-radius: .625rem;
        transition: box-shadow .2s ease, border-color .2s ease;
    }
    #gal-search::placeholder { color: #7a9abf !important; }
    #gal-search:focus {
        outline: none !important;
        border-color: #ea580c !important;
        box-shadow: 0 0 0 3px rgba(234,88,12,.25) !important;
        background: rgba(255,255,255,.13) !important;
    }

    /* ── Filter pills ── */
    .gal-filter-btn {
        cursor: pointer;
        border: 1.5px solid rgba(255,255,255,.25);
        background: rgba(255,255,255,.08);
        color: #cbd5e1;
        border-radius: 999px;
        transition: all .2s ease;
        user-select: none;
        font-weight: 600;
    }
    .gal-filter-btn:hover { border-color: #ea580c; color: #ea580c; background: rgba(234,88,12,.12); }
    .gal-filter-btn.active { background: #ea580c; border-color: #ea580c; color: #fff; }

    /* ── Lightbox ── */
    #gal-lightbox {
        position: fixed; inset: 0; z-index: 9999;
        background: rgba(0,20,50,.97);
        display: flex; align-items: center; justify-content: center;
        padding: 1rem;
        opacity: 0; pointer-events: none;
        transition: opacity .3s ease;
    }
    #gal-lightbox.open { opacity: 1; pointer-events: all; }
    #gal-lightbox figure {
        position: relative; max-width: 900px; width: 100%;
        display: flex; flex-direction: column; align-items: center; gap: .75rem;
    }
    #gal-lb-img {
        max-height: 80vh; width: 100%; object-fit: contain;
        border-radius: .75rem;
        box-shadow: 0 30px 80px rgba(0,0,0,.7), 0 0 0 1px rgba(255,255,255,.06);
        transition: opacity .25s ease;
    }
    #gal-lb-img.fading { opacity: 0; }
    #gal-lb-caption { color: rgba(255,255,255,.9); font-size: .95rem; font-weight: 700; text-align: center; }
    #gal-lb-counter { color: rgba(255,255,255,.35); font-size: .78rem; font-family: monospace; letter-spacing: .1em; }
    .gal-lb-btn {
        position: absolute; top: 50%; transform: translateY(-50%);
        background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.2);
        color: #fff; border-radius: 999px; width: 2.75rem; height: 2.75rem;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: background .2s ease, transform .2s ease;
        z-index: 10; backdrop-filter: blur(8px);
    }
    .gal-lb-btn:hover { background: rgba(234,88,12,.75); border-color: #ea580c; transform: translateY(-50%) scale(1.1); }
    #gal-lb-prev { left: -4.5rem; }
    #gal-lb-next { right: -4.5rem; }
    #gal-lb-close {
        position: absolute; top: 1rem; right: 1rem;
        background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.2);
        color: #fff; border-radius: 999px; width: 2.5rem; height: 2.5rem;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: background .2s ease; z-index: 20;
    }
    #gal-lb-close:hover { background: rgba(239,68,68,.7); border-color: #ef4444; }
    @media (max-width: 768px) {
        #gal-lb-prev { left: .25rem; top: auto; bottom: -3.5rem; transform: none; }
        #gal-lb-next { right: .25rem; top: auto; bottom: -3.5rem; transform: none; }
        .gal-lb-btn:hover { transform: scale(1.1); }
    }

    /* ── Pagination ── */
    .gal-page-btn {
        width: 2.25rem; height: 2.25rem;
        border-radius: .5rem;
        display: flex; align-items: center; justify-content: center;
        font-size: .875rem; font-weight: 600;
        border: 1.5px solid rgba(255,255,255,.15);
        color: #94a3b8;
        cursor: pointer;
        transition: all .2s ease;
        background: rgba(255,255,255,.05);
    }
    .gal-page-btn:hover:not(:disabled) { border-color: #ea580c; color: #ea580c; background: rgba(234,88,12,.1); }
    .gal-page-btn.active { background: #ea580c; border-color: #ea580c; color: #fff; }
    .gal-page-btn:disabled { opacity: .3; cursor: not-allowed; }

    /* ── Empty state ── */
    #gal-empty {
        display: none;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 5rem 2rem;
        gap: 1rem;
        color: #94a3b8;
    }

    /* ── Card animation ── */
    @keyframes galCardIn {
        from { opacity: 0; transform: translateY(24px) scale(.97); }
        to   { opacity: 1; transform: none; }
    }
    .gal-card-anim {
        animation: galCardIn .5s cubic-bezier(.22,1,.36,1) both;
    }
</style>
@endpush

@section('content')

{{-- ================================================================
     HERO SECTION  (mirrors certification/index hero)
================================================================ --}}
<section class="relative pt-28 pb-32 overflow-hidden bg-primary" aria-label="Gallery header">
    <div class="absolute inset-0 z-0 opacity-20 bg-cover bg-center"
         style="background-image:url('{{ asset('images/gallery/hero-bg.jpg') }}')"></div>
    <div class="absolute right-0 top-0 w-1/2 h-full bg-gradient-to-l from-industrial-blue-light/30 to-transparent z-0"></div>

    <div class="max-w-container-max mx-auto px-gutter relative z-10">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 mb-6 backdrop-blur-sm">
                <span class="material-symbols-outlined text-safety-orange text-sm" aria-hidden="true">photo_library</span>
                <span class="text-white font-semibold text-xs uppercase tracking-wider">Visual STC Indonesia</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-6 leading-tight">
                Gallery <span class="text-safety-orange">Training</span>
            </h1>
            <p class="text-lg text-white/90 mb-10 max-w-2xl leading-relaxed">
                Dokumentasi kegiatan pelatihan, sertifikasi, dan workshop yang berlangsung di Subang Training Center.
                Setiap foto menceritakan komitmen kami terhadap keselamatan dan keunggulan industri.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="#gallery-section"
                   class="bg-safety-orange text-white px-8 py-4 rounded-lg font-semibold uppercase text-sm hover:bg-orange-600 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 inline-flex items-center gap-2">
                    Lihat Foto
                    <span class="material-symbols-outlined text-sm" aria-hidden="true">arrow_downward</span>
                </a>
                <a href="{{ route('contact.send') }}"
                   class="bg-white/10 text-white border border-white/30 px-8 py-4 rounded-lg font-semibold uppercase text-sm hover:bg-white/20 transition-all backdrop-blur-sm inline-flex items-center gap-2">
                    Hubungi Kami
                    <span class="material-symbols-outlined text-sm" aria-hidden="true">forum</span>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     STATS CARD (lifted, mirrors certification methodology bar)
================================================================ --}}
<section class="py-10 bg-surface-container-lowest border-b border-surface-variant relative z-20 -mt-10 mx-4 md:mx-auto max-w-5xl rounded-xl shadow-lg">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 px-8">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-lg bg-primary/5 text-primary flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-2xl" aria-hidden="true">collections</span>
            </div>
            <div>
                <p class="text-3xl font-bold text-safety-orange" id="gal-stat-total">{{ $galleries->total() }}</p>
                <p class="text-sm text-on-surface-variant mt-0.5">Total Foto Tersedia</p>
            </div>
        </div>
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-lg bg-safety-orange/10 text-safety-orange flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-2xl" aria-hidden="true">label</span>
            </div>
            <div>
                <p class="text-3xl font-bold text-safety-orange">{{ $categories->count() }}</p>
                <p class="text-sm text-on-surface-variant mt-0.5">Kategori Kegiatan</p>
            </div>
        </div>
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-lg bg-industrial-blue-light/10 text-industrial-blue-light flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-2xl" aria-hidden="true">verified</span>
            </div>
            <div>
                <p class="text-3xl font-bold text-safety-orange">98%</p>
                <p class="text-sm text-on-surface-variant mt-0.5">Compliance Rate</p>
            </div>
        </div>
    </div>
</section>


{{-- ================================================================
     GALLERY GRID  — mirrors certification/index categories grid
================================================================ --}}
<section id="gallery-section" class="py-24 bg-surface-gray industrial-pattern" aria-label="Gallery foto">
    <div class="max-w-container-max mx-auto px-gutter">

        {{-- Section heading (mirrors certification heading exactly) --}}
        <div class="text-center mb-16 cert-reveal">
            <h2 class="text-4xl md:text-5xl font-bold text-primary mb-4">
                Dokumentasi <span class="gradient-text">Kegiatan Kami</span>
            </h2>
            <p class="text-lg text-on-surface-variant max-w-2xl mx-auto">
                Setiap momen pelatihan dan sertifikasi diabadikan sebagai bukti nyata komitmen STC Indonesia
                dalam mencetak tenaga kerja kompeten dan berstandar tinggi.
            </p>
        </div>

        {{-- Grid — identical structure to cert-grid --}}
        <div
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
            id="gallery-grid"
            aria-live="polite"
            aria-label="Daftar foto gallery"
        >
            @forelse ($galleries as $i => $item)
                @php
                    $src     = Str::startsWith($item->image, 'http')
                                ? $item->image
                                : Storage::url($item->image);
                    $caption = $item->caption;
                    $cat     = $item->category ?? '';
                    // Derive a short "album" name from caption for the card title
                    $title   = $caption;
                    $desc    = $item->description ?? $caption;
                @endphp

                {{-- Card — mirrors cert-card markup exactly --}}
                <div
                    class="group relative overflow-hidden rounded-2xl bg-white shadow-sm hover:shadow-2xl transition-all duration-300 border-t-4 border-industrial-blue-light flex flex-col h-full stc-card-lift gal-card gal-card-anim"
                    data-caption="{{ e($caption) }}"
                    data-cat="{{ e($cat) }}"
                    data-src="{{ $src }}"
                    style="animation-delay: {{ ($i % 9) * 60 }}ms"
                    role="button"
                    tabindex="0"
                    aria-label="Lihat foto: {{ e($caption) }}"
                >

                    {{-- Thumbnail (mirrors cert card h-48 thumbnail) --}}
                    <div class="relative h-48 overflow-hidden bg-surface-variant">
                        <img
                            src="{{ $src }}"
                            alt="{{ e($caption) }}"
                            class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                            loading="lazy"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                        {{-- Bottom overlay: caption + badge --}}
                        <div class="absolute bottom-4 left-4 right-4 flex items-end justify-between">
                            <h3 class="text-base font-bold text-white leading-snug line-clamp-2 flex-1 pr-2">
                                {{ e($caption) }}
                            </h3>
                            @if ($cat)
                                <span class="bg-safety-orange/90 text-white text-xs font-bold px-2 py-1 rounded shrink-0">
                                    {{ e($cat) }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Content (mirrors cert card p-6 content block) --}}
                    <div class="p-6 flex flex-col flex-grow bg-white">

                        {{-- Description / caption text --}}
                        <p class="text-sm text-on-surface-variant leading-relaxed mb-5 flex-grow">
                            {{ Str::limit(e($desc), 120) }}
                        </p>

                        {{-- Category pill (mirrors checklist items styling) --}}
                        @if ($cat)
                            <div class="flex items-center gap-2 mb-5 text-sm text-on-surface-variant">
                                <span class="material-symbols-outlined text-safety-orange text-sm" aria-hidden="true">label</span>
                                <span>{{ e($cat) }}</span>
                            </div>
                        @endif

                        {{-- Photo count placeholder (mirrors "N Program Sertifikasi") --}}
                        <div class="flex items-center gap-2 mb-5 text-sm text-on-surface-variant">
                            <span class="material-symbols-outlined text-industrial-blue-light" aria-hidden="true">photo_library</span>
                            <span>Dokumentasi Kegiatan</span>
                        </div>

                        {{-- CTA — mirrors "Lihat Daftar Sertifikasi" link --}}
                        <button
                            type="button"
                            class="gal-open-lb inline-flex items-center gap-2 text-industrial-blue-light font-semibold uppercase text-sm hover:text-primary transition-colors group/link mt-auto"
                            aria-label="Buka foto: {{ e($caption) }}"
                        >
                            Lihat Foto
                            <span class="material-symbols-outlined text-sm transition-transform group-hover/link:translate-x-1" aria-hidden="true">
                                arrow_forward
                            </span>
                        </button>

                    </div>
                </div>

            @empty
                <div class="col-span-full text-center py-20">
                    <span class="material-symbols-outlined text-6xl text-outline mb-4" aria-hidden="true">photo_library</span>
                    <h3 class="text-2xl font-bold text-on-surface mb-2">Belum Ada Foto di Gallery</h3>
                    <p class="text-on-surface-variant">Data foto akan segera ditambahkan.</p>
                </div>
            @endforelse
        </div>

        {{-- Empty state (JS-driven) --}}
        <div id="gal-empty" aria-live="polite">
            <span class="material-symbols-outlined text-6xl opacity-20" aria-hidden="true">image_search</span>
            <p class="font-bold text-lg text-on-surface">Tidak ada foto yang cocok.</p>
            <p class="text-sm text-on-surface-variant">Coba kata kunci atau kategori lain.</p>
            <button
                onclick="galResetFilters()"
                class="mt-2 px-6 py-2.5 rounded-lg bg-safety-orange text-white text-sm font-bold hover:bg-orange-600 transition-colors inline-flex items-center gap-2"
            >
                <span class="material-symbols-outlined text-sm" aria-hidden="true">refresh</span>
                Reset Filter
            </button>
        </div>

        {{-- Pagination --}}
        <div class="mt-14 flex flex-col items-center gap-3" id="gal-pagination-wrap">
            <div class="flex items-center gap-2" id="gal-pagination" role="navigation" aria-label="Navigasi halaman gallery"></div>
            <p class="text-sm text-on-surface-variant" id="gal-page-info"></p>
        </div>

    </div>
</section>

{{-- ================================================================
     CONSULTATION CTA — mirrors certification/index exactly
================================================================ --}}
<section class="py-16 bg-primary" aria-label="Konsultasi Gallery">
    <div class="max-w-container-max mx-auto px-gutter">
        <div class="bg-white/5 border border-safety-orange/30 rounded-2xl p-8 flex flex-col md:flex-row items-center justify-between gap-6 cert-reveal">
            <div class="flex items-start gap-5">
                <span class="material-symbols-outlined text-safety-orange stc-float flex-shrink-0" style="font-size:48px" aria-hidden="true">photo_camera</span>
                <div>
                    <h3 class="text-xl font-bold text-white mb-2">Ingin Mendokumentasikan Program Pelatihan Anda?</h3>
                    <p class="text-outline-variant text-base">Kami menyediakan layanan in-house training lengkap dengan dokumentasi profesional sesuai kebutuhan perusahaan Anda.</p>
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
    @vite(['resources/js/gallery.js'])
@endpush