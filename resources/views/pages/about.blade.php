@php
  $hero = $sections->get('hero');
  $profile = $sections->get('profile');
  $voice = $sections->get('voice');
  $footer = $sections->get('footer');
  $heroContent = $hero?->content ?? [];
  $profileContent = $profile?->content ?? [];
  $voiceContent = $voice?->content ?? [];
  $footerContent = $footer?->content ?? [];
  $heroBackground = $media->url($heroContent['background_image'] ?? $page->og_image);
  $secondaryBackground = $media->url($heroContent['secondary_background_image'] ?? null);
  $socialImage = $media->url($page->og_image);
  $recognitions = collect($heroContent['recognitions'] ?? [])
      ->map(fn ($item) => [
          'cat' => $item['category'] ?? '',
          'name' => $item['name'] ?? '',
          'title' => $item['title'] ?? '',
          'q' => $item['quote'] ?? '',
      ])
      ->filter(fn ($item) => filled($item['name']))
      ->values();
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
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&family=Montserrat:wght@200;300;400;500;600&display=swap" rel="stylesheet">

<meta name="robots" content="{{ $robotsMeta }}">
<meta name="author" content="Anmol Pushjai Goel">
<link rel="canonical" href="{{ $canonicalUrl }}">
<meta property="og:type" content="website">
<meta property="og:locale" content="en_IN">
<meta property="og:site_name" content="Anmol Pushjai Goel">
<meta property="og:title" content="{{ $page->seo_title }}">
<meta property="og:description" content="{{ $page->meta_description }}">
<meta property="og:url" content="{{ route('about') }}">
@if ($socialImage)
<meta property="og:image" content="{{ $socialImage }}">
@endif
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $page->seo_title }}">
<meta name="twitter:description" content="{{ $page->meta_description }}">
@if ($socialImage)
<meta name="twitter:image" content="{{ $socialImage }}">
@endif
<link rel="stylesheet" href="{{ asset_version('css/about.css') }}">
<script type="application/ld+json">{!! json_encode($schemaMarkup, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
</head>
<body>

@include('partials.site-header')

<main id="main-content">
@if ($hero)
<section class="praise" id="top">
  <div class="praise-bg" aria-hidden="true">
    @if ($heroBackground)
      <div class="pl pl1" id="bg1" style="background-image:url('{{ $heroBackground }}')"></div>
    @endif
    @if ($secondaryBackground)
      <div class="pl pl2" id="bg2" style="background-image:url('{{ $secondaryBackground }}')"></div>
    @endif
  </div>
  <div class="praise-veil" aria-hidden="true"></div>

  <div class="praise-inner">
    <div class="praise-head">
      <div class="eyebrow reveal in">{{ $heroContent['eyebrow'] ?? '' }}</div>
      <h1 class="display-lg reveal" data-d="1">{{ $heroContent['heading_line_one'] ?? '' }}<br>{{ $heroContent['heading_line_two'] ?? '' }}</h1>
      <p class="lede reveal" data-d="2">{{ $heroContent['lede'] ?? '' }}</p>
      <div class="praise-roles reveal" data-d="3">
        @foreach ($heroContent['roles'] ?? [] as $role)
          @if (filled($role['label'] ?? null))
            <span>{{ $role['label'] }}</span>
          @endif
        @endforeach
      </div>
    </div>

    <div class="praise-stream" id="stream"></div>
  </div>

  @if (filled($heroContent['scrollcue'] ?? null))
    <div class="scrollcue"><span class="bar"></span>{{ $heroContent['scrollcue'] }}</div>
  @endif
</section>
@endif

@if ($profile)
<section class="section" id="about">
  <div class="wrap about-grid">
    <div class="about-head reveal">
      <div class="eyebrow">{{ $profileContent['eyebrow'] ?? '' }}</div>
      <h2 class="display-lg">{{ $profileContent['heading_line_one'] ?? '' }}<br>{{ $profileContent['heading_line_two'] ?? '' }}</h2>
      <div class="about-meta">
        @foreach ($profileContent['metadata'] ?? [] as $item)
          @if (filled($item['label'] ?? null) || filled($item['value'] ?? null))
            <div class="row"><span class="k">{{ $item['label'] ?? '' }}</span><span class="v">{{ $item['value'] ?? '' }}</span></div>
          @endif
        @endforeach
      </div>
    </div>
    <div class="about-body reveal" data-d="1">
      @foreach ($profileContent['paragraphs'] ?? [] as $paragraph)
        <p>{{ $paragraph['before'] ?? '' }}@if (filled($paragraph['emphasis'] ?? null))<span class="em">{{ $paragraph['emphasis'] }}</span>@endif{{ $paragraph['after'] ?? '' }}</p>
      @endforeach

      @if (filled($profileContent['signature'] ?? null))
        <div class="sig">{{ $profileContent['signature'] }}</div>
      @endif
    </div>
  </div>
</section>
@endif

@if ($voice)
<section id="voice">
  <div class="voice-clouds" aria-hidden="true">
    <span class="cloud c1"></span><span class="cloud c2"></span><span class="cloud c3"></span>
  </div>
  <div class="voice-veil" aria-hidden="true"></div>

  <div class="voice-wrap">
    <div class="eyebrow center">{{ $voiceContent['eyebrow'] ?? '' }}</div>
    <div class="voice-mark">&ldquo;</div>
    <div class="voice-stage" id="voiceStage">
      @foreach ($voiceContent['quotes'] ?? [] as $quote)
        @if (filled($quote['text'] ?? null))
          <div class="voice-q @if ($loop->first) on @endif"><p>{{ $quote['text'] }}</p></div>
        @endif
      @endforeach
    </div>
    <div class="voice-dots" id="voiceDots"></div>
    <div class="voice-by">{{ $voiceContent['byline'] ?? '' }}</div>
  </div>
</section>
@endif
</main>

@if ($footer)
<footer>
  <div class="foot-grid">
    <div>
      <div class="eyebrow">{{ $footerContent['eyebrow'] ?? '' }}</div>
      @if (filled($footerContent['email'] ?? null))
        <a class="big" href="mailto:{{ $footerContent['email'] }}" style="display:inline-block;margin-top:14px">{{ $footerContent['email'] }}</a>
      @endif
      <div class="socials">
        @foreach ($footerContent['socials'] ?? [] as $social)
          @if (filled($social['label'] ?? null))
            <a href="{{ $social['url'] ?? '#' }}">{{ $social['label'] }}</a>
          @endif
        @endforeach
      </div>
    </div>
    @if (filled($footerContent['back_label'] ?? null))
      <a href="#top" class="eyebrow">{{ $footerContent['back_label'] }}</a>
    @endif
  </div>
  <div class="foot-base">
    <span>&copy; <span id="yr"></span> {{ $footerContent['copyright_name'] ?? '' }}</span>
    <span>{{ $footerContent['role_line'] ?? '' }}</span>
    <a class="foot-sitemap" href="{{ route('sitemap') }}">sitemap.xml</a>
  </div>
</footer>
@endif

<script id="about-praise-data" type="application/json">{!! json_encode($recognitions, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!}</script>
<script src="{{ asset_version('js/about.js') }}"></script>
</body>
</html>
