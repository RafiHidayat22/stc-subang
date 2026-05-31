{{-- resources/views/category_certification/index.blade.php --}}
@extends('layouts.app')

@section('title', e($category->name ?? 'Kategori Sertifikasi') . ' - STC Indonesia')

@section('content')

<style>
    .stc-reveal { opacity: 0; transform: translateY(40px); transition: opacity 0.7s cubic-bezier(.22,1,.36,1), transform 0.7s cubic-bezier(.22,1,.36,1); }
    .stc-reveal.visible { opacity: 1; transform: none; }
    .stc-card-lift { transition: transform .3s cubic-bezier(.22,1,.36,1), box-shadow .3s ease; }
    .stc-card-lift:hover { transform: translateY(-6px); box-shadow: 0 20px 40px -10px rgba(0,0,0,.15); }
    @keyframes stcFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
    .stc-float { animation: stcFloat 3s ease-in-out infinite; }

    /* ── Breadcrumb dark bar ── */
    .catpage-breadcrumb-bar {
        background: linear-gradient(90deg, #0D1B2A 0%, #1b365d 100%);
        border-bottom: 1px solid rgba(249,99,2,.25);
    }
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
                <a href="{{ route('certification.index') }}" itemprop="item"
                   class="text-white/60 hover:text-safety-orange transition-colors">
                    <span itemprop="name">Sertifikasi</span>
                </a>
                <meta itemprop="position" content="2" />
            </li>
            <span class="material-symbols-outlined text-sm text-white/30" aria-hidden="true">chevron_right</span>
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <span itemprop="name" class="text-safety-orange font-bold">{{ e($category->name ?? 'Kategori') }}</span>
                <meta itemprop="position" content="3" />
            </li>
        </ol>
    </div>
</nav>


{{-- ================================================================
     HERO SECTION
================================================================ --}}
<section class="relative bg-deep-slate text-on-primary overflow-hidden">
    {{-- Background image --}}
    @if (!empty($category->cover_image))
        <div class="absolute inset-0 bg-cover bg-center opacity-20"
             style="background-image: url('{{ Storage::url($category->cover_image) }}')"
             aria-hidden="true"></div>
    @else
        <div class="absolute inset-0 bg-cover bg-center opacity-20"
             style="background-image: url('{{ asset('images/certification/hero-bg.jpg') }}')"
             aria-hidden="true"></div>
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-deep-slate via-deep-slate/80 to-transparent" aria-hidden="true"></div>
    <div class="absolute inset-0 opacity-5 pointer-events-none" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 20px 20px;" aria-hidden="true"></div>

    <div class="relative z-10 w-full px-gutter max-w-container-max mx-auto py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <div class="flex items-center gap-3 cert-reveal">
                    <span class="inline-flex items-center gap-2 bg-safety-orange/20 text-safety-orange font-label-sm text-label-sm px-4 py-1.5 rounded-full uppercase tracking-widest border border-safety-orange/30">
                        <span class="material-symbols-outlined text-base" aria-hidden="true">{{ $category->badge_icon ?? 'verified' }}</span>
                        {{ $category->badge_label ?? 'Sertifikasi' }}
                    </span>
                </div>
                <h1 class="font-display-lg text-4xl md:text-[52px] leading-tight text-white cert-reveal" style="transition-delay:.1s">
                    {{ e($category->name ?? 'Kategori Sertifikasi') }}
                </h1>
                <p class="font-body-lg text-body-lg text-surface-variant max-w-xl cert-reveal" style="transition-delay:.2s">
                    {{ $category->description ?? 'Program sertifikasi kompetensi profesi yang diakui secara nasional.' }}
                </p>
                <div class="flex flex-wrap gap-4 pt-4 cert-reveal" style="transition-delay:.3s">
                    <a href="#programs" class="bg-safety-orange hover:bg-orange-600 text-white px-8 py-3.5 rounded-lg font-bold transition-all duration-200 hover:-translate-y-1 shadow-xl flex items-center gap-2">
                        <span class="material-symbols-outlined text-xl" aria-hidden="true">workspace_premium</span>
                        Lihat Program Sertifikasi
                    </a>
                    <a href="{{ route('certification.index') }}" class="border-2 border-white/40 hover:bg-white/10 text-white px-8 py-3.5 rounded-lg font-bold transition-all duration-200 hover:-translate-y-1 flex items-center gap-2">
                        <span class="material-symbols-outlined text-xl" aria-hidden="true">arrow_back</span>
                        Semua Kategori
                    </a>
                </div>
            </div>

            {{-- Stats panel --}}
            <div class="hidden lg:block cert-reveal" style="transition-delay:.4s">
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-8 space-y-6">
                    <h3 class="font-title-md text-title-md text-white border-b border-white/10 pb-4">Statistik Program</h3>
                    @php
                        $itemCount = isset($category->items) ? $category->items->count() : 0;
                    @endphp
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center">
                            <p class="text-3xl font-bold text-safety-orange">{{ $itemCount ?: '10+' }}</p>
                            <p class="text-sm text-surface-variant mt-1">Program Sertifikasi</p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-bold text-safety-orange">98%</p>
                            <p class="text-sm text-surface-variant mt-1">Pass Rate</p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-bold text-safety-orange">5000+</p>
                            <p class="text-sm text-surface-variant mt-1">Alumni Tersertifikasi</p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-bold text-safety-orange">15+</p>
                            <p class="text-sm text-surface-variant mt-1">Tahun Pengalaman</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ================================================================
     CATEGORY NAVIGATION (sidebar pills)
================================================================ --}}
<div class="bg-surface-container-lowest border-b border-outline-variant/30 sticky top-20 z-30 shadow-sm">
    <div class="w-full px-gutter max-w-container-max mx-auto">
        <div class="flex items-center gap-3 overflow-x-auto py-3 scrollbar-hide" role="navigation" aria-label="Kategori Sertifikasi">
            <span class="text-xs font-bold uppercase tracking-widest text-on-surface-variant shrink-0">Kategori:</span>
            @foreach ($allCategories as $cat)
                <a href="{{ route('certification.category', $cat->slug) }}"
                   class="shrink-0 px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200 border
                          {{ $cat->slug === $category->slug
                             ? 'bg-primary text-on-primary border-primary'
                             : 'bg-transparent text-on-surface-variant border-outline-variant hover:border-primary hover:text-primary' }}">
                    {{ e($cat->name) }}
                </a>
            @endforeach
        </div>
    </div>
