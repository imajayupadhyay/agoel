<section class="sec press" id="press">
  <div class="wrap">
    <div class="press-head">
      <div>
        <p class="eyebrow rev">{{ $content['eyebrow'] ?? '' }}</p>
        <h2 class="rev d1">{{ $content['heading'] ?? '' }}</h2>
      </div>
      <div class="car-ctrl rev d1">
        <button id="prev" aria-label="Previous">&larr;</button>
        <button id="next" aria-label="Next">&rarr;</button>
      </div>
    </div>
    <div class="carousel rev d2">
      <div class="viewport" id="viewport">
        <div class="track" id="track">
          @foreach ($newsCoverage as $card)
            @php
              $url = $card['url'] ?? '#';
              $isExternal = filter_var($url, FILTER_VALIDATE_URL);
            @endphp
            <a class="slide" href="{{ $url ?: '#' }}" @if($isExternal) target="_blank" rel="noopener" @endif>
              <em>{{ $card['outlet'] ?? '' }}</em>
              <p>{{ $card['title'] ?? '' }}</p>
              <span class="rd">{{ $card['date'] ?? 'Read feature' }}</span>
            </a>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>
