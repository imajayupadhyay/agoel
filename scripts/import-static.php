<?php

declare(strict_types=1);

$projectRoot = dirname(__DIR__);
$sourceRoot = dirname($projectRoot).'/html';

$pages = [
    'home' => [
        'source' => $sourceRoot.'/F1 Anmolweb-D.html',
        'view' => $projectRoot.'/resources/views/pages/home.blade.php',
        'css' => $projectRoot.'/public/css/home.css',
        'js' => $projectRoot.'/public/js/home.js',
        'route' => 'home',
        'og_image' => 'images/home/anmol-pushjai-goel-portrait.jpg',
        'embedded' => [
            'images/home/anmol-pushjai-goel-portrait.jpg',
            'images/home/nuclear-edge-industries.jpg',
            'images/home/anmol-goel-philanthropy.jpg',
            'images/home/ai-policy-review.jpg',
            'images/home/sociologist-entrepreneur.jpg',
            'images/home/nuclear-edge-news.jpg',
            'images/home/anmol-goel-books.jpg',
            'images/home/anmol-goel-writing.jpg',
            'images/home/meet-anmol-background.jpg',
            'images/home/anmol-pushjai-goel-meet.jpg',
        ],
        'links' => [
            'href="#top" class="brand"' => 'href="{{ route(\'home\') }}#top" class="brand"',
            'href="#industries"' => 'href="{{ route(\'industries\') }}"',
            'href="#philanthropy"' => 'href="{{ route(\'philanthropy\') }}"',
        ],
        'navigation' => <<<'HTML'
  <nav id="nav">
    <a href="{{ route('industries') }}">Industries</a>
    <a href="{{ route('philanthropy') }}">Philanthropy</a>
    <a href="{{ route('home') }}#news">In the News</a>
    <a href="{{ route('home') }}#books">Books</a>
    <a href="{{ route('home') }}#research">Research &amp; Publications</a>
    <a href="{{ route('home') }}#meet">About Anmol Goel</a>
  </nav>
HTML,
        'schema' => <<<'JSON'
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "WebSite",
      "@id": "{{ route('home') }}#website",
      "url": "{{ route('home') }}",
      "name": "Anmol Pushjai Goel",
      "inLanguage": "en-IN"
    },
    {
      "@type": "Person",
      "@id": "{{ route('home') }}#person",
      "name": "Anmol Pushjai Goel",
      "url": "{{ route('home') }}",
      "image": "{{ asset('images/home/anmol-pushjai-goel-portrait.jpg') }}",
      "jobTitle": "Founder & CEO, Nuclear Edge",
      "worksFor": {
        "@type": "Organization",
        "name": "Nuclear Edge"
      }
    }
  ]
}
JSON,
    ],
    'industries' => [
        'source' => $sourceRoot.'/F3_Anmolweb-Industries (1).html',
        'view' => $projectRoot.'/resources/views/pages/industries.blade.php',
        'css' => $projectRoot.'/public/css/industries.css',
        'js' => $projectRoot.'/public/js/industries.js',
        'route' => 'industries',
        'og_image' => 'images/industries/technology.jpg',
        'embedded' => [],
        'remote_assets' => [
            'https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=1600&q=60' => 'images/industries/hero-space.jpg',
            'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1400&q=60' => 'images/industries/creed-buildings.jpg',
            'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=1600&q=60' => 'images/industries/portfolio-data-centre.jpg',
            'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=1400&q=60' => 'images/industries/closing-policy.jpg',
            'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1100&q=70' => 'images/industries/technology.jpg',
            'https://images.unsplash.com/photo-1551434678-e076c223a692?auto=format&fit=crop&w=1100&q=70' => 'images/industries/it-services.jpg',
            'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=1100&q=70' => 'images/industries/data-centres.jpg',
            'https://images.unsplash.com/photo-1610552050890-fe99536c2615?auto=format&fit=crop&w=1100&q=70' => 'images/industries/petroleum.jpg',
            'https://images.unsplash.com/photo-1563636619-e9143da7973b?auto=format&fit=crop&w=1100&q=70' => 'images/industries/milk-dairy.jpg',
            'https://images.unsplash.com/photo-1519003722824-194d4455a60c?auto=format&fit=crop&w=1100&q=70' => 'images/industries/transportation-logistics.jpg',
            'https://images.unsplash.com/photo-1473773508845-188df298d2d1?auto=format&fit=crop&w=1100&q=70' => 'images/industries/timber-wood.jpg',
            'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=1100&q=70' => 'images/industries/education.jpg',
            'https://images.unsplash.com/photo-1501504905252-473c47e087f8?auto=format&fit=crop&w=1100&q=70' => 'images/industries/edtech.jpg',
            'https://images.unsplash.com/photo-1485846234645-a62644f84728?auto=format&fit=crop&w=1100&q=70' => 'images/industries/production-houses.jpg',
            'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?auto=format&fit=crop&w=1100&q=70' => 'images/industries/media-entertainment.jpg',
        ],
        'links' => [
            'href="F1_Anmolweb-D.html#philanthropy"' => 'href="{{ route(\'philanthropy\') }}"',
            'href="F1_Anmolweb-D.html#news"' => 'href="{{ route(\'home\') }}#news"',
            'href="F1_Anmolweb-D.html#books"' => 'href="{{ route(\'home\') }}#books"',
            'href="F1_Anmolweb-D.html#top"' => 'href="{{ route(\'home\') }}"',
            'href="F1_Anmolweb-D.html"' => 'href="{{ route(\'home\') }}"',
        ],
        'navigation' => <<<'HTML'
  <nav id="nav">
    <a href="#portfolio" class="active">Industries</a>
    <a href="{{ route('philanthropy') }}">Philanthropy</a>
    <a href="{{ route('home') }}#news">In the News</a>
    <a href="{{ route('home') }}#books">Books</a>
    <a href="{{ route('home') }}#research">Research &amp; Publications</a>
    <a href="{{ route('home') }}#meet">About Anmol Goel</a>
  </nav>
HTML,
        'schema' => <<<'JSON'
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "Industries — Anmol Pushjai Goel",
  "url": "{{ route('industries') }}",
  "description": "Where Anmol Pushjai Goel invests and why, across technology, infrastructure, energy, food, logistics, education and media.",
  "inLanguage": "en-IN",
  "about": {
    "@type": "Person",
    "name": "Anmol Pushjai Goel",
    "url": "{{ route('home') }}"
  }
}
JSON,
    ],
    'philanthropy' => [
        'source' => $sourceRoot.'/F3_Anmolweb-Philanthropy.html',
        'view' => $projectRoot.'/resources/views/pages/philanthropy.blade.php',
        'css' => $projectRoot.'/public/css/philanthropy.css',
        'js' => $projectRoot.'/public/js/philanthropy.js',
        'route' => 'philanthropy',
        'og_image' => 'images/philanthropy/anmol-pushjai-goel-philanthropy.jpg',
        'embedded' => [
            'images/philanthropy/philanthropy-hero-background.jpg',
            'images/philanthropy/anmol-pushjai-goel-philanthropy.jpg',
            'images/philanthropy/philanthropy-hero-background.jpg',
            'images/philanthropy/literacy-programme.jpg',
            'images/philanthropy/literacy-programme.jpg',
            'images/philanthropy/community-work.jpg',
            'images/philanthropy/community-work.jpg',
            'images/philanthropy/philanthropy-hero-background.jpg',
            'images/philanthropy/shri-mata-mansa-devi-shrine.jpg',
            'images/philanthropy/shri-mata-mansa-devi-shrine.jpg',
            'images/philanthropy/literacy-programme.jpg',
        ],
        'links' => [
            'href="F2_Anmolweb-Industries.html"' => 'href="{{ route(\'industries\') }}"',
            'href="F1_Anmolweb-D.html#news"' => 'href="{{ route(\'home\') }}#news"',
            'href="F1_Anmolweb-D.html#books"' => 'href="{{ route(\'home\') }}#books"',
            'href="F1_Anmolweb-D.html#top"' => 'href="{{ route(\'home\') }}"',
            'href="F1_Anmolweb-D.html"' => 'href="{{ route(\'home\') }}"',
            'href="#industries"' => 'href="{{ route(\'industries\') }}"',
        ],
        'navigation' => <<<'HTML'
  <nav id="nav">
    <a href="{{ route('industries') }}">Industries</a>
    <a href="#top" class="active">Philanthropy</a>
    <a href="{{ route('home') }}#news">In the News</a>
    <a href="{{ route('home') }}#books">Books</a>
    <a href="{{ route('home') }}#research">Research &amp; Publications</a>
    <a href="{{ route('home') }}#meet">About Anmol Goel</a>
  </nav>
HTML,
        'schema' => <<<'JSON'
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "Philanthropy & Governance — Anmol Pushjai Goel",
  "url": "{{ route('philanthropy') }}",
  "description": "The philanthropy and governance work of Anmol Pushjai Goel, focused on education, dignity, institutions and public service.",
  "inLanguage": "en-IN",
  "about": {
    "@type": "Person",
    "name": "Anmol Pushjai Goel",
    "url": "{{ route('home') }}"
  }
}
JSON,
    ],
];

