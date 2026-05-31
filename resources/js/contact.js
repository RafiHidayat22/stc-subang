/**
 * resources/js/contact.js
 * Contact page interactions:
 *  - Scroll-reveal animations
 *  - Live character counter for message textarea
 *  - Client-side form validation with accessible error display
 *  - Submit loading state
 *  - Auto-dismiss success alert
 *  - Smooth scroll to form on CTA click
 */

/* ─────────────────────────────────────────────
   1. SCROLL REVEAL
───────────────────────────────────────────── */
function initScrollReveal() {
    const selectors = [
        '.ctc-reveal',
        '.ctc-reveal-left',
        '.ctc-reveal-right',
        '.ctc-stagger',
    ];

    const targets = document.querySelectorAll(selectors.join(','));

    if (!targets.length) return;

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
    );

    targets.forEach((el) => observer.observe(el));

    // Immediately reveal anything already in view on load
    requestAnimationFrame(() => {
        targets.forEach((el) => {
            const rect = el.getBoundingClientRect();
            if (rect.top < window.innerHeight - 40) {
                el.classList.add('visible');
                observer.unobserve(el);
            }
        });
    });
}

/* ─────────────────────────────────────────────
   2. CHARACTER COUNTER
───────────────────────────────────────────── */
function initCharCounter() {
    const textarea = document.getElementById('message');
    const counter  = document.getElementById('message-count');

    if (!textarea || !counter) return;

    const max = parseInt(textarea.getAttribute('maxlength'), 10) || 2000;

    function update() {
        const len = textarea.value.length;
        counter.textContent = `${len} / ${max}`;
        counter.classList.toggle('text-red-500', len > max * 0.9);
    }

    textarea.addEventListener('input', update);
    update(); // initialise with old() value if any
}

/* ─────────────────────────────────────────────
   3. CLIENT-SIDE VALIDATION
───────────────────────────────────────────── */
const RULES = {
    name:    { required: true, maxLength: 100,  label: 'Nama Lengkap' },
    email:   { required: true, maxLength: 150,  label: 'Email', pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/ },
    phone:   { required: false,                 label: 'Nomor Telepon', pattern: /^[\d\+\-\s]{7,20}$/ },
    message: { required: true, minLength: 10, maxLength: 2000, label: 'Pesan' },
};

function setFieldError(field, message) {
    field.classList.add('is-invalid');
    field.setAttribute('aria-invalid', 'true');

    let errEl = document.getElementById(`${field.id}-error`);
    if (!errEl) {
        errEl = document.createElement('p');
        errEl.id        = `${field.id}-error`;
        errEl.className = 'mt-1.5 text-xs text-red-600 flex items-center gap-1 ctc-field-error';
        errEl.setAttribute('role', 'alert');
        field.parentNode.insertBefore(errEl, field.nextSibling);
    }
    errEl.innerHTML = `<span class="material-symbols-outlined text-sm" aria-hidden="true">error</span>${message}`;
    field.setAttribute('aria-describedby', errEl.id);
}

function clearFieldError(field) {
    field.classList.remove('is-invalid');
    field.removeAttribute('aria-invalid');
    const errEl = document.getElementById(`${field.id}-error`);
    // Only remove dynamically created errors (not server-rendered ones)
    if (errEl && errEl.classList.contains('ctc-field-error')) {
        errEl.remove();
    }
}

function validateField(field) {
    const rule = RULES[field.name];
    if (!rule) return true;

    const val = field.value.trim();

    if (rule.required && !val) {
        setFieldError(field, `${rule.label} wajib diisi.`);
        return false;
    }
    if (val && rule.pattern && !rule.pattern.test(val)) {
        const msgs = {
            email: 'Format email tidak valid.',
            phone: 'Format nomor telepon tidak valid.',
        };
        setFieldError(field, msgs[field.name] || 'Format tidak valid.');
        return false;
    }
    if (rule.minLength && val.length < rule.minLength) {
        setFieldError(field, `${rule.label} minimal ${rule.minLength} karakter.`);
        return false;
    }
    if (rule.maxLength && val.length > rule.maxLength) {
        setFieldError(field, `${rule.label} maksimal ${rule.maxLength} karakter.`);
        return false;
    }

    clearFieldError(field);
    return true;
}

function initFormValidation() {
    const form   = document.getElementById('contact-form');
    const submit = document.getElementById('contact-submit');

    if (!form || !submit) return;

    // Live validation on blur
    form.querySelectorAll('input, textarea, select').forEach((field) => {
        field.addEventListener('blur', () => validateField(field));
        field.addEventListener('input', () => {
            if (field.classList.contains('is-invalid')) validateField(field);
        });
    });

    // Submit handler
    form.addEventListener('submit', (e) => {
        let isValid = true;

        // Validate all rules-defined fields
        Object.keys(RULES).forEach((name) => {
            const field = form.querySelector(`[name="${name}"]`);
            if (field && !validateField(field)) {
                isValid = false;
            }
        });

        if (!isValid) {
            e.preventDefault();
            // Focus first invalid field
            const first = form.querySelector('.is-invalid');
            if (first) {
                first.focus();
                first.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            return;
        }

        // Show loading state
        submit.classList.add('loading');
        submit.setAttribute('disabled', 'disabled');
        submit.setAttribute('aria-label', 'Mengirim pesan...');
    });
}

/* ─────────────────────────────────────────────
   4. AUTO-DISMISS SUCCESS ALERT
───────────────────────────────────────────── */
function initSuccessAlert() {
    const alert = document.getElementById('contact-success-alert');
    if (!alert) return;

    // Auto-dismiss after 8 seconds
    setTimeout(() => {
        alert.style.transition = 'opacity .5s ease, transform .5s ease';
        alert.style.opacity    = '0';
        alert.style.transform  = 'translateY(-12px)';
        setTimeout(() => alert.remove(), 500);
    }, 8000);

    // Scroll to alert on page load
    alert.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

/* ─────────────────────────────────────────────
   5. SMOOTH SCROLL FOR CTA "REQUEST PROPOSAL"
───────────────────────────────────────────── */
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener('click', (e) => {
            const targetId = anchor.getAttribute('href').slice(1);
            const target   = document.getElementById(targetId);
            if (!target) return;
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
}

/* ─────────────────────────────────────────────
   6. INIT
───────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
    initScrollReveal();
    initCharCounter();
    initFormValidation();
    initSuccessAlert();
    initSmoothScroll();
});