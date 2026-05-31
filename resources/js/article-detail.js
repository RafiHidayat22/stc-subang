/**
 * resources/js/article-detail.js
 *
 * Handles:
 *  - Scroll-reveal animation
 *  - Header shrink on scroll
 *  - Reading-progress bar
 *  - Share functionality (WhatsApp + copy link)
 */

// ── Reading Progress Bar ─────────────────────────────────────────────────────

const progressBar = document.createElement('div');
progressBar.id = 'reading-progress';
progressBar.setAttribute('role', 'progressbar');
progressBar.setAttribute('aria-label', 'Progres membaca');
Object.assign(progressBar.style, {
    position: 'fixed',
    top: '0',
    left: '0',
    height: '3px',
    width: '0%',
    backgroundColor: '#F96302',
    zIndex: '9999',
    transition: 'width .1s linear',
});
document.body.prepend(progressBar);

// ── Scroll: progress + header shrink ────────────────────────────────────────

const header = document.querySelector('header');

window.addEventListener('scroll', () => {
    // Reading progress
    const scrollTop = window.scrollY;
    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
    const pct = docHeight > 0 ? Math.round((scrollTop / docHeight) * 100) : 0;
    progressBar.style.width = pct + '%';
    progressBar.setAttribute('aria-valuenow', pct);

    // Header shrink
    if (header) {
        if (scrollTop > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    }
}, { passive: true });

// ── Scroll Reveal ────────────────────────────────────────────────────────────

const revealObserver = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                revealObserver.unobserve(entry.target);
            }
        });
    },
    { threshold: 0.1, rootMargin: '0px 0px -30px 0px' }
);

document.querySelectorAll('.art-reveal').forEach((el) => {
    revealObserver.observe(el);
});

// ── Share Functions ──────────────────────────────────────────────────────────

/**
 * @param {'whatsapp'|'copy'} method
 */
window.articleShare = function (method) {
    const url  = window.location.href;
    const title = document.querySelector('h1')?.textContent?.trim() ?? 'Artikel STC Indonesia';

    if (method === 'whatsapp') {
        const waUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(title + '\n' + url)}`;
        window.open(waUrl, '_blank', 'noopener,noreferrer');
        return;
    }

    if (method === 'copy') {
        const copyBtn = document.getElementById('copy-btn');

        if (navigator.clipboard) {
            navigator.clipboard.writeText(url).then(() => {
                showCopyFeedback(copyBtn);
            }).catch(() => {
                fallbackCopy(url, copyBtn);
            });
        } else {
            fallbackCopy(url, copyBtn);
        }
    }
};

function showCopyFeedback(btn) {
    if (!btn) return;
    const icon = btn.querySelector('.material-symbols-outlined');
    if (icon) {
        const original = icon.textContent;
        icon.textContent = 'check';
        btn.classList.add('bg-green-500', 'text-white');
        setTimeout(() => {
            icon.textContent = original;
            btn.classList.remove('bg-green-500', 'text-white');
        }, 1800);
    }
}

function fallbackCopy(text, btn) {
    const textarea = document.createElement('textarea');
    textarea.value = text;
    textarea.style.cssText = 'position:fixed;left:-9999px;top:-9999px';
    document.body.appendChild(textarea);
    textarea.focus();
    textarea.select();
    try {
        document.execCommand('copy');
        showCopyFeedback(btn);
    } catch (_) {
        // silently fail
    }
    document.body.removeChild(textarea);
}