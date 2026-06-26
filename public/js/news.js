const track = document.getElementById("track");
if (track && track.children.length > 0) {
  track.innerHTML += track.innerHTML;
}

const hdr = document.getElementById("hdr");
const onScroll = () => hdr && hdr.classList.toggle("scrolled", window.scrollY > 40);
onScroll();
window.addEventListener("scroll", onScroll, { passive: true });

const burger = document.getElementById("burger");
if (burger) {
  burger.addEventListener("click", () => document.body.classList.toggle("menu-open"));
}
document.querySelectorAll("#nav a").forEach((a) => a.addEventListener("click", () => document.body.classList.remove("menu-open")));

requestAnimationFrame(() => setTimeout(() => {
  document.getElementById("h1")?.classList.add("in");
  document.getElementById("sub")?.classList.add("in");
  document.getElementById("hint")?.classList.add("in");
  document.querySelectorAll(".reel-track .ncard").forEach((card, index) => {
    setTimeout(() => card.classList.add("in"), 200 + index * 90);
  });
}, 120));

const revealObserver = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (! entry.isIntersecting) {
      return;
    }

    entry.target.classList.add("in");
    revealObserver.unobserve(entry.target);
  });
}, { threshold: 0.14, rootMargin: "0px 0px -6% 0px" });
document.querySelectorAll(".reveal").forEach((el) => revealObserver.observe(el));

const rows = [...document.querySelectorAll(".row")];
const rowObserver = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (! entry.isIntersecting) {
      return;
    }

    const index = rows.indexOf(entry.target);
    setTimeout(() => entry.target.classList.add("in"), Math.max(index, 0) * 70);
    rowObserver.unobserve(entry.target);
  });
}, { threshold: 0.2 });
setTimeout(() => rows.forEach((row) => rowObserver.observe(row)), 60);

const year = document.getElementById("yr");
if (year) {
  year.textContent = new Date().getFullYear();
}
