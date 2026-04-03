<?php

namespace Tests\Feature;

use App\Models\BodyMetric;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProgressTrackingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_store_a_body_metric(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('progress.store'), [
                'recorded_on' => now()->toDateString(),
                'weight_kg' => '71.5',
                'body_fat_percentage' => '18.2',
                'note' => 'Morning weigh-in.',
            ]);

        $response
            ->assertRedirect(route('progress.index'))
            ->assertSessionHas('success', __('messages.progress_metric_created'));

        $this->assertDatabaseHas('body_metrics', [
            'user_id' => $user->id,
            'note' => 'Morning weigh-in.',
        ]);
    }

    public function test_user_can_delete_their_own_body_metric(): void
    {
        $user = User::factory()->create();

        $metric = BodyMetric::create([
            'user_id' => $user->id,
            'recorded_on' => now()->toDateString(),
            'weight_kg' => 72.0,
            'body_fat_percentage' => 19.0,
            'note' => 'Test entry',
        ]);

        $response = $this
            ->actingAs($user)
            ->delete(route('progress.destroy', $metric));

        $response
            ->assertRedirect(route('progress.index'))
            ->assertSessionHas('success', __('messages.progress_metric_deleted'));

        $this->assertDatabaseMissing('body_metrics', [
            'id' => $metric->id,
        ]);
    }

    public function test_user_cannot_delete_another_users_body_metric(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();

        $metric = BodyMetric::create([
            'user_id' => $owner->id,
            'recorded_on' => now()->toDateString(),
            'weight_kg' => 72.0,
            'body_fat_percentage' => null,
            'note' => null,
        ]);

        $response = $this
            ->actingAs($intruder)
            ->delete(route('progress.destroy', $metric));

        $response->assertForbidden();

        $this->assertDatabaseHas('body_metrics', [
            'id' => $metric->id,
        ]);
    }

    public function test_user_cannot_store_a_body_metric_with_a_future_date(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from(route('progress.index'))
            ->post(route('progress.store'), [
                'recorded_on' => now()->addDay()->toDateString(),
                'weight_kg' => '71.5',
                'body_fat_percentage' => '18.2',
                'note' => 'Future entry',
            ]);

        $response
            ->assertRedirect(route('progress.index'))
            ->assertSessionHasErrors('recorded_on');

        $this->assertDatabaseMissing('body_metrics', [
            'user_id' => $user->id,
            'note' => 'Future entry',
        ]);
    }
}
