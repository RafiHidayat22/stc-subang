{{-- resources/views/articles/show.blade.php --}}
@extends('layouts.app')

@section('title', e($article->title) . ' — STC Indonesia')
@section('meta_description', e(Str::limit($article->excerpt, 160)))

@section('content')

<style>
    /* Scroll reveal */
    .art-reveal { opacity: 0; transform: translateY(24px); transition: opacity .6s cubic-bezier(.22,1,.36,1), transform .6s cubic-bezier(.22,1,.36,1); }
    .art-reveal.visible { opacity: 1; transform: none; }

    /* Shrink header on scroll (JS applies via data attr) */
    header.scrolled { padding-top:.5rem; padding-bottom:.5rem; }

    /* Prose styling for article body */
    .article-body h2 {
        font-size: 1.6rem;
        font-weight: 700;
        color: #002046;
        margin-top: 2.5rem;
        margin-bottom: 1rem;
        line-height: 1.3;
    }
    .article-body h3 {
        font-size: 1.2rem;
        font-weight: 700;
        color: #002046;
        margin-top: 2rem;
        margin-bottom: .75rem;
    }
    .article-body p {
        margin-bottom: 1.25rem;
        line-height: 1.8;
        color: #44474e;
    }
    .article-body ul {
        list-style: none;
        padding: 0;
        margin-bottom: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .article-body ul li {
        display: flex;
        align-items: flex-start;
        gap: .75rem;
        color: #44474e;
        line-height: 1.7;
    }
    .article-body ul li::before {
        content: 'check_circle';
        font-family: 'Material Symbols Outlined';
        font-size: 1.25rem;
        color: #F96302;
        flex-shrink: 0;
        margin-top: 2px;
    }
    .article-body blockquote {
        background: #F4F7F9;
        border-left: 4px solid #F96302;
        padding: 1.5rem 2rem;
        border-radius: .5rem;
        margin: 2rem 0;
        font-style: italic;
        font-weight: 500;
        color: #002046;
    }
    .article-body a { color: #2A5298; text-decoration: underline; }

    /* Card hover */
    .related-card { transition: transform .3s cubic-bezier(.22,1,.36,1), box-shadow .3s ease; }
    .related-card:hover { transform: translateY(-4px); box-shadow: 0 12px 28px -6px rgba(0,0,0,.13); }

    /* Line clamp */
    .line-clamp-2 { display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }

    @keyframes artFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-6px)} }
    .art-float { animation: artFloat 3s ease-in-out infinite; }

    /* ── Breadcrumb dark bar (sama dengan detail_certification) ── */
    .catpage-breadcrumb-bar {
        background: linear-gradient(90deg, #0D1B2A 0%, #1b365d 100%);
        border-bottom: 1px solid rgba(249,99,2,.25);
    }
</style>

<main class="pb-stack-lg">

    {{-- ── BREADCRUMB (dark bar — sama dengan detail_certification) ──────── --}}
    <nav class="catpage-breadcrumb-bar pt-20" aria-label="Breadcrumb">
        <div class="max-w-container-max mx-auto px-gutter py-3">
            <ol class="flex items-center gap-2 text-xs font-semibold flex-wrap" itemscope itemtype="https://schema.org/BreadcrumbList">
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
                    <a href="{{ route('articles.index') }}" itemprop="item"
                       class="text-white/60 hover:text-safety-orange transition-colors">
                        <span itemprop="name">Artikel</span>
                    </a>
                    <meta itemprop="position" content="2" />
                </li>
                @if ($article->category)
                    <span class="material-symbols-outlined text-sm text-white/30" aria-hidden="true">chevron_right</span>
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a href="{{ route('articles.index', ['category' => $article->category->slug]) }}" itemprop="item"
                           class="text-white/60 hover:text-safety-orange transition-colors">
                            <span itemprop="name">{{ e($article->category->name) }}</span>
                        </a>
                        <meta itemprop="position" content="3" />
                    </li>
                    <span class="material-symbols-outlined text-sm text-white/30" aria-hidden="true">chevron_right</span>
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <span itemprop="name" class="text-safety-orange font-bold truncate max-w-[200px]">{{ e(Str::limit($article->title, 60)) }}</span>
                        <meta itemprop="position" content="4" />
                    </li>
                @else
                    <span class="material-symbols-outlined text-sm text-white/30" aria-hidden="true">chevron_right</span>
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <span itemprop="name" class="text-safety-orange font-bold truncate max-w-[200px]">{{ e(Str::limit($article->title, 60)) }}</span>
                        <meta itemprop="position" content="3" />
                    </li>
                @endif
            </ol>
        </div>
    </nav>

    {{-- ── HERO SECTION (sama dengan detail_certification) ───────────────── --}}
    <section class="relative bg-deep-slate text-on-primary overflow-hidden pb-16 md:pb-24">
        <div class="absolute inset-0 bg-gradient-to-r from-deep-slate via-primary to-industrial-blue-light opacity-90 z-0" aria-hidden="true"></div>
        {{-- Dot pattern --}}
        <div class="absolute inset-0 z-0 opacity-10 pointer-events-none"
             style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 20px 20px;"
             aria-hidden="true"></div>

        <div class="relative z-10 w-full px-gutter max-w-container-max mx-auto py-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                {{-- Left: Info --}}
                <div class="space-y-6">
                    <div class="flex items-center gap-4 art-reveal">
                        @if ($article->category)
                            <span class="bg-surface-container-lowest text-primary px-3 py-1.5 rounded-full font-label-sm uppercase tracking-wider flex items-center gap-2 shadow-sm text-xs">
                                <span class="material-symbols-outlined text-[16px] text-safety-orange" aria-hidden="true">article</span>
                                {{ e($article->category->name) }}
                            </span>
                        @endif
                        <span class="text-white/60 text-xs font-semibold flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm" aria-hidden="true">visibility</span>
                            {{ number_format($article->views) }} views
                        </span>
                    </div>

                    <h1 class="font-display-lg text-4xl md:text-[52px] leading-tight text-white art-reveal" style="transition-delay:.1s">
                        {{ e($article->title) }}
                    </h1>

                    <p class="font-body-lg text-body-lg text-surface-variant max-w-xl art-reveal" style="transition-delay:.2s">
                        {{ e(Str::limit($article->excerpt, 180)) }}
                    </p>

                    {{-- Author row --}}
                    <div class="flex items-center gap-3 art-reveal" style="transition-delay:.3s">
                        <div
                            class="w-10 h-10 rounded-full bg-safety-orange flex items-center justify-center text-white font-bold text-sm flex-shrink-0"
                            aria-hidden="true"
                        >
                            {{ $article->author_initials }}
                        </div>
                        <div>
                            <p class="font-bold text-white font-body-md text-body-md">{{ e($article->author_name) }}</p>
                            <p class="text-white/60 text-label-sm font-label-sm">{{ e($article->author_role) }} · {{ $article->published_date }}</p>
                        </div>

                        {{-- Share buttons --}}
                        <div class="ml-auto flex items-center gap-2" aria-label="Bagikan artikel">
                            <span class="text-xs text-white/40 hidden md:block">Bagikan:</span>
                            <button
                                type="button"
                                onclick="articleShare('whatsapp')"
                                class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-green-500 hover:text-white transition-colors"
                                aria-label="Bagikan via WhatsApp"
                            >
                                <span class="material-symbols-outlined text-sm text-white" aria-hidden="true">share</span>
                            </button>
                            <button
                                type="button"
                                onclick="articleShare('copy')"
                                class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-industrial-blue-light hover:text-white transition-colors"
                                aria-label="Salin tautan"
                                id="copy-btn"
                            >
                                <span class="material-symbols-outlined text-sm text-white" aria-hidden="true">link</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Right: Featured Image --}}
                <div class="hidden lg:block relative art-reveal" style="transition-delay:.4s">
                    <div class="absolute -top-4 -right-4 w-24 h-24 bg-safety-orange/20 rounded-full blur-xl" aria-hidden="true"></div>
                    <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-industrial-blue-light/30 rounded-full blur-2xl" aria-hidden="true"></div>
                    <div class="bg-surface-container-lowest rounded-lg p-2 shadow-2xl relative z-10 border border-outline-variant/20 transform rotate-2 hover:rotate-0 transition-transform duration-500">
                        <img
                            src="{{ $article->featured_image_url }}"
                            alt="{{ e($article->title) }}"
                            class="rounded w-full h-auto object-cover aspect-[4/3]"
                            loading="eager"
                        />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="max-w-container-max mx-auto px-gutter mt-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">

            {{-- ================================================================
                 MAIN ARTICLE CONTENT
            ================================================================ --}}
            <article class="lg:col-span-8 bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden p-6 md:p-10 art-reveal">

                {{-- Featured Image (mobile only — hero sudah menampilkan di desktop) --}}
                <div class="mb-10 rounded-lg overflow-hidden shadow-md lg:hidden">
                    <img
                        src="{{ $article->featured_image_url }}"
                        alt="{{ e($article->title) }}"
                        class="w-full h-auto object-cover"
                        loading="eager"
                    />
                </div>

                {{-- Body HTML --}}
                <div class="article-body text-body-lg max-w-none space-y-4">
                    {!! $article->body !!}
                </div>

                {{-- Tags footer --}}
                @if (! empty($article->tags))
                    <footer class="mt-12 pt-8 border-t border-outline-variant">
                        <div class="flex flex-wrap gap-2" aria-label="Tag artikel">
                            @foreach ($article->tags as $tag)
                                <span class="bg-surface-container text-on-surface-variant px-4 py-1 rounded-full text-label-sm font-label-sm">
                                    {{ e($tag) }}
                                </span>
                            @endforeach
                        </div>
                    </footer>
                @endif

            </article>

            {{-- ================================================================
                 SIDEBAR
            ================================================================ --}}
            <aside class="lg:col-span-4 space-y-gutter" aria-label="Sidebar artikel">

                {{-- CTA Card --}}
                <div class="bg-primary p-8 rounded-xl text-on-primary shadow-lg sticky top-28">
                    <div class="w-12 h-12 bg-safety-orange rounded-lg flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-on-primary text-3xl art-float" aria-hidden="true">school</span>
                    </div>
                    <h4 class="font-headline-lg text-headline-lg mb-4">Ingin meningkatkan kompetensi?</h4>
                    <p class="text-on-primary/80 font-body-md text-body-md mb-8 leading-relaxed">
                        Dapatkan sertifikasi resmi BNSP dan jadilah profesional yang diakui industri global. Daftar sekarang untuk jadwal batch berikutnya.
                    </p>
                    <a
                        href="{{ route('programs.index') }}"
                        class="block w-full bg-safety-orange hover:bg-white hover:text-safety-orange text-center py-4 rounded-lg font-bold transition-all duration-300 transform hover:-translate-y-1"
                    >
                        Daftar Training Sekarang
                    </a>
                </div>

                {{-- Trending / Most Viewed --}}
                @if ($trending->isNotEmpty())
                    <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm">
                        <h4 class="font-title-md text-title-md text-primary mb-6 flex items-center gap-2">
                            <span class="material-symbols-outlined text-safety-orange" aria-hidden="true">trending_up</span>
                            Artikel Populer
                        </h4>
                        <ol class="space-y-4" aria-label="Artikel paling populer">
                            @foreach ($trending as $i => $t)
                                <li class="flex gap-3 items-start">
                                    <span class="text-2xl font-bold text-outline-variant leading-none mt-1 w-6 flex-shrink-0" aria-hidden="true">
                                        {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                    <div>
                                        <a
                                            href="{{ route('articles.show', $t->slug) }}"
                                            class="font-bold text-sm text-on-surface hover:text-industrial-blue-light transition-colors leading-snug line-clamp-2"
                                        >
                                            {{ e($t->title) }}
                                        </a>
                                        <p class="text-xs text-outline mt-1">{{ $t->published_date }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                @endif

                {{-- Alumni Stats --}}
                <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm">
                    <h4 class="font-title-md text-title-md text-primary mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined" aria-hidden="true">analytics</span>
                        Statistik Alumni
                    </h4>
                    <div class="space-y-6">
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-on-surface-variant font-body-md text-sm">Tingkat Kelulusan</span>
                                <span class="font-bold text-industrial-blue-light">98%</span>
                            </div>
                            <div class="w-full bg-surface-variant h-2 rounded-full overflow-hidden" role="progressbar" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100">
                                <div class="bg-industrial-blue-light h-full rounded-full" style="width:98%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-on-surface-variant font-body-md text-sm">Penempatan Kerja</span>
                                <span class="font-bold text-industrial-blue-light">85%</span>
                            </div>
                            <div class="w-full bg-surface-variant h-2 rounded-full overflow-hidden" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                                <div class="bg-industrial-blue-light h-full rounded-full" style="width:85%"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </aside>

        </div>
    </div>

    {{-- ================================================================
         RELATED ARTICLES
    ================================================================ --}}
    @if ($related->isNotEmpty())
        <section class="mt-stack-lg bg-surface-container-low py-16" aria-label="Artikel Terkait">
            <div class="max-w-container-max mx-auto px-gutter">
                <div class="flex justify-between items-end mb-10 gap-4">
                    <div>
                        <h2 class="font-headline-lg text-headline-lg text-primary uppercase">Artikel Terkait</h2>
                        <div class="w-20 h-1 bg-safety-orange mt-2 rounded-full" aria-hidden="true"></div>
                    </div>
                    <a
                        class="text-industrial-blue-light font-bold hover:underline flex items-center gap-1 text-sm shrink-0"
                        href="{{ route('articles.index') }}"
                    >
                        Lihat Semua Artikel
                        <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
                    @foreach ($related as $rel)
                        <div class="related-card bg-surface-container-lowest rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 group overflow-hidden">
                            <div class="aspect-video relative overflow-hidden rounded-t-lg">
                                <img
                                    src="{{ $rel->thumbnail_url }}"
                                    alt="{{ e($rel->title) }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    loading="lazy"
                                />
                            </div>
                            <div class="p-6">
                                @if ($rel->category)
                                    <span class="text-label-sm font-label-sm text-safety-orange uppercase">
                                        {{ e($rel->category->name) }}
                                    </span>
                                @endif
                                <h3 class="font-title-md text-title-md text-primary mt-2 mb-4 group-hover:text-industrial-blue-light transition-colors leading-snug">
                                    <a href="{{ route('articles.show', $rel->slug) }}">{{ e($rel->title) }}</a>
                                </h3>
                                <p class="text-on-surface-variant text-body-md line-clamp-2 text-sm">
                                    {{ e($rel->excerpt) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

</main>

@endsection

@push('scripts')
    @vite(['resources/js/article-detail.js'])
@endpush