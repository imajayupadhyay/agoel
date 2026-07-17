var year = document.getElementById("yr");
if(year) year.textContent = new Date().getFullYear();
var reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

var burger = document.getElementById("burger");
if(burger){
  burger.addEventListener("click", function(){
    var open = document.body.classList.toggle("menu-open");
    burger.setAttribute("aria-expanded", open ? "true" : "false");
  });
  document.querySelectorAll("#nav a").forEach(function(a){
    a.addEventListener("click", function(){
      document.body.classList.remove("menu-open");
      burger.setAttribute("aria-expanded", "false");
    });
  });
}

var io = new IntersectionObserver(function(es){
  es.forEach(function(e){
    if(e.isIntersecting){
      e.target.classList.add("in");
      io.unobserve(e.target);
    }
  });
},{threshold:.14, rootMargin:"0px 0px -8% 0px"});
document.querySelectorAll(".rev,.eyebrow").forEach(function(el){ reduce ? el.classList.add("in") : io.observe(el); });

var plates = [].slice.call(document.querySelectorAll("[data-para]"));
var ticking = false;
function frame(){
  var vh = innerHeight;
  plates.forEach(function(p){
    var r = p.getBoundingClientRect();
    if(r.bottom < -240 || r.top > vh + 240) return;
    var mid = (r.top + r.height / 2 - vh / 2) / vh;
    var img = p.querySelector("img");
    if(img) img.style.setProperty("--py", (mid * 34 * -1).toFixed(1) + "px");
  });
  ticking = false;
}
addEventListener("scroll", function(){ if(!ticking && !reduce){ ticking = true; requestAnimationFrame(frame); } }, {passive:true});
addEventListener("resize", function(){ if(!reduce) frame(); });
if(!reduce) frame();
