const hdr = document.getElementById('hdr');
const onScroll = () => hdr?.classList.toggle('scrolled', window.scrollY > 40);
onScroll();
window.addEventListener('scroll', onScroll, { passive: true });

const burger = document.getElementById('burger');
burger?.addEventListener('click', () => document.body.classList.toggle('menu-open'));
document.querySelectorAll('#nav a').forEach((link) => {
    link.addEventListener('click', () => document.body.classList.remove('menu-open'));
});

requestAnimationFrame(() => {
    setTimeout(() => document.getElementById('heroTitle')?.classList.add('in'), 120);
});

const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.classList.add('in');
            revealObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.16, rootMargin: '0px 0px -8% 0px' });

document.querySelectorAll('.reveal').forEach((element) => revealObserver.observe(element));

const tiles = [...document.querySelectorAll('.tile')];
const tileObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            const index = tiles.indexOf(entry.target);
            setTimeout(() => entry.target.classList.add('in'), (index % 4) * 90);
            tileObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.2 });

tiles.forEach((tile) => tileObserver.observe(tile));
