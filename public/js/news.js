const NEWS=[
    {out:"The Tribune",date:"Jun 25, 2024",
     title:"The Sociologist Entrepreneur, Anmol Pushjai Goel",
     url:"https://www.tribuneindia.com/news/business/anmol-pushjai-goel-prominent-indian-entrepreneur-and-tech-policy-expert-redefining-indias-ai-agenda/",
     img:"/images/news/the-tribune-sociologist-entrepreneur.jpg",reel:true},
    {out:"The Wire",date:"Jun 25, 2024",
     title:"India Not in the AI Race, Selling Chai Outside the Stadium",
     url:"https://thewire.in/ptiprnews/anmol-pushjai-goel-prominent-indian-entrepreneur-and-tech-policy-expert-redefining-indias-ai-agenda",
     img:"/images/news/the-wire-ai-race.jpg",reel:true},
    {out:"Business Standard",date:"Jun 22, 2024",
     title:"Nuclear Edge: Company Directors, Revenue &amp; Projects",
     url:"https://www.business-standard.com/content/press-releases-ani/nuclear-edge-best-it-company-revenue-networth-directors-anmol-pushjai-goel-prominent-indian-entrepreneur-and-ai-policy-expert-126062201052_1.html",
     img:"/images/news/business-standard-nuclear-edge.jpg",reel:true},
    {out:"Wisconsin Journal",date:"Jun 22, 2024",
     title:"Leading IT Company, Nuclear Edge",
     url:"https://www.wisconsinjournal.news/news/nuclear-edge-best-it-company-revenue-networth-directors-anmol-pushjai-goel-prominent-indian-entrepreneur-and-ai-policy-expert20260622180340/",
     img:"/images/news/wisconsin-journal-nuclear-edge.jpg",reel:true},
    {out:"ThePrint",date:"Aug 16, 2023",
     title:"Funds Should Be the Last Thing Stopping Anybody From Studying",
     url:"https://theprint.in/ani-press-releases/free-ias-coaching-for-underprivileged-aspirants-a-game-changer-by-99notes/1717326/",
     img:"/images/news/theprint-funds-should-be-last.jpg",reel:true},
    {out:"The Statesman",date:"Aug 16, 2023",
     title:"What is 99Notes? Free IAS coaching for underprivileged aspirants",
     url:"https://www.thestatesman.com/education/what-is-99-notes-ias-coaching-institute-providing-free-coaching-to-underprivileged-aspirants-1503212537.html",
     reel:false},
    {out:"ThePrint",date:"Feb 19, 2024",
     title:"Top Bureaucrat IAS (R) Sunil Oberoi joins 99Notes",
     url:"https://theprint.in/ani-press-releases/top-bureaucrat-ias-r-sunil-oberoi-joins-99notes/1971171/",
     reel:false}
  ];

  /* reel cards (only those with screenshots) */
  const reelItems=NEWS.filter(n=>n.reel);
  const card=n=>`
    <a class="ncard" href="${n.url}" target="_blank" rel="noopener">
      <div class="nclip"><img src="${n.img}" alt="${n.out} — ${n.title}" loading="lazy"></div>
      <div class="nbody">
        <div class="n-meta"><span class="n-out">${n.out}</span><span class="n-date">${n.date}</span></div>
        <h3>${n.title}</h3>
        <span class="n-read">Read on ${n.out} <span class="ar">&rarr;</span></span>
      </div>
    </a>`;
  document.getElementById("track").innerHTML=(reelItems.map(card).join("")).repeat(2);

  /* full index rows (all items) */
  document.getElementById("ct").textContent=NEWS.length+" features";
  document.getElementById("rows").innerHTML=NEWS.map(n=>`
    <a class="row" href="${n.url}" target="_blank" rel="noopener">
      <span class="r-date">${n.date}</span>
      <span class="r-out">${n.out}</span>
      <span class="r-title">${n.title}</span>
      <span class="r-go">Read <span class="ar">&rarr;</span></span>
    </a>`).join("");

  /* header + menu */
  const hdr=document.getElementById("hdr");
  const onScroll=()=>hdr.classList.toggle("scrolled",window.scrollY>40);
  onScroll();window.addEventListener("scroll",onScroll,{passive:true});
  const burger=document.getElementById("burger");
  burger.addEventListener("click",()=>document.body.classList.toggle("menu-open"));
  document.querySelectorAll("#nav a").forEach(a=>a.addEventListener("click",()=>document.body.classList.remove("menu-open")));

  /* intro reveal */
  requestAnimationFrame(()=>setTimeout(()=>{
    document.getElementById("h1").classList.add("in");
    document.getElementById("sub").classList.add("in");
    document.getElementById("hint").classList.add("in");
    // stagger the reel cards in (first set only is enough visually)
    document.querySelectorAll(".reel-track .ncard").forEach((c,i)=>setTimeout(()=>c.classList.add("in"),200+i*90));
  },120));

  /* scroll reveals for index + rows */
  const io=new IntersectionObserver((es)=>{es.forEach(e=>{if(e.isIntersecting){e.target.classList.add("in");io.unobserve(e.target);}});},{threshold:.14,rootMargin:"0px 0px -6% 0px"});
  document.querySelectorAll(".reveal").forEach(el=>io.observe(el));
  const rowIO=new IntersectionObserver((es)=>{es.forEach(e=>{if(e.isIntersecting){const r=[...document.querySelectorAll(".row")].indexOf(e.target);setTimeout(()=>e.target.classList.add("in"),(r%NEWS.length)*70);rowIO.unobserve(e.target);}});},{threshold:.2});
  setTimeout(()=>document.querySelectorAll(".row").forEach(r=>rowIO.observe(r)),60);

  document.getElementById("yr").textContent=new Date().getFullYear();
