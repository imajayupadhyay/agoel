<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use App\Models\Page;
use App\Services\IndustriesMedia;
use App\Services\PageSeo;
use Illuminate\View\View;

class IndustriesController extends Controller
{
    public function __invoke(IndustriesMedia $media, PageSeo $seo): View
    {
        $page = Page::query()
            ->where('key', 'industries')
            ->where('is_published', true)
            ->with(['sections' => fn ($query) => $query
                ->where('is_enabled', true)
                ->orderBy('sort_order')])
            ->firstOrFail();

        return view('pages.industries', [
            'page' => $page,
            'sections' => $page->sections->keyBy('key'),
            'industries' => Industry::query()
                ->where('is_enabled', true)
                ->orderBy('sort_order')
                ->get(),
            'media' => $media,
            'schemaMarkup' => $seo->schema($page),
            'canonicalUrl' => $seo->canonical($page),
            'robotsMeta' => $seo->robots($page),
        ]);
    }
}
