/**
 * resources/js/certification.js
 * ──────────────────────────────────────────────────────────────────
 * Handles semua animasi & interaktivitas untuk halaman:
 *   - certification/index        (cert-section, cert-reveal, cert-stagger)
 *   - category_certification/index (cert-card search/filter)
 *   - detail_certification/index   (sticky sidebar, syllabus download)
 * ──────────────────────────────────────────────────────────────────
 */

/* ─────────────────────────────────────────────────────────────────
   1. SCROLL-REVEAL (IntersectionObserver)
───────────────────────────────────────────────────────────────── */
function initReveal() {
    const THRESHOLD = 0.15;

    const revealObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('cert-visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        },
        { threshold: THRESHOLD }
    );

    // Single elements
    document.querySelectorAll(
        '.cert-reveal, .cert-reveal-left, .cert-reveal-right'
    ).forEach((el) => revealObserver.observe(el));

    // Staggered children
    const staggerObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('cert-visible');
                    staggerObserver.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.1 }
    );

    document.querySelectorAll('.cert-stagger').forEach((el) =>
        staggerObserver.observe(el)
    );
}

/* ─────────────────────────────────────────────────────────────────
   2. INJECT REVEAL CSS ONCE
───────────────────────────────────────────────────────────────── */
function injectRevealStyles() {
    if (document.getElementById('cert-reveal-style')) return;

    const style = document.createElement('style');
    style.id = 'cert-reveal-style';
    style.textContent = `
        /* Base hidden states */
        .cert-reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.7s cubic-bezier(.22,1,.36,1),
                        transform 0.7s cubic-bezier(.22,1,.36,1);
        }
        .cert-reveal-left {
            opacity: 0;
            transform: translateX(-50px);
            transition: opacity 0.7s cubic-bezier(.22,1,.36,1),
                        transform 0.7s cubic-bezier(.22,1,.36,1);
        }
        .cert-reveal-right {
            opacity: 0;
            transform: translateX(50px);
            transition: opacity 0.7s cubic-bezier(.22,1,.36,1),
                        transform 0.7s cubic-bezier(.22,1,.36,1);
        }

        /* Visible states */
        .cert-reveal.cert-visible,
        .cert-reveal-left.cert-visible,
        .cert-reveal-right.cert-visible {
            opacity: 1;
            transform: none;
        }

        /* Stagger children */
        .cert-stagger > * {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s cubic-bezier(.22,1,.36,1),
                        transform 0.6s cubic-bezier(.22,1,.36,1);
        }
        .cert-stagger.cert-visible > *:nth-child(1)  { opacity:1; transform:none; transition-delay:.05s }
        .cert-stagger.cert-visible > *:nth-child(2)  { opacity:1; transform:none; transition-delay:.13s }
        .cert-stagger.cert-visible > *:nth-child(3)  { opacity:1; transform:none; transition-delay:.21s }
        .cert-stagger.cert-visible > *:nth-child(4)  { opacity:1; transform:none; transition-delay:.29s }
        .cert-stagger.cert-visible > *:nth-child(5)  { opacity:1; transform:none; transition-delay:.37s }
        .cert-stagger.cert-visible > *:nth-child(6)  { opacity:1; transform:none; transition-delay:.45s }
        .cert-stagger.cert-visible > *:nth-child(n+7){ opacity:1; transform:none; transition-delay:.53s }

        /* Card hover lift */
        .cert-card {
            transition: transform .3s cubic-bezier(.22,1,.36,1),
                        box-shadow .3s ease;
        }
        .cert-card:hover { transform: translateY(-6px); }

        /* Scrollbar hide for category nav */
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    `;
    document.head.appendChild(style);
}

/* ─────────────────────────────────────────────────────────────────
   3. LIVE SEARCH / FILTER  (category page)
───────────────────────────────────────────────────────────────── */
function initCertSearch() {
    const searchInput = document.getElementById('cert-search');
    const grid        = document.getElementById('cert-grid');
    const emptyState  = document.getElementById('cert-empty');

    if (!searchInput || !grid) return;

    const cards = () => grid.querySelectorAll('.cert-card');

    searchInput.addEventListener('input', () => {
        const query = searchInput.value.trim().toLowerCase();
        let visible = 0;

        cards().forEach((card) => {
            const name = card.dataset.name  || '';
            const code = card.dataset.code  || '';
            const match = name.includes(query) || code.includes(query);

            if (match) {
                card.style.display = '';
                visible++;
            } else {
                card.style.display = 'none';
            }
        });

        if (emptyState) {
            emptyState.classList.toggle('hidden', visible > 0);
        }
    });
}

