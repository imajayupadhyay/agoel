<!DOCTYPE html>
<html lang="en-IN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Research & Publications — Anmol Pushjai Goel</title>
<meta name="description" content="Research, articles, essays and recommended studies by Anmol Pushjai Goel.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&family=Montserrat:wght@200;300;400;500;600&family=Cormorant+Garamond:ital,wght@0,500;1,500&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">


<meta name="robots" content="index, follow, max-image-preview:large">
<meta name="author" content="Anmol Pushjai Goel">
<link rel="canonical" href="{{ route('research') }}">
<meta property="og:type" content="website">
<meta property="og:locale" content="en_IN">
<meta property="og:site_name" content="Anmol Pushjai Goel">
<meta property="og:title" content="Research &amp; Publications — Anmol Pushjai Goel">
<meta property="og:description" content="Research, articles, essays and recommended studies by Anmol Pushjai Goel.">
<meta property="og:url" content="{{ route('research') }}">
<meta property="og:image" content="{{ asset('images/research/research-hero-collage.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Research &amp; Publications — Anmol Pushjai Goel">
<meta name="twitter:description" content="Research, articles, essays and recommended studies by Anmol Pushjai Goel.">
<meta name="twitter:image" content="{{ asset('images/research/research-hero-collage.jpg') }}">
<link rel="stylesheet" href="{{ asset('css/research.css') }}">
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "CollectionPage",
  "name": "Research & Publications — Anmol Pushjai Goel",
  "url": "{{ route('research') }}",
  "description": "Research, articles, essays and recommended studies by Anmol Pushjai Goel.",
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
    <a href="{{ route('news') }}">In the News</a>
    <a href="{{ route('books') }}">Books</a>
    <a href="#top" class="active">Research &amp; Publications</a>
    <a href="{{ route('home') }}#meet">About Anmol Goel</a>
  </nav>
  <button class="burger" id="burger" aria-label="Menu"><span></span><span></span><span></span></button>
</header>

<!-- INDEX (page starts here) -->
<main id="main-content">
<section class="index" id="top">
  <div class="idx-bg" style="background-image:url('{{ asset('images/research/research-hero-collage.jpg') }}')"></div>
  <canvas id="net"></canvas>
  <div class="idx-veil"></div>
  <div class="idx-in">
    <div class="idx-head">
      <div class="kick">Anmol Pushjai Goel</div>
      <h1 id="h1"><span>Research &amp; Publications</span></h1>
      <div class="terminal" id="term"><span id="termtxt"></span><span class="cur"></span></div>
      </div>
      <div class="filters" id="filters"></div>
    <div class="publist" id="publist"></div>
    <p class="pubs-note">// a living index — new work is appended as it is published</p>
    <div class="wave"><svg id="wave" viewBox="0 0 2880 40" preserveAspectRatio="none"><path id="wavePath" fill="none" stroke="rgba(169,143,91,.5)" stroke-width="1.4"/></svg></div>
  </div>
</section>

<!-- LENS (signpost) -->
<section class="section lens">
  <div class="wrap">
    <div class="fig reveal">
      <span class="scn"></span>
      <span class="cap">fig.01 — the lens</span>
      <img loading="lazy" decoding="async" src="{{ asset('images/research/sociology-psychology-technology-sign.jpg') }}" alt="Sociology, Psychology, Technology">
    </div>
    <div class="lens-copy">
      <div class="eyebrow reveal">Methodology</div>
      <h2 class="reveal" data-d="1">Three disciplines, one way of seeing.</h2>
      <p class="reveal" data-d="1">This work is not engineering-first. It reads markets, machines and policy the way a social scientist reads people &mdash; for incentives, institutions and the quiet structures that decide what is possible.</p>
      <div class="creds reveal" data-d="2">
        <div><span>BA</span> Psychology &middot; Panjab University, Chandigarh</div>
        <div><span>MA</span> Sociology &middot; Jawaharlal Nehru University, New Delhi</div>
        <div><span>MA</span> Philosophy &middot; Panjab University, Chandigarh</div>
      </div>
    </div>
  </div>
</section>

<!-- INTERLUDE (jobs young) -->
<section class="interlude">
  <div class="ibg" style="background-image:url('{{ asset('images/research/steve-jobs-floor.jpg') }}')"></div>
  <div class="iq">
    <div class="eyebrow center">fig.02 — at the intersection</div>
    <blockquote>Technology alone is not enough. It is technology married to the humanities that yields the result that makes the heart sing.</blockquote>
    <div class="src">The premise the research is built on</div>
  </div>
</section>

<!-- FIELDS (one image each) -->
<section class="section fields" id="fields">
  <div class="wrap">
    <div class="fields-head">
      <svg class="orbit" viewBox="0 0 40 40"><circle cx="20" cy="20" r="13" fill="none" stroke="rgba(169,143,91,.4)" stroke-width="1"/><g class="dot"><circle cx="33" cy="20" r="2.4" fill="#A98F5B"/></g><circle cx="20" cy="20" r="2" fill="#C7B589"/></svg>
      <div class="eyebrow center reveal">The minds in the margins</div>
      <h2 class="reveal" data-d="1">Who the work argues with.</h2>
    </div>
    <div class="flist" id="flist"></div>
  </div>
</section>

<!-- FOOTER -->
</main>

<footer id="sub">
  <div class="foot-bg" style="background-image:url('{{ asset('images/research/anmol-goel-research-portrait.jpg') }}')"></div>
  <div class="foot-in">
    <div class="foot-brand reveal">Anmol Pushjai Goel</div>
    <div class="foot-tag reveal" data-d="1">Research &middot; essays &middot; recommended reading</div>
    <div class="socials reveal" data-d="1">
      <a href="#" aria-label="Substack"><svg viewBox="0 0 24 24"><path d="M22 4H2v3h20V4zM2 10v10l10-4.5L22 20V10H2z"/></svg>Substack</a>
      <a href="#" aria-label="X / Twitter"><svg viewBox="0 0 24 24"><path d="M18.9 2H22l-7.2 8.2L23 22h-6.6l-5-6.6L5.6 22H2.5l7.7-8.8L1.6 2h6.8l4.6 6.1L18.9 2zm-2.3 18h1.8L7.4 3.8H5.5L16.6 20z"/></svg>Twitter / X</a>
      <a href="#" aria-label="LinkedIn"><svg viewBox="0 0 24 24"><path d="M4.98 3.5A2.5 2.5 0 1 0 5 8.5a2.5 2.5 0 0 0-.02-5zM3 9h4v12H3V9zm6 0h3.8v1.7h.05c.53-1 1.83-2.05 3.77-2.05 4.03 0 4.78 2.65 4.78 6.1V21H17.6v-5.4c0-1.29-.02-2.95-1.8-2.95-1.8 0-2.08 1.4-2.08 2.85V21H9V9z"/></svg>LinkedIn</a>
    </div>
    <div class="foot-base">
      <span>&copy; <span id="yr"></span> Anmol Pushjai Goel</span>
      <span>Founder &amp; CEO, Nuclear Edge &middot; Trustee, Bharat Governance Council</span>
    </div>
  </div>
</footer>


<script src="{{ asset('js/research.js') }}"></script>
</body>
</html>