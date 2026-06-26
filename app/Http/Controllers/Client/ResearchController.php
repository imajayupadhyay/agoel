<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\ResearchCategory;
use App\Models\ResearchPublication;
use App\Services\PageSeo;
use App\Services\ResearchMedia;
use Illuminate\View\View;

class ResearchController extends Controller
{
    public function __invoke(ResearchMedia $media, PageSeo $seo): View
    {
        $page = Page::query()
            ->where('key', 'research')
            ->where('is_published', true)
            ->with(['sections' => fn ($query) => $query
                ->where('is_enabled', true)
                ->orderBy('sort_order')])
            ->firstOrFail();

        $categories = ResearchCategory::query()
            ->where('is_enabled', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $publications = ResearchPublication::query()
            ->with('category')
            ->where('is_enabled', true)
            ->whereHas('category', fn ($query) => $query->where('is_enabled', true))
            ->orderBy('sort_order')
            ->orderByDesc('year')
            ->orderBy('title')
            ->get();

        return view('pages.research', [
            'page' => $page,
            'sections' => $page->sections->keyBy('key'),
            'categories' => $categories,
            'publications' => $publications,
            'media' => $media,
            'schemaMarkup' => $seo->schema($page),
            'canonicalUrl' => $seo->canonical($page),
            'robotsMeta' => $seo->robots($page),
        ]);
    }
}
