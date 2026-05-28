{{-- resources/views/home/index.blade.php --}}
@extends('layouts.app')

@section('content')

{{-- ================================================================
     GLOBAL ANIMATION STYLES
================================================================ --}}
<style>
    /* ── Scroll reveal ── */
    .stc-reveal {
        opacity: 0;
        transform: translateY(40px);
        transition: opacity 0.7s cubic-bezier(.22,1,.36,1), transform 0.7s cubic-bezier(.22,1,.36,1);
    }
    .stc-reveal.visible {
        opacity: 1;
        transform: none;
    }
    .stc-reveal-left  { opacity: 0; transform: translateX(-50px); transition: opacity 0.7s cubic-bezier(.22,1,.36,1), transform 0.7s cubic-bezier(.22,1,.36,1); }
    .stc-reveal-right { opacity: 0; transform: translateX(50px);  transition: opacity 0.7s cubic-bezier(.22,1,.36,1), transform 0.7s cubic-bezier(.22,1,.36,1); }
    .stc-reveal-left.visible, .stc-reveal-right.visible { opacity: 1; transform: none; }

    /* staggered children */
    .stc-stagger > * { opacity: 0; transform: translateY(30px); transition: opacity 0.6s cubic-bezier(.22,1,.36,1), transform 0.6s cubic-bezier(.22,1,.36,1); }
    .stc-stagger.visible > *:nth-child(1) { opacity:1; transform:none; transition-delay:.05s }
    .stc-stagger.visible > *:nth-child(2) { opacity:1; transform:none; transition-delay:.15s }
    .stc-stagger.visible > *:nth-child(3) { opacity:1; transform:none; transition-delay:.25s }
    .stc-stagger.visible > *:nth-child(4) { opacity:1; transform:none; transition-delay:.35s }
    .stc-stagger.visible > *:nth-child(5) { opacity:1; transform:none; transition-delay:.45s }
    .stc-stagger.visible > *:nth-child(6) { opacity:1; transform:none; transition-delay:.55s }

    /* ── Floating badge shimmer ── */
    @keyframes stcShimmer {
        0%   { background-position: -400px 0 }
        100% { background-position: 400px 0 }
    }

    /* ── Pulsing ring on hero card ── */
    @keyframes stcRingPulse {
        0%,100% { opacity:.3; transform:scale(1) }
        50%      { opacity:.7; transform:scale(1.04) }
    }
    .stc-ring-pulse { animation: stcRingPulse 3s ease-in-out infinite }

    /* ── Icon float bounce ── */
    @keyframes stcFloat {
        0%,100% { transform: translateY(0) }
        50%      { transform: translateY(-8px) }
    }
    .stc-float { animation: stcFloat 3s ease-in-out infinite }

    /* ── Counter number ── */
    @keyframes stcCountUp { from { opacity:0; transform:scale(.8) } to { opacity:1; transform:scale(1) } }

    /* ── Divider line draw ── */
    @keyframes stcLineDraw { from { width:0 } to { width:5rem } }
    .stc-line-draw.visible { animation: stcLineDraw .7s .3s cubic-bezier(.22,1,.36,1) forwards }

    /* ── Card hover lift ── */
    .stc-card-lift { transition: transform .3s cubic-bezier(.22,1,.36,1), box-shadow .3s ease }
    .stc-card-lift:hover { transform: translateY(-6px); box-shadow: 0 20px 40px -10px rgba(0,0,0,.15) }

    /* ── Sertifikasi card glow border ── */
    .stc-sert-card { transition: transform .35s cubic-bezier(.22,1,.36,1), border-color .3s ease, box-shadow .3s ease }
    .stc-sert-card:hover { transform: translateY(-8px); border-color: rgba(var(--color-safety-orange-rgb,234,88,12),.5); box-shadow: 0 0 30px -5px rgba(234,88,12,.25) }

    /* ── Why-us icon spin on hover ── */
    .stc-why-card:hover .stc-spin-icon { animation: stcSpinOnce .5s ease }
    @keyframes stcSpinOnce { 0%{transform:rotate(0deg)} 100%{transform:rotate(360deg)} }

    /* ── Scroll indicator bounce ── */
    @keyframes stcBounce { 0%,100%{transform:translateY(0)} 50%{transform:translateY(6px)} }
    .stc-scroll-bounce { animation: stcBounce 1.4s ease-in-out infinite }

    /* ── Progress bar fill ── */
    @keyframes stcBarFill { from { width:0 } to { width:98% } }

    /* ── Badge pill shimmer ── */
    .stc-badge-shimmer {
        background: linear-gradient(90deg, #ea580c 30%, #fb923c 50%, #ea580c 70%);
        background-size: 400px 100%;
        animation: stcShimmer 2.5s infinite linear;
    }

    /* ── Testimonial quote mark ── */
    @keyframes stcQuoteFade { from { opacity:0; transform:scale(.5) } to { opacity:.18; transform:scale(1) } }
    .stc-quote-reveal.visible .stc-quote-icon { animation: stcQuoteFade .6s .3s ease forwards }

    /* ── CTA section background wave ── */
    @keyframes stcWave { 0%,100%{ border-radius:60% 40% 30% 70%/60% 30% 70% 40% } 50%{ border-radius:30% 60% 70% 40%/50% 60% 30% 60% } }
    .stc-blob { position:absolute; inset:0; background:rgba(255,255,255,.05); animation:stcWave 8s ease-in-out infinite; pointer-events:none }

    /* ── Gallery overlay slide ── */
    .stc-gallery-item .stc-gallery-overlay { transition: opacity .4s ease, transform .4s ease; opacity:0; transform:translateY(10px) }
    .stc-gallery-item:hover .stc-gallery-overlay { opacity:1; transform:translateY(0) }
</style>

{{-- ================================================================
     HERO SECTION
================================================================ --}}
<section
    id="hero"
    class="relative min-h-screen flex items-center pt-20 overflow-hidden"
    aria-label="Hero Section"
>
    <div class="absolute inset-0 z-0">
        <img
            src="{{ asset('images/hero-industrial.jpg') }}"
            alt="Suasana pelatihan industri STC Indonesia"
            class="w-full h-full object-cover"
            loading="eager"
            fetchpriority="high"
        />
        <div class="absolute inset-0 bg-gradient-to-r from-primary/95 via-primary/75 to-primary/20" aria-hidden="true"></div>
        <div id="hero-particles" class="absolute inset-0 pointer-events-none" aria-hidden="true"></div>
    </div>

    <div class="relative z-10 w-full px-gutter max-w-container-max mx-auto grid md:grid-cols-2 gap-12 py-16">
        <div class="text-on-primary space-y-stack-md">
            <span class="home-hero-badge stc-badge-shimmer inline-block px-4 py-1.5 text-white text-sm font-bold rounded-full tracking-wide uppercase opacity-0 translate-y-6 transition-all duration-700">
                Pusat Pelatihan Industri Terpadu
            </span>
            <h1 class="home-hero-title text-3xl md:text-[42px] font-bold leading-tight opacity-0 translate-y-6 transition-all duration-700 delay-100">
                Mencetak Tenaga Kerja Industri yang
                <span class="text-safety-orange">Kompeten</span>,
                Profesional, dan Siap Kerja
            </h1>
            <p class="home-hero-desc text-base leading-relaxed text-outline-variant max-w-xl opacity-0 translate-y-6 transition-all duration-700 delay-200">
                Subang Training Center hadir untuk mempersiapkan SDM unggul di bidang industri, otomotif, manufaktur, energi, dan oil &amp; gas melalui pelatihan berbasis kompetensi dan kebutuhan industri modern.
            </p>
            <div class="home-hero-cta flex flex-wrap gap-4 pt-6 opacity-0 translate-y-6 transition-all duration-700 delay-300">
                <a href="#programs" class="bg-safety-orange hover:bg-orange-600 text-white px-8 py-3.5 rounded-lg text-base font-bold transition-all duration-200 shadow-xl hover:shadow-orange-500/30 hover:-translate-y-1 active:translate-y-0 flex items-center gap-2">
                    <span class="material-symbols-outlined text-xl" aria-hidden="true">school</span>
                    Lihat Program Training
                </a>
                <a href="#why-us" class="border-2 border-white hover:bg-white hover:text-primary text-white px-8 py-3.5 rounded-lg text-base font-bold transition-all duration-200 hover:-translate-y-1 flex items-center gap-2">
                    Keunggulan Kami
                </a>
            </div>

            {{-- Stats row --}}
            <div class="home-hero-stats flex flex-wrap gap-10 pt-8 opacity-0 translate-y-6 transition-all duration-700 delay-[400ms]">
                @php
                    $stats = [
                        ['value' => '5000+', 'label' => 'Alumni Bersertifikat', 'icon' => 'groups'],
                        ['value' => '50+',   'label' => 'Program Pelatihan',    'icon' => 'menu_book'],
                        ['value' => '98%',   'label' => 'Compliance Rate',      'icon' => 'verified'],
                    ];
                @endphp
                @foreach ($stats as $stat)
                    <div class="text-center">
                        <span class="material-symbols-outlined text-2xl text-safety-orange/70 block mb-1" aria-hidden="true">{{ $stat['icon'] }}</span>
                        <p class="text-2xl font-bold text-safety-orange">{{ $stat['value'] }}</p>
                        <p class="text-sm text-outline-variant mt-1">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Right: Floating card --}}
        <div class="hidden md:flex items-center justify-center">
            <div class="home-hero-card relative w-full aspect-square max-w-md opacity-0 translate-x-8 transition-all duration-700 delay-500">
                <div class="absolute -inset-4 border-2 border-safety-orange/30 rounded-xl stc-ring-pulse" aria-hidden="true"></div>
                <div class="absolute inset-0 bg-surface-container-lowest/10 backdrop-blur-md rounded-xl border border-white/20 p-8 shadow-2xl flex flex-col justify-end">
                    <div class="mb-auto">
                        <span class="material-symbols-outlined text-safety-orange stc-float block mb-4" style="font-size:56px" aria-hidden="true">verified</span>
                        <p class="text-white text-lg font-bold mb-2">Diakui Secara Nasional</p>
                        <p class="text-outline-variant text-sm">Sertifikasi BNSP &amp; Kemnaker RI</p>
                    </div>
                    <div>
                        <p class="text-4xl font-bold text-safety-orange mb-2" id="hero-compliance-counter" aria-live="polite">0%</p>
                        <p class="text-base font-bold text-white mb-4">Industrial Compliance Rate</p>
                        <div class="w-full h-2.5 bg-white/20 rounded-full overflow-hidden" role="progressbar" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100">
                            <div id="hero-compliance-bar" class="h-full bg-safety-orange rounded-full w-0" style="transition:width 1.5s cubic-bezier(.22,1,.36,1)"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10" aria-hidden="true">
        <a href="#about" class="flex flex-col items-center gap-1 text-white/60 hover:text-white transition-colors stc-scroll-bounce">
            <span class="text-xs font-label-sm tracking-widest uppercase">Scroll</span>
            <span class="material-symbols-outlined text-xl">expand_more</span>
        </a>
    </div>
