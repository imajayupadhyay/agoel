<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateBooksRequest;
use App\Models\Page;
use App\Services\BooksManager;
use App\Services\BooksMedia;
use App\Services\BooksSchema;
use App\Services\PageSeo;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BooksController extends Controller
{
    public function edit(BooksSchema $schema, BooksMedia $media, PageSeo $seo): View
    {
        $page = $this->page();

        return view('admin.books.edit', [
            'page' => $page,
            'sections' => $page->sections,
            'schema' => $schema,
            'media' => $media,
            'defaultSchemaJson' => $seo->defaultSchemaJson($page),
        ]);
    }

    public function update(UpdateBooksRequest $request, BooksManager $manager): RedirectResponse
    {
        $manager->update($this->page(), $request);

        return back()->with('status', 'Books page updated successfully.');
    }

    private function page(): Page
    {
        return Page::query()
            ->where('key', 'books')
            ->with('sections')
            ->firstOrFail();
    }
}
