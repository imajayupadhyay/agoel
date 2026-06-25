<?php

namespace Tests\Feature;

use App\Models\Industry;
use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminIndustriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_the_industries_editor(): void
    {
        $this->actingAs($this->admin())
            ->get('/sanchalak/industries')
            ->assertOk()
            ->assertSee('Manage the Industries page')
            ->assertSee('SEO & Publishing', false)
            ->assertSee('Investment Philosophy')
            ->assertSee('Portfolio Introduction')
            ->assertSee('Industry entries')
            ->assertSee('Technology')
            ->assertSee('Media &amp; Entertainment', false);
    }

    public function test_industries_are_server_rendered_without_javascript_injection(): void
    {
        $this->get('/industries')
            ->assertOk()
            ->assertSee('The compounding engine of the modern economy')
            ->assertSee('id="ind-technology"', false)
            ->assertSee('Defensible IP')
            ->assertDontSee('const INDUSTRIES', false)
            ->assertDontSee('tiles injected');
    }

    public function test_admin_can_update_page_sections_and_industry_content(): void
    {
        $page = $this->page();
        $payload = $this->payload($page);
        $hero = $page->sections->firstWhere('key', 'hero');
        $technology = Industry::query()->where('slug', 'technology')->firstOrFail();

        $payload['sections'][$hero->id]['content']['title_first'] = 'Invest with discipline,';
        $payload['industries'][$technology->id]['name'] = 'Frontier Technology';
        $payload['industries'][$technology->id]['body_before'] = 'A newly managed investment thesis.';

        $this->actingAs($this->admin())
            ->put('/sanchalak/industries', $payload)
            ->assertRedirect()
            ->assertSessionHas('status');

        $this->get('/industries')
            ->assertOk()
            ->assertSee('Invest with discipline,')
            ->assertSee('Frontier Technology')
            ->assertSee('A newly managed investment thesis.')
            ->assertSee('id="ind-frontier-technology"', false);
    }

    public function test_admin_can_replace_an_industry_image(): void
    {
        Storage::fake('public');

        $page = $this->page();
        $payload = $this->payload($page);
        $technology = Industry::query()->where('slug', 'technology')->firstOrFail();
        $payload['industries'][$technology->id]['image_upload'] = UploadedFile::fake()
            ->image('technology.jpg', 1200, 900);

        $this->actingAs($this->admin())
            ->put('/sanchalak/industries', $payload)
            ->assertRedirect();

        $technology->refresh();

        Storage::disk('public')->assertExists($technology->image);
        $this->assertStringStartsWith('pages/industries/items/', $technology->image);
    }

    public function test_admin_can_add_and_remove_an_industry(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)
            ->post('/sanchalak/industries/items', ['name' => 'Healthcare'])
            ->assertRedirect()
            ->assertSessionHas('status');

        $industry = Industry::query()->where('slug', 'healthcare')->firstOrFail();

        $this->assertFalse($industry->is_enabled);

        $this->actingAs($admin)
            ->delete("/sanchalak/industries/items/{$industry->id}")
            ->assertRedirect();

        $this->assertDatabaseMissing('industries', ['id' => $industry->id]);
    }

    public function test_hidden_industries_and_unpublished_page_are_not_public(): void
    {
        $industry = Industry::query()->where('slug', 'technology')->firstOrFail();
        $industry->update(['is_enabled' => false]);

        $this->get('/industries')
            ->assertOk()
            ->assertDontSee('The compounding engine of the modern economy');

        $this->page()->update(['is_published' => false]);
        $this->get('/industries')->assertNotFound();
    }

    public function test_non_admin_cannot_manage_industries(): void
    {
        $user = User::factory()->create(['email' => 'person@example.com']);

        $this->actingAs($user)
            ->get('/sanchalak/industries')
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
        return Page::query()->where('key', 'industries')->with('sections')->firstOrFail();
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
            'industries' => Industry::query()
                ->get()
                ->mapWithKeys(fn (Industry $industry) => [
                    $industry->id => [
                        'name' => $industry->name,
                        'tag' => $industry->tag,
                        'body_before' => $industry->body_before,
                        'body_accent' => $industry->body_accent,
                        'body_after' => $industry->body_after,
                        'pull_quote' => $industry->pull_quote,
                        'facts' => $industry->facts,
                        'image_alt' => $industry->image_alt,
                        'is_enabled' => $industry->is_enabled ? 1 : 0,
                        'sort_order' => $industry->sort_order,
                        'remove_image' => 0,
                    ],
                ])
                ->all(),
        ];
    }
}
