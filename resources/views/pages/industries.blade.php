<!DOCTYPE html>
<html lang="en-IN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Industries — Anmol Pushjai Goel · Nuclear Edge</title>
<meta name="description" content="Where Anmol Pushjai Goel invests, and why — durable businesses with moats, capable people and prices that leave room for error, across India with conviction in the North.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&family=Montserrat:wght@200;300;400;500;600&display=swap" rel="stylesheet">


<meta name="robots" content="index, follow, max-image-preview:large">
<meta name="author" content="Anmol Pushjai Goel">
<link rel="canonical" href="{{ route('industries') }}">
<meta property="og:type" content="website">
<meta property="og:locale" content="en_IN">
<meta property="og:site_name" content="Anmol Pushjai Goel">
<meta property="og:title" content="Industries — Anmol Pushjai Goel · Nuclear Edge">
<meta property="og:description" content="Where Anmol Pushjai Goel invests, and why — durable businesses with moats, capable people and prices that leave room for error, across India with conviction in the North.">
<meta property="og:url" content="{{ route('industries') }}">
<meta property="og:image" content="{{ asset('images/industries/technology.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Industries — Anmol Pushjai Goel · Nuclear Edge">
<meta name="twitter:description" content="Where Anmol Pushjai Goel invests, and why — durable businesses with moats, capable people and prices that leave room for error, across India with conviction in the North.">
<meta name="twitter:image" content="{{ asset('images/industries/technology.jpg') }}">
<link rel="stylesheet" href="{{ asset('css/industries.css') }}">
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "WebPage",
  "name": "Industries — Anmol Pushjai Goel",
  "url": "{{ route('industries') }}",
  "description": "Where Anmol Pushjai Goel invests and why, across technology, infrastructure, energy, food, logistics, education and media.",
  "inLanguage": "en-IN",
  "about": {
    "@type": "Person",
    "name": "Anmol Pushjai Goel",
    "url": "{{ route('home') }}"
  }
}
</script>
</head>
<body>

<header id="hdr">
  <a href="{{ route('home') }}" class="brand"><span class="mono">A</span>Anmol Pushjai Goel</a>
    <nav id="nav">
    <a href="#portfolio" class="active">Industries</a>
    <a href="{{ route('philanthropy') }}">Philanthropy</a>
    <a href="{{ route('home') }}#news">In the News</a>
    <a href="{{ route('home') }}#books">Books</a>
    <a href="{{ route('home') }}#research">Research &amp; Publications</a>
    <a href="{{ route('home') }}#meet">About Anmol Goel</a>
  </nav>
  <button class="burger" id="burger" aria-label="Menu"><span></span><span></span><span></span></button>
</header>

<!-- HERO -->
<main id="main-content">
<section class="hero scene" id="top">
  <div class="scene-bg" style="background-image:url('{{ asset('images/industries/hero-space.jpg') }}')"></div>
  <div class="scene-veil"></div>
  <div class="hero-grid">
    <div class="hero-copy">
      <div class="eyebrow reveal in">The Portfolio · Nuclear Edge</div>
      <h1 class="hero-title display-xl" id="heroTitle">
        <span class="ln"><span>Where we invest,</span></span>
        <span class="ln"><span><em>and why.</em></span></span>
      </h1>
      <p class="hero-line reveal" data-d="2">We buy durable businesses, run by capable people, at prices that leave room for error &mdash; and we hold them for the long arc of their growth. We invest across India, with a particular conviction in the North we know best.</p>
      <div class="hero-stats reveal" data-d="3">
        <div class="s"><b>11</b><span>Industries</span></div>
        <div class="s"><b>10&#8209;yr</b><span>The test we apply</span></div>
        <div class="s"><b>North</b><span>India conviction</span></div>
      </div>
    </div>

    <div class="roller" id="roller" aria-hidden="true">
      <div class="roll-col"><div class="roll-track" data-set="a"></div></div>
      <div class="roll-col"><div class="roll-track" data-set="b"></div></div>
      <div class="roll-col"><div class="roll-track" data-set="c"></div></div>
    </div>
  </div>
  <div class="scrollcue"><span class="bar"></span>The Philosophy</div>
