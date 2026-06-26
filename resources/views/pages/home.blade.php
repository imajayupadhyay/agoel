@php
    $heroContent = $sections->firstWhere('type', 'hero')?->content ?? config('homepage.sections.hero.content');
    $contactSection = $sections->firstWhere('type', 'contact');
    $contactContent = $contactSection?->content ?? config('homepage.sections.contact.content');
    $socialImage = $media->url($page->og_image ?: ($heroContent['image'] ?? null));
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
<meta property="og:url" content="{{ route('home') }}">
@if ($socialImage)<meta property="og:image" content="{{ $socialImage }}">@endif
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $page->seo_title }}">
<meta name="twitter:description" content="{{ $page->meta_description }}">
@if ($socialImage)<meta name="twitter:image" content="{{ $socialImage }}">@endif
<link rel="stylesheet" href="{{ asset_version('css/home.css') }}">
<script type="application/ld+json">{!! json_encode($schemaMarkup, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
</head>
<body>

@include('partials.site-header')

<main id="main-content">
  @foreach ($sections as $section)
    @continue($section->type === 'contact')
    @includeIf('pages.home.sections.'.$section->type, [
        'section' => $section,
        'content' => $section->content ?? [],
        'media' => $media,
    ])
  @endforeach
</main>

@if ($contactSection)
  @include('pages.home.sections.contact', [
      'section' => $contactSection,
      'content' => $contactContent,
      'media' => $media,
  ])
@endif

<script src="{{ asset_version('js/home.js') }}"></script>
</body>
</html>
