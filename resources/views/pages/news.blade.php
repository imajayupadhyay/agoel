<!DOCTYPE html>
<html lang="en-IN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>In the News — Anmol Pushjai Goel</title>
<meta name="description" content="Anmol Pushjai Goel in News — featured across The Tribune, The Wire, ThePrint, Business Standard, Wisconsin Journal and more.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&family=Montserrat:wght@200;300;400;500;600&display=swap" rel="stylesheet">


<meta name="robots" content="index, follow, max-image-preview:large">
<meta name="author" content="Anmol Pushjai Goel">
<link rel="canonical" href="{{ route('news') }}">
<meta property="og:type" content="website">
<meta property="og:locale" content="en_IN">
<meta property="og:site_name" content="Anmol Pushjai Goel">
<meta property="og:title" content="In the News — Anmol Pushjai Goel">
<meta property="og:description" content="Anmol Pushjai Goel in News — featured across The Tribune, The Wire, ThePrint, Business Standard, Wisconsin Journal and more.">
<meta property="og:url" content="{{ route('news') }}">
<meta property="og:image" content="{{ asset('images/news/nuclear-edge-office.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="In the News — Anmol Pushjai Goel">
<meta name="twitter:description" content="Anmol Pushjai Goel in News — featured across The Tribune, The Wire, ThePrint, Business Standard, Wisconsin Journal and more.">
<meta name="twitter:image" content="{{ asset('images/news/nuclear-edge-office.jpg') }}">
<link rel="stylesheet" href="{{ asset('css/news.css') }}">
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "CollectionPage",
  "name": "In the News — Anmol Pushjai Goel",
  "url": "{{ route('news') }}",
  "description": "Anmol Pushjai Goel in News — featured across The Tribune, The Wire, ThePrint, Business Standard, Wisconsin Journal and more.",
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
    <a href="{{ route('industries') }}">Industries</a>
    <a href="{{ route('philanthropy') }}">Philanthropy</a>
    <a href="#top" class="active">In the News</a>
    <a href="{{ route('books') }}">Books</a>
    <a href="{{ route('research') }}">Research &amp; Publications</a>
    <a href="{{ route('home') }}#meet">About Anmol Goel</a>
  </nav>
  <button class="burger" id="burger" aria-label="Menu"><span></span><span></span><span></span></button>
</header>

<!-- HERO -->
<main id="main-content">
<section class="hero" id="top">
  <div class="scene-bg" style="background-image:url('{{ asset('images/news/nuclear-edge-office.jpg') }}')"></div>
  <div class="scene-veil"></div>
  <div class="stage">
    <div class="head">
      <div class="eyebrow center">Press &amp; Media</div>
      <h1 id="h1"><span>In the <em>news.</em></span></h1>
      <div class="subline" id="sub">Anmol Pushjai Goel in News</div>
    </div>
    <div class="reel" id="reel"><div class="reel-track" id="track"></div></div>
    <div class="hint" id="hint">Auto-scrolling <i></i> hover to pause <i></i> click any clipping to read</div>
  </div>
</section>

<!-- FULL INDEX -->
<section class="index">
  <div class="index-in">
    <div class="index-head">
      <div>
        <div class="eyebrow">The full record</div>
        <h2 class="reveal">All coverage.</h2>
      </div>
      <div class="ct reveal" data-d="1" id="ct"></div>
    </div>
    <div class="rows" id="rows"></div>
    <p class="syndicate reveal"><b>Syndicated across</b> Google News, Yahoo News, Dailyhunt, ANI, Latestly, PTI, Jaipur Times and 480+ publications worldwide.</p>
  </div>
</section>

<!-- FOOTER -->
</main>

<footer id="contact">
  <div class="foot-grid">
    <div class="foot-l">
      <div class="eyebrow">Press &amp; media enquiries</div>
      <a class="big" href="mailto:press@anmolpushjaigoel.com">press@anmolpushjaigoel.com</a>
    </div>
    <div class="foot-r">
      <a href="#">LinkedIn</a><a href="#">X / Twitter</a><a href="{{ route('home') }}">Back to Home</a>
    </div>
  </div>
  <div class="foot-base">
    <span>&copy; <span id="yr"></span> Anmol Pushjai Goel. All rights reserved.</span>
    <span>Entrepreneur &middot; Investor &middot; Tech &amp; AI Policy Voice</span>
  </div>
</footer>


<script src="{{ asset('js/news.js') }}"></script>
</body>
</html>