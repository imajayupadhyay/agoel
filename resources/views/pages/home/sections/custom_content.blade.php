@php
  $anchor = $content['anchor'] ?: 'custom-'.$section->id;
  $theme = ($content['theme'] ?? 'light') === 'dark' ? 'dark' : 'light';
@endphp
<section class="section custom-home-section custom-home-section-{{ $theme }}" id="{{ $anchor }}">
  <div class="wrap custom-home-grid {{ empty($content['image']) ? 'custom-home-grid-copy-only' : '' }}">
    @if ($image = $media->url($content['image'] ?? null))
      <div class="media reveal">
        <img loading="lazy" decoding="async" src="{{ $image }}" alt="{{ $content['image_alt'] ?? '' }}">
      </div>
    @endif
    <div class="block-head reveal" data-d="1">
      @if (! empty($content['eyebrow']))<div class="eyebrow">{{ $content['eyebrow'] }}</div>@endif
      <h2 class="display-lg">{{ $content['heading'] ?? '' }}</h2>
      <p class="lead custom-home-copy">{{ $content['body'] ?? '' }}</p>
      @if (! empty($content['button_label']))
        <a class="custom-home-button" href="{{ $content['button_url'] ?: '#' }}">{{ $content['button_label'] }}</a>
      @endif
    </div>
  </div>
</section>
