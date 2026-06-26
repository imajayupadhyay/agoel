@php
  $hero = $sections->get('hero');
  $libraryBand = $sections->get('library_band');
  $library = $sections->get('library');
  $reviewsBand = $sections->get('reviews_band');
  $reviews = $sections->get('reviews');
  $closing = $sections->get('closing');
  $footer = $sections->get('footer');
  $heroContent = $hero?->content ?? [];
  $libraryBandContent = $libraryBand?->content ?? [];
  $libraryContent = $library?->content ?? [];
  $reviewsBandContent = $reviewsBand?->content ?? [];
  $reviewsContent = $reviews?->content ?? [];
  $closingContent = $closing?->content ?? [];
  $footerContent = $footer?->content ?? [];
  $heroBackground = $media->url($heroContent['background_image'] ?? $page->og_image);
  $libraryBandBackground = $media->url($libraryBandContent['background_image'] ?? null);
  $reviewsBandBackground = $media->url($reviewsBandContent['background_image'] ?? null);
  $closingImage = $media->url($closingContent['image'] ?? null);
  $clientData = [
      'books' => $libraryContent['books'] ?? [],
      'reviews' => $reviewsContent['reviews'] ?? [],
      'reviewKicker' => $reviewsContent['modal_kicker'] ?? 'Book Review · Anmol Pushjai Goel',
      'downloadLabel' => $reviewsContent['download_label'] ?? 'Download the original · public domain',
      'reviewSignature' => $reviewsContent['signature'] ?? '— Anmol Pushjai Goel',
  ];
@endphp
<!DOCTYPE html>
<html lang="en-IN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
@include('partials.favicon')
<title>{{ $page->seo_title }}</title>
<meta name="description" content="{{ $page->meta_description }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&family=Montserrat:wght@200;300;400;500;600&family=Cormorant+Garamond:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet">

