<section class="section" id="books">
  <div class="wrap">
    <div class="split">
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
    <div class="shelf">
      @foreach ($content['items'] ?? [] as $index => $item)
        <div class="book reveal" @if ($index) data-d="{{ min($index, 2) }}" @endif>
          <div class="cover">
            <div class="small">{{ $item['category'] ?? '' }}</div>
            <div class="ttl">{{ $item['title_first'] ?? '' }}<br>{{ $item['title_second'] ?? '' }}</div>
          </div>
          <div class="meta">
            <div class="y">{{ $item['meta'] ?? '' }}</div>
            <a href="{{ $item['url'] ?: '#' }}">{{ $item['link_label'] ?? '' }}</a>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
