<section class="sec" id="sectors">
  <div class="wrap">
    <div class="sec-head">
      <div>
        <p class="eyebrow rev">{{ $content['eyebrow'] ?? '' }}</p>
        <h2 class="rev d1">{{ $content['heading'] ?? '' }}</h2>
      </div>
      <p class="lede rev d2">{{ $content['description'] ?? '' }}</p>
    </div>
    <div class="sx-grid rev d1">
      @foreach ($industries as $index => $industry)
        <a class="sx" href="#ind-{{ $industry->slug }}">
          <span class="sn">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
          <span class="st">{{ $industry->name }}</span>
          <span class="sg">&rarr;</span>
        </a>
      @endforeach
    </div>
  </div>
</section>

<section class="wrap">
    @foreach ($industries as $index => $industry)
      @php
        $bodyAfterPrefix = $industry->body_after && ! preg_match('/^[,.:;!?—-]/u', $industry->body_after)
            ? ' '
            : '';
        $bgClass = match ($industry->slug) {
            'milk-dairy' => ' bg bg-milk',
            'transportation-logistics' => ' bg bg-ship',
            'timber-wood' => ' bg bg-wood',
            default => '',
        };
        $image = $industry->image ? $media->url($industry->image) : null;
      @endphp
      <article class="thesis{{ $bgClass }}"><span class="anchor" id="ind-{{ $industry->slug }}"></span>
        <div class="th-media rev">
          <div class="th-plate">
            @if ($image)
              <img src="{{ $image }}" alt="{{ $industry->image_alt ?: $industry->name }}" loading="lazy" decoding="async" onerror="this.style.display='none'">
            @endif
          </div>
        </div>
        <div class="rev d1">
          <div class="th-num">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</div>
          <p class="th-kick">{{ $industry->tag }}</p>
          <h3>{{ $industry->name }}</h3>
          <p>{{ $industry->body_before }} @if($industry->body_accent)<em>{{ $industry->body_accent }}</em>@endif{{ $bodyAfterPrefix }}{{ $industry->body_after }}</p>
          @if ($industry->pull_quote)
            <p class="th-pull">{{ $industry->pull_quote }}</p>
          @endif
          <div class="th-tags">
            @foreach ($industry->facts as $fact)
              <span>{{ $fact }}</span>
            @endforeach
          </div>
        </div>
      </article>
    @endforeach
</section>
