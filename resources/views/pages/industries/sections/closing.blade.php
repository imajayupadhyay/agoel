<section class="sec thread" id="thread">
  <div class="wrap">
    <p class="eyebrow rev">{{ $content['eyebrow'] ?? '' }}</p>
    <h2 class="rev d1">{{ $content['heading'] ?? '' }}</h2>
    <p class="rev d2">{{ $content['description'] ?? '' }}</p>
    @if (($content['button_label'] ?? '') && ($content['button_url'] ?? ''))
      <a class="cta rev d2" href="{{ $content['button_url'] }}">{{ $content['button_label'] }}</a>
    @endif
  </div>
</section>
