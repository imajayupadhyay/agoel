<section class="sec idea">
  <div class="wrap">
    <p class="eyebrow rev">{{ $content['eyebrow'] ?? 'The idea' }}</p>
    <p class="lead rev d1">
      {{ $content['statement_before'] ?? '' }}
      @if (! empty($content['statement_accent']))<i>{{ $content['statement_accent'] }}</i>@endif
      {{ $content['statement_after'] ?? '' }}
    </p>
    <div class="idea-grid rev d2">
      @foreach ($content['principles'] ?? [] as $principle)
        <div class="icell"><em>{{ $principle['title'] ?? '' }}</em><p>{{ $principle['description'] ?? '' }}</p></div>
      @endforeach
    </div>
  </div>
</section>
