<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminNewsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_the_news_editor(): void
    {
        $this->actingAs($this->admin())
            ->get('/edit99/in-the-news')
            ->assertOk()
            ->assertSee('Manage the In the News page')
            ->assertSee('SEO & Publishing', false)
            ->assertSee('Hero &amp; Coverage Reel', false)
            ->assertSee('Coverage entries')
            ->assertSee('Full Coverage Index')
            ->assertSee('Press Footer');
    }

    public function test_news_content_is_server_rendered_from_admin_data(): void
    {
        $this->get('/in-the-news')
            ->assertOk()
            ->assertSee('The Sociologist Entrepreneur, Anmol Pushjai Goel')
            ->assertSee('The Statesman')
            ->assertSee('Syndicated across')
            ->assertDontSee('const NEWS', false)
            ->assertDontSee('data:image', false);
    }

    public function test_admin_can_update_news_sections_and_coverage(): void
    {
        $page = $this->page();
        $payload = $this->payload($page);
        $hero = $page->sections->firstWhere('key', 'hero');
        $index = $page->sections->firstWhere('key', 'index');

        $payload['sections'][$hero->id]['content']['subline'] = 'Updated press archive';
        $payload['sections'][$hero->id]['content']['coverage'][0]['outlet'] = 'Managed Outlet';
        $payload['sections'][$hero->id]['content']['coverage'][0]['title'] = 'Managed headline from admin';
        $payload['sections'][$hero->id]['content']['coverage'][0]['url'] = '/managed-coverage';
        $payload['sections'][$hero->id]['content']['coverage'][0]['show_in_reel'] = '0';
        $payload['sections'][$index->id]['content']['syndication_text'] = 'Managed syndication copy.';

        $this->actingAs($this->admin())
            ->put('/edit99/in-the-news', $payload)
            ->assertRedirect()
            ->assertSessionHas('status');

        $this->get('/in-the-news')
            ->assertOk()
            ->assertSee('Updated press archive')
            ->assertSee('Managed Outlet')
            ->assertSee('Managed headline from admin')
            ->assertSee('/managed-coverage', false)
            ->assertSee('Managed syndication copy.');
    }

    public function test_admin_can_replace_news_images(): void
    {
        Storage::fake('public');

        $page = $this->page();
        $payload = $this->payload($page);
        $hero = $page->sections->firstWhere('key', 'hero');

        $payload['sections'][$hero->id]['uploads']['background_image'] = UploadedFile::fake()
            ->image('news-background.jpg', 1600, 900);
        $payload['sections'][$hero->id]['content']['coverage'][0]['image_upload'] = UploadedFile::fake()
            ->image('coverage.jpg', 1200, 900);

        $this->actingAs($this->admin())
            ->put('/edit99/in-the-news', $payload)
            ->assertRedirect();

        $hero->refresh();

        Storage::disk('public')->assertExists($hero->content['background_image']);
        Storage::disk('public')->assertExists($hero->content['coverage'][0]['image']);
        $this->assertStringStartsWith('pages/news/hero/', $hero->content['background_image']);
        $this->assertStringStartsWith('pages/news/hero/', $hero->content['coverage'][0]['image']);
    }

    public function test_unpublished_news_page_is_not_public(): void
    {
        $this->page()->update(['is_published' => false]);

        $this->get('/in-the-news')->assertNotFound();
    }

    public function test_non_admin_cannot_manage_news(): void
    {
        $user = User::factory()->create(['email' => 'person@example.com']);

        $this->actingAs($user)
            ->get('/edit99/in-the-news')
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
        return Page::query()->where('key', 'news')->with('sections')->firstOrFail();
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
