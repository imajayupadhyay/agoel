@php
  $index = $sections->get('index');
  $lens = $sections->get('lens');
  $interlude = $sections->get('interlude');
  $fields = $sections->get('fields');
  $footer = $sections->get('footer');
  $indexContent = $index?->content ?? [];
  $lensContent = $lens?->content ?? [];
  $interludeContent = $interlude?->content ?? [];
  $fieldsContent = $fields?->content ?? [];
  $footerContent = $footer?->content ?? [];
  $indexBackground = $media->url($indexContent['background_image'] ?? $page->og_image);
  $lensImage = $media->url($lensContent['image'] ?? null);
  $interludeBackground = $media->url($interludeContent['background_image'] ?? null);
  $footerBackground = $media->url($footerContent['background_image'] ?? null);
  $clientData = [
      'categories' => $categories
          ->map(fn ($category) => [
              'label' => $category->label,
              'slug' => $category->slug,
          ])
          ->values(),
      'publications' => $publications
          ->map(fn ($publication) => [
              'cat' => $publication->category?->slug,
              'catLabel' => $publication->category?->label,
              'title' => $publication->title,
              'venue' => $publication->venue,
              'year' => $publication->year,
              'status' => $publication->status,
              'snip' => $publication->summary,
              'tags' => $publication->tags ?? [],
              'link' => $publication->url,
          ])
          ->values(),
      'fields' => collect($fieldsContent['items'] ?? [])
          ->map(fn ($item) => [
              'img' => $media->url($item['image'] ?? null),
              'alt' => $item['image_alt'] ?? ($item['who'] ?? ''),
              'cap' => $item['figure_caption'] ?? '',
              'name' => $item['name'] ?? '',
              'who' => $item['who'] ?? '',
              'ln' => $item['description'] ?? '',
          ])
          ->values(),
      'terminalLines' => collect($indexContent['terminal_lines'] ?? [])
          ->pluck('text')
          ->filter()
          ->values(),
  ];
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
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&family=Montserrat:wght@200;300;400;500;600&family=Cormorant+Garamond:ital,wght@0,500;1,500&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

