<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\PhilanthropyMedia;
use Illuminate\View\View;

class PhilanthropyController extends Controller
{
    public function __invoke(PhilanthropyMedia $media): View
    {
        $page = Page::query()
            ->where('key', 'philanthropy')
            ->where('is_published', true)
            ->with(['sections' => fn ($query) => $query
                ->where('is_enabled', true)
                ->orderBy('sort_order')])
            ->firstOrFail();

        return view('pages.philanthropy', [
            'page' => $page,
            'sections' => $page->sections,
            'media' => $media,
        ]);
    }
}
