<span id="philanthropy" class="anchor"></span>
<section class="sec" id="governance">
  <div class="wrap">
    <div class="gov-head">
      <div>
        <p class="eyebrow rev">{{ $content['eyebrow'] ?? '' }}</p>
        <h2 class="rev d1">{{ $content['heading_first'] ?? '' }} <b>{{ $content['heading_second'] ?? '' }}</b></h2>
      </div>
      <p class="lede rev d2">{{ $content['description'] ?? '' }}</p>
    </div>
    <div class="gov-grid">
      @foreach ($content['pillars'] ?? [] as $pillar)
        <article class="card rev">
          <span class="rn">{{ $pillar['number'] ?? '' }}</span>
          <h3>{{ $pillar['title'] ?? '' }}</h3>
          <p>{{ $pillar['description'] ?? '' }}</p>
        </article>
      @endforeach
    </div>
  </div>
</section>