</section>


{{-- ================================================================
     ABOUT SECTION
================================================================ --}}
<section
    id="about"
    class="py-stack-lg bg-surface-container-lowest home-reveal"
    aria-label="Tentang STC Indonesia"
>
    <div class="w-full px-gutter max-w-container-max mx-auto">
        <div class="grid md:grid-cols-2 gap-16 items-center">

            <div class="relative group stc-reveal-left">
                <div class="absolute -top-4 -left-4 w-28 h-28 bg-safety-orange/10 rounded-full group-hover:scale-150 transition-transform duration-700" aria-hidden="true"></div>
                <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-primary/10 rounded-full" aria-hidden="true"></div>
                <img
                    src="{{ asset('images/about-stc.jpg') }}"
                    alt="Fasilitas pelatihan STC Indonesia"
                    class="relative z-10 rounded-xl shadow-2xl w-full object-cover aspect-[4/3] grayscale group-hover:grayscale-0 transition-all duration-500"
                    loading="lazy"
                />
                <div class="absolute -bottom-6 -right-6 bg-primary p-5 rounded-xl shadow-xl z-20" aria-hidden="true">
                    <span class="material-symbols-outlined text-safety-orange block mb-1" style="font-size:32px">business_center</span>
                    <span class="block text-lg font-bold text-white leading-none">PROFIL</span>
                    <span class="block text-sm text-safety-orange tracking-widest mt-1">PERUSAHAAN</span>
                </div>
            </div>

            <div class="space-y-stack-md stc-reveal-right">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-safety-orange text-2xl" aria-hidden="true">info</span>
                    <span class="text-safety-orange font-bold tracking-widest text-sm uppercase">Tentang Kami</span>
                </div>
                <h2 class="text-2xl font-bold text-primary">Komitmen Kami Untuk Masa Depan Industri</h2>
                <div class="w-0 h-1.5 bg-safety-orange rounded-full stc-line-draw" style="width:0" aria-hidden="true"></div>
                <p class="text-base text-on-surface-variant leading-relaxed">
                    Subang Training Center (STC) merupakan lembaga pelatihan dan pengembangan sumber daya manusia yang berfokus pada peningkatan kompetensi tenaga kerja industri di Indonesia. Kami hadir sebagai mitra strategis perusahaan dalam mempersiapkan tenaga kerja yang profesional, kompeten, produktif, serta siap menghadapi tantangan industri modern.
                </p>
                <p class="text-base text-on-surface-variant leading-relaxed">
                    Berlokasi di wilayah Subang — Jawa Barat yang menjadi salah satu pusat pertumbuhan kawasan industri nasional, STC berkomitmen mendukung kebutuhan industri manufaktur, otomotif, energi, migas, konstruksi, dan berbagai sektor industri lainnya melalui program pelatihan berbasis kompetensi dan kebutuhan dunia kerja.
                </p>
                <div class="flex flex-wrap gap-3 pt-4">
                    @php
                        $badges = [
                            ['label' => 'BNSP Certified',       'icon' => 'workspace_premium'],
                            ['label' => 'Kemnaker RI',           'icon' => 'account_balance'],
                            ['label' => 'ISO Standard',          'icon' => 'verified'],
                            ['label' => '15+ Tahun Pengalaman',  'icon' => 'history_edu'],
                        ];
                    @endphp
                    @foreach ($badges as $badge)
                        <span class="px-3 py-1.5 bg-surface-gray border border-outline-variant rounded-full text-sm font-semibold text-on-surface-variant flex items-center gap-2 hover:border-safety-orange hover:text-safety-orange transition-colors duration-200">
                            <span class="material-symbols-outlined text-lg text-safety-orange" aria-hidden="true">{{ $badge['icon'] }}</span>
                            {{ $badge['label'] }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ================================================================
     VISI & MISI
================================================================ --}}
<section
    id="vision-mission"
    class="py-stack-lg bg-primary text-on-primary home-reveal"
    aria-label="Visi dan Misi"
