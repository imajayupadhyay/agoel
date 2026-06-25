@php
  $background = $media->url($content['background_image'] ?? null);
@endphp
<section class="section orgs scene">
  <div class="scene-bg" @if($background) style="background-image:url('{{ $background }}')" @endif role="img" aria-label="{{ $content['background_alt'] ?? '' }}"></div>
  <div class="scene-veil"></div>
  <div class="orgs-head">
    <div>
      <div class="eyebrow">{{ $content['eyebrow'] ?? '' }}</div>
      <h2 class="display-lg">{{ $content['heading'] ?? '' }}</h2>
    </div>
    <p class="lead reveal" data-d="1">{{ $content['description'] ?? '' }}</p>
  </div>
  <div class="orgs-grid">
    @foreach ($content['items'] ?? [] as $index => $item)
      @php
        $image = $media->url($item['image'] ?? null);
      @endphp
      <article class="org reveal" @if($index) data-d="{{ min($index, 3) }}" @endif>
        <div class="org-media">
          @if ($image)
            <img loading="lazy" decoding="async" src="{{ $image }}" alt="{{ $item['image_alt'] ?? '' }}">
          @else
            <div class="org-mono">
              <div class="glyph">{{ $item['monogram'] ?? '' }}</div>
              <span>{{ $item['monogram_label'] ?? '' }}</span>
            </div>
          @endif
        </div>
        <div class="org-body">
          <span class="role">{{ $item['role'] ?? '' }}</span>
          <h3>{{ $item['name'] ?? '' }}</h3>
          <div class="loc">{{ $item['location'] ?? '' }}</div>
          <p>{{ $item['description'] ?? '' }}</p>
        </div>
      </article>
    @endforeach
  </div>
</section>
