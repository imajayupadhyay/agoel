<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateNewsRequest;
use App\Models\Page;
use App\Services\NewsManager;
use App\Services\NewsMedia;
use App\Services\NewsSchema;
use App\Services\PageSeo;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function edit(NewsSchema $schema, NewsMedia $media, PageSeo $seo): View
    {
        $page = $this->page();

        return view('admin.news.edit', [
            'page' => $page,
            'sections' => $page->sections,
            'schema' => $schema,
            'media' => $media,
            'defaultSchemaJson' => $seo->defaultSchemaJson($page),
        ]);
    }

    public function update(UpdateNewsRequest $request, NewsManager $manager): RedirectResponse
    {
        $manager->update($this->page(), $request);

        return back()->with('status', 'In the News page updated successfully.');
    }

    private function page(): Page
    {
        return Page::query()
            ->where('key', 'news')
            ->with('sections')
            ->firstOrFail();
    }
}
