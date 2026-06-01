(function () {
    'use strict';

    // ── Collect photo data from DOM ────────────────────────────────────────
    const grid = document.getElementById('dtl-photo-grid');
    if (!grid) return;

    const cards  = Array.from(grid.querySelectorAll('.photo-card'));
    const photos = cards.map(c => ({ src: c.dataset.src, caption: c.dataset.caption }));

    // ── DOM refs ───────────────────────────────────────────────────────────
    const lb        = document.getElementById('dtl-lightbox');
    const lbImg     = document.getElementById('dtl-lb-img');
    const lbCaption = document.getElementById('dtl-lb-caption');
    const lbMeta    = document.getElementById('dtl-lb-meta');
    const lbClose   = document.getElementById('dtl-lb-close');
    const lbPrev    = document.getElementById('dtl-lb-prev');
    const lbNext    = document.getElementById('dtl-lb-next');

    let lbIdx = 0;

    // ── Open ───────────────────────────────────────────────────────────────
    function openLb(idx) {
        lbIdx = idx;
        renderLb();
        lb.classList.add('open');
        lb.focus();
        document.body.style.overflow = 'hidden';
    }

    // ── Render ─────────────────────────────────────────────────────────────
    function renderLb() {
        const p = photos[lbIdx];
        lbImg.classList.add('fading');
        setTimeout(() => {
            lbImg.src             = p.src;
            lbImg.alt             = p.caption;
            lbCaption.textContent = p.caption;
            lbMeta.textContent    = `${lbIdx + 1} / ${photos.length}`;
            lbImg.classList.remove('fading');
        }, 220);
        lbPrev.disabled = lbIdx === 0;
        lbNext.disabled = lbIdx === photos.length - 1;
    }

    // ── Navigate ───────────────────────────────────────────────────────────
    function navigate(dir) {
        const next = lbIdx + dir;
        if (next < 0 || next >= photos.length) return;
        lbIdx = next;
        renderLb();
    }

    // ── Close ──────────────────────────────────────────────────────────────
    function closeLb() {
        lb.classList.remove('open');
        document.body.style.overflow = '';
    }

    // ── Events ─────────────────────────────────────────────────────────────
    // Card click
    grid.addEventListener('click', e => {
        const card = e.target.closest('.photo-card');
        if (!card) return;
        openLb(parseInt(card.dataset.idx, 10));
    });

    // Card keyboard
    grid.addEventListener('keydown', e => {
        if (e.key !== 'Enter' && e.key !== ' ') return;
        const card = e.target.closest('.photo-card');
        if (!card) return;
        e.preventDefault();
        openLb(parseInt(card.dataset.idx, 10));
    });

    // Lightbox buttons
    lbClose.addEventListener('click', closeLb);
    lbPrev.addEventListener('click',  () => navigate(-1));
    lbNext.addEventListener('click',  () => navigate(1));
    lb.addEventListener('click', e => { if (e.target === lb) closeLb(); });

    // Keyboard
    document.addEventListener('keydown', e => {
        if (!lb.classList.contains('open')) return;
        if (e.key === 'Escape')     closeLb();
        if (e.key === 'ArrowLeft')  navigate(-1);
        if (e.key === 'ArrowRight') navigate(1);
    });

    // Swipe
    let tX = 0;
    lb.addEventListener('touchstart', e => { tX = e.changedTouches[0].clientX; }, { passive: true });
    lb.addEventListener('touchend',   e => {
        const diff = tX - e.changedTouches[0].clientX;
        if (Math.abs(diff) > 50) navigate(diff > 0 ? 1 : -1);
    });

    // ── Scroll reveal ──────────────────────────────────────────────────────
    const reveals = document.querySelectorAll('.cert-reveal');
    if (reveals.length) {
        const obs = new IntersectionObserver(entries => {
            entries.forEach(en => {
                if (en.isIntersecting) {
                    en.target.classList.add('visible');
                    obs.unobserve(en.target);
                }
            });
        }, { threshold: 0.12 });
        reveals.forEach(el => obs.observe(el));
    }

}());