// header scroll state
const hdr = document.getElementById('hdr');
const onScroll = () => hdr?.classList.toggle('scrolled', window.scrollY > 40);
onScroll();
window.addEventListener('scroll', onScroll, { passive: true });

// mobile menu
const burger = document.getElementById('burger');
burger?.addEventListener('click', () => document.body.classList.toggle('menu-open'));
document.querySelectorAll('#nav a').forEach((a) => a.addEventListener('click', () => document.body.classList.remove('menu-open')));

// year
const year = document.getElementById('yr');
if (year) year.textContent = new Date().getFullYear();

// reveal observer
const io = new IntersectionObserver((es) => {
  es.forEach((e) => {
    if (e.isIntersecting) {
      e.target.classList.add('in');
      io.unobserve(e.target);
    }
  });
}, { threshold: 0.16, rootMargin: '0px 0px -8% 0px' });
document.querySelectorAll('.reveal').forEach((el) => io.observe(el));

const escapeHtml = (value) => String(value ?? '')
  .replaceAll('&', '&amp;')
  .replaceAll('<', '&lt;')
  .replaceAll('>', '&gt;')
  .replaceAll('"', '&quot;')
  .replaceAll("'", '&#039;');

const praiseData = document.getElementById('about-praise-data');
const praise = praiseData ? JSON.parse(praiseData.textContent || '[]') : [];
const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const stream = document.getElementById('stream');

if (stream && praise.length) {
  const colDefs = [
    { cls: 'up c1', dur: '56s', items: praise.filter((_, index) => index % 3 === 0) },
    { cls: 'down c2', dur: '66s', items: praise.filter((_, index) => index % 3 === 1) },
    { cls: 'up c3', dur: '60s', items: praise.filter((_, index) => index % 3 === 2) },
  ];

  colDefs.forEach((def) => {
    const col = document.createElement('div');
    col.className = `col ${def.cls}`;
    const track = document.createElement('div');
    track.className = 'col-track';
    track.style.setProperty('--dur', def.dur);

    const build = () => def.items.forEach((c) => {
      const card = document.createElement('div');
      card.className = `quote-card${c.q ? '' : ' namesonly'}`;
      card.innerHTML = (c.q ? `<p>&ldquo;${escapeHtml(c.q)}&rdquo;</p>` : '')
        + '<div class="who">'
        + `<span class="cat">${escapeHtml(c.cat)}</span>`
        + `<b>${escapeHtml(c.name)}</b>`
        + `<span class="role">${escapeHtml(c.title)}</span>`
        + '</div>';
      track.appendChild(card);
    });

    build();
    if (! reduce) build();
    col.appendChild(track);
    stream.appendChild(col);
  });
}

// voice quote rotation
(() => {
  const stage = document.getElementById('voiceStage');
  if (! stage) return;

  const qs = [...stage.querySelectorAll('.voice-q')];
  const dotsWrap = document.getElementById('voiceDots');
  if (! qs.length || ! dotsWrap) return;

  let i = 0;
  let timer = null;
  qs.forEach((_, idx) => {
    const b = document.createElement('button');
    if (idx === 0) b.classList.add('on');
    b.setAttribute('aria-label', `Quote ${idx + 1}`);
    b.addEventListener('click', () => go(idx, true));
    dotsWrap.appendChild(b);
  });

  const dots = [...dotsWrap.children];
  function show(n) {
    qs.forEach((q, k) => q.classList.toggle('on', k === n));
    dots.forEach((d, k) => d.classList.toggle('on', k === n));
    i = n;
  }
  function go(n, manual) {
    show(n);
    if (manual) reset();
  }
  function next() {
    show((i + 1) % qs.length);
  }
  function reset() {
    clearInterval(timer);
    timer = setInterval(next, 5400);
  }
  if (! reduce) reset();
})();
