<?php

namespace Tests\Feature;

use App\Models\NewsletterSubscriber;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsletterTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_newsletter_form_posts_to_subscription_endpoint(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('action="'.route('newsletter.subscribe').'"', false)
            ->assertSee('name="email"', false)
            ->assertSee('name="website"', false)
            ->assertSee('data-newsletter', false);
    }

    public function test_visitor_can_subscribe_to_newsletter(): void
    {
        $this->postJson('/newsletter', [
            'email' => 'Reader@Example.com',
            'source' => 'homepage',
            'website' => '',
        ])
            ->assertOk()
            ->assertJsonPath('message', 'Thank you — you are on the list.');

        $this->assertDatabaseHas('newsletter_subscribers', [
            'email' => 'reader@example.com',
            'status' => 'active',
            'source' => 'homepage',
        ]);

        $subscriber = NewsletterSubscriber::query()->firstOrFail();
        $this->assertNotNull($subscriber->subscribed_at);
    }

    public function test_duplicate_newsletter_subscription_does_not_create_duplicate_rows(): void
    {
        NewsletterSubscriber::query()->create([
            'email' => 'reader@example.com',
            'status' => 'active',
            'source' => 'homepage',
            'subscribed_at' => now(),
        ]);

        $this->postJson('/newsletter', [
            'email' => 'reader@example.com',
            'source' => 'homepage',
            'website' => '',
        ])->assertOk();

        $this->assertSame(1, NewsletterSubscriber::query()->where('email', 'reader@example.com')->count());
    }

    public function test_newsletter_honeypot_submission_is_ignored(): void
    {
        $this->postJson('/newsletter', [
            'email' => 'bot@example.com',
            'source' => 'homepage',
            'website' => 'filled by bot',
        ])->assertOk();

        $this->assertDatabaseMissing('newsletter_subscribers', [
            'email' => 'bot@example.com',
        ]);
    }

    public function test_admin_can_view_filter_update_and_delete_newsletter_entries(): void
    {
        $active = NewsletterSubscriber::query()->create([
            'email' => 'active@example.com',
            'status' => 'active',
            'source' => 'homepage',
            'subscribed_at' => now(),
        ]);

        NewsletterSubscriber::query()->create([
            'email' => 'old@example.com',
            'status' => 'unsubscribed',
            'source' => 'homepage',
            'subscribed_at' => now()->subDay(),
            'unsubscribed_at' => now(),
        ]);
        $admin = $this->admin();

        $this->actingAs($admin)
            ->get('/edit99/newsletters?status=active')
            ->assertOk()
            ->assertSee('Newsletter subscriptions')
            ->assertSee('active@example.com')
            ->assertDontSee('old@example.com');

        $this->actingAs($admin)
            ->patch("/edit99/newsletters/{$active->id}", ['status' => 'unsubscribed'])
            ->assertRedirect();

        $active->refresh();
        $this->assertSame('unsubscribed', $active->status);
        $this->assertNotNull($active->unsubscribed_at);

        $this->actingAs($admin)
            ->delete("/edit99/newsletters/{$active->id}")
            ->assertRedirect();

        $this->assertDatabaseMissing('newsletter_subscribers', [
            'email' => 'active@example.com',
        ]);
    }

    public function test_non_admin_cannot_manage_newsletters(): void
    {
        $user = User::factory()->create(['email' => 'person@example.com']);

        $this->actingAs($user)
            ->get('/edit99/newsletters')
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
