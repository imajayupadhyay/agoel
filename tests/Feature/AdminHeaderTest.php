<?php

namespace Tests\Feature;

use App\Models\SiteHeaderNavItem;
use App\Models\SiteHeaderSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminHeaderTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_the_header_editor(): void
    {
        $this->actingAs($this->admin())
            ->get('/sanchalak/header')
            ->assertOk()
            ->assertSee('Manage the public header')
            ->assertSee('Brand')
            ->assertSee('Navigation items')
            ->assertSee('Industries')
            ->assertSee('About Anmol Goel');
    }

    public function test_admin_can_update_brand_reorder_hide_and_add_navigation_items(): void
    {
        $payload = $this->payload();
        $items = SiteHeaderNavItem::query()->orderBy('sort_order')->get();
        $books = $items->firstWhere('label', 'Books');
        $industries = $items->firstWhere('label', 'Industries');

        $payload['settings']['brand_mark'] = 'AG';
        $payload['settings']['brand_name'] = 'Managed Brand';
        $payload['nav_items'] = collect($payload['nav_items'])
            ->map(function (array $item) use ($books, $industries): array {
                if ((int) $item['id'] === $books->id) {
                    $item['sort_order'] = 10;
                }

                if ((int) $item['id'] === $industries->id) {
                    $item['sort_order'] = 20;
                    $item['is_enabled'] = 0;
                }

                return $item;
            })
            ->sortBy('sort_order')
            ->values()
            ->all();

        $payload['nav_items'][] = [
            'id' => null,
            'label' => 'Advisory',
            'url' => '/advisory',
            'sort_order' => 70,
            'is_enabled' => 1,
            'opens_new_tab' => 0,
        ];

        $this->actingAs($this->admin())
            ->put('/sanchalak/header', $payload)
            ->assertRedirect()
            ->assertSessionHas('status');

        $this->get('/books')
            ->assertOk()
            ->assertSee('Managed Brand')
            ->assertSee('AG')
            ->assertSee('href="http://localhost/advisory"', false)
            ->assertSeeInOrder(['>Books<', '>Philanthropy<', '>In the News<', '>Research &amp; Publications<', '>About Anmol Goel<', '>Advisory<'], false)
            ->assertDontSee('>Industries<', false);
    }

    public function test_admin_can_remove_navigation_items(): void
    {
        $payload = $this->payload();
        $payload['nav_items'] = collect($payload['nav_items'])
            ->reject(fn (array $item) => $item['label'] === 'Books')
            ->values()
            ->all();

        $this->actingAs($this->admin())
            ->put('/sanchalak/header', $payload)
            ->assertRedirect();

        $this->assertDatabaseMissing('site_header_nav_items', ['label' => 'Books']);

        $this->get('/about-anmol-goel')
            ->assertOk()
            ->assertDontSee('>Books<', false);
    }

    public function test_unsafe_header_links_are_rejected(): void
    {
        $payload = $this->payload();
        $payload['nav_items'][0]['url'] = 'javascript:alert(1)';

        $this->actingAs($this->admin())
            ->from('/sanchalak/header')
            ->put('/sanchalak/header', $payload)
            ->assertRedirect('/sanchalak/header')
            ->assertSessionHasErrors('nav_items.0.url');
    }

    public function test_non_admin_cannot_manage_header(): void
    {
        $user = User::factory()->create(['email' => 'person@example.com']);

        $this->actingAs($user)
            ->get('/sanchalak/header')
            ->assertForbidden();
    }

    private function admin(): User
    {
        return User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
        ]);
    }

    private function payload(): array
    {
        $settings = SiteHeaderSetting::current();

        return [
            'settings' => [
                'brand_mark' => $settings->brand_mark,
                'brand_name' => $settings->brand_name,
                'brand_url' => $settings->brand_url,
                'is_enabled' => $settings->is_enabled ? 1 : 0,
            ],
            'nav_items' => SiteHeaderNavItem::query()
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get()
                ->map(fn (SiteHeaderNavItem $item) => [
                    'id' => $item->id,
                    'label' => $item->label,
                    'url' => $item->url,
                    'sort_order' => $item->sort_order,
                    'is_enabled' => $item->is_enabled ? 1 : 0,
                    'opens_new_tab' => $item->opens_new_tab ? 1 : 0,
                ])
                ->all(),
        ];
    }
}
