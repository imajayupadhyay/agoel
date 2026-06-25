@php
  $background = $media->url($content['background_image'] ?? null);
  $columns = collect([0, 1, 2])->map(function ($column) use ($industries) {
      $items = $industries->values()->filter(fn ($industry, $index) => $index % 3 === $column)->values();

      return $items->isNotEmpty() ? $items : $industries->values();
  });
@endphp
<section class="hero scene" id="top">
  <div class="scene-bg" @if($background) style="background-image:url('{{ $background }}')" @endif role="img" aria-label="{{ $content['background_alt'] ?? '' }}"></div>
  <div class="scene-veil"></div>
  <div class="hero-grid">
    <div class="hero-copy">
      <div class="eyebrow reveal in">{{ $content['eyebrow'] ?? '' }}</div>
      <h1 class="hero-title display-xl" id="heroTitle">
        <span class="ln"><span>{{ $content['title_first'] ?? '' }}</span></span>
        <span class="ln"><span><em>{{ $content['title_second'] ?? '' }}</em></span></span>
      </h1>
      <p class="hero-line reveal" data-d="2">{{ $content['description'] ?? '' }}</p>
      <div class="hero-stats reveal" data-d="3">
        @foreach ($content['stats'] ?? [] as $stat)
          <div class="s"><b>{{ $stat['value'] ?? '' }}</b><span>{{ $stat['label'] ?? '' }}</span></div>
        @endforeach
      </div>
    </div>

    <div class="roller" id="roller" aria-hidden="true">
      @foreach ($columns as $column)
        <div class="roll-col">
          <div class="roll-track">
            @for ($copy = 0; $copy < 2; $copy++)
              @foreach ($column as $industry)
                <div class="chip">
                  <span class="no">{{ str_pad((string) ($industries->search(fn ($item) => $item->is($industry)) + 1), 2, '0', STR_PAD_LEFT) }}</span>
                  <span class="nm">{{ $industry->name }}</span>
                </div>
              @endforeach
            @endfor
          </div>
        </div>
      @endforeach
    </div>
  </div>
  <div class="scrollcue"><span class="bar"></span>{{ $content['scroll_label'] ?? '' }}</div>
</section>
