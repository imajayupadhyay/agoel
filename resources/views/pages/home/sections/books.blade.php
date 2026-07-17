@php
    $image = $media->url($content['image'] ?? 'images/home/redesign-writing-office.jpg');
@endphp

<span id="books" class="anchor"></span>
<span id="research" class="anchor"></span>
<section class="sec essays" id="essays">
  <div class="wrap essay-grid">
    <div class="essay-sticky">
      <figure class="frame shelf-plate rev" data-parallax="0.05">
        @if ($image)
          <img loading="lazy" decoding="async" src="{{ $image }}" alt="{{ $content['image_alt'] ?? '' }}">
        @endif
      </figure>
      <p class="shelf-note rev d1">{{ $content['description'] ?? '' }}</p>
    </div>
    <div>
      <p class="eyebrow rev">{{ $content['eyebrow'] ?? '' }}</p>
      <h2 class="rev d1">{{ $content['heading_first'] ?? '' }} <b>{{ $content['heading_second'] ?? '' }}</b></h2>
      @if (! empty($content['lede']))
        <p class="lede rev d2">{{ $content['lede'] }}</p>
      @endif
      <div class="list">
        @foreach ($content['items'] ?? [] as $item)
          <a class="item rev" href="{{ $item['url'] ?: '#' }}">
            <span class="kick">{{ $item['category'] ?? '' }}</span>
            <h3>{{ trim(($item['title_first'] ?? '').' '.($item['title_second'] ?? '')) }}</h3>
            <p>{{ $item['meta'] ?? '' }}</p>
            <span class="go">{{ $item['link_label'] ?? 'Read' }}</span>
          </a>
        @endforeach
      </div>
    </div>
  </div>
</section>
