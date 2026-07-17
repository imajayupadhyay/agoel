<section class="sec principles">
  <div class="wrap">
    <p class="eyebrow rev">{{ $content['eyebrow'] ?? '' }}</p>
    <h2 class="rev d1">{{ $content['heading'] ?? '' }}</h2>
    <div class="pr-grid rev d2">
      @foreach ($content['items'] ?? [] as $index => $item)
        @php
          $bodyAfter = $item['body_after'] ?? '';
          $bodyAfterPrefix = $bodyAfter && ! preg_match('/^[,.:;!?—-]/u', $bodyAfter) ? ' ' : '';
        @endphp
        <div class="prin">
          <div class="rn">{{ $item['number'] ?? str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</div>
          <h3>{{ $item['heading'] ?? '' }} @if(! empty($item['heading_accent']))<i>{{ $item['heading_accent'] }}</i>@endif</h3>
          <p>{{ $item['body_before'] ?? '' }} @if($item['body_accent'] ?? null)<em>{{ $item['body_accent'] }}</em>@endif{{ $bodyAfterPrefix }}{{ $bodyAfter }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>
