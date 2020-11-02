<?php

namespace Tests\Api;

use Tests\TestCase;
use App\Models\User;
use App\Models\Clip;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoriteTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function get_favorites()
    {
        $user = User::factory()->create();
        $clip = Clip::factory()->create();

        $user->favorites()->attach($clip->id);

        $response = $this->get('api/favorites/search/' . $user->id);

        $favorites = $user->favorites;

        $response
            ->assertStatus(200)
            ->assertJsonPath('clips.data.0.id', $favorites->first()->id);
    }

    /**
     * @test
     */
    public function toggle_on_to_off()
    {
        $user = User::factory()->create();
        $clip = Clip::factory()->create();

        $response = $this->actingAs($user)->post('api/favorites/toggle', [
            'clip_id' => $clip->id,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'clip_id' => $clip->id,
        ]);
    }

    /**
     * @test
     */
    public function toggle_off_to_on()
    {
        $user = User::factory()->create();
        $clip = Clip::factory()->create();

        $user->favorites()->attach($clip->id);

        $response = $this->actingAs($user)->post('api/favorites/toggle', [
            'clip_id' => $clip->id,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'clip_id' => $clip->id,
        ]);
    }

    /**
     * @test
     */
    public function guest_cannot_toggle()
    {
        $clip = Clip::factory()->create();

        $response = $this->post('api/favorites/toggle', [
            'clip_id' => $clip->id,
        ]);

        $response->assertStatus(403);
    }
}
