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

/* parallax inside frames */
var plates = [].slice.call(document.querySelectorAll('[data-parallax]')), ticking=false;
function frame(){
  var vh = innerHeight;
  plates.forEach(function(p){
    var r = p.getBoundingClientRect();
    if(r.bottom < -200 || r.top > vh+200) return;
    var mid = (r.top + r.height/2 - vh/2)/vh;
    var img = p.querySelector('img');
    if(img) img.style.setProperty('--py',(mid*r.height*parseFloat(p.dataset.parallax)*-1).toFixed(2)+'px');
  });
  ticking=false;
}
addEventListener('scroll', function(){ if(!ticking && !reduce){ ticking=true; requestAnimationFrame(frame);} }, {passive:true});
addEventListener('resize', function(){ if(!reduce) frame(); });
if(!reduce) frame();

/* ---- rotating quotes ---- */
(function(){
  var stage = document.getElementById('quoteStage');
  var dotWrap = document.getElementById('qdots');
  if(!stage) return;
  var slides = [].slice.call(stage.querySelectorAll('.qslide'));
  if(!slides.length) return;
  var i = 0, timer, DELAY = 5200, paused = false;
  slides.forEach(function(s, idx){
    if(!dotWrap) return;
    var b = document.createElement('button');
    b.setAttribute('role','tab');
    b.setAttribute('aria-label','Quote '+(idx+1));
    if(idx===0) b.classList.add('on');
    b.addEventListener('click', function(){ show(idx); restart(); });
    dotWrap.appendChild(b);
  });
  var dots = dotWrap ? [].slice.call(dotWrap.children) : [];
  function show(n){
    slides[i].classList.remove('is-active');
    if(dots[i]) dots[i].classList.remove('on');
    i = (n + slides.length) % slides.length;
    slides[i].classList.add('is-active');
    if(dots[i]) dots[i].classList.add('on');
  }
  function tick(){ if(!paused) show(i+1); }
  function start(){ if(!reduce) timer = setInterval(tick, DELAY); }
  function restart(){ clearInterval(timer); start(); }
  stage.addEventListener('mouseenter', function(){ paused=true; });
  stage.addEventListener('mouseleave', function(){ paused=false; });
  start();
})();

/* ---- press carousel: continuous drift + drag + arrows ---- */
(function(){
  var track = document.getElementById('track');
  var viewport = document.getElementById('viewport');
  if(!track || !viewport) return;
  var originals = [].slice.call(track.children);
  if(!originals.length) return;
  originals.forEach(function(n){ track.appendChild(n.cloneNode(true)); });

  var pos = 0, setW = 0, speed = 0.35, paused = false;
  function measure(){
    setW = 0; var gap = parseFloat(getComputedStyle(track).gap) || 22;
    originals.forEach(function(n){ setW += n.getBoundingClientRect().width + gap; });
  }
  measure(); addEventListener('resize', function(){ var f=pos/(setW||1); measure(); pos=f*setW; });

  function wrap(){ if(setW){ while(pos<=-setW) pos+=setW; while(pos>0) pos-=setW; } }
  function loop(){
    if(!paused && !dragging && !reduce){ pos -= speed; wrap(); track.style.transform='translateX('+pos+'px)'; }
    requestAnimationFrame(loop);
  }
  requestAnimationFrame(loop);

  viewport.addEventListener('mouseenter', function(){ paused=true; });
  viewport.addEventListener('mouseleave', function(){ paused=false; });

  var dragging=false, startX=0, startPos=0, moved=0;
  function down(x){ dragging=true; startX=x; startPos=pos; moved=0; track.classList.add('grabbing'); }
  function move(x){ if(!dragging) return; moved=x-startX; pos=startPos+moved; wrap(); track.style.transform='translateX('+pos+'px)'; }
  function up(){ dragging=false; track.classList.remove('grabbing'); }

  viewport.addEventListener('pointerdown', function(e){ down(e.clientX); });
  addEventListener('pointermove', function(e){ if(dragging){ e.preventDefault(); move(e.clientX);} }, {passive:false});
  addEventListener('pointerup', up);
  addEventListener('pointercancel', up);
  track.querySelectorAll('a').forEach(function(a){ a.addEventListener('click', function(e){ if(Math.abs(moved)>6) e.preventDefault(); }); });

  function step(dir){ if(!originals[0]) return; var card = originals[0].getBoundingClientRect().width + (parseFloat(getComputedStyle(track).gap)||22); pos += dir*card; wrap(); track.style.transition='transform .5s cubic-bezier(.2,.7,.2,1)'; track.style.transform='translateX('+pos+'px)'; setTimeout(function(){ track.style.transition=''; },520); }
  var prev=document.getElementById('prev'), next=document.getElementById('next');
  if(prev) prev.addEventListener('click', function(){ step(1); });
  if(next) next.addEventListener('click', function(){ step(-1); });
})();

/* ---- forms ---- */
(function(){
  var ok = function(v){ return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v); };

  var newsField = document.getElementById('newsField');
  if(newsField) newsField.addEventListener('submit', function(e){
    e.preventDefault();

    var input = document.getElementById('nlMail'),
        note = document.getElementById('nlNote'),
        button = document.getElementById('nlSend'),
        invalid = newsField.getAttribute('data-invalid') || 'Please enter a valid email address.',
        success = newsField.getAttribute('data-success') || 'Thank you. You are subscribed.';

    if(!ok(input.value.trim())){ note.textContent = invalid; return; }

    button.disabled = true;
    fetch(newsField.action, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': newsField.querySelector('input[name="_token"]').value
      },
      body: new FormData(newsField)
    }).then(function(response){
      if(!response.ok) throw response;
      return response.json();
    }).then(function(data){
      newsField.style.display = 'none';
      note.textContent = data.message || success;
    }).catch(function(){
      note.textContent = invalid;
      button.disabled = false;
    });
  });
})();
