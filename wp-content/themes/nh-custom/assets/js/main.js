/**
 * Narasumber Hukum Custom Theme — Interactive Frontend Logic
 * Handles:
 * 1. Scroll-aware Navbar (transparent on Hero -> solid bg-navbar on scroll)
 * 2. Mobile menu toggle
 * 3. Instant Language Switcher (ID <-> EN) with localStorage ('nh-locale') & dynamic article translation
 * 4. Scroll Reveal animations (IntersectionObserver)
 * 5. FAQ Accordion toggle
 * 6. Article Category Filter & Image Lightbox
 * 7. Contact Form AJAX submission
 */

(function () {
    'use strict';

    const config = window.NH_CONFIG || {};
    const translations = config.translations || {};
    let currentLocale = localStorage.getItem('nh-locale') || 'id';
    if (currentLocale !== 'id' && currentLocale !== 'en') {
        currentLocale = 'id';
    }

    function getNestedTranslation(localeObj, path) {
        if (!localeObj || !path) return null;
        const keys = path.split('.');
        let res = localeObj;
        for (let i = 0; i < keys.length; i++) {
            if (res && typeof res === 'object' && keys[i] in res) {
                res = res[keys[i]];
            } else {
                return null;
            }
        }
        return typeof res === 'string' ? res : null;
    }

    // Google Translate helper for dynamic user-created content when switching to EN
    const translateCache = {};
    async function translateDynamicText(text, targetLang, sourceLang) {
        if (!text || !text.trim()) return text;
        const key = sourceLang + '-' + targetLang + '-' + text;
        if (translateCache[key]) return translateCache[key];
        try {
            const url = 'https://translate.googleapis.com/translate_a/single?client=gtx&sl=' + sourceLang + '&tl=' + targetLang + '&dt=t&q=' + encodeURIComponent(text);
            const res = await fetch(url);
            const data = await res.json();
            if (data && data[0]) {
                const out = data[0].map(function (item) { return item[0] || ''; }).join('');
                translateCache[key] = out;
                return out;
            }
        } catch (e) {
            console.warn('Translation fallback:', e);
        }
        return text;
    }

    function applyLocale(locale) {
        currentLocale = locale;
        localStorage.setItem('nh-locale', locale);
        document.documentElement.lang = locale;

        const dict = translations[locale];
        if (dict) {
            // Update all elements with data-nh-i18n while preserving custom Elementor Indonesian edits
            document.querySelectorAll('[data-nh-i18n]').forEach(function (el) {
                if (!el.hasAttribute('data-nh-id-orig')) {
                    el.setAttribute('data-nh-id-orig', el.textContent);
                }
                if (locale === 'id') {
                    el.textContent = el.getAttribute('data-nh-id-orig');
                } else {
                    const key = el.getAttribute('data-nh-i18n');
                    const val = getNestedTranslation(dict, key);
                    if (val !== null) {
                        el.textContent = val;
                    }
                }
            });

            // Update input placeholders
            document.querySelectorAll('[data-nh-placeholder]').forEach(function (el) {
                const key = el.getAttribute('data-nh-placeholder');
                const val = getNestedTranslation(dict, key);
                if (val !== null) {
                    el.setAttribute('placeholder', val);
                }
            });
        }

        // Toggle bilingual HTML blocks (e.g., Service detail ID vs EN)
        document.querySelectorAll('[data-nh-lang-block]').forEach(function (el) {
            const blockLang = el.getAttribute('data-nh-lang-block');
            if (blockLang === locale) {
                el.classList.remove('hidden');
            } else {
                el.classList.add('hidden');
            }
        });

        // Update Floating Language Button badge
        const langCodeEl = document.getElementById('nh-lang-code');
        const langLabelEl = document.getElementById('nh-lang-label');
        if (langCodeEl) langCodeEl.textContent = locale === 'id' ? 'ID' : 'EN';
        if (langLabelEl) langLabelEl.textContent = locale === 'id' ? 'Ganti Bahasa' : 'Switch Language';

        // Dynamic article translation (for articles page / single article)
        document.querySelectorAll('[data-nh-dynamic-translate]').forEach(async function (el) {
            if (!el.getAttribute('data-nh-orig')) {
                el.setAttribute('data-nh-orig', el.textContent);
            }
            const orig = el.getAttribute('data-nh-orig');
            if (locale === 'en') {
                const translated = await translateDynamicText(orig, 'en', 'id');
                el.textContent = translated;
            } else {
                el.textContent = orig;
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        // 1. Initialize Language
        applyLocale(currentLocale);

        const langBtn = document.getElementById('nh-floating-lang-btn');
        if (langBtn) {
            langBtn.addEventListener('click', function () {
                applyLocale(currentLocale === 'id' ? 'en' : 'id');
            });
        }

        // 2. Scroll-aware Navbar
        const navbar = document.getElementById('nh-navbar');
        const isHome = navbar && navbar.getAttribute('data-is-home') === '1';

        function updateNavbar() {
            if (!navbar) return;
            if (window.scrollY > 50 || !isHome) {
                navbar.classList.add('bg-navbar', 'shadow-2xl', 'py-3');
                navbar.classList.remove('bg-transparent', 'py-5');
            } else {
                navbar.classList.add('bg-transparent', 'py-5');
                navbar.classList.remove('bg-navbar', 'shadow-2xl', 'py-3');
            }
        }
        updateNavbar();
        window.addEventListener('scroll', updateNavbar, { passive: true });

        // 3. Mobile Menu Toggle
        const mobileBtn = document.getElementById('nh-mobile-menu-btn');
        const mobileMenu = document.getElementById('nh-mobile-menu');
        const iconMenu = document.getElementById('nh-icon-menu');
        const iconClose = document.getElementById('nh-icon-close');

        if (mobileBtn && mobileMenu) {
            mobileBtn.addEventListener('click', function () {
                const isHidden = mobileMenu.classList.contains('hidden');
                if (isHidden) {
                    mobileMenu.classList.remove('hidden');
                    if (iconMenu) iconMenu.classList.add('hidden');
                    if (iconClose) iconClose.classList.remove('hidden');
                } else {
                    mobileMenu.classList.add('hidden');
                    if (iconMenu) iconMenu.classList.remove('hidden');
                    if (iconClose) iconClose.classList.add('hidden');
                }
            });
        }

        // 4. Scroll Reveal Animations
        const revealEls = document.querySelectorAll('.nh-reveal');
        if ('IntersectionObserver' in window && revealEls.length > 0) {
            const observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12 });

            revealEls.forEach(function (el) {
                observer.observe(el);
            });
        } else {
            revealEls.forEach(function (el) {
                el.classList.add('is-visible');
            });
        }

        // 5. FAQ Accordion
        document.querySelectorAll('.nh-faq-item').forEach(function (item) {
            const btn = item.querySelector('.nh-faq-btn');
            const body = item.querySelector('.nh-faq-body');
            const title = item.querySelector('.nh-faq-title');
            const downIcon = item.querySelector('.nh-faq-down');
            const upIcon = item.querySelector('.nh-faq-up');

            if (btn && body) {
                btn.addEventListener('click', function () {
                    const isOpen = !body.classList.contains('hidden');
                    if (isOpen) {
                        body.classList.add('hidden');
                        if (title) title.classList.remove('text-gold');
                        if (downIcon) downIcon.classList.remove('hidden');
                        if (upIcon) upIcon.classList.add('hidden');
                    } else {
                        body.classList.remove('hidden');
                        if (title) title.classList.add('text-gold');
                        if (downIcon) downIcon.classList.add('hidden');
                        if (upIcon) upIcon.classList.remove('hidden');
                    }
                });
            }
        });

        // 6. Article Category Filter
        const catBtns = document.querySelectorAll('.nh-cat-filter-btn');
        const articleCards = document.querySelectorAll('[data-nh-article-cat]');
        if (catBtns.length > 0) {
            catBtns.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const selected = btn.getAttribute('data-cat');
                    catBtns.forEach(function (b) {
                        b.className = 'nh-cat-filter-btn px-5 py-2.5 text-xs font-black uppercase tracking-widest rounded-sm transition-all shadow-md border bg-white/5 border-white/10 text-gray-300 hover:border-gold hover:text-gold hover:scale-105 cursor-pointer';
                    });
                    btn.className = 'nh-cat-filter-btn px-5 py-2.5 text-xs font-black uppercase tracking-widest rounded-sm transition-all shadow-md border bg-gold border-gold text-navy scale-105 cursor-pointer';

                    articleCards.forEach(function (card) {
                        const cardCat = card.getAttribute('data-nh-article-cat');
                        if (selected === 'all' || cardCat === selected) {
                            card.classList.remove('hidden');
                        } else {
                            card.classList.add('hidden');
                        }
                    });
                });
            });
        }

        // 7. Image Lightbox on Single Article
        const lightboxModal = document.getElementById('nh-lightbox-modal');
        const lightboxImg = document.getElementById('nh-lightbox-img');
        document.querySelectorAll('[data-nh-lightbox]').forEach(function (trigger) {
            trigger.addEventListener('click', function () {
                const src = trigger.getAttribute('data-nh-lightbox');
                if (lightboxModal && lightboxImg && src) {
                    lightboxImg.setAttribute('src', src);
                    lightboxModal.classList.remove('hidden');
                    lightboxModal.classList.add('flex');
                }
            });
        });
        if (lightboxModal) {
            lightboxModal.addEventListener('click', function () {
                lightboxModal.classList.add('hidden');
                lightboxModal.classList.remove('flex');
            });
        }

        // 8. Contact Form AJAX Submission
        const contactForm = document.getElementById('nh-contact-form');
        const successBox = document.getElementById('nh-contact-success');
        const errorBox = document.getElementById('nh-contact-error');
        const submitBtn = document.getElementById('nh-contact-submit');
        const submitText = document.getElementById('nh-contact-submit-text');

        if (contactForm) {
            contactForm.addEventListener('submit', async function (e) {
                e.preventDefault();
                if (errorBox) errorBox.classList.add('hidden');
                if (submitBtn) submitBtn.disabled = true;
                const origBtnText = submitText ? submitText.textContent : 'Kirim Pesan Sekarang';
                if (submitText) submitText.textContent = currentLocale === 'en' ? 'Sending...' : 'Mengirim...';

                const formData = new FormData(contactForm);
                formData.append('action', 'nh_submit_contact');
                formData.append('nonce', config.nonce || '');

                try {
                    const res = await fetch(config.ajaxUrl || '/wp-admin/admin-ajax.php', {
                        method: 'POST',
                        body: formData
                    });
                    const json = await res.json();
                    if (json && json.success) {
                        contactForm.reset();
                        contactForm.classList.add('hidden');
                        if (successBox) successBox.classList.remove('hidden');
                        setTimeout(function () {
                            if (successBox) successBox.classList.add('hidden');
                            contactForm.classList.remove('hidden');
                        }, 5000);
                    } else {
                        if (errorBox) {
                            errorBox.classList.remove('hidden');
                            errorBox.classList.add('flex');
                        }
                    }
                } catch (err) {
                    if (errorBox) {
                        errorBox.classList.remove('hidden');
                        errorBox.classList.add('flex');
                    }
                } finally {
                    if (submitBtn) submitBtn.disabled = false;
                    if (submitText) submitText.textContent = origBtnText;
                }
            });
        }
    });
})();
