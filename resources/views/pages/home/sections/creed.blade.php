<section class="section creed">
  <div class="wrap">
    <div class="creed-statement reveal">
      {{ $content['statement'] ?? '' }}
      <em>{{ $content['accent'] ?? '' }}</em>
    </div>
    <div class="creed-meta reveal" data-d="1">
      @foreach ($content['highlights'] ?? [] as $highlight)
        <div class="item">
          <b>{{ $highlight['title'] ?? '' }}</b>{{ $highlight['description'] ?? '' }}
        </div>
      @endforeach
    </div>
  </div>
</section>
