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
     * @dataProvider unlockedAchievementsProvider
     */
    public function search_achievements(bool $secret)
    {
        $user = User::factory()->create();

        $achievement = Achievement::factory()->create([
            'secret' => $secret,
        ]);

        app(AchievementService::class)->assignee($user, $achievement);

        $response = $this->get('api/achievements/search/' . $user->id);

        $response
            ->assertStatus(200)
            ->assertJsonPath('achievements.data.0.id', $achievement->id)
            ->assertJsonPath('achievements.data.0.description', $achievement->description)
            ->assertJsonPath('achievements.data.0.unlocked_at', $achievement->created_at->toDateTimeString());
    }

    public function unlockedAchievementsProvider()
    {
        return [
            [$secret = false],
            [$secret = true],
        ];
    }

    /**
     * @dataProvider lockedAchievementsProvider
     */
    public function search_unlocked_achievements(bool $secret)
    {
        $user = User::factory()->create();

        $achievement = Achievement::factory()->create([
            'secret' => $secret,
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
    public function lockedAchievementsProvider()
    {
        return [
            [$secret = false],
            [$secret = true],
        ];
    }
}
