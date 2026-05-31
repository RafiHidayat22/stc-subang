{{-- resources/views/program/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Program Pelatihan - STC Indonesia')

@section('content')

<style>
    .stc-reveal { opacity: 0; transform: translateY(40px); transition: opacity 0.7s cubic-bezier(.22,1,.36,1), transform 0.7s cubic-bezier(.22,1,.36,1); }
    .stc-reveal.visible { opacity: 1; transform: none; }
    .stc-card-lift { transition: transform .3s cubic-bezier(.22,1,.36,1), box-shadow .3s ease; }
    .stc-card-lift:hover { transform: translateY(-6px); box-shadow: 0 20px 40px -10px rgba(0,0,0,.15); }
    .industrial-pattern { background-image: radial-gradient(rgba(42,82,152,0.08) 1px, transparent 1px); background-size: 24px 24px; }
    .gradient-text { background: linear-gradient(to right, #002046, #2A5298); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .glass-card { background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); }
    @keyframes stcFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
    .stc-float { animation: stcFloat 3s ease-in-out infinite; }
    .program-card-hover .card-overlay { opacity: 0; transform: translateY(10px); transition: opacity .3s, transform .3s; }
    .program-card-hover:hover .card-overlay { opacity: 1; transform: translateY(0); }
    .filter-btn.active { background-color: #002046; color: #fff; border-color: #002046; }

    .category-card {
    transition:
        opacity .3s ease,
        transform .3s ease,
        box-shadow .3s ease;
}
</style>

{{-- ═══════════════════════════════════════════════
     HERO SECTION
════════════════════════════════════════════════ --}}
<section class="relative pt-28 pb-32 overflow-hidden bg-primary" aria-label="Hero Program Pelatihan">
    <div class="absolute inset-0 z-0 opacity-20 bg-cover bg-center"
         style="background-image:url('{{ asset('images/hero-programs.jpg') }}')"></div>
    <div class="absolute right-0 top-0 w-1/2 h-full bg-gradient-to-l from-industrial-blue-light/30 to-transparent z-0"></div>

    <div class="max-w-container-max mx-auto px-gutter relative z-10">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 mb-6 backdrop-blur-sm">
                <span class="material-symbols-outlined text-safety-orange text-sm" aria-hidden="true">workspace_premium</span>
                <span class="text-white font-semibold text-xs uppercase tracking-wider">Kurikulum Berstandar Industri</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-6 leading-tight">
                Program Pelatihan <span class="text-safety-orange">Unggul</span>
            </h1>
            <p class="text-lg text-white/90 mb-10 max-w-2xl leading-relaxed">
                Tingkatkan kompetensi tenaga kerja Anda dengan program pelatihan STC Indonesia. Dirancang khusus untuk memenuhi kebutuhan industri berat, otomotif, dan manufaktur modern dengan standar keselamatan tertinggi.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="#categories" class="bg-safety-orange text-white px-8 py-4 rounded-lg font-semibold uppercase text-sm hover:bg-orange-600 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 inline-flex items-center gap-2">
                    Lihat Program
                    <span class="material-symbols-outlined text-sm" aria-hidden="true">arrow_downward</span>
                </a>
                <a href="#consultation" class="bg-white/10 text-white border border-white/30 px-8 py-4 rounded-lg font-semibold uppercase text-sm hover:bg-white/20 transition-all backdrop-blur-sm inline-flex items-center gap-2">
                    Konsultasi Program
                    <span class="material-symbols-outlined text-sm" aria-hidden="true">forum</span>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     METHODOLOGY BRIEF
════════════════════════════════════════════════ --}}
<section class="py-10 bg-surface-container-lowest border-b border-surface-variant relative z-20 -mt-10 mx-4 md:mx-auto max-w-5xl rounded-xl shadow-lg">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 px-8">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-lg bg-primary/5 text-primary flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-2xl" aria-hidden="true">menu_book</span>
            </div>
            <div>
                <h3 class="font-bold text-lg text-on-surface mb-1">Teori Komprehensif</h3>
                <p class="text-on-surface-variant text-sm">Pemahaman mendalam tentang konsep dasar dan standar operasional industri.</p>
            </div>
        </div>
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-lg bg-safety-orange/10 text-safety-orange flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-2xl" aria-hidden="true">build</span>
            </div>
            <div>
                <h3 class="font-bold text-lg text-on-surface mb-1">Praktik Intensif</h3>
                <p class="text-on-surface-variant text-sm">Simulasi dan praktik langsung menggunakan peralatan standar industri terkini.</p>
            </div>
        </div>
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-lg bg-industrial-blue-light/10 text-industrial-blue-light flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-2xl" aria-hidden="true">verified</span>
            </div>
            <div>
                <h3 class="font-bold text-lg text-on-surface mb-1">Sertifikasi BNSP</h3>
                <p class="text-on-surface-variant text-sm">Evaluasi kompetensi terstruktur yang berujung pada sertifikasi resmi.</p>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     PROGRAM CATEGORY GRID
════════════════════════════════════════════════ --}}
<section id="categories" class="py-24 bg-surface-gray industrial-pattern" aria-label="Kategori Program">
    <div class="max-w-container-max mx-auto px-gutter">

        <div class="text-center mb-16 stc-reveal">
            <h2 class="text-4xl md:text-5xl font-bold text-primary mb-4">
                Pilihan <span class="gradient-text">Program Pelatihan</span>
            </h2>
            <p class="text-lg text-on-surface-variant max-w-2xl mx-auto">
                Kurikulum komprehensif yang dirancang untuk membangun tenaga kerja kompeten, disiplin, dan sadar akan keselamatan kerja.
            </p>
        </div>

        {{-- Filter Buttons --}}
        <div class="flex flex-wrap justify-center gap-3 mb-12" id="program-filter" role="tablist" aria-label="Filter program">
            <button class="filter-btn active px-5 py-2 rounded-full border border-primary text-primary font-semibold text-sm transition-all" data-filter="all">
                Semua Program
            </button>
            @foreach ($categories as $cat)
                <button class="filter-btn px-5 py-2 rounded-full border border-outline text-on-surface-variant font-semibold text-sm transition-all hover:border-primary hover:text-primary"
                        data-filter="{{ $cat->slug }}">
                    {{ $cat->name }}
                </button>
            @endforeach
        </div>

        {{-- Kategori Program Grid --}}
{{-- Category Grid --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="program-grid">

    @forelse ($categories as $category)

<div
    class="group relative overflow-hidden rounded-2xl bg-white shadow-sm hover:shadow-2xl transition-all duration-300 border-t-4 border-industrial-blue-light flex flex-col h-full stc-card-lift category-card"
    data-category="{{ $category->slug }}"
>
            {{-- Thumbnail --}}
            <div class="relative h-64 overflow-hidden">

                <img
                    src="{{ $category->thumbnail
                        ? Storage::url($category->thumbnail)
                        : asset('images/placeholder-program.jpg') }}"
                    alt="{{ e($category->name) }}"
                    class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                    loading="lazy"
                />

                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                <div class="absolute bottom-5 left-5 right-5">

                    <h3 class="text-2xl font-bold text-white mb-2">
                        {{ e($category->name) }}
                    </h3>

                    @if ($category->description)
                        <p class="text-white/80 text-sm line-clamp-2">
                            {{ Str::limit($category->description, 100) }}
                        </p>
                    @endif

                </div>

            </div>

            {{-- Content --}}
            <div class="p-6 flex flex-col flex-grow bg-white">

                {{-- Program Count --}}
                <div class="flex items-center gap-2 mb-5 text-sm text-on-surface-variant">

                    <span
                        class="material-symbols-outlined text-industrial-blue-light"
                        aria-hidden="true"
                    >
                        school
                    </span>

                    <span>
                        {{ $category->programs_count }} Program Pelatihan
                    </span>

                </div>

                {{-- CTA --}}
                <a
                    href="{{ route('programs.category', $category) }}"
                    class="inline-flex items-center gap-2 text-industrial-blue-light font-semibold uppercase text-sm hover:text-primary transition-colors group/link mt-auto"
                >

                    Lihat Category

                    <span
                        class="material-symbols-outlined text-sm transition-transform group-hover/link:translate-x-1"
                        aria-hidden="true"
                    >
                        arrow_forward
                    </span>

                </a>

            </div>

        </div>

    @empty

        <div class="col-span-full text-center py-20">

            <span
                class="material-symbols-outlined text-6xl text-outline mb-4"
                aria-hidden="true"
            >
                category
            </span>

            <h3 class="text-2xl font-bold text-on-surface mb-2">
                Belum Ada Category Program
            </h3>

            <p class="text-on-surface-variant">
                Data kategori program belum tersedia.
            </p>

        </div>

    @endforelse

</div>


    </div>
</section>

{{-- ═══════════════════════════════════════════════
     CONSULTATION CTA
════════════════════════════════════════════════ --}}
<section id="consultation" class="py-16 bg-primary" aria-label="Konsultasi Program">
    <div class="max-w-container-max mx-auto px-gutter">
        <div class="bg-white/5 border border-safety-orange/30 rounded-2xl p-8 flex flex-col md:flex-row items-center justify-between gap-6 stc-reveal">
            <div class="flex items-start gap-5">
                <span class="material-symbols-outlined text-safety-orange stc-float flex-shrink-0" style="font-size:48px" aria-hidden="true">handshake</span>
                <div>
                    <h3 class="text-xl font-bold text-white mb-2">Butuh Program Khusus untuk Perusahaan Anda?</h3>
                    <p class="text-outline-variant text-base">Kami menyediakan in-house training dan program sertifikasi sesuai kebutuhan spesifik industri Anda.</p>
                </div>
            </div>
            <a href="{{ route('contact.send') }}" class="whitespace-nowrap bg-safety-orange hover:bg-orange-600 text-white px-7 py-3.5 rounded-xl text-base font-bold transition-all duration-200 hover:-translate-y-1 shadow-xl flex items-center gap-3">
                <span class="material-symbols-outlined text-xl" aria-hidden="true">forum</span>
                Konsultasi Sekarang
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
    @vite(['resources/js/program.js'])
@endpush