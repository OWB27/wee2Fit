<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActiveUserMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_inactive_user_is_logged_out_and_redirected_to_login(): void
    {
        $inactiveUser = User::factory()->create([
            'is_active' => false,
        ]);

        $response = $this
            ->actingAs($inactiveUser)
            ->get(route('dashboard'));

        $response
            ->assertRedirect(route('login'))
            ->assertSessionHas('error', __('messages.account_inactive'));

        $this->assertGuest();
    }
}
