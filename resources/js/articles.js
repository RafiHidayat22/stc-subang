/**
 * resources/js/articles.js
 *
 * Handles:
 *  - Scroll-reveal animation for article cards and sections
 *  - Newsletter form submission with basic validation
 */

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
    { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
);

document.querySelectorAll('.art-reveal').forEach((el) => {
    revealObserver.observe(el);
});

// Staggered reveal for article cards inside the grid
const grid = document.getElementById('articles-grid');
if (grid) {
    const cards = grid.querySelectorAll('article');
    cards.forEach((card, i) => {
        card.style.transitionDelay = `${i * 0.07}s`;
        card.classList.add('art-reveal');
        revealObserver.observe(card);
    });
}

// ── Newsletter Form ──────────────────────────────────────────────────────────

const newsletterBtn = document.getElementById('newsletter-btn');
const newsletterEmail = document.getElementById('newsletter-email');
const newsletterMsg = document.getElementById('newsletter-msg');

if (newsletterBtn && newsletterEmail && newsletterMsg) {
    newsletterBtn.addEventListener('click', () => {
        const email = newsletterEmail.value.trim();

        // Basic email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            newsletterMsg.textContent = 'Mohon masukkan alamat email yang valid.';
            newsletterMsg.className = 'mt-3 text-sm text-error';
            newsletterMsg.classList.remove('hidden');
            newsletterEmail.focus();
            return;
        }

        // Disable the button while "submitting"
        newsletterBtn.disabled = true;
        newsletterBtn.textContent = 'Mengirim…';

        // Simulate async submission (replace with real fetch/axios call)
        setTimeout(() => {
            newsletterMsg.textContent = 'Terima kasih! Anda telah berhasil berlangganan buletin STC.';
            newsletterMsg.className = 'mt-3 text-sm text-green-600 font-semibold';
            newsletterMsg.classList.remove('hidden');
            newsletterEmail.value = '';
            newsletterBtn.disabled = false;
            newsletterBtn.textContent = 'Berlangganan';
        }, 800);
    });

    // Allow Enter key on the email input
    newsletterEmail.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') newsletterBtn.click();
    });
}