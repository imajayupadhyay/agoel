const pageData = window.BOOKS_PAGE_DATA || {};
const libraryBooks = (pageData.books || []).map((book) => ({
  t: book.title || "",
  a: book.author || "",
  y: Number(book.year) || new Date().getFullYear(),
}));

const PALETTE=["#6E4B3A","#3E5641","#2E4257","#7A2E2E","#8A6D3B","#4A4A52","#5C3A2E","#34495E","#6B3A4B","#2F4A43","#7C5A33","#404A3D"];
const colorOf=s=>{let h=0;for(let i=0;i<s.length;i++)h=(h*31+s.charCodeAt(i))>>>0;return PALETTE[h%PALETTE.length];};
const heightOf=s=>{let h=0;for(let i=0;i<s.length;i++)h=(h*17+s.charCodeAt(i))>>>0;return 188+(h%52);};
const sortKey=t=>(t || "").replace(/^(the|a|an)\s+/i,"").toUpperCase();
const esc=s=>(s || "").replace(/&/g,"&amp;");

  /* ---- annual shelves ---- */
  const YEARS=[...new Set(libraryBooks.map(b=>b.y))].sort();
  let activeYear=YEARS[YEARS.length-1] || new Date().getFullYear();
  const yearsEl=document.getElementById("years");
  if (yearsEl) yearsEl.innerHTML=YEARS.map(y=>`<button class="yr${y===activeYear?' on':''}" data-y="${y}">${y}</button>`).join("");
  const shelf=document.getElementById("shelf"), yrMeta=document.getElementById("yrMeta");

  function renderShelf(y){
    activeYear=y;
    document.querySelectorAll(".yr").forEach(b=>b.classList.toggle("on",+b.dataset.y===y));
    const list=libraryBooks.filter(b=>b.y===y).sort((a,b)=>sortKey(a.t)<sortKey(b.t)?-1:1);
    shelf.innerHTML=list.map(b=>`
      <div class="spine" style="--c:${colorOf(b.t)};height:${heightOf(b.t)}px" title="${esc(b.t)} — ${esc(b.a)}">
        <span class="t">${esc(b.t)}</span>
        <span class="tip"><b>${esc(b.t)}</b><span>${esc(b.a)}</span></span>
      </div>`).join("");
    yrMeta.textContent=list.length+" books · "+y;
    const sp=[...shelf.children];
    sp.forEach((s,i)=>setTimeout(()=>s.classList.add("in"),60+i*55));
  }
  if (yearsEl) yearsEl.addEventListener("click",e=>{const b=e.target.closest(".yr");if(b)renderShelf(+b.dataset.y);});

  /* ---- A-Z ---- */
  const groups={};
  libraryBooks.slice().sort((a,b)=>sortKey(a.t)<sortKey(b.t)?-1:1).forEach(b=>{
    const L=sortKey(b.t)[0];(groups[L]=groups[L]||[]).push(b);
  });
  const ALPHA="ABCDEFGHIJKLMNOPQRSTUVWXYZ".split("");
  if (document.getElementById("azNav")) document.getElementById("azNav").innerHTML=ALPHA.map(L=>
    groups[L]?`<a class="has" href="#az-${L}">${L}</a>`:`<a class="off">${L}</a>`).join("");
  if (document.getElementById("azBody")) document.getElementById("azBody").innerHTML=Object.keys(groups).sort().map(L=>`
    <div class="azgroup" id="az-${L}">
      <div class="azletter">${L}</div>
      ${groups[L].map(b=>`
        <div class="brow">
          <span class="sw" style="--c:${colorOf(b.t)}"></span>
          <span><span class="bt">${esc(b.t)}</span><span class="ba">${esc(b.a)}</span></span>
          <span class="by">${b.y}</span>
        </div>`).join("")}
    </div>`).join("");

  /* ---- reviews (full reviews by Anmol Pushjai Goel) ---- */
  const escH=s=>(s||"").replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;");
  const reviewsData = (pageData.reviews || []).map((review) => ({
    title: review.title || "",
    author: review.author || "",
    year: review.year || "",
    teaser: review.teaser || "",
    paras: (review.body || "").split(/\n{2,}/).map((part) => part.trim()).filter(Boolean),
    pdf: review.pdf || "",
  }));
  const revGrid=document.getElementById("revGrid");
  if (revGrid) revGrid.innerHTML=reviewsData.map((r,i)=>`
    <article class="rcard reveal" data-i="${i}" data-d="${i%3}">
      <div class="rcover" style="--c:${colorOf(r.title)}">
        ${r.year?`<span class="yr">${r.year}</span>`:""}
        <span class="ttl">${escH(r.title)}</span>
      </div>
      <div class="rbody">
        <span class="auth">${escH(r.author)}</span>
        <p>${escH(r.teaser)}</p>
        <span class="st">Read review <span class="ar">&rarr;</span></span>
      </div>
    </article>`).join("");

  const modal=document.getElementById("revModal");
  function openReview(i){
    const r=reviewsData[i];
    document.getElementById("mKicker").textContent=pageData.reviewKicker || "Book Review · Anmol Pushjai Goel";
    document.getElementById("mTitle").textContent=r.title;
    document.getElementById("mMeta").textContent=r.author+(r.year?"   \u00b7   "+r.year:"");
    document.getElementById("mBody").innerHTML=r.paras.map(p=>`<p>${escH(p)}</p>`).join("");
    const dl=document.getElementById("mDownload");
    document.getElementById("mDownloadLabel").textContent=pageData.downloadLabel || "Download the original · public domain";
    document.getElementById("mSignature").textContent=pageData.reviewSignature || "— Anmol Pushjai Goel";
    if(r.pdf){dl.href=r.pdf;dl.setAttribute("download",r.title+" — original.pdf");dl.style.display="inline-flex";}
    else dl.style.display="none";
    modal.classList.add("on");document.body.style.overflow="hidden";
    document.getElementById("mScroll").scrollTop=0;
  }
  function closeReview(){modal.classList.remove("on");document.body.style.overflow="";}
  if (revGrid) revGrid.addEventListener("click",e=>{const c=e.target.closest(".rcard");if(c)openReview(+c.dataset.i);});
  document.getElementById("revClose")?.addEventListener("click",closeReview);
  modal.addEventListener("click",e=>{if(e.target===modal)closeReview();});
  document.addEventListener("keydown",e=>{if(e.key==="Escape"&&modal.classList.contains("on"))closeReview();});

    /* ---- view toggle ---- */
  window.setView = function setView(v){
    const y=v==="year";
    document.getElementById("viewYear").classList.toggle("on",y);
    document.getElementById("viewAZ").classList.toggle("on",!y);
    document.getElementById("tgYear").classList.toggle("on",y);
    document.getElementById("tgAZ").classList.toggle("on",!y);
    if(y)renderShelf(activeYear);
  }

  /* ---- header + menu ---- */
  const hdr=document.getElementById("hdr");
  const onScroll=()=>hdr.classList.toggle("scrolled",window.scrollY>40);
  onScroll();window.addEventListener("scroll",onScroll,{passive:true});
  const burger=document.getElementById("burger");
  burger.addEventListener("click",()=>document.body.classList.toggle("menu-open"));
  document.querySelectorAll("#nav a").forEach(a=>a.addEventListener("click",()=>document.body.classList.remove("menu-open")));

  /* ---- reveals ---- */
  const io=new IntersectionObserver((es)=>{es.forEach(e=>{if(e.isIntersecting){e.target.classList.add("in");io.unobserve(e.target);}});},{threshold:.14,rootMargin:"0px 0px -7% 0px"});
  document.querySelectorAll(".reveal").forEach(el=>io.observe(el));
  // manifesto + first shelf
  requestAnimationFrame(()=>setTimeout(()=>document.getElementById("manifesto").classList.add("in"),200));
  const shelfIO=new IntersectionObserver((es)=>{es.forEach(e=>{if(e.isIntersecting){renderShelf(activeYear);shelfIO.disconnect();}});},{threshold:.2});
  const shelfEl = document.getElementById("shelf");
  if (shelfEl) shelfIO.observe(shelfEl);

  document.getElementById("yr").textContent=new Date().getFullYear();
