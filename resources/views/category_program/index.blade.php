{{-- resources/views/category_program/index.blade.php --}}
@extends('layouts.app')

@section('title', e($category->name) . ' - Program STC Indonesia')

@section('content')

<style>
    .stc-reveal { opacity: 0; transform: translateY(40px); transition: opacity 0.7s cubic-bezier(.22,1,.36,1), transform 0.7s cubic-bezier(.22,1,.36,1); }
    .stc-reveal.visible { opacity: 1; transform: none; }
    .stc-card-lift { transition: transform .3s cubic-bezier(.22,1,.36,1), box-shadow .3s ease; }
    .stc-card-lift:hover { transform: translateY(-6px); box-shadow: 0 20px 40px -10px rgba(0,0,0,.15); }
    @keyframes stcFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
    .stc-float { animation: stcFloat 3s ease-in-out infinite; }
    .sidebar-sticky { position: sticky; top: 96px; }
    .module-badge { transition: all .2s; }
    .module-badge:hover { transform: translateX(4px); }

    /* ── Hero dark gradient overlay ── */
    .catpage-hero-overlay {
        background: linear-gradient(
            135deg,
            rgba(13,27,42,.97) 0%,
            rgba(13,27,42,.88) 45%,
            rgba(42,82,152,.55) 80%,
            transparent 100%
        );
    }

    /* ── Breadcrumb dark bar ── */
    .catpage-breadcrumb-bar {
        background: linear-gradient(90deg, #0D1B2A 0%, #1b365d 100%);
        border-bottom: 1px solid rgba(249,99,2,.25);
    }

    /* ── Decorative grid pattern ── */
    .catpage-grid-pattern {
        background-image:
            linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px);
        background-size: 40px 40px;
    }

    /* ── Stat pill glow on hover ── */
    .catpage-stat-pill {
        transition: background-color .25s, border-color .25s, transform .25s;
    }
    .catpage-stat-pill:hover {
        background-color: rgba(249,99,2,.15);
        border-color: rgba(249,99,2,.5);
        transform: translateY(-2px);
    }

    /* ── Orange accent line pulse ── */
    @keyframes catpageLinePulse {
        0%,100% { opacity: 1; } 50% { opacity: .5; }
    }
    .catpage-accent-line { animation: catpageLinePulse 2.5s ease-in-out infinite; }
</style>

{{-- ═══════════════════════════════════════════════
     BREADCRUMB — dark bar
════════════════════════════════════════════════ --}}
<nav class="catpage-breadcrumb-bar pt-20" aria-label="Breadcrumb">
    <div class="max-w-container-max mx-auto px-gutter py-3">
        <ol class="flex items-center gap-2 text-xs font-semibold" itemscope itemtype="https://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a href="{{ route('home') }}" itemprop="item"
                   class="text-white/60 hover:text-safety-orange transition-colors flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm" aria-hidden="true">home</span>
                    <span itemprop="name">Home</span>
                </a>
                <meta itemprop="position" content="1" />
            </li>
            <span class="material-symbols-outlined text-sm text-white/30" aria-hidden="true">chevron_right</span>
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a href="{{ route('programs.index') }}" itemprop="item"
                   class="text-white/60 hover:text-safety-orange transition-colors">
                    <span itemprop="name">Program</span>
                </a>
                <meta itemprop="position" content="2" />
            </li>
            <span class="material-symbols-outlined text-sm text-white/30" aria-hidden="true">chevron_right</span>
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <span itemprop="name" class="text-safety-orange font-bold">{{ e($category->name) }}</span>
                <meta itemprop="position" content="3" />
            </li>
        </ol>
    </div>
</nav>

{{-- ═══════════════════════════════════════════════
     HERO CATEGORY BANNER — dark theme
════════════════════════════════════════════════ --}}
<section
    class="relative overflow-hidden bg-deep-slate"
    style="min-height: 420px;"
    aria-label="Header Kategori"
