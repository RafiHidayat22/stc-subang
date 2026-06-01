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

    // reset opacity sebelum load
    img.style.opacity = '0';

    img.onload = () => {
        img.style.opacity = '1';
    };

    img.src = src;
    img.alt = caption || '';

    if (cap) {
        cap.textContent = caption || '';
    }

    modal.classList.remove('opacity-0', 'pointer-events-none');
    modal.classList.add('opacity-100', 'pointer-events-auto');

    document.body.style.overflow = 'hidden';

    // focus button close
    const closeBtn = modal.querySelector('button');
    closeBtn?.focus();
}

function homeGalleryCloseModal(event) {
    if (
        event &&
        event.target !== event.currentTarget &&
        event.target.tagName !== 'BUTTON'
    ) return;

    const modal = document.getElementById('gallery-modal');
    const img   = document.getElementById('gallery-modal-img');

    if (!modal) return;

    modal.classList.add('opacity-0', 'pointer-events-none');
    modal.classList.remove('opacity-100', 'pointer-events-auto');

    document.body.style.overflow = '';

    if (img) {
        img.style.opacity = '0';
    }
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
    homeHeroInit();
    homeRevealInit();
    homeGalleryInitKeyboard();
});
