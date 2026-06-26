@php
  $hero = $sections->get('hero');
  $index = $sections->get('index');
  $footer = $sections->get('footer');
  $heroContent = $hero?->content ?? [];
  $indexContent = $index?->content ?? [];
  $footerContent = $footer?->content ?? [];
  $coverage = collect($heroContent['coverage'] ?? []);
  $reelItems = $coverage->filter(fn ($item) => ($item['show_in_reel'] ?? '0') === '1' && filled($item['image'] ?? null))->values();
  $background = $media->url($heroContent['background_image'] ?? $page->og_image);
@endphp
<!DOCTYPE html>
<html lang="en-IN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $page->seo_title }}</title>
<meta name="description" content="{{ $page->meta_description }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&family=Montserrat:wght@200;300;400;500;600&display=swap" rel="stylesheet">

<meta name="robots" content="{{ $robotsMeta }}">
<meta name="author" content="Anmol Pushjai Goel">
<link rel="canonical" href="{{ $canonicalUrl }}">
<meta property="og:type" content="website">
<meta property="og:locale" content="en_IN">
<meta property="og:site_name" content="Anmol Pushjai Goel">
<meta property="og:title" content="{{ $page->seo_title }}">
<meta property="og:description" content="{{ $page->meta_description }}">
<meta property="og:url" content="{{ route('news') }}">
@if ($page->og_image)
<meta property="og:image" content="{{ $media->url($page->og_image) }}">
@endif
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $page->seo_title }}">
<meta name="twitter:description" content="{{ $page->meta_description }}">
@if ($page->og_image)
<meta name="twitter:image" content="{{ $media->url($page->og_image) }}">
@endif
<link rel="stylesheet" href="{{ asset('css/news.css') }}">
<script type="application/ld+json">{!! json_encode($schemaMarkup, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
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
    <a href="{{ route('about') }}">About Anmol Goel</a>
  </nav>
  <button class="burger" id="burger" aria-label="Menu"><span></span><span></span><span></span></button>
</header>

<main id="main-content">
@if ($hero)
<section class="hero" id="top">
  @if ($background)
    <div class="scene-bg" style="background-image:url('{{ $background }}')" role="img" aria-label="{{ $heroContent['background_alt'] ?? '' }}"></div>
  @else
    <div class="scene-bg"></div>
  @endif
  <div class="scene-veil"></div>
  <div class="stage">
    <div class="head">
      <div class="eyebrow center">{{ $heroContent['eyebrow'] ?? '' }}</div>
      <h1 id="h1"><span>{{ $heroContent['heading_before'] ?? '' }} <em>{{ $heroContent['heading_accent'] ?? '' }}</em></span></h1>
      <div class="subline" id="sub">{{ $heroContent['subline'] ?? '' }}</div>
    </div>
    <div class="reel" id="reel">
      <div class="reel-track" id="track">
        @foreach ($reelItems as $item)
          @php
            $url = $item['url'] ?? '#';
            $isExternal = filter_var($url, FILTER_VALIDATE_URL);
            $image = $media->url($item['image'] ?? null);
          @endphp
          <a class="ncard" href="{{ $url }}" @if($isExternal) target="_blank" rel="noopener" @endif>
            <div class="nclip">
              @if ($image)
                <img src="{{ $image }}" alt="{{ ($item['image_alt'] ?? '') ?: (($item['outlet'] ?? '').' — '.($item['title'] ?? '')) }}" loading="lazy">
              @endif
            </div>
            <div class="nbody">
              <div class="n-meta"><span class="n-out">{{ $item['outlet'] ?? '' }}</span><span class="n-date">{{ $item['date'] ?? '' }}</span></div>
              <h3>{{ $item['title'] ?? '' }}</h3>
              <span class="n-read">Read on {{ $item['outlet'] ?? 'source' }} <span class="ar">&rarr;</span></span>
            </div>
          </a>
        @endforeach
      </div>
    </div>
    @if (filled($heroContent['hint'] ?? null))
      <div class="hint" id="hint">{{ str_replace('·', ' ', $heroContent['hint']) }}</div>
    @endif
  </div>
</section>
@endif

@if ($index)
<section class="index">
  <div class="index-in">
    <div class="index-head">
      <div>
        <div class="eyebrow">{{ $indexContent['eyebrow'] ?? '' }}</div>
        <h2 class="reveal">{{ $indexContent['heading'] ?? '' }}</h2>
      </div>
      <div class="ct reveal" data-d="1" id="ct">{{ $coverage->count() }} {{ $indexContent['count_label'] ?? 'features' }}</div>
    </div>
    <div class="rows" id="rows">
      @foreach ($coverage as $item)
        @php
          $url = $item['url'] ?? '#';
          $isExternal = filter_var($url, FILTER_VALIDATE_URL);
        @endphp
        <a class="row" href="{{ $url }}" @if($isExternal) target="_blank" rel="noopener" @endif>
          <span class="r-date">{{ $item['date'] ?? '' }}</span>
          <span class="r-out">{{ $item['outlet'] ?? '' }}</span>
          <span class="r-title">{{ $item['title'] ?? '' }}</span>
          <span class="r-go">Read <span class="ar">&rarr;</span></span>
        </a>
      @endforeach
    </div>
    @if (filled($indexContent['syndication_text'] ?? null))
      <p class="syndicate reveal"><b>{{ $indexContent['syndication_label'] ?? '' }}</b> {{ $indexContent['syndication_text'] }}</p>
    @endif
  </div>
</section>
@endif
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
  </div>
</footer>
@endif

<script src="{{ asset('js/news.js') }}"></script>
</body>
</html>
