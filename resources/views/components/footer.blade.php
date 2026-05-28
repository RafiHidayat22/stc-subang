{{-- resources/views/components/footer.blade.php --}}
<footer class="bg-primary text-on-primary" role="contentinfo">
    <div class="w-full py-stack-lg px-gutter max-w-container-max mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">

            {{-- Brand & Info --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="flex items-center gap-3">
                    <div class="w-13 h-13 bg-white rounded-lg flex items-center justify-center">
                                        <img 
                    src="{{ asset('images/logo-stc.png') }}" 
                    alt="Logo STC"
                    class="w-full h-full object-cover"
                >
                    </div>
                    <h2 class="font-display-lg text-headline-lg text-on-primary">STC Indonesia</h2>
                </div>
                <p class="text-outline-variant font-body-md leading-relaxed">
                    Subang Training Center adalah pusat keunggulan pengembangan SDM industri berbasis kompetensi di Jawa Barat. Kami berkomitmen mencetak tenaga kerja handal melalui sistem pendidikan vokasi yang modern.
                </p>
                <address class="not-italic space-y-3">
                    <p class="flex items-start gap-3 text-sm">
                        <span class="material-symbols-outlined text-safety-orange mt-0.5 shrink-0" aria-hidden="true">location_on</span>
                        <span>Jl. Palabuan (Veteran) No.9, Sukamelang, Subang, Jawa Barat.</span>
                    </p>
                    <p class="flex items-center gap-3 text-sm">
                        <span class="material-symbols-outlined text-safety-orange shrink-0" aria-hidden="true">mail</span>
                        <a href="mailto:info@stc-subang.com" class="hover:text-safety-orange transition-colors">
                            info@stc-subang.com
                        </a>
                    </p>
                    <p class="flex items-center gap-3 text-sm">
                        <span class="material-symbols-outlined text-safety-orange shrink-0" aria-hidden="true">call</span>
                        <a href="tel:+628112021212" class="hover:text-safety-orange transition-colors">
                            0811-2021-212
                        </a>
                    </p>
                </address>
            </div>

            {{-- Quick Links --}}
            <div>
                <h3 class="font-display-lg text-title-md mb-6 pb-2 border-b border-white/20">Quick Links</h3>
                <ul class="space-y-3" role="list">
                    @php
                        $quickLinks = [
                            ['href' => route('home'),             'label' => 'Beranda'],
                            ['href' => '#programs',               'label' => 'Program Pelatihan'],
                            ['href' => '#certification',          'label' => 'Sertifikasi'],
                            ['href' => '#gallery',                'label' => 'Gallery'],
                            ['href' => '#contact',                'label' => 'Hubungi Kami'],
                            ['href' => route('privacy-policy'),   'label' => 'Privacy Policy'],
                        ];
                    @endphp
                    @foreach ($quickLinks as $link)
                        <li>
                            <a
                                href="{{ $link['href'] }}"
                                class="text-on-primary-container hover:text-on-primary hover:underline transition-all duration-200 text-sm flex items-center gap-2 group"
                            >
                                <span class="text-safety-orange opacity-0 group-hover:opacity-100 transition-opacity text-xs">›</span>
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Social & Newsletter --}}
            <div>
                <h3 class="font-display-lg text-title-md mb-6 pb-2 border-b border-white/20">Follow Us</h3>
<div class="flex gap-3 mb-8" role="list" aria-label="Media Sosial">

    @php
        $socials = [
            [
                'icon' => 'fa-linkedin-in',
                'type' => 'brands',
                'label' => 'LinkedIn',
                'href' => '#'
            ],
            [
                'icon' => 'fa-instagram',
                'type' => 'brands',
                'label' => 'Instagram',
                'href' => '#'
            ],
            [
                'icon' => 'fa-tiktok',
                'type' => 'brands',
                'label' => 'TikTok',
                'href' => '#'
            ],
            [
                'icon' => 'fa-envelope',
                'type' => 'solid',
                'label' => 'Email',
                'href' => 'mailto:info@stc-subang.com'
            ],
        ];
    @endphp

    @foreach ($socials as $social)
        <a
            href="{{ $social['href'] }}"
            class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-safety-orange transition-all duration-200 hover:scale-110"
            aria-label="{{ $social['label'] }}"
        >
            <i class="fa-{{ $social['type'] }} {{ $social['icon'] }} text-sm"></i>
        </a>
    @endforeach

</div>

                {{-- Mini CTA --}}
                <div class="bg-primary-container rounded-xl p-5">
                    <p class="text-sm font-bold text-safety-orange mb-2">Konsultasi Gratis</p>
                    <p class="text-xs text-outline-variant mb-4">Hubungi tim kami untuk informasi program pelatihan terbaik untuk Anda.</p>
                    <a
                        href="https://wa.me/628112021212"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="block text-center bg-safety-orange hover:bg-orange-600 text-white text-sm font-bold py-2 px-4 rounded-lg transition-all duration-200"
                    >
                        WhatsApp Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom Bar --}}
    <div class="border-t border-white/10">
        <div class="w-full px-gutter max-w-container-max mx-auto py-5 flex flex-col md:flex-row justify-between items-center gap-3 text-sm text-outline-variant">
            <p>© {{ date('Y') }} Subang Training Center (STC Indonesia). All rights reserved.</p>
            <div class="flex gap-4">
                <a href="{{ route('privacy-policy') }}" class="hover:text-on-primary transition-colors">Privacy Policy</a>
                <span aria-hidden="true">·</span>
                <a href="{{ route('terms') }}" class="hover:text-on-primary transition-colors">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>
