<section id="meet">
  <div class="meet-grid">
    <div class="meet-visual" id="meetVisual">
      <div class="meet-rule"></div>
      <div class="layer l1">
        @if ($image = $media->url($content['image_background'] ?? null))
          <img loading="lazy" decoding="async" src="{{ $image }}" alt="" data-par="0.06">
        @endif
      </div>
      <div class="layer l2">
        @if ($image = $media->url($content['image_portrait'] ?? null))
          <img loading="lazy" decoding="async" src="{{ $image }}" alt="{{ $content['image_alt'] ?? '' }}" data-par="-0.04">
        @endif
      </div>
      <div class="meet-tag">{{ $content['image_tag'] ?? '' }}</div>
    </div>
    <div class="meet-copy" id="meetCopy">
      <div class="eyebrow">{{ $content['eyebrow'] ?? '' }}</div>
      <h2 class="display-lg">{{ $content['heading'] ?? '' }}</h2>
      @foreach ($content['paragraphs'] ?? [] as $paragraph)
        <p class="para"><span>{{ $paragraph['text'] ?? '' }}</span></p>
      @endforeach
      <div class="sig">{{ $content['signature'] ?? '' }}</div>
    </div>
  </div>
</section>
