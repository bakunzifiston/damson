/**
 * Extra Matomo events: form submits and non-navigation clicks (scoped to avoid spam).
 * Opt out: add class "no-matomo" on a container.
 */
function matomoPush(args) {
    if (typeof window._paq === 'undefined' || !Array.isArray(args)) {
        return;
    }
    window._paq.push(args);
}

function labelFromElement(el, maxLen = 120) {
    const explicit =
        el.getAttribute('data-matomo-label') ||
        el.getAttribute('aria-label') ||
        el.getAttribute('title');
    if (explicit) {
        return explicit.trim().slice(0, maxLen);
    }
    const text = (el.textContent || '').replace(/\s+/g, ' ').trim();
    if (text) {
        return text.slice(0, maxLen);
    }
    const tag = el.tagName.toLowerCase();
    const id = el.id ? `#${el.id}` : '';
    return `${tag}${id}`.slice(0, maxLen);
}

function samePageLink(anchor) {
    const href = anchor.getAttribute('href') || '';
    if (!href || href === '#' || href.startsWith('#')) {
        return true;
    }
    if (href.startsWith('javascript:')) {
        return true;
    }
    try {
        const u = new URL(anchor.href, window.location.origin);
        return u.origin === window.location.origin;
    } catch {
        return true;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    document.addEventListener(
        'submit',
        (e) => {
            const form = e.target;
            if (!(form instanceof HTMLFormElement)) {
                return;
            }
            if (form.closest('.no-matomo')) {
                return;
            }
            const name =
                form.getAttribute('id') ||
                form.getAttribute('name') ||
                (() => {
                    try {
                        return new URL(form.action, window.location.origin).pathname;
                    } catch {
                        return form.action || 'form';
                    }
                })();
            matomoPush(['trackEvent', 'Form', 'submit', String(name).slice(0, 120)]);
        },
        true,
    );

    document.addEventListener(
        'click',
        (e) => {
            const t = e.target.closest('a, button, [role="button"]');
            if (!t || t.closest('.no-matomo')) {
                return;
            }
            if (t.tagName === 'A') {
                const href = t.getAttribute('href') || '';
                if (href.startsWith('#') && href.length > 1) {
                    matomoPush(['trackEvent', 'Interaction', 'anchor', href.slice(0, 100)]);
                }
                if (
                    samePageLink(t) &&
                    t.target !== '_blank' &&
                    !e.metaKey &&
                    !e.ctrlKey &&
                    !e.shiftKey &&
                    t.getAttribute('download') === null
                ) {
                    return;
                }
                matomoPush(['trackEvent', 'Interaction', 'link', labelFromElement(t)]);
                return;
            }
            if (t.tagName === 'BUTTON' || t.getAttribute('role') === 'button') {
                const form = t.closest('form');
                const isSubmit =
                    t.tagName === 'BUTTON' &&
                    (t.type === 'submit' || t.type === '' || t.type === null);
                if (form && isSubmit) {
                    return;
                }
                if (t.type === 'submit' && form) {
                    return;
                }
                matomoPush(['trackEvent', 'Interaction', 'click', labelFromElement(t)]);
            }
        },
        true,
    );
});
