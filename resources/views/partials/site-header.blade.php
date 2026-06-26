@php
    $siteHeader = app(\App\Services\SiteHeader::class);
    $headerSettings = $siteHeader->settings();
    $headerItems = $siteHeader->enabledItems();
    $brandUrl = $headerSettings->brand_url ?: route('home');
    $brandHref = $siteHeader->href($brandUrl);
    $brandExternal = $siteHeader->isExternal($brandUrl);
@endphp

@if ($headerSettings->is_enabled)
<header id="hdr">
  <a href="{{ $brandHref }}" class="brand" @if($brandExternal) target="_blank" rel="noopener" @endif>
    <span class="mono">{{ $headerSettings->brand_mark }}</span>{{ $headerSettings->brand_name }}
  </a>
  <nav id="nav">
    @foreach ($headerItems as $item)
      @php
        $href = $siteHeader->href($item->url);
        $isExternal = $siteHeader->isExternal($item->url);
        $isActive = $siteHeader->isActive($item, request());
      @endphp
      <a
        href="{{ $href }}"
        @class(['active' => $isActive])
        @if($item->opens_new_tab || $isExternal) target="_blank" rel="noopener" @endif
      >{{ $item->label }}</a>
    @endforeach
  </nav>
  <button class="burger" id="burger" aria-label="Menu"><span></span><span></span><span></span></button>
</header>
@endif
