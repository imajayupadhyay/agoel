const INDUSTRIES = [
    {
      name:"Technology", tag:"Compute · Platforms · Pricing Power",
      img:"/images/industries/technology.jpg",
      body:"The compounding engine of the modern economy &mdash; and India is no longer just its back office, but a builder of products and platforms. We back technology businesses with genuine pricing power: defensible IP, sticky customers, and switching costs that widen the moat each year. We favour companies whose advantage is <em>structural rather than sentimental</em>, funded by their own cash rather than the next round of capital.",
      pull:"Wary of fashion, fond of fundamentals.",
      facts:["Defensible IP","Self-funded growth"]
    },
    {
      name:"IT Services", tag:"Delivery Scale · Client Trust",
      img:"/images/industries/it-services.jpg",
      body:"One of India&rsquo;s truest moats &mdash; built on talent depth, delivery scale, and decades of client trust competitors cannot replicate overnight. We look for firms with high client retention, diversified revenue, and the discipline to <em>move up the value chain</em> from labour arbitrage toward outcomes, automation and domain expertise.",
      pull:"Durable, cash-rich franchises with long reinvestment runways.",
      facts:["Noida · Gurugram corridors","High client retention"]
    },
    {
      name:"Data Centres", tag:"Digital Infrastructure · Real Assets",
      img:"/images/industries/data-centres.jpg",
      body:"Every app, transaction and AI model has to live somewhere &mdash; increasingly on Indian soil, driven by data localisation, cloud adoption and surging digital consumption. Data centres are the <em>toll roads of the digital age</em>: capital-intensive to build, blessed with long contracts, recurring revenue and high barriers to entry.",
      pull:"A multi-decade compounding theme in real infrastructure.",
      facts:["Long-tenor contracts","Power & land advantage"]
    },
    {
      name:"Petroleum", tag:"Distribution · Storage · Logistics",
      img:"/images/industries/petroleum.jpg",
      body:"Energy is the bloodstream of an industrialising economy, and petroleum remains foundational to India&rsquo;s transport, manufacturing and rural growth. We favour businesses with control over distribution, strong storage and logistics, and resilient margins through the cycle &mdash; a <em>durable, cash-generative position</em> rather than a bet on the price of a barrel.",
      pull:"We approach the sector with the patience it demands.",
      facts:["North India consumption belt","Throughput & infrastructure"]
    },
    {
      name:"Milk &amp; Dairy", tag:"Procurement · Cold Chain · Brand",
      img:"/images/industries/milk-dairy.jpg",
      body:"One of the great recurring-revenue businesses hidden in plain sight &mdash; a daily, non-discretionary purchase in nearly every Indian household. North India is the heartland of Indian milk. We invest in strong procurement networks, cold-chain capability and brand loyalty that turns a commodity into a moat &mdash; companies that <em>earn a little, every day, from millions of customers</em>, and reinvest it for decades.",
      pull:"The closest thing in food to a perpetual annuity.",
      facts:["Punjab · Haryana · UP · Rajasthan","Farmer networks"]
    },
    {
      name:"Transportation &amp; Logistics", tag:"Freight Corridors · Route Density",
      img:"/images/industries/transportation-logistics.jpg",
      body:"As goods move, value moves with them &mdash; and India&rsquo;s logistics backbone is being rebuilt at historic scale. We back asset-smart operators along the country&rsquo;s freight corridors, with the Delhi-NCR hub and the region&rsquo;s arterial highways among the densest goods movement in India &mdash; operators with the discipline to <em>convert volume into consistent free cash flow</em>, not commoditised competition.",
      pull:"The arteries every other industry quietly relies on.",
      facts:["Delhi-NCR freight hub","Repeat customers"]
    },
    {
      name:"Timber &amp; Wood", tag:"Import / Export · Processing",
      img:"/images/industries/timber-wood.jpg",
      body:"Few associate North India with global trade flows &mdash; yet Yamunanagar in Haryana is the plywood and timber capital of the country, and India&rsquo;s construction and furniture demand keeps wood in perpetual short supply. A classic trading and processing business: supplier relationships, working-capital discipline, port logistics from Kandla to the heartland. <em>An old business done well</em> &mdash; steady margins, real assets.",
      pull:"Demand tied directly to India&rsquo;s housing and infrastructure growth.",
      facts:["Yamunanagar · Kandla port","Working-capital discipline"]
    },
    {
      name:"Education", tag:"Institutions · Brands · Outcomes",
      img:"/images/industries/education.jpg",
      body:"The most defensible business in any aspiring economy &mdash; driven by relentless demand, deep trust, and pricing power that compounds with reputation. India&rsquo;s young population and North India&rsquo;s standing as a centre of learning &mdash; from Delhi to Chandigarh to the coaching capital of Kota &mdash; create a decade-long tailwind. We back brands and outcomes that turn a single campus into a <em>generational franchise</em>.",
      pull:"Reputation compounds; it does not depreciate.",
      facts:["Delhi · Chandigarh · Kota","Demonstrated outcomes"]
    },
    {
      name:"EdTech", tag:"Digital Learning · Selective",
      img:"/images/industries/edtech.jpg",
      body:"EdTech extends quality education from the metros to the smallest towns, where India&rsquo;s appetite for learning meets its smartphone penetration. We invest selectively and with discipline &mdash; mindful that not every fast-growing platform earns its keep. We look for unit economics that work and retention that proves real value, backing the rare businesses building <em>a moat, not just a user count</em>.",
      pull:"The opportunity is enormous; our standard is unforgiving.",
      facts:["Unit-economics first","Real retention"]
    },
    {
      name:"Production Houses", tag:"Content · IP · Libraries",
      img:"/images/industries/production-houses.jpg",
      body:"Stories are India&rsquo;s quiet export and its deepest cultural currency, and the production house sits at the heart of that economy. We invest in content businesses with a library of value &mdash; a back catalogue that earns long after release, relationships with talent and distributors, and the consistency to compound a brand. As streaming and regional content expand the market, we favour houses that <em>own their intellectual property</em>.",
      pull:"Content as a durable asset, not a one-time gamble.",
      facts:["Owned IP","Back-catalogue earnings"]
    },
    {
      name:"Media &amp; Entertainment", tag:"Distribution · Audience · Franchises",
      img:"/images/industries/media-entertainment.jpg",
      body:"Media is where <em>attention becomes a moat</em> &mdash; and in a market as large, young and linguistically diverse as India&rsquo;s, that attention is only deepening. We invest across the value chain in businesses with audience loyalty, repeatable franchises and multiple ways to monetise the same content &mdash; strong regional resonance across North India alongside national reach.",
      pull:"Brands and distribution competitors find very hard to dislodge.",
      facts:["Regional resonance","National reach"]
    }
  ];

  const clean = s => s.replace(/&amp;/g,"&");
  const pad = n => String(n).padStart(2,"0");

  /* rolling hero columns */
  (function(){
    const sets={a:[0,3,6,9,1],b:[1,4,7,10,2],c:[2,5,8,0,4]};
    document.querySelectorAll(".roll-track").forEach(track=>{
      const idxs=sets[track.dataset.set];
      const chip=i=>`<div class="chip"><span class="no">${pad(i+1)}</span><span class="nm">${INDUSTRIES[i].name}</span></div>`;
      const html=idxs.map(chip).join("");
      track.innerHTML=html+html;
    });
  })();

  /* portfolio tiles */
  (function(){
    document.getElementById("pfGrid").innerHTML=INDUSTRIES.map((ind,i)=>`
      <a class="tile" href="#ind-${i}" data-fallback="${clean(ind.name)}">
        <img src="${ind.img}" alt="${clean(ind.name)}" loading="lazy" onerror="this.style.display='none'">
        <div class="ov">
          <span class="no">${pad(i+1)}</span>
          <div><div class="nm">${ind.name}</div><span class="go">View thesis &rarr;</span></div>
        </div>
      </a>`).join("");
  })();

  /* ticker */
  (function(){
    const items=INDUSTRIES.map((ind,i)=>`<div class="ti"><b>${pad(i+1)}</b> ${ind.name}</div>`).join("");
    document.getElementById("ticker").innerHTML=items+items;
  })();

  /* detail rows */
  (function(){
    document.getElementById("indWrap").innerHTML=INDUSTRIES.map((ind,i)=>{
      const rev=i%2===1?" rev":"";
      const facts=ind.facts.map(f=>`<span class="fchip">${f}</span>`).join("");
      return `
      <article class="ind${rev}" id="ind-${i}">
        <div class="ind-bg" style="background-image:url('${ind.img}')"></div>
        <div class="ind-veil"></div>
        <div class="ind-main reveal">
          <div class="frame" data-fallback="${clean(ind.name)}">
            <img src="${ind.img}" alt="${clean(ind.name)}" loading="lazy" onerror="this.style.display='none'">
          </div>
          <span class="num">${pad(i+1)}</span>
        </div>
        <div class="ind-copy reveal" data-d="1">
          <span class="tag">${ind.tag}</span>
          <h3>${ind.name}</h3>
          <p class="body">${ind.body}</p>
          <div class="pull"><p>${ind.pull}</p></div>
          <div class="facts">${facts}</div>
        </div>
      </article>`;
    }).join("");
  })();

  /* header scroll */
  const hdr=document.getElementById("hdr");
  const onScroll=()=>hdr.classList.toggle("scrolled",window.scrollY>40);
  onScroll();window.addEventListener("scroll",onScroll,{passive:true});

  /* mobile menu */
  const burger=document.getElementById("burger");
  burger.addEventListener("click",()=>document.body.classList.toggle("menu-open"));
  document.querySelectorAll("#nav a").forEach(a=>a.addEventListener("click",()=>document.body.classList.remove("menu-open")));

  /* hero title reveal */
  requestAnimationFrame(()=>setTimeout(()=>document.getElementById("heroTitle").classList.add("in"),120));

  /* reveal observer */
  const io=new IntersectionObserver((es)=>{
    es.forEach(e=>{if(e.isIntersecting){e.target.classList.add("in");io.unobserve(e.target);}});
  },{threshold:.16,rootMargin:"0px 0px -8% 0px"});
  document.querySelectorAll(".reveal").forEach(el=>io.observe(el));

  /* stagger tiles */
  const tiles=document.querySelectorAll(".tile");
  const tileIO=new IntersectionObserver((es)=>{
    es.forEach(e=>{if(e.isIntersecting){const i=[...tiles].indexOf(e.target);setTimeout(()=>e.target.classList.add("in"),(i%4)*90);tileIO.unobserve(e.target);}});
  },{threshold:.2});
  tiles.forEach(t=>tileIO.observe(t));

  document.getElementById("yr").textContent=new Date().getFullYear();