</div>


{{-- ================================================================
     BENEFIT CARDS
================================================================ --}}
<section class="py-stack-lg bg-surface cert-section">
    <div class="w-full px-gutter max-w-container-max mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 cert-stagger">
            @php
                $benefits = [
                    ['icon' => 'verified',              'color' => 'border-industrial-blue-light', 'title' => 'Pengakuan Nasional',  'desc' => 'Sertifikat kompetensi yang diakui secara nasional oleh negara melalui Badan Nasional Sertifikasi Profesi (BNSP).'],
                    ['icon' => 'trending_up',            'color' => 'border-safety-orange',         'title' => 'Daya Saing Tinggi',   'desc' => 'Meningkatkan nilai jual dan daya saing tenaga kerja di pasar industri nasional maupun multinasional.'],
                    ['icon' => 'precision_manufacturing','color' => 'border-industrial-blue-light', 'title' => 'Relevansi Industri',  'desc' => 'Mendukung kebutuhan industri secara presisi terhadap SDM yang kompeten di bidang terkait.'],
                ];
            @endphp
            @foreach ($benefits as $b)
                <div class="bg-surface-container-lowest rounded-lg p-6 shadow-md border-t-4 {{ $b['color'] }} flex flex-col gap-4">
                    <div class="w-12 h-12 rounded-full bg-surface-gray flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[28px]" aria-hidden="true">{{ $b['icon'] }}</span>
                    </div>
                    <h3 class="font-title-md text-title-md text-on-surface">{{ $b['title'] }}</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant">{{ $b['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ================================================================
     DAFTAR PROGRAM SERTIFIKASI
