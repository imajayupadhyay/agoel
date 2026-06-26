<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\NewsMedia;
use App\Services\PageSeo;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function __invoke(NewsMedia $media, PageSeo $seo): View
    {
        $page = Page::query()
            ->where('key', 'news')
            ->where('is_published', true)
            ->with(['sections' => fn ($query) => $query
                ->where('is_enabled', true)
                ->orderBy('sort_order')])
            ->firstOrFail();

        return view('pages.news', [
            'page' => $page,
            'sections' => $page->sections->keyBy('key'),
            'media' => $media,
            'schemaMarkup' => $seo->schema($page),
            'canonicalUrl' => $seo->canonical($page),
            'robotsMeta' => $seo->robots($page),
        ]);
    }
}
