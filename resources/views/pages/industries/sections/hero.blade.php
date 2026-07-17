@php
  $columns = collect([0, 1, 2])->map(function ($column) use ($industries) {
      $items = $industries->values()->filter(fn ($industry, $index) => $index % 3 === $column)->values();

      return $items->isNotEmpty() ? $items : $industries->values();
  });
@endphp
<section class="hero">
  <div class="wrap">
    <div class="hero-copy">
      <p class="eyebrow rev">{{ $content['eyebrow'] ?? '' }}</p>
      <h1 class="rev d1">{{ $content['title_first'] ?? '' }} <i>{{ $content['title_second'] ?? '' }}</i></h1>
      <div class="hero-rule rev d1"></div>
      <p class="hero-sub rev d2">{{ $content['description'] ?? '' }}</p>
      <div class="stats rev d3">
        @foreach ($content['stats'] ?? [] as $stat)
          <div><div class="n">{{ $stat['value'] ?? '' }}</div><div class="l">{{ $stat['label'] ?? '' }}</div></div>
        @endforeach
      </div>
    </div>

    <div class="float" aria-hidden="true">
      <div class="float-cols">
        @foreach ($columns as $columnIndex => $column)
          <div class="fsway s{{ $columnIndex + 1 }}">
            <div class="fcol {{ $columnIndex === 1 ? 'down' : 'up' }} {{ $columnIndex === 2 ? 'slow' : '' }}">
              @for ($copy = 0; $copy < 2; $copy++)
                @foreach ($column as $industry)
                  <a class="fi" href="#ind-{{ $industry->slug }}">
                    <span class="fn">{{ str_pad((string) ($industries->search(fn ($item) => $item->is($industry)) + 1), 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="ft">{{ $industry->name }}</span>
                  </a>
                @endforeach
              @endfor
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
