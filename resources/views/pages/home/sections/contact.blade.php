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
      <div
        class="field"
        data-newsletter
        data-success="{{ $content['newsletter_success'] ?? '' }}"
        data-invalid="{{ $content['newsletter_invalid'] ?? '' }}"
      >
        <input id="nl" type="email" placeholder="{{ $content['newsletter_placeholder'] ?? '' }}" aria-label="Email">
        <button id="nlBtn" type="button">{{ $content['newsletter_button'] ?? '' }}</button>
      </div>
      <div class="ok" id="nlOk"></div>
    </div>
  </div>
  <div class="foot-base">
    <span>© <span id="yr"></span> {{ $content['copyright_name'] ?? '' }}. All rights reserved.</span>
    <span>{{ $content['strapline'] ?? '' }}</span>
  </div>
</footer>
