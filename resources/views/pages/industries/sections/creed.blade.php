<section class="sec phil" id="philosophy">
  <div class="wrap">
    <p class="eyebrow rev">The Philosophy</p>
    <h2 class="rev d1">{{ $content['statement_before'] ?? '' }} <i>{{ $content['statement_accent'] ?? '' }}</i> {{ $content['statement_after'] ?? '' }}</h2>
    <p class="phil-lede rev d2">{{ $content['lede'] ?? 'Four questions settle almost everything: what we truly understand, what protects the earnings, who runs the place, and what the price is asking us to believe.' }}</p>
    <div class="phil-grid rev d2">
      @foreach ($content['principles'] ?? [] as $principle)
        <div class="pill"><em>{{ $principle['title'] ?? '' }}</em><p>{{ $principle['description'] ?? '' }}</p></div>
      @endforeach
    </div>
  </div>
</section>