<meta name="robots" content="{{ $robotsMeta }}">
<meta name="author" content="Anmol Pushjai Goel">
<link rel="canonical" href="{{ $canonicalUrl }}">
<meta property="og:type" content="website">
<meta property="og:locale" content="en_IN">
<meta property="og:site_name" content="Anmol Pushjai Goel">
<meta property="og:title" content="{{ $page->seo_title }}">
<meta property="og:description" content="{{ $page->meta_description }}">
<meta property="og:url" content="{{ route('research') }}">
@if ($page->og_image)
<meta property="og:image" content="{{ $media->url($page->og_image) }}">
@endif
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $page->seo_title }}">
<meta name="twitter:description" content="{{ $page->meta_description }}">
@if ($page->og_image)
<meta name="twitter:image" content="{{ $media->url($page->og_image) }}">
@endif
<link rel="stylesheet" href="{{ asset('css/research.css') }}">
<script type="application/ld+json">{!! json_encode($schemaMarkup, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
</head>
<body>

@include('partials.site-header')

<main id="main-content">
@if ($index)
<section class="index" id="top">
  @if ($indexBackground)
    <div class="idx-bg" style="background-image:url('{{ $indexBackground }}')" role="img" aria-label="{{ $indexContent['background_alt'] ?? '' }}"></div>
  @else
    <div class="idx-bg"></div>
  @endif
  <canvas id="net"></canvas>
  <div class="idx-veil"></div>
  <div class="idx-in">
    <div class="idx-head">
      <div class="kick">{{ $indexContent['kick'] ?? '' }}</div>
      <h1 id="h1"><span>{{ $indexContent['heading'] ?? '' }}</span></h1>
      <div class="terminal" id="term"><span id="termtxt"></span><span class="cur"></span></div>
    </div>
    <div class="filters" id="filters"></div>
    <div class="publist" id="publist"></div>
    <p class="pubs-note">{{ $indexContent['note'] ?? '' }}</p>
    <div class="wave"><svg id="wave" viewBox="0 0 2880 40" preserveAspectRatio="none"><path id="wavePath" fill="none" stroke="rgba(169,143,91,.5)" stroke-width="1.4"/></svg></div>
  </div>
</section>
@endif

@if ($lens)
<section class="section lens">
  <div class="wrap">
    @if ($lensImage)
      <div class="fig reveal">
        <span class="scn"></span>
        <span class="cap">{{ $lensContent['figure_caption'] ?? '' }}</span>
        <img loading="lazy" decoding="async" src="{{ $lensImage }}" alt="{{ $lensContent['image_alt'] ?? '' }}">
      </div>
    @endif
    <div class="lens-copy">
      <div class="eyebrow reveal">{{ $lensContent['eyebrow'] ?? '' }}</div>
      <h2 class="reveal" data-d="1">{{ $lensContent['heading'] ?? '' }}</h2>
      <p class="reveal" data-d="1">{{ $lensContent['description'] ?? '' }}</p>
      <div class="creds reveal" data-d="2">
        @foreach ($lensContent['credentials'] ?? [] as $credential)
          <div><span>{{ $credential['label'] ?? '' }}</span> {{ $credential['text'] ?? '' }}</div>
        @endforeach
      </div>
    </div>
  </div>
</section>
@endif

@if ($interlude)
<section class="interlude">
  @if ($interludeBackground)
    <div class="ibg" style="background-image:url('{{ $interludeBackground }}')" role="img" aria-label="{{ $interludeContent['background_alt'] ?? '' }}"></div>
  @else
    <div class="ibg"></div>
  @endif
  <div class="iq">
    <div class="eyebrow center">{{ $interludeContent['eyebrow'] ?? '' }}</div>
    <blockquote>{{ $interludeContent['quote'] ?? '' }}</blockquote>
    <div class="src">{{ $interludeContent['source'] ?? '' }}</div>
  </div>
</section>
@endif

@if ($fields)
<section class="section fields" id="fields">
  <div class="wrap">
    <div class="fields-head">
      <svg class="orbit" viewBox="0 0 40 40"><circle cx="20" cy="20" r="13" fill="none" stroke="rgba(169,143,91,.4)" stroke-width="1"/><g class="dot"><circle cx="33" cy="20" r="2.4" fill="#A98F5B"/></g><circle cx="20" cy="20" r="2" fill="#C7B589"/></svg>
      <div class="eyebrow center reveal">{{ $fieldsContent['eyebrow'] ?? '' }}</div>
      <h2 class="reveal" data-d="1">{{ $fieldsContent['heading'] ?? '' }}</h2>
    </div>
    <div class="flist" id="flist"></div>
  </div>
</section>
@endif
</main>

@if ($footer)
<footer id="sub">
  @if ($footerBackground)
    <div class="foot-bg" style="background-image:url('{{ $footerBackground }}')" role="img" aria-label="{{ $footerContent['background_alt'] ?? '' }}"></div>
  @else
    <div class="foot-bg"></div>
  @endif
  <div class="foot-in">
    <div class="foot-brand reveal">{{ $footerContent['brand'] ?? '' }}</div>
    <div class="foot-tag reveal" data-d="1">{{ $footerContent['tagline'] ?? '' }}</div>
    <div class="socials reveal" data-d="1">
      @foreach ($footerContent['links'] ?? [] as $link)
        @if (filled($link['label'] ?? null))
          <a href="{{ $link['url'] ?? '#' }}">{{ $link['label'] }}</a>
        @endif
      @endforeach
    </div>
    <div class="foot-base">
      <span>&copy; <span id="yr"></span> {{ $footerContent['copyright_name'] ?? '' }}</span>
      <span>{{ $footerContent['role_line'] ?? '' }}</span>
    </div>
  </div>
</footer>
@endif

<script>
window.RESEARCH_PAGE_DATA = @json($clientData);
</script>
<script src="{{ asset('js/research.js') }}"></script>
</body>
</html>
