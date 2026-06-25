<!DOCTYPE html>
<html lang="en-IN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $page->seo_title }}</title>
<meta name="description" content="{{ $page->meta_description }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&family=Montserrat:wght@200;300;400;500;600&family=Caveat:wght@500&display=swap" rel="stylesheet">

<meta name="robots" content="index, follow, max-image-preview:large">
<meta name="author" content="Anmol Pushjai Goel">
<link rel="canonical" href="{{ route('philanthropy') }}">
<meta property="og:type" content="website">
<meta property="og:locale" content="en_IN">
<meta property="og:site_name" content="Anmol Pushjai Goel">
<meta property="og:title" content="{{ $page->seo_title }}">
<meta property="og:description" content="{{ $page->meta_description }}">
<meta property="og:url" content="{{ route('philanthropy') }}">
@if ($page->og_image)
<meta property="og:image" content="{{ $media->url($page->og_image) }}">
@endif
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $page->seo_title }}">
<meta name="twitter:description" content="{{ $page->meta_description }}">
@if ($page->og_image)
<meta name="twitter:image" content="{{ $media->url($page->og_image) }}">
@endif
<link rel="stylesheet" href="{{ asset('css/philanthropy.css') }}">
<script type="application/ld+json">
{!! json_encode([
    '@@context' => 'https://schema.org',
    '@type' => 'WebPage',
    'name' => $page->seo_title,
    'url' => route('philanthropy'),
    'description' => $page->meta_description,
    'inLanguage' => 'en-IN',
    'about' => [
        '@type' => 'Person',
        'name' => 'Anmol Pushjai Goel',
        'url' => route('home'),
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
</head>
<body>

<header id="hdr">
  <a href="{{ route('home') }}" class="brand"><span class="mono">A</span>Anmol Pushjai Goel</a>
  <nav id="nav">
    <a href="{{ route('industries') }}">Industries</a>
    <a href="#top" class="active">Philanthropy</a>
    <a href="{{ route('home') }}#news">In the News</a>
    <a href="{{ route('home') }}#books">Books</a>
    <a href="{{ route('home') }}#research">Research &amp; Publications</a>
    <a href="{{ route('home') }}#meet">About Anmol Goel</a>
  </nav>
  <button class="burger" id="burger" aria-label="Menu"><span></span><span></span><span></span></button>
</header>

<main id="main-content">
@foreach ($sections as $section)
  @continue($section->key === 'contact')
  @includeIf('pages.philanthropy.sections.'.$section->type, [
      'content' => $section->content ?? [],
  ])
@endforeach
</main>

@php
  $contact = $sections->firstWhere('key', 'contact');
@endphp
@if ($contact)
  @include('pages.philanthropy.sections.contact', [
      'content' => $contact->content ?? [],
  ])
@endif

<script src="{{ asset('js/philanthropy.js') }}"></script>
</body>
</html>
