<!DOCTYPE html>
<html lang="en-IN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
@include('partials.favicon')
<title>Page Not Found — Anmol Pushjai Goel</title>
<meta name="description" content="The requested page could not be found on the official Anmol Pushjai Goel website.">
<meta name="robots" content="noindex, follow, max-image-preview:large">
<meta name="author" content="Anmol Pushjai Goel">
<meta property="og:type" content="website">
<meta property="og:locale" content="en_IN">
<meta property="og:site_name" content="Anmol Pushjai Goel">
<meta property="og:title" content="Page Not Found — Anmol Pushjai Goel">
<meta property="og:description" content="The requested page could not be found on the official Anmol Pushjai Goel website.">
<meta property="og:url" content="{{ url()->current() }}">
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="Page Not Found — Anmol Pushjai Goel">
<meta name="twitter:description" content="The requested page could not be found on the official Anmol Pushjai Goel website.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&family=Montserrat:wght@200;300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset_version('css/error.css') }}">
</head>
<body>
@include('partials.site-header')

<main id="main-content" class="not-found">
  <section class="not-found-hero">
    <div class="not-found-veil" aria-hidden="true"></div>
    <div class="not-found-orbit" aria-hidden="true">
      <span></span><span></span><span></span>
    </div>

    <div class="not-found-content">
      <p class="eyebrow">404</p>
      <h1>Page not found.</h1>
      <p class="lede">The address may have changed, or the page may no longer be available. Use the site navigation or return to the home page.</p>

      <div class="not-found-actions" aria-label="Suggested destinations">
        <a class="primary-action" href="{{ route('home') }}">Return Home</a>
        <a href="{{ route('industries') }}">Industries</a>
        <a href="{{ route('philanthropy') }}">Philanthropy</a>
        <a href="{{ route('news') }}">In the News</a>
      </div>
    </div>
  </section>
</main>

<footer class="error-footer">
  <span>&copy; {{ now()->year }} Anmol Pushjai Goel. All rights reserved.</span>
  <a href="{{ route('about') }}">About Anmol Goel</a>
  <a class="foot-sitemap" href="{{ route('sitemap') }}">sitemap.xml</a>
</footer>
<script src="{{ asset_version('js/error.js') }}"></script>
</body>
</html>
