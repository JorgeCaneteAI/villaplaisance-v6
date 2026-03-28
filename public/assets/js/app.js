/* Villa Plaisance — app.js */
'use strict';

// ── Header sticky ────────────────────────────────────────────────────────────
(function () {
    const header = document.getElementById('site-header');
    if (!header) return;

    let lastY = 0;
    window.addEventListener('scroll', () => {
        const y = window.scrollY;
        if (y > 80) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
        if (y > 200 && y > lastY) {
            header.classList.add('hidden');
        } else {
            header.classList.remove('hidden');
        }
        lastY = y;
    }, { passive: true });
})();

// ── Menu mobile ───────────────────────────────────────────────────────────────
(function () {
    const toggle = document.getElementById('nav-toggle');
    const nav    = document.getElementById('main-nav');
    if (!toggle || !nav) return;

    toggle.addEventListener('click', () => {
        const open = toggle.getAttribute('aria-expanded') === 'true';
        toggle.setAttribute('aria-expanded', String(!open));
        nav.classList.toggle('open', !open);
        toggle.classList.toggle('active', !open);
    });

    // Fermer au clic extérieur
    document.addEventListener('click', (e) => {
        if (!toggle.contains(e.target) && !nav.contains(e.target)) {
            toggle.setAttribute('aria-expanded', 'false');
            nav.classList.remove('open');
            toggle.classList.remove('active');
        }
    });
})();

// ── Scroll reveal ─────────────────────────────────────────────────────────────
(function () {
    const items = document.querySelectorAll('.reveal');
    if (!items.length) return;

    if ('IntersectionObserver' in window) {
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

        items.forEach(el => obs.observe(el));
    } else {
        items.forEach(el => el.classList.add('visible'));
    }
})();

// ── FAQ accordion ─────────────────────────────────────────────────────────────
(function () {
    const items = document.querySelectorAll('.faq-item');
    if (!items.length) return;

    items.forEach(item => {
        const q = item.querySelector('.faq-question');
        const a = item.querySelector('.faq-answer');
        if (!q || !a) return;

        q.setAttribute('role', 'button');
        q.setAttribute('tabindex', '0');
        q.setAttribute('aria-expanded', 'false');
        a.style.maxHeight = '0';
        a.style.overflow  = 'hidden';
        a.style.transition = 'max-height 0.35s ease';

        function toggle() {
            const open = item.classList.contains('open');
            // Fermer tous
            items.forEach(i => {
                i.classList.remove('open');
                const ia = i.querySelector('.faq-answer');
                const iq = i.querySelector('.faq-question');
                if (ia) ia.style.maxHeight = '0';
                if (iq) iq.setAttribute('aria-expanded', 'false');
            });
            if (!open) {
                item.classList.add('open');
                a.style.maxHeight = a.scrollHeight + 'px';
                q.setAttribute('aria-expanded', 'true');
            }
        }

        q.addEventListener('click', toggle);
        q.addEventListener('keydown', e => { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); toggle(); } });
    });
})();

// ── Galerie lightbox (simple) ─────────────────────────────────────────────────
(function () {
    const imgs = document.querySelectorAll('.galerie-img');
    if (!imgs.length) return;

    const overlay = document.createElement('div');
    overlay.className = 'lightbox-overlay';
    overlay.setAttribute('role', 'dialog');
    overlay.setAttribute('aria-modal', 'true');
    overlay.innerHTML = '<button class="lightbox-close" aria-label="Fermer">✕</button><img class="lightbox-img" src="" alt="">';
    document.body.appendChild(overlay);

    const lbImg   = overlay.querySelector('.lightbox-img');
    const lbClose = overlay.querySelector('.lightbox-close');

    function open(src, alt) {
        lbImg.src = src;
        lbImg.alt = alt;
        overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
        lbClose.focus();
    }
    function close() {
        overlay.classList.remove('open');
        document.body.style.overflow = '';
    }

    imgs.forEach(img => {
        img.style.cursor = 'zoom-in';
        img.addEventListener('click', () => open(img.src, img.alt));
    });
    lbClose.addEventListener('click', close);
    overlay.addEventListener('click', e => { if (e.target === overlay) close(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') close(); });
})();