<meta name="robots" content="{{ $robotsMeta }}">
<meta name="author" content="Anmol Pushjai Goel">
<link rel="canonical" href="{{ $canonicalUrl }}">
<meta property="og:type" content="website">
<meta property="og:locale" content="en_IN">
<meta property="og:site_name" content="Anmol Pushjai Goel">
<meta property="og:title" content="{{ $page->seo_title }}">
<meta property="og:description" content="{{ $page->meta_description }}">
<meta property="og:url" content="{{ route('books') }}">
@if ($page->og_image)
<meta property="og:image" content="{{ $media->url($page->og_image) }}">
@endif
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $page->seo_title }}">
<meta name="twitter:description" content="{{ $page->meta_description }}">
@if ($page->og_image)
<meta name="twitter:image" content="{{ $media->url($page->og_image) }}">
@endif
<link rel="stylesheet" href="{{ asset('css/books.css') }}">
<script type="application/ld+json">{!! json_encode($schemaMarkup, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
</head>
<body>

@include('partials.site-header')

<main id="main-content">
@if ($hero)
<section class="hero" id="top">
  @if ($heroBackground)
    <div class="hero-bg" style="background-image:url('{{ $heroBackground }}')" role="img" aria-label="{{ $heroContent['background_alt'] ?? '' }}"></div>
  @else
    <div class="hero-bg"></div>
  @endif
  <div class="hero-veil"></div>
  <div class="hero-in">
    <div class="eyebrow center">{{ $heroContent['eyebrow'] ?? '' }}</div>
    <h1>{{ $heroContent['heading'] ?? '' }}</h1>
    <div class="manifesto" id="manifesto">
      @foreach ($heroContent['paragraphs'] ?? [] as $paragraph)
        <p>{{ $paragraph['text'] ?? '' }}</p>
      @endforeach
      <div class="sign">{{ $heroContent['signature'] ?? '' }}</div>
    </div>
  </div>
</section>
@endif

@if ($libraryBand)
<div class="band">
  @if ($libraryBandBackground)
    <div class="band-bg" style="background-image:url('{{ $libraryBandBackground }}')" role="img" aria-label="{{ $libraryBandContent['background_alt'] ?? '' }}"></div>
  @else
    <div class="band-bg"></div>
  @endif
  <div class="band-label">
    <div class="eyebrow center reveal">{{ $libraryBandContent['eyebrow'] ?? '' }}</div>
    <h2 class="reveal" data-d="1">{{ $libraryBandContent['heading'] ?? '' }}</h2>
  </div>
</div>
@endif

@if ($library)
<section class="section" id="library">
  <div class="wrap">
    <div class="lib-head">
      <div class="eyebrow center">{{ $libraryContent['eyebrow'] ?? '' }}</div>
      <h2 class="reveal">{{ $libraryContent['heading'] ?? '' }}</h2>
      <p class="reveal" data-d="1">{{ $libraryContent['description'] ?? '' }}</p>
    </div>

    <div class="toggle reveal" data-d="1">
      <button id="tgYear" class="on" onclick="setView('year')">{{ $libraryContent['annual_label'] ?? 'Annual Lists' }}</button>
      <button id="tgAZ" onclick="setView('az')">{{ $libraryContent['shelf_label'] ?? 'The Shelf · A-Z' }}</button>
    </div>

    <div class="view on" id="viewYear">
      <div class="years" id="years"></div>
      <div class="shelfwrap">
        <div class="shelf" id="shelf"></div>
        <div class="shelf-base"></div>
        <div class="yr-meta" id="yrMeta"></div>
      </div>
    </div>

    <div class="view" id="viewAZ">
      <div class="aznav" id="azNav"></div>
      <div id="azBody"></div>
      <div class="libnote">{{ $libraryContent['az_note'] ?? '' }}</div>
    </div>
  </div>
</section>
@endif

@if ($reviewsBand)
<div class="band">
  @if ($reviewsBandBackground)
    <div class="band-bg" style="background-image:url('{{ $reviewsBandBackground }}')" role="img" aria-label="{{ $reviewsBandContent['background_alt'] ?? '' }}"></div>
  @else
    <div class="band-bg"></div>
  @endif
  <div class="band-label">
    <div class="eyebrow center reveal">{{ $reviewsBandContent['eyebrow'] ?? '' }}</div>
    <h2 class="reveal" data-d="1">{{ $reviewsBandContent['heading'] ?? '' }}</h2>
  </div>
</div>
@endif

@if ($reviews)
<section class="section rev" id="reviews">
  <div class="wrap">
    <div class="lib-head">
      <div class="eyebrow center">{{ $reviewsContent['eyebrow'] ?? '' }}</div>
      <h2 class="reveal">{{ $reviewsContent['heading'] ?? '' }}</h2>
      <p class="reveal" data-d="1">{{ $reviewsContent['description'] ?? '' }}</p>
    </div>
    <div class="rev-grid" id="revGrid"></div>
    <p class="rev-note reveal">{{ $reviewsContent['note'] ?? '' }}</p>
  </div>
</section>
@endif

@if ($closing)
<section class="close" id="closing">
  <div class="wrap" style="padding-left:var(--pad);padding-right:var(--pad)">
    @if ($closingImage)
      <div class="close-photo reveal"><img loading="lazy" decoding="async" src="{{ $closingImage }}" alt="{{ $closingContent['image_alt'] ?? '' }}"></div>
    @endif
    <div class="close-q">
      <div class="mark reveal">&ldquo;</div>
      <blockquote class="reveal" data-d="1">{{ $closingContent['quote'] ?? '' }}</blockquote>
      <div class="sign reveal" data-d="2">{{ $closingContent['signature'] ?? '' }}</div>
    </div>
  </div>
</section>
@endif

<div class="rev-modal" id="revModal" aria-hidden="true" role="dialog" aria-modal="true">
  <div class="rm-panel">
    <button class="rm-close" id="revClose" aria-label="Close review">&times;</button>
    <div class="rm-scroll" id="mScroll">
      <div class="rm-inner">
        <div class="rm-kicker" id="mKicker"></div>
        <h2 class="rm-title" id="mTitle"></h2>
        <div class="rm-meta" id="mMeta"></div>
        <a class="rm-dl" id="mDownload" target="_blank" rel="noopener"><span id="mDownloadLabel"></span> &darr;</a>
        <div class="rm-body" id="mBody"></div>
        <div class="rm-sign" id="mSignature"></div>
      </div>
    </div>
  </div>
</div>
</main>

@if ($footer)
<footer id="contact">
  <div class="foot-grid">
    <div class="foot-l">
      <div class="eyebrow">{{ $footerContent['eyebrow'] ?? '' }}</div>
      @if (filled($footerContent['email'] ?? null))
        <a class="big" href="mailto:{{ $footerContent['email'] }}">{{ $footerContent['email'] }}</a>
      @endif
    </div>
    <div class="foot-r">
      @if (filled($footerContent['linkedin_label'] ?? null))
        <a href="{{ $footerContent['linkedin_url'] ?? '#' }}">{{ $footerContent['linkedin_label'] }}</a>
      @endif
      @if (filled($footerContent['twitter_label'] ?? null))
        <a href="{{ $footerContent['twitter_url'] ?? '#' }}">{{ $footerContent['twitter_label'] }}</a>
      @endif
      @if (filled($footerContent['home_label'] ?? null))
        <a href="{{ route('home') }}">{{ $footerContent['home_label'] }}</a>
      @endif
    </div>
  </div>
  <div class="foot-base">
    <span>&copy; <span id="yr"></span> {{ $footerContent['copyright_name'] ?? '' }}</span>
    <span>{{ $footerContent['role_line'] ?? '' }}</span>
    <a class="foot-sitemap" href="{{ route('sitemap') }}">sitemap.xml</a>
  </div>
</footer>
@endif

<script>
window.BOOKS_PAGE_DATA = @json($clientData);
</script>
<script src="{{ asset('js/books.js') }}"></script>
</body>
</html>