>
    <div class="w-full px-gutter max-w-container-max mx-auto">
        <div class="text-center mb-16 space-y-4 stc-reveal">
            <div class="flex items-center justify-center gap-3 mb-2">
                <span class="material-symbols-outlined text-safety-orange text-3xl stc-float" aria-hidden="true">foundation</span>
                <span class="text-safety-orange font-bold tracking-widest text-sm uppercase">Fondasi Kami</span>
            </div>
            <h2 class="text-3xl font-bold">VISI &amp; MISI</h2>
            <p class="text-outline-variant max-w-2xl mx-auto text-base">Membangun fondasi SDM unggul untuk keberlanjutan industri nasional.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-gutter">
            <div class="md:col-span-1 bg-primary-container p-10 rounded-xl border-l-4 border-safety-orange shadow-lg stc-card-lift stc-reveal-left">
                <span class="material-symbols-outlined text-safety-orange stc-float block mb-6" style="font-size:48px" aria-hidden="true">visibility</span>
                <h3 class="text-xl font-bold mb-4">VISI</h3>
                <p class="text-base opacity-80 italic leading-relaxed">
                    "Menjadi pusat pelatihan industri dan pengembangan sumber daya manusia terdepan di Indonesia yang menghasilkan tenaga kerja profesional, kompeten, berintegritas, dan berdaya saing global."
                </p>
            </div>
            <div class="md:col-span-2 grid sm:grid-cols-2 gap-6 stc-stagger">
                @php
                    $missions = [
                        ['no' => '01', 'title' => 'Profesionalisme', 'icon' => 'military_tech',  'desc' => 'Menyelenggarakan pelatihan kerja berbasis kompetensi industri dengan standar tinggi dan metode pembelajaran terkini.'],
                        ['no' => '02', 'title' => 'Kemitraan',       'icon' => 'handshake',       'desc' => 'Menjadi mitra strategis perusahaan dalam pengembangan SDM industri yang berkelanjutan dan terukur.'],
                        ['no' => '03', 'title' => 'Kualitas Nasional','icon' => 'emoji_events',  'desc' => 'Mendukung program pemerintah dalam peningkatan kualitas tenaga kerja melalui sertifikasi BNSP.'],
                        ['no' => '04', 'title' => 'Budaya Safety',   'icon' => 'health_and_safety','desc' => 'Menanamkan budaya keselamatan dan kesehatan kerja (K3) di seluruh lini industri sebagai standar operasional.'],
                    ];
                @endphp
                @foreach ($missions as $m)
                    <div class="p-6 border border-white/10 rounded-lg hover:bg-white/5 transition-all duration-200 group cursor-default stc-card-lift">
                        <span class="material-symbols-outlined text-safety-orange text-3xl mb-3 block" aria-hidden="true">{{ $m['icon'] }}</span>
                        <h4 class="font-bold text-base text-safety-orange mb-2">{{ $m['no'] }}. {{ $m['title'] }}</h4>
                        <p class="text-sm opacity-70 leading-relaxed group-hover:opacity-90 transition-opacity">{{ $m['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>


{{-- ================================================================
     TRAINING PROGRAMS SECTION
================================================================ --}}
<section
    id="programs"
    class="py-stack-lg bg-surface-container-lowest home-reveal"
    aria-label="Program Pelatihan"
>
    <div class="w-full px-gutter max-w-container-max mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6 stc-reveal">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="material-symbols-outlined text-safety-orange text-2xl" aria-hidden="true">menu_book</span>
                    <span class="text-safety-orange font-bold tracking-widest text-sm uppercase">Pilih Keahlian Anda</span>
                </div>
                <h2 class="text-3xl font-bold text-primary mt-2">Program Pelatihan Unggulan</h2>
            </div>
            <p class="max-w-md text-on-surface-variant text-base">
                Sertifikasi resmi dari Kemnaker, BNSP, dan standar industri global untuk karir cemerlang.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 stc-stagger">
            @forelse ($programs as $program)
                <article class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border-t-4 {{ $loop->odd ? 'border-primary' : 'border-safety-orange' }} stc-card-lift">
                    <div class="relative h-48 overflow-hidden">
                        <img
                            src="{{ $program->thumbnail ? Storage::url($program->thumbnail) : asset('images/placeholder-program.jpg') }}"
                            alt="{{ e($program->title) }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                            loading="lazy"
                        />
                        <div class="absolute inset-0 bg-primary/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span class="material-symbols-outlined text-white" style="font-size:56px" aria-hidden="true">{{ $program->icon ?? 'school' }}</span>
                        </div>
                        @if ($program->is_featured)
                            <span class="absolute top-3 left-3 bg-safety-orange text-white text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm" aria-hidden="true">star</span> Unggulan
                            </span>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="text-primary mb-3 text-lg font-bold">{{ e($program->title) }}</h3>
                        <ul class="space-y-2 text-sm text-on-surface-variant mb-5" role="list">
                            @foreach (array_slice($program->modules ?? [], 0, 3) as $module)
                                <li class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-safety-orange text-xl flex-shrink-0" aria-hidden="true">check_circle</span>
                                    {{ e($module) }}
                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('programs.show', $program->slug) }}" class="text-safety-orange font-bold flex items-center gap-2 group-hover:gap-4 transition-all duration-300 text-sm">
                            Detail Program <span class="material-symbols-outlined text-xl" aria-hidden="true">arrow_forward</span>
                        </a>
                    </div>
                </article>
            @empty
                @php
                    $dummies = [
                        ['title' => 'Manufaktur & Produksi', 'icon' => 'precision_manufacturing', 'color' => 'border-primary',
                         'modules' => ['Operator Produksi Industri', 'Quality Control & Assurance', 'Lean Manufacturing System'],
                         'img' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=600&q=80'],
                        ['title' => 'Teknologi Otomotif', 'icon' => 'directions_car', 'color' => 'border-safety-orange',
                         'modules' => ['Engine & Electrical System', 'Automotive Diagnostic System', 'Hybrid & EV Introduction'],
                         'img' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=600&q=80'],
                        ['title' => 'Oil & Gas (MIGAS)', 'icon' => 'oil_barrel', 'color' => 'border-primary',
                         'modules' => ['Rig & Drill Safety Awareness', 'Well Control Training', 'H2S & Hazardous Area Safety'],
                         'img' => 'https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?w=600&q=80'],
                        ['title' => 'K3 & HSE', 'icon' => 'health_and_safety', 'color' => 'border-safety-orange',
                         'modules' => ['K3 Umum & Industri', 'Fire Safety & Rescue', 'Emergency Response Plan'],
                         'img' => 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?w=600&q=80'],
                        ['title' => 'Welding & Fabricasi', 'icon' => 'hardware', 'color' => 'border-primary',
                         'modules' => ['SMAW / MIG / TIG Welding', 'NDT Inspection', 'ASME & AWS Standard'],
                         'img' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=600&q=80'],
                        ['title' => 'Listrik & Instrumentasi', 'icon' => 'electrical_services', 'color' => 'border-safety-orange',
                         'modules' => ['PLC & SCADA System', 'Instrumentasi Industri', 'Panel Control & Wiring'],
                         'img' => 'https://images.unsplash.com/photo-1621905251918-48416bd8575a?w=600&q=80'],
                    ];
                @endphp
                @foreach ($dummies as $d)
                    <article class="group bg-white rounded-xl shadow-lg overflow-hidden border-t-4 {{ $d['color'] }} stc-card-lift">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $d['img'] }}" alt="{{ $d['title'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy" />
                            <div class="absolute inset-0 bg-primary/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <span class="material-symbols-outlined text-white" style="font-size:60px" aria-hidden="true">{{ $d['icon'] }}</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-primary mb-3 text-lg font-bold">{{ $d['title'] }}</h3>
                            <ul class="space-y-2 text-sm text-on-surface-variant mb-5" role="list">
                                @foreach ($d['modules'] as $mod)
                                    <li class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-safety-orange text-xl flex-shrink-0" aria-hidden="true">check_circle</span>
                                        {{ $mod }}
                                    </li>
                                @endforeach
                            </ul>
                            <a href="#" class="text-safety-orange font-bold flex items-center gap-2 group-hover:gap-4 transition-all duration-300 text-sm">
                                Detail Program <span class="material-symbols-outlined text-xl" aria-hidden="true">arrow_forward</span>
                            </a>
                        </div>
                    </article>
                @endforeach
            @endforelse
        </div>

        <div class="text-center mt-14 stc-reveal">
            <a href="{{ route('programs.index') }}" class="inline-flex items-center gap-3 border-2 border-primary text-primary hover:bg-primary hover:text-on-primary px-8 py-3.5 rounded-lg text-base font-bold transition-all duration-200 hover:-translate-y-1">
                <span class="material-symbols-outlined text-xl" aria-hidden="true">view_list</span>
                Lihat Semua Program
                <span class="material-symbols-outlined text-xl" aria-hidden="true">arrow_forward</span>
            </a>
        </div>
    </div>
</section>


{{-- ================================================================
     PROGRAM SERTIFIKASI SECTION
================================================================ --}}
<section
    id="sertifikasi-program"
    class="py-stack-lg bg-primary home-reveal"
    aria-label="Program Sertifikasi"
>
    <div class="w-full px-gutter max-w-container-max mx-auto">

        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6 stc-reveal">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="material-symbols-outlined text-safety-orange text-3xl stc-float" aria-hidden="true">workspace_premium</span>
                    <span class="text-safety-orange font-bold tracking-widest text-sm uppercase">Diakui Nasional &amp; Internasional</span>
                </div>
                <h2 class="text-3xl font-bold text-white mt-2">Program Sertifikasi</h2>
                <div class="w-0 h-1.5 bg-safety-orange rounded-full mt-4 stc-line-draw" aria-hidden="true"></div>
            </div>
            <p class="max-w-md text-outline-variant text-base">
                Raih sertifikasi resmi yang diakui industri dan pemerintah untuk meningkatkan nilai kompetensi Anda.
            </p>
        </div>

        @php
            $sertifikasiPrograms = [
                [
                    'code'        => 'BNSP-001',
                    'title'       => 'Sertifikasi Operator Produksi',
                    'issuer'      => 'BNSP — Badan Nasional Sertifikasi Profesi',
                    'duration'    => '5 Hari',
                    'level'       => 'Operator',
                    'badge'       => 'BNSP',
                    'badge_color' => 'bg-blue-500',
                    'icon'        => 'precision_manufacturing',
                    'img'         => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=600&q=80',
                    'topics'      => ['Standar Kompetensi Kerja Nasional (SKKNI)', 'Praktik Produksi Industri', 'Asesmen & Uji Kompetensi'],
                ],
                [
                    'code'        => 'K3-UMUM',
                    'title'       => 'Sertifikasi Ahli K3 Umum',
                    'issuer'      => 'Kementerian Ketenagakerjaan RI',
                    'duration'    => '12 Hari',
                    'level'       => 'Profesional',
                    'badge'       => 'Kemnaker',
                    'badge_color' => 'bg-green-600',
                    'icon'        => 'health_and_safety',
                    'img'         => 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?w=600&q=80',
                    'topics'      => ['Perundangan K3 Indonesia', 'Manajemen Risiko & Hazard', 'Inspeksi & Audit K3'],
                ],
                [
                    'code'        => 'WELDING-AWS',
                    'title'       => 'Sertifikasi Welder Internasional',
                    'issuer'      => 'AWS — American Welding Society',
                    'duration'    => '10 Hari',
                    'level'       => 'Internasional',
                    'badge'       => 'AWS',
                    'badge_color' => 'bg-red-600',
                    'icon'        => 'hardware',
                    'img'         => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=600&q=80',
                    'topics'      => ['Teknik SMAW, MIG & TIG', 'Standar Kualitas Lasan ASME', 'Uji NDT & Kompetensi Lapangan'],
                ],
                [
                    'code'        => 'MIGAS-001',
                    'title'       => 'Sertifikasi Tenaga Teknik MIGAS',
                    'issuer'      => 'Kementerian ESDM RI',
                    'duration'    => '8 Hari',
                    'level'       => 'Spesialis',
                    'badge'       => 'ESDM',
                    'badge_color' => 'bg-amber-600',
                    'icon'        => 'oil_barrel',
                    'img'         => 'https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?w=600&q=80',
                    'topics'      => ['Keselamatan Operasi MIGAS', 'Well Control & IWCF', 'H2S Safety & Emergency Response'],
                ],
                [
                    'code'        => 'PLC-SCADA',
                    'title'       => 'Sertifikasi Teknisi Instrumentasi',
                    'issuer'      => 'BNSP — Badan Nasional Sertifikasi Profesi',
                    'duration'    => '7 Hari',
                    'level'       => 'Teknisi',
                    'badge'       => 'BNSP',
                    'badge_color' => 'bg-blue-500',
                    'icon'        => 'electrical_services',
                    'img'         => 'https://images.unsplash.com/photo-1621905251918-48416bd8575a?w=600&q=80',
                    'topics'      => ['PLC Programming & SCADA', 'Kalibrasi Instrumen Industri', 'Loop Checking & Commissioning'],
                ],
                [
                    'code'        => 'AUTOMOTIF-EV',
                    'title'       => 'Sertifikasi Teknisi Otomotif EV',
                    'issuer'      => 'BNSP — Kemnaker RI',
                    'duration'    => '6 Hari',
                    'level'       => 'Teknisi',
                    'badge'       => 'Kemnaker',
                    'badge_color' => 'bg-green-600',
                    'icon'        => 'directions_car',
                    'img'         => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=600&q=80',
                    'topics'      => ['Sistem Kelistrikan Kendaraan EV', 'Baterai & Manajemen Daya', 'Diagnostic & Troubleshooting EV'],
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 stc-stagger">
            @foreach ($sertifikasiPrograms as $sert)
                <article class="group bg-white/5 border border-white/10 rounded-2xl overflow-hidden stc-sert-card">
                    <div class="relative h-44 overflow-hidden">
                        <img
                            src="{{ $sert['img'] }}"
                            alt="{{ $sert['title'] }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 brightness-50"
                            loading="lazy"
                        />
                        <div class="absolute top-0 inset-x-0 p-3 flex items-start justify-between">
                            <span class="{{ $sert['badge_color'] }} text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm" aria-hidden="true">verified</span>
                                {{ $sert['badge'] }}
                            </span>
                            <span class="bg-black/60 backdrop-blur-sm text-white text-xs font-semibold px-3 py-1.5 rounded-full border border-white/20">
                                {{ $sert['level'] }}
                            </span>
                        </div>
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span class="material-symbols-outlined text-white drop-shadow-lg" style="font-size:64px" aria-hidden="true">{{ $sert['icon'] }}</span>
                        </div>
                        <div class="absolute bottom-3 left-4">
                            <span class="text-white/60 text-xs font-mono tracking-widest">{{ $sert['code'] }}</span>
                        </div>
                    </div>

                    <div class="p-6">
                        <h3 class="font-bold text-white text-lg mb-2 leading-snug">{{ $sert['title'] }}</h3>
                        <p class="text-safety-orange text-sm font-semibold mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg" aria-hidden="true">verified_user</span>
                            {{ $sert['issuer'] }}
                        </p>

                        <ul class="space-y-2 mb-5">
                            @foreach ($sert['topics'] as $topic)
                                <li class="flex items-start gap-2 text-white/70 text-sm">
                                    <span class="material-symbols-outlined text-safety-orange text-xl mt-0.5 flex-shrink-0" aria-hidden="true">check_circle</span>
                                    {{ $topic }}
                                </li>
                            @endforeach
                        </ul>

                        <div class="flex items-center justify-between pt-4 border-t border-white/10">
                            <div class="flex items-center gap-2 text-white/60 text-sm">
                                <span class="material-symbols-outlined text-xl" aria-hidden="true">schedule</span>
                                <span>{{ $sert['duration'] }}</span>
                            </div>
                            <a href="#" class="text-safety-orange font-bold text-sm flex items-center gap-2 hover:gap-4 transition-all duration-300">
                                Info Lengkap
                                <span class="material-symbols-outlined text-xl" aria-hidden="true">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        {{-- CTA Sertifikasi --}}
        <div class="mt-16 bg-white/5 border border-safety-orange/30 rounded-2xl p-8 flex flex-col md:flex-row items-center justify-between gap-6 stc-reveal">
            <div class="flex items-start gap-5">
                <span class="material-symbols-outlined text-safety-orange stc-float flex-shrink-0" style="font-size:48px" aria-hidden="true">handshake</span>
                <div>
                    <h3 class="text-xl font-bold text-white mb-2">Ingin Program Sertifikasi Khusus?</h3>
                    <p class="text-outline-variant text-base">Kami juga menyediakan program in-house training dan sertifikasi sesuai kebutuhan spesifik perusahaan Anda.</p>
                </div>
            </div>
            <a href="#cta" class="whitespace-nowrap bg-safety-orange hover:bg-orange-600 text-white px-7 py-3.5 rounded-xl text-base font-bold transition-all duration-200 hover:-translate-y-1 shadow-xl hover:shadow-orange-500/30 flex items-center gap-3">
                <span class="material-symbols-outlined text-xl" aria-hidden="true">forum</span>
                Konsultasi Sekarang
            </a>
        </div>
    </div>
</section>


{{-- ================================================================
     KEUNGGULAN SECTION
================================================================ --}}
<section
    id="why-us"
    class="py-stack-lg bg-surface-gray home-reveal"
    aria-label="Mengapa Memilih STC"
>
    <div class="w-full px-gutter max-w-container-max mx-auto text-center mb-16 stc-reveal">
        <div class="flex items-center justify-center gap-3 mb-2">
            <span class="material-symbols-outlined text-safety-orange text-3xl stc-float" aria-hidden="true">thumb_up</span>
            <span class="text-safety-orange font-bold tracking-widest text-sm uppercase">Keunggulan Kami</span>
        </div>
        <h2 class="text-2xl font-bold text-primary mt-2">Mengapa Memilih STC?</h2>
        <div class="w-24 h-1 bg-safety-orange mx-auto mt-4 rounded-full" aria-hidden="true"></div>
    </div>
    <div class="w-full px-gutter max-w-container-max mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-6 stc-stagger">
        @php
            $features = [
                ['icon' => 'settings_suggest', 'title' => 'Berbasis Kebutuhan Industri', 'desc' => 'Kurikulum disesuaikan dengan permintaan industri terkini dan standar global.'],
                ['icon' => 'engineering',       'title' => 'Instruktur Profesional',      'desc' => 'Praktisi ahli dengan pengalaman lapangan puluhan tahun di berbagai sektor.'],
                ['icon' => 'verified',          'title' => 'Sertifikasi Resmi',           'desc' => 'Pengakuan dari Kemnaker RI dan BNSP Indonesia yang diakui industri.'],
                ['icon' => 'handyman',          'title' => 'Peralatan Lengkap',           'desc' => 'Fasilitas lab dan workshop standar operasional industri modern.'],
                ['icon' => 'handshake',         'title' => 'Jaringan Karir',              'desc' => 'Relasi luas dengan perusahaan industri ternama di Jawa Barat dan nasional.'],
            ];
        @endphp
        @foreach ($features as $f)
            <div class="stc-why-card bg-white p-6 rounded-xl shadow-md border-b-4 border-transparent hover:border-safety-orange transition-all duration-300 text-center group stc-card-lift cursor-default">
                <div class="w-16 h-16 bg-surface-gray rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-safety-orange/10 transition-colors duration-300">
                    <span class="stc-spin-icon material-symbols-outlined text-safety-orange" style="font-size:34px" aria-hidden="true">{{ $f['icon'] }}</span>
                </div>
                <h4 class="font-bold text-sm mb-2 text-on-surface">{{ $f['title'] }}</h4>
                <p class="text-sm text-on-surface-variant leading-relaxed">{{ $f['desc'] }}</p>
            </div>
        @endforeach
    </div>
</section>


{{-- ================================================================
     GALLERY SECTION
================================================================ --}}
<section
    id="gallery"
    class="py-stack-lg bg-white overflow-hidden home-reveal"
    aria-label="Gallery Training"
>
    <div class="w-full mb-12 px-gutter max-w-container-max mx-auto flex flex-col md:flex-row justify-between items-end gap-4 stc-reveal">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="material-symbols-outlined text-safety-orange text-2xl" aria-hidden="true">photo_library</span>
                <span class="text-safety-orange font-bold tracking-widest text-sm uppercase">Visual STC</span>
            </div>
            <h2 class="text-2xl font-bold text-primary mt-2">Gallery Training</h2>
            <p class="text-on-surface-variant mt-2 text-base">Intip kegiatan pelatihan rutin kami di workshop STC.</p>
        </div>
        <a href="{{ route('gallery.index') }}" class="text-safety-orange font-bold flex items-center gap-2 hover:gap-4 transition-all shrink-0 text-sm">
            Lihat Semua <span class="material-symbols-outlined text-xl" aria-hidden="true">arrow_forward</span>
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 h-[500px] md:h-[600px] gap-2 px-2">
        @forelse ($galleries as $item)
            <div class="stc-gallery-item relative overflow-hidden group cursor-pointer" onclick="homeGalleryOpenModal('{{ Storage::url($item->image) }}', '{{ e($item->caption) }}')">
                <img src="{{ Storage::url($item->image) }}" alt="{{ e($item->caption) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" loading="lazy" />
                <div class="stc-gallery-overlay absolute inset-0 bg-primary/70 flex flex-col items-center justify-center gap-3">
                    <span class="material-symbols-outlined text-white" style="font-size:40px" aria-hidden="true">zoom_in</span>
                    <span class="text-white font-bold border-b-2 border-safety-orange pb-1 text-center px-4 text-sm">{{ e($item->caption) }}</span>
                </div>
            </div>
        @empty
            @php
                $dummyGallery = [
                    ['src' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&q=80', 'caption' => 'Safety First Training'],
                    ['src' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=600&q=80', 'caption' => 'Automotive Lab'],
                    ['src' => 'https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?w=600&q=80', 'caption' => 'Welding Certification'],
                    ['src' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=600&q=80', 'caption' => 'Industrial Production'],
                ];
            @endphp
            @foreach ($dummyGallery as $g)
                <div
                    class="stc-gallery-item relative overflow-hidden group cursor-pointer"
                    onclick="homeGalleryOpenModal('{{ $g['src'] }}', '{{ $g['caption'] }}')"
                    role="button" tabindex="0"
                    aria-label="Lihat foto: {{ $g['caption'] }}"
                    onkeydown="if(event.key==='Enter') homeGalleryOpenModal('{{ $g['src'] }}', '{{ $g['caption'] }}')"
                >
                    <img src="{{ $g['src'] }}" alt="{{ $g['caption'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" loading="lazy" />
                    <div class="stc-gallery-overlay absolute inset-0 bg-primary/70 flex flex-col items-center justify-center gap-3">
                        <span class="material-symbols-outlined text-white" style="font-size:40px" aria-hidden="true">zoom_in</span>
                        <span class="text-white font-bold border-b-2 border-safety-orange pb-1 text-center px-4 text-sm">{{ $g['caption'] }}</span>
                    </div>
                </div>
            @endforeach
        @endforelse
    </div>

    {{-- Gallery Modal --}}
    <div
        id="gallery-modal"
        class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-4 opacity-0 pointer-events-none transition-opacity duration-300"
        role="dialog" aria-modal="true" aria-label="Gallery viewer"
        onclick="homeGalleryCloseModal(event)"
    >
        <button class="absolute top-4 right-4 text-white hover:text-safety-orange transition-colors p-2" onclick="homeGalleryCloseModal()" aria-label="Tutup gallery">
            <span class="material-symbols-outlined" style="font-size:36px" aria-hidden="true">close</span>
        </button>
        <figure class="max-w-4xl w-full">
            <img id="gallery-modal-img" src="" alt="" class="w-full max-h-[80vh] object-contain rounded-lg shadow-2xl" />
            <figcaption id="gallery-modal-caption" class="text-white text-center mt-4 font-semibold text-base"></figcaption>
        </figure>
    </div>
</section>


{{-- ================================================================
     CERTIFICATION SECTION
================================================================ --}}
<section
    id="certification"
    class="py-stack-lg bg-surface-gray home-reveal"
    aria-label="Sertifikasi"
>
    <div class="w-full px-gutter max-w-container-max mx-auto">
        <div class="text-center mb-16 stc-reveal">
            <div class="flex items-center justify-center gap-3 mb-2">
                <span class="material-symbols-outlined text-safety-orange text-3xl stc-float" aria-hidden="true">emoji_events</span>
                <span class="text-safety-orange font-bold tracking-widest text-sm uppercase">Pengakuan Nasional</span>
            </div>
            <h2 class="text-2xl font-bold text-primary mt-2">Sertifikasi & Akreditasi</h2>
            <div class="w-24 h-1 bg-safety-orange mx-auto mt-4 rounded-full" aria-hidden="true"></div>
        </div>

<div class="grid grid-cols-2 md:grid-cols-4 gap-6 stc-stagger">
    
    @forelse ($certifications as $cert)
        <div class="bg-white p-7 rounded-xl shadow-md text-center stc-card-lift group">
            
            <div class="w-20 h-20 mx-auto mb-4 flex items-center justify-center bg-surface-gray rounded-full group-hover:bg-safety-orange/10 transition-colors">
                
                @if ($cert->logo)
                    {{-- Jika logo dari database/storage --}}
                    <img 
                        src="{{ Storage::url($cert->logo) }}" 
                        alt="{{ e($cert->name) }}"
                        class="w-14 h-14 object-contain"
                        loading="lazy"
                    />
                @else
                    {{-- Default logo dari folder public --}}
                    <img 
                        src="{{ asset('images/certifications/default.png') }}" 
                        alt="{{ e($cert->name) }}"
                        class="w-14 h-14 object-contain"
                        loading="lazy"
                    />
                @endif

            </div>

            <h4 class="font-bold text-sm text-on-surface">
                {{ e($cert->name) }}
            </h4>

            <p class="text-xs text-on-surface-variant mt-1">
                {{ e($cert->issuer) }}
            </p>
        </div>

    @empty

        @php
            $dummyCerts = [
                [
                    'name' => 'BNSP',
                    'issuer' => 'Badan Nasional Sertifikasi Profesi',
                    'image' => 'images/logo-bnsp.png'
                ],
                [
                    'name' => 'Kemnaker RI',
                    'issuer' => 'Kementerian Ketenagakerjaan',
                    'image' => 'images/logo-kemenaker.png'
                ],
                [
                    'name' => 'ISO 9001:2015',
                    'issuer' => 'International Organization',
                    'image' => 'images/logo-iso.png'
                ],
                [
                    'name' => 'MIGAS Certified',
                    'issuer' => 'Kementerian ESDM RI',
                    'image' => 'images/logo-esdm.png'
                ],
            ];
        @endphp

        @foreach ($dummyCerts as $c)
            <div class="bg-white p-7 rounded-xl shadow-md text-center stc-card-lift group">
                
                <div class="w-20 h-20 mx-auto mb-4 flex items-center justify-center bg-surface-gray rounded-full group-hover:bg-safety-orange/10 transition-colors">
                    
                    <img 
                        src="{{ asset($c['image']) }}" 
                        alt="{{ $c['name'] }}"
                        class="w-14 h-14 object-contain"
                        loading="lazy"
                    />

                </div>

                <h4 class="font-bold text-sm text-on-surface">
                    {{ $c['name'] }}
                </h4>

                <p class="text-xs text-on-surface-variant mt-1">
                    {{ $c['issuer'] }}
                </p>
            </div>
        @endforeach

    @endforelse

</div>
    </div>
</section>


{{-- ================================================================
     TESTIMONIALS SECTION
================================================================ --}}
<section
    id="testimonials"
    class="py-stack-lg bg-surface-container-low home-reveal"
    aria-label="Testimoni Alumni"
>
    <div class="w-full px-gutter max-w-container-max mx-auto">
        <div class="text-center mb-16 stc-reveal">
            <div class="flex items-center justify-center gap-3 mb-2">
                <span class="material-symbols-outlined text-safety-orange text-3xl stc-float" aria-hidden="true">format_quote</span>
                <span class="text-safety-orange font-bold tracking-widest text-sm uppercase">Cerita Sukses</span>
            </div>
            <h2 class="text-2xl font-bold text-primary mt-2">Apa Kata Alumni?</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-8 stc-stagger">
            @forelse ($testimonials as $i => $testi)
                <article
                    class="stc-quote-reveal bg-white p-7 rounded-xl shadow-lg relative stc-card-lift {{ $i === 1 ? 'border-b-4 border-safety-orange' : '' }}"
                    aria-label="Testimoni dari {{ e($testi->name) }}"
                >
                    <span class="stc-quote-icon material-symbols-outlined text-safety-orange/20 absolute top-4 right-4 opacity-0" style="font-size:48px" aria-hidden="true">format_quote</span>
                    <div class="flex mb-3" aria-label="{{ $testi->rating }} bintang dari 5">
                        @for ($s = 1; $s <= 5; $s++)
                            <span class="text-{{ $s <= $testi->rating ? 'safety-orange' : 'outline-variant' }} text-lg" aria-hidden="true">★</span>
                        @endfor
                    </div>
                    <p class="text-base italic mb-5 text-on-surface-variant leading-relaxed">"{{ e($testi->content) }}"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white font-bold text-lg flex-shrink-0" aria-hidden="true">
                            {{ strtoupper(substr($testi->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-bold text-sm text-on-surface">{{ e($testi->name) }}</p>
                            <p class="text-xs text-safety-orange flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm" aria-hidden="true">badge</span>
                                {{ e($testi->role) }}
                            </p>
                        </div>
                    </div>
                </article>
            @empty
                @php
                    $dummyTestis = [
                        ['name' => 'Aditya Pratama', 'role' => 'Alumni Automotive Tech', 'rating' => 5,
                         'content' => 'Pelatihan di STC sangat komprehensif. Instrukturnya sangat sabar dan fasilitasnya sangat modern. Saya langsung diterima kerja setelah lulus sertifikasi.'],
                        ['name' => 'Rina Fitriani',  'role' => 'HSE Professional',       'rating' => 5,
                         'content' => 'Materi K3 yang diajarkan sangat relevan dengan standar industri migas. Sangat membantu dalam memahami aspek keselamatan kerja yang kritikal.'],
                        ['name' => 'Bambang S.',     'role' => 'Supervisor Produksi',    'rating' => 5,
                         'content' => 'Networking STC dengan industri sangat luas. Kami diajarkan tidak hanya teori, tapi simulasi kerja nyata yang membuat kami percaya diri saat interview.'],
                    ];
                @endphp
                @foreach ($dummyTestis as $i => $t)
                    <article class="stc-quote-reveal bg-white p-7 rounded-xl shadow-lg relative stc-card-lift {{ $i === 1 ? 'border-b-4 border-safety-orange' : '' }}">
                        <span class="stc-quote-icon material-symbols-outlined text-safety-orange/20 absolute top-4 right-4 opacity-0" style="font-size:48px" aria-hidden="true">format_quote</span>
                        <div class="flex mb-3">
                            @for ($s = 0; $s < 5; $s++)
                                <span class="text-safety-orange text-lg" aria-hidden="true">★</span>
                            @endfor
                        </div>
                        <p class="text-base italic mb-5 text-on-surface-variant leading-relaxed">"{{ $t['content'] }}"</p>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white font-bold text-lg flex-shrink-0" aria-hidden="true">
                                {{ strtoupper(substr($t['name'], 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-bold text-sm text-on-surface">{{ $t['name'] }}</p>
                                <p class="text-xs text-safety-orange flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm" aria-hidden="true">badge</span>
                                    {{ $t['role'] }}
                                </p>
                            </div>
                        </div>
                    </article>
                @endforeach
            @endforelse
        </div>
    </div>
</section>


{{-- ================================================================
     FINAL CTA
================================================================ --}}
<section
    id="cta"
    class="py-stack-lg bg-safety-orange text-white text-center home-reveal relative overflow-hidden"
    aria-label="Call to Action"
>
    <div class="stc-blob" aria-hidden="true"></div>
    <div class="stc-blob" style="animation-delay:-4s;opacity:.03" aria-hidden="true"></div>

    <div class="relative z-10 w-full px-gutter max-w-container-max mx-auto space-y-6 stc-reveal">
        <span class="material-symbols-outlined stc-float text-white/50 block mx-auto" style="font-size:56px" aria-hidden="true">rocket_launch</span>
        <h2 class="text-3xl font-bold leading-tight">
            Siapkan Masa Depan Karier Industri<br />Anda Bersama STC Indonesia
        </h2>
        <p class="text-base max-w-2xl mx-auto opacity-90 leading-relaxed">
            Jadilah bagian dari tenaga kerja masa depan yang kompeten dan bersertifikat nasional.
        </p>
        <div class="flex flex-wrap justify-center gap-4 pt-6">
            <a
                href="#programs"
                class="bg-primary text-on-primary px-9 py-3.5 rounded-lg font-bold text-base hover:bg-primary-container transition-all duration-200 shadow-2xl hover:-translate-y-1 active:translate-y-0 flex items-center gap-3"
            >
                <span class="material-symbols-outlined text-xl" aria-hidden="true">school</span>
                Daftar Pelatihan Sekarang
            </a>
            <a
                href="tel:+628112021212"
                class="bg-white text-safety-orange px-9 py-3.5 rounded-lg font-bold text-base hover:bg-surface-gray transition-all duration-200 hover:-translate-y-1 flex items-center gap-3"
            >
                <span class="material-symbols-outlined text-xl" aria-hidden="true">call</span>
                Hubungi Kami
            </a>
        </div>
    </div>
</section>


@endsection

@push('scripts')
    @vite(['resources/js/home.js'])
@endpush