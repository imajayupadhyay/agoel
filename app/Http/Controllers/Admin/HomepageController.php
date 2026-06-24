<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreHomepageSectionRequest;
use App\Http\Requests\Admin\UpdateHomepageRequest;
use App\Models\Page;
use App\Models\PageSection;
use App\Services\HomepageManager;
use App\Services\HomepageMedia;
use App\Services\HomepageSchema;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HomepageController extends Controller
{
    public function edit(HomepageSchema $schema, HomepageMedia $media): View
    {
        $page = $this->homepage();

        return view('admin.homepage.edit', [
            'page' => $page,
            'sections' => $page->sections,
            'schema' => $schema,
            'media' => $media,
        ]);
    }

    public function update(UpdateHomepageRequest $request, HomepageManager $manager): RedirectResponse
    {
        $manager->update($this->homepage(), $request);

        return back()->with('status', 'Homepage updated successfully.');
    }

    public function storeSection(StoreHomepageSectionRequest $request): RedirectResponse
    {
        $page = $this->homepage();
        $sectionDefaults = config('homepage.custom_section');

        $page->sections()->create([
            'key' => 'custom-'.Str::lower(Str::random(10)),
            'name' => $request->validated('name'),
            'type' => $sectionDefaults['type'],
            'content' => $sectionDefaults['content'],
            'is_enabled' => true,
            'is_custom' => true,
            'sort_order' => ((int) $page->sections()->max('sort_order')) + 10,
        ]);

        return back()->with('status', 'Custom section added. Configure it below and save the homepage.');
    }

    public function destroySection(
        PageSection $section,
        HomepageMedia $media,
        HomepageSchema $schema,
    ): RedirectResponse {
        abort_unless($section->page?->key === 'home' && $section->is_custom, 404);

        foreach ($schema->forSection($section)['fields'] as $fieldName => $field) {
            if ($field['type'] === 'image') {
                $media->deleteManaged($section->content[$fieldName] ?? null);
            }
        }

        $section->delete();

        return back()->with('status', 'Custom section removed.');
    }

    private function homepage(): Page
    {
        return Page::query()
            ->where('key', 'home')
            ->with('sections')
            ->firstOrFail();
    }
}
