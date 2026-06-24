<section id="news">
  <div class="news-head">
    <div>
      <div class="eyebrow reveal">{{ $content['eyebrow'] ?? '' }}</div>
      <h2 class="display-lg reveal" data-d="1">{{ $content['heading'] ?? '' }}</h2>
    </div>
    <p class="lead reveal" data-d="2">{{ $content['description'] ?? '' }}</p>
  </div>

  @if (! empty($content['ticker']))
    <div class="ticker reveal" data-d="2" aria-hidden="true">
      <div class="ticker-track">
        @foreach ([...$content['ticker'], ...$content['ticker']] as $item)
          <span class="ti"><b>{{ $item['outlet'] ?? '' }}</b>{{ $item['headline'] ?? '' }}</span>
        @endforeach
      </div>
    </div>
  @endif

  <div class="news-floats">
    @foreach ($content['cards'] ?? [] as $index => $card)
      <article class="ni reveal" @if ($index % 3) data-d="{{ $index % 3 }}" @endif>
        <div class="ni-float">
          <div class="ni-top">
            @if ($image = $media->url($card['image'] ?? null))
              <div class="ni-thumb"><img loading="lazy" decoding="async" src="{{ $image }}" alt="{{ $card['image_alt'] ?? '' }}"></div>
            @endif
            <div class="ni-outlet">{{ $card['outlet'] ?? '' }}<span class="kind">{{ $card['kind'] ?? '' }}</span></div>
          </div>
          <h3>{{ $card['title'] ?? '' }}</h3>
          <div class="ni-foot">
            <span class="ni-date">{{ $card['category'] ?? '' }}</span>
            <a class="ni-go" href="{{ $card['url'] ?: '#' }}">Read <span class="ar">↗</span></a>
          </div>
        </div>
      </article>
    @endforeach
  </div>
</section>
