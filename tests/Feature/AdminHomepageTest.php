<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminHomepageTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_the_sectioned_homepage_editor(): void
    {
        $this->actingAs($this->admin())
            ->get('/sanchalak/homepage')
            ->assertOk()
            ->assertSee('Manage the homepage')
            ->assertSee('SEO & Publishing', false)
            ->assertSee('Hero')
            ->assertSee('Positioning Strip')
            ->assertSee('Industries Introduction')
            ->assertSee('Philanthropy Introduction')
            ->assertSee('In the News')
            ->assertSee('Books')
            ->assertSee('Research &amp; Publications', false)
            ->assertSee('Voice &amp; Philosophy', false)
            ->assertSee('About Anmol Goel')
            ->assertSee('Contact &amp; Footer', false);
    }

    public function test_admin_can_update_homepage_text_visibility_and_order(): void
    {
        $page = $this->homepage();
        $payload = $this->payload($page);
        $hero = $page->sections->firstWhere('key', 'hero');
        $creed = $page->sections->firstWhere('key', 'creed');

        $payload['sections'][$hero->id]['content']['title_first'] = 'Dynamic Anmol';
        $payload['sections'][$hero->id]['sort_order'] = 15;
        $payload['sections'][$creed->id]['is_enabled'] = 0;

        $this->actingAs($this->admin())
            ->put('/sanchalak/homepage', $payload)
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

        $this->get('/')
            ->assertOk()
            ->assertSee('Dynamic Anmol')
            ->assertDontSee('A single thread runs through the company');
    }

    public function test_admin_can_replace_a_homepage_image(): void
    {
        Storage::fake('public');

        $page = $this->homepage();
        $payload = $this->payload($page);
        $hero = $page->sections->firstWhere('key', 'hero');
        $payload['sections'][$hero->id]['uploads']['image'] = UploadedFile::fake()
            ->image('portrait.jpg', 1000, 1400);

        $this->actingAs($this->admin())
            ->put('/sanchalak/homepage', $payload)
            ->assertRedirect();

        $hero->refresh();
        $path = $hero->content['image'];

        Storage::disk('public')->assertExists($path);
        $this->assertStringStartsWith('pages/home/hero/', $path);
    }

    public function test_admin_can_save_page_level_seo_and_schema_overrides(): void
    {
        $page = $this->homepage();
        $payload = $this->payload($page);
        $payload['page']['canonical_url'] = 'https://example.com/anmol';
        $payload['page']['robots_index'] = 0;
        $payload['page']['robots_follow'] = 0;
        $payload['page']['schema_override_enabled'] = 1;
        $payload['page']['schema_markup'] = json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'ProfilePage',
            'name' => 'Managed homepage schema',
        ]);
        $payload['page']['sitemap_change_frequency'] = 'weekly';
        $payload['page']['sitemap_priority'] = 0.9;

        $this->actingAs($this->admin())
            ->put('/sanchalak/homepage', $payload)
            ->assertRedirect()
            ->assertSessionHas('status');

        $page->refresh();

        $this->assertSame('https://example.com/anmol', $page->canonical_url);
        $this->assertFalse($page->robots_index);
        $this->assertTrue($page->schema_override_enabled);
        $this->assertSame('weekly', $page->sitemap_change_frequency);

        $this->get('/')
            ->assertOk()
            ->assertSee('Managed homepage schema')
            ->assertSee('content="noindex, nofollow, max-image-preview:large"', false);
    }

    public function test_invalid_page_schema_override_is_rejected(): void
    {
        $page = $this->homepage();
        $payload = $this->payload($page);
        $payload['page']['schema_override_enabled'] = 1;
        $payload['page']['schema_markup'] = '{"@context":';

        $this->actingAs($this->admin())
            ->put('/sanchalak/homepage', $payload)
            ->assertSessionHasErrors('page.schema_markup');
    }

    public function test_admin_can_add_and_remove_a_custom_section(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)
            ->post('/sanchalak/homepage/sections', ['name' => 'New Initiative'])
            ->assertRedirect()
            ->assertSessionHas('status');

        $section = $this->homepage()->sections->firstWhere('name', 'New Initiative');

        $this->assertNotNull($section);
        $this->assertTrue($section->is_custom);

        $this->actingAs($admin)
            ->delete("/sanchalak/homepage/sections/{$section->id}")
            ->assertRedirect();

        $this->assertDatabaseMissing('page_sections', ['id' => $section->id]);
    }

    public function test_custom_section_can_be_configured_and_rendered(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)
            ->post('/sanchalak/homepage/sections', ['name' => 'New Initiative'])
            ->assertRedirect();

        $page = $this->homepage();
        $section = $page->sections->firstWhere('name', 'New Initiative');
        $payload = $this->payload($page);
        $payload['sections'][$section->id]['content'] = [
            'anchor' => 'new-initiative',
            'eyebrow' => 'What comes next',
            'heading' => 'A new initiative',
            'body' => 'This section was created through Sanchalak.',
            'image_alt' => '',
            'theme' => 'dark',
            'button_label' => 'Learn more',
            'button_url' => '#contact',
        ];

        $this->actingAs($admin)
            ->put('/sanchalak/homepage', $payload)
            ->assertRedirect();

        $this->get('/')
            ->assertOk()
            ->assertSee('A new initiative')
            ->assertSee('This section was created through Sanchalak.')
            ->assertSee('id="new-initiative"', false);
    }

    public function test_non_admin_cannot_manage_homepage(): void
    {
        $user = User::factory()->create(['email' => 'person@example.com']);

        $this->actingAs($user)
            ->get('/sanchalak/homepage')
            ->assertForbidden();
    }

    private function admin(): User
    {
        return User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
        ]);
    }

    private function homepage(): Page
    {
        return Page::query()->where('key', 'home')->with('sections')->firstOrFail();
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
                        'name' => $section->name,
                        'is_enabled' => $section->is_enabled ? 1 : 0,
                        'sort_order' => $section->sort_order,
                        'content' => $section->content,
                    ],
                ])
                ->all(),
        ];
    }
}
