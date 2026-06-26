<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminUsersTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_users_page(): void
    {
        $admin = User::factory()->admin()->create([
            'name' => 'Primary Admin',
            'email' => 'admin@example.com',
        ]);

        User::factory()->create([
            'name' => 'Editor User',
            'email' => 'editor@example.com',
        ]);

        $this->actingAs($admin)
            ->get('/edit99/users')
            ->assertOk()
            ->assertSee('Manage administrators')
            ->assertSee('Primary Admin')
            ->assertDontSee('editor@example.com')
            ->assertDontSee('Standard users')
            ->assertDontSee('Administrator access')
            ->assertSee('css/admin-users.css', false);
    }

    public function test_admin_can_create_another_admin(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post('/edit99/users', [
                'name' => 'Second Admin',
                'email' => 'second-admin@example.com',
                'password' => 'NewAdminPass123',
                'password_confirmation' => 'NewAdminPass123',
            ])
            ->assertRedirect('/edit99/users');

        $created = User::query()->where('email', 'second-admin@example.com')->firstOrFail();

        $this->assertTrue($created->is_admin);
        $this->assertTrue(Hash::check('NewAdminPass123', $created->password));
    }

    public function test_admin_can_update_administrator_details(): void
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->admin()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
        ]);

        $this->actingAs($admin)
            ->put("/edit99/users/{$user->id}", [
                'name' => 'New Name',
                'email' => 'new@example.com',
            ])
            ->assertRedirect('/edit99/users');

        $user->refresh();

        $this->assertSame('New Name', $user->name);
        $this->assertSame('new@example.com', $user->email);
        $this->assertTrue($user->is_admin);
    }

    public function test_admin_can_reset_user_password(): void
    {
        User::factory()->admin()->create([
            'email' => 'admin@example.com',
            'password' => 'OriginalAdminPass123',
        ]);

        $target = User::factory()->admin()->create([
            'email' => 'target-admin@example.com',
            'password' => 'OldTargetPass123',
        ]);

        $this->actingAs(User::query()->where('email', 'admin@example.com')->first())
            ->put("/edit99/users/{$target->id}/password", [
                'password' => 'UpdatedTargetPass123',
                'password_confirmation' => 'UpdatedTargetPass123',
            ])
            ->assertRedirect('/edit99/users');

        $this->post('/edit99', [
            'email' => 'target-admin@example.com',
            'password' => 'UpdatedTargetPass123',
        ])->assertRedirect('/edit99/dashboard');
    }

    public function test_admin_cannot_delete_own_account(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->delete("/edit99/users/{$admin->id}")
            ->assertSessionHasErrors('user');

        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_non_admin_cannot_access_users_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/edit99/users')
            ->assertForbidden();
    }
}