foreach ([
    $projectRoot.'/resources/views/pages',
    $projectRoot.'/public/css',
    $projectRoot.'/public/js',
    $projectRoot.'/public/images/home',
    $projectRoot.'/public/images/philanthropy',
] as $directory) {
    if (! is_dir($directory) && ! mkdir($directory, 0755, true) && ! is_dir($directory)) {
        throw new RuntimeException("Unable to create directory: {$directory}");
    }
}

foreach ($pages as $pageName => $page) {
    $html = file_get_contents($page['source']);

    if ($html === false) {
        throw new RuntimeException("Unable to read source page: {$page['source']}");
    }

    $assetIndex = 0;
    $html = preg_replace_callback(
        '~data:image/([a-zA-Z0-9.+-]+);base64,([A-Za-z0-9+/=]+)~',
        function (array $matches) use (&$assetIndex, $page, $projectRoot): string {
            if (! isset($page['embedded'][$assetIndex])) {
                throw new RuntimeException('Embedded image mapping is incomplete.');
            }

            $relativePath = $page['embedded'][$assetIndex++];
            $destination = $projectRoot.'/public/'.$relativePath;
            $binary = base64_decode($matches[2], true);

            if ($binary === false) {
                throw new RuntimeException("Unable to decode image: {$relativePath}");
            }

            if (! is_file($destination)) {
                file_put_contents($destination, $binary);
            }

            return "{{ asset('{$relativePath}') }}";
        },
        $html,
    );

    if ($html === null || $assetIndex !== count($page['embedded'])) {
        throw new RuntimeException("Image extraction failed for {$pageName}.");
    }

    if (! preg_match('~<style>(.*?)</style>~s', $html, $styleMatch)) {
        throw new RuntimeException("Inline CSS not found for {$pageName}.");
    }

    if (! preg_match('~<script>(.*?)</script>~s', $html, $scriptMatch)) {
        throw new RuntimeException("Inline JavaScript not found for {$pageName}.");
    }

    $css = trim($styleMatch[1]).PHP_EOL;
    $javascript = trim($scriptMatch[1]).PHP_EOL;
    $html = str_replace($styleMatch[0], '', $html);
    $html = str_replace($scriptMatch[0], '', $html);

    foreach ($page['remote_assets'] ?? [] as $remoteUrl => $relativePath) {
        $html = str_replace($remoteUrl, "{{ asset('{$relativePath}') }}", $html);
        $javascript = str_replace($remoteUrl, "/{$relativePath}", $javascript);
    }

    foreach ($page['links'] as $from => $to) {
        $html = str_replace($from, $to, $html);
    }

    $html = preg_replace(
        '~<nav id="nav">.*?</nav>~s',
        $page['navigation'],
        $html,
        1,
    );

    $html = str_replace('<html lang="en">', '<html lang="en-IN">', $html);
    $html = preg_replace('~<img(?![^>]*\bdecoding=)~', '<img decoding="async"', $html);
    $html = preg_replace('~<img(?![^>]*\bloading=)~', '<img loading="lazy"', $html);
    $html = str_replace(
        '<img loading="lazy" decoding="async" src="{{ asset(\''.$page['og_image'].'\') }}"',
        '<img loading="eager" decoding="async" fetchpriority="high" src="{{ asset(\''.$page['og_image'].'\') }}"',
        $html,
    );

    preg_match('~<title>(.*?)</title>~s', $html, $titleMatch);
    preg_match('~<meta name="description" content="([^"]+)">~s', $html, $descriptionMatch);
    $title = trim($titleMatch[1] ?? 'Anmol Pushjai Goel');
    $attributeTitle = htmlspecialchars(
        htmlspecialchars_decode($title, ENT_QUOTES | ENT_HTML5),
        ENT_QUOTES | ENT_HTML5,
        'UTF-8',
    );
    $description = $descriptionMatch[1] ?? '';

    $seo = PHP_EOL.'<meta name="robots" content="index, follow, max-image-preview:large">'.PHP_EOL;
    $seo .= '<meta name="author" content="Anmol Pushjai Goel">'.PHP_EOL;
    $seo .= '<link rel="canonical" href="{{ route(\''.$page['route'].'\') }}">'.PHP_EOL;
    $seo .= '<meta property="og:type" content="website">'.PHP_EOL;
    $seo .= '<meta property="og:locale" content="en_IN">'.PHP_EOL;
    $seo .= '<meta property="og:site_name" content="Anmol Pushjai Goel">'.PHP_EOL;
    $seo .= '<meta property="og:title" content="'.$attributeTitle.'">'.PHP_EOL;
    $seo .= '<meta property="og:description" content="'.$description.'">'.PHP_EOL;
    $seo .= '<meta property="og:url" content="{{ route(\''.$page['route'].'\') }}">'.PHP_EOL;
    $seo .= '<meta property="og:image" content="{{ asset(\''.$page['og_image'].'\') }}">'.PHP_EOL;
    $seo .= '<meta name="twitter:card" content="summary_large_image">'.PHP_EOL;
    $seo .= '<meta name="twitter:title" content="'.$attributeTitle.'">'.PHP_EOL;
    $seo .= '<meta name="twitter:description" content="'.$description.'">'.PHP_EOL;
    $seo .= '<meta name="twitter:image" content="{{ asset(\''.$page['og_image'].'\') }}">'.PHP_EOL;
    $seo .= '<link rel="stylesheet" href="{{ asset(\'css/'.$pageName.'.css\') }}">'.PHP_EOL;
    $bladeSafeSchema = str_replace('"@context"', '"@@context"', $page['schema']);
    $seo .= '<script type="application/ld+json">'.PHP_EOL.$bladeSafeSchema.PHP_EOL.'</script>'.PHP_EOL;

    $html = str_replace('</head>', $seo.'</head>', $html);
    $html = preg_replace('~(<section\b[^>]*class="[^"]*\bhero\b)~', "<main id=\"main-content\">\n$1", $html, 1);
    $html = str_replace('<footer id="contact">', "</main>\n\n<footer id=\"contact\">", $html);
    $html = str_replace('</body>', '<script src="{{ asset(\'js/'.$pageName.'.js\') }}"></script>'.PHP_EOL.'</body>', $html);

    file_put_contents($page['css'], $css);
    file_put_contents($page['js'], $javascript);
    file_put_contents($page['view'], $html);
}

echo 'Imported '.count($pages)." static pages into Laravel.\n";
