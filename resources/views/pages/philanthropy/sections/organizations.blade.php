<section class="sec orgs">
  <div class="wrap">
    <p class="eyebrow rev">{{ $content['eyebrow'] ?? '' }}</p>
    <h2 class="rev d1">{{ $content['heading'] ?? '' }}</h2>
    <p class="lead rev d2">{{ $content['description'] ?? '' }}</p>
    <div class="org-grid rev d1">
      @foreach ($content['items'] ?? [] as $item)
      <article class="org">
        <p class="role">{{ $item['role'] ?? '' }}</p>
        <h3>{{ $item['name'] ?? '' }}</h3>
        <p class="loc">{{ $item['location'] ?: ($item['monogram_label'] ?? '') }}</p>
        <p>{{ $item['description'] ?? '' }}</p>
      </article>
      @endforeach
    </div>
  </div>
</section>
