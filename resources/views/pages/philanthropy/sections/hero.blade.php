@php
  $background = $media->url($content['background_image'] ?? null);
  $portrait = $media->url($content['portrait'] ?? null);
@endphp
<section class="hero scene" id="top">
  <div class="scene-bg" @if($background) style="background-image:url('{{ $background }}')" @endif role="img" aria-label="{{ $content['background_alt'] ?? '' }}"></div>
  <div class="scene-veil"></div>
  <div class="hero-grid">
    <div class="hero-copy">
      <div class="eyebrow reveal in">{{ $content['eyebrow'] ?? '' }}</div>
      <h1 class="hero-title display-xl" id="heroTitle">
        <span class="ln"><span>{{ $content['title_first'] ?? '' }}</span></span>
        <span class="ln"><span>{{ $content['title_second_before'] ?? '' }} <em>{{ $content['title_second_accent'] ?? '' }}</em></span></span>
      </h1>
      <p class="hero-line reveal" data-d="2">{{ $content['description'] ?? '' }}</p>
      <div class="hero-stats reveal" data-d="3">
        @foreach ($content['stats'] ?? [] as $stat)
          <div class="s"><b>{{ $stat['value'] ?? '' }}</b><span>{{ $stat['label'] ?? '' }}</span></div>
        @endforeach
      </div>
    </div>
    <div class="portrait-wrap reveal" data-d="1">
      <div class="portrait">
        @if ($portrait)
          <img loading="eager" decoding="async" fetchpriority="high" src="{{ $portrait }}" alt="{{ $content['portrait_alt'] ?? '' }}">
        @endif
      </div>
      <div class="portrait-cap">{{ $content['portrait_caption'] ?? '' }}</div>
    </div>
  </div>
  <div class="scrollcue"><span class="bar"></span>{{ $content['scroll_label'] ?? '' }}</div>
</section>
