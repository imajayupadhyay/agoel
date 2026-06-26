/* ===== dynamic data ===== */
const researchData = window.RESEARCH_PAGE_DATA || {};
const PUBS = (researchData.publications || []).map((publication) => ({
  cat: publication.cat || "",
  catLabel: publication.catLabel || publication.cat || "",
  title: publication.title || "",
  venue: publication.venue || "",
  year: publication.year || "",
  status: publication.status || "",
  snip: publication.snip || "",
  tags: Array.isArray(publication.tags) ? publication.tags : [],
  link: publication.link || "",
}));
const FIELDS = researchData.fields || [];
const CATS = [
  ["All", "all"],
  ...(researchData.categories || []).map((category) => [category.label || category.slug, category.slug]),
];

const esc = (value) => String(value || "")
  .replace(/&/g, "&amp;")
  .replace(/</g, "&lt;")
  .replace(/>/g, "&gt;");
const escAttr = (value) => esc(value).replace(/"/g, "&quot;");

/* ===== filters + list ===== */
const filtersEl = document.getElementById("filters");
const publist = document.getElementById("publist");
let active = "all";

if (filtersEl && publist) {
  filtersEl.innerHTML = CATS.map(([label, key]) => {
    const n = key === "all" ? PUBS.length : PUBS.filter((p) => p.cat === key).length;
    return `<button data-k="${escAttr(key)}" class="${key === "all" ? "on" : ""}">${esc(label)}<span class="n">${n}</span></button>`;
  }).join("");

  function render() {
    const list = active === "all" ? PUBS : PUBS.filter((p) => p.cat === active);
    publist.innerHTML = list.map((p, i) => `
      <article class="pub">
        <div class="idx">${String(i + 1).padStart(2, "0")}</div>
        <div class="main">
          <span class="cat-tag">${esc(p.catLabel)}</span>
          <h3>${esc(p.title)}</h3>
          <div class="venue">${esc(p.venue)}</div>
          <p class="snip">${esc(p.snip)}</p>
          <div class="tags">${p.tags.map((t) => `<i>${esc(t)}</i>`).join("")}</div>
        </div>
        <div class="right">
          <span class="yr">${esc(p.year)}</span>
          ${p.link ? `<a class="lk" href="${escAttr(p.link)}">Open <span class="ar">&rarr;</span></a>` : `<span class="status">${esc(p.status)}</span>`}
        </div>
      </article>`).join("");
    [...publist.children].forEach((el, i) => setTimeout(() => el.classList.add("show"), 50 + i * 50));
  }

  filtersEl.addEventListener("click", (event) => {
    const button = event.target.closest("button");
    if (!button) return;
    active = button.dataset.k;
    [...filtersEl.children].forEach((item) => item.classList.toggle("on", item === button));
    render();
  });

  let rendered = false;
  const pIO = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting && !rendered) {
        rendered = true;
        render();
        pIO.disconnect();
      }
    });
  }, { threshold: 0.02 });
  pIO.observe(publist);
}

/* ===== fields ===== */
const flist = document.getElementById("flist");
if (flist) {
  flist.innerHTML = FIELDS.map((field, i) => `
    <article class="field${i % 2 ? " rev" : ""}">
      <div class="fig reveal">
        <span class="scn"></span>
        <span class="cap">${esc(field.cap || `fig.0${i + 3}`)}</span>
        ${field.img ? `<img loading="lazy" decoding="async" src="${escAttr(field.img)}" alt="${escAttr(field.alt || field.who)}">` : ""}
      </div>
      <div class="fcopy">
        <div class="num reveal">FIELD · ${String(i + 1).padStart(2, "0")}</div>
        <h3 class="reveal" data-d="1">${esc(field.name)}</h3>
        <div class="who reveal" data-d="1">${esc(field.who)}</div>
        <p class="reveal" data-d="2">${esc(field.ln)}</p>
      </div>
    </article>`).join("");
}

/* ===== sine wave path ===== */
(function () {
  const wavePath = document.getElementById("wavePath");
  if (!wavePath) return;
  const amp = 11;
  const mid = 20;
  const w = 2880;
  const step = 6;
  let d = `M0 ${mid}`;
  for (let x = 0; x <= w; x += step) {
    d += ` L${x} ${(mid + amp * Math.sin((2 * Math.PI * x) / 240)).toFixed(1)}`;
  }
  wavePath.setAttribute("d", d);
})();

/* ===== terminal typewriter ===== */
(function () {
  const el = document.getElementById("termtxt");
  if (!el) return;
  const lines = (researchData.terminalLines || []).length
    ? researchData.terminalLines
    : ["> reading markets...", "> reading machines...", "> reading institutions...", "> reading people..."];
  let li = 0;
  let ci = 0;
  let del = false;
  function tick() {
    const text = lines[li] || "";
    el.textContent = text.slice(0, ci);
    if (!del) {
      ci++;
      if (ci > text.length) {
        del = true;
        return setTimeout(tick, 1400);
      }
    } else {
      ci--;
      if (ci < 2) {
        del = false;
        li = (li + 1) % lines.length;
      }
    }
    setTimeout(tick, del ? 34 : 62);
  }
  tick();
})();

