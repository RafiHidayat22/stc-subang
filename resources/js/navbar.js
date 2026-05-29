/**
 * resources/js/navbar.js
 *
 * Navbar behaviour yang dipakai di SEMUA halaman.
 * Di-load via layouts/app.blade.php (bukan per-page JS).
 *
 * Fungsi global (dipanggil dari onclick di navbar.blade.php):
 *   navbarToggleMobile(btn)
 *   navbarCloseMobile()
 */

// ══════════════════════════════════════════════════════════════════════════════
// STATE
// ══════════════════════════════════════════════════════════════════════════════

let _navbarScrolled = false;

// ══════════════════════════════════════════════════════════════════════════════
// SCROLL BEHAVIOUR
// ══════════════════════════════════════════════════════════════════════════════

function navbarUpdate() {
    const bg             = document.getElementById('navbar-bg');
    const brand          = document.getElementById('navbar-brand');
    const links          = document.querySelectorAll('.nav-link');
    const hamburgerLines = document.querySelectorAll('.hamburger-line');

    if (!bg) return;

    const scrolled = window.scrollY > 60;
    if (scrolled === _navbarScrolled) return;
    _navbarScrolled = scrolled;

    // Background layer
    bg.classList.toggle('bg-white/10',                  !scrolled);
    bg.classList.toggle('backdrop-blur-md',             !scrolled);
    bg.classList.toggle('border-white/10',              !scrolled);
    bg.classList.toggle('shadow-none',                  !scrolled);

    bg.classList.toggle('bg-surface-container-lowest',  scrolled);
    bg.classList.toggle('backdrop-blur-xl',             scrolled);
    bg.classList.toggle('border-outline-variant',       scrolled);
    bg.classList.toggle('shadow-md',                    scrolled);

    // Brand text colour
    brand?.classList.toggle('text-white',   !scrolled);
    brand?.classList.toggle('text-primary', scrolled);

    // Nav link colours
    links.forEach(l => {
        l.classList.toggle('text-white/90',   !scrolled);
        l.classList.toggle('text-on-surface', scrolled);
    });

    // Hamburger lines colour
    hamburgerLines.forEach(line => {
        line.classList.toggle('bg-white',   !scrolled);
        line.classList.toggle('bg-primary', scrolled);
    });
}

function navbarInit() {
    // Run once on load, then on every scroll
    navbarUpdate();
    window.addEventListener('scroll', navbarUpdate, { passive: true });

    // Highlight active nav link based on current URL (works across all pages)
    navbarHighlightByRoute();

    // On-scroll section highlight (only useful on pages with named sections)
    navbarHighlightByScroll();
}

// ══════════════════════════════════════════════════════════════════════════════
// ACTIVE LINK — route-based (for multi-page sites)
// ══════════════════════════════════════════════════════════════════════════════

function navbarHighlightByRoute() {
    const currentPath = window.location.pathname;

    document.querySelectorAll('.nav-link').forEach(link => {
        const href = link.getAttribute('href') || '';

        // Match exact path or prefix (e.g. /about matches /about/team)
        const isActive =
            href === currentPath ||
            (href !== '/' && currentPath.startsWith(href));

        link.classList.toggle('text-safety-orange', isActive);
        link.classList.toggle('after:w-full',       isActive);
    });
}

// ══════════════════════════════════════════════════════════════════════════════
// ACTIVE LINK — scroll-based (for single-page anchor sections)
// ══════════════════════════════════════════════════════════════════════════════

function navbarHighlightByScroll() {
    const sections = document.querySelectorAll('section[id]');
    const links    = document.querySelectorAll('.nav-link[data-target^="#"]');

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

// ══════════════════════════════════════════════════════════════════════════════
// MOBILE MENU
// ══════════════════════════════════════════════════════════════════════════════

function navbarToggleMobile(btn) {
    const menu   = document.getElementById('mobile-menu');
    if (!menu) return;

    const isOpen = menu.getAttribute('aria-hidden') === 'false';

    menu.setAttribute('aria-hidden', isOpen ? 'true' : 'false');
    btn.setAttribute('aria-expanded', String(!isOpen));

    menu.classList.toggle('-translate-y-full',    isOpen);
    menu.classList.toggle('opacity-0',            isOpen);
    menu.classList.toggle('pointer-events-none',  isOpen);
    menu.classList.toggle('translate-y-0',       !isOpen);
    menu.classList.toggle('opacity-100',         !isOpen);
    menu.classList.toggle('pointer-events-auto', !isOpen);

    // Animate hamburger → X
    const lines = btn.querySelectorAll('.hamburger-line');
    lines[0]?.classList.toggle('rotate-45',     !isOpen);
    lines[0]?.classList.toggle('translate-y-2', !isOpen);
    lines[1]?.classList.toggle('opacity-0',     !isOpen);
    lines[2]?.classList.toggle('-rotate-45',    !isOpen);
    lines[2]?.classList.toggle('-translate-y-2',!isOpen);
}

function navbarCloseMobile() {
    const btn  = document.getElementById('navbar-hamburger');
    const menu = document.getElementById('mobile-menu');
    if (!menu) return;

    menu.setAttribute('aria-hidden', 'true');
    btn?.setAttribute('aria-expanded', 'false');
    menu.classList.add('-translate-y-full', 'opacity-0', 'pointer-events-none');
    menu.classList.remove('translate-y-0', 'opacity-100', 'pointer-events-auto');

    const lines = btn?.querySelectorAll('.hamburger-line');
    lines?.[0]?.classList.remove('rotate-45',  'translate-y-2');
    lines?.[1]?.classList.remove('opacity-0');
    lines?.[2]?.classList.remove('-rotate-45', '-translate-y-2');
}

// Close mobile menu on Escape key
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') navbarCloseMobile();
});

// ══════════════════════════════════════════════════════════════════════════════
// EXPOSE GLOBALS (dipanggil via onclick di navbar.blade.php)
// ══════════════════════════════════════════════════════════════════════════════

window.navbarToggleMobile = navbarToggleMobile;
window.navbarCloseMobile  = navbarCloseMobile;

// Backward-compat alias — home.js masih pakai nama lama
window.homeNavbarToggleMobile = navbarToggleMobile;
window.homeNavbarCloseMobile  = navbarCloseMobile;

// ══════════════════════════════════════════════════════════════════════════════
// BOOT
// ══════════════════════════════════════════════════════════════════════════════

document.addEventListener('DOMContentLoaded', navbarInit);