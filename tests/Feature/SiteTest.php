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
            ->assertDontSee('data:image', false);
    }

    public function test_sitemap_and_robots_are_available(): void
    {
        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee(route('home'), false)
            ->assertSee(route('industries'), false)
            ->assertSee(route('philanthropy'), false);

        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Allow: /', false)
            ->assertSee('Disallow: /sanchalak', false)
            ->assertSee(route('sitemap'), false);
    }

    public function test_navigation_uses_the_requested_menu_items(): void
    {
        foreach (['/', '/industries', '/philanthropy'] as $uri) {
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

    public function test_legacy_static_urls_redirect_permanently(): void
    {
        $this->get('/F1_Anmolweb-D.html')->assertRedirect('/');
        $this->get('/F2_Anmolweb-Industries.html')->assertRedirect('/industries');
        $this->get('/F3_Anmolweb-Philanthropy.html')->assertRedirect('/philanthropy');
    }
}
