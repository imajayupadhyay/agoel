/* ===== data (living scaffold) ===== */
  const PUBS=[
    {cat:"Article",title:"We Are Not Behind in the AI Race",venue:"Financial Express",year:2026,status:"Published",
     snip:"India is not losing the AI race; it is running a different one. Success is measured by deployment across governance, health and education — not the count of frontier models.",tags:["AI policy","India","deployment"]},
    {cat:"Article",title:"Rule-Maker, Not Rule-Taker",venue:"Op-ed",year:2025,status:"Published",
     snip:"Why India must help write the global rules of AI rather than inherit them — and what an aggressive, accountable industry posture looks like in practice.",tags:["regulation","sovereignty"]},
    {cat:"Article",title:"Reading a Billion Consumers",venue:"Essay / Trade press",year:2025,status:"Published",
     snip:"India is not one market. Behaviour fractures across language, income and digital-access tiers — and most strategy fails because it averages them away.",tags:["consumer behaviour","markets"]},
    {cat:"Essay",title:"A Real Book Should Hurt",venue:"On reading",year:2025,status:"Essay",
     snip:"A manifesto against comfortable reading: read less, read slower, read what makes you sick — and let a book break the dumbest thing you believe.",tags:["reading","epistemics"],link:"/books#top"},
    {cat:"Essay",title:"Achieved Worth over Inherited Worth",venue:"On education & dignity",year:2025,status:"Essay",
     snip:"The most valuable thing a person can own is not what they inherit but what they build — and education is the one lever that changes a position rather than relieving it.",tags:["education","caste","dignity"],link:"/philanthropy#top"},
    {cat:"Essay",title:"Systems over Slogans",venue:"On governance",year:2026,status:"Essay",
     snip:"Real change arrives when positions change — when the overlooked gain leverage and institutions behave differently, not when a campaign trends and evaporates.",tags:["governance","institutions"]},
    {cat:"Study",title:"The Weirdest People in the World?",venue:"Henrich, Heine & Norenzayan · Behavioral and Brain Sciences",year:2010,status:"Recommended",
     snip:"The behavioural sciences over-generalise from Western, Educated, Industrialised, Rich, Democratic samples — a warning that travels straight into how we read India.",tags:["psychology","WEIRD","method"]},
    {cat:"Study",title:"The Colonial Origins of Comparative Development",venue:"Acemoglu, Johnson & Robinson · American Economic Review",year:2001,status:"Recommended",
     snip:"Institutions, not geography or culture, explain why nations diverge — the empirical backbone behind 'why nations fail.'",tags:["institutions","development"]},
    {cat:"Study",title:"Prospect Theory: Decision under Risk",venue:"Kahneman & Tversky · Econometrica",year:1979,status:"Recommended",
     snip:"People are not the rational agents economics assumed — losses loom larger than gains, and that asymmetry rewires every model of choice.",tags:["behavioural econ","risk"]},
    {cat:"Study",title:"The Strength of Weak Ties",venue:"Granovetter · American Journal of Sociology",year:1973,status:"Recommended",
     snip:"Information, jobs and influence travel through acquaintances, not close friends — the small idea that founded modern network sociology.",tags:["networks","sociology"]},
    {cat:"Research",title:"Deployment over Frontier: A Framework for India's AI Adoption",venue:"Working paper · Nuclear Edge",year:2026,status:"Working paper",
     snip:"A measurement framework that scores AI progress by integration into public-service delivery and productivity, not by model scale.",tags:["AI","framework","India"]},
    {cat:"Research",title:"Consumer Heterogeneity Across India's Digital Tiers",venue:"Working paper",year:2025,status:"Working paper",
     snip:"A segmentation model of Indian consumers along digital-literacy and access gradients, with implications for product and policy design.",tags:["consumer","segmentation"]},
    {cat:"Research",title:"Adaptive Governance for Automation",venue:"Bharat Governance Council",year:2026,status:"In progress",
     snip:"Designing governance frameworks that update as fast as the technologies they regulate — responsive institutions over static rulebooks.",tags:["governance","automation"]}
  ];
  const FIELDS=[
    {img:"/images/research/adam-smith-statue.jpg",name:"Markets",who:"Adam Smith · Political Economy",ln:"Markets as moral systems — the invisible hand that still needs watching, and the political economy underneath every price."},
    {img:"/images/research/karl-marx-portrait.jpg",name:"Capital & Power",who:"Karl Marx · Critique",ln:"Who owns, who labours, who decides — reading technology and policy through the ledger of power."},
    {img:"/images/research/che-guevara-portrait.jpg",name:"Revolution",who:"Che Guevara · Power",ln:"The uncomfortable question of when systems must be broken rather than reformed."},
    {img:"/images/research/steve-jobs-portrait.jpg",name:"Technology & Taste",who:"Steve Jobs · Craft",ln:"Technology built at the intersection of the humanities — with conviction, not consensus."},
    {img:"/images/research/social-research-crowd.jpg",name:"The Public",who:"Sociology of the crowd",ln:"A billion individuals who refuse to behave like one market."}
  ];

  const esc=s=>(s||"").replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;");

  /* ===== filters + list ===== */
  const CATS=[["All","all"],["Articles","Article"],["Essays","Essay"],["Recommended Studies","Study"],["Research","Research"]];
  const filtersEl=document.getElementById("filters"),publist=document.getElementById("publist");
  let active="all";
  filtersEl.innerHTML=CATS.map(([label,key])=>{
    const n=key==="all"?PUBS.length:PUBS.filter(p=>p.cat===key).length;
    return `<button data-k="${key}" class="${key==="all"?"on":""}">${label}<span class="n">${n}</span></button>`;
  }).join("");
  function render(){
    const list=active==="all"?PUBS:PUBS.filter(p=>p.cat===active);
    publist.innerHTML=list.map((p,i)=>`
      <article class="pub">
        <div class="idx">${String(i+1).padStart(2,"0")}</div>
        <div class="main">
          <span class="cat-tag">${p.cat==="Study"?"Recommended Study":p.cat}</span>
          <h3>${esc(p.title)}</h3>
          <div class="venue">${esc(p.venue)}</div>
          <p class="snip">${esc(p.snip)}</p>
          <div class="tags">${p.tags.map(t=>`<i>${esc(t)}</i>`).join("")}</div>
        </div>
        <div class="right">
          <span class="yr">${p.year}</span>
          ${p.link?`<a class="lk" href="${p.link}">Open <span class="ar">&rarr;</span></a>`:`<span class="status">${esc(p.status)}</span>`}
        </div>
      </article>`).join("");
    [...publist.children].forEach((el,i)=>setTimeout(()=>el.classList.add("show"),50+i*50));
  }
  filtersEl.addEventListener("click",e=>{const b=e.target.closest("button");if(!b)return;active=b.dataset.k;[...filtersEl.children].forEach(x=>x.classList.toggle("on",x===b));render();});

  /* ===== fields ===== */
  document.getElementById("flist").innerHTML=FIELDS.map((f,i)=>`
    <article class="field${i%2?' rev':''}">
      <div class="fig reveal"><span class="scn"></span><span class="cap">fig.0${i+3}</span><img src="${f.img}" alt="${esc(f.who)}"></div>
      <div class="fcopy">
        <div class="num reveal">FIELD · ${String(i+1).padStart(2,"0")}</div>
        <h3 class="reveal" data-d="1">${esc(f.name)}</h3>
        <div class="who reveal" data-d="1">${esc(f.who)}</div>
        <p class="reveal" data-d="2">${esc(f.ln)}</p>
      </div>
    </article>`).join("");

  /* ===== sine wave path ===== */
  (function(){
    const amp=11,mid=20,w=2880,step=6;let d="M0 "+mid;
    for(let x=0;x<=w;x+=step){d+=" L"+x+" "+(mid+amp*Math.sin(2*Math.PI*x/240)).toFixed(1);}
    document.getElementById("wavePath").setAttribute("d",d);
  })();

  /* ===== terminal typewriter ===== */
  (function(){
    const el=document.getElementById("termtxt");
    const lines=["> reading markets…","> reading machines…","> reading institutions…","> reading people…"];
    let li=0,ci=0,del=false;
    function tick(){
      const t=lines[li];
      el.textContent=t.slice(0,ci);
      if(!del){ci++;if(ci>t.length){del=true;return setTimeout(tick,1400);}}
      else{ci--;if(ci<2){del=false;li=(li+1)%lines.length;}}
      setTimeout(tick,del?34:62);
    }
    tick();
  })();

  /* ===== particle network (mouse-reactive) ===== */
  (function(){
    const cv=document.getElementById("net");if(!cv)return;
    const reduce=window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    const ctx=cv.getContext("2d");let W,H,DPR=Math.min(window.devicePixelRatio||1,2),P=[],raf,mx=-1e4,my=-1e4;
    function size(){W=cv.width=cv.offsetWidth*DPR;H=cv.height=cv.offsetHeight*DPR;}
    function init(){const n=Math.min(90,Math.round(cv.offsetWidth*cv.offsetHeight/15000));P=[];for(let i=0;i<n;i++)P.push({x:Math.random()*W,y:Math.random()*H,vx:(Math.random()-.5)*.2*DPR,vy:(Math.random()-.5)*.2*DPR});}
    const D=128*DPR,DM=160*DPR;
    function frame(){
      ctx.clearRect(0,0,W,H);
      for(const p of P){p.x+=p.vx;p.y+=p.vy;if(p.x<0||p.x>W)p.vx*=-1;if(p.y<0||p.y>H)p.vy*=-1;}
      for(let i=0;i<P.length;i++){
        for(let j=i+1;j<P.length;j++){const dx=P[i].x-P[j].x,dy=P[i].y-P[j].y,d=Math.hypot(dx,dy);
          if(d<D){ctx.strokeStyle="rgba(169,143,91,"+(0.15*(1-d/D))+")";ctx.lineWidth=DPR;ctx.beginPath();ctx.moveTo(P[i].x,P[i].y);ctx.lineTo(P[j].x,P[j].y);ctx.stroke();}}
        const ddx=P[i].x-mx,ddy=P[i].y-my,dm=Math.hypot(ddx,ddy);
        if(dm<DM){ctx.strokeStyle="rgba(199,181,137,"+(0.4*(1-dm/DM))+")";ctx.lineWidth=DPR;ctx.beginPath();ctx.moveTo(P[i].x,P[i].y);ctx.lineTo(mx,my);ctx.stroke();}
      }
      for(const p of P){ctx.fillStyle="rgba(199,181,137,.55)";ctx.beginPath();ctx.arc(p.x,p.y,1.5*DPR,0,7);ctx.fill();}
      raf=requestAnimationFrame(frame);
    }
    function start(){size();init();cancelAnimationFrame(raf);frame();}
    start();
    cv.addEventListener("mousemove",e=>{const r=cv.getBoundingClientRect();mx=(e.clientX-r.left)*DPR;my=(e.clientY-r.top)*DPR;});
    cv.addEventListener("mouseleave",()=>{mx=my=-1e4;});
    let to;window.addEventListener("resize",()=>{clearTimeout(to);to=setTimeout(start,200);});
  })();

  /* ===== header + menu ===== */
  const hdr=document.getElementById("hdr");
  const onScroll=()=>hdr.classList.toggle("scrolled",window.scrollY>40);
  onScroll();window.addEventListener("scroll",onScroll,{passive:true});
  const burger=document.getElementById("burger");
  burger.addEventListener("click",()=>document.body.classList.toggle("menu-open"));
  document.querySelectorAll("#nav a").forEach(a=>a.addEventListener("click",()=>document.body.classList.remove("menu-open")));

  /* ===== reveals + counters ===== */
  requestAnimationFrame(()=>setTimeout(()=>document.getElementById("h1").classList.add("in"),140));
  const io=new IntersectionObserver((es)=>{es.forEach(e=>{if(e.isIntersecting){e.target.classList.add("in");io.unobserve(e.target);}});},{threshold:.14,rootMargin:"0px 0px -7% 0px"});
  document.querySelectorAll(".reveal").forEach(el=>io.observe(el));
  function cup(el){const to=+el.dataset.to,t0=performance.now();(function t(n){let p=Math.min((n-t0)/1300,1);p=1-Math.pow(1-p,3);el.textContent=Math.round(to*p);if(p<1)requestAnimationFrame(t);})(t0);}
  const cIO=new IntersectionObserver((es)=>{es.forEach(e=>{if(e.isIntersecting){cup(e.target);cIO.unobserve(e.target);}});},{threshold:.5});
  document.querySelectorAll(".count").forEach(el=>cIO.observe(el));

  let rendered=false;
  const pIO=new IntersectionObserver((es)=>{es.forEach(e=>{if(e.isIntersecting&&!rendered){rendered=true;render();pIO.disconnect();}});},{threshold:.02});
  pIO.observe(document.getElementById("publist"));

  document.getElementById("yr").textContent=new Date().getFullYear();
