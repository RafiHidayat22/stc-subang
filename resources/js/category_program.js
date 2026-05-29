// resources/js/category_program.js
// JavaScript for Category Program page – scroll reveal, sticky sidebar, search

document.addEventListener('DOMContentLoaded', () => {

    // ── Scroll Reveal ────────────────────────────────────────────────
    const revealObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.1, rootMargin: '0px 0px -40px 0px' }
    );

    document.querySelectorAll('.stc-reveal').forEach((el) => revealObserver.observe(el));

    // ── Stagger card entrance ────────────────────────────────────────
    const programCards = document.querySelectorAll('article.stc-card-lift');
    const cardObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'none';
                    }, i * 80);
                    cardObserver.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.05 }
    );

    programCards.forEach((card) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(24px)';
        card.style.transition = 'opacity .55s cubic-bezier(.22,1,.36,1), transform .55s cubic-bezier(.22,1,.36,1)';
        cardObserver.observe(card);
    });

    // ── Sticky sidebar active state ──────────────────────────────────
    const sidebar = document.querySelector('.sidebar-sticky');
    if (sidebar) {
        window.addEventListener('scroll', () => {
            const footer = document.querySelector('footer');
            if (!footer) return;
            const footerTop = footer.getBoundingClientRect().top;
            const sidebarHeight = sidebar.offsetHeight;

            if (footerTop < sidebarHeight + 112) {
                sidebar.style.position = 'relative';
            } else {
                sidebar.style.position = 'sticky';
            }
        }, { passive: true });
    }

    // ── Smooth scroll ────────────────────────────────────────────────
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener('click', (e) => {
            const target = document.querySelector(anchor.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
});
