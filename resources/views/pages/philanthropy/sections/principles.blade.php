<section class="section principles">
  <div class="wrap">
    <div class="pr-head">
      <div class="eyebrow">{{ $content['eyebrow'] ?? '' }}</div>
      <h2 class="display-lg reveal">{{ $content['heading'] ?? '' }}</h2>
    </div>
    <div class="pr-grid">
      @foreach ($content['items'] ?? [] as $index => $item)
        @php
          $bodyAfter = $item['body_after'] ?? '';
          $bodyAfterPrefix = $bodyAfter && ! preg_match('/^[,.:;!?—-]/u', $bodyAfter) ? ' ' : '';
        @endphp
        <div class="pr reveal" @if($index) data-d="{{ min($index, 3) }}" @endif>
          <span class="no">{{ $item['number'] ?? str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
          <h3>{{ $item['heading'] ?? '' }}</h3>
          <p>{{ $item['body_before'] ?? '' }} @if($item['body_accent'] ?? null)<em>{{ $item['body_accent'] }}</em>@endif{{ $bodyAfterPrefix }}{{ $bodyAfter }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>
