{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach ($pages as $page)
    <url>
        <loc>{{ $page->canonical_url ?: match ($page->key) {
            'home' => route('home'),
            'industries' => route('industries'),
            'philanthropy' => route('philanthropy'),
            default => url($page->slug),
        } }}</loc>
        <lastmod>{{ $page->updated_at->toDateString() }}</lastmod>
        <changefreq>{{ $page->sitemap_change_frequency }}</changefreq>
        <priority>{{ number_format((float) $page->sitemap_priority, 1) }}</priority>
    </url>
@endforeach
</urlset>
