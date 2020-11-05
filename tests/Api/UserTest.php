<?php

namespace Tests\Api;

use Tests\TestCase;
use App\Models\Clip;
use App\Models\User;
use App\Models\Achievement;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function get_users()
    {
        $user = User::factory()->create();

        $response = $this->get('api/users/search');

        $response
            ->assertStatus(200)
            ->assertJsonPath('users.data.0.id', $user->id);
    }

    /**
     * @test
     */
    public function get_users_ordered_by_clips()
    {
        User::factory()
            ->has(Clip::factory()->count(3))
            ->create();

        User::factory()
            ->has(Clip::factory()->count(5))
            ->create();

        User::factory()
            ->has(Clip::factory()->count(4))
            ->create();

        $response = $this->get('api/users/search?order=clips');

        $response
            ->assertStatus(200)
            ->assertJsonPath('users.data.0.clips_count', '5')
            ->assertJsonPath('users.data.0.rank', 1)
            ->assertJsonPath('users.data.1.clips_count', '4')
            ->assertJsonPath('users.data.1.rank', 2)
            ->assertJsonPath('users.data.2.clips_count', '3')
            ->assertJsonPath('users.data.2.rank', 3);
    }

    /**
     * @test
     */
    public function get_users_ordered_by_achievements()
    {
        User::factory()
            ->has(Achievement::factory()->count(3))
            ->create();

        User::factory()
            ->has(Achievement::factory()->count(5))
            ->create();

        User::factory()
            ->has(Achievement::factory()->count(4))
            ->create();

        $response = $this->get('api/users/search?order=achievements');

        $response
            ->assertStatus(200)
            ->assertJsonPath('users.data.0.achievements_count', '5')
            ->assertJsonPath('users.data.0.rank', 1)
            ->assertJsonPath('users.data.1.achievements_count', '4')
            ->assertJsonPath('users.data.1.rank', 2)
            ->assertJsonPath('users.data.2.achievements_count', '3')
            ->assertJsonPath('users.data.2.rank', 3);
    }

    /**
     * @test
     */
    public function get_users_ordered_by_points()
    {
        $users = User::factory()
            ->count(3)
            ->state(new Sequence(
                ['points' => 100],
                ['points' => 300],
                ['points' => 200],
            ))
            ->create();

        $response = $this->get('api/users/search?order=approved_at');

        $sorted = $users->sortBy('points')->values()->all();

        $response
            ->assertStatus(200)
            ->assertJsonPath('users.data.0.id', $sorted[2]->id)
            ->assertJsonPath('users.data.0.rank', 1)
            ->assertJsonPath('users.data.1.id', $sorted[1]->id)
            ->assertJsonPath('users.data.1.rank', 2)
            ->assertJsonPath('users.data.2.id', $sorted[0]->id)
            ->assertJsonPath('users.data.2.rank', 3);
    }

    /**
     * @test
     */
    /**
     * @test
     */
    public function get_users_with_display_name_search()
    {
        $user = User::factory()->create();

        $truncated = Str::limit($user->title, 5, $end = null);

        $response = $this->get('api/users/search?display_name=' . $truncated);

        $response
            ->assertStatus(200)
            ->assertJsonPath('users.data.0.id', $user->id);
    }
}
