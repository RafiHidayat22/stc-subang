/**
 * resources/js/about.js
 *
 * All functions are prefixed with "about" + SectionName to avoid
 * conflicts with JS from other pages.
 *
 * Sections covered:
 *   aboutReveal*    — scroll-reveal for all about-page sections
 *   aboutHero*      — hero entrance animation & floating particles
 *   aboutStats*     — animated counter numbers in the stats section
 *   aboutLineDraw*  — animated underline draws
 */


// ══════════════════════════════════════════════════════════════════════════════
// SCROLL REVEAL
// ══════════════════════════════════════════════════════════════════════════════

function aboutRevealInit() {
    // Immediately show everything if the user prefers reduced motion
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        document.querySelectorAll(
            '.about-reveal, .about-reveal-left, .about-reveal-right, ' +
            '.about-stagger, .about-line-draw'
        ).forEach(el => el.classList.add('visible'));
        return;
    }

    const selector =
        '.about-reveal, .about-reveal-left, .about-reveal-right, ' +
        '.about-stagger, .about-line-draw';

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
// HERO ENTRANCE
// ══════════════════════════════════════════════════════════════════════════════

function aboutHeroInit() {
    aboutHeroAnimateEntrance();
    aboutHeroParticles();
}

function aboutHeroAnimateEntrance() {
    // All .about-reveal inside #about-hero get a staggered entrance
    const heroSection = document.getElementById('about-hero');
    if (!heroSection) return;

    const elements = heroSection.querySelectorAll('.about-reveal');
    elements.forEach((el, i) => {
        setTimeout(() => {
            el.classList.add('visible');
        }, i * 130 + 100);
    });
}

function aboutHeroParticles() {
    const canvas = document.getElementById('about-hero-particles');
    if (!canvas || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    // Inject keyframe once
    if (!document.getElementById('about-float-kf')) {
        const style = document.createElement('style');
        style.id = 'about-float-kf';
        style.textContent = `
            @keyframes aboutHeroFloat {
                from { transform: translateY(0) scale(1); opacity: 0.12; }
                to   { transform: translateY(-22px) scale(1.15); opacity: 0.38; }
            }
        `;
        document.head.appendChild(style);
    }

    const count = 14;
    for (let i = 0; i < count; i++) {
        const dot   = document.createElement('div');
        const size  = Math.random() * 9 + 4;
        const delay = Math.random() * 5;
        const dur   = Math.random() * 7 + 8;
        const x     = Math.random() * 100;
        const y     = Math.random() * 100;

        dot.className = 'absolute rounded-full pointer-events-none';
        dot.style.cssText = `
            width: ${size}px;
            height: ${size}px;
            left: ${x}%;
            top: ${y}%;
            background: rgba(249, 99, 2, 0.25);
            animation: aboutHeroFloat ${dur}s ${delay}s ease-in-out infinite alternate;
        `;
        canvas.appendChild(dot);
    }
}


// ══════════════════════════════════════════════════════════════════════════════
// ANIMATED COUNTERS (Stats Section)
// ══════════════════════════════════════════════════════════════════════════════

function aboutStatsInit() {
    const counterEls = document.querySelectorAll('[data-about-counter]');
    if (!counterEls.length) return;

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            observer.unobserve(entry.target);
            aboutCounterAnimate(entry.target);
        });
    }, { threshold: 0.4 });

    counterEls.forEach(el => observer.observe(el));
}

function aboutCounterAnimate(el) {
    const target  = parseInt(el.dataset.aboutCounter, 10);
    const suffix  = el.dataset.suffix || '';
    const duration = 1400; // ms
    const startTime = performance.now();

    function step(now) {
        const elapsed  = now - startTime;
        const progress = Math.min(elapsed / duration, 1);
        // Ease out cubic
        const eased    = 1 - Math.pow(1 - progress, 3);
        const current  = Math.floor(eased * target);

        el.textContent = current.toLocaleString('id-ID') + suffix;

        if (progress < 1) {
            requestAnimationFrame(step);
        } else {
            el.textContent = target.toLocaleString('id-ID') + suffix;
        }
    }

    requestAnimationFrame(step);
}


// ══════════════════════════════════════════════════════════════════════════════
// LINE DRAW (decorative animated underlines)
// ══════════════════════════════════════════════════════════════════════════════

function aboutLineDrawInit() {
    // Handled by the scroll-reveal observer adding .visible class,
    // which triggers the CSS @keyframes aboutLineDraw animation.
    // No additional JS needed — the observer in aboutRevealInit covers it.
}


// ══════════════════════════════════════════════════════════════════════════════
// INDUSTRY CARD HOVER LABEL EFFECT
// ══════════════════════════════════════════════════════════════════════════════

function aboutIndustryInit() {
    // Subtle: scale the icon on hover via JS for browsers where CSS :hover
    // might not cover keyboard focus. Ensure focus also shows hover styles.
    const industryCards = document.querySelectorAll('.about-industry-card');
    industryCards.forEach(card => {
        card.setAttribute('tabindex', '0');
        card.addEventListener('focus', () => card.classList.add('about-industry-focused'));
        card.addEventListener('blur',  () => card.classList.remove('about-industry-focused'));
    });
}


// ══════════════════════════════════════════════════════════════════════════════
// VALUE CARD — animate on first viewport entry
// ══════════════════════════════════════════════════════════════════════════════

function aboutValueInit() {
    const valueItems = document.querySelectorAll('.about-value-item');
    if (!valueItems.length) return;

    const observer = new IntersectionObserver(entries => {
        entries.forEach((entry, idx) => {
            if (!entry.isIntersecting) return;
            setTimeout(() => {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'none';
            }, idx * 90);
            observer.unobserve(entry.target);
        });
    }, { threshold: 0.15 });

    valueItems.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateX(20px)';
        el.style.transition = 'opacity .55s ease, transform .55s ease';
        observer.observe(el);
    });
}


// ══════════════════════════════════════════════════════════════════════════════
// SYNERGY SECTION — entrance stagger
// ══════════════════════════════════════════════════════════════════════════════

function aboutSynergyInit() {
    const synergySection = document.getElementById('about-synergy');
    if (!synergySection) return;

    // Already handled by about-stagger + about-reveal-left/right via observer.
    // Nothing extra needed here.
}


// ══════════════════════════════════════════════════════════════════════════════
// BOOT
// ══════════════════════════════════════════════════════════════════════════════

document.addEventListener('DOMContentLoaded', () => {
    aboutRevealInit();
    aboutHeroInit();
    aboutStatsInit();
    aboutLineDrawInit();
    aboutIndustryInit();
    aboutValueInit();
    aboutSynergyInit();
});