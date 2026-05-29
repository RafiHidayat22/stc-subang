// resources/js/detail_program.js
// JavaScript for Detail Program page – tabs, scroll reveal, sticky sidebar

document.addEventListener('DOMContentLoaded', () => {

    // ── Tab System ───────────────────────────────────────────────────
    const tabBtns  = document.querySelectorAll('.tab-btn');
    const tabPanes = document.querySelectorAll('.tab-pane');

    tabBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            const targetTab = btn.dataset.tab;

            // Update buttons
            tabBtns.forEach((b) => {
                b.classList.remove('active');
                b.setAttribute('aria-selected', 'false');
            });
            btn.classList.add('active');
            btn.setAttribute('aria-selected', 'true');

            // Update panes
            tabPanes.forEach((pane) => {
                pane.classList.remove('active');
                pane.style.opacity = '0';
            });

            const activePane = document.getElementById(`tab-${targetTab}`);
            if (activePane) {
                activePane.classList.add('active');
                requestAnimationFrame(() => {
                    activePane.style.transition = 'opacity .3s ease';
                    activePane.style.opacity = '1';
                });
            }
        });
    });

    // Initialise first tab opacity
    const firstPane = document.querySelector('.tab-pane.active');
    if (firstPane) firstPane.style.opacity = '1';

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

    // ── Stagger related program cards ────────────────────────────────
    const relatedCards = document.querySelectorAll('[aria-labelledby="related-programs-heading"] article');
    const cardObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'none';
                    }, i * 100);
                    cardObserver.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.1 }
    );

    relatedCards.forEach((card) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(24px)';
        card.style.transition = 'opacity .6s cubic-bezier(.22,1,.36,1), transform .6s cubic-bezier(.22,1,.36,1)';
        cardObserver.observe(card);
    });

    // ── Sticky sidebar guard (avoid overlapping footer) ──────────────
    const sidebar = document.querySelector('.sidebar-sticky');
    if (sidebar) {
        const onScroll = () => {
            const footer = document.querySelector('footer');
            if (!footer) return;
            const footerTop = footer.getBoundingClientRect().top;
            const sidebarH  = sidebar.offsetHeight + 112; // 96px nav + 16px gap

            sidebar.style.position = footerTop < sidebarH ? 'relative' : 'sticky';
        };
        window.addEventListener('scroll', onScroll, { passive: true });
    }

    // ── Curriculum item hover highlight ─────────────────────────────
    document.querySelectorAll('.curriculum-item').forEach((item) => {
        item.addEventListener('mouseenter', () => {
            item.style.borderLeftColor = '#F96302';
        });
        item.addEventListener('mouseleave', () => {
            item.style.borderLeftColor = 'transparent';
        });
    });

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
