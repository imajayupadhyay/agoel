<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdatePhilanthropyRequest;
use App\Models\Page;
use App\Services\PhilanthropyManager;
use App\Services\PhilanthropyMedia;
use App\Services\PhilanthropySchema;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PhilanthropyController extends Controller
{
    public function edit(PhilanthropySchema $schema, PhilanthropyMedia $media): View
    {
        $page = $this->page();

        return view('admin.philanthropy.edit', [
            'page' => $page,
            'sections' => $page->sections,
            'schema' => $schema,
            'media' => $media,
        ]);
    }

    public function update(UpdatePhilanthropyRequest $request, PhilanthropyManager $manager): RedirectResponse
    {
        $manager->update($this->page(), $request);

        return back()->with('status', 'Philanthropy page updated successfully.');
    }

    private function page(): Page
    {
        return Page::query()
            ->where('key', 'philanthropy')
            ->with('sections')
            ->firstOrFail();
    }
}
