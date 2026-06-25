<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreIndustryRequest;
use App\Http\Requests\Admin\UpdateIndustriesRequest;
use App\Models\Industry;
use App\Models\Page;
use App\Services\IndustriesManager;
use App\Services\IndustriesMedia;
use App\Services\IndustriesSchema;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class IndustriesController extends Controller
{
    public function edit(IndustriesSchema $schema, IndustriesMedia $media): View
    {
        $page = $this->page();

        return view('admin.industries.edit', [
            'page' => $page,
            'sections' => $page->sections,
            'industries' => Industry::query()->orderBy('sort_order')->get(),
            'schema' => $schema,
            'media' => $media,
        ]);
    }

    public function update(UpdateIndustriesRequest $request, IndustriesManager $manager): RedirectResponse
    {
        $manager->update($this->page(), $request);

        return back()->with('status', 'Industries page updated successfully.');
    }

    public function storeIndustry(StoreIndustryRequest $request): RedirectResponse
    {
        $name = trim(strip_tags($request->validated('name')));
        $baseSlug = Str::slug($name) ?: 'industry';
        $slug = $baseSlug;
        $suffix = 2;

        while (Industry::query()->where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$suffix}";
            $suffix++;
        }

        Industry::query()->create([
            'name' => $name,
            'slug' => $slug,
            'tag' => 'Industry thesis',
            'body_before' => 'Add the investment thesis for this industry.',
            'body_accent' => null,
            'body_after' => null,
            'pull_quote' => 'Add a concise pull quote.',
            'facts' => [],
            'image' => null,
            'image_alt' => $name,
            'is_enabled' => false,
            'sort_order' => ((int) Industry::query()->max('sort_order')) + 10,
        ]);

        return back()->with('status', 'Industry added as hidden. Complete its content and enable it when ready.');
    }

    public function destroyIndustry(Industry $industry, IndustriesMedia $media): RedirectResponse
    {
        $media->deleteManaged($industry->image);
        $industry->delete();

        return back()->with('status', 'Industry removed.');
    }

    private function page(): Page
    {
        return Page::query()
            ->where('key', 'industries')
            ->with('sections')
            ->firstOrFail();
    }
}
