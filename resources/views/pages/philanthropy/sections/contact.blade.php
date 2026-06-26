<footer id="contact">
  <div class="foot-grid">
    <div>
      <div class="eyebrow">{{ $content['eyebrow'] ?? '' }}</div>
      <h2 class="display-md">{{ $content['heading'] ?? '' }}</h2>
      @if ($content['email'] ?? null)
        <div class="contact-line"><a class="big" href="mailto:{{ $content['email'] }}">{{ $content['email'] }}</a></div>
      @endif
    </div>
    <div class="foot-r">
      <label>{{ $content['commitment_label'] ?? '' }}</label>
      <p class="lead">{{ $content['description'] ?? '' }}</p>
      <div class="socials">
        @if ($content['linkedin_url'] ?? null)<a href="{{ $content['linkedin_url'] }}">LinkedIn</a>@endif
        @if ($content['twitter_url'] ?? null)<a href="{{ $content['twitter_url'] }}">X / Twitter</a>@endif
        <a href="{{ route('home') }}">Back to Home</a>
      </div>
    </div>
  </div>
  <div class="foot-base">
    <span>&copy; <span id="yr">{{ now()->year }}</span> {{ $content['copyright_name'] ?? '' }}</span>
    <span>{{ $content['footer_role'] ?? '' }}</span>
    <a class="foot-sitemap" href="{{ route('sitemap') }}">sitemap.xml</a>
  </div>
</footer>
