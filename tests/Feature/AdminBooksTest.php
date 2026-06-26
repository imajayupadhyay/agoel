<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminBooksTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_the_books_editor(): void
    {
        $this->actingAs($this->admin())
            ->get('/edit99/books')
            ->assertOk()
            ->assertSee('Manage the Books page')
            ->assertSee('SEO & Publishing', false)
            ->assertSee('Hero Manifesto')
            ->assertSee('My Library')
            ->assertSee('Library books')
            ->assertSee('Book Reviews')
            ->assertSee('Full review body')
            ->assertSee('Reading Footer');
    }

    public function test_books_page_uses_admin_managed_data(): void
    {
        $this->get('/books')
            ->assertOk()
            ->assertSee('A real book should hurt.')
            ->assertSee('Meditations')
            ->assertSee('The Age of Surveillance Capitalism')
            ->assertSee('window.BOOKS_PAGE_DATA', false)
            ->assertDontSee('const BOOKS', false)
            ->assertDontSee('const REVIEWS', false)
            ->assertDontSee('data:image', false);
    }

    public function test_admin_can_update_library_and_review_content(): void
    {
        $page = $this->page();
        $payload = $this->payload($page);
        $hero = $page->sections->firstWhere('key', 'hero');
        $library = $page->sections->firstWhere('key', 'library');
        $reviews = $page->sections->firstWhere('key', 'reviews');

        $payload['sections'][$hero->id]['content']['heading'] = 'Books that changed the room.';
        $payload['sections'][$library->id]['content']['books'][0]['title'] = 'Managed Book Title';
        $payload['sections'][$library->id]['content']['books'][0]['author'] = 'Managed Author';
        $payload['sections'][$library->id]['content']['books'][0]['year'] = '2026';
        $payload['sections'][$reviews->id]['content']['reviews'][0]['title'] = 'Managed Review Title';
        $payload['sections'][$reviews->id]['content']['reviews'][0]['teaser'] = 'Managed review teaser.';
        $payload['sections'][$reviews->id]['content']['reviews'][0]['body'] = 'Managed review paragraph one.'."\n\n".'Managed review paragraph two.';

        $this->actingAs($this->admin())
            ->put('/edit99/books', $payload)
            ->assertRedirect()
            ->assertSessionHas('status');

        $this->get('/books')
            ->assertOk()
            ->assertSee('Books that changed the room.')
            ->assertSee('Managed Book Title')
            ->assertSee('Managed Author')
            ->assertSee('Managed Review Title')
            ->assertSee('Managed review teaser.')
            ->assertSee('Managed review paragraph two.');
    }

    public function test_admin_can_replace_books_section_images(): void
    {
        Storage::fake('public');

        $page = $this->page();
        $payload = $this->payload($page);
        $hero = $page->sections->firstWhere('key', 'hero');
        $closing = $page->sections->firstWhere('key', 'closing');

        $payload['sections'][$hero->id]['uploads']['background_image'] = UploadedFile::fake()
            ->image('library.jpg', 1600, 900);
        $payload['sections'][$closing->id]['uploads']['image'] = UploadedFile::fake()
            ->image('portrait.jpg', 900, 1200);

        $this->actingAs($this->admin())
            ->put('/edit99/books', $payload)
            ->assertRedirect();

        $hero->refresh();
        $closing->refresh();

        Storage::disk('public')->assertExists($hero->content['background_image']);
        Storage::disk('public')->assertExists($closing->content['image']);
        $this->assertStringStartsWith('pages/books/hero/', $hero->content['background_image']);
        $this->assertStringStartsWith('pages/books/closing/', $closing->content['image']);
    }

    public function test_unpublished_books_page_is_not_public(): void
    {
        $this->page()->update(['is_published' => false]);

        $this->get('/books')->assertNotFound();
    }

    public function test_non_admin_cannot_manage_books(): void
    {
        $user = User::factory()->create(['email' => 'person@example.com']);

        $this->actingAs($user)
            ->get('/edit99/books')
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
        return Page::query()->where('key', 'books')->with('sections')->firstOrFail();
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
