<section id="voice">
  <div class="voice-wrap reveal">
    <div class="eyebrow center">{{ $content['eyebrow'] ?? '' }}</div>
    <div class="voice-mark">&ldquo;</div>
    <div class="voice-stage" id="voiceStage">
      @foreach ($content['quotes'] ?? [] as $index => $quote)
        <figure class="voice-q {{ $index === 0 ? 'on' : '' }}">
          <p>{{ $quote['text'] ?? '' }} <em>{{ $quote['accent'] ?? '' }}</em></p>
        </figure>
      @endforeach
    </div>
    <div class="voice-dots" id="voiceDots"></div>
    <div class="voice-by">{{ $content['author'] ?? '' }}</div>
  </div>
</section>
