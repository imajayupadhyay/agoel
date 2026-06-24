<section class="section" id="research">
  <div class="wrap">
    <div class="split">
      <div class="block-head reveal" data-d="1" style="order:1">
        <div class="eyebrow">{{ $content['eyebrow'] ?? '' }}</div>
        <h2 class="display-lg">{{ $content['heading_first'] ?? '' }}<br>{{ $content['heading_second'] ?? '' }}</h2>
        <p class="lead">{{ $content['description'] ?? '' }}</p>
      </div>
      <div class="media reveal" style="order:2">
        @if ($image = $media->url($content['image'] ?? null))
          <img loading="lazy" decoding="async" src="{{ $image }}" alt="{{ $content['image_alt'] ?? '' }}">
        @endif
        <span class="tag">{{ $content['image_tag'] ?? '' }}</span>
      </div>
    </div>
    <div class="pubs">
      @foreach ($content['items'] ?? [] as $item)
        <a class="pub reveal" href="{{ $item['url'] ?: '#' }}">
          <span class="yr">{{ $item['tag'] ?? '' }}</span>
          <span class="body">
            <h3>{{ $item['title'] ?? '' }}</h3>
            <span class="src">{{ $item['source'] ?? '' }}</span>
          </span>
          <span class="act">{{ $item['link_label'] ?? '' }} <span class="ar">↗</span></span>
        </a>
      @endforeach
    </div>
  </div>
</section>
