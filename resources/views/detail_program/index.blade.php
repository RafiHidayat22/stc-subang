{{-- resources/views/detail_program/index.blade.php --}}
@extends('layouts.app')

@section('title', e($program->title) . ' - STC Indonesia')

@section('content')

<style>
    .stc-reveal { opacity: 0; transform: translateY(40px); transition: opacity 0.7s cubic-bezier(.22,1,.36,1), transform 0.7s cubic-bezier(.22,1,.36,1); }
    .stc-reveal.visible { opacity: 1; transform: none; }
    .stc-card-lift { transition: transform .3s cubic-bezier(.22,1,.36,1), box-shadow .3s ease; }
    .stc-card-lift:hover { transform: translateY(-6px); box-shadow: 0 20px 40px -10px rgba(0,0,0,.15); }
    @keyframes stcFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
    .stc-float { animation: stcFloat 3s ease-in-out infinite; }
    .sidebar-sticky { position: sticky; top: 96px; }
    .curriculum-item { border-left: 3px solid transparent; transition: all .2s ease; }
    .curriculum-item:hover { border-left-color: #F96302; background: rgba(249,99,2,0.04); }
    .tab-btn.active { background: #002046; color: #fff; }
    .tab-pane { display: none; }
    .tab-pane.active { display: block; }

    /* ── Breadcrumb dark bar ── */
    .detprog-breadcrumb-bar {
        background: linear-gradient(90deg, #0D1B2A 0%, #1b365d 100%);
        border-bottom: 1px solid rgba(249,99,2,.25);
    }

    /* ── Hero enhancements ── */
    .detprog-grid-pattern {
        background-image:
            linear-gradient(rgba(255,255,255,.035) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,.035) 1px, transparent 1px);
        background-size: 40px 40px;
    }

    /* ── Info pill hover ── */
    .detprog-pill {
        transition: background-color .2s, border-color .2s, transform .2s;
    }
    .detprog-pill:hover {
        background-color: rgba(249,99,2,.15);
        border-color: rgba(249,99,2,.5);
        transform: translateY(-2px);
    }

    /* ── Orange accent line pulse ── */
    @keyframes detprogLinePulse { 0%,100%{opacity:1} 50%{opacity:.45} }
    .detprog-accent-line { animation: detprogLinePulse 2.5s ease-in-out infinite; }

    /* ── Hero image frame ── */
    .detprog-img-frame {
        box-shadow: 0 0 0 1px rgba(255,255,255,.1), 0 25px 60px -15px rgba(0,0,0,.6);
    }
</style>

{{-- ═══════════════════════════════════════════════
     BREADCRUMB — dark bar
════════════════════════════════════════════════ --}}
<nav class="detprog-breadcrumb-bar pt-20" aria-label="Breadcrumb">
    <div class="max-w-container-max mx-auto px-gutter py-3">
        <ol class="flex items-center gap-2 text-xs font-semibold flex-wrap">
            <li>
                <a href="{{ route('home') }}" class="text-white/60 hover:text-safety-orange transition-colors flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm" aria-hidden="true">home</span>Home
                </a>
            </li>
            <span class="material-symbols-outlined text-sm text-white/30" aria-hidden="true">chevron_right</span>
            <li>
                <a href="{{ route('programs.index') }}" class="text-white/60 hover:text-safety-orange transition-colors">Program</a>
            </li>
            @if ($program->category)
                <span class="material-symbols-outlined text-sm text-white/30" aria-hidden="true">chevron_right</span>
                <li>
                    <a href="{{ route('programs.category', $program->category->slug) }}"
                       class="text-white/60 hover:text-safety-orange transition-colors">
                        {{ e($program->category->name) }}
                    </a>
                </li>
            @endif
            <span class="material-symbols-outlined text-sm text-white/30" aria-hidden="true">chevron_right</span>
            <li class="text-safety-orange font-bold">{{ e($program->title) }}</li>
        </ol>
    </div>
</nav>

{{-- ═══════════════════════════════════════════════
     HERO PROGRAM HEADER — dark theme
════════════════════════════════════════════════ --}}
<section
    class="relative w-full overflow-hidden bg-deep-slate"
    style="padding-top: 4rem; padding-bottom: 5rem;"
    aria-label="Detail Program"
>
    {{-- Background layers --}}
    <div class="absolute inset-0 z-0">
        <img
            src="{{ $program->thumbnail ? Storage::url($program->thumbnail) : asset('images/placeholder-program.jpg') }}"
            alt=""
            class="w-full h-full object-cover object-center opacity-20"
            loading="eager"
            aria-hidden="true"
        />
        {{-- Directional gradient: deep left → blue-tinted right --}}
        <div class="absolute inset-0"
             style="background: linear-gradient(135deg, rgba(13,27,42,.98) 0%, rgba(13,27,42,.88) 50%, rgba(27,54,93,.65) 80%, rgba(42,82,152,.35) 100%);"
             aria-hidden="true">
        </div>
        {{-- Decorative grid --}}
        <div class="detprog-grid-pattern absolute inset-0 pointer-events-none" aria-hidden="true"></div>
        {{-- Ambient glows --}}
        <div class="absolute -bottom-20 -right-20 w-[500px] h-[500px] bg-industrial-blue-light/15 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>
        <div class="absolute top-0 left-0 w-72 h-72 bg-safety-orange/5 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>
    </div>

    <div class="max-w-container-max mx-auto px-gutter relative z-10">
        <div class="grid lg:grid-cols-12 gap-10 items-center">

            {{-- Left: text --}}
            <div class="lg:col-span-7 space-y-5">

                {{-- Badges row --}}
                <div class="flex flex-wrap items-center gap-2">
                    @if ($program->is_featured)
                        <span class="inline-flex items-center gap-1 bg-safety-orange/20 border border-safety-orange/40 text-safety-orange text-xs font-bold px-3 py-1.5 rounded-full">
                            <span class="material-symbols-outlined text-sm" aria-hidden="true">star</span> Program Unggulan
                        </span>
                    @endif
                    @if ($program->category)
                        <span class="inline-flex items-center gap-1 bg-white/10 border border-white/20 text-white/70 text-xs font-semibold px-3 py-1.5 rounded-full">
                            <span class="material-symbols-outlined text-sm text-safety-orange/70" aria-hidden="true">{{ $program->category->icon ?? 'category' }}</span>
                            {{ e($program->category->name) }}
                        </span>
                    @endif
                </div>

                {{-- Orange accent line --}}
                <div class="w-12 h-1 bg-safety-orange rounded-full detprog-accent-line" aria-hidden="true"></div>

                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight">
                    {{ e($program->title) }}
                </h1>

                <p class="text-base md:text-lg text-white/70 max-w-2xl leading-relaxed">
                    {{ e($program->description) }}
                </p>

                {{-- Info pills --}}
                <div class="flex flex-wrap gap-3 pt-2">
                    <div class="detprog-pill flex items-center gap-2 bg-white/8 border border-white/15 backdrop-blur-sm px-4 py-2.5 rounded-lg">
                        <span class="material-symbols-outlined text-safety-orange text-xl" aria-hidden="true">schedule</span>
                        <span class="text-white text-sm font-semibold">{{ $program->duration ?? '3 Bulan' }}</span>
                    </div>
                    <div class="detprog-pill flex items-center gap-2 bg-white/8 border border-white/15 backdrop-blur-sm px-4 py-2.5 rounded-lg">
                        <span class="material-symbols-outlined text-safety-orange text-xl" aria-hidden="true">workspace_premium</span>
                        <span class="text-white text-sm font-semibold">Sertifikasi BNSP</span>
                    </div>
                    <div class="detprog-pill flex items-center gap-2 bg-white/8 border border-white/15 backdrop-blur-sm px-4 py-2.5 rounded-lg">
                        <span class="material-symbols-outlined text-safety-orange text-xl" aria-hidden="true">groups</span>
                        <span class="text-white text-sm font-semibold">Teori &amp; Praktik</span>
                    </div>
                </div>

                {{-- CTA buttons --}}
                <div class="flex flex-wrap gap-3 pt-1">
                    <a href="{{ route('contact.send') }}"
                       class="inline-flex items-center gap-2 bg-safety-orange hover:bg-orange-600 text-white font-bold px-7 py-3.5 rounded-lg transition-all duration-200 hover:-translate-y-0.5 shadow-lg hover:shadow-orange-500/30 text-sm">
                        <span class="material-symbols-outlined text-xl" aria-hidden="true">assignment_turned_in</span>
                        Daftar Sekarang
                    </a>
                    <a href="https://wa.me/628112021212?text=Saya+tertarik+dengan+program+{{ urlencode($program->title) }}"
                       target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 border border-white/25 hover:border-safety-orange text-white hover:text-safety-orange font-semibold px-7 py-3.5 rounded-lg transition-all duration-200 hover:-translate-y-0.5 text-sm backdrop-blur-sm">
                        <span class="material-symbols-outlined text-xl" aria-hidden="true">chat</span>
                        Tanya via WhatsApp
                    </a>
                </div>
            </div>

            {{-- Right: thumbnail image --}}
            <div class="lg:col-span-5 flex justify-center lg:justify-end">
                <div class="relative w-full max-w-md">
                    {{-- Decorative ring --}}
                    <div class="absolute -inset-3 border border-safety-orange/20 rounded-xl pointer-events-none" aria-hidden="true"></div>
                    <img
                        src="{{ $program->thumbnail ? Storage::url($program->thumbnail) : asset('images/placeholder-program.jpg') }}"
                        alt="{{ e($program->title) }}"
                        class="relative w-full h-72 object-cover rounded-xl detprog-img-frame"
                        loading="eager"
                    />
                    {{-- Level badge overlaid on image --}}
                    <div class="absolute -bottom-4 -left-4 bg-primary border border-white/10 px-4 py-2.5 rounded-xl shadow-xl z-10 flex items-center gap-2">
                        <span class="material-symbols-outlined text-safety-orange text-xl" aria-hidden="true">verified</span>
                        <div>
                            <p class="text-white text-xs font-bold leading-none">{{ $program->level ?? 'Operator' }}</p>
                            <p class="text-white/50 text-xs mt-0.5">Level Program</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom fade --}}
    <div class="absolute bottom-0 inset-x-0 h-10 bg-gradient-to-t from-surface-gray to-transparent pointer-events-none" aria-hidden="true"></div>
</section>

{{-- ═══════════════════════════════════════════════
     MAIN CONTENT + SIDEBAR
════════════════════════════════════════════════ --}}
<section class="py-16 md:py-20 bg-surface-gray" aria-label="Konten Detail Program">
    <div class="max-w-container-max mx-auto px-gutter grid grid-cols-1 lg:grid-cols-12 gap-8">

        {{-- Main Content --}}
        <main class="lg:col-span-8 flex flex-col gap-8">

            {{-- Tab Navigation --}}
            <div class="bg-surface-container-lowest rounded-lg shadow-sm border border-outline-variant/30 overflow-hidden">
                <div class="flex border-b border-outline-variant/30 overflow-x-auto" role="tablist" aria-label="Tab konten program">
                    <button class="tab-btn active px-6 py-4 text-sm font-bold whitespace-nowrap transition-all rounded-tl-lg" data-tab="overview" role="tab" aria-selected="true" aria-controls="tab-overview">
                        Overview
                    </button>
                    <button class="tab-btn px-6 py-4 text-sm font-bold whitespace-nowrap transition-all text-on-surface-variant hover:text-primary" data-tab="curriculum" role="tab" aria-selected="false" aria-controls="tab-curriculum">
                        Kurikulum
                    </button>
                    <button class="tab-btn px-6 py-4 text-sm font-bold whitespace-nowrap transition-all text-on-surface-variant hover:text-primary" data-tab="outcomes" role="tab" aria-selected="false" aria-controls="tab-outcomes">
                        Hasil Pembelajaran
                    </button>
                </div>

                {{-- Tab: Overview --}}
                <div id="tab-overview" class="tab-pane active p-8" role="tabpanel">
                    <h2 class="text-2xl font-bold text-primary mb-6 flex items-center gap-3">
                        <span class="material-symbols-outlined text-safety-orange" aria-hidden="true">info</span>
                        Tentang Program
                    </h2>
                    <p class="text-on-surface-variant text-base leading-relaxed mb-6">{{ e($program->description_long ?? $program->description) }}</p>

                    <h3 class="font-bold text-lg text-primary mt-8 mb-4">Target Peserta</h3>
                    <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @php $targets = $program->target_participants ?? ['Operator Industri', 'Teknisi Pemula', 'Supervisor Muda', 'Fresh Graduate Teknik']; @endphp
                        @foreach ($targets as $target)
                            <li class="flex items-start gap-3 bg-surface-gray p-3 rounded border border-surface-dim/50">
                                <span class="material-symbols-outlined text-primary text-xl flex-shrink-0 mt-0.5" aria-hidden="true">person</span>
                                <span class="text-sm text-on-surface-variant">{{ $target }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Tab: Curriculum --}}
                <div id="tab-curriculum" class="tab-pane p-8" role="tabpanel">
                    <h2 class="text-2xl font-bold text-primary mb-6 flex items-center gap-3">
                        <span class="material-symbols-outlined text-safety-orange" aria-hidden="true">menu_book</span>
                        Silabus &amp; Kurikulum
                    </h2>

                    <div class="space-y-4">
                        @forelse ($program->modules ?? [] as $i => $module)
                            <div class="curriculum-item p-5 rounded-lg bg-surface-container-lowest border border-outline-variant/20">
                                <div class="flex items-start gap-4">
                                    <span class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">{{ $i + 1 }}</span>
                                    <div>
                                        <h3 class="font-bold text-primary mb-1">{{ $module }}</h3>
                                        <p class="text-sm text-on-surface-variant">Materi praktis dan teori berstandar industri</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            @php
                                $defaultModules = [
                                    ['title'=>'Pengantar & Dasar-Dasar','desc'=>'Pengenalan terhadap sistem, alur proses, dan terminologi industri dasar.'],
                                    ['title'=>'Keselamatan Kerja Industri (K3)','desc'=>'Penerapan prosedur K3 di lingkungan kerja, identifikasi bahaya, dan penggunaan APD yang benar.'],
                                    ['title'=>'Pengoperasian Peralatan','desc'=>'Praktik langsung mengoperasikan peralatan standar, melakukan setup awal, dan perawatan rutin.'],
                                    ['title'=>'Quality Control Dasar','desc'=>'Metode pengecekan kualitas, penggunaan alat ukur, dan implementasi budaya kerja yang baik.'],
                                    ['title'=>'Evaluasi & Uji Kompetensi','desc'=>'Asesmen akhir program dan persiapan ujian sertifikasi BNSP.'],
                                ];
                            @endphp
                            @foreach ($defaultModules as $i => $m)
                                <div class="curriculum-item p-5 rounded-lg bg-surface-container-lowest border border-outline-variant/20">
                                    <div class="flex items-start gap-4">
                                        <span class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">{{ $i + 1 }}</span>
                                        <div>
                                            <h3 class="font-bold text-primary mb-1">{{ $m['title'] }}</h3>
                                            <p class="text-sm text-on-surface-variant">{{ $m['desc'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforelse
                    </div>
                </div>

                {{-- Tab: Outcomes --}}
                <div id="tab-outcomes" class="tab-pane p-8" role="tabpanel">
                    <h2 class="text-2xl font-bold text-primary mb-6 flex items-center gap-3">
                        <span class="material-symbols-outlined text-safety-orange" aria-hidden="true">emoji_events</span>
                        Hasil yang Dicapai
                    </h2>
                    <p class="text-sm text-on-surface-variant mb-6">Setelah menyelesaikan program ini, peserta mampu:</p>
                    <ul class="space-y-3">
                        @php
                            $outcomes = $program->learning_outcomes ?? [
                                'Mengoperasikan peralatan produksi sesuai SOP industri',
                                'Menerapkan prosedur K3 di area kerja',
                                'Melakukan quality control dasar secara mandiri',
                                'Berkomunikasi efektif dalam lingkungan industri',
                                'Lulus uji kompetensi dan mendapatkan sertifikasi BNSP',
                            ];
                        @endphp
                        @foreach ($outcomes as $outcome)
                            <li class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-safety-orange text-xl mt-0.5 flex-shrink-0" aria-hidden="true">check_circle</span>
                                <span class="text-on-surface-variant text-sm leading-relaxed">{{ $outcome }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </main>

        {{-- Sidebar --}}
        <aside class="lg:col-span-4">
            <div class="sidebar-sticky space-y-6">

                {{-- Registration Box --}}
                <div class="bg-primary rounded-xl p-6 text-on-primary shadow-lg">
                    <h3 class="font-bold text-base border-b border-white/20 pb-4 mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-safety-orange" aria-hidden="true">assignment</span>
                        Informasi Pendaftaran
                    </h3>

                    <p class="text-xs text-outline-variant uppercase tracking-wider font-semibold mb-1">Investasi Program</p>
                    <p class="text-3xl font-bold text-white">{{ $program->price_display ?? 'Hubungi Kami' }}</p>
                    <p class="text-xs text-outline mt-1 mb-6">*Termasuk biaya ujian BNSP</p>

                    <div class="space-y-3 text-sm text-outline-variant mb-6">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-safety-orange text-xl" aria-hidden="true">schedule</span>
                            <span><strong class="text-white">Durasi:</strong> {{ $program->duration ?? '3 Bulan' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-safety-orange text-xl" aria-hidden="true">groups</span>
                            <span><strong class="text-white">Metode:</strong> Teori &amp; Praktik</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-safety-orange text-xl" aria-hidden="true">workspace_premium</span>
                            <span><strong class="text-white">Sertifikat:</strong> BNSP Resmi</span>
                        </div>
                    </div>

                    <a href="{{ route('contact.send') }}"
                       class="w-full flex items-center justify-center gap-2 bg-safety-orange hover:bg-orange-600 text-white font-bold py-3.5 px-6 rounded-lg transition-all hover:-translate-y-0.5 shadow-lg mb-3">
                        <span class="material-symbols-outlined text-xl" aria-hidden="true">assignment_turned_in</span>
                        Daftar Sekarang
                    </a>
                    <a href="https://wa.me/628112021212?text=Saya+tertarik+dengan+program+{{ urlencode($program->title) }}"
                       target="_blank" rel="noopener noreferrer"
                       class="w-full flex items-center justify-center gap-2 bg-white/10 hover:bg-white/20 text-white font-semibold py-3 px-6 rounded-lg transition-all">
                        <span class="material-symbols-outlined text-xl" aria-hidden="true">chat</span>
                        Tanya via WhatsApp
                    </a>
                </div>

                {{-- Program Info Quick --}}
                <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/30">
                    <h3 class="font-bold text-sm text-on-surface mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-safety-orange text-xl" aria-hidden="true">info</span>
                        Info Program
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between py-2 border-b border-outline-variant/20">
                            <span class="text-on-surface-variant">Kategori</span>
                            <span class="font-semibold text-primary">{{ $program->category->name ?? 'Umum' }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-outline-variant/20">
                            <span class="text-on-surface-variant">Level</span>
                            <span class="font-semibold text-primary">{{ $program->level ?? 'Operator' }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-outline-variant/20">
                            <span class="text-on-surface-variant">Durasi</span>
                            <span class="font-semibold text-primary">{{ $program->duration ?? '3 Bulan' }}</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-on-surface-variant">Sertifikasi</span>
                            <span class="font-semibold text-safety-orange">BNSP</span>
                        </div>
                    </div>
                </div>

            </div>
        </aside>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     RELATED PROGRAMS
════════════════════════════════════════════════ --}}
<section class="py-16 bg-surface border-t border-surface-dim" aria-labelledby="related-programs-heading">
    <div class="max-w-container-max mx-auto px-gutter">
        <div class="flex items-end justify-between mb-8 stc-reveal">
            <div>
                <h2 id="related-programs-heading" class="text-2xl font-bold text-primary">Program Terkait</h2>
                <p class="text-on-surface-variant text-base mt-1">
                    Jelajahi program lain dalam kategori {{ $program->category->name ?? 'ini' }}
                </p>
            </div>
            @if ($program->category)
                <a href="{{ route('programs.category', $program->category->slug) }}"
                   class="text-primary font-bold text-sm flex items-center gap-1 hover:text-safety-orange transition-colors">
                    Lihat Semua <span class="material-symbols-outlined text-sm" aria-hidden="true">arrow_forward</span>
                </a>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse ($relatedPrograms as $related)
                <article class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all border border-outline-variant/20 flex flex-col stc-card-lift overflow-hidden">
                    <div class="relative h-40 overflow-hidden">
                        <img src="{{ $related->thumbnail ? Storage::url($related->thumbnail) : asset('images/placeholder-program.jpg') }}"
                             alt="{{ e($related->title) }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             loading="lazy" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="font-bold text-base text-primary mb-2">{{ e($related->title) }}</h3>
                        <p class="text-on-surface-variant text-sm mb-4 flex-grow leading-relaxed">{{ Str::limit($related->description, 80) }}</p>
                        <a href="{{ route('programs.show', $related->slug) }}"
                           class="inline-flex items-center gap-2 text-primary hover:text-safety-orange font-bold text-sm transition-colors">
                            Lihat Detail <span class="material-symbols-outlined text-sm" aria-hidden="true">arrow_forward</span>
                        </a>
                    </div>
                </article>
            @empty
                @php
                    $dummyRelated = [
                        ['title'=>'Lean Manufacturing Basic','desc'=>'Pelajari konsep eliminasi pemborosan (waste) untuk meningkatkan efisiensi proses produksi.'],
                        ['title'=>'Implementasi 5S di Industri','desc'=>'Panduan praktis menata area kerja untuk menciptakan lingkungan pabrik yang aman dan produktif.'],
                        ['title'=>'Teknisi Perawatan Dasar','desc'=>'Keterampilan perawatan preventif mekanikal dan elektrikal dasar untuk teknisi pemula.'],
                    ];
                @endphp
                @foreach ($dummyRelated as $dr)
                    <article class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all border border-outline-variant/20 flex flex-col stc-card-lift">
                        <div class="h-40 bg-surface-gray rounded-t-xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-outline" style="font-size:48px" aria-hidden="true">image</span>
                        </div>
                        <div class="p-5 flex flex-col flex-grow">
                            <h3 class="font-bold text-base text-primary mb-2">{{ $dr['title'] }}</h3>
                            <p class="text-on-surface-variant text-sm mb-4 flex-grow leading-relaxed">{{ $dr['desc'] }}</p>
                            <a href="#" class="inline-flex items-center gap-2 text-primary hover:text-safety-orange font-bold text-sm transition-colors">
                                Lihat Detail <span class="material-symbols-outlined text-sm" aria-hidden="true">arrow_forward</span>
                            </a>
                        </div>
                    </article>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

@endsection

@push('scripts')
    @vite(['resources/js/detail_program.js'])
@endpush