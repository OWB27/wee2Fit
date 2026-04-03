<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MyProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_their_business_profile(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->put(route('my-profile.update'), [
                'sex' => 'male',
                'birth_date' => '2002-05-10',
                'height_cm' => '175.0',
                'current_weight_kg' => '72.5',
                'activity_level' => 'moderate',
                'goal' => 'cut',
                'intensity' => 'mild',
            ]);

        $response
            ->assertRedirect(route('my-profile.edit'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
            'sex' => 'male',
            'activity_level' => 'moderate',
            'goal' => 'cut',
            'intensity' => 'mild',
        ]);
    }

    public function test_user_can_update_their_existing_business_profile(): void
    {
        $user = User::factory()->create();

        $user->profile()->create([
            'sex' => 'female',
            'birth_date' => '2001-01-01',
            'height_cm' => '165.0',
            'current_weight_kg' => '60.0',
            'activity_level' => 'light',
            'goal' => 'bulk',
            'intensity' => 'moderate',
        ]);

        $response = $this
            ->actingAs($user)
            ->put(route('my-profile.update'), [
                'sex' => 'female',
                'birth_date' => '2001-01-01',
                'height_cm' => '166.0',
                'current_weight_kg' => '61.0',
                'activity_level' => 'active',
                'goal' => 'bulk',
                'intensity' => 'aggressive',
            ]);

        $response
            ->assertRedirect(route('my-profile.edit'))
            ->assertSessionHasNoErrors();

        $profile = $user->fresh()->profile;

        $this->assertEquals(1, $user->profile()->count());
        $this->assertSame('active', $profile->activity_level);
        $this->assertSame('aggressive', $profile->intensity);
        $this->assertEquals(166.0, (float) $profile->height_cm);
        $this->assertEquals(61.0, (float) $profile->current_weight_kg);
    }
}
