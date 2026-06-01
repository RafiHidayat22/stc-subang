/**
 * gallery.js
 * -----------
 * Handles:
 *  1. Home page gallery modal (homeGalleryOpenModal / homeGalleryCloseModal)
 *  2. Gallery index page: filter, search, pagination, lightbox, reveal
 *
 * Cards on the gallery index now navigate to /gallery/{category} when
 * the "Lihat Foto" button is clicked. Clicking the card body (outside
 * the button) still opens the lightbox for a quick preview.
 *
 * Usage: imported via @vite(['resources/js/gallery.js']) in blade layouts.
 */

'use strict';

// ════════════════════════════════════════════════════════════════════════════
// 1. HOME PAGE — Modal gallery (existing logic, untouched)
// ════════════════════════════════════════════════════════════════════════════

let currentIndex = 0;
let galleryItems = []; // { src, caption }[]

const modal    = () => document.getElementById('gallery-modal');
const modalImg = () => document.getElementById('gallery-modal-img');
const modalCap = () => document.getElementById('gallery-modal-caption');

function buildGalleryItems() {
    const nodes = document.querySelectorAll('.stc-gallery-item');
    galleryItems = Array.from(nodes).map(el => ({
        src    : el.dataset.src     ?? '',
        caption: el.dataset.caption ?? '',
    }));
}

window.homeGalleryOpenModal = function (src, caption) {
    if (!galleryItems.length) buildGalleryItems();
    const idx = galleryItems.findIndex(i => i.src === src);
    currentIndex = idx >= 0 ? idx : 0;
    _renderModal(src, caption);
    _showModal();
};

function _renderModal(src, caption) {
    const img = modalImg();
    const cap = modalCap();
    img.style.opacity = '0';
    img.src           = src;
    img.alt           = caption;
    img.onload        = () => { img.style.transition = 'opacity .3s ease'; img.style.opacity = '1'; };
    cap.textContent   = caption;
}

function _showModal() {
    const m = modal();
    m.classList.remove('opacity-0', 'pointer-events-none');
    m.classList.add('opacity-100');
    document.body.style.overflow = 'hidden';
    m.focus();
}

window.homeGalleryCloseModal = function (e) {
    if (e && e.target !== modal() && e.target !== modal().querySelector('button')) return;
    _closeModal();
};

function _closeModal() {
    const m = modal();
    m.classList.add('opacity-0', 'pointer-events-none');
    m.classList.remove('opacity-100');
    document.body.style.overflow = '';
}

function _navigate(direction) {
    if (!galleryItems.length) return;
    currentIndex = (currentIndex + direction + galleryItems.length) % galleryItems.length;
    const item = galleryItems[currentIndex];
    _renderModal(item.src, item.caption);
}

document.addEventListener('keydown', e => {
    const m = modal();
    if (!m || m.classList.contains('pointer-events-none')) return;
    switch (e.key) {
        case 'Escape':     _closeModal();  break;
        case 'ArrowRight': _navigate(1);   break;
        case 'ArrowLeft':  _navigate(-1);  break;
    }
});

let touchStartX = 0;
document.addEventListener('touchstart', e => {
    touchStartX = e.changedTouches[0].clientX;
}, { passive: true });
document.addEventListener('touchend', e => {
    const m = modal();
    if (!m || m.classList.contains('pointer-events-none')) return;
    const diff = touchStartX - e.changedTouches[0].clientX;
    if (Math.abs(diff) > 50) _navigate(diff > 0 ? 1 : -1);
});

function _injectNavButtons() {
    const m = modal();
    if (!m || m.querySelector('.gallery-nav-prev')) return;

    const btnClass = `
        gallery-nav-btn absolute top-1/2 -translate-y-1/2 z-20
        bg-black/40 hover:bg-black/70 text-white rounded-full p-2
        transition-colors duration-200 hidden md:flex items-center justify-center
    `;

    const prev = document.createElement('button');
    prev.className = btnClass + ' gallery-nav-prev left-4';
    prev.setAttribute('aria-label', 'Foto sebelumnya');
    prev.innerHTML = '<span class="material-symbols-outlined text-3xl">chevron_left</span>';
    prev.onclick   = e => { e.stopPropagation(); _navigate(-1); };

    const next = document.createElement('button');
    next.className = btnClass + ' gallery-nav-next right-4';
    next.setAttribute('aria-label', 'Foto selanjutnya');
    next.innerHTML = '<span class="material-symbols-outlined text-3xl">chevron_right</span>';
    next.onclick   = e => { e.stopPropagation(); _navigate(1); };

    m.appendChild(prev);
    m.appendChild(next);
}

