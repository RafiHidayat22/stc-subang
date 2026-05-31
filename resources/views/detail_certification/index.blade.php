{{-- resources/views/detail_certification/index.blade.php --}}
@extends('layouts.app')

@section('title', e($item->name ?? 'Detail Sertifikasi') . ' - STC Indonesia')

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
            @if ($item->category)
                <span class="material-symbols-outlined text-sm text-white/30" aria-hidden="true">chevron_right</span>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a href="{{ route('certification.category', $item->category->slug) }}" itemprop="item"
                       class="text-white/60 hover:text-safety-orange transition-colors">
                        <span itemprop="name">{{ e($item->category->name) }}</span>
                    </a>
                    <meta itemprop="position" content="3" />
                </li>
                <span class="material-symbols-outlined text-sm text-white/30" aria-hidden="true">chevron_right</span>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <span itemprop="name" class="text-safety-orange font-bold truncate max-w-[200px]">{{ e($item->name ?? '') }}</span>
                    <meta itemprop="position" content="4" />
                </li>
            @else
                <span class="material-symbols-outlined text-sm text-white/30" aria-hidden="true">chevron_right</span>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <span itemprop="name" class="text-safety-orange font-bold truncate max-w-[200px]">{{ e($item->name ?? '') }}</span>
                    <meta itemprop="position" content="3" />
                </li>
            @endif
        </ol>
    </div>
</nav>


{{-- ================================================================
     HERO SECTION
================================================================ --}}
<section class="relative bg-deep-slate text-on-primary overflow-hidden pb-24 md:pb-32">
    <div class="absolute inset-0 bg-gradient-to-r from-deep-slate via-primary to-industrial-blue-light opacity-90 z-0" aria-hidden="true"></div>
    {{-- Dot pattern --}}
    <div class="absolute inset-0 z-0 opacity-10 pointer-events-none"
         style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 20px 20px;"
         aria-hidden="true"></div>

    <div class="relative z-10 w-full px-gutter max-w-container-max mx-auto py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            {{-- Left: Info --}}
            <div class="space-y-6">
                <div class="flex items-center gap-4 cert-reveal">
                    <span class="bg-surface-container-lowest text-primary px-3 py-1.5 rounded-full font-label-sm uppercase tracking-wider flex items-center gap-2 shadow-sm text-xs">
                        <span class="material-symbols-outlined text-[16px] text-safety-orange" aria-hidden="true">workspace_premium</span>
                        {{ e($item->issuer ?? 'Sertifikasi') }}
                    </span>
                    @if (!empty($item->badge_label))
                        <div class="bg-white rounded px-3 py-1 flex items-center justify-center shadow-sm">
                            <span class="font-title-md text-sm font-bold text-primary">{{ e($item->badge_label) }}</span>
                        </div>
                    @endif
                </div>

                <h1 class="font-display-lg text-4xl md:text-[52px] leading-tight text-white cert-reveal" style="transition-delay:.1s">
                    {{ e($item->name ?? 'Sertifikasi') }}
                    @if (!empty($item->level))
                        <span class="text-safety-orange">{{ e($item->level) }}</span>
                    @endif
                </h1>

                <p class="font-body-lg text-body-lg text-surface-variant max-w-xl cert-reveal" style="transition-delay:.2s">
                    {{ $item->description ?? 'Pelatihan teknis dan sertifikasi kompetensi untuk mendukung kebutuhan industri. Mengacu pada standar yang ditetapkan oleh lembaga berwenang.' }}
                </p>

                <div class="flex flex-wrap gap-4 pt-4 cert-reveal" style="transition-delay:.3s">
                    <a href="#registration" class="bg-safety-orange text-white font-bold py-3 px-8 rounded-lg hover:bg-orange-600 transition-colors shadow-md flex items-center gap-2">
                        Daftar Sertifikasi
                        <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span>
                    </a>
                    <button
                        id="btn-download-syllabus"
                        class="bg-transparent border-2 border-outline-variant text-white font-bold py-3 px-8 rounded-lg hover:bg-white/10 transition-colors flex items-center gap-2"
                    >
                        Unduh Silabus
                        <span class="material-symbols-outlined" aria-hidden="true">download</span>
                    </button>
                </div>
            </div>

            {{-- Right: Cover image --}}
            <div class="hidden lg:block relative cert-reveal" style="transition-delay:.4s">
                <div class="absolute -top-4 -right-4 w-24 h-24 bg-safety-orange/20 rounded-full blur-xl" aria-hidden="true"></div>
                <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-industrial-blue-light/30 rounded-full blur-2xl" aria-hidden="true"></div>
                <div class="bg-surface-container-lowest rounded-lg p-2 shadow-2xl relative z-10 border border-outline-variant/20 transform rotate-2 hover:rotate-0 transition-transform duration-500">
                    @if ($item->cover_image)
                        <img
                            src="{{ Storage::url($item->cover_image) }}"
                            alt="{{ e($item->name) }}"
                            class="rounded w-full h-auto object-cover aspect-[4/3]"
                            loading="lazy"
                        />
                    @else
                        <div class="rounded w-full aspect-[4/3] bg-primary-container flex items-center justify-center">
                            <span class="material-symbols-outlined text-safety-orange" style="font-size: 80px" aria-hidden="true">{{ $item->icon ?? 'workspace_premium' }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ================================================================
     BENEFIT OVERVIEW CARDS (overlap hero)
================================================================ --}}
<section class="py-stack-lg bg-surface relative -mt-10 z-20">
    <div class="w-full px-gutter max-w-container-max mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 cert-stagger">
            @php
                $benefits = [
                    ['icon' => 'verified',               'color' => 'border-industrial-blue-light', 'title' => 'Pengakuan Nasional',  'desc' => 'Sertifikat kompetensi yang diakui secara nasional melalui lembaga sertifikasi resmi pemerintah.'],
                    ['icon' => 'trending_up',             'color' => 'border-safety-orange',         'title' => 'Daya Saing Tinggi',   'desc' => 'Meningkatkan nilai jual dan daya saing tenaga kerja di pasar industri nasional maupun multinasional.'],
                    ['icon' => 'precision_manufacturing', 'color' => 'border-industrial-blue-light', 'title' => 'Relevansi Industri',  'desc' => 'Mendukung kebutuhan industri secara presisi terhadap SDM yang kompeten di bidang ini.'],
                ];
            @endphp
            @foreach ($benefits as $b)
                <div class="bg-surface-container-lowest rounded-lg p-6 shadow-md border-t-4 {{ $b['color'] }} flex flex-col gap-4">
                    <div class="w-12 h-12 rounded-full bg-primary-container/10 flex items-center justify-center text-primary">
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
     MAIN CONTENT + SIDEBAR
