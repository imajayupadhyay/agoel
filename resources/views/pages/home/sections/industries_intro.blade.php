@php
    $image = $media->url($content['image'] ?? 'images/home/redesign-company-band.jpg');
@endphp

<span id="industries" class="anchor"></span>
<section class="band" id="company">
  <div class="band-bg" style="--wall:url('{{ $image }}')"></div>
  <div class="wrap">
    <div class="band-inner">
      <p class="eyebrow rev">{{ $content['eyebrow'] ?? '' }}</p>
      <h2 class="rev d1">{{ $content['heading_first'] ?? '' }} <b>{{ $content['heading_second'] ?? '' }}</b></h2>
      <p class="lede rev d2">{{ $content['description'] ?? '' }}</p>
      <div class="band-list rev d3">
        @foreach ($content['facts'] ?? [] as $fact)
          <div><span>{{ $fact['label'] ?? '' }}</span><em>{{ $fact['value'] ?? '' }}</em></div>
        @endforeach
      </div>
    </div>
  </div>
</section>