/* ===== particle network (mouse-reactive) ===== */
(function () {
  const cv = document.getElementById("net");
  if (!cv) return;
  const ctx = cv.getContext("2d");
  let W;
  let H;
  const DPR = Math.min(window.devicePixelRatio || 1, 2);
  let P = [];
  let raf;
  let mx = -1e4;
  let my = -1e4;
  function size() {
    W = cv.width = cv.offsetWidth * DPR;
    H = cv.height = cv.offsetHeight * DPR;
  }
  function init() {
    const n = Math.min(90, Math.round((cv.offsetWidth * cv.offsetHeight) / 15000));
    P = [];
    for (let i = 0; i < n; i++) {
      P.push({
        x: Math.random() * W,
        y: Math.random() * H,
        vx: (Math.random() - 0.5) * 0.2 * DPR,
        vy: (Math.random() - 0.5) * 0.2 * DPR,
      });
    }
  }
  const D = 128 * DPR;
  const DM = 160 * DPR;
  function frame() {
    ctx.clearRect(0, 0, W, H);
    for (const p of P) {
      p.x += p.vx;
      p.y += p.vy;
      if (p.x < 0 || p.x > W) p.vx *= -1;
      if (p.y < 0 || p.y > H) p.vy *= -1;
    }
    for (let i = 0; i < P.length; i++) {
      for (let j = i + 1; j < P.length; j++) {
        const dx = P[i].x - P[j].x;
        const dy = P[i].y - P[j].y;
        const d = Math.hypot(dx, dy);
        if (d < D) {
          ctx.strokeStyle = `rgba(169,143,91,${0.15 * (1 - d / D)})`;
          ctx.lineWidth = DPR;
          ctx.beginPath();
          ctx.moveTo(P[i].x, P[i].y);
          ctx.lineTo(P[j].x, P[j].y);
          ctx.stroke();
        }
      }
      const ddx = P[i].x - mx;
      const ddy = P[i].y - my;
      const dm = Math.hypot(ddx, ddy);
      if (dm < DM) {
        ctx.strokeStyle = `rgba(199,181,137,${0.4 * (1 - dm / DM)})`;
        ctx.lineWidth = DPR;
        ctx.beginPath();
        ctx.moveTo(P[i].x, P[i].y);
        ctx.lineTo(mx, my);
        ctx.stroke();
      }
    }
    for (const p of P) {
      ctx.fillStyle = "rgba(199,181,137,.55)";
      ctx.beginPath();
      ctx.arc(p.x, p.y, 1.5 * DPR, 0, 7);
      ctx.fill();
    }
    raf = requestAnimationFrame(frame);
  }
  function start() {
    size();
    init();
    cancelAnimationFrame(raf);
    frame();
  }
  start();
  cv.addEventListener("mousemove", (event) => {
    const rect = cv.getBoundingClientRect();
    mx = (event.clientX - rect.left) * DPR;
    my = (event.clientY - rect.top) * DPR;
  });
  cv.addEventListener("mouseleave", () => {
    mx = my = -1e4;
  });
  let to;
  window.addEventListener("resize", () => {
    clearTimeout(to);
    to = setTimeout(start, 200);
  });
})();

/* ===== header + menu ===== */
const hdr = document.getElementById("hdr");
if (hdr) {
  const onScroll = () => hdr.classList.toggle("scrolled", window.scrollY > 40);
  onScroll();
  window.addEventListener("scroll", onScroll, { passive: true });
}
const burger = document.getElementById("burger");
if (burger) {
  burger.addEventListener("click", () => document.body.classList.toggle("menu-open"));
}
document.querySelectorAll("#nav a").forEach((a) => a.addEventListener("click", () => document.body.classList.remove("menu-open")));

/* ===== reveals + counters ===== */
const h1 = document.getElementById("h1");
if (h1) {
  requestAnimationFrame(() => setTimeout(() => h1.classList.add("in"), 140));
}
const io = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      entry.target.classList.add("in");
      io.unobserve(entry.target);
    }
  });
}, { threshold: 0.14, rootMargin: "0px 0px -7% 0px" });
document.querySelectorAll(".reveal").forEach((el) => io.observe(el));
function cup(el) {
  const to = +el.dataset.to;
  const t0 = performance.now();
  (function t(n) {
    let p = Math.min((n - t0) / 1300, 1);
    p = 1 - Math.pow(1 - p, 3);
    el.textContent = Math.round(to * p);
    if (p < 1) requestAnimationFrame(t);
  }(t0));
}
const cIO = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      cup(entry.target);
      cIO.unobserve(entry.target);
    }
  });
}, { threshold: 0.5 });
document.querySelectorAll(".count").forEach((el) => cIO.observe(el));

const year = document.getElementById("yr");
if (year) {
  year.textContent = new Date().getFullYear();
}
