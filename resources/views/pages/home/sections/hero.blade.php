<section class="hero" id="top">
  <div class="hero-grid">
    <div class="hero-copy">
      <div class="eyebrow reveal in">{{ $content['eyebrow'] ?? '' }}</div>
      <h1 class="hero-name display-xl" id="heroName">
        <span class="ln"><span>{{ $content['title_first'] ?? '' }}</span></span>
        <span class="ln"><span>{{ $content['title_second'] ?? '' }}</span></span>
      </h1>
      <div class="roles reveal" data-d="2">
        @foreach ($content['roles'] ?? [] as $role)
          <span>{{ $role['label'] ?? '' }}</span>
        @endforeach
      </div>
      <p class="hero-line reveal" data-d="3">{{ $content['description'] ?? '' }}</p>
    </div>
    <div class="hero-portrait reveal" data-d="2">
      <div class="frame">
        @if ($image = $media->url($content['image'] ?? null))
          <img loading="eager" decoding="async" fetchpriority="high" src="{{ $image }}" alt="{{ $content['image_alt'] ?? '' }}">
        @endif
      </div>
    </div>
  </div>
  <div class="scrollcue"><span class="bar"></span>{{ $content['scroll_label'] ?? '' }}</div>
</section>
