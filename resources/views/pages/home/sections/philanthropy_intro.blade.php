<section class="section" id="philanthropy">
  <div class="wrap split rev">
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
    </div>
  </div>
  <div class="wrap" style="margin-top:clamp(40px,6vw,70px)">
    <div class="pillars reveal">
      @foreach ($content['pillars'] ?? [] as $pillar)
        <div class="cell">
          <div class="ic">{{ $pillar['number'] ?? '' }}</div>
          <h3>{{ $pillar['title'] ?? '' }}</h3>
          <p>{{ $pillar['description'] ?? '' }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>
