@php
  $background = $media->url($content['background_image'] ?? null);
@endphp
<section class="section scene" id="close">
  <div class="scene-bg" @if($background) style="background-image:url('{{ $background }}')" @endif role="img" aria-label="{{ $content['background_alt'] ?? '' }}"></div>
  <div class="scene-veil"></div>
  <div class="wrap">
    <div class="eyebrow center reveal">{{ $content['eyebrow'] ?? '' }}</div>
    <h2 class="display-md reveal" data-d="1">{{ $content['heading'] ?? '' }}</h2>
    <p class="reveal" data-d="2">{{ $content['description'] ?? '' }}</p>
    @if (($content['button_label'] ?? '') && ($content['button_url'] ?? ''))
      <a class="btn reveal" data-d="3" href="{{ $content['button_url'] }}">{{ $content['button_label'] }} <span class="ar">&rarr;</span></a>
    @endif
  </div>
</section>