function _initLazyObserver() {
    if (!('IntersectionObserver' in window)) return;
    const items = document.querySelectorAll('.stc-gallery-item img[loading="lazy"]');
    const obs   = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                if (img.dataset.src) { img.src = img.dataset.src; img.removeAttribute('data-src'); }
                obs.unobserve(img);
            }
        });
    }, { rootMargin: '200px' });
    items.forEach(img => obs.observe(img));
}

function _animateCounter(el, target, suffix = '', duration = 1800) {
    if (!el) return;
    const start = performance.now();
    function step(timestamp) {
        const progress = Math.min((timestamp - start) / duration, 1);
        const eased    = 1 - Math.pow(1 - progress, 3);
        el.textContent = Math.floor(target * eased) + suffix;
        if (progress < 1) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
}

function _initHeroCompliance() {
    const bar     = document.getElementById('hero-compliance-bar');
    const counter = document.getElementById('hero-compliance-counter');
    if (!bar || !counter) return;
    const obs = new IntersectionObserver(entries => {
        if (entries[0].isIntersecting) {
            bar.style.width = '98%';
            _animateCounter(counter, 98, '%');
            obs.disconnect();
        }
    }, { threshold: 0.5 });
    obs.observe(bar);
}

function _initScrollReveal() {
    const selectors = [
        '.stc-reveal', '.stc-reveal-left', '.stc-reveal-right',
        '.stc-stagger', '.stc-quote-reveal', '.stc-line-draw',
        '.cert-reveal',
    ];
    const els = document.querySelectorAll(selectors.join(','));
    if (!els.length) return;
    const obs = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) { entry.target.classList.add('visible'); obs.unobserve(entry.target); }
        });
    }, { threshold: 0.12 });
    els.forEach(el => obs.observe(el));
}

function _initHeroEntrance() {
    const els = [
        { sel: '.home-hero-badge', delay: 100 },
        { sel: '.home-hero-title', delay: 250 },
        { sel: '.home-hero-desc',  delay: 380 },
        { sel: '.home-hero-cta',   delay: 480 },
        { sel: '.home-hero-stats', delay: 580 },
        { sel: '.home-hero-card',  delay: 650 },
    ];
    els.forEach(({ sel, delay }) => {
        const el = document.querySelector(sel);
        if (!el) return;
        setTimeout(() => {
            el.classList.remove('opacity-0', 'translate-y-6', 'translate-x-8');
            el.classList.add('opacity-100');
        }, delay);
    });
}

