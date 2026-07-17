@php
  $anchor = $content['anchor'] ?: 'custom-'.$section->id;
  $theme = ($content['theme'] ?? 'light') === 'dark' ? 'dark' : 'light';
@endphp
<section class="sec custom-home-section custom-home-section-{{ $theme }}" id="{{ $anchor }}">
  <div class="wrap custom-home-grid {{ empty($content['image']) ? 'custom-home-grid-copy-only' : '' }}">
    @if ($image = $media->url($content['image'] ?? null))
      <figure class="frame custom-home-media rev" data-parallax="0.04">
        <img loading="lazy" decoding="async" src="{{ $image }}" alt="{{ $content['image_alt'] ?? '' }}">
      </figure>
    @endif
    <div class="custom-home-copy rev d1">
      @if (! empty($content['eyebrow']))<p class="eyebrow">{{ $content['eyebrow'] }}</p>@endif
      <h2>{{ $content['heading'] ?? '' }}</h2>
      <p class="lede">{{ $content['body'] ?? '' }}</p>
      @if (! empty($content['button_label']))
        <a class="btn ghost custom-home-button" href="{{ $content['button_url'] ?: '#' }}">{{ $content['button_label'] }}</a>
      @endif
    </div>
  </div>
</section>
