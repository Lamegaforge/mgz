<?php

namespace Tests\Unit\Achievements;

use Tests\TestCase;
use App\Models\User;
use App\Models\Achievement;
use App\Services\Achievements\AchievementService;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class AchievementServiceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function assignee()
    {
        list($user, $achievement) = $this->prerequisite();

        $assigned = app(AchievementService::class)->assignee($user, $achievement);

        $user->refresh();

        $this->assertEquals(1, $user->achievements->count());
        $this->assertTrue($assigned);
    }

    /**
     * @test
     */
    public function assignee_duplicate()
    {
        list($user, $achievement) = $this->prerequisite();

        $user->achievements()->attach($achievement->id);

        $assigned = app(AchievementService::class)->assignee($user, $achievement);

        $user->refresh();

        $this->assertEquals(1, $user->achievements->count());
        $this->assertFalse($assigned);
    }


    protected function prerequisite(): array
    {
        $user = User::factory()->create();
        $achievement = Achievement::factory()->create();

        return [$user, $achievement];
    }
}
