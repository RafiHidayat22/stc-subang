// resources/js/program.js

document.addEventListener('DOMContentLoaded', () => {

    // ── Scroll Reveal ─────────────────────────
    const revealObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
    );

    document.querySelectorAll('.stc-reveal').forEach((el) => {
        revealObserver.observe(el);
    });

    // ── Category Filter ───────────────────────
    const filterBtns = document.querySelectorAll('#program-filter .filter-btn');
    const programCards = document.querySelectorAll('#program-grid .category-card');

    filterBtns.forEach((btn) => {

        btn.addEventListener('click', () => {

            const filter = btn.dataset.filter;

            // active state
            filterBtns.forEach((b) => {
                b.classList.remove('active');
            });

            btn.classList.add('active');

            // filter card
            programCards.forEach((card) => {

                const category = card.dataset.category ?? '';

                if (filter === 'all' || category === filter) {

                    card.style.display = 'flex';

                    requestAnimationFrame(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    });

                } else {

                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';

                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 200);

                }

            });

        });

    });

    // ── Smooth Scroll ─────────────────────────
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {

        anchor.addEventListener('click', (e) => {

            const target = document.querySelector(anchor.getAttribute('href'));

            if (target) {
                e.preventDefault();

                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }

        });

    });

});