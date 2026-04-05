<?php

namespace Tests\Feature;

use App\Models\UserTag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_toggle_another_users_active_status(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'is_active' => true,
        ]);

        $member = User::factory()->create([
            'role' => User::ROLE_USER,
            'is_active' => true,
        ]);

        $response = $this
            ->actingAs($admin)
            ->patch(route('admin.users.toggle-active', $member));

        $response
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('success', __('messages.admin_user_status_updated'));

        $this->assertFalse($member->fresh()->is_active);
    }

    public function test_admin_cannot_disable_their_own_account(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'is_active' => true,
        ]);

        $response = $this
            ->actingAs($admin)
            ->patch(route('admin.users.toggle-active', $admin));

        $response
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('error', __('messages.admin_users_cannot_disable_self'));

        $this->assertTrue($admin->fresh()->is_active);
    }

    public function test_admin_can_update_user_tags(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'is_active' => true,
        ]);

        $member = User::factory()->create([
            'role' => User::ROLE_USER,
            'is_active' => true,
        ]);

        $tagIds = UserTag::query()
            ->whereIn('slug', ['new_user', 'test_account'])
            ->pluck('id')
            ->all();

        $response = $this
            ->actingAs($admin)
            ->put(route('admin.users.update', $member), [
                'user_tag_ids' => $tagIds,
            ]);

        $response
            ->assertRedirect(route('admin.users.edit', $member))
            ->assertSessionHas('success', __('messages.admin_user_updated'));

        $this->assertEqualsCanonicalizing($tagIds, $member->fresh()->tags()->pluck('user_tags.id')->all());
    }
}
