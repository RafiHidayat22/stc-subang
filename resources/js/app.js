// resources/js/app.js
// Global utilities — section-specific logic goes in their own files (e.g. home.js)


// ─── Scroll-to-top button ─────────────────────────────────────────────────────
(function appInitScrollToTop() {
    const btn = document.getElementById('scroll-to-top');
    if (!btn) return;

    window.addEventListener('scroll', () => {
        const visible = window.scrollY > 400;
        btn.classList.toggle('opacity-100',   visible);
        btn.classList.toggle('translate-y-0', visible);
        btn.classList.toggle('pointer-events-auto', visible);
        btn.classList.toggle('opacity-0',     !visible);
        btn.classList.toggle('translate-y-4', !visible);
        btn.classList.toggle('pointer-events-none', !visible);
    }, { passive: true });
})();

// ─── Global: smooth scroll for anchor links ───────────────────────────────────
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const target = document.querySelector(this.getAttribute('href'));
        if (!target) return;
        e.preventDefault();
        const offset = 80; // navbar height
        const top = target.getBoundingClientRect().top + window.scrollY - offset;
        window.scrollTo({ top, behavior: 'smooth' });
    });
});

// ─── CSRF helper for fetch calls ─────────────────────────────────────────────
window.csrfToken = () =>
    document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';