================================================================ --}}
<section class="py-stack-lg bg-surface-gray cert-section">
    <div class="w-full px-gutter max-w-container-max mx-auto">
        <div class="flex flex-col lg:flex-row gap-12">

            {{-- ── LEFT: Curriculum & Description ───────────────────────── --}}
            <div class="lg:w-2/3 space-y-10">

                {{-- Description --}}
                <div class="bg-surface-container-lowest rounded-lg p-8 shadow-md cert-reveal">
                    <h2 class="font-headline-lg text-headline-lg text-primary mb-6 flex items-center gap-3">
                        <span class="material-symbols-outlined text-industrial-blue-light text-[32px]" aria-hidden="true">menu_book</span>
                        Deskripsi Program
                    </h2>
                    <div class="space-y-4 font-body-md text-body-md text-on-surface-variant leading-relaxed">
                        @if ($item->description)
                            <p>{{ $item->description }}</p>
                        @else
                            <p>STC Indonesia menyediakan pelatihan persiapan sertifikasi kompetensi profesi yang mengacu pada standar lembaga sertifikasi resmi. Program <strong>{{ e($item->name) }}</strong> ini dirancang khusus untuk memberikan pemahaman teknis fundamental yang dibutuhkan industri.</p>
                            <p>Pelatihan ini mencakup teori dasar hingga aplikasi praktis dalam lingkungan industri, membekali peserta dengan keterampilan krusial untuk bekerja dengan aman dan efisien. Lulusan program ini dipersiapkan untuk memenuhi standar kompetensi yang diwajibkan oleh industri modern.</p>
                        @endif
                    </div>
                </div>

                {{-- Materi Sertifikasi (Unit Kompetensi) --}}
                <div class="cert-reveal">
                    <h2 class="font-headline-lg text-headline-lg text-primary mb-6">Materi Sertifikasi (Unit Kompetensi)</h2>

                    @php
                        $modules = (!empty($item->modules)) ? $item->modules : [
                            ['icon' => 'electric_bolt',          'title' => 'Modul Dasar / Teori Fundamental',  'description' => 'Konsep dan teori dasar yang menjadi landasan kompetensi di bidang ini.'],
                            ['icon' => 'precision_manufacturing', 'title' => 'Sistem & Peralatan Industri',      'description' => 'Pengenalan sistem dan peralatan yang digunakan dalam lingkungan industri.'],
                            ['icon' => 'memory',                  'title' => 'Teknologi & Otomasi',              'description' => 'Penerapan teknologi dan otomasi modern dalam konteks pekerjaan.'],
                            ['icon' => 'settings_motion_mode',    'title' => 'Kontrol & Pengendalian',           'description' => 'Sistem pengendalian dan kontrol yang digunakan di lapangan.'],
                            ['icon' => 'electrical_services',     'title' => 'Instalasi & Konfigurasi',          'description' => 'Teknik instalasi dan konfigurasi sesuai standar keselamatan industri.'],
                            ['icon' => 'speed',                   'title' => 'Instrumentasi & Pengukuran',       'description' => 'Pengenalan instrumen ukur, sensor, dan transmitter di lapangan.'],
                            ['icon' => 'health_and_safety',       'title' => 'Safety & K3 (Critical Module)',    'description' => 'Prosedur K3, LOTO, dan pencegahan bahaya dalam pekerjaan industri. (Critical Module)'],
                        ];
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($modules as $index => $mod)
                            @php
                                $isString   = is_string($mod);
                                $modTitle   = $isString ? $mod                        : ($mod['title']       ?? '');
                                $modDesc    = $isString ? ''                          : ($mod['description'] ?? '');
                                $modIcon    = $isString ? 'check_circle'              : ($mod['icon']        ?? 'check_circle');
                                $isCritical  = str_contains(strtolower($modTitle . $modDesc), 'safety')
                                            || str_contains(strtolower($modTitle . $modDesc), 'k3')
                                            || str_contains(strtolower($modTitle . $modDesc), 'critical');
                                $isFullWidth = $isCritical && $index === count($modules) - 1;
                            @endphp

                            @if ($isFullWidth)
                                <div class="md:col-span-2 bg-primary rounded-lg p-5 flex gap-4 items-start border-l-4 border-safety-orange">
                                    <div class="w-10 h-10 rounded-lg bg-safety-orange flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-white text-[22px]" aria-hidden="true">{{ $modIcon }}</span>
                                    </div>
                                    <div>
                                        <h4 class="text-[15px] font-bold text-white mb-1 leading-snug">{{ $modTitle }}</h4>
                                        <p class="text-[13px] text-white/75 leading-relaxed">{{ $modDesc }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="bg-white rounded-lg p-5 flex gap-4 items-start border border-gray-200 border-l-4 border-l-industrial-blue-light hover:shadow-md hover:border-l-safety-orange transition-all duration-200 group">
                                    <div class="w-10 h-10 rounded-lg bg-primary flex items-center justify-center shrink-0 group-hover:bg-safety-orange transition-colors duration-200">
                                        <span class="material-symbols-outlined text-white text-[22px]" aria-hidden="true">{{ $modIcon }}</span>
                                    </div>
                                    <div>
                                        <h4 class="text-[15px] font-bold mb-1 leading-snug" style="color: #111827;">{{ $modTitle }}</h4>
                                        <p class="text-[13px] leading-relaxed" style="color: #6b7280;">{{ $modDesc }}</p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

            </div>{{-- /left --}}


            {{-- ── RIGHT: Sticky Sidebar ─────────────────────────────────── --}}
            <div class="lg:w-1/3">
                <div class="sticky top-24 space-y-6">

                    {{-- Registration Card --}}
                    <div id="registration" class="bg-surface-container-lowest rounded-lg border border-outline-variant/30 shadow-lg overflow-hidden cert-reveal">
                        <div class="bg-deep-slate p-6 text-center border-b-4 border-safety-orange">
                            <h3 class="font-headline-lg text-headline-lg text-white mb-1">Jadwal Terdekat</h3>
                            @php
                                $schedules  = $item->schedule_info ?? [];
                                $firstSched = collect($schedules)->firstWhere('status', 'open') ?? ($schedules[0] ?? []);
                                $batch      = $firstSched['batch']    ?? 'Batch Terbaru';
                                $date       = $firstSched['date']     ?? 'Hubungi kami untuk jadwal';
                                $location   = 'STC Main Facility, Subang';
                                $quota      = $firstSched['quota']    ?? null;
                            @endphp
                            <p class="font-body-md text-surface-variant text-sm">{{ $batch }} — Subang Training Center</p>
                        </div>
                        <div class="p-6 space-y-5">
                            <div class="flex items-center gap-4 text-on-surface">
                                <span class="material-symbols-outlined text-industrial-blue-light" aria-hidden="true">calendar_month</span>
                                <div>
                                    <p class="font-label-sm uppercase text-outline text-xs">Tanggal Pelaksanaan</p>
                                    <p class="font-title-md font-bold">{{ $date }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 text-on-surface">
                                <span class="material-symbols-outlined text-industrial-blue-light" aria-hidden="true">schedule</span>
                                <div>
                                    <p class="font-label-sm uppercase text-outline text-xs">Durasi</p>
                                    <p class="font-title-md font-bold">{{ e($item->duration ?? 'Hubungi kami') }}</p>
                                </div>
                            </div>
                            @if ($quota)
                                <div class="flex items-center gap-4 text-on-surface">
                                    <span class="material-symbols-outlined text-industrial-blue-light" aria-hidden="true">group</span>
                                    <div>
                                        <p class="font-label-sm uppercase text-outline text-xs">Kuota</p>
                                        <p class="font-title-md font-bold">{{ $quota }} Peserta</p>
                                    </div>
                                </div>
                            @endif
                            <div class="flex items-center gap-4 text-on-surface">
                                <span class="material-symbols-outlined text-industrial-blue-light" aria-hidden="true">location_on</span>
                                <div>
                                    <p class="font-label-sm uppercase text-outline text-xs">Lokasi</p>
                                    <p class="font-title-md font-bold">{{ $location }}</p>
                                </div>
                            </div>
                            @if (count($schedules) > 1)
                                <div class="pt-2 border-t border-outline-variant/20">
                                    <p class="text-xs uppercase text-outline font-semibold mb-2">Semua Batch Tersedia</p>
                                    <div class="space-y-1.5">
                                        @foreach ($schedules as $sched)
                                            <div class="flex items-center justify-between text-xs">
                                                <span class="font-semibold" style="color:#1e3a5f">{{ $sched['batch'] ?? '' }}</span>
                                                <span style="color:#6b7280">{{ $sched['date'] ?? '' }}</span>
                                                <span class="px-2 py-0.5 rounded-full text-white text-[10px] font-bold {{ ($sched['status'] ?? '') === 'open' ? 'bg-green-600' : 'bg-gray-400' }}">
                                                    {{ strtoupper($sched['status'] ?? 'open') }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <div class="pt-4 border-t border-outline-variant/30 space-y-3">
                                <a href="tel:+62811202121"
                                   class="w-full bg-industrial-blue-light text-white font-bold py-3 px-4 rounded hover:bg-primary transition-colors flex items-center justify-center gap-2">
                                    Daftar Sekarang
                                    <span class="material-symbols-outlined text-[20px]" aria-hidden="true">how_to_reg</span>
                                </a>
                                <a href="https://wa.me/62811202121" target="_blank" rel="noopener"
                                   class="w-full bg-transparent border border-industrial-blue-light text-industrial-blue-light font-bold py-3 px-4 rounded hover:bg-industrial-blue-light/5 transition-colors flex items-center justify-center gap-2">
                                    Konsultasi Program
                                    <span class="material-symbols-outlined text-[20px]" aria-hidden="true">chat</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Requirements Card --}}
                    <div class="bg-surface-container-lowest rounded-lg p-6 border border-outline-variant/30 shadow-md cert-reveal">
                        <h3 class="font-title-md text-title-md text-primary font-bold mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-safety-orange" aria-hidden="true">checklist</span>
                            Persyaratan Peserta
                        </h3>
                        <ul class="space-y-3 font-body-md text-[14px] text-on-surface-variant">
                            @php
                                $requirements = (!empty($item->requirements)) ? $item->requirements : [
                                    'Minimal pendidikan SMK/D3 atau setara di bidang terkait.',
                                    'Memiliki pengalaman kerja minimal 1 tahun di bidang yang relevan.',
                                    'Sehat jasmani dan rohani (surat keterangan sehat).',
                                    'Fotokopi KTP, Ijazah terakhir, dan pas foto latar merah.',
                                ];
                            @endphp
                            @foreach ($requirements as $req)
                                <li class="flex items-start gap-2">
                                    <span class="material-symbols-outlined text-[18px] text-industrial-blue-light mt-0.5 shrink-0" aria-hidden="true">check_circle</span>
                                    {{ e(is_array($req) ? ($req['label'] ?? implode('', $req)) : $req) }}
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Category link card --}}
                    @if ($item->category)
                        <div class="bg-surface-container-lowest rounded-lg p-5 border border-outline-variant/30 flex items-center gap-4 cert-reveal">
                            <div class="w-12 h-12 rounded-full bg-safety-orange/10 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-safety-orange text-2xl" aria-hidden="true">category</span>
                            </div>
                            <div class="flex-grow min-w-0">
                                <p class="text-xs text-on-surface-variant uppercase tracking-wider">Kategori</p>
                                <p class="font-bold text-primary text-sm truncate">{{ e($item->category->name) }}</p>
                            </div>
                            <a href="{{ route('certification.category', $item->category->slug) }}"
                               class="shrink-0 text-safety-orange hover:text-orange-600 transition-colors"
                               aria-label="Lihat semua sertifikasi {{ $item->category->name }}">
                                <span class="material-symbols-outlined text-xl" aria-hidden="true">arrow_forward</span>
                            </a>
                        </div>
                    @endif

                </div>
            </div>{{-- /right --}}

        </div>
    </div>
