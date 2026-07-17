@php
  $isHeritage = ($section->key ?? '') === 'heritage';
  $image = $media->url($content['image'] ?? 'images/philanthropy/redesign-education.jpg');
  $bodyAfter = $content['body_after'] ?? '';
  $bodyAfterPrefix = $bodyAfter && ! preg_match('/^[,.:;!?—-]/u', $bodyAfter) ? ' ' : '';
@endphp
@if ($isHeritage)
  <section class="sec heritage">
    <div class="wrap">
      <p class="eyebrow rev">{{ $content['tag'] ?? '' }}</p>
      <h2 class="rev d1">{{ $content['heading'] ?? '' }} @if(! empty($content['heading_accent']))<i>{{ $content['heading_accent'] }}</i>@endif</h2>
      <p class="rev d2">{{ $content['body_before'] ?? '' }} @if($content['body_accent'] ?? null)<em>{{ $content['body_accent'] }}</em>@endif{{ $bodyAfterPrefix }}{{ $bodyAfter }}</p>
      @if (! empty($content['pull_quote']))
        <p class="pull rev d2">{{ $content['pull_quote'] }}</p>
      @endif
    </div>
  </section>
@else
  <section class="sec why">
    <div class="wrap why-grid">
      <div class="plate rev" data-para>
        <div class="frame">
          @if ($image)
            <img loading="lazy" decoding="async" src="{{ $image }}" alt="{{ $content['image_alt'] ?? '' }}">
          @endif
        </div>
        <p class="cap">{{ $content['image_caption'] ?? $content['tag'] ?? '' }}</p>
      </div>
      <div class="rev d1">
        <p class="eyebrow">{{ $content['tag'] ?? '' }}</p>
        <h2>{{ $content['heading'] ?? '' }} @if(! empty($content['heading_accent']))<i>{{ $content['heading_accent'] }}</i>@endif</h2>
        <p>{{ $content['body_before'] ?? '' }} @if($content['body_accent'] ?? null)<em>{{ $content['body_accent'] }}</em>@endif{{ $bodyAfterPrefix }}{{ $bodyAfter }}</p>
        @if (! empty($content['pull_quote']))
          <p class="pull">{{ $content['pull_quote'] }}</p>
        @endif
      </div>
    </div>
  </section>
@endif
