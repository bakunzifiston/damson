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
