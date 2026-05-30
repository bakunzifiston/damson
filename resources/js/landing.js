function animateCounter(el) {
    const target = Number(el.dataset.count);
    if (!Number.isFinite(target)) {
        return;
    }
    const suffix = el.dataset.suffix || '';
    const duration = 1600;
    const start = performance.now();

    function frame(now) {
        const progress = Math.min((now - start) / duration, 1);
        const eased = 1 - (1 - progress) ** 3;
        const value = Math.floor(target * eased);
        el.textContent = value.toLocaleString() + suffix;
        if (progress < 1) {
            requestAnimationFrame(frame);
        }
    }

    requestAnimationFrame(frame);
}

function initReveal() {
    const nodes = document.querySelectorAll('[data-reveal]');
    if (!nodes.length) {
        return;
    }
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        },
        { threshold: 0.12, rootMargin: '0px 0px -48px 0px' },
    );
    nodes.forEach((node) => observer.observe(node));
}

function initCounters() {
    const nodes = document.querySelectorAll('[data-count]');
    if (!nodes.length) {
        return;
    }
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting || entry.target.dataset.counted === '1') {
                    return;
                }
                entry.target.dataset.counted = '1';
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            });
        },
        { threshold: 0.35 },
    );
    nodes.forEach((node) => observer.observe(node));
}

function initTestimonialCarousel() {
    const root = document.getElementById('testimonial-carousel');
    if (!root) {
        return;
    }
    const track = root.querySelector('[data-carousel-track]');
    const slides = root.querySelectorAll('[data-carousel-slide]');
    const prev = root.querySelector('[data-carousel-prev]');
    const next = root.querySelector('[data-carousel-next]');
    const dotsHost = root.querySelector('[data-carousel-dots]');
    if (!track || !slides.length) {
        return;
    }

    let index = 0;
    let timer;

    function renderDots() {
        if (!dotsHost) {
            return;
        }
        dotsHost.innerHTML = '';
        slides.forEach((_, i) => {
            const dot = document.createElement('button');
            dot.type = 'button';
            dot.className = 'testimonial-dot' + (i === index ? ' is-active' : '');
            dot.setAttribute('aria-label', `Go to testimonial ${i + 1}`);
            dot.addEventListener('click', () => goTo(i));
            dotsHost.appendChild(dot);
        });
    }

    function goTo(i) {
        index = (i + slides.length) % slides.length;
        track.style.transform = `translateX(-${index * 100}%)`;
        renderDots();
        resetTimer();
    }

    function resetTimer() {
        clearInterval(timer);
        timer = setInterval(() => goTo(index + 1), 7000);
    }

    prev?.addEventListener('click', () => goTo(index - 1));
    next?.addEventListener('click', () => goTo(index + 1));
    root.addEventListener('mouseenter', () => clearInterval(timer));
    root.addEventListener('mouseleave', resetTimer);

    renderDots();
    resetTimer();
}

function initHeroSlider() {
    const root = document.getElementById('hero-slider');
    if (!root) {
        return;
    }
    const slides = root.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('[data-hero-go]');
    if (!slides.length) {
        return;
    }

    let index = 0;
    let timer;

    function goTo(i) {
        index = (i + slides.length) % slides.length;
        slides.forEach((slide, idx) => {
            slide.classList.toggle('is-active', idx === index);
        });
        dots.forEach((dot, idx) => {
            const active = idx === index;
            dot.classList.toggle('is-active', active);
            dot.setAttribute('aria-selected', active ? 'true' : 'false');
        });
    }

    function resetTimer() {
        clearInterval(timer);
        if (slides.length > 1) {
            timer = setInterval(() => goTo(index + 1), 5500);
        }
    }

    dots.forEach((dot) => {
        dot.addEventListener('click', () => {
            goTo(Number(dot.getAttribute('data-hero-go')));
            resetTimer();
        });
    });

    root.closest('section')?.addEventListener('mouseenter', () => clearInterval(timer));
    root.closest('section')?.addEventListener('mouseleave', resetTimer);

    resetTimer();
}

function initNewsletter() {
    const form = document.getElementById('newsletter-form');
    const note = document.getElementById('newsletter-note');
    if (!form || !note) {
        return;
    }
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        note.textContent = 'Thank you for subscribing. We will be in touch soon.';
        note.classList.remove('hidden');
        form.reset();
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initNewsletter();
    initReveal();

    if (document.querySelector('[data-count]')) {
        initCounters();
    }

    if (document.querySelector('.landing-page')) {
        initHeroSlider();
        initTestimonialCarousel();
    }

    initStoryFilters();
});

function initStoryFilters() {
    const root = document.getElementById('story-filters');
    if (!root) {
        return;
    }
    const buttons = root.querySelectorAll('[data-story-filter]');
    const cards = document.querySelectorAll('[data-story-category]');
    buttons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const filter = btn.getAttribute('data-story-filter');
            buttons.forEach((b) => b.classList.toggle('is-active', b === btn));
            cards.forEach((card) => {
                const cat = card.getAttribute('data-story-category');
                const show = filter === 'all' || cat === filter;
                card.classList.toggle('hidden', !show);
            });
        });
    });
}