================================================================ --}}
<section id="programs" class="py-stack-lg bg-surface-gray cert-section">
    <div class="w-full px-gutter max-w-container-max mx-auto">

        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4 cert-reveal">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="material-symbols-outlined text-safety-orange text-2xl" aria-hidden="true">workspace_premium</span>
                    <span class="text-safety-orange font-bold tracking-widest text-sm uppercase">Program Sertifikasi</span>
                </div>
                <h2 class="font-headline-lg text-headline-lg text-primary">{{ e($category->name ?? 'Daftar Sertifikasi') }}</h2>
            </div>

            {{-- Search / Filter --}}
            <div class="flex items-center gap-3">
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-xl" aria-hidden="true">search</span>
                    <input
                        type="search"
                        id="cert-search"
                        placeholder="Cari program..."
                        class="pl-10 pr-4 py-2.5 border border-outline-variant rounded-lg text-sm focus:outline-none focus:border-primary bg-white w-64"
                        aria-label="Cari program sertifikasi"
                    />
                </div>
            </div>
        </div>

        {{-- Dummy items (akan diganti data dari $category->items) --}}
        @php
            $dummyItems = [
                ['slug' => 'basic-electrical', 'name' => 'Basic Electrical Training', 'code' => 'BNSP-EL-001', 'issuer' => 'BNSP', 'level' => 'Teknisi', 'duration' => '4 Hari', 'badge_color' => 'bg-blue-600', 'icon' => 'electric_bolt', 'topics' => ['Basic Electrical Knowledge', 'Industrial Electrical System', 'PLC Basic', 'Electrical Safety'], 'is_featured' => true],
                ['slug' => 'motor-control',     'name' => 'Motor Control & Automation', 'code' => 'BNSP-EL-002', 'issuer' => 'BNSP', 'level' => 'Teknisi', 'duration' => '5 Hari', 'badge_color' => 'bg-blue-600', 'icon' => 'settings_motion_mode', 'topics' => ['Motor Control', 'PLC Advanced', 'SCADA System', 'Electrical Safety'], 'is_featured' => false],
                ['slug' => 'ahli-k3-umum',     'name' => 'Ahli K3 Umum', 'code' => 'KMK-K3-001', 'issuer' => 'Kemnaker RI', 'level' => 'Profesional', 'duration' => '12 Hari', 'badge_color' => 'bg-green-700', 'icon' => 'health_and_safety', 'topics' => ['Perundangan K3', 'Manajemen Risiko', 'Inspeksi K3', 'Audit SMK3'], 'is_featured' => true],
                ['slug' => 'authorized-gas-tester', 'name' => 'Authorized Gas Tester', 'code' => 'BNSP-GT-001', 'issuer' => 'LSP Promigas', 'level' => 'Spesialis', 'duration' => '3 Hari', 'badge_color' => 'bg-amber-600', 'icon' => 'air', 'topics' => ['Gas Detection', 'Confined Space', 'H2S Safety', 'Emergency Response'], 'is_featured' => false],
                ['slug' => 'scaffolding-operator', 'name' => 'Operator Scaffolding', 'code' => 'BNSP-SC-001', 'issuer' => 'BNSP & Kemnaker', 'level' => 'Operator', 'duration' => '5 Hari', 'badge_color' => 'bg-primary', 'icon' => 'architecture', 'topics' => ['Instalasi Perancah', 'Inspeksi Scaffolding', 'Working at Heights', 'Fall Protection'], 'is_featured' => false],
                ['slug' => 'rigger-banksman',   'name' => 'Rigger / Banksman', 'code' => 'BNSP-RG-001', 'issuer' => 'BNSP', 'level' => 'Spesialis', 'duration' => '4 Hari', 'badge_color' => 'bg-blue-600', 'icon' => 'hvac', 'topics' => ['Teknik Rigging', 'Angkat Beban Aman', 'Crane Coordination', 'Load Calculation'], 'is_featured' => false],
            ];
            $displayItems = (isset($category->items) && $category->items->isNotEmpty())
                ? $category->items
                : collect($dummyItems);
        @endphp

        <div id="cert-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 cert-stagger">
            @foreach ($displayItems as $item)
                @php
                    $isModel    = $item instanceof \App\Models\CertificationItem;
                    $itemSlug   = $isModel ? $item->slug        : $item['slug'];
                    $itemName   = $isModel ? $item->name        : $item['name'];
                    $itemCode   = $isModel ? $item->code        : $item['code'];
                    $itemIssuer = $isModel ? $item->issuer      : $item['issuer'];
                    $itemLevel  = $isModel ? $item->level       : $item['level'];
                    $itemDur    = $isModel ? $item->duration    : $item['duration'];
                    $itemColor  = $isModel ? ($item->badge_color ?? 'bg-blue-600') : ($item['badge_color'] ?? 'bg-blue-600');
                    $itemIcon   = $isModel ? ($item->icon ?? 'workspace_premium')  : ($item['icon'] ?? 'workspace_premium');
                    $itemTopics = $isModel ? ($item->topics ?? []) : ($item['topics'] ?? []);
                    $isFeatured = $isModel ? $item->is_featured  : ($item['is_featured'] ?? false);
                @endphp

                <article
                    class="cert-card group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-outline-variant/30 flex flex-col"
                    data-name="{{ strtolower($itemName) }}"
                    data-code="{{ strtolower($itemCode ?? '') }}"
                >
                    {{-- Card Header --}}
                    <div class="relative bg-primary px-6 pt-6 pb-10">
                        <div class="flex items-start justify-between mb-4">
                            <span class="{{ $itemColor }} text-white text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs" aria-hidden="true">verified</span>
                                {{ e($itemIssuer ?? '') }}
                            </span>
                            @if ($isFeatured)
                                <span class="bg-safety-orange text-white text-xs font-bold px-2 py-1 rounded-full flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs" aria-hidden="true">star</span> Unggulan
                                </span>
                            @endif
                        </div>
                        <span class="material-symbols-outlined text-safety-orange/60 group-hover:text-safety-orange transition-colors" style="font-size: 40px" aria-hidden="true">{{ $itemIcon }}</span>
                        <p class="text-white/50 text-xs font-mono tracking-widest mt-2">{{ $itemCode }}</p>

                        {{-- Curved bottom --}}
                        <div class="absolute bottom-0 left-0 right-0 h-8 bg-white rounded-t-[2rem]" aria-hidden="true"></div>
                    </div>

                    {{-- Card Body --}}
                    <div class="px-6 pt-2 pb-6 flex flex-col flex-grow">
                        <h3 class="font-title-md text-title-md text-primary mb-1 leading-snug">{{ e($itemName) }}</h3>

                        <div class="flex items-center gap-3 text-xs text-on-surface-variant mb-4 mt-1">
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-base text-industrial-blue-light" aria-hidden="true">military_tech</span>
                                {{ e($itemLevel ?? '') }}
                            </span>
                            <span class="w-1 h-1 rounded-full bg-outline-variant" aria-hidden="true"></span>
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-base text-industrial-blue-light" aria-hidden="true">schedule</span>
                                {{ e($itemDur ?? '') }}
                            </span>
                        </div>

                        <ul class="space-y-1.5 mb-5 flex-grow" role="list">
                            @foreach (array_slice((array) $itemTopics, 0, 4) as $topic)
                                <li class="flex items-center gap-2 text-sm text-on-surface-variant">
                                    <span class="material-symbols-outlined text-safety-orange text-[18px] shrink-0" aria-hidden="true">check_circle</span>
                                    {{ e($topic) }}
                                </li>
                            @endforeach
                        </ul>

                        <a href="{{ route('certification.show', $itemSlug) }}"
                           class="mt-auto inline-flex items-center justify-center gap-2 w-full bg-surface-gray hover:bg-primary hover:text-white text-primary font-semibold py-3 px-4 rounded-lg transition-all duration-200 border border-outline-variant/50 group-hover:border-primary">
                            Detail Sertifikasi
                            <span class="material-symbols-outlined text-xl" aria-hidden="true">arrow_forward</span>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        {{-- Empty state --}}
        <div id="cert-empty" class="hidden text-center py-20">
            <span class="material-symbols-outlined text-outline-variant" style="font-size:64px" aria-hidden="true">search_off</span>
            <p class="text-on-surface-variant mt-4 font-semibold">Program tidak ditemukan.</p>
        </div>
    </div>
</section>


{{-- ================================================================
     CTA SECTION
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
    @vite(['resources/js/certification.js'])
@endpush