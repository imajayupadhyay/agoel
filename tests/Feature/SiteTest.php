<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class SiteTest extends TestCase
{
    use RefreshDatabase;

    public static function pageProvider(): array
    {
        return [
            'home' => ['/', 'Anmol Pushjai Goel — Entrepreneur', 'home.css'],
            'industries' => ['/industries', 'Industries — Anmol Pushjai Goel', 'industries.css'],
            'philanthropy' => ['/philanthropy', 'Philanthropy &amp; Governance', 'philanthropy.css'],
            'news' => ['/in-the-news', 'In the News — Anmol Pushjai Goel', 'news.css'],
            'books' => ['/books', 'The Library — Anmol Pushjai Goel', 'books.css'],
            'research' => ['/research-publications', 'Research &amp; Publications — Anmol Pushjai Goel', 'research.css'],
            'about' => ['/about-anmol-goel', 'About — Anmol Pushjai Goel', 'about.css'],
        ];
    }

    #[DataProvider('pageProvider')]
    public function test_static_pages_are_rendered_with_seo_markup(
        string $uri,
        string $title,
        string $stylesheet,
    ): void {
        $response = $this->get($uri);

        $response
            ->assertOk()
            ->assertSee($title, false)
            ->assertSee('rel="canonical"', false)
            ->assertSee('application/ld+json', false)
            ->assertSee('"@context"', false)
            ->assertSee('https://schema.org', false)
            ->assertSee('<main id="main-content">', false)
            ->assertSee('</main>', false)
            ->assertSee($stylesheet, false)
            ->assertSee('rel="icon"', false)
            ->assertSee('favicon.svg', false)
            ->assertDontSee('data:image', false);
    }

    public function test_favicon_is_available(): void
    {
        $favicon = public_path('favicon.svg');
        $contents = file_get_contents($favicon);

        $this->assertFileExists($favicon);
        $this->assertStringContainsString('<svg', $contents);
        $this->assertStringContainsString('#A98F5B', $contents);
        $this->assertStringContainsString('#C7B589', $contents);

        $this->get('/favicon.ico')->assertRedirect('/favicon.svg');
    }

    public function test_sitemap_and_robots_are_available(): void
    {
        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee(route('home'), false)
            ->assertSee(route('industries'), false)
            ->assertSee(route('philanthropy'), false)
            ->assertSee(route('news'), false)
            ->assertSee(route('books'), false)
            ->assertSee(route('research'), false)
            ->assertSee(route('about'), false);

        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Allow: /', false)
            ->assertSee('Disallow: /sanchalak', false)
            ->assertSee(route('sitemap'), false);
    }

    public function test_navigation_uses_the_requested_menu_items(): void
    {
        foreach (['/', '/industries', '/philanthropy', '/in-the-news', '/books', '/research-publications', '/about-anmol-goel'] as $uri) {
            $this->get($uri)
                ->assertOk()
                ->assertSeeInOrder([
                    '>Industries<',
                    '>Philanthropy<',
                    '>In the News<',
                    '>Books<',
                    '>Research &amp; Publications<',
                    '>About Anmol Goel<',
                ], false);
        }
    }

    public function test_navigation_points_to_static_section_pages(): void
    {
        foreach (['/', '/industries', '/philanthropy', '/in-the-news', '/books', '/research-publications'] as $uri) {
            $this->get($uri)
                ->assertOk()
                ->assertSee('href="'.route('news').'"', false)
                ->assertSee('href="'.route('books').'"', false)
                ->assertSee('href="'.route('research').'"', false)
                ->assertSee('href="'.route('about').'"', false)
                ->assertDontSee('href="'.route('home').'#news"', false)
                ->assertDontSee('href="'.route('home').'#books"', false)
                ->assertDontSee('href="'.route('home').'#research"', false)
                ->assertDontSee('href="'.route('home').'#meet"', false);
        }
    }

    public function test_legacy_static_urls_redirect_permanently(): void
    {
        $this->get('/F1_Anmolweb-D.html')->assertRedirect('/');
        $this->get('/F2_Anmolweb-Industries.html')->assertRedirect('/industries');
        $this->get('/F3_Anmolweb-Philanthropy.html')->assertRedirect('/philanthropy');
        $this->get('/AG-IN THE NEWS.html')->assertRedirect('/in-the-news');
        $this->get('/BookAG.html')->assertRedirect('/books');
        $this->get('/AG-Research & Publications.html')->assertRedirect('/research-publications');
        $this->get('/2About_AG .html')->assertRedirect('/about-anmol-goel');
    }

    public function test_missing_public_page_renders_themed_404_with_seo_controls(): void
    {
        $this->get('/missing-page-that-does-not-exist')
            ->assertNotFound()
            ->assertSee('Page Not Found — Anmol Pushjai Goel', false)
            ->assertSee('meta name="robots" content="noindex, follow, max-image-preview:large"', false)
            ->assertSee('css/error.css', false)
            ->assertSee('favicon.svg', false)
            ->assertSee('<main id="main-content" class="not-found">', false)
            ->assertSee('>Return Home<', false)
            ->assertSee('>Industries<', false)
            ->assertSee('>Philanthropy<', false)
            ->assertDontSee('data:image', false);
    }
}
