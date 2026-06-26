<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateAboutRequest;
use App\Models\Page;
use App\Services\AboutManager;
use App\Services\AboutMedia;
use App\Services\AboutSchema;
use App\Services\PageSeo;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function edit(AboutSchema $schema, AboutMedia $media, PageSeo $seo): View
    {
        $page = $this->page();

        return view('admin.about.edit', [
            'page' => $page,
            'sections' => $page->sections,
            'schema' => $schema,
            'media' => $media,
            'defaultSchemaJson' => $seo->defaultSchemaJson($page),
        ]);
    }

    public function update(UpdateAboutRequest $request, AboutManager $manager): RedirectResponse
    {
        $manager->update($this->page(), $request);

        return back()->with('status', 'About page updated successfully.');
    }

    private function page(): Page
    {
        return Page::query()
            ->where('key', 'about')
            ->with('sections')
            ->firstOrFail();
    }
}
