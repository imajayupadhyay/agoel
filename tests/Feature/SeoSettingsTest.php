<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_global_seo_settings(): void
    {
        $this->actingAs($this->admin())
            ->get('/edit99/seo')
            ->assertOk()
            ->assertSee('Global SEO settings')
            ->assertSee('robots.txt')
            ->assertSee('sitemap.xml');
    }

    public function test_default_robots_and_sitemap_are_generated_from_settings_and_pages(): void
    {
        Page::query()->where('key', 'philanthropy')->update(['sitemap_included' => false]);

        $this->get('/robots.txt')
            ->assertOk()
            ->assertDontSee('edit99', false)
            ->assertSee(route('sitemap'), false);

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertSee(route('home'), false)
            ->assertSee(route('industries'), false)
            ->assertDontSee(route('philanthropy'), false)
            ->assertSee('<lastmod>', false)
            ->assertSee('<priority>1.0</priority>', false);
    }

    public function test_admin_can_override_robots_and_sitemap_files(): void
    {
        $robots = "User-agent: *\nDisallow: /private\n";
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"><url><loc>https://example.com/custom</loc></url></urlset>';

        $this->actingAs($this->admin())
            ->put('/edit99/seo', [
                'site_name' => 'Anmol Pushjai Goel',
                'robots_override_enabled' => 1,
                'robots_content' => $robots,
                'sitemap_override_enabled' => 1,
                'sitemap_content' => $sitemap,
            ])
            ->assertRedirect()
            ->assertSessionHas('status');

        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Disallow: /private', false);

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertSee('https://example.com/custom', false)
            ->assertDontSee(route('home'), false);
    }

    public function test_invalid_sitemap_override_is_rejected(): void
    {
        $this->actingAs($this->admin())
            ->put('/edit99/seo', [
                'site_name' => 'Anmol Pushjai Goel',
                'robots_override_enabled' => 0,
                'sitemap_override_enabled' => 1,
                'sitemap_content' => '<not-valid',
            ])
            ->assertSessionHasErrors('sitemap_content');
    }

    public function test_page_schema_canonical_and_robots_overrides_are_rendered(): void
    {
        $page = Page::query()->where('key', 'philanthropy')->firstOrFail();
        $page->update([
            'canonical_url' => 'https://example.com/canonical-philanthropy',
            'robots_index' => false,
            'robots_follow' => false,
            'schema_override_enabled' => true,
            'schema_markup' => json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'AboutPage',
                'name' => 'Custom philanthropy schema',
            ]),
        ]);

        $this->get('/philanthropy')
            ->assertOk()
            ->assertSee('content="noindex, nofollow, max-image-preview:large"', false)
            ->assertSee('href="https://example.com/canonical-philanthropy"', false)
            ->assertSee('"@type":"AboutPage"', false)
            ->assertSee('Custom philanthropy schema');
    }

    public function test_non_admin_cannot_manage_global_seo_settings(): void
    {
        $user = User::factory()->create(['email' => 'person@example.com']);

        $this->actingAs($user)
            ->get('/edit99/seo')
            ->assertForbidden();
    }

    private function admin(): User
    {
        return User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
        ]);
    }
}
