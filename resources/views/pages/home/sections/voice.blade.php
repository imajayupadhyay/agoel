@php
    $image = $media->url($content['image'] ?? 'images/home/redesign-voice-portrait.png');
@endphp

<span id="about" class="anchor"></span>
<section class="sec voice" id="voice">
  <div class="wrap">
    <figure class="voice-portrait rev" aria-hidden="false">
      <div class="frame">
        @if ($image)
          <img loading="lazy" decoding="async" src="{{ $image }}" alt="{{ $content['image_alt'] ?? '' }}">
        @endif
      </div>
    </figure>
    <div class="voice-copy rev d1">
      <p class="eyebrow rev">{{ $content['eyebrow'] ?? '' }}</p>
      <div class="quote-stage rev d1" id="quoteStage" aria-live="polite">
        @foreach ($content['quotes'] ?? [] as $index => $quote)
          <blockquote class="qslide {{ $index === 0 ? 'is-active' : '' }}">
            <p class="quote">{{ $quote['text'] ?? '' }} <span>{{ $quote['accent'] ?? '' }}</span></p>
            @if (! empty($quote['subtext']))
              <p class="quote-sub">{{ $quote['subtext'] }}</p>
            @endif
          </blockquote>
        @endforeach
      </div>
      <p class="sig rev d2">{{ $content['author'] ?? '' }}</p>
      <div class="qdots rev d2" id="qdots" role="tablist" aria-label="Quotes"></div>
    </div>
  </div>
</section>
