<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\ResearchCategory;
use App\Models\ResearchPublication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminResearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_the_research_editor(): void
    {
        $this->actingAs($this->admin())
            ->get('/sanchalak/research-publications')
            ->assertOk()
            ->assertSee('Manage the Research &amp; Publications page', false)
            ->assertSee('SEO & Publishing', false)
            ->assertSee('Index Hero')
            ->assertSee('Methodology Lens')
            ->assertSee('Research publications')
            ->assertSee('Manage categories');
    }

    public function test_admin_can_open_the_research_categories_editor(): void
    {
        $this->actingAs($this->admin())
            ->get('/sanchalak/research-publications/categories')
            ->assertOk()
            ->assertSee('Research Categories')
            ->assertSee('Articles')
            ->assertSee('Recommended Studies')
            ->assertSee('Attached publications');
    }

    public function test_research_page_uses_admin_managed_data(): void
    {
        $this->get('/research-publications')
            ->assertOk()
            ->assertSee('Research &amp; Publications', false)
            ->assertSee('We Are Not Behind in the AI Race')
            ->assertSee('Recommended Studies')
            ->assertSee('window.RESEARCH_PAGE_DATA', false)
            ->assertDontSee('const PUBS=[', false)
            ->assertDontSee('const FIELDS=[', false)
            ->assertDontSee('data:image', false);
    }

    public function test_admin_can_update_research_sections_and_publications(): void
    {
        $page = $this->page();
        $payload = $this->payload($page);
        $index = $page->sections->firstWhere('key', 'index');
        $publication = ResearchPublication::query()->with('category')->firstOrFail();
        $essay = ResearchCategory::query()->where('slug', 'essay')->firstOrFail();

        $payload['sections'][$index->id]['content']['heading'] = 'Managed research archive';
        $payload['publications'][$publication->id]['research_category_id'] = $essay->id;
        $payload['publications'][$publication->id]['title'] = 'Managed Publication Title';
        $payload['publications'][$publication->id]['status'] = 'Managed status';
        $payload['publications'][$publication->id]['summary'] = 'Managed publication summary.';
        $payload['publications'][$publication->id]['tags'][0] = 'managed tag';

        $this->actingAs($this->admin())
            ->put('/sanchalak/research-publications', $payload)
            ->assertRedirect()
            ->assertSessionHas('status');

        $this->get('/research-publications')
            ->assertOk()
            ->assertSee('Managed research archive')
            ->assertSee('Managed Publication Title')
            ->assertSee('Managed publication summary.')
            ->assertSee('managed tag')
            ->assertSee('Essays');
    }

    public function test_admin_can_manage_research_categories(): void
    {
        $payload = $this->categoryPayload();
        $article = ResearchCategory::query()->where('slug', 'article')->firstOrFail();
        $study = ResearchCategory::query()->where('slug', 'study')->firstOrFail();

        $payload['categories'][$article->id]['label'] = 'Long Articles';
        $payload['categories'][$study->id]['is_enabled'] = 0;

        $this->actingAs($this->admin())
            ->put('/sanchalak/research-publications/categories', $payload)
            ->assertRedirect()
            ->assertSessionHas('status');

        $this->get('/research-publications')
            ->assertOk()
            ->assertSee('Long Articles')
            ->assertDontSee('Recommended Studies');
    }

    public function test_admin_can_add_and_remove_a_research_publication(): void
    {
        $admin = $this->admin();
        $category = ResearchCategory::query()->firstOrFail();

        $this->actingAs($admin)
            ->post('/sanchalak/research-publications/publications', [
                'research_category_id' => $category->id,
                'title' => 'Draft Publication',
            ])
            ->assertRedirect()
            ->assertSessionHas('status');

        $publication = ResearchPublication::query()->where('title', 'Draft Publication')->firstOrFail();

        $this->assertFalse($publication->is_enabled);

        $this->actingAs($admin)
            ->delete("/sanchalak/research-publications/publications/{$publication->id}")
            ->assertRedirect();

        $this->assertDatabaseMissing('research_publications', ['id' => $publication->id]);
    }

    public function test_admin_can_add_and_remove_an_unused_research_category(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)
            ->post('/sanchalak/research-publications/categories', ['name' => 'Policy Notes'])
            ->assertRedirect()
            ->assertSessionHas('status');

        $category = ResearchCategory::query()->where('slug', 'policy-notes')->firstOrFail();

        $this->assertFalse($category->is_enabled);

        $this->actingAs($admin)
            ->delete("/sanchalak/research-publications/categories/{$category->id}")
            ->assertRedirect();

        $this->assertDatabaseMissing('research_categories', ['id' => $category->id]);
    }

    public function test_admin_cannot_delete_a_category_with_publications(): void
    {
        $category = ResearchCategory::query()->whereHas('publications')->firstOrFail();

        $this->actingAs($this->admin())
            ->delete("/sanchalak/research-publications/categories/{$category->id}")
            ->assertRedirect()
            ->assertSessionHasErrors('category');

        $this->assertDatabaseHas('research_categories', ['id' => $category->id]);
    }

    public function test_admin_can_replace_research_section_images(): void
    {
        Storage::fake('public');

        $page = $this->page();
        $payload = $this->payload($page);
        $index = $page->sections->firstWhere('key', 'index');
        $fields = $page->sections->firstWhere('key', 'fields');

        $payload['sections'][$index->id]['uploads']['background_image'] = UploadedFile::fake()
            ->image('research-background.jpg', 1600, 900);
        $payload['sections'][$fields->id]['content']['items'][0]['image_upload'] = UploadedFile::fake()
            ->image('field.jpg', 1200, 900);

        $this->actingAs($this->admin())
            ->put('/sanchalak/research-publications', $payload)
            ->assertRedirect();

        $index->refresh();
        $fields->refresh();

        Storage::disk('public')->assertExists($index->content['background_image']);
        Storage::disk('public')->assertExists($fields->content['items'][0]['image']);
        $this->assertStringStartsWith('pages/research/index/', $index->content['background_image']);
        $this->assertStringStartsWith('pages/research/fields/', $fields->content['items'][0]['image']);
    }

    public function test_hidden_categories_publications_and_unpublished_page_are_not_public(): void
    {
        $category = ResearchCategory::query()->where('slug', 'article')->firstOrFail();
        $category->update(['is_enabled' => false]);

        $this->get('/research-publications')
            ->assertOk()
            ->assertDontSee('We Are Not Behind in the AI Race');

        $this->page()->update(['is_published' => false]);

        $this->get('/research-publications')->assertNotFound();
    }

    public function test_non_admin_cannot_manage_research(): void
    {
        $user = User::factory()->create(['email' => 'person@example.com']);

        $this->actingAs($user)
            ->get('/sanchalak/research-publications')
            ->assertForbidden();
    }

    private function admin(): User
    {
        return User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
        ]);
    }

    private function page(): Page
    {
        return Page::query()->where('key', 'research')->with('sections')->firstOrFail();
    }

    private function payload(Page $page): array
    {
        return [
            'page' => [
                'title' => $page->title,
                'seo_title' => $page->seo_title,
                'meta_description' => $page->meta_description,
                'canonical_url' => $page->canonical_url,
                'robots_index' => 1,
                'robots_follow' => 1,
                'schema_override_enabled' => 0,
                'schema_markup' => null,
                'sitemap_included' => 1,
                'sitemap_change_frequency' => $page->sitemap_change_frequency,
                'sitemap_priority' => $page->sitemap_priority,
                'is_published' => 1,
                'remove_og_image' => 0,
            ],
            'sections' => $page->sections
                ->mapWithKeys(fn ($section) => [
                    $section->id => [
                        'is_enabled' => $section->is_enabled ? 1 : 0,
                        'sort_order' => $section->sort_order,
                        'content' => $section->content,
                    ],
                ])
                ->all(),
            'publications' => ResearchPublication::query()
                ->get()
                ->mapWithKeys(fn (ResearchPublication $publication) => [
                    $publication->id => [
                        'research_category_id' => $publication->research_category_id,
                        'title' => $publication->title,
                        'venue' => $publication->venue,
                        'year' => $publication->year,
                        'status' => $publication->status,
                        'summary' => $publication->summary,
                        'url' => $publication->url,
                        'tags' => $publication->tags ?? [],
                        'is_enabled' => $publication->is_enabled ? 1 : 0,
                        'sort_order' => $publication->sort_order,
                    ],
                ])
                ->all(),
        ];
    }

    private function categoryPayload(): array
    {
        return [
            'categories' => ResearchCategory::query()
                ->get()
                ->mapWithKeys(fn (ResearchCategory $category) => [
                    $category->id => [
                        'name' => $category->name,
                        'label' => $category->label,
                        'slug' => $category->slug,
                        'is_enabled' => $category->is_enabled ? 1 : 0,
                        'sort_order' => $category->sort_order,
                    ],
                ])
                ->all(),
        ];
    }
}
