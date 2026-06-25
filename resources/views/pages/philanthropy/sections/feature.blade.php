@php
  $image = $media->url($content['image'] ?? null);
  $reverse = ($content['layout'] ?? 'normal') === 'reverse';
  $bodyAfter = $content['body_after'] ?? '';
  $bodyAfterPrefix = $bodyAfter && ! preg_match('/^[,.:;!?—-]/u', $bodyAfter) ? ' ' : '';
@endphp
<section class="feat">
  <div class="wrap">
    <article class="frow {{ $reverse ? 'rev' : '' }}">
      <div class="frow-bg" @if($image) style="background-image:url('{{ $image }}')" @endif></div>
      <div class="frow-veil"></div>
      <div class="frow-media reveal">
        <div class="frame">
          @if ($image)
            <img loading="lazy" decoding="async" src="{{ $image }}" alt="{{ $content['image_alt'] ?? '' }}">
          @endif
        </div>
      </div>
      <div class="frow-copy reveal" data-d="1">
        <span class="tag">{{ $content['tag'] ?? '' }}</span>
        <h3>{{ $content['heading'] ?? '' }}</h3>
        <p class="body">{{ $content['body_before'] ?? '' }} @if($content['body_accent'] ?? null)<em>{{ $content['body_accent'] }}</em>@endif{{ $bodyAfterPrefix }}{{ $bodyAfter }}</p>
        <div class="pull"><p>{{ $content['pull_quote'] ?? '' }}</p></div>
      </div>
    </article>
  </div>
</section>
