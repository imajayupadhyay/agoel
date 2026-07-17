var year = document.getElementById('yr');
if(year) year.textContent = new Date().getFullYear();
var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

/* mobile menu */
var burger = document.getElementById('burger');
if(burger){
  burger.addEventListener('click', function(){
    var open = document.body.classList.toggle('menu-open');
    burger.setAttribute('aria-expanded', open ? 'true':'false');
  });
  document.querySelectorAll('#nav a').forEach(function(a){
    a.addEventListener('click', function(){
      document.body.classList.remove('menu-open');
      burger.setAttribute('aria-expanded','false');
    });
  });
}

/* reveal on scroll */
var io = new IntersectionObserver(function(es){
  es.forEach(function(e){ if(e.isIntersecting){ e.target.classList.add('in'); io.unobserve(e.target);} });
},{threshold:.12, rootMargin:'0px 0px -8% 0px'});
document.querySelectorAll('.rev').forEach(function(el){ reduce ? el.classList.add('in') : io.observe(el); });
