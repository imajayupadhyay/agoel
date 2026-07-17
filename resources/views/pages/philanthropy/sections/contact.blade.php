<section class="sec contact" id="contact">
  <div class="wrap">
    <p class="eyebrow rev">{{ $content['eyebrow'] ?? '' }}</p>
    <h2 class="rev d1">{{ $content['heading'] ?? '' }}</h2>
    @if ($content['email'] ?? null)
      <a class="contact-mail rev d2" href="mailto:{{ $content['email'] }}">{{ $content['email'] }}</a>
    @endif
    <p class="note rev d2">{{ $content['description'] ?? '' }}</p>
  </div>
</section>

<footer>
  <div class="foot-grid">
    <div class="foot-l">
      <p class="fb">{{ $content['commitment_label'] ?? '' }}</p>
      <p class="fl">{{ $content['description'] ?? '' }}</p>
    </div>
    <nav class="foot-r foot-nav" aria-label="Footer navigation">
      @if ($content['linkedin_url'] ?? null)<a href="{{ $content['linkedin_url'] }}" @if(str_starts_with($content['linkedin_url'], 'http')) target="_blank" rel="noopener" @endif>LinkedIn</a>@endif
      @if ($content['twitter_url'] ?? null)<a href="{{ $content['twitter_url'] }}" @if(str_starts_with($content['twitter_url'], 'http')) target="_blank" rel="noopener" @endif>X</a>@endif
      <a href="{{ route('home') }}">Home</a>
    </nav>
  </div>
  <div class="foot-base">
    <span>&copy; <span id="yr">{{ now()->year }}</span> {{ $content['copyright_name'] ?? '' }}</span>
    <span>{{ $content['footer_role'] ?? '' }}</span>
    <a class="foot-sitemap" href="{{ route('sitemap') }}">sitemap.xml</a>
  </div>
</footer>