</section>


{{-- ================================================================
     RELATED CERTIFICATIONS
================================================================ --}}
@if ($relatedItems->isNotEmpty())
    <section class="py-stack-lg bg-surface-container-lowest cert-section">
        <div class="w-full px-gutter max-w-container-max mx-auto">
            <div class="mb-10 cert-reveal">
                <div class="flex items-center gap-2 mb-2">
                    <span class="material-symbols-outlined text-safety-orange text-2xl" aria-hidden="true">workspace_premium</span>
                    <span class="text-safety-orange font-bold tracking-widest text-sm uppercase">Program Terkait</span>
                </div>
                <h2 class="font-headline-lg text-headline-lg text-primary">Sertifikasi Lainnya</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 cert-stagger">
                @foreach ($relatedItems as $related)
                    <article class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-outline-variant/30 flex flex-col">
                        <div class="bg-primary px-6 py-6 flex items-center gap-4">
                            <span class="material-symbols-outlined text-safety-orange text-4xl" aria-hidden="true">{{ $related->icon ?? 'workspace_premium' }}</span>
                            <div>
                                <p class="text-white/50 text-xs font-mono">{{ $related->code }}</p>
                                <p class="text-xs text-safety-orange font-semibold">{{ $related->issuer }}</p>
                            </div>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="font-title-md text-title-md text-primary mb-2 leading-snug">{{ e($related->name) }}</h3>
                            <p class="text-sm text-on-surface-variant mb-4 flex-grow">{{ Str::limit($related->description, 100) }}</p>
                            <a href="{{ route('certification.show', $related->slug) }}"
                               class="inline-flex items-center gap-2 text-safety-orange font-bold text-sm hover:gap-4 transition-all duration-200">
                                Detail Program
                                <span class="material-symbols-outlined text-xl" aria-hidden="true">arrow_forward</span>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif


{{-- ================================================================
     CTA
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