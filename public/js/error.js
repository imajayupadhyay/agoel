const hdr = document.getElementById('hdr');
const onScroll = () => hdr?.classList.toggle('scrolled', window.scrollY > 40);
onScroll();
window.addEventListener('scroll', onScroll, { passive: true });

const burger = document.getElementById('burger');
burger?.addEventListener('click', () => document.body.classList.toggle('menu-open'));
document.querySelectorAll('#nav a').forEach((link) => {
    link.addEventListener('click', () => document.body.classList.remove('menu-open'));
});
