const sidebarToggle = document.querySelector('[data-sidebar-toggle]');
const sidebarClosers = document.querySelectorAll('[data-sidebar-close]');

const setSidebar = (isOpen) => {
    document.body.classList.toggle('sidebar-open', isOpen);
    sidebarToggle?.setAttribute('aria-expanded', String(isOpen));
};

sidebarToggle?.addEventListener('click', () => {
    setSidebar(!document.body.classList.contains('sidebar-open'));
});

sidebarClosers.forEach((closer) => {
    closer.addEventListener('click', () => setSidebar(false));
});

window.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        setSidebar(false);
    }
});

window.addEventListener('resize', () => {
    if (window.innerWidth > 900) {
        setSidebar(false);
    }
});
