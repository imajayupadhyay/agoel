<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminAboutTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_the_about_editor(): void
    {
        $this->actingAs($this->admin())
            ->get('/sanchalak/about-anmol-goel')
            ->assertOk()
            ->assertSee('Manage the About Anmol Goel page')
            ->assertSee('SEO & Publishing', false)
            ->assertSee('Recognition Hero')
            ->assertSee('Recognition wall')
            ->assertSee('About Profile')
            ->assertSee('Profile facts')
            ->assertSee('In His Words')
            ->assertSee('About Footer');
    }

    public function test_about_page_uses_admin_managed_data(): void
    {
        $this->get('/about-anmol-goel')
            ->assertOk()
            ->assertSee('A reputation')
            ->assertSee('Kush Verma, IAS')
            ->assertSee('About Anmol')
            ->assertSee('Motion is not movement')
            ->assertSee('about-praise-data', false)
            ->assertDontSee('const praise=[', false)
            ->assertDontSee('data:image', false);
    }

    public function test_admin_can_update_about_sections(): void
    {
        $page = $this->page();
        $payload = $this->payload($page);
        $hero = $page->sections->firstWhere('key', 'hero');
        $profile = $page->sections->firstWhere('key', 'profile');
        $voice = $page->sections->firstWhere('key', 'voice');

        $payload['sections'][$hero->id]['content']['heading_line_one'] = 'Managed reputation';
        $payload['sections'][$hero->id]['content']['recognitions'][0]['name'] = 'Managed Mentor';
        $payload['sections'][$hero->id]['content']['recognitions'][0]['quote'] = 'Managed recognition quote.';
        $payload['sections'][$profile->id]['content']['metadata'][0]['value'] = 'Managed Company';
        $payload['sections'][$profile->id]['content']['paragraphs'][0]['emphasis'] = 'managed emphasis';
        $payload['sections'][$voice->id]['content']['quotes'][0]['text'] = 'Managed voice quote.';

        $this->actingAs($this->admin())
            ->put('/sanchalak/about-anmol-goel', $payload)
            ->assertRedirect()
            ->assertSessionHas('status');

        $this->get('/about-anmol-goel')
            ->assertOk()
            ->assertSee('Managed reputation')
            ->assertSee('Managed Mentor')
            ->assertSee('Managed recognition quote.')
            ->assertSee('Managed Company')
            ->assertSee('managed emphasis')
            ->assertSee('Managed voice quote.');
    }

    public function test_admin_can_replace_about_images(): void
    {
        Storage::fake('public');

        $page = $this->page();
        $payload = $this->payload($page);
        $hero = $page->sections->firstWhere('key', 'hero');

        $payload['sections'][$hero->id]['uploads']['background_image'] = UploadedFile::fake()
            ->image('about-primary.jpg', 1400, 1000);
        $payload['sections'][$hero->id]['uploads']['secondary_background_image'] = UploadedFile::fake()
            ->image('about-secondary.jpg', 1200, 900);

        $this->actingAs($this->admin())
            ->put('/sanchalak/about-anmol-goel', $payload)
            ->assertRedirect();

        $hero->refresh();

        Storage::disk('public')->assertExists($hero->content['background_image']);
        Storage::disk('public')->assertExists($hero->content['secondary_background_image']);
        $this->assertStringStartsWith('pages/about/hero/', $hero->content['background_image']);
        $this->assertStringStartsWith('pages/about/hero/', $hero->content['secondary_background_image']);
    }

    public function test_unpublished_about_page_is_not_public(): void
    {
        $this->page()->update(['is_published' => false]);

        $this->get('/about-anmol-goel')->assertNotFound();
    }

    public function test_non_admin_cannot_manage_about(): void
    {
        $user = User::factory()->create(['email' => 'person@example.com']);

        $this->actingAs($user)
            ->get('/sanchalak/about-anmol-goel')
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
        return Page::query()->where('key', 'about')->with('sections')->firstOrFail();
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
