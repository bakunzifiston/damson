// Small accessible UI behaviours: dashboard drawer and site mobile menu.

function toggleable({ openSel, closeSel, panelId, bp, lock = false }) {
    const panel = document.getElementById(panelId);
    if (!panel) return;
    const openers = document.querySelectorAll(openSel);
    let lastFocus = null;

    const setOpen = (open) => {
        panel.classList.toggle('hidden', !open);
        openers.forEach((b) => b.setAttribute('aria-expanded', String(open)));
        if (lock) document.documentElement.classList.toggle('overflow-hidden', open);
        if (open) {
            lastFocus = document.activeElement;
            panel.querySelector('a, button')?.focus();
        } else if (lastFocus) {
            lastFocus.focus();
        }
    };

    openers.forEach((b) => b.addEventListener('click', () => setOpen(panel.classList.contains('hidden'))));
    document.querySelectorAll(closeSel).forEach((b) => b.addEventListener('click', () => setOpen(false)));
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !panel.classList.contains('hidden')) setOpen(false);
    });
    window.matchMedia(`(min-width: ${bp}px)`).addEventListener('change', (m) => m.matches && setOpen(false));
}

toggleable({ openSel: '[data-drawer-open]', closeSel: '[data-drawer-close]', panelId: 'dashboard-drawer', bp: 768, lock: true });
toggleable({ openSel: '[data-menu-toggle]', closeSel: '[data-menu-close]', panelId: 'site-menu', bp: 1024 });

// Category tabs: filter cards in place (the tabs are real links, so this is progressive enhancement).
document.querySelectorAll('[data-category-tabs]').forEach((tabs) => {
    const list = tabs.parentElement.parentElement.querySelector('[data-category-list]');
    if (!list) return;
    const ON = ['border-brand-900', 'bg-brand-900', 'text-white'];
    const OFF = ['border-stone-300', 'bg-white', 'text-stone-700', 'hover:border-brand-900'];

    tabs.querySelectorAll('[data-tab-value]').forEach((tab) => {
        tab.addEventListener('click', (e) => {
            e.preventDefault();
            const value = tab.dataset.tabValue;
            tabs.querySelectorAll('[data-tab-value]').forEach((t) => {
                const on = t === tab;
                t.classList.remove(...(on ? OFF : ON));
                t.classList.add(...(on ? ON : OFF));
                t.querySelector('[data-tab-count]')?.classList.toggle('text-white/70', on);
                t.querySelector('[data-tab-count]')?.classList.toggle('text-stone-400', !on);
                on ? t.setAttribute('aria-current', 'true') : t.removeAttribute('aria-current');
            });
            list.querySelectorAll('[data-category]').forEach((li) => {
                li.hidden = value !== '' && li.dataset.category !== value;
            });
        });
    });
});