function _initParticles() {
    const container = document.getElementById('hero-particles');
    if (!container) return;
    const canvas = document.createElement('canvas');
    const ctx    = canvas.getContext('2d');
    container.appendChild(canvas);
    let W, H, particles = [];

    function resize() { W = canvas.width = container.offsetWidth; H = canvas.height = container.offsetHeight; }
    function createParticle() {
        return { x: Math.random() * W, y: Math.random() * H, r: Math.random() * 2 + 0.5,
                 dx: (Math.random() - 0.5) * 0.4, dy: -Math.random() * 0.6 - 0.2, alpha: Math.random() * 0.5 + 0.1 };
    }
    function init() { resize(); particles = Array.from({ length: 60 }, createParticle); }
    function animate() {
        ctx.clearRect(0, 0, W, H);
        particles.forEach(p => {
            p.x += p.dx; p.y += p.dy;
            if (p.y < -5) Object.assign(p, createParticle(), { y: H + 5 });
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(234,88,12,${p.alpha})`;
            ctx.fill();
        });
        requestAnimationFrame(animate);
    }
    window.addEventListener('resize', resize);
    init(); animate();
}


// ════════════════════════════════════════════════════════════════════════════
// 2. GALLERY INDEX PAGE — Filter, search, pagination, lightbox
// ════════════════════════════════════════════════════════════════════════════

const GAL_PER_PAGE = 12;

// ─── State ───────────────────────────────────────────────────────────────────
let galAllCards   = [];
let galFiltered   = [];
let galPage       = 1;
let galActiveCat  = 'all';
let galSearch     = '';
let galLbIndex    = 0;

// ─── DOM refs ────────────────────────────────────────────────────────────────
let galGrid, galEmpty, galCountEl, galPaginEl, galPageInfo,
    galSearchEl, galLb, galLbImg, galLbCaption, galLbCounter,
    galLbClose, galLbPrev, galLbNext;

function _galResolveDom() {
    galGrid      = document.getElementById('gallery-grid');
    galEmpty     = document.getElementById('gal-empty');
    galCountEl   = document.getElementById('gal-visible-count');
    galPaginEl   = document.getElementById('gal-pagination');
    galPageInfo  = document.getElementById('gal-page-info');
    galSearchEl  = document.getElementById('gal-search');
    galLb        = document.getElementById('gal-lightbox');
    galLbImg     = document.getElementById('gal-lb-img');
    galLbCaption = document.getElementById('gal-lb-caption');
    galLbCounter = document.getElementById('gal-lb-counter');
    galLbClose   = document.getElementById('gal-lb-close');
    galLbPrev    = document.getElementById('gal-lb-prev');
    galLbNext    = document.getElementById('gal-lb-next');
    return !!galGrid;
}

// ─── Filter + render ─────────────────────────────────────────────────────────
function _galApplyFilters() {
    galFiltered = galAllCards.filter(card => {
        const catOk    = galActiveCat === 'all' || (card.dataset.cat ?? '') === galActiveCat;
        const searchOk = !galSearch || (card.dataset.caption ?? '').toLowerCase().includes(galSearch);
        return catOk && searchOk;
    });
    galPage = 1;
    _galRenderPage();
}

function _galRenderPage() {
    const total = galFiltered.length;
    const pages = Math.max(1, Math.ceil(total / GAL_PER_PAGE));
    if (galPage > pages) galPage = pages;

    const start = (galPage - 1) * GAL_PER_PAGE;
    const end   = start + GAL_PER_PAGE;

    galAllCards.forEach(c => { c.style.display = 'none'; c.removeAttribute('data-lb-idx'); });
    galFiltered.slice(start, end).forEach((card, i) => {
        card.style.display      = '';
        card.style.animationName = 'none';
        void card.offsetWidth;
        card.style.animationName  = '';
        card.style.animationDelay = `${i * 55}ms`;
        card.dataset.lbIdx        = start + i;
    });

    const isEmpty = total === 0;
    galEmpty.style.display     = isEmpty ? 'flex' : 'none';
    galGrid.style.display      = isEmpty ? 'none' : 'grid';
    if (galCountEl) galCountEl.textContent = total;

    _galRenderPagination(pages);
}

function _galRenderPagination(pages) {
    if (!galPaginEl) return;
    galPaginEl.innerHTML = '';
    if (pages <= 1) { if (galPageInfo) galPageInfo.textContent = ''; return; }

    const makeBtn = (label, page, isIcon = false) => {
        const btn = document.createElement('button');
        btn.className = 'gal-page-btn';
        if (isIcon) btn.innerHTML = `<span class="material-symbols-outlined text-lg">${label}</span>`;
        else btn.textContent = label;
        if (page === galPage && !isIcon) btn.classList.add('active');
        if ((page < 1 || page > pages) && isIcon) btn.disabled = true;
        btn.addEventListener('click', () => { galPage = page; _galRenderPage(); _galScrollToGrid(); });
        return btn;
    };

    galPaginEl.appendChild(makeBtn('chevron_left', galPage - 1, true));
    _galBuildPageRange(galPage, pages).forEach(p => {
        if (p === '…') {
            const s = document.createElement('span');
            s.className = 'gal-page-btn'; s.textContent = '…'; s.style.pointerEvents = 'none';
            galPaginEl.appendChild(s);
        } else {
            galPaginEl.appendChild(makeBtn(p, p));
        }
    });
    galPaginEl.appendChild(makeBtn('chevron_right', galPage + 1, true));

    const s = (galPage - 1) * GAL_PER_PAGE + 1;
    const e = Math.min(galPage * GAL_PER_PAGE, galFiltered.length);
    if (galPageInfo) galPageInfo.textContent = `Halaman ${galPage} dari ${pages} · Foto ${s}–${e} dari ${galFiltered.length}`;
}

function _galBuildPageRange(cur, total) {
    if (total <= 7) return Array.from({ length: total }, (_, i) => i + 1);
    if (cur <= 4)         return [1, 2, 3, 4, 5, '…', total];
    if (cur >= total - 3) return [1, '…', total-4, total-3, total-2, total-1, total];
    return [1, '…', cur-1, cur, cur+1, '…', total];
}

function _galScrollToGrid() {
    document.getElementById('gallery-section')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

// ─── Lightbox ────────────────────────────────────────────────────────────────
function _galOpenLightbox(idx) {
    galLbIndex = idx;
    _galRenderLightbox();
    galLb.classList.add('open');
    galLb.focus();
    document.body.style.overflow = 'hidden';
}

function _galCloseLightbox() {
    galLb.classList.remove('open');
    document.body.style.overflow = '';
}

function _galRenderLightbox() {
    const card = galFiltered[galLbIndex];
    if (!card) return;
    galLbImg.classList.add('fading');
    setTimeout(() => {
        galLbImg.src          = card.dataset.src ?? '';
        galLbImg.alt          = card.dataset.caption ?? '';
        galLbCaption.textContent = card.dataset.caption ?? '';
        galLbCounter.textContent = `${galLbIndex + 1} / ${galFiltered.length}`;
        galLbImg.classList.remove('fading');
    }, 200);
    galLbPrev.disabled = galLbIndex === 0;
    galLbNext.disabled = galLbIndex === galFiltered.length - 1;
}

function _galLbNavigate(dir) {
    const next = galLbIndex + dir;
    if (next < 0 || next >= galFiltered.length) return;
    galLbIndex = next;
    _galRenderLightbox();
}

// ─── Event binding ───────────────────────────────────────────────────────────
function _galBindEvents() {
    // Filter pills
    document.querySelectorAll('.gal-filter-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.gal-filter-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            galActiveCat = btn.dataset.cat;
            _galApplyFilters();
        });
    });

    // Search (debounced)
    let debTimer;
    galSearchEl?.addEventListener('input', e => {
        clearTimeout(debTimer);
        debTimer = setTimeout(() => {
            galSearch = e.target.value.trim().toLowerCase();
            _galApplyFilters();
        }, 280);
    });

    // ── Card interactions ────────────────────────────────────────────────
    // Clicking the "Lihat Foto" CTA button → navigate to detail page
    // Clicking anywhere else on the card → open lightbox (quick preview)
    galGrid.addEventListener('click', e => {
        const ctaBtn = e.target.closest('.gal-open-lb');
        if (ctaBtn) {
            // Navigate to the detail page for this card's category
            const card = ctaBtn.closest('.gal-card');
            if (!card) return;
            const cat = (card.dataset.cat || '').trim() || 'all';
            window.location.href = '/gallery/' + encodeURIComponent(cat);
            return;
        }

        // Fallback: click on card body → quick lightbox preview
        const card = e.target.closest('.gal-card');
        if (!card) return;
        const idx = parseInt(card.dataset.lbIdx ?? '-1', 10);
        if (idx >= 0) _galOpenLightbox(idx);
    });

    galGrid.addEventListener('keydown', e => {
        if (e.key !== 'Enter' && e.key !== ' ') return;
        const card = e.target.closest('.gal-card');
        if (!card) return;
        e.preventDefault();
        const idx = parseInt(card.dataset.lbIdx ?? '-1', 10);
        if (idx >= 0) _galOpenLightbox(idx);
    });

    // Lightbox controls
    galLbClose?.addEventListener('click', _galCloseLightbox);
    galLbPrev?.addEventListener('click',  () => _galLbNavigate(-1));
    galLbNext?.addEventListener('click',  () => _galLbNavigate(1));
    galLb?.addEventListener('click', e => { if (e.target === galLb) _galCloseLightbox(); });

    document.addEventListener('keydown', e => {
        if (!galLb?.classList.contains('open')) return;
        if (e.key === 'Escape')     _galCloseLightbox();
        if (e.key === 'ArrowLeft')  _galLbNavigate(-1);
        if (e.key === 'ArrowRight') _galLbNavigate(1);
    });

    let tStartX = 0;
    galLb?.addEventListener('touchstart', e => { tStartX = e.changedTouches[0].clientX; }, { passive: true });
    galLb?.addEventListener('touchend', e => {
        const diff = tStartX - e.changedTouches[0].clientX;
        if (Math.abs(diff) > 50) _galLbNavigate(diff > 0 ? 1 : -1);
    });
}

// ─── Public reset (called from blade onclick) ─────────────────────────────────
window.galResetFilters = function () {
    galActiveCat = 'all';
    galSearch    = '';
    if (galSearchEl) galSearchEl.value = '';
    document.querySelectorAll('.gal-filter-btn').forEach(b => {
        b.classList.toggle('active', b.dataset.cat === 'all');
    });
    _galApplyFilters();
};

// ─── Init gallery index ───────────────────────────────────────────────────────
function _initGalleryIndex() {
    if (!_galResolveDom()) return;
    galAllCards = Array.from(galGrid.querySelectorAll('.gal-card'));
    _galApplyFilters();
    _galBindEvents();
}


// ════════════════════════════════════════════════════════════════════════════
// Bootstrap
// ════════════════════════════════════════════════════════════════════════════
document.addEventListener('DOMContentLoaded', () => {
    buildGalleryItems();
    _injectNavButtons();
    _initLazyObserver();
    _initScrollReveal();
    _initHeroEntrance();
    _initHeroCompliance();
    _initParticles();

    _initGalleryIndex();
});