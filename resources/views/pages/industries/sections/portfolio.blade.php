@php
  $background = $media->url($content['background_image'] ?? null);
@endphp
<section class="section scene" id="portfolio">
  <div class="scene-bg" @if($background) style="background-image:url('{{ $background }}')" @endif role="img" aria-label="{{ $content['background_alt'] ?? '' }}"></div>
  <div class="scene-veil"></div>
  <div class="pf-head">
    <div>
      <div class="eyebrow">{{ $content['eyebrow'] ?? '' }}</div>
      <h2 class="display-lg">{{ $content['heading'] ?? '' }}</h2>
    </div>
    <p class="lead reveal" data-d="1">{{ $content['description'] ?? '' }}</p>
  </div>
  <div class="pf-grid" id="pfGrid">
    @foreach ($industries as $index => $industry)
      <a class="tile" href="#ind-{{ $industry->slug }}" data-fallback="{{ $industry->name }}">
        @if ($industry->image)
          <img src="{{ $media->url($industry->image) }}" alt="{{ $industry->image_alt ?: $industry->name }}" loading="lazy" onerror="this.style.display='none'">
        @endif
        <div class="ov">
          <span class="no">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
          <div><div class="nm">{{ $industry->name }}</div><span class="go">{{ $content['tile_link_label'] ?? '' }}</span></div>
        </div>
      </a>
    @endforeach
  </div>
</section>

<div class="ticker-band">
  <div class="ticker">
    <div class="ticker-track" id="ticker">
      @for ($copy = 0; $copy < 2; $copy++)
        @foreach ($industries as $index => $industry)
          <div class="ti"><b>{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</b> {{ $industry->name }}</div>
        @endforeach
      @endfor
    </div>
  </div>
</div>

<section class="rows">
  <div class="wrap" id="indWrap">
    @foreach ($industries as $index => $industry)
      @php
        $bodyAfterPrefix = $industry->body_after && ! preg_match('/^[,.:;!?—-]/u', $industry->body_after)
            ? ' '
            : '';
      @endphp
      <article class="ind {{ $index % 2 === 1 ? 'rev' : '' }}" id="ind-{{ $industry->slug }}">
        @if ($industry->image)
          <div class="ind-bg" style="background-image:url('{{ $media->url($industry->image) }}')"></div>
        @else
          <div class="ind-bg"></div>
        @endif
        <div class="ind-veil"></div>
        <div class="ind-main reveal">
          <div class="frame" data-fallback="{{ $industry->name }}">
            @if ($industry->image)
              <img src="{{ $media->url($industry->image) }}" alt="{{ $industry->image_alt ?: $industry->name }}" loading="lazy" onerror="this.style.display='none'">
            @endif
          </div>
          <span class="num">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div class="ind-copy reveal" data-d="1">
          <span class="tag">{{ $industry->tag }}</span>
          <h3>{{ $industry->name }}</h3>
          <p class="body">{{ $industry->body_before }} @if($industry->body_accent)<em>{{ $industry->body_accent }}</em>@endif{{ $bodyAfterPrefix }}{{ $industry->body_after }}</p>
          <div class="pull"><p>{{ $industry->pull_quote }}</p></div>
          <div class="facts">
            @foreach ($industry->facts as $fact)
              <span class="fchip">{{ $fact }}</span>
            @endforeach
          </div>
        </div>
      </article>
    @endforeach
  </div>
</section>
