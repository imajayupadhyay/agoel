<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPhilanthropyTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_the_philanthropy_editor(): void
    {
        $this->actingAs($this->admin())
            ->get('/sanchalak/philanthropy')
            ->assertOk()
            ->assertSee('Manage the Philanthropy page')
            ->assertSee('SEO & Publishing', false)
            ->assertSee('Why Education')
            ->assertSee('Giving Principles')
            ->assertSee('Organizations')
            ->assertSee('Heritage of Service')
            ->assertSee('Contact &amp; Footer', false);
    }

    public function test_philanthropy_content_is_server_rendered(): void
    {
        $this->get('/philanthropy')
            ->assertOk()
            ->assertSee('The one lever that changes the position itself.')
            ->assertSee('Thinking over certificates')
            ->assertSee('Smile Foundation')
            ->assertSee('Bharat Governance Council')
            ->assertSee('Shri Mata Mansa Devi Shrine Trust');
    }

    public function test_admin_can_update_sections_repeaters_visibility_and_order(): void
    {
        $page = $this->page();
        $payload = $this->payload($page);
        $hero = $page->sections->firstWhere('key', 'hero');
        $creed = $page->sections->firstWhere('key', 'creed');
        $organizations = $page->sections->firstWhere('key', 'organizations');

        $payload['sections'][$hero->id]['content']['title_first'] = 'Built with purpose,';
        $payload['sections'][$hero->id]['sort_order'] = 15;
        $payload['sections'][$creed->id]['is_enabled'] = 0;
        $payload['sections'][$organizations->id]['content']['items'][0]['name'] = 'Smile Foundation India';
        $payload['sections'][$organizations->id]['content']['items'][0]['description'] = 'Managed through the Philanthropy CMS.';

        $this->actingAs($this->admin())
            ->put('/sanchalak/philanthropy', $payload)
            ->assertRedirect()
            ->assertSessionHas('status');

        $this->assertDatabaseHas('page_sections', [
            'id' => $hero->id,
            'sort_order' => 15,
        ]);
        $this->assertDatabaseHas('page_sections', [
            'id' => $creed->id,
            'is_enabled' => false,
        ]);

        $this->get('/philanthropy')
            ->assertOk()
            ->assertSee('Built with purpose,')
            ->assertSee('Smile Foundation India')
            ->assertSee('Managed through the Philanthropy CMS.')
            ->assertDontSee('A surname, a town, an income bracket');
    }

    public function test_admin_can_replace_a_section_and_repeater_image(): void
    {
        Storage::fake('public');

        $page = $this->page();
        $payload = $this->payload($page);
        $hero = $page->sections->firstWhere('key', 'hero');
        $organizations = $page->sections->firstWhere('key', 'organizations');

        $payload['sections'][$hero->id]['uploads']['portrait'] = UploadedFile::fake()
            ->image('portrait.jpg', 1000, 1400);
        $payload['sections'][$organizations->id]['content']['items'][0]['image_upload'] = UploadedFile::fake()
            ->image('organization.jpg', 1200, 800);

        $this->actingAs($this->admin())
            ->put('/sanchalak/philanthropy', $payload)
            ->assertRedirect();

        $hero->refresh();
        $organizations->refresh();

        Storage::disk('public')->assertExists($hero->content['portrait']);
        Storage::disk('public')->assertExists($organizations->content['items'][0]['image']);
        $this->assertStringStartsWith('pages/philanthropy/hero/', $hero->content['portrait']);
        $this->assertStringStartsWith('pages/philanthropy/organizations/', $organizations->content['items'][0]['image']);
    }

    public function test_admin_can_add_and_remove_repeater_items(): void
    {
        $page = $this->page();
        $payload = $this->payload($page);
        $principles = $page->sections->firstWhere('key', 'principles');

        $payload['sections'][$principles->id]['content']['items'][] = [
            '_key' => 'principle-new',
            'number' => '04',
            'heading' => 'Long-term accountability',
            'body_before' => 'Stay close enough to',
            'body_accent' => 'measure the outcome',
            'body_after' => 'rather than merely announce the intention.',
        ];
        array_shift($payload['sections'][$principles->id]['content']['items']);

        $this->actingAs($this->admin())
            ->put('/sanchalak/philanthropy', $payload)
            ->assertRedirect();

        $this->get('/philanthropy')
            ->assertOk()
            ->assertSee('Long-term accountability')
            ->assertDontSee('Thinking over certificates');
    }

    public function test_unpublished_philanthropy_page_is_not_public(): void
    {
        $this->page()->update(['is_published' => false]);

        $this->get('/philanthropy')->assertNotFound();
    }

    public function test_non_admin_cannot_manage_philanthropy(): void
    {
        $user = User::factory()->create(['email' => 'person@example.com']);

        $this->actingAs($user)
            ->get('/sanchalak/philanthropy')
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
        return Page::query()->where('key', 'philanthropy')->with('sections')->firstOrFail();
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
        ];
    }
}
