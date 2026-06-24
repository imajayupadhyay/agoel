// header scroll state
  const hdr=document.getElementById('hdr');
  const onScroll=()=>hdr.classList.toggle('scrolled',window.scrollY>40);
  onScroll();window.addEventListener('scroll',onScroll,{passive:true});

  // mobile menu
  const burger=document.getElementById('burger');
  burger.addEventListener('click',()=>document.body.classList.toggle('menu-open'));
  document.querySelectorAll('#nav a').forEach(a=>a.addEventListener('click',()=>document.body.classList.remove('menu-open')));

  // hero name reveal on load
  requestAnimationFrame(()=>setTimeout(()=>document.getElementById('heroName').classList.add('in'),120));

  // reveal observer
  const io=new IntersectionObserver((es)=>{
    es.forEach(e=>{if(e.isIntersecting){e.target.classList.add('in');io.unobserve(e.target);}});
  },{threshold:.18,rootMargin:'0px 0px -8% 0px'});
  document.querySelectorAll('.reveal,#meetVisual,#meetCopy').forEach(el=>io.observe(el));

  // year
  document.getElementById('yr').textContent=new Date().getFullYear();

  // newsletter (front-end only)
  const nlBtn=document.getElementById('nlBtn'),nl=document.getElementById('nl'),nlOk=document.getElementById('nlOk');
  nlBtn.addEventListener('click',()=>{
    const v=nl.value.trim();
    if(/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(v)){nlOk.textContent='Thank you — you are on the list.';nl.value='';}
    else{nlOk.textContent='Please enter a valid email address.';}
  });

  // gentle parallax on Meet Anmol layers
  const reduce=window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if(!reduce){
    const layers=[...document.querySelectorAll('.meet-visual img[data-par]')];
    let ticking=false;
    window.addEventListener('scroll',()=>{
      if(ticking)return;ticking=true;
      requestAnimationFrame(()=>{
        const v=document.getElementById('meetVisual');
        if(v){const r=v.getBoundingClientRect();const c=(r.top+r.height/2-window.innerHeight/2)/window.innerHeight;
          layers.forEach(l=>{const p=parseFloat(l.dataset.par);l.style.transform='translateY('+(c*p*100)+'px) scale(1.06)';});}
        ticking=false;
      });
    },{passive:true});
  }

  // voice quote rotation
  (function(){
    const stage=document.getElementById('voiceStage');
    if(!stage)return;
    const qs=[...stage.querySelectorAll('.voice-q')];
    const dotsWrap=document.getElementById('voiceDots');
    let i=0,timer=null;
    qs.forEach((_,idx)=>{const b=document.createElement('button');if(idx===0)b.classList.add('on');
      b.setAttribute('aria-label','Quote '+(idx+1));b.addEventListener('click',()=>go(idx,true));dotsWrap.appendChild(b);});
    const dots=[...dotsWrap.children];
    function show(n){qs.forEach((q,k)=>q.classList.toggle('on',k===n));dots.forEach((d,k)=>d.classList.toggle('on',k===n));i=n;}
    function go(n,manual){show(n);if(manual)reset();}
    function next(){show((i+1)%qs.length);}
    function reset(){clearInterval(timer);timer=setInterval(next,5200);}
    const reduceM=window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if(!reduceM)reset();
  })();
