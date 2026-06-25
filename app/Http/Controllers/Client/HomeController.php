<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\HomepageMedia;
use App\Services\PageSeo;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(HomepageMedia $media, PageSeo $seo): View
    {
        $page = Page::query()
            ->where('key', 'home')
            ->where('is_published', true)
            ->with(['sections' => fn ($query) => $query
                ->where('is_enabled', true)
                ->orderBy('sort_order')])
            ->firstOrFail();

        return view('pages.home', [
            'page' => $page,
            'sections' => $page->sections,
            'media' => $media,
            'schemaMarkup' => $seo->schema($page),
            'canonicalUrl' => $seo->canonical($page),
            'robotsMeta' => $seo->robots($page),
        ]);
    }
}
