/**
 * resources/js/home.js
 *
 * All functions are prefixed with "home" + SectionName to avoid
 * conflicts with JS from other pages.
 *
 * Sections covered:
 *   homeNavbar*      — sticky navbar behaviour
 *   homeHero*        — hero animations, counter, particles
 *   homeReveal*      — scroll-reveal for all sections
 *   homeGallery*     — gallery lightbox modal
 *   homeContact*     — contact form UX & validation
 */

// ══════════════════════════════════════════════════════════════════════════════
// NAVBAR
// ══════════════════════════════════════════════════════════════════════════════

let homeNavbarScrolled = false;

function homeNavbarInit() {
    const bg     = document.getElementById('navbar-bg');
    const brand  = document.getElementById('navbar-brand');
    const links  = document.querySelectorAll('.nav-link');
    const hamburgerLines = document.querySelectorAll('.hamburger-line');

    if (!bg) return;

function homeNavbarUpdate() {
    const scrolled = window.scrollY > 60;
    if (scrolled === homeNavbarScrolled) return;
    homeNavbarScrolled = scrolled;

    // Background
    bg.classList.toggle('bg-surface-container-lowest/0',   !scrolled);
    bg.classList.toggle('backdrop-blur-none',               !scrolled);
    bg.classList.toggle('shadow-none',                      !scrolled);
    bg.classList.toggle('bg-surface-container-lowest',      scrolled);
    bg.classList.toggle('backdrop-blur-xl',                 scrolled);
    bg.classList.toggle('shadow-md',                        scrolled);

    // Brand color
    brand?.classList.toggle('text-white',   !scrolled);
    brand?.classList.toggle('text-primary', scrolled);

    // Nav links
    links.forEach(l => {
        l.classList.toggle('text-white/90',   !scrolled);
        l.classList.toggle('text-on-surface', scrolled);
        l.classList.toggle('hover:text-safety-orange', true);
    });

    // Hamburger color
    hamburgerLines.forEach(line => {
        line.classList.toggle('bg-white', !scrolled);
        line.classList.toggle('bg-primary', scrolled);
    });
}

    window.addEventListener('scroll', homeNavbarUpdate, { passive: true });
    homeNavbarUpdate();

    // Active link on scroll
    homeNavbarHighlightActive();
}

function homeNavbarHighlightActive() {
    const sections = document.querySelectorAll('section[id]');
    const links    = document.querySelectorAll('.nav-link[data-target]');

    if (!sections.length || !links.length) return;

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            links.forEach(l => {
                const isActive = l.dataset.target === `#${entry.target.id}`;
                l.classList.toggle('text-safety-orange', isActive);
                l.classList.toggle('after:w-full',       isActive);
            });
        });
    }, { rootMargin: '-50% 0px -50% 0px' });

    sections.forEach(s => observer.observe(s));
}

/** Called by navbar hamburger button (onclick in blade) */
function homeNavbarToggleMobile(btn) {
    const menu    = document.getElementById('mobile-menu');
    const isOpen  = menu.getAttribute('aria-hidden') === 'false';

    menu.setAttribute('aria-hidden', isOpen ? 'true' : 'false');
    btn.setAttribute('aria-expanded', !isOpen);
    menu.classList.toggle('-translate-y-full', isOpen);
    menu.classList.toggle('opacity-0',         isOpen);
    menu.classList.toggle('pointer-events-none', isOpen);
    menu.classList.toggle('translate-y-0',    !isOpen);
    menu.classList.toggle('opacity-100',      !isOpen);
    menu.classList.toggle('pointer-events-auto', !isOpen);

    // Animate hamburger lines → X
    const lines = btn.querySelectorAll('.hamburger-line');
    lines[0]?.classList.toggle('rotate-45',    !isOpen);
    lines[0]?.classList.toggle('translate-y-2', !isOpen);
    lines[1]?.classList.toggle('opacity-0',    !isOpen);
    lines[2]?.classList.toggle('-rotate-45',   !isOpen);
    lines[2]?.classList.toggle('-translate-y-2', !isOpen);
}

function homeNavbarCloseMobile() {
    const btn  = document.getElementById('navbar-hamburger');
    const menu = document.getElementById('mobile-menu');
    if (!menu) return;

    menu.setAttribute('aria-hidden', 'true');
    btn?.setAttribute('aria-expanded', 'false');
    menu.classList.add('-translate-y-full', 'opacity-0', 'pointer-events-none');
    menu.classList.remove('translate-y-0', 'opacity-100', 'pointer-events-auto');

    const lines = btn?.querySelectorAll('.hamburger-line');
    lines?.[0]?.classList.remove('rotate-45', 'translate-y-2');
    lines?.[1]?.classList.remove('opacity-0');
    lines?.[2]?.classList.remove('-rotate-45', '-translate-y-2');
}

// Make mobile helpers global (called from blade onclick)
window.homeNavbarToggleMobile = homeNavbarToggleMobile;
window.homeNavbarCloseMobile  = homeNavbarCloseMobile;


// ══════════════════════════════════════════════════════════════════════════════
// HERO
// ══════════════════════════════════════════════════════════════════════════════

function homeHeroInit() {
    homeHeroAnimateEntrance();
    homeHeroCounterAnimate();
    homeHeroParticles();
}

