<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\AboutMedia;
use App\Services\PageSeo;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function __invoke(AboutMedia $media, PageSeo $seo): View
    {
        $page = Page::query()
            ->where('key', 'about')
            ->where('is_published', true)
            ->with(['sections' => fn ($query) => $query
                ->where('is_enabled', true)
                ->orderBy('sort_order')])
            ->firstOrFail();

        return view('pages.about', [
            'page' => $page,
            'sections' => $page->sections->keyBy('key'),
            'media' => $media,
            'schemaMarkup' => $seo->schema($page),
            'canonicalUrl' => $seo->canonical($page),
            'robotsMeta' => $seo->robots($page),
        ]);
    }
}
