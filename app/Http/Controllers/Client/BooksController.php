<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\BooksMedia;
use App\Services\PageSeo;
use Illuminate\View\View;

class BooksController extends Controller
{
    public function __invoke(BooksMedia $media, PageSeo $seo): View
    {
        $page = Page::query()
            ->where('key', 'books')
            ->where('is_published', true)
            ->with(['sections' => fn ($query) => $query
                ->where('is_enabled', true)
                ->orderBy('sort_order')])
            ->firstOrFail();

        return view('pages.books', [
            'page' => $page,
            'sections' => $page->sections->keyBy('key'),
            'media' => $media,
            'schemaMarkup' => $seo->schema($page),
            'canonicalUrl' => $seo->canonical($page),
            'robotsMeta' => $seo->robots($page),
        ]);
    }
}