>
    {{-- Background image with dark overlay --}}
    <div class="absolute inset-0 z-0">
        <img
            src="{{ $category->thumbnail ? Storage::url($category->thumbnail) : asset('images/placeholder-category.jpg') }}"
            alt=""
            class="w-full h-full object-cover object-center opacity-30"
            loading="eager"
            aria-hidden="true"
        />
        <div class="catpage-hero-overlay absolute inset-0" aria-hidden="true"></div>

        {{-- Decorative grid overlay --}}
        <div class="catpage-grid-pattern absolute inset-0 pointer-events-none" aria-hidden="true"></div>

        {{-- Subtle blue glow blob --}}
        <div class="absolute -bottom-16 -right-16 w-96 h-96 bg-industrial-blue-light/20 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>
        <div class="absolute top-0 left-0 w-64 h-64 bg-safety-orange/5 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>
    </div>

    {{-- Content --}}
    <div class="relative z-10 max-w-container-max mx-auto px-gutter py-16 md:py-20 grid md:grid-cols-2 gap-10 items-center">

        {{-- Left: text --}}
        <div class="flex flex-col justify-center">
            {{-- Category badge --}}
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/8 border border-white/15 mb-5 w-fit backdrop-blur-sm">
                <span class="material-symbols-outlined text-safety-orange text-sm" aria-hidden="true">{{ $category->icon ?? 'category' }}</span>
                <span class="text-white/80 text-xs font-bold uppercase tracking-wider">Kategori Program</span>
            </div>

            {{-- Orange accent line --}}
            <div class="w-12 h-1 bg-safety-orange rounded-full mb-5 catpage-accent-line" aria-hidden="true"></div>

            <h1 class="text-4xl md:text-5xl font-bold text-white mb-5 leading-tight">
                {{ e($category->name) }}
            </h1>

            <p class="text-base text-white/70 mb-8 leading-relaxed max-w-lg">
                {{ e($category->description) }}
            </p>

            {{-- CTA buttons --}}
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('contact.send') }}"
                   class="inline-flex items-center gap-2 bg-safety-orange hover:bg-orange-600 text-white font-bold px-6 py-3 rounded-lg transition-all duration-200 hover:-translate-y-0.5 shadow-lg hover:shadow-orange-500/30 text-sm">
                    <span class="material-symbols-outlined text-lg" aria-hidden="true">assignment_turned_in</span>
                    Daftar Sekarang
                </a>
                <a href="https://wa.me/628112021212" target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-2 border border-white/25 hover:border-safety-orange text-white hover:text-safety-orange font-semibold px-6 py-3 rounded-lg transition-all duration-200 hover:-translate-y-0.5 text-sm backdrop-blur-sm">
                    <span class="material-symbols-outlined text-lg" aria-hidden="true">chat</span>
                    Konsultasi WA
                </a>
            </div>
        </div>

        {{-- Right: stats pills --}}
        <div class="flex flex-col gap-4 md:items-end">
            {{-- Large stat display --}}
            <div class="grid grid-cols-3 gap-3 w-full md:max-w-xs">
                <div class="catpage-stat-pill bg-white/8 border border-white/15 backdrop-blur-sm px-4 py-4 rounded-xl text-center">
                    <p class="text-2xl font-bold text-safety-orange leading-none mb-1">{{ $programs->total() }}</p>
                    <p class="text-white/60 text-xs leading-tight mt-1">Program<br>Tersedia</p>
                </div>
                <div class="catpage-stat-pill bg-white/8 border border-white/15 backdrop-blur-sm px-4 py-4 rounded-xl text-center">
                    <p class="text-xl font-bold text-white leading-none mb-1">{{ $category->duration ?? '12 Hari' }}</p>
                    <p class="text-white/60 text-xs leading-tight mt-1">Durasi<br>Pelatihan</p>
                </div>
                <div class="catpage-stat-pill bg-white/8 border border-white/15 backdrop-blur-sm px-4 py-4 rounded-xl text-center">
                    <p class="text-xl font-bold text-white leading-none mb-1">{{ $category->certification ?? 'BNSP' }}</p>
                    <p class="text-white/60 text-xs leading-tight mt-1">Sertifikasi<br>Resmi</p>
                </div>
            </div>

            {{-- Decorative card --}}
            <div class="bg-white/6 border border-white/10 backdrop-blur-sm rounded-xl p-5 w-full md:max-w-xs">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-safety-orange/20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-safety-orange text-xl" aria-hidden="true">workspace_premium</span>
                    </div>
                    <div>
                        <p class="text-white font-bold text-sm">Diakui Secara Nasional</p>
                        <p class="text-white/55 text-xs">BNSP &amp; Kemnaker RI</p>
                    </div>
                </div>
                @php
                    $heroBadges = ['BNSP Certified', 'Kemnaker RI', 'ISO Standard'];
                @endphp
                <div class="flex flex-wrap gap-2">
                    @foreach ($heroBadges as $b)
                        <span class="px-2.5 py-1 bg-white/10 border border-white/20 rounded-full text-xs text-white/75 font-semibold">{{ $b }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom fade into page background --}}
    <div class="absolute bottom-0 inset-x-0 h-12 bg-gradient-to-t from-surface-container-lowest to-transparent pointer-events-none" aria-hidden="true"></div>