function homeHeroAnimateEntrance() {
    const elements = [
        document.querySelector('.home-hero-badge'),
        document.querySelector('.home-hero-title'),
        document.querySelector('.home-hero-desc'),
        document.querySelector('.home-hero-cta'),
        document.querySelector('.home-hero-stats'),
        document.querySelector('.home-hero-card'),
    ];

    elements.forEach((el, i) => {
        if (!el) return;
        setTimeout(() => {
            el.classList.remove('opacity-0', 'translate-y-6', 'translate-x-8');
            el.classList.add('opacity-100', 'translate-y-0', 'translate-x-0');
        }, i * 120);
    });
}

function homeHeroCounterAnimate() {
    const counter    = document.getElementById('hero-compliance-counter');
    const bar        = document.getElementById('hero-compliance-bar');
    const targetPct  = 98;
    if (!counter || !bar) return;

    let current = 0;
    const step  = () => {
        current = Math.min(current + 2, targetPct);
        counter.textContent = current + '%';
        if (current < targetPct) requestAnimationFrame(step);
    };

    // Start after entrance delay
    setTimeout(() => {
        bar.style.width = targetPct + '%';
        requestAnimationFrame(step);
    }, 900);
}

function homeHeroParticles() {
    const canvas = document.getElementById('hero-particles');
    if (!canvas || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    // Simple floating dots using CSS animation injected via a hidden SVG
    const count = 12;
    for (let i = 0; i < count; i++) {
        const dot = document.createElement('div');
        dot.className = 'absolute rounded-full bg-safety-orange/20 pointer-events-none';
        const size  = Math.random() * 8 + 4;
        const delay = Math.random() * 4;
        const dur   = Math.random() * 6 + 8;
        const x     = Math.random() * 100;
        const y     = Math.random() * 100;

        dot.style.cssText = `
            width:${size}px; height:${size}px;
            left:${x}%; top:${y}%;
            animation: homeHeroFloat ${dur}s ${delay}s ease-in-out infinite alternate;
        `;
        canvas.appendChild(dot);
    }

    // Inject keyframe if not already present
    if (!document.getElementById('hero-float-kf')) {
        const style   = document.createElement('style');
        style.id      = 'hero-float-kf';
        style.textContent = `
            @keyframes homeHeroFloat {
                from { transform: translateY(0px) scale(1); opacity: 0.15; }
                to   { transform: translateY(-20px) scale(1.1); opacity: 0.4; }
            }
        `;
        document.head.appendChild(style);
    }
}


// ══════════════════════════════════════════════════════════════════════════════
// SCROLL REVEAL (shared across all sections)
// ══════════════════════════════════════════════════════════════════════════════

function homeRevealInit() {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        // Langsung tampilkan semua tanpa animasi
        document.querySelectorAll(
            '.stc-reveal, .stc-reveal-left, .stc-reveal-right, ' +
            '.stc-stagger, .stc-line-draw, .stc-quote-reveal, .home-reveal'
        ).forEach(el => el.classList.add('visible'));
        return;
    }

    const selector =
        '.stc-reveal, .stc-reveal-left, .stc-reveal-right, ' +
        '.stc-stagger, .stc-line-draw, .stc-quote-reveal, .home-reveal';

    const targets = document.querySelectorAll(selector);

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('visible');
            observer.unobserve(entry.target);
        });
    }, { threshold: 0.08 });

    targets.forEach(el => observer.observe(el));
}


// ══════════════════════════════════════════════════════════════════════════════
// GALLERY LIGHTBOX
// ══════════════════════════════════════════════════════════════════════════════

function homeGalleryOpenModal(src, caption) {
    const modal   = document.getElementById('gallery-modal');
    const img     = document.getElementById('gallery-modal-img');
    const cap     = document.getElementById('gallery-modal-caption');
    if (!modal || !img) return;

    img.src        = src;
    img.alt        = caption || '';
    if (cap) cap.textContent = caption || '';

    modal.classList.remove('opacity-0', 'pointer-events-none');
    modal.classList.add('opacity-100', 'pointer-events-auto');
    document.body.style.overflow = 'hidden';

    // Focus trap
    const closeBtn = modal.querySelector('button');
    closeBtn?.focus();
}

function homeGalleryCloseModal(event) {
    // Close only when clicking backdrop (not the image itself)
    if (event && event.target !== event.currentTarget && event.target.tagName !== 'BUTTON') return;

    const modal = document.getElementById('gallery-modal');
    if (!modal) return;

    modal.classList.add('opacity-0', 'pointer-events-none');
    modal.classList.remove('opacity-100', 'pointer-events-auto');
    document.body.style.overflow = '';
}

function homeGalleryInitKeyboard() {
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') homeGalleryCloseModal();
    });
}

// Make gallery functions global (called from blade onclick)
window.homeGalleryOpenModal  = homeGalleryOpenModal;
window.homeGalleryCloseModal = homeGalleryCloseModal;




// ══════════════════════════════════════════════════════════════════════════════
// BOOT
// ══════════════════════════════════════════════════════════════════════════════

document.addEventListener('DOMContentLoaded', () => {
    homeNavbarInit();
    homeHeroInit();
    homeRevealInit();
    homeGalleryInitKeyboard();
});
