@php
    $image = $media->url($content['image'] ?? 'images/home/redesign-hero-portrait.jpg');
@endphp

<section class="hero">
  <div class="wrap">
    <div class="hero-copy">
      <p class="eyebrow rev">{{ $content['eyebrow'] ?? '' }}</p>
      <h1 class="rev d1">{{ $content['title_first'] ?? '' }} <b>{{ $content['title_second'] ?? '' }}</b></h1>
      <p class="hero-sub rev d2">{!! $content['description'] ?? '' !!}</p>
      @if (! empty($content['description_secondary']))
        <p class="hero-sub sub-2 rev d2">{{ $content['description_secondary'] }}</p>
      @endif
      <div class="actions rev d3">
        @if (! empty($content['primary_button_label']))
          <a class="btn solid" href="{{ $content['primary_button_url'] ?? '#essays' }}">{{ $content['primary_button_label'] }}</a>
        @endif
        @if (! empty($content['secondary_button_label']))
          <a class="btn ghost" href="{{ $content['secondary_button_url'] ?? '#connect' }}">{{ $content['secondary_button_label'] }}</a>
        @endif
      </div>
    </div>
    <figure class="hero-plate rev d2">
      <div class="frame" data-parallax="0.06">
        @if ($image)
          <img loading="eager" decoding="async" fetchpriority="high" src="{{ $image }}" alt="{{ $content['image_alt'] ?? '' }}">
        @endif
      </div>
    </figure>
  </div>
</section>
