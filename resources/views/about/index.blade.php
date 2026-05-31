{{-- resources/views/about/index.blade.php --}}
@extends('layouts.app')

@section('content')

{{-- ================================================================
     ABOUT-SPECIFIC ANIMATION STYLES
================================================================ --}}
<style>
    /* ── Scroll reveal ── */
    .about-reveal {
        opacity: 0;
        transform: translateY(40px);
        transition: opacity 0.7s cubic-bezier(.22,1,.36,1), transform 0.7s cubic-bezier(.22,1,.36,1);
    }
    .about-reveal.visible { opacity: 1; transform: none; }

    .about-reveal-left  { opacity: 0; transform: translateX(-50px); transition: opacity 0.7s cubic-bezier(.22,1,.36,1), transform 0.7s cubic-bezier(.22,1,.36,1); }
    .about-reveal-right { opacity: 0; transform: translateX(50px);  transition: opacity 0.7s cubic-bezier(.22,1,.36,1), transform 0.7s cubic-bezier(.22,1,.36,1); }
    .about-reveal-left.visible, .about-reveal-right.visible { opacity: 1; transform: none; }

    /* staggered children */
    .about-stagger > * { opacity: 0; transform: translateY(30px); transition: opacity 0.6s cubic-bezier(.22,1,.36,1), transform 0.6s cubic-bezier(.22,1,.36,1); }
    .about-stagger.visible > *:nth-child(1) { opacity:1; transform:none; transition-delay:.05s }
    .about-stagger.visible > *:nth-child(2) { opacity:1; transform:none; transition-delay:.12s }
    .about-stagger.visible > *:nth-child(3) { opacity:1; transform:none; transition-delay:.19s }
    .about-stagger.visible > *:nth-child(4) { opacity:1; transform:none; transition-delay:.26s }
    .about-stagger.visible > *:nth-child(5) { opacity:1; transform:none; transition-delay:.33s }
    .about-stagger.visible > *:nth-child(6) { opacity:1; transform:none; transition-delay:.40s }
    .about-stagger.visible > *:nth-child(7) { opacity:1; transform:none; transition-delay:.47s }
    .about-stagger.visible > *:nth-child(8) { opacity:1; transform:none; transition-delay:.54s }

    /* ── Divider line draw ── */
    @keyframes aboutLineDraw { from { width:0 } to { width:3rem } }
    .about-line-draw { width:0; height:4px; background:#F96302; border-radius:9999px; display:inline-block; }
    .about-line-draw.visible { animation: aboutLineDraw .7s .3s cubic-bezier(.22,1,.36,1) forwards }

    /* ── Card hover lift ── */
    .about-card-lift { transition: transform .3s cubic-bezier(.22,1,.36,1), box-shadow .3s ease }
    .about-card-lift:hover { transform: translateY(-6px); box-shadow: 0 20px 40px -10px rgba(0,0,0,.15) }

    /* ── Icon float ── */
    @keyframes aboutFloat {
        0%,100% { transform: translateY(0) }
        50%      { transform: translateY(-8px) }
    }
    .about-float { animation: aboutFloat 3s ease-in-out infinite }

    /* ── Hero clip-path ── */
    .about-hero-clip {
        clip-path: polygon(0 0, 100% 0, 100% 88%, 0 100%);
    }

    /* ── Value icon hover ── */
    .about-value-item .about-value-icon { transition: background .3s ease }
    .about-value-item:hover .about-value-icon { background-color: #F96302; }

    /* ── Industry target hover ── */
    .about-industry-card { transition: transform .25s ease, box-shadow .25s ease; }
    .about-industry-card:hover { transform: translateY(-4px); box-shadow: 0 12px 28px -8px rgba(0,0,0,.12); }
    .about-industry-card:hover .about-industry-icon { color: #F96302; }

    /* ── Synergy partner card ── */
    .about-synergy-card { transition: box-shadow .3s ease; }
    .about-synergy-card:hover { box-shadow: 0 20px 50px -12px rgba(249,99,2,.2); }

    /* ── Progress bar fill ── */
    @keyframes aboutBarFill { from { width:0 } to { width:var(--bar-width,80%) } }
    .about-bar-fill { animation: aboutBarFill 1.2s .4s cubic-bezier(.22,1,.36,1) forwards; width:0; }
</style>


{{-- ================================================================
     HERO
================================================================ --}}
<section
    id="about-hero"
    class="relative bg-deep-slate text-white about-hero-clip pt-28 pb-36 md:pb-44 overflow-hidden"
    aria-label="Tentang STC Indonesia"
>
    {{-- BG image + overlay --}}
    <div class="absolute inset-0 z-0" aria-hidden="true">
        <img
            src="{{ asset('images/about-hero.jpg') }}"
            alt=""
            class="w-full h-full object-cover"
            loading="eager"
            fetchpriority="high"
        />
        <div class="absolute inset-0 bg-gradient-to-r from-primary/95 via-primary/80 to-deep-slate/60"></div>
    </div>

    {{-- Decorative floating dots --}}
    <div id="about-hero-particles" class="absolute inset-0 pointer-events-none z-0" aria-hidden="true"></div>

    <div class="relative z-10 max-w-container-max mx-auto px-gutter">
        <div class="max-w-3xl">
            <span class="inline-flex items-center gap-2 bg-safety-orange/20 border border-safety-orange/40 text-safety-orange text-sm font-bold px-4 py-1.5 rounded-full mb-5 about-reveal" style="transition-delay:.1s">
                <span class="material-symbols-outlined text-lg" aria-hidden="true">info</span>
                Tentang STC Indonesia
            </span>
            <h1 class="font-bold text-3xl md:text-5xl leading-tight mb-5 about-reveal" style="transition-delay:.2s">
                Tentang <span class="text-safety-orange">STC</span> Indonesia
            </h1>
            <div class="about-line-draw mb-5 about-reveal" style="transition-delay:.3s" aria-hidden="true"></div>
            <p class="font-body-lg text-lg md:text-xl opacity-90 max-w-2xl leading-relaxed about-reveal" style="transition-delay:.35s">
                Membangun Kompetensi SDM Industri untuk Masa Depan Indonesia yang Berdaya Saing Global.
            </p>

            {{-- Quick stats row --}}
            <div class="flex flex-wrap gap-10 mt-10 about-reveal" style="transition-delay:.45s">
                @php
                    $heroStats = [
                        ['value' => '5000+', 'label' => 'Alumni Tersertifikasi', 'icon' => 'groups'],
                        ['value' => '15+',   'label' => 'Tahun Pengalaman',      'icon' => 'history_edu'],
                        ['value' => '50+',   'label' => 'Program Pelatihan',     'icon' => 'menu_book'],
                        ['value' => '98%',   'label' => 'Compliance Rate',       'icon' => 'verified'],
                    ];
                @endphp
                @foreach ($heroStats as $hs)
                    <div class="text-center">
                        <span class="material-symbols-outlined text-safety-orange/70 text-2xl block mb-1" aria-hidden="true">{{ $hs['icon'] }}</span>
                        <p class="text-2xl font-bold text-safety-orange">{{ $hs['value'] }}</p>
                        <p class="text-sm text-white/60 mt-0.5">{{ $hs['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>


{{-- ================================================================
     COMPANY PROFILE
================================================================ --}}
<section
    id="about-profile"
    class="py-stack-lg bg-surface-container-lowest"
    aria-label="Profil Perusahaan"
>
    <div class="max-w-container-max mx-auto px-gutter">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

            {{-- Text --}}
            <div class="lg:col-span-7 about-reveal-left">
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-12 h-1 bg-safety-orange rounded-full flex-shrink-0" aria-hidden="true"></span>
                    <h2 class="font-bold text-2xl md:text-3xl text-primary uppercase tracking-wide">Profil Perusahaan</h2>
                </div>
                <div class="space-y-4 text-base text-on-surface-variant leading-relaxed">
                    <p>
                        Subang Training Center (STC) merupakan lembaga pelatihan dan pengembangan sumber daya manusia yang berfokus pada peningkatan kompetensi tenaga kerja industri di Indonesia. STC hadir sebagai mitra strategis perusahaan dalam mempersiapkan tenaga kerja yang profesional, kompeten, produktif, serta siap menghadapi tantangan industri modern.
                    </p>
                    <p>
                        Berlokasi di wilayah Subang — Jawa Barat yang menjadi salah satu pusat pertumbuhan kawasan industri nasional, STC berkomitmen mendukung kebutuhan industri manufaktur, otomotif, energi, migas, konstruksi, dan berbagai sektor industri lainnya melalui program pelatihan berbasis kompetensi dan kebutuhan dunia kerja.
                    </p>
                    <p>
                        Dengan dukungan instruktur berpengalaman, sistem pembelajaran berbasis praktik industri, serta pendekatan pelatihan yang adaptif terhadap perkembangan teknologi dan kebutuhan perusahaan, STC hadir untuk menciptakan sumber daya manusia unggul yang memiliki keterampilan teknis, kedisiplinan, keselamatan kerja, dan etos profesional.
                    </p>
                </div>

                {{-- Accreditation badges --}}
                <div class="flex flex-wrap gap-3 mt-8">
                    @php
                        $profileBadges = [
                            ['label' => 'BNSP Certified',      'icon' => 'workspace_premium'],
                            ['label' => 'Kemnaker RI',          'icon' => 'account_balance'],
                            ['label' => 'ISO 9001:2015',        'icon' => 'verified'],
                            ['label' => 'MIGAS Certified',      'icon' => 'oil_barrel'],
                            ['label' => '15+ Tahun Pengalaman', 'icon' => 'history_edu'],
                        ];
                    @endphp
                    @foreach ($profileBadges as $badge)
                        <span class="px-3 py-1.5 bg-surface-gray border border-outline-variant rounded-full text-sm font-semibold text-on-surface-variant flex items-center gap-2 hover:border-safety-orange hover:text-safety-orange transition-colors duration-200">
                            <span class="material-symbols-outlined text-lg text-safety-orange" aria-hidden="true">{{ $badge['icon'] }}</span>
                            {{ $badge['label'] }}
                        </span>
                    @endforeach
                </div>
            </div>

            {{-- Image --}}
            <div class="lg:col-span-5 relative group about-reveal-right">
                <div class="absolute -inset-4 bg-industrial-blue-light/10 rounded-xl blur-xl group-hover:bg-safety-orange/10 transition-colors duration-500" aria-hidden="true"></div>
                <img
                    src="{{ asset('images/about-team.jpg') }}"
                    alt="Tim profesional STC Indonesia berfoto bersama di depan fasilitas training"
                    class="relative rounded-xl shadow-2xl w-full h-auto object-cover border-4 border-white grayscale group-hover:grayscale-0 transition-all duration-500"
                    loading="lazy"
                />
                <div class="absolute -bottom-5 -left-5 bg-primary p-4 rounded-xl shadow-xl z-10" aria-hidden="true">
                    <span class="material-symbols-outlined text-safety-orange block mb-1" style="font-size:28px">business_center</span>
                    <span class="block text-sm font-bold text-white leading-none">PROFIL</span>
                    <span class="block text-xs text-safety-orange tracking-widest mt-1">PERUSAHAAN</span>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ================================================================
     SINERGI / STRATEGIC COLLABORATION
================================================================ --}}
<section
    id="about-synergy"
    class="py-stack-lg bg-surface-gray"
    aria-label="Sinergi Pengembangan SDM Industri"
>
    <div class="max-w-container-max mx-auto px-gutter">
        <div class="text-center mb-12 about-reveal">
            <div class="flex items-center justify-center gap-3 mb-2">
                <span class="material-symbols-outlined text-safety-orange text-3xl about-float" aria-hidden="true">hub</span>
                <span class="text-safety-orange font-bold tracking-widest text-sm uppercase">Kolaborasi Strategis</span>
            </div>
            <h2 class="text-2xl md:text-3xl font-bold text-primary mt-2 uppercase">Sinergi Pengembangan SDM Industri</h2>
            <p class="text-on-surface-variant text-base max-w-3xl mx-auto mt-3">
                Kolaborasi strategis antara PT Subang Energi Abadi (Perseroda) dan PT Aryndo Utama Sarana Sukses untuk menghadirkan pusat pelatihan berstandar internasional.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">

            {{-- Partner card --}}
<div class="about-synergy-card bg-white p-12 rounded-xl shadow-sm flex flex-col items-center justify-center space-y-6 border-t-4 border-safety-orange about-reveal-left">

    <div class="flex gap-8 items-center justify-center">

        {{-- Logo pertama --}}
        <div class="flex flex-col items-center gap-2 text-center">
            <img
                src="{{ asset('images/logo-subang-energi.png') }}"
                alt="PT Subang Energi Abadi"
                class="w-[95px] h-[95px] object-contain about-float"
            >

            <span class="font-bold text-xs text-primary">
                PT SUBANG ENERGI ABADI (Perseroda)
            </span>
        </div>

        <div class="h-14 w-px bg-outline-variant" aria-hidden="true"></div>

        {{-- Logo kedua --}}
        <div class="flex flex-col items-center gap-2 text-center">
            <img
                src="{{ asset('images/Logo-aryndo.png') }}"
                alt="PT Aryndo Utama Sarana Sukses"
                class="w-[95px] h-[95px] object-contain about-float"
                style="animation-delay:.4s"
            >

            <span class="font-bold text-xs text-primary">
                PT ARYNDO UTAMA SARANA SUKSES
            </span>
        </div>

    </div>

    <div class="text-center">
        <span
            class="material-symbols-outlined text-safety-orange text-3xl block mb-2"
            aria-hidden="true"
        >
            handshake
        </span>

        <p class="font-bold text-lg text-primary uppercase tracking-wide">
            "End-to-End Training and Certification"
        </p>
    </div>

</div>
            {{-- Points list --}}
            <div class="space-y-4 about-stagger">
                @php
                    $synergyPoints = [
                        'Mendukung peningkatan kompetensi masyarakat Kabupaten Subang.',
                        'Mempersiapkan tenaga kerja lokal yang siap bersaing di kawasan industri.',
                        'Mendukung program pengembangan SDM nasional secara berkelanjutan.',
                        'Meningkatkan kesejahteraan masyarakat melalui peningkatan skill kerja.',
                        'Menghadirkan pelatihan berstandar nasional dan internasional yang terjangkau.',
                    ];
                @endphp
                @foreach ($synergyPoints as $point)
                    <div class="flex items-start gap-4 p-4 bg-white rounded-lg shadow-sm border-l-4 border-industrial-blue-light hover:border-safety-orange transition-colors duration-200">
                        <span class="material-symbols-outlined text-industrial-blue-light flex-shrink-0 mt-0.5" aria-hidden="true">check_circle</span>
                        <p class="text-on-surface-variant text-sm leading-relaxed">{{ $point }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>


{{-- ================================================================
     TARGET INDUSTRI
================================================================ --}}
<section
    id="about-industry"
    class="py-stack-lg bg-surface-container-lowest"
    aria-label="Target Industri"
>
    <div class="max-w-container-max mx-auto px-gutter">
        <div class="text-center mb-12 about-reveal">
            <div class="flex items-center justify-center gap-3 mb-2">
                <span class="material-symbols-outlined text-safety-orange text-3xl about-float" aria-hidden="true">factory</span>
                <span class="text-safety-orange font-bold tracking-widest text-sm uppercase">Sektor Layanan</span>
            </div>
            <h2 class="text-2xl md:text-3xl font-bold text-primary mt-2 uppercase">Target Industri</h2>
            <div class="w-24 h-1 bg-safety-orange mx-auto mt-4 rounded-full" aria-hidden="true"></div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-5 about-stagger">
            @php
                $industries = [
                    ['icon' => 'directions_car',           'label' => 'Otomotif'],
                    ['icon' => 'precision_manufacturing',  'label' => 'Manufaktur'],
                    ['icon' => 'bolt',                     'label' => 'Energi'],
                    ['icon' => 'oil_barrel',               'label' => 'Oil & Gas'],
                    ['icon' => 'construction',             'label' => 'Konstruksi'],
                    ['icon' => 'diamond',                  'label' => 'Pertambangan'],
                    ['icon' => 'local_shipping',           'label' => 'Logistik'],
                    ['icon' => 'domain',                   'label' => 'Kawasan Industri'],
                ];
            @endphp
            @foreach ($industries as $industry)
                <div class="about-industry-card bg-white p-6 rounded-lg shadow-sm border border-outline-variant/30 text-center group cursor-default">
                    <span class="about-industry-icon material-symbols-outlined text-industrial-blue-light transition-colors duration-200 block mb-3" style="font-size:40px" aria-hidden="true">{{ $industry['icon'] }}</span>
                    <p class="font-bold text-sm text-on-surface">{{ $industry['label'] }}</p>
                </div>
            @endforeach
        </div>

        {{-- Context image banner --}}
        <div class="mt-14 rounded-xl overflow-hidden shadow-2xl relative h-[360px] md:h-[440px] about-reveal">
            <img
                src="{{ asset('images/about-workshop.jpg') }}"
                alt="Peserta pelatihan STC sedang praktik di workshop listrik dan instrumentasi"
                class="w-full h-full object-cover"
                loading="lazy"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-primary/80 via-primary/30 to-transparent flex items-end p-8 md:p-12">
                <div class="text-white">
                    <p class="font-bold text-safety-orange uppercase tracking-wide mb-2">Training Today, Skill for Tomorrow</p>
                    <p class="max-w-xl opacity-90 text-base">Fasilitas praktek lengkap untuk simulasi dunia kerja yang sesungguhnya.</p>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ================================================================
     VISI & MISI
================================================================ --}}
<section
    id="about-vision"
    class="py-stack-lg bg-deep-slate text-white overflow-hidden"
    aria-label="Visi dan Misi"
>
    <div class="max-w-container-max mx-auto px-gutter">
        <div class="text-center mb-14 about-reveal">
            <div class="flex items-center justify-center gap-3 mb-2">
                <span class="material-symbols-outlined text-safety-orange text-3xl about-float" aria-hidden="true">foundation</span>
                <span class="text-safety-orange font-bold tracking-widest text-sm uppercase">Fondasi Kami</span>
            </div>
            <h2 class="text-2xl md:text-3xl font-bold mt-2 uppercase">Visi &amp; Misi</h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-14">
            {{-- Visi --}}
            <div class="about-reveal-left">
                <h3 class="font-bold text-2xl text-white mb-4 border-b-2 border-safety-orange inline-block pb-2 uppercase">Visi</h3>
                <p class="text-body-lg italic leading-relaxed opacity-90 text-base mt-4">
                    "Menjadi pusat pelatihan industri dan pengembangan sumber daya manusia terdepan di Indonesia yang menghasilkan tenaga kerja profesional, kompeten, berintegritas, dan berdaya saing global."
                </p>

                <h3 class="font-bold text-2xl text-white mt-12 mb-6 border-b-2 border-safety-orange inline-block pb-2 uppercase">Misi</h3>
                <ul class="space-y-5 mt-4" role="list">
                    @php
                        $missions = [
                            'Menyelenggarakan pelatihan kerja berbasis kompetensi industri yang relevan.',
                            'Mengembangkan tenaga kerja yang memiliki keterampilan teknis dan sikap profesional tinggi.',
                            'Menjadi mitra strategis perusahaan dalam pengembangan SDM industri berkelanjutan.',
                            'Mendukung program peningkatan kualitas tenaga kerja nasional dan daerah.',
                            'Menghadirkan pelatihan yang sesuai dengan standar industri, Kementerian Ketenagakerjaan, dan BNSP.',
                        ];
                    @endphp
                    @foreach ($missions as $i => $mission)
                        <li class="flex gap-4 about-reveal" style="transition-delay:{{ ($i * 0.08) + 0.1 }}s">
                            <span class="flex-shrink-0 w-8 h-8 bg-safety-orange rounded-full flex items-center justify-center font-bold text-sm text-white" aria-hidden="true">{{ $i + 1 }}</span>
                            <p class="text-sm opacity-90 leading-relaxed pt-1">{{ $mission }}</p>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Nilai Perusahaan --}}
            <div class="about-reveal-right">
                <div class="bg-primary-container p-8 md:p-10 rounded-2xl relative border border-white/10">
                    <h3 class="font-bold text-2xl text-white mb-8 text-center uppercase">Nilai Perusahaan</h3>
                    <div class="space-y-6">
                        @php
                            $values = [
                                ['icon' => 'verified_user',  'title' => 'Professional', 'desc' => 'Menjunjung tinggi profesionalisme dalam setiap aspek pelayanan.'],
                                ['icon' => 'handshake',      'title' => 'Integrity',    'desc' => 'Membangun kepercayaan melalui kejujuran dan tanggung jawab.'],
                                ['icon' => 'fitness_center', 'title' => 'Competency',   'desc' => 'Berorientasi pada peningkatan keterampilan nyata yang terukur.'],
                                ['icon' => 'security',       'title' => 'Safety',       'desc' => 'Menanamkan budaya K3 di seluruh aktivitas industri.'],
                                ['icon' => 'military_tech',  'title' => 'Excellence',   'desc' => 'Komitmen memberikan kualitas pelatihan terbaik berstandar dunia.'],
                            ];
                        @endphp
                        @foreach ($values as $v)
                            <div class="about-value-item flex items-center gap-5 group">
                                <div class="about-value-icon w-14 h-14 bg-white/10 rounded-xl flex items-center justify-center flex-shrink-0 transition-colors duration-300">
                                    <span class="material-symbols-outlined text-white text-2xl" aria-hidden="true">{{ $v['icon'] }}</span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-base text-safety-orange">{{ $v['title'] }}</h4>
                                    <p class="text-sm opacity-70 leading-relaxed mt-0.5">{{ $v['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Decorative glow --}}
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[110%] h-[110%] bg-industrial-blue-light/15 blur-3xl -z-0 rounded-full pointer-events-none" aria-hidden="true"></div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ================================================================
     KEUNGGULAN / WHY US
================================================================ --}}
<section
    id="about-why"
    class="py-stack-lg bg-surface-gray"
    aria-label="Keunggulan STC"
>
    <div class="max-w-container-max mx-auto px-gutter">
        <div class="text-center mb-14 about-reveal">
            <div class="flex items-center justify-center gap-3 mb-2">
                <span class="material-symbols-outlined text-safety-orange text-3xl about-float" aria-hidden="true">thumb_up</span>
                <span class="text-safety-orange font-bold tracking-widest text-sm uppercase">Keunggulan Kami</span>
            </div>
            <h2 class="text-2xl md:text-3xl font-bold text-primary mt-2 uppercase">Mengapa Memilih STC?</h2>
            <div class="w-24 h-1 bg-safety-orange mx-auto mt-4 rounded-full" aria-hidden="true"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 about-stagger">
            @php
                $whyUs = [
                    ['icon' => 'settings_suggest', 'title' => 'Berbasis Industri',       'desc' => 'Kurikulum disesuaikan dengan permintaan industri terkini dan standar global.'],
                    ['icon' => 'engineering',       'title' => 'Instruktur Ahli',         'desc' => 'Praktisi berpengalaman lapangan dari berbagai sektor industri nasional.'],
                    ['icon' => 'verified',          'title' => 'Sertifikasi Resmi',       'desc' => 'Diakui Kemnaker RI, BNSP, dan lembaga sertifikasi internasional.'],
                    ['icon' => 'handyman',          'title' => 'Fasilitas Lengkap',       'desc' => 'Lab dan workshop berstandar operasional industri modern dan up-to-date.'],
                    ['icon' => 'handshake',         'title' => 'Jaringan Karir',          'desc' => 'Relasi luas dengan perusahaan ternama di Jawa Barat dan seluruh Indonesia.'],
                ];
            @endphp
            @foreach ($whyUs as $w)
                <div class="about-card-lift bg-white p-6 rounded-xl shadow-md border-b-4 border-transparent hover:border-safety-orange transition-all duration-300 text-center group cursor-default">
                    <div class="w-16 h-16 bg-surface-gray rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-safety-orange/10 transition-colors duration-300">
                        <span class="material-symbols-outlined text-safety-orange" style="font-size:32px" aria-hidden="true">{{ $w['icon'] }}</span>
                    </div>
                    <h4 class="font-bold text-sm mb-2 text-on-surface">{{ $w['title'] }}</h4>
                    <p class="text-xs text-on-surface-variant leading-relaxed">{{ $w['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ================================================================
     ACHIEVEMENT STATS
================================================================ --}}
<section
    id="about-stats"
    class="py-stack-lg bg-primary text-white relative overflow-hidden"
    aria-label="Pencapaian STC"
>
    <div class="absolute inset-0 opacity-5 pointer-events-none" aria-hidden="true">
        <div class="absolute top-0 right-0 w-96 h-96 bg-safety-orange rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-industrial-blue-light rounded-full blur-3xl"></div>
    </div>
    <div class="relative z-10 max-w-container-max mx-auto px-gutter">
        <div class="text-center mb-14 about-reveal">
            <div class="flex items-center justify-center gap-3 mb-2">
                <span class="material-symbols-outlined text-safety-orange text-3xl about-float" aria-hidden="true">emoji_events</span>
                <span class="text-safety-orange font-bold tracking-widest text-sm uppercase">Pencapaian Kami</span>
            </div>
            <h2 class="text-2xl md:text-3xl font-bold mt-2 uppercase">Angka Berbicara</h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 about-stagger">
            @php
                $achievements = [
                    ['value' => '5000', 'suffix' => '+', 'label' => 'Alumni Bersertifikat',  'icon' => 'groups',       'bar' => '85%'],
                    ['value' => '50',   'suffix' => '+', 'label' => 'Program Pelatihan',     'icon' => 'menu_book',    'bar' => '70%'],
                    ['value' => '98',   'suffix' => '%', 'label' => 'Industrial Compliance', 'icon' => 'verified',     'bar' => '98%'],
                    ['value' => '15',   'suffix' => '+', 'label' => 'Tahun Pengalaman',      'icon' => 'history_edu',  'bar' => '75%'],
                ];
            @endphp
            @foreach ($achievements as $ach)
                <div class="text-center group">
                    <div class="w-20 h-20 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-safety-orange/20 transition-colors duration-300">
                        <span class="material-symbols-outlined text-safety-orange" style="font-size:36px" aria-hidden="true">{{ $ach['icon'] }}</span>
                    </div>
                    <p class="text-4xl font-bold text-safety-orange" data-about-counter="{{ $ach['value'] }}" data-suffix="{{ $ach['suffix'] }}">0</p>
                    <p class="text-sm text-white/70 mt-2 font-semibold">{{ $ach['label'] }}</p>
                    <div class="mt-3 h-1.5 bg-white/10 rounded-full overflow-hidden">
                        <div class="h-full bg-safety-orange about-bar-fill rounded-full" style="--bar-width:{{ $ach['bar'] }}"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ================================================================
     SERTIFIKASI & AKREDITASI
================================================================ --}}
<section
    id="about-certification"
    class="py-stack-lg bg-surface-gray"
    aria-label="Sertifikasi dan Akreditasi"
>
    <div class="max-w-container-max mx-auto px-gutter">
        <div class="text-center mb-14 about-reveal">
            <div class="flex items-center justify-center gap-3 mb-2">
                <span class="material-symbols-outlined text-safety-orange text-3xl about-float" aria-hidden="true">workspace_premium</span>
                <span class="text-safety-orange font-bold tracking-widest text-sm uppercase">Pengakuan Nasional</span>
            </div>
            <h2 class="text-2xl md:text-3xl font-bold text-primary mt-2 uppercase">Sertifikasi &amp; Akreditasi</h2>
            <div class="w-24 h-1 bg-safety-orange mx-auto mt-4 rounded-full" aria-hidden="true"></div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 about-stagger">
            @forelse ($certifications as $cert)
                <div class="about-card-lift bg-white p-7 rounded-xl shadow-md text-center group">
                    <div class="w-20 h-20 mx-auto mb-4 flex items-center justify-center bg-surface-gray rounded-full group-hover:bg-safety-orange/10 transition-colors">
                        @if ($cert->logo)
                            <img src="{{ Storage::url($cert->logo) }}" alt="{{ e($cert->name) }}" class="w-14 h-14 object-contain" loading="lazy" />
                        @else
                            <img src="{{ asset('images/certifications/default.png') }}" alt="{{ e($cert->name) }}" class="w-14 h-14 object-contain" loading="lazy" />
                        @endif
                    </div>
                    <h4 class="font-bold text-sm text-on-surface">{{ e($cert->name) }}</h4>
                    <p class="text-xs text-on-surface-variant mt-1">{{ e($cert->issuer) }}</p>
                </div>
            @empty
                @php
                    $dummyCerts = [
                        ['name' => 'BNSP',          'issuer' => 'Badan Nasional Sertifikasi Profesi', 'image' => 'images/logo-bnsp.png'],
                        ['name' => 'Kemnaker RI',   'issuer' => 'Kementerian Ketenagakerjaan',        'image' => 'images/logo-kemenaker.png'],
                        ['name' => 'ISO 9001:2015', 'issuer' => 'International Organization',         'image' => 'images/logo-iso.png'],
                        ['name' => 'MIGAS Certified','issuer' => 'Kementerian ESDM RI',              'image' => 'images/logo-esdm.png'],
                    ];
                @endphp
                @foreach ($dummyCerts as $c)
                    <div class="about-card-lift bg-white p-7 rounded-xl shadow-md text-center group">
                        <div class="w-20 h-20 mx-auto mb-4 flex items-center justify-center bg-surface-gray rounded-full group-hover:bg-safety-orange/10 transition-colors">
                            <img src="{{ asset($c['image']) }}" alt="{{ $c['name'] }}" class="w-14 h-14 object-contain" loading="lazy" />
                        </div>
                        <h4 class="font-bold text-sm text-on-surface">{{ $c['name'] }}</h4>
                        <p class="text-xs text-on-surface-variant mt-1">{{ $c['issuer'] }}</p>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>


{{-- ================================================================
     TEAM / INSTRUKTUR
================================================================ --}}
<section
    id="about-team"
    class="py-stack-lg bg-surface-container-lowest"
    aria-label="Tim Instruktur"
>
    <div class="max-w-container-max mx-auto px-gutter">
        <div class="text-center mb-14 about-reveal">
            <div class="flex items-center justify-center gap-3 mb-2">
                <span class="material-symbols-outlined text-safety-orange text-3xl about-float" aria-hidden="true">groups</span>
                <span class="text-safety-orange font-bold tracking-widest text-sm uppercase">Tim Kami</span>
            </div>
            <h2 class="text-2xl md:text-3xl font-bold text-primary mt-2 uppercase">Instruktur Profesional</h2>
            <p class="text-on-surface-variant text-base max-w-2xl mx-auto mt-3">Didukung oleh para ahli dan praktisi berpengalaman langsung dari industri.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 about-stagger">
            @forelse ($instructors ?? [] as $instructor)
                <div class="about-card-lift bg-white rounded-xl shadow-md overflow-hidden group text-center">
                    <div class="relative h-56 overflow-hidden">
                        <img
                            src="{{ $instructor->photo ? Storage::url($instructor->photo) : asset('images/placeholder-instructor.jpg') }}"
                            alt="{{ e($instructor->name) }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                            loading="lazy"
                        />
                        <div class="absolute inset-0 bg-primary/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span class="material-symbols-outlined text-white" style="font-size:48px" aria-hidden="true">person</span>
                        </div>
                    </div>
                    <div class="p-5">
                        <h4 class="font-bold text-base text-on-surface">{{ e($instructor->name) }}</h4>
                        <p class="text-xs text-safety-orange font-semibold mt-1">{{ e($instructor->expertise) }}</p>
                        <p class="text-xs text-on-surface-variant mt-2 leading-relaxed">{{ e($instructor->bio ?? '') }}</p>
                    </div>
                </div>
            @empty
                @php
                    $dummyInstructors = [
                        ['name' => 'Ir. Budi Santoso, M.T.',   'expertise' => 'Oil & Gas Specialist',           'icon' => 'engineering'],
                        ['name' => 'Rina Kusuma, S.T.',         'expertise' => 'K3 & HSE Professional',          'icon' => 'health_and_safety'],
                        ['name' => 'Agus Wibowo, S.T.',         'expertise' => 'Welding & Fabrication Expert',   'icon' => 'hardware'],
                        ['name' => 'Dewi Rahayu, S.T., M.T.',  'expertise' => 'Electrical & Instrumentation',   'icon' => 'electrical_services'],
                    ];
                @endphp
                @foreach ($dummyInstructors as $instr)
                    <div class="about-card-lift bg-white rounded-xl shadow-md overflow-hidden group text-center">
                        <div class="relative h-52 bg-gradient-to-br from-primary-container to-primary overflow-hidden flex items-center justify-center">
                            <span class="material-symbols-outlined text-white/40 group-hover:text-safety-orange/60 transition-colors duration-300" style="font-size:96px" aria-hidden="true">{{ $instr['icon'] }}</span>
                        </div>
                        <div class="p-5">
                            <h4 class="font-bold text-sm text-on-surface">{{ $instr['name'] }}</h4>
                            <p class="text-xs text-safety-orange font-semibold mt-1">{{ $instr['expertise'] }}</p>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>


{{-- ================================================================
     CTA
================================================================ --}}
<section
    id="about-cta"
    class="py-stack-lg bg-safety-orange text-white text-center relative overflow-hidden"
    aria-label="Hubungi Kami"
>
    <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
        <div class="absolute -top-16 -right-16 w-64 h-64 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-16 -left-16 w-64 h-64 bg-white/10 rounded-full blur-2xl"></div>
    </div>
    <div class="relative z-10 max-w-container-max mx-auto px-gutter space-y-6 about-reveal">
        <span class="material-symbols-outlined about-float text-white/50 block mx-auto" style="font-size:52px" aria-hidden="true">rocket_launch</span>
        <h2 class="text-2xl md:text-3xl font-bold leading-snug">
            Bergabunglah Bersama STC Indonesia<br />dan Wujudkan Karier Industri Impianmu
        </h2>
        <p class="text-base max-w-2xl mx-auto opacity-90 leading-relaxed">
            Lebih dari 5.000 alumni telah membuktikan kualitas pelatihan STC. Saatnya giliran Anda.
        </p>
        <div class="flex flex-wrap justify-center gap-4 pt-4">
            <a
                href="{{ route('programs.index') }}"
                class="bg-primary text-on-primary px-8 py-3.5 rounded-lg font-bold text-base hover:bg-primary-container transition-all duration-200 shadow-2xl hover:-translate-y-1 active:translate-y-0 flex items-center gap-3"
            >
                <span class="material-symbols-outlined text-xl" aria-hidden="true">school</span>
                Lihat Program Pelatihan
            </a>
            <a
                href="tel:+628112021212"
                class="bg-white text-safety-orange px-8 py-3.5 rounded-lg font-bold text-base hover:bg-surface-gray transition-all duration-200 hover:-translate-y-1 flex items-center gap-3"
            >
                <span class="material-symbols-outlined text-xl" aria-hidden="true">call</span>
                Hubungi Kami
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
    @vite(['resources/js/about.js'])
@endpush