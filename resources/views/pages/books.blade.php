<!DOCTYPE html>
<html lang="en-IN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>The Library — Anmol Pushjai Goel</title>
<meta name="description" content="The personal library & reading manifesto of Anmol Pushjai Goel — annual reading lists from 2022, an A–Z shelf, and book reviews.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&family=Montserrat:wght@200;300;400;500;600&family=Cormorant+Garamond:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet">


<meta name="robots" content="index, follow, max-image-preview:large">
<meta name="author" content="Anmol Pushjai Goel">
<link rel="canonical" href="{{ route('books') }}">
<meta property="og:type" content="website">
<meta property="og:locale" content="en_IN">
<meta property="og:site_name" content="Anmol Pushjai Goel">
<meta property="og:title" content="The Library — Anmol Pushjai Goel">
<meta property="og:description" content="The personal library & reading manifesto of Anmol Pushjai Goel — annual reading lists from 2022, an A–Z shelf, and book reviews.">
<meta property="og:url" content="{{ route('books') }}">
<meta property="og:image" content="{{ asset('images/books/hero-library.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="The Library — Anmol Pushjai Goel">
<meta name="twitter:description" content="The personal library & reading manifesto of Anmol Pushjai Goel — annual reading lists from 2022, an A–Z shelf, and book reviews.">
<meta name="twitter:image" content="{{ asset('images/books/hero-library.jpg') }}">
<link rel="stylesheet" href="{{ asset('css/books.css') }}">
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "CollectionPage",
  "name": "The Library — Anmol Pushjai Goel",
  "url": "{{ route('books') }}",
  "description": "The personal library and reading manifesto of Anmol Pushjai Goel — annual reading lists from 2022, an A–Z shelf, and book reviews.",
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
    <a href="#top" class="active">Books</a>
    <a href="{{ route('research') }}">Research &amp; Publications</a>
    <a href="{{ route('home') }}#meet">About Anmol Goel</a>
  </nav>
  <button class="burger" id="burger" aria-label="Menu"><span></span><span></span><span></span></button>
</header>

<!-- HERO MANIFESTO -->
<main id="main-content">
<section class="hero" id="top">
  <div class="hero-bg" style="background-image:url('{{ asset('images/books/hero-library.jpg') }}')"></div>
  <div class="hero-veil"></div>
  <div class="hero-in">
    <div class="eyebrow center">The Library &middot; On Reading</div>
    <h1>A real book should hurt.</h1>
    <div class="manifesto" id="manifesto">
      <p>It should walk into your skull, find the dumbest, most comfortable thing you believe, and break its legs. If you finished a book and you&rsquo;re the same person, you didn&rsquo;t read it, you <em>babysat</em> it. You held it and gave it back unharmed.</p>
      <p>Read less. Read slower. Read things that make you sick. Read one book like it owes you money instead of forty like they&rsquo;re snacks.</p>
      <p>Here I&rsquo;m sharing my personal library. I&rsquo;ll try to put up reviews of all the books I can.</p>
      <div class="sign">&mdash; Anmol Pushjai Goel</div>
    </div>
  </div>
</section>

<!-- BAND: MY LIBRARY -->
<div class="band">
  <div class="band-bg" style="background-image:url('{{ asset('images/books/library-shelves.jpg') }}')"></div>
  <div class="band-label">
    <div class="eyebrow center reveal">Annual lists from 2022</div>
    <h2 class="reveal" data-d="1">My Library</h2>
  </div>
</div>

