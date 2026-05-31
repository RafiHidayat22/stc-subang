{{-- resources/views/contact/index.blade.php --}}
@extends('layouts.app')

@section('content')

{{-- ================================================================
     CONTACT PAGE STYLES
================================================================ --}}
<style>
    /* ── Scroll reveal ── */
    .ctc-reveal {
        opacity: 0;
        transform: translateY(40px);
        transition: opacity 0.7s cubic-bezier(.22,1,.36,1), transform 0.7s cubic-bezier(.22,1,.36,1);
    }
    .ctc-reveal.visible { opacity: 1; transform: none; }

    .ctc-reveal-left  { opacity: 0; transform: translateX(-50px); transition: opacity 0.7s cubic-bezier(.22,1,.36,1), transform 0.7s cubic-bezier(.22,1,.36,1); }
    .ctc-reveal-right { opacity: 0; transform: translateX(50px);  transition: opacity 0.7s cubic-bezier(.22,1,.36,1), transform 0.7s cubic-bezier(.22,1,.36,1); }
    .ctc-reveal-left.visible, .ctc-reveal-right.visible { opacity: 1; transform: none; }

    .ctc-stagger > * { opacity: 0; transform: translateY(30px); transition: opacity 0.6s cubic-bezier(.22,1,.36,1), transform 0.6s cubic-bezier(.22,1,.36,1); }
    .ctc-stagger.visible > *:nth-child(1) { opacity:1; transform:none; transition-delay:.05s }
    .ctc-stagger.visible > *:nth-child(2) { opacity:1; transform:none; transition-delay:.15s }
    .ctc-stagger.visible > *:nth-child(3) { opacity:1; transform:none; transition-delay:.25s }

    /* ── Icon float ── */
    @keyframes ctcFloat { 0%,100%{ transform:translateY(0) } 50%{ transform:translateY(-8px) } }
    .ctc-float { animation: ctcFloat 3s ease-in-out infinite }

    /* ── Card lift ── */
    .ctc-card-lift { transition: transform .3s cubic-bezier(.22,1,.36,1), box-shadow .3s ease }
    .ctc-card-lift:hover { transform: translateY(-6px); box-shadow: 0 20px 40px -10px rgba(0,0,0,.12) }

    /* ── Input focus glow ── */
    .ctc-input:focus { border-color: #002046; box-shadow: 0 0 0 3px rgba(0,32,70,.1); outline: none; }
    .ctc-input.is-invalid { border-color: #ba1a1a; }
    .ctc-input.is-invalid:focus { box-shadow: 0 0 0 3px rgba(186,26,26,.1); }

    /* ── Submit button loading ── */
    .ctc-btn-submit { position: relative; overflow: hidden; }
    .ctc-btn-submit.loading { pointer-events: none; }
    .ctc-btn-submit.loading .btn-text { opacity: 0; }
    .ctc-btn-submit.loading .btn-spinner { opacity: 1; }
    .btn-spinner { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity .2s; }

    @keyframes ctcSpin { to { transform: rotate(360deg) } }
    .ctc-spinner { width: 22px; height: 22px; border: 3px solid rgba(255,255,255,.3); border-top-color: #fff; border-radius: 50%; animation: ctcSpin .7s linear infinite; }

    /* ── Alert flash ── */
    .ctc-alert { animation: ctcAlertIn .4s cubic-bezier(.22,1,.36,1); }
    @keyframes ctcAlertIn { from { opacity:0; transform:translateY(-12px) } to { opacity:1; transform:none } }

    /* ── Map overlay ── */
    .ctc-map-card { transition: transform .35s cubic-bezier(.22,1,.36,1), box-shadow .3s ease; }

    /* ── CTA blobs ── */
    @keyframes ctcWave { 0%,100%{ border-radius:60% 40% 30% 70%/60% 30% 70% 40% } 50%{ border-radius:30% 60% 70% 40%/50% 60% 30% 60% } }
    .ctc-blob { position:absolute; animation:ctcWave 8s ease-in-out infinite; pointer-events:none }
</style>

{{-- ================================================================
     HERO SECTION
================================================================ --}}
<section
    class="relative bg-primary-container text-on-primary py-24 md:py-36 overflow-hidden"
    aria-label="Contact Hero"
>
    <div class="absolute inset-0 bg-gradient-to-r from-primary to-primary-container opacity-90 z-10" aria-hidden="true"></div>
    <img
        src="{{ asset('images/contact-hero.jpg') }}"
        alt="Kantor pusat STC Indonesia"
        class="absolute inset-0 w-full h-full object-cover z-0"
        loading="eager"
        fetchpriority="high"
    />
    {{-- Decorative blobs --}}
    <div class="ctc-blob absolute -right-24 -top-24 w-72 h-72 bg-safety-orange/10 z-10" style="animation-delay:-2s"></div>
    <div class="ctc-blob absolute -left-24 -bottom-24 w-56 h-56 bg-white/5 z-10" style="animation-delay:-5s"></div>

    <div class="relative z-20 max-w-container-max mx-auto px-gutter text-center space-y-5">
        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 px-4 py-1.5 rounded-full text-sm font-bold tracking-widest uppercase text-safety-orange ctc-reveal">
            <span class="material-symbols-outlined text-lg" aria-hidden="true">forum</span>
            Hubungi Kami
        </div>
        <h1 class="text-4xl md:text-5xl font-bold leading-tight ctc-reveal" style="transition-delay:.1s">
            Kami Siap Membantu<br />
            <span class="text-safety-orange">Kebutuhan Training Anda</span>
        </h1>
        <p class="text-base md:text-lg max-w-2xl mx-auto text-primary-fixed-dim leading-relaxed ctc-reveal" style="transition-delay:.2s">
            Hubungi tim STC Indonesia untuk informasi program pelatihan, jadwal sertifikasi, dan kerjasama corporate training.
        </p>
    </div>
</section>

{{-- ================================================================
     SUCCESS / ERROR FLASH MESSAGES
================================================================ --}}
@if (session('contact_success'))
    <div
        class="ctc-alert max-w-container-max mx-auto px-gutter mt-6"
        role="alert"
        aria-live="polite"
        id="contact-success-alert"
    >
        <div class="flex items-start gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 shadow-sm">
            <span class="material-symbols-outlined text-green-600 text-2xl flex-shrink-0" aria-hidden="true">check_circle</span>
            <div>
                <p class="font-bold text-sm">Pesan Berhasil Dikirim!</p>
                <p class="text-sm mt-0.5">{{ session('contact_success') }}</p>
            </div>
            <button
                class="ml-auto text-green-500 hover:text-green-700 transition-colors"
                onclick="document.getElementById('contact-success-alert').remove()"
                aria-label="Tutup notifikasi"
            >
                <span class="material-symbols-outlined text-xl" aria-hidden="true">close</span>
            </button>
        </div>
    </div>
@endif

@if ($errors->has('rate_limit'))
    <div class="ctc-alert max-w-container-max mx-auto px-gutter mt-6" role="alert">
        <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 shadow-sm">
            <span class="material-symbols-outlined text-red-500 text-2xl flex-shrink-0" aria-hidden="true">error</span>
            <p class="text-sm">{{ $errors->first('rate_limit') }}</p>
        </div>
    </div>
@endif

{{-- ================================================================
     CONTACT INFO CARDS  (overlap hero)
================================================================ --}}
<section
    class="max-w-container-max mx-auto px-gutter -mt-14 relative z-30"
    aria-label="Informasi Kontak"
>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 ctc-stagger">

        {{-- Address --}}
        <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-primary flex flex-col items-center text-center ctc-card-lift group">
            <div class="w-16 h-16 bg-surface-gray rounded-full flex items-center justify-center mb-5 group-hover:bg-primary/10 transition-colors duration-300">
                <span class="material-symbols-outlined text-primary text-3xl icon-fill ctc-float" aria-hidden="true">location_on</span>
            </div>
            <h3 class="text-lg font-bold mb-3 text-primary">Kunjungi Kami</h3>
            <p class="text-sm text-on-surface-variant leading-relaxed">
                Jl. Palabuan (Veteran) No.9, Sukamelang<br>
                Kec. Subang, Kabupaten Subang<br>
                Jawa Barat 41211
            </p>
            <a
                href="https://maps.google.com/?q=Subang+Training+Center"
                target="_blank"
                rel="noopener noreferrer"
                class="mt-4 text-primary text-sm font-bold flex items-center gap-1 hover:text-safety-orange transition-colors"
            >
                Buka di Maps <span class="material-symbols-outlined text-lg" aria-hidden="true">open_in_new</span>
            </a>
        </div>

        {{-- Email --}}
        <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-safety-orange flex flex-col items-center text-center ctc-card-lift group">
            <div class="w-16 h-16 bg-surface-gray rounded-full flex items-center justify-center mb-5 group-hover:bg-safety-orange/10 transition-colors duration-300">
                <span class="material-symbols-outlined text-safety-orange text-3xl icon-fill ctc-float" style="animation-delay:.5s" aria-hidden="true">mail</span>
            </div>
            <h3 class="text-lg font-bold mb-3 text-primary">Email Kami</h3>
            <a
                href="mailto:info@stc-subang.com"
                class="text-sm text-on-surface-variant hover:text-primary transition-colors"
            >
                info@stc-subang.com
            </a>
            <p class="text-xs text-outline mt-2">Respon dalam 1×24 jam kerja</p>
        </div>

        {{-- Phone --}}
        <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-primary flex flex-col items-center text-center ctc-card-lift group">
            <div class="w-16 h-16 bg-surface-gray rounded-full flex items-center justify-center mb-5 group-hover:bg-primary/10 transition-colors duration-300">
                <span class="material-symbols-outlined text-primary text-3xl icon-fill ctc-float" style="animation-delay:1s" aria-hidden="true">call</span>
            </div>
            <h3 class="text-lg font-bold mb-3 text-primary">Telepon</h3>
            <a
                href="tel:08112021212"
                class="text-sm text-on-surface-variant hover:text-primary transition-colors"
            >
                0811-2021-212
            </a>
            <p class="text-xs text-outline mt-2">Senin–Sabtu, 08.00–17.00 WIB</p>
        </div>

    </div>
</section>


{{-- ================================================================
     FORM + MAP SECTION
================================================================ --}}
<section
    class="py-16 max-w-container-max mx-auto px-gutter"
    aria-label="Form dan Peta Lokasi"
>
    <div class="bg-surface-gray rounded-2xl shadow-sm p-6 md:p-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-14 items-start">

            {{-- ── CONTACT FORM ── --}}
            <div class="bg-white p-8 rounded-xl shadow-sm ctc-reveal-left">
                <div class="mb-7">
                    <h2 class="text-2xl font-bold text-primary mb-1">Kirim Pesan</h2>
                    <p class="text-sm text-on-surface-variant">Isi formulir berikut dan tim kami akan merespons secepatnya.</p>
                </div>

                <form
                    id="contact-form"
                    action="{{ route('contact.send') }}"
                    method="POST"
                    novalidate
                    class="space-y-5"
                >
                    @csrf

                    {{-- Name + Company --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-on-surface-variant mb-2 uppercase tracking-wider" for="name">
                                Nama Lengkap <span class="text-secondary" aria-hidden="true">*</span>
                            </label>
                            <input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name') }}"
                                placeholder="Masukkan nama Anda"
                                autocomplete="name"
                                class="ctc-input w-full px-4 py-3 rounded-lg border border-outline-variant bg-surface-container-lowest text-sm transition-colors duration-200 @error('name') is-invalid @enderror"
                                required
                                maxlength="100"
                                aria-required="true"
                                aria-describedby="@error('name') name-error @enderror"
                            />
                            @error('name')
                                <p id="name-error" class="mt-1.5 text-xs text-red-600 flex items-center gap-1" role="alert">
                                    <span class="material-symbols-outlined text-sm" aria-hidden="true">error</span>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-on-surface-variant mb-2 uppercase tracking-wider" for="company">
                                Perusahaan / Institusi
                            </label>
                            <input
                                id="company"
                                name="company"
                                type="text"
                                value="{{ old('company') }}"
                                placeholder="Nama perusahaan (opsional)"
                                autocomplete="organization"
                                class="ctc-input w-full px-4 py-3 rounded-lg border border-outline-variant bg-surface-container-lowest text-sm transition-colors duration-200"
                                maxlength="150"
                            />
                        </div>
                    </div>

                    {{-- Email + Phone --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-on-surface-variant mb-2 uppercase tracking-wider" for="email">
                                Email <span class="text-secondary" aria-hidden="true">*</span>
                            </label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                placeholder="email@contoh.com"
                                autocomplete="email"
                                class="ctc-input w-full px-4 py-3 rounded-lg border border-outline-variant bg-surface-container-lowest text-sm transition-colors duration-200 @error('email') is-invalid @enderror"
                                required
                                maxlength="150"
                                aria-required="true"
                                aria-describedby="@error('email') email-error @enderror"
                            />
                            @error('email')
                                <p id="email-error" class="mt-1.5 text-xs text-red-600 flex items-center gap-1" role="alert">
                                    <span class="material-symbols-outlined text-sm" aria-hidden="true">error</span>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-on-surface-variant mb-2 uppercase tracking-wider" for="phone">
                                Nomor Telepon
                            </label>
                            <input
                                id="phone"
                                name="phone"
                                type="tel"
                                value="{{ old('phone') }}"
                                placeholder="08xx-xxxx-xxxx"
                                autocomplete="tel"
                                class="ctc-input w-full px-4 py-3 rounded-lg border border-outline-variant bg-surface-container-lowest text-sm transition-colors duration-200 @error('phone') is-invalid @enderror"
                                maxlength="20"
                                aria-describedby="@error('phone') phone-error @enderror"
                            />
                            @error('phone')
                                <p id="phone-error" class="mt-1.5 text-xs text-red-600 flex items-center gap-1" role="alert">
                                    <span class="material-symbols-outlined text-sm" aria-hidden="true">error</span>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    {{-- Subject --}}
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant mb-2 uppercase tracking-wider" for="subject">
                            Subjek Inquiry
                        </label>
                        <div class="relative">
                            <select
                                id="subject"
                                name="subject"
                                class="ctc-input w-full px-4 py-3 rounded-lg border border-outline-variant bg-surface-container-lowest text-sm transition-colors duration-200 appearance-none @error('subject') is-invalid @enderror"
                                aria-describedby="@error('subject') subject-error @enderror"
                            >
                                <option value="">Pilih Subjek...</option>
                                <option value="daftar_pelatihan"  {{ old('subject') === 'daftar_pelatihan'  ? 'selected' : '' }}>Pendaftaran Training</option>
                                <option value="konsultasi_karir"  {{ old('subject') === 'konsultasi_karir'  ? 'selected' : '' }}>Info Sertifikasi BNSP</option>
                                <option value="kerjasama"         {{ old('subject') === 'kerjasama'         ? 'selected' : '' }}>Inhouse Training / Corporate</option>
                                <option value="informasi_umum"    {{ old('subject') === 'informasi_umum'    ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none text-xl" aria-hidden="true">expand_more</span>
                        </div>
                        @error('subject')
                            <p id="subject-error" class="mt-1.5 text-xs text-red-600 flex items-center gap-1" role="alert">
                                <span class="material-symbols-outlined text-sm" aria-hidden="true">error</span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Message --}}
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant mb-2 uppercase tracking-wider" for="message">
                            Pesan <span class="text-secondary" aria-hidden="true">*</span>
                        </label>
                        <textarea
                            id="message"
                            name="message"
                            rows="5"
                            placeholder="Tuliskan detail pertanyaan atau kebutuhan Anda..."
                            class="ctc-input w-full px-4 py-3 rounded-lg border border-outline-variant bg-surface-container-lowest text-sm transition-colors duration-200 resize-none @error('message') is-invalid @enderror"
                            required
                            minlength="10"
                            maxlength="2000"
                            aria-required="true"
                            aria-describedby="message-count @error('message') message-error @enderror"
                        >{{ old('message') }}</textarea>
                        <div class="flex justify-between mt-1.5">
                            @error('message')
                                <p id="message-error" class="text-xs text-red-600 flex items-center gap-1" role="alert">
                                    <span class="material-symbols-outlined text-sm" aria-hidden="true">error</span>
                                    {{ $message }}
                                </p>
                            @else
                                <span></span>
                            @enderror
                            <span id="message-count" class="text-xs text-outline ml-auto">0 / 2000</span>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button
                        type="submit"
                        id="contact-submit"
                        class="ctc-btn-submit w-full bg-primary text-on-primary py-4 rounded-lg font-bold text-sm tracking-wider hover:bg-primary-container transition-all duration-200 shadow-sm hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2"
                        aria-live="polite"
                    >
                        <span class="btn-text flex items-center gap-2">
                            Kirim Pesan
                            <span class="material-symbols-outlined text-xl" aria-hidden="true">send</span>
                        </span>
                        <span class="btn-spinner" aria-hidden="true">
                            <span class="ctc-spinner"></span>
                        </span>
                    </button>

                    <p class="text-xs text-outline text-center">
                        <span class="material-symbols-outlined text-sm align-middle" aria-hidden="true">lock</span>
                        Data Anda aman dan tidak akan dibagikan ke pihak ketiga.
                    </p>
                </form>
            </div>

            {{-- ── MAP + OPERATIONAL INFO ── --}}
            <div class="space-y-6 ctc-reveal-right">
                {{-- Embedded Map --}}
                <div class="h-80 rounded-xl overflow-hidden shadow-md relative ctc-map-card">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.5!2d107.7554!3d-6.5720!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMzQnMTkuMiJTIDEwN8KwNDUnMTkuNCJF!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Lokasi STC Indonesia di Subang, Jawa Barat"
                        aria-label="Peta lokasi STC Indonesia"
                    ></iframe>
                    <div class="absolute bottom-0 left-0 right-0 bg-white/95 backdrop-blur-sm border-t-4 border-safety-orange p-4">
                        <h4 class="font-bold text-primary text-sm mb-0.5">STC Indonesia Headquarters</h4>
                        <p class="text-xs text-on-surface-variant">Jl. Palabuan (Veteran) No.9 · Subang, Jawa Barat 41211</p>
                    </div>
                </div>

                {{-- Operational Hours --}}
                <div class="bg-white rounded-xl shadow-sm p-6 border border-outline-variant/50">
                    <h3 class="font-bold text-primary mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-safety-orange text-xl" aria-hidden="true">schedule</span>
                        Jam Operasional
                    </h3>
                    <ul class="space-y-2.5 text-sm" role="list">
                        @php
                            $hours = [
                                ['day' => 'Senin – Jumat',  'time' => '08.00 – 17.00 WIB', 'open' => true],
                                ['day' => 'Sabtu',          'time' => '08.00 – 14.00 WIB', 'open' => true],
                                ['day' => 'Minggu',         'time' => 'Tutup',               'open' => false],
                            ];
                        @endphp
                        @foreach ($hours as $h)
                            <li class="flex justify-between items-center py-2 border-b border-outline-variant/30 last:border-0">
                                <span class="text-on-surface font-medium">{{ $h['day'] }}</span>
                                <span class="{{ $h['open'] ? 'text-green-600 bg-green-50' : 'text-outline bg-surface-gray' }} px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ $h['time'] }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Quick Contact Buttons --}}
                <div class="grid grid-cols-2 gap-4">
                    <a
                        href="https://wa.me/628112021212?text=Halo%20STC%20Indonesia%2C%20saya%20ingin%20mengetahui%20lebih%20lanjut%20tentang%20program%20training."
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white py-3.5 rounded-lg font-bold text-sm transition-all duration-200 hover:-translate-y-0.5 shadow-sm"
                    >
                        <span class="material-symbols-outlined text-xl" aria-hidden="true">chat</span>
                        WhatsApp
                    </a>
                    <a
                        href="tel:08112021212"
                        class="flex items-center justify-center gap-2 bg-primary hover:bg-primary-container text-on-primary py-3.5 rounded-lg font-bold text-sm transition-all duration-200 hover:-translate-y-0.5 shadow-sm"
                    >
                        <span class="material-symbols-outlined text-xl" aria-hidden="true">call</span>
                        Telepon
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ================================================================
     CTA SECTION – CORPORATE / IN-HOUSE TRAINING
================================================================ --}}
<section
    class="pb-16 max-w-container-max mx-auto px-gutter"
    aria-label="Corporate Partnership CTA"
>
    <div class="relative bg-primary text-on-primary rounded-2xl py-14 px-8 md:px-16 text-center overflow-hidden shadow-xl ctc-reveal">
        {{-- Blobs --}}
        <div class="ctc-blob -right-20 -top-20 w-72 h-72 bg-industrial-blue-light/20 rounded-full blur-3xl" aria-hidden="true"></div>
        <div class="ctc-blob -left-20 -bottom-20 w-64 h-64 bg-safety-orange/10 rounded-full blur-3xl" style="animation-delay:-4s" aria-hidden="true"></div>

        <div class="relative z-10 max-w-3xl mx-auto space-y-5">
            <span class="material-symbols-outlined text-safety-orange ctc-float block mx-auto" style="font-size:52px" aria-hidden="true">handshake</span>
            <h2 class="text-2xl md:text-3xl font-bold">Corporate Partnerships &amp; Inhouse Training</h2>
            <p class="text-primary-fixed-dim text-base leading-relaxed max-w-2xl mx-auto">
                Kami menyediakan solusi pelatihan industri yang disesuaikan khusus untuk kebutuhan operasional dan kepatuhan keselamatan organisasi Anda.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 pt-4">
                <a
                    href="#contact-form"
                    class="bg-safety-orange hover:bg-orange-600 text-white px-8 py-4 rounded-lg font-bold text-sm tracking-wide transition-all duration-200 hover:-translate-y-1 shadow-xl hover:shadow-orange-500/30 flex items-center justify-center gap-3"
                >
                    <span class="material-symbols-outlined text-xl" aria-hidden="true">request_quote</span>
                    Request Proposal
                </a>
                <a
                    href="{{ asset('docs/company-profile-stc.pdf') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="border-2 border-white/40 hover:border-white text-white hover:bg-white/10 px-8 py-4 rounded-lg font-bold text-sm tracking-wide transition-all duration-200 hover:-translate-y-1 flex items-center justify-center gap-3"
                >
                    <span class="material-symbols-outlined text-xl" aria-hidden="true">download</span>
                    Download Company Profile
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
    @vite(['resources/js/contact.js'])
@endpush