@php
    $mark = $media->url($content['footer_mark'] ?? 'images/home/redesign-footer-mark.png');
@endphp

<footer id="connect">
  <div class="foot-glow" aria-hidden="true"></div>

  <div class="foot-grid">
    <div class="foot-l">
      @if ($mark)
        <img class="foot-mark" src="{{ $mark }}" alt="{{ $content['footer_mark_alt'] ?? 'APG' }}">
      @endif
      <p class="foot-name">{{ $content['copyright_name'] ?? '' }}</p>
      <p class="foot-role">{{ $content['strapline'] ?? '' }}</p>
      <a class="foot-mail" href="mailto:{{ $content['primary_email'] ?? '' }}">{{ $content['primary_email'] ?? '' }}</a>
      <p class="foot-place">
        <span>{{ $content['location_primary'] ?? '' }}</span>
        <span class="foot-dot"></span>
        <span>{{ $content['location_secondary'] ?? '' }}</span>
      </p>
      <nav class="foot-links" aria-label="{{ $content['explore_label'] ?? 'Explore' }}">
        @foreach ($content['socials'] ?? [] as $social)
          <a href="{{ $social['url'] ?: '#' }}" @if (str_starts_with($social['url'] ?? '', 'http')) target="_blank" rel="noopener" @endif>
            {{ $social['label'] ?? '' }}
          </a>
        @endforeach
      </nav>
    </div>

    <div class="foot-r">
      <p class="foot-h">{{ $content['newsletter_label'] ?? '' }}</p>
      <p class="foot-news-copy">{{ $content['newsletter_description'] ?? '' }}</p>
      <form
        class="field"
        id="newsField"
        data-newsletter
        method="POST"
        action="{{ route('newsletter.subscribe') }}"
        data-success="{{ $content['newsletter_success'] ?? '' }}"
        data-invalid="{{ $content['newsletter_invalid'] ?? '' }}"
      >
        @csrf
        <input name="source" type="hidden" value="homepage">
        <input name="website" type="text" tabindex="-1" autocomplete="off" aria-hidden="true" style="position:absolute;left:-9999px;width:1px;height:1px;opacity:0">
        <input name="email" type="email" id="nlMail" placeholder="{{ $content['newsletter_placeholder'] ?? '' }}" aria-label="{{ $content['newsletter_placeholder'] ?? 'Your email address' }}" required>
        <button type="submit" id="nlSend">{{ $content['newsletter_button'] ?? '' }}</button>
      </form>
      <p class="nl-note" id="nlNote" role="status">{{ session('newsletter_status') }}</p>
    </div>
  </div>

  <div class="foot-base">
    <span>&copy; <span id="yr">{{ now()->year }}</span> {{ $content['copyright_name'] ?? '' }}. All rights reserved.</span>
    <span class="foot-base-r">
      <span>{{ $content['footer_locations'] ?? '' }}</span>
      <a href="#top" class="foot-top-link">Back to top &uarr;</a>
      <a class="foot-sitemap" href="{{ route('sitemap') }}">sitemap.xml</a>
    </span>
  </div>
</footer>