<!-- MY LIBRARY -->
<section class="section" id="library">
  <div class="wrap">
    <div class="lib-head">
      <div class="eyebrow center">Personal library</div>
      <h2 class="reveal">Read like it owes you money.</h2>
      <p class="reveal" data-d="1">An annual reading list from 2022 onwards &mdash; and the whole shelf, A to Z. Thousands of books, added over time, each one read like it meant something.</p>
    </div>

    <div class="toggle reveal" data-d="1">
      <button id="tgYear" class="on" onclick="setView('year')">Annual Lists</button>
      <button id="tgAZ" onclick="setView('az')">The Shelf · A–Z</button>
    </div>

    <!-- ANNUAL -->
    <div class="view on" id="viewYear">
      <div class="years" id="years"></div>
      <div class="shelfwrap">
        <div class="shelf" id="shelf"></div>
        <div class="shelf-base"></div>
        <div class="yr-meta" id="yrMeta"></div>
      </div>
    </div>

    <!-- A-Z -->
    <div class="view" id="viewAZ">
      <div class="aznav" id="azNav"></div>
      <div id="azBody"></div>
      <div class="libnote">A living shelf &mdash; this is a first selection; the full library grows here over time.</div>
    </div>
  </div>
</section>

<!-- BAND: REVIEWS -->
<div class="band">
  <div class="band-bg" style="background-image:url('{{ asset('images/books/bookstore-shelves.jpg') }}')"></div>
  <div class="band-label">
    <div class="eyebrow center reveal">In his own words</div>
    <h2 class="reveal" data-d="1">Book Reviews</h2>
  </div>
</div>

<!-- REVIEWS -->
<section class="section rev" id="reviews">
  <div class="wrap">
    <div class="lib-head">
      <div class="eyebrow center">Book Reviews by Anmol Pushjai Goel</div>
      <h2 class="reveal">One book at a time.</h2>
      <p class="reveal" data-d="1">Long-form, unsentimental reviews &mdash; what the book broke, what it built, and whether it was worth the bruise. Ten so far, in his own hand.</p>
    </div>
    <div class="rev-grid" id="revGrid"></div>
    <p class="rev-note reveal">Ten reviews and counting &mdash; tap any cover to read it in full.</p>
  </div>
</section>

<!-- CLOSING -->
<section class="close" id="closing">
  <div class="wrap" style="padding-left:var(--pad);padding-right:var(--pad)">
    <div class="close-photo reveal"><img loading="lazy" decoding="async" src="{{ asset('images/books/anmol-goel-library-portrait.jpg') }}" alt="Anmol Pushjai Goel"></div>
    <div class="close-q">
      <div class="mark reveal">&ldquo;</div>
      <blockquote class="reveal" data-d="1">If you finished a book and you&rsquo;re the same person, you didn&rsquo;t read it, you babysat it. You held it and gave it back unharmed.</blockquote>
      <div class="sign reveal" data-d="2">&mdash; Anmol Pushjai Goel</div>
    </div>
  </div>
</section>

<!-- REVIEW READER -->
<div class="rev-modal" id="revModal" aria-hidden="true" role="dialog" aria-modal="true">
  <div class="rm-panel">
    <button class="rm-close" id="revClose" aria-label="Close review">&times;</button>
    <div class="rm-scroll" id="mScroll">
      <div class="rm-inner">
        <div class="rm-kicker">Book Review &middot; Anmol Pushjai Goel</div>
        <h2 class="rm-title" id="mTitle"></h2>
        <div class="rm-meta" id="mMeta"></div>
        <a class="rm-dl" id="mDownload" target="_blank" rel="noopener"><span>Download the original &middot; public domain</span> &darr;</a>
        <div class="rm-body" id="mBody"></div>
        <div class="rm-sign">&mdash; Anmol Pushjai Goel</div>
      </div>
    </div>
  </div>
</div>

<!-- FOOTER -->
</main>

<footer id="contact">
  <div class="foot-grid">
    <div class="foot-l">
      <div class="eyebrow">Reading &amp; recommendations</div>
      <a class="big" href="mailto:library@anmolpushjaigoel.com">library@anmolpushjaigoel.com</a>
    </div>
    <div class="foot-r">
      <a href="#">LinkedIn</a><a href="#">X / Twitter</a><a href="{{ route('home') }}">Back to Home</a>
    </div>
  </div>
  <div class="foot-base">
    <span>&copy; <span id="yr"></span> Anmol Pushjai Goel. All rights reserved.</span>
    <span>Entrepreneur &middot; Investor &middot; Reader</span>
  </div>
</footer>


<script src="{{ asset('js/books.js') }}"></script>
</body>
</html>