/* ─────────────────────────────────────────────────────────────────
   4. STICKY SIDEBAR ACTIVE HIGHLIGHT  (detail page)
───────────────────────────────────────────────────────────────── */
function initStickyHighlight() {
    const sidebar = document.querySelector('[id="registration"]');
    if (!sidebar) return;

    // Show a subtle "pulse" on the register card after 3 s
    setTimeout(() => {
        sidebar.classList.add('cert-sidebar-pulse');

        const style = document.createElement('style');
        style.textContent = `
            @keyframes certSidebarPulse {
                0%,100% { box-shadow: 0 0 0 0 rgba(249,99,2,0); }
                50%      { box-shadow: 0 0 0 10px rgba(249,99,2,.15); }
            }
            .cert-sidebar-pulse { animation: certSidebarPulse 2s ease-in-out 3; }
        `;
        document.head.appendChild(style);
    }, 3000);
}

/* ─────────────────────────────────────────────────────────────────
   5. SYLLABUS DOWNLOAD BUTTON  (detail page)
───────────────────────────────────────────────────────────────── */
function initSyllabusDownload() {
    const btn = document.getElementById('btn-download-syllabus');
    if (!btn) return;

    btn.addEventListener('click', () => {
        // If you have a real PDF route, replace the href below.
        // For now, show an alert/toast directing user to contact us.
        showToast('Unduhan silabus segera tersedia. Hubungi kami di 0811-2021-212.', 'info');
    });
}

/* ─────────────────────────────────────────────────────────────────
   6. TOAST NOTIFICATION
───────────────────────────────────────────────────────────────── */
function showToast(message, type = 'info') {
    // Create container if it doesn't exist
    let container = document.getElementById('cert-toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'cert-toast-container';
        container.style.cssText = `
            position: fixed; bottom: 1.5rem; right: 1.5rem; z-index: 9999;
            display: flex; flex-direction: column; gap: .75rem;
        `;
        document.body.appendChild(container);
    }

    const colors = {
        info    : { bg: '#002046', border: '#F96302', icon: 'info' },
        success : { bg: '#166534', border: '#4ade80', icon: 'check_circle' },
        error   : { bg: '#7f1d1d', border: '#f87171', icon: 'error' },
    };
    const c = colors[type] || colors.info;

    const toast = document.createElement('div');
    toast.style.cssText = `
        background: ${c.bg}; color: #fff; border-left: 4px solid ${c.border};
        padding: .875rem 1.25rem; border-radius: .5rem;
        box-shadow: 0 10px 30px rgba(0,0,0,.25);
        display: flex; align-items: center; gap: .75rem;
        max-width: 360px; font-family: Montserrat, sans-serif; font-size: .875rem;
        animation: certToastIn .4s cubic-bezier(.22,1,.36,1);
    `;
    toast.innerHTML = `
        <span class="material-symbols-outlined" style="font-size:20px;color:${c.border};flex-shrink:0">${c.icon}</span>
        <span style="flex-grow:1">${message}</span>
        <button onclick="this.parentElement.remove()" style="background:none;border:none;color:#fff;cursor:pointer;padding:0;line-height:1">
            <span class="material-symbols-outlined" style="font-size:18px">close</span>
        </button>
    `;

    if (!document.getElementById('cert-toast-style')) {
        const ts = document.createElement('style');
        ts.id = 'cert-toast-style';
        ts.textContent = `
            @keyframes certToastIn {
                from { opacity:0; transform:translateY(20px) }
                to   { opacity:1; transform:translateY(0) }
            }
        `;
        document.head.appendChild(ts);
    }

    container.appendChild(toast);
    setTimeout(() => toast.remove(), 5000);
}

/* ─────────────────────────────────────────────────────────────────
   7. COUNTER ANIMATION (index page stats)
───────────────────────────────────────────────────────────────── */
function initCounters() {
    const counters = document.querySelectorAll('[data-count-target]');
    if (!counters.length) return;

    const obs = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            const el     = entry.target;
            const target = parseFloat(el.dataset.countTarget);
            const suffix = el.dataset.countSuffix || '';
            const dur    = 1500;
            const start  = performance.now();

            function tick(now) {
                const elapsed  = now - start;
                const progress = Math.min(elapsed / dur, 1);
                const eased    = 1 - Math.pow(1 - progress, 3); // easeOutCubic
                el.textContent = Math.round(target * eased) + suffix;
                if (progress < 1) requestAnimationFrame(tick);
            }

            requestAnimationFrame(tick);
            obs.unobserve(el);
        });
    }, { threshold: 0.5 });

    counters.forEach((el) => obs.observe(el));
}

/* ─────────────────────────────────────────────────────────────────
   8. MOBILE NAV TOGGLE (category pill scrollbar active)
───────────────────────────────────────────────────────────────── */
function initCategoryNavScroll() {
    const nav    = document.querySelector('[role="navigation"][aria-label="Kategori Sertifikasi"]');
    const active = nav?.querySelector('a[class*="bg-primary"]');
    if (active) {
        active.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
    }
}

/* ─────────────────────────────────────────────────────────────────
   BOOT
───────────────────────────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
    injectRevealStyles();
    initReveal();
    initCertSearch();
    initStickyHighlight();
    initSyllabusDownload();
    initCounters();
    initCategoryNavScroll();
});