</section>

{{-- ═══════════════════════════════════════════════
     MAIN CONTENT: PROGRAM LIST + SIDEBAR
════════════════════════════════════════════════ --}}
<div class="max-w-container-max mx-auto px-gutter grid grid-cols-1 lg:grid-cols-12 gap-8 my-12">

    {{-- Programs List Column --}}
    <div class="lg:col-span-8 flex flex-col gap-8">

        {{-- Category Overview Card --}}
        <section class="bg-surface-container-lowest rounded-lg p-8 shadow-sm border border-outline-variant/30 stc-reveal" aria-labelledby="category-overview-heading">
            <h2 id="category-overview-heading" class="text-2xl font-bold text-primary mb-6 flex items-center gap-3">
                <span class="material-symbols-outlined text-safety-orange" aria-hidden="true">info</span>
                Tentang Kategori Ini
            </h2>
            <p class="text-on-surface-variant text-base leading-relaxed mb-6">{{ e($category->description_long ?? $category->description) }}</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                <div class="bg-surface-gray p-5 rounded border-l-4 border-primary">
                    <span class="material-symbols-outlined text-primary mb-2 block" aria-hidden="true">group</span>
                    <h3 class="font-bold text-primary mb-1">Target Peserta</h3>
                    <p class="text-sm text-on-surface-variant">{{ $category->target_participant ?? 'Operator, Teknisi, & Supervisor Muda' }}</p>
                </div>
                <div class="bg-surface-gray p-5 rounded border-l-4 border-safety-orange">
                    <span class="material-symbols-outlined text-safety-orange mb-2 block" aria-hidden="true">schedule</span>
                    <h3 class="font-bold text-primary mb-1">Durasi</h3>
                    <p class="text-sm text-on-surface-variant">{{ $category->duration ?? '1–12 Hari (Teori & Praktik Intensif)' }}</p>
                </div>
                <div class="bg-surface-gray p-5 rounded border-l-4 border-industrial-blue-light">
                    <span class="material-symbols-outlined text-industrial-blue-light mb-2 block" aria-hidden="true">workspace_premium</span>
                    <h3 class="font-bold text-primary mb-1">Sertifikasi</h3>
                    <p class="text-sm text-on-surface-variant">{{ $category->certification_body ?? 'BNSP Kompetensi Nasional' }}</p>
                </div>
            </div>
        </section>

        {{-- Programs in Category --}}
        <section aria-labelledby="program-list-heading">
            <h2 id="program-list-heading" class="text-2xl font-bold text-primary mb-6 flex items-center gap-3">
                <span class="material-symbols-outlined text-safety-orange" aria-hidden="true">menu_book</span>
                Program dalam Kategori Ini
                <span class="text-sm font-normal text-on-surface-variant ml-auto">({{ $programs->total() }} program)</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse ($programs as $program)
                    <article class="bg-surface-container-lowest p-6 rounded-lg shadow-sm border border-outline-variant/30 hover:shadow-md transition-shadow group relative overflow-hidden flex flex-col h-full stc-card-lift">
                        <div class="absolute top-0 right-0 w-16 h-16 bg-surface-gray rounded-bl-full -z-10 group-hover:bg-primary-fixed/20 transition-colors" aria-hidden="true"></div>

                        @if ($program->is_featured)
                            <span class="absolute top-3 left-3 bg-safety-orange text-white text-xs font-bold px-2 py-1 rounded-full flex items-center gap-1 z-10">
                                <span class="material-symbols-outlined text-xs" aria-hidden="true">star</span> Unggulan
                            </span>
                        @endif

                        <div class="w-10 h-10 bg-primary/5 rounded-lg flex items-center justify-center mb-3 group-hover:bg-safety-orange/10 transition-colors">
                            <span class="material-symbols-outlined text-primary group-hover:text-safety-orange transition-colors" aria-hidden="true">{{ $program->icon ?? 'school' }}</span>
                        </div>

                        <h3 class="font-bold text-base text-primary mb-2 flex justify-between items-start gap-2">
                            {{ e($program->title) }}
                        </h3>
                        <p class="text-sm text-on-surface-variant mb-4 flex-grow leading-relaxed">{{ Str::limit($program->description, 100) }}</p>

                        <div class="flex items-center justify-between mt-auto pt-4 border-t border-outline-variant/30">
                            <span class="text-xs text-on-surface-variant flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm text-safety-orange" aria-hidden="true">schedule</span>
                                {{ $program->duration ?? 'Lihat Detail' }}
                            </span>
                            <a href="{{ route('programs.show', $program->slug) }}"
                               class="inline-flex items-center gap-1 text-primary font-bold text-xs uppercase hover:text-safety-orange transition-colors group/link">
                                Detail
                                <span class="material-symbols-outlined text-sm transition-transform group-hover/link:translate-x-1" aria-hidden="true">arrow_forward</span>
                            </a>
                        </div>
                    </article>
                @empty
                    {{-- Dummy programs if empty --}}
                    @php
                        $dummyPrograms = [
                            ['title'=>'Operator Produksi Industri','desc'=>'Pelatihan intensif mencetak operator mesin produksi yang kompeten dan memahami alur kerja standar industri.','duration'=>'3 Bulan'],
                            ['title'=>'Dasar-Dasar Proses Manufaktur','desc'=>'Kursus komprehensif mengenai dasar-dasar proses manufaktur dari pengolahan bahan baku hingga produk jadi.','duration'=>'1 Bulan'],
                            ['title'=>'Manajemen Lini Produksi','desc'=>'Program spesialisasi dalam manajemen sistem lini produksi dan sinkronisasi antar departemen.','duration'=>'2 Bulan'],
                            ['title'=>'Lean Manufacturing Basic','desc'=>'Pelatihan mendalam tentang implementasi prinsip produksi ramping untuk mengidentifikasi dan menghilangkan pemborosan.','duration'=>'5 Hari'],
                            ['title'=>'Quality Control & Assurance','desc'=>'Sertifikasi teknik inspeksi, pengujian, dan kontrol kualitas produk sesuai standar industri ketat.','duration'=>'2 Minggu'],
                            ['title'=>'Total Quality Management','desc'=>'Program berfokus pada sistem manajemen mutu dan penjaminan kualitas menyeluruh sesuai standar ISO.','duration'=>'1 Minggu'],
                        ];
                    @endphp
                    @foreach ($dummyPrograms as $dp)
                        <article class="bg-surface-container-lowest p-6 rounded-lg shadow-sm border border-outline-variant/30 hover:shadow-md transition-shadow group relative overflow-hidden flex flex-col h-full stc-card-lift">
                            <div class="absolute top-0 right-0 w-16 h-16 bg-surface-gray rounded-bl-full -z-10 group-hover:bg-primary-fixed/20 transition-colors" aria-hidden="true"></div>
                            <div class="w-10 h-10 bg-primary/5 rounded-lg flex items-center justify-center mb-3 group-hover:bg-safety-orange/10 transition-colors">
                                <span class="material-symbols-outlined text-primary group-hover:text-safety-orange transition-colors" aria-hidden="true">school</span>
                            </div>
                            <h3 class="font-bold text-base text-primary mb-2">{{ $dp['title'] }}</h3>
                            <p class="text-sm text-on-surface-variant mb-4 flex-grow leading-relaxed">{{ $dp['desc'] }}</p>
                            <div class="flex items-center justify-between mt-auto pt-4 border-t border-outline-variant/30">
                                <span class="text-xs text-on-surface-variant flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm text-safety-orange" aria-hidden="true">schedule</span>
                                    {{ $dp['duration'] }}
                                </span>
                                <a href="#" class="inline-flex items-center gap-1 text-primary font-bold text-xs uppercase hover:text-safety-orange transition-colors group/link">
                                    Detail <span class="material-symbols-outlined text-sm transition-transform group-hover/link:translate-x-1" aria-hidden="true">arrow_forward</span>
                                </a>
                            </div>
                        </article>
                    @endforeach
                @endforelse
            </div>

            {{-- Pagination --}}
            @if ($programs->hasPages())
                <div class="mt-8">{{ $programs->links() }}</div>
            @endif
        </section>
    </div>

    {{-- Sidebar --}}
    <aside class="lg:col-span-4">
        <div class="sidebar-sticky space-y-6">

            {{-- Registration CTA --}}
            <div class="bg-primary rounded-xl p-6 text-on-primary shadow-lg">
                <h3 class="font-bold text-base border-b border-white/20 pb-4 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-safety-orange" aria-hidden="true">assignment</span>
                    Informasi Pendaftaran
                </h3>
                <p class="text-xs text-outline-variant uppercase tracking-wider font-semibold mb-1">Investasi Program</p>
                <p class="text-3xl font-bold text-white mb-1">{{ $category->price_display ?? 'Hubungi Kami' }}</p>
                <p class="text-xs text-outline mt-1 mb-6">*Termasuk biaya ujian sertifikasi</p>

                <div class="space-y-3 mb-6">
                    @php
                        $outcomes = $category->learning_outcomes ?? [
                            'Memahami proses industri secara menyeluruh',
                            'Mampu mengoperasikan peralatan standar industri',
                            'Menerapkan budaya K3 di tempat kerja',
                            'Lulus uji kompetensi BNSP',
                        ];
                    @endphp
                    <h4 class="font-bold text-sm mb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-safety-orange text-sm" aria-hidden="true">emoji_events</span>
                        Hasil yang Dicapai
                    </h4>
                    @foreach ($outcomes as $outcome)
                        <p class="flex items-start gap-3 text-sm text-surface-variant">
                            <span class="material-symbols-outlined text-safety-orange text-xl mt-0.5 flex-shrink-0" aria-hidden="true">check_circle</span>
                            {{ $outcome }}
                        </p>
                    @endforeach
                </div>

                <a href="{{ route('contact.send') }}"
                   class="w-full flex items-center justify-center gap-2 bg-safety-orange hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-lg transition-all hover:-translate-y-0.5 shadow-lg">
                    <span class="material-symbols-outlined text-xl" aria-hidden="true">assignment_turned_in</span>
                    Daftar Program Ini
                </a>
                <a href="https://wa.me/628112021212" target="_blank" rel="noopener noreferrer"
                   class="w-full flex items-center justify-center gap-2 bg-white/10 hover:bg-white/20 text-white font-semibold py-3 px-6 rounded-lg transition-all mt-3">
                    <span class="material-symbols-outlined text-xl" aria-hidden="true">chat</span>
                    Konsultasi via WhatsApp
                </a>
            </div>

            {{-- Other Categories --}}
            <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/30">
                <h3 class="font-bold text-base text-on-surface border-b border-outline-variant/30 pb-4 mb-4">
                    Kategori Program Lain
                </h3>
                <ul class="space-y-2">
                    @foreach ($otherCategories as $otherCat)
                        <li>
                            <a href="{{ route('programs.category', $otherCat->slug) }}"
                               class="flex items-center gap-3 p-3 rounded-lg hover:bg-surface-gray transition-colors group {{ $otherCat->slug === $category->slug ? 'bg-primary/5 text-primary' : 'text-on-surface-variant' }}">
                                <span class="material-symbols-outlined text-safety-orange text-xl" aria-hidden="true">{{ $otherCat->icon ?? 'category' }}</span>
                                <span class="text-sm font-semibold group-hover:text-primary transition-colors">{{ e($otherCat->name) }}</span>
                                <span class="ml-auto material-symbols-outlined text-sm text-outline" aria-hidden="true">chevron_right</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Contact Info --}}
            <div class="bg-surface-gray rounded-xl p-6">
                <h3 class="font-bold text-sm text-on-surface mb-4">Hubungi Kami</h3>
                <div class="space-y-3 text-sm text-on-surface-variant">
                    <p class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-safety-orange text-xl" aria-hidden="true">call</span>
                        <a href="tel:+628112021212" class="hover:text-primary transition-colors">0811-2021-212</a>
                    </p>
                    <p class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-safety-orange text-xl" aria-hidden="true">mail</span>
                        <a href="mailto:info@stc-subang.com" class="hover:text-primary transition-colors">info@stc-subang.com</a>
                    </p>
                    <p class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-safety-orange text-xl mt-0.5" aria-hidden="true">location_on</span>
                        <span>Jl. Palabuan No.9, Subang, Jawa Barat</span>
                    </p>
                </div>
            </div>

        </div>
    </aside>
</div>

@endsection

@push('scripts')
    @vite(['resources/js/category_program.js'])
@endpush