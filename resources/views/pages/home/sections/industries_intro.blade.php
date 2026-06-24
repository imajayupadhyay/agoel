<section class="section" id="industries">
  <div class="wrap split">
    <div class="media reveal">
      @if ($image = $media->url($content['image'] ?? null))
        <img loading="lazy" decoding="async" src="{{ $image }}" alt="{{ $content['image_alt'] ?? '' }}">
      @endif
      <span class="tag">{{ $content['image_tag'] ?? '' }}</span>
    </div>
    <div class="block-head reveal" data-d="1">
      <div class="eyebrow">{{ $content['eyebrow'] ?? '' }}</div>
      <h2 class="display-lg">{{ $content['heading_first'] ?? '' }}<br>{{ $content['heading_second'] ?? '' }}</h2>
      <p class="lead">{{ $content['description'] ?? '' }}</p>
      <div class="ledger">
        @foreach ($content['facts'] ?? [] as $fact)
          <div class="row">
            <span class="k">{{ $fact['label'] ?? '' }}</span>
            <span class="v">{{ $fact['value'] ?? '' }}</span>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
