<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreResearchCategoryRequest;
use App\Http\Requests\Admin\StoreResearchPublicationRequest;
use App\Http\Requests\Admin\UpdateResearchCategoriesRequest;
use App\Http\Requests\Admin\UpdateResearchRequest;
use App\Models\Page;
use App\Models\ResearchCategory;
use App\Models\ResearchPublication;
use App\Services\PageSeo;
use App\Services\ResearchManager;
use App\Services\ResearchMedia;
use App\Services\ResearchSchema;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ResearchController extends Controller
{
    public function edit(ResearchSchema $schema, ResearchMedia $media, PageSeo $seo): View
    {
        $page = $this->page();

        return view('admin.research.edit', [
            'page' => $page,
            'sections' => $page->sections,
            'categories' => $this->categories(),
            'publications' => $this->publications(),
            'schema' => $schema,
            'media' => $media,
            'defaultSchemaJson' => $seo->defaultSchemaJson($page),
        ]);
    }

    public function update(UpdateResearchRequest $request, ResearchManager $manager): RedirectResponse
    {
        $manager->update($this->page(), $request);

        return back()->with('status', 'Research page updated successfully.');
    }

    public function storePublication(StoreResearchPublicationRequest $request): RedirectResponse
    {
        ResearchPublication::query()->create([
            'research_category_id' => (int) $request->validated('research_category_id'),
            'title' => $this->clean($request->validated('title')),
            'tags' => [],
            'is_enabled' => false,
            'sort_order' => ((int) ResearchPublication::query()->max('sort_order')) + 10,
        ]);

        return back()->with('status', 'Publication added. Fill in the details and make it visible when ready.');
    }

    public function destroyPublication(ResearchPublication $publication): RedirectResponse
    {
        $publication->delete();

        return back()->with('status', 'Publication deleted.');
    }

    public function editCategories(): View
    {
        return view('admin.research.categories', [
            'categories' => $this->categories(),
        ]);
    }

    public function updateCategories(UpdateResearchCategoriesRequest $request): RedirectResponse
    {
        $categories = ResearchCategory::query()->get()->keyBy('id');

        foreach ($request->validated('categories', []) as $categoryId => $submitted) {
            $category = $categories->get((int) $categoryId);

            if (! $category) {
                continue;
            }

            $category->update([
                'name' => $this->clean($submitted['name']),
                'label' => $this->clean($submitted['label']),
                'slug' => Str::slug($submitted['slug']),
                'is_enabled' => (bool) ($submitted['is_enabled'] ?? false),
                'sort_order' => (int) $submitted['sort_order'],
            ]);
        }

        return back()->with('status', 'Research categories updated successfully.');
    }

    public function storeCategory(StoreResearchCategoryRequest $request): RedirectResponse
    {
        $name = $this->clean($request->validated('name'));

        ResearchCategory::query()->create([
            'name' => $name,
            'label' => $name,
            'slug' => $this->uniqueSlug($name),
            'is_enabled' => false,
            'sort_order' => ((int) ResearchCategory::query()->max('sort_order')) + 10,
        ]);

        return back()->with('status', 'Category added. It is hidden until you make it visible.');
    }

    public function destroyCategory(ResearchCategory $category): RedirectResponse
    {
        if ($category->publications()->exists()) {
            return back()
                ->withErrors(['category' => 'Move or delete publications before deleting this category.'])
                ->withInput();
        }

        $category->delete();

        return back()->with('status', 'Category deleted.');
    }

    private function page(): Page
    {
        return Page::query()
            ->where('key', 'research')
            ->with(['sections' => fn ($query) => $query->orderBy('sort_order')])
            ->firstOrFail();
    }

    private function categories()
    {
        return ResearchCategory::query()
            ->withCount('publications')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }

    private function publications()
    {
        return ResearchPublication::query()
            ->with('category')
            ->orderBy('sort_order')
            ->orderByDesc('year')
            ->orderBy('title')
            ->get();
    }

    private function uniqueSlug(string $name): string
    {
        $base = Str::slug($name) ?: 'category';
        $slug = $base;
        $count = 2;

        while (ResearchCategory::query()->where('slug', $slug)->exists()) {
            $slug = "{$base}-{$count}";
            $count++;
        }

        return $slug;
    }

    private function clean(string $value): string
    {
        return trim(strip_tags($value));
    }
}
