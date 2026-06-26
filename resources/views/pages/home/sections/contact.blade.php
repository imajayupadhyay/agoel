<footer id="contact">
  <div class="foot-grid">
    <div>
      <div class="eyebrow">{{ $content['eyebrow'] ?? '' }}</div>
      <h2 class="display-md">{{ $content['heading'] ?? '' }}</h2>
      <div class="contact-line">
        <a class="big" href="mailto:{{ $content['primary_email'] ?? '' }}">{{ $content['primary_email'] ?? '' }}</a>
      </div>
      <div class="intents">
        @foreach ($content['intents'] ?? [] as $intent)
          <div class="it">
            <span class="lbl">{{ $intent['label'] ?? '' }}</span>
            <a href="mailto:{{ $intent['email'] ?? '' }}">{{ $intent['email'] ?? '' }}</a>
          </div>
        @endforeach
      </div>
      <div class="socials">
        @foreach ($content['socials'] ?? [] as $social)
          <a href="{{ $social['url'] ?: '#' }}">{{ $social['label'] ?? '' }}</a>
        @endforeach
      </div>
    </div>
    <div class="news">
      <label>{{ $content['newsletter_label'] ?? '' }}</label>
      <p class="lead" style="color:var(--muted-d);margin-bottom:20px;font-size:15px">{{ $content['newsletter_description'] ?? '' }}</p>
      <form
        class="field"
        data-newsletter
        method="POST"
        action="{{ route('newsletter.subscribe') }}"
        data-success="{{ $content['newsletter_success'] ?? '' }}"
        data-invalid="{{ $content['newsletter_invalid'] ?? '' }}"
      >
        @csrf
        <input name="source" type="hidden" value="homepage">
        <input name="website" type="text" tabindex="-1" autocomplete="off" aria-hidden="true" style="position:absolute;left:-9999px;width:1px;height:1px;opacity:0">
        <input id="nl" name="email" type="email" placeholder="{{ $content['newsletter_placeholder'] ?? '' }}" aria-label="Email" required>
        <button id="nlBtn" type="submit">{{ $content['newsletter_button'] ?? '' }}</button>
      </form>
      <div class="ok" id="nlOk">{{ session('newsletter_status') }}</div>
    </div>
  </div>
  <div class="foot-base">
    <span>© <span id="yr"></span> {{ $content['copyright_name'] ?? '' }}. All rights reserved.</span>
    <span>{{ $content['strapline'] ?? '' }}</span>
    <a class="foot-sitemap" href="{{ route('sitemap') }}">sitemap.xml</a>
  </div>
</footer>