</section>

<!-- PHILOSOPHY STRIP -->
<section class="section creed scene">
  <div class="scene-bg" style="background-image:url('{{ asset('images/industries/creed-buildings.jpg') }}')"></div>
  <div class="scene-veil"></div>
  <div class="wrap">
    <div class="creed-statement reveal">Understand the business before the stock. Prize the <em>moat over the momentum.</em> And let time do the heavy lifting.</div>
    <div class="creed-meta reveal" data-d="1">
      <div class="item"><b>Circle of competence</b>Old-economy cash and the digital frontier, deliberately chosen</div>
      <div class="item"><b>The one question</b>Will this business be earning more, ten years from now?</div>
      <div class="item"><b>Geography</b>All of India, with an on-the-ground North-India edge</div>
      <div class="item"><b>The horizon</b>Long-term owners &mdash; not traders of tickers</div>
    </div>
  </div>
</section>

<!-- PORTFOLIO OVERVIEW -->
<section class="section scene" id="portfolio">
  <div class="scene-bg" style="background-image:url('{{ asset('images/industries/portfolio-data-centre.jpg') }}')"></div>
  <div class="scene-veil"></div>
  <div class="pf-head">
    <div>
      <div class="eyebrow">The Sectors</div>
      <h2 class="display-lg">Where the capital sits.</h2>
    </div>
    <p class="lead reveal" data-d="1">From silicon to dairy to timber &mdash; eleven industries, chosen not by sector label but by one shared test: a business that will still be earning, and earning more, a decade from now. Tap any to read the thesis.</p>
  </div>
  <div class="pf-grid" id="pfGrid"><!-- tiles injected --></div>
</section>

<!-- TICKER -->
<div class="ticker-band">
  <div class="ticker"><div class="ticker-track" id="ticker"></div></div>
</div>

<!-- DETAILED ROWS -->
<section class="rows">
  <div class="wrap" id="indWrap"><!-- rows injected --></div>
</section>

<!-- CLOSING -->
<section class="section scene" id="close">
  <div class="scene-bg" style="background-image:url('{{ asset('images/industries/closing-policy.jpg') }}')"></div>
  <div class="scene-veil"></div>
  <div class="wrap">
    <div class="eyebrow center reveal">The Common Thread</div>
    <h2 class="display-md reveal" data-d="1">Understand. Trust. Respect. Protect.</h2>
    <p class="reveal" data-d="2">Across every industry we touch, the test is the same &mdash; a business we can understand, a moat we can trust, a management we can respect, and a price that protects us if we are wrong. We partner with businesses, and the people who build them, for the years it takes for great companies to become greater.</p>
    <a class="btn reveal" data-d="3" href="#contact">Start a conversation <span class="ar">&rarr;</span></a>
  </div>
</section>

<!-- FOOTER -->
</main>

<footer id="contact">
  <div class="foot-grid">
    <div>
      <div class="eyebrow">Investment &amp; collaboration</div>
      <h2 class="display-md">Let&rsquo;s talk capital.</h2>
      <div class="contact-line">
        <a class="big" href="mailto:invest@anmolpushjaigoel.com">invest@anmolpushjaigoel.com</a>
      </div>
    </div>
    <div class="foot-r">
      <label>Nuclear Edge</label>
      <p class="lead">Deep-tech consulting &amp; a long-horizon portfolio across technology, energy, food, logistics, materials, education and media &mdash; with conviction in North India.</p>
      <div class="socials">
        <a href="#">LinkedIn</a><a href="#">X / Twitter</a><a href="{{ route('home') }}">Back to Home</a>
      </div>
    </div>
  </div>
  <div class="foot-base">
    <span>&copy; <span id="yr"></span> Anmol Pushjai Goel. All rights reserved.</span>
    <span>Entrepreneur &middot; Investor &middot; Tech &amp; AI Policy Voice</span>
  </div>
</footer>


<script src="{{ asset('js/industries.js') }}"></script>
</body>
</html>
