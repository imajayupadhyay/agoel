@php
    $heroContent = $sections->firstWhere('type', 'hero')?->content ?? config('homepage.sections.hero.content');
    $contactSection = $sections->firstWhere('type', 'contact');
    $contactContent = $contactSection?->content ?? config('homepage.sections.contact.content');
    $socialImage = $media->url($page->og_image ?: ($heroContent['image'] ?? null));
    $structuredData = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'WebSite',
                '@id' => route('home').'#website',
                'url' => route('home'),
                'name' => $page->title,
                'inLanguage' => 'en-IN',
            ],
            [
                '@type' => 'Person',
                '@id' => route('home').'#person',
                'name' => 'Anmol Pushjai Goel',
                'url' => route('home'),
                'image' => $media->url($heroContent['image'] ?? null),
                'jobTitle' => $heroContent['roles'][0]['label'] ?? 'Founder & CEO, Nuclear Edge',
                'worksFor' => [
                    '@type' => 'Organization',
                    'name' => 'Nuclear Edge',
                ],
            ],
        ],
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
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&family=Montserrat:wght@200;300;400;500;600&display=swap" rel="stylesheet">
<meta name="robots" content="index, follow, max-image-preview:large">
<meta name="author" content="Anmol Pushjai Goel">
<link rel="canonical" href="{{ route('home') }}">
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
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
</head>
<body>

<header id="hdr">
  <a href="{{ route('home') }}#top" class="brand"><span class="mono">A</span>Anmol Pushjai Goel</a>
  <nav id="nav">
    <a href="{{ route('industries') }}">Industries</a>
    <a href="{{ route('philanthropy') }}">Philanthropy</a>
    <a href="{{ route('home') }}#news">In the News</a>
    <a href="{{ route('home') }}#books">Books</a>
    <a href="{{ route('home') }}#research">Research &amp; Publications</a>
    <a href="{{ route('home') }}#meet">About Anmol Goel</a>
  </nav>
  <button class="burger" id="burger" aria-label="Menu"><span></span><span></span><span></span></button>
</header>

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

<script src="{{ asset('js/home.js') }}"></script>
</body>
</html>
