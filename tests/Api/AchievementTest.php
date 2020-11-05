<?php

namespace Tests\Api;

use Tests\TestCase;
use App\Models\User;
use App\Models\Achievement;
use App\Services\Achievements\AchievementService;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AchievementTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @dataProvider dataProvider
     */
    public function user_search_achievements(bool $secret)
    {
        $user = User::factory()->create();

        $achievement = Achievement::factory()->create([
            'secret' => $secret,
            'description' => 'blablabla',
        ]);

        app(AchievementService::class)->assignee($user, $achievement);

        $response = $this->actingAs($user)->get('api/achievements/search/' . $user->id);

        $response
            ->assertStatus(200)
            ->assertJsonPath('achievements.data.0.id', $achievement->id)
            ->assertJsonPath('achievements.data.0.description', $achievement->description)
            ->assertJsonPath('achievements.data.0.unlocked_at', $achievement->created_at->toDateTimeString());
    }

    /**
     * @test
     */
    public function guest_search_achievements()
    {
        $user = User::factory()->create();

        $achievement = Achievement::factory()->create([
            'secret' => true,
            'description' => 'blablabla',
        ]);

        app(AchievementService::class)->assignee($user, $achievement);

        $response = $this->get('api/achievements/search/' . $user->id);

        $response
            ->assertStatus(200)
            ->assertJsonPath('achievements.data.0.id', $achievement->id)
            ->assertJsonPath('achievements.data.0.description', null)
            ->assertJsonPath('achievements.data.0.unlocked_at', $achievement->created_at->toDateTimeString());
    }

    /**
     * @dataProvider dataProvider
     */
    public function search_unlocked_achievements(bool $secret)
    {
        $user = User::factory()->create();

        $achievement = Achievement::factory()->create([
            'secret' => $secret,
            'description' => 'blablabla',
        ]);

        $response = $this->get('api/achievements/search/' . $user->id);

        $description = ($secret) ? null : $achievement->description;

        $response
            ->assertStatus(200)
            ->assertJsonPath('achievements.data.0.id', $achievement->id)
            ->assertJsonPath('achievements.data.0.description', $description)
            ->assertJsonPath('achievements.data.0.unlocked_at', null);
    }

    /**
     * @dataProvider 
     */
    public function dataProvider()
    {
        return [
            [$secret = false],
            [$secret = true],
        ];
    }
}
