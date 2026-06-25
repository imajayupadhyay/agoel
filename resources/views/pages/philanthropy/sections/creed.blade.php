@php
  $background = $media->url($content['background_image'] ?? null);
@endphp
<section class="section creed scene">
  <div class="scene-bg" @if($background) style="background-image:url('{{ $background }}')" @endif role="img" aria-label="{{ $content['background_alt'] ?? '' }}"></div>
  <div class="scene-veil"></div>
  <div class="wrap">
    <div class="creed-statement reveal">
      {{ $content['statement_before'] ?? '' }}
      <em>{{ $content['statement_accent'] ?? '' }}</em>
      {{ $content['statement_after'] ?? '' }}
    </div>
    <div class="creed-meta reveal" data-d="1">
      @foreach ($content['principles'] ?? [] as $principle)
        <div class="item"><b>{{ $principle['title'] ?? '' }}</b>{{ $principle['description'] ?? '' }}</div>
      @endforeach
    </div>
  </div>
</section>
