{{-- resources/views/certification/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Sertifikasi Kompetensi Industri - STC Indonesia')

@section('content')

<style>
    .cert-reveal { opacity: 0; transform: translateY(40px); transition: opacity 0.7s cubic-bezier(.22,1,.36,1), transform 0.7s cubic-bezier(.22,1,.36,1); }
    .cert-reveal.visible { opacity: 1; transform: none; }
    .stc-card-lift { transition: transform .3s cubic-bezier(.22,1,.36,1), box-shadow .3s ease; }
    .stc-card-lift:hover { transform: translateY(-6px); box-shadow: 0 20px 40px -10px rgba(0,0,0,.15); }
    .industrial-pattern { background-image: radial-gradient(rgba(42,82,152,0.08) 1px, transparent 1px); background-size: 24px 24px; }
    .gradient-text { background: linear-gradient(to right, #002046, #2A5298); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    @keyframes stcFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
    .stc-float { animation: stcFloat 3s ease-in-out infinite; }

    .cert-card {
        transition:
            opacity .3s ease,
            transform .3s ease,
            box-shadow .3s ease;
    }
</style>

{{-- ================================================================
     HERO SECTION
================================================================ --}}
<section class="relative pt-28 pb-32 overflow-hidden bg-primary" aria-label="Hero Sertifikasi">
    <div class="absolute inset-0 z-0 opacity-20 bg-cover bg-center"
         style="background-image:url('{{ asset('images/certification/hero-bg.jpg') }}')"></div>
    <div class="absolute right-0 top-0 w-1/2 h-full bg-gradient-to-l from-industrial-blue-light/30 to-transparent z-0"></div>

    <div class="max-w-container-max mx-auto px-gutter relative z-10">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 mb-6 backdrop-blur-sm">
                <span class="material-symbols-outlined text-safety-orange text-sm" aria-hidden="true">workspace_premium</span>
                <span class="text-white font-semibold text-xs uppercase tracking-wider">Program Sertifikasi Resmi</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-6 leading-tight">
                Sertifikasi Kompetensi <span class="text-safety-orange">Industri</span>
            </h1>
            <p class="text-lg text-white/90 mb-10 max-w-2xl leading-relaxed">
                Tingkatkan kualifikasi dan standar keselamatan tenaga kerja Anda dengan program sertifikasi yang diakui secara nasional. Kami bermitra dengan lembaga berwenang untuk memastikan kepatuhan regulasi dan keunggulan operasional.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="#categories"
                   class="bg-safety-orange text-white px-8 py-4 rounded-lg font-semibold uppercase text-sm hover:bg-orange-600 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 inline-flex items-center gap-2">
                    Lihat Program
                    <span class="material-symbols-outlined text-sm" aria-hidden="true">arrow_downward</span>
                </a>
                <a href="#consultation"
                   class="bg-white/10 text-white border border-white/30 px-8 py-4 rounded-lg font-semibold uppercase text-sm hover:bg-white/20 transition-all backdrop-blur-sm inline-flex items-center gap-2">
                    Konsultasi Program
                    <span class="material-symbols-outlined text-sm" aria-hidden="true">forum</span>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     METHODOLOGY BRIEF (lifted card, sama dengan program/index)
================================================================ --}}
<section class="py-10 bg-surface-container-lowest border-b border-surface-variant relative z-20 -mt-10 mx-4 md:mx-auto max-w-5xl rounded-xl shadow-lg">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 px-8">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-lg bg-primary/5 text-primary flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-2xl" aria-hidden="true">verified</span>
            </div>
            <div>
                <h3 class="font-bold text-lg text-on-surface mb-1">Diakui Nasional</h3>
                <p class="text-on-surface-variant text-sm">Sertifikat diterbitkan oleh lembaga resmi BNSP dan Kemnaker yang berlaku di seluruh Indonesia.</p>
            </div>
        </div>
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-lg bg-safety-orange/10 text-safety-orange flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-2xl" aria-hidden="true">build</span>
            </div>
            <div>
                <h3 class="font-bold text-lg text-on-surface mb-1">Standar Industri</h3>
                <p class="text-on-surface-variant text-sm">Kurikulum mengacu pada standar keselamatan dan operasional industri berat terkini.</p>
            </div>
        </div>
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-lg bg-industrial-blue-light/10 text-industrial-blue-light flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-2xl" aria-hidden="true">workspace_premium</span>
            </div>
            <div>
                <h3 class="font-bold text-lg text-on-surface mb-1">Instruktur Bersertifikat</h3>
                <p class="text-on-surface-variant text-sm">Dibimbing oleh instruktur berpengalaman yang telah tersertifikasi di bidangnya.</p>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     KATEGORI SERTIFIKASI — GRID
================================================================ --}}
<section id="categories" class="py-24 bg-surface-gray industrial-pattern" aria-label="Kategori Sertifikasi">
    <div class="max-w-container-max mx-auto px-gutter">

        <div class="text-center mb-16 cert-reveal">
            <h2 class="text-4xl md:text-5xl font-bold text-primary mb-4">
                Pilihan <span class="gradient-text">Kategori Sertifikasi</span>
            </h2>
            <p class="text-lg text-on-surface-variant max-w-2xl mx-auto">
                Program sertifikasi kami dirancang khusus untuk memenuhi standar ketat di berbagai sektor industri berat,
                memastikan setiap peserta siap menghadapi tantangan riil di lapangan.
            </p>
        </div>

        @php
            $dummyCategories = [
                [
                    'slug'        => 'bnsp',
                    'accent'      => 'border-primary',
                    'logo_text'   => 'BNSP',
                    'badge_icon'  => 'verified',
                    'badge_label' => 'Nasional',
                    'badge_color' => 'bg-primary/10 text-primary',
                    'name'        => 'Badan Nasional Sertifikasi Profesi (BNSP)',
                    'description' => 'Pelatihan persiapan sertifikasi kompetensi profesi yang mengacu pada standar BNSP. Meningkatkan pengakuan kompetensi secara nasional, daya saing tenaga kerja, dan mendukung kebutuhan industri.',
                    'items'       => ['Electrical & Mechanical', 'Troubleshooting & Maintenance'],
                    'cover'       => null,
                    'cover_badge' => null,
                    'cert_count'  => 8,
                ],
                [
                    'slug'        => 'kemnaker',
                    'accent'      => 'border-safety-orange',
                    'logo_text'   => 'KEMNAKER',
                    'badge_icon'  => 'gavel',
                    'badge_label' => 'Regulasi',
                    'badge_color' => 'bg-safety-orange/10 text-safety-orange',
                    'name'        => 'Kementerian Ketenagakerjaan (KEMNAKER)',
                    'description' => 'Mendukung peningkatan kompetensi melalui pembinaan regulasi. Fokus pada kepatuhan K3, budaya keselamatan, dan standar operasional alat berat.',
                    'items'       => ['Ahli K3 Umum & Spesialis', 'Operator Alat Berat (Forklift, Crane)'],
                    'cover'       => null,
                    'cover_badge' => null,
                    'cert_count'  => 6,
                ],
                [
                    'slug'        => 'kpdm-oil-gas',
                    'accent'      => 'border-deep-slate',
                    'logo_text'   => null,
                    'badge_icon'  => null,
                    'badge_label' => 'SPESIALIS',
                    'badge_color' => 'bg-primary text-white',
                    'name'        => 'KPDM - Oil and Gas Explosives Technician',
                    'description' => 'Sertifikasi khusus untuk teknisi bahan peledak di sektor minyak dan gas. Memastikan prosedur penanganan yang aman dan sesuai standar tinggi industri energi.',
                    'items'       => [],
                    'cover'       => 'images/certification/kpdm-cover.jpg',
                    'cover_badge' => 'SPESIALIS',
                    'cert_count'  => 3,
                ],
                [
                    'slug'        => 'scaffolding-heights-rigging',
                    'accent'      => 'border-industrial-blue-light',
                    'logo_text'   => null,
                    'badge_icon'  => null,
                    'badge_label' => 'BNSP & KEMNAKER',
                    'badge_color' => 'bg-primary text-white',
                    'name'        => 'Scaffolding, Working at Heights & Rigging',
                    'description' => 'Program komprehensif dari LSP Promigas, Migas, dan K3 Nasional untuk mencegah kecelakaan kerja. Mencakup teknik instalasi, pengangkatan beban, dan prosedur keselamatan bekerja di ketinggian.',
                    'items'       => [],
                    'cover'       => 'images/certification/scaffolding-cover.jpg',
                    'cover_badge' => 'BNSP & KEMNAKER',
                    'cert_count'  => 5,
                ],
            ];

            $displayCategories = (isset($categories) && $categories->isNotEmpty())
                ? $categories
                : collect($dummyCategories);
        @endphp

        {{-- Kategori Sertifikasi Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="cert-grid">

            @forelse ($displayCategories as $cat)
                @php
                    $isModel     = $cat instanceof \App\Models\CertificationCategory;

                    $slug        = $isModel ? $cat->slug                                  : $cat['slug'];
                    $accent      = $isModel ? 'border-industrial-blue-light'               : $cat['accent'];
                    $logoText    = $isModel ? null                                         : ($cat['logo_text'] ?? null);
                    $logo        = $isModel ? $cat->logo                                   : null;
                    $badgeIcon   = $isModel ? ($cat->badge_icon ?? 'verified')             : ($cat['badge_icon'] ?? null);
                    $badgeLabel  = $isModel ? ($cat->badge_label ?? '')                    : ($cat['badge_label'] ?? '');
                    $badgeColor  = $isModel ? 'bg-primary/10 text-primary'                 : ($cat['badge_color'] ?? 'bg-primary/10 text-primary');
                    $name        = $isModel ? $cat->name                                   : $cat['name'];
                    $description = $isModel ? ($cat->description ?? '')                    : $cat['description'];
                    $items       = $isModel ? []                                           : ($cat['items'] ?? []);
                    $cover       = $isModel ? ($cat->cover_image ?? null)                  : ($cat['cover'] ?? null);
                    $coverBadge  = $isModel ? ($cat->badge_label ?? null)                  : ($cat['cover_badge'] ?? null);
                    $certCount   = $isModel ? $cat->items->count()                         : ($cat['cert_count'] ?? 0);
                    $hasCover    = !empty($cover);
                    $coverUrl    = $isModel
                                    ? ($cat->cover_image ? Storage::url($cat->cover_image) : null)
                                    : ($cover ? asset($cover) : null);
                @endphp

                <div
                    class="group relative overflow-hidden rounded-2xl bg-white shadow-sm hover:shadow-2xl transition-all duration-300 border-t-4 {{ $accent }} flex flex-col h-full stc-card-lift cert-card"
                    data-category="{{ $slug }}"
                >
                    {{-- Thumbnail --}}
                    <div class="relative h-48 overflow-hidden bg-surface-variant">

                        @if ($hasCover && $coverUrl)
                            <img
                                src="{{ $coverUrl }}"
                                alt="{{ e($name) }}"
                                class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                loading="lazy"
                            />
                        @else
                            {{-- Fallback: logo / text placeholder --}}
                            <div class="w-full h-full bg-gradient-to-br from-primary to-deep-slate flex items-center justify-center">
                                @if ($logo)
                                    <img src="{{ Storage::url($logo) }}" alt="{{ e($name) }}" class="h-20 object-contain" loading="lazy" />
                                @elseif ($logoText)
                                    <span class="text-4xl font-bold text-white/80 tracking-tight">{{ $logoText }}</span>
                                @else
                                    <span class="material-symbols-outlined text-white/60" style="font-size:64px" aria-hidden="true">workspace_premium</span>
                                @endif
                            </div>
                        @endif

                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                        <div class="absolute bottom-4 left-4 right-4 flex items-end justify-between">
                            <h3 class="text-lg font-bold text-white leading-snug line-clamp-2 flex-1 pr-2">
                                {{ e($name) }}
                            </h3>
                            @if ($badgeLabel)
                                <span class="{{ $badgeColor }} text-xs font-bold px-2 py-1 rounded shrink-0">
                                    {{ $badgeLabel }}
                                </span>
                            @endif
                        </div>

                    </div>

                    {{-- Content --}}
                    <div class="p-6 flex flex-col flex-grow bg-white">

                        {{-- Description --}}
                        <p class="text-sm text-on-surface-variant leading-relaxed mb-5 flex-grow">
                            {{ Str::limit(e($description), 120) }}
                        </p>

                        {{-- Checklist items (if any) --}}
                        @if (!empty($items))
                            <ul class="space-y-1.5 mb-5" role="list">
                                @foreach ($items as $item)
                                    <li class="flex items-center gap-2 text-sm text-on-surface-variant">
                                        <span class="material-symbols-outlined text-safety-orange text-sm" aria-hidden="true">check_circle</span>
                                        {{ e($item) }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        {{-- Cert count --}}
                        <div class="flex items-center gap-2 mb-5 text-sm text-on-surface-variant">
                            <span class="material-symbols-outlined text-industrial-blue-light" aria-hidden="true">workspace_premium</span>
                            <span>{{ $certCount }} Program Sertifikasi</span>
                        </div>

                        {{-- CTA --}}
                        <a
                            href="{{ route('certification.category', $slug) }}"
                            class="inline-flex items-center gap-2 text-industrial-blue-light font-semibold uppercase text-sm hover:text-primary transition-colors group/link mt-auto"
                        >
                            Lihat Daftar Sertifikasi
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
                    <span class="material-symbols-outlined text-6xl text-outline mb-4" aria-hidden="true">workspace_premium</span>
                    <h3 class="text-2xl font-bold text-on-surface mb-2">Belum Ada Kategori Sertifikasi</h3>
                    <p class="text-on-surface-variant">Data kategori sertifikasi belum tersedia.</p>
                </div>

            @endforelse

        </div>

    </div>
</section>

{{-- ================================================================
     CONSULTATION CTA (sama persis dengan program/index)
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