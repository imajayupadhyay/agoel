@php
  $portrait = $media->url($content['portrait'] ?? 'images/philanthropy/redesign-hero-portrait.jpg');
@endphp
<section class="p-hero">
  <div class="p-hero-bg" aria-hidden="true"><div class="kb"></div></div>
  <div class="p-hero-wash" aria-hidden="true"></div>
  <div class="wrap">
    <div class="p-hero-copy">
      <p class="eyebrow rev">{{ $content['eyebrow'] ?? '' }}</p>
      <h1 class="rev d1">
        {{ $content['title_first'] ?? '' }}
        @if (! empty($content['title_second_before']))
          {{ $content['title_second_before'] }}
        @endif
        <i>{{ $content['title_second_accent'] ?? '' }}</i>
      </h1>
      <div class="hero-rule rev d1"></div>
      <p class="hero-sub rev d2">{{ $content['description'] ?? '' }}</p>
      <div class="pillars rev d3">
        @foreach ($content['stats'] ?? [] as $stat)
          <div><div class="pk">{{ $stat['value'] ?? '' }}</div><div class="pv">{{ $stat['label'] ?? '' }}</div></div>
        @endforeach
      </div>
    </div>
    <div class="hero-portrait plate rev d2" data-para>
      <div class="frame">
        @if ($portrait)
          <img loading="eager" decoding="async" fetchpriority="high" src="{{ $portrait }}" alt="{{ $content['portrait_alt'] ?? '' }}">
        @endif
      </div>
      <p class="cap">{{ $content['portrait_caption'] ?? '' }}</p>
    </div>
  </div>
</section>
