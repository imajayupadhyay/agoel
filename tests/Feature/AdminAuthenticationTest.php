<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_page_is_available(): void
    {
        $this->get('/sanchalak')
            ->assertOk()
            ->assertSee('Admin login')
            ->assertSee('noindex, nofollow', false);
    }

    public function test_guest_is_redirected_to_admin_login(): void
    {
        $this->get('/sanchalak/dashboard')
            ->assertRedirect('/sanchalak');
    }

    public function test_admin_can_login_and_view_dashboard(): void
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'TestPassword@123',
        ]);

        $this->post('/sanchalak', [
            'email' => 'admin@gmail.com',
            'password' => 'TestPassword@123',
        ])->assertRedirect('/sanchalak/dashboard');

        $this->assertAuthenticated();

        $this->get('/sanchalak/dashboard')
            ->assertOk()
            ->assertSee('Hello, Admin.')
            ->assertSee('admin@gmail.com')
            ->assertSee('Sanchalak')
            ->assertSee('Dashboard')
            ->assertSee('css/admin.css', false)
            ->assertSee('js/admin.js', false)
            ->assertSee('aria-label="Admin navigation"', false);
    }

    public function test_invalid_credentials_do_not_authenticate(): void
    {
        User::factory()->create([
            'email' => 'admin@gmail.com',
            'password' => 'TestPassword@123',
        ]);

        $this->from('/sanchalak')->post('/sanchalak', [
            'email' => 'admin@gmail.com',
            'password' => 'incorrect-password',
        ])->assertRedirect('/sanchalak')
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_non_admin_user_cannot_access_dashboard(): void
    {
        $user = User::factory()->create([
            'email' => 'person@example.com',
        ]);

        $this->actingAs($user)
            ->get('/sanchalak/dashboard')
            ->assertForbidden();
    }

    public function test_admin_can_logout(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@gmail.com',
        ]);

        $this->actingAs($admin)
            ->post('/sanchalak/logout')
            ->assertRedirect('/sanchalak');

        $this->assertGuest();
    }
}
