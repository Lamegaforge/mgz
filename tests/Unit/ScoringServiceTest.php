<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Clip;
use App\Models\Favorite;
use App\Models\Achievement;
use App\Services\ScoringService;
use App\Services\Achievements\AchievementService;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ScoringServiceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function create_user()
    {
        $user = User::factory()->create();

        $this->givePoints($user);

        $total = app(ScoringService::class)->total($user);

        $expected = [
            'sum' => 1650,
            'sum_achievements' => 100,
            'sum_clips' => 500,
            'sum_views' => 1000,
            'sum_favorites' => 50,
        ];

        $this->assertEquals($total, $expected);
    }

    protected function givePoints(User $user)
    {
        $clips = $this->giveClipsPoints($user);
        $this->giveFavoritesPoints($clips, $user);
        $this->giveAchievementPoints($user);

        $user->refresh();
    }

    protected function giveClipsPoints(User $user)
    {
        return Clip::factory()->times(5)->create([
            'user_id' => $user->id,
            'views' => 200,
            'state' => 'active',
        ]);
    }

    protected function giveFavoritesPoints($clips, $user)
    {
        Favorite::factory()
            ->times(5)
            ->create([
                'clip_id' => $clips->first->id,
            ]);

        Favorite::factory()
            ->times(5)
            ->create([
                'clip_id' => $clips->first->id,
                'user_id' => $user->id,
            ]);
    }

    protected function giveAchievementPoints(User $user)
    {
        $achievement = Achievement::factory()->create();

        app(AchievementService::class)->assignee($user, $achievement);
    }
}
