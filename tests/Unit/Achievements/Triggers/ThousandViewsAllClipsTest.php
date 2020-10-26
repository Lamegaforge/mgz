<?php

namespace Tests\Unit\Achievements\Triggers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Clip;
use Illuminate\Foundation\Testing\DatabaseMigrations; 
use App\Services\Achievements\Triggers\ThousandViewsAllClips;

class ThousandViewsAllClipsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function eligible()
    {
        $user = User::factory()->create();

        Clip::factory()
            ->times(4)
            ->active()
            ->create([
                'user_id' => $user->id,
                'views' => 250,
            ]);

        $achievement = new ThousandViewsAllClips($user);

        $this->assertTrue($achievement->eligible());
    }

    /**
     * @test
     */
    public function ineligible_with_waiting_clip()
    {
        $user = User::factory()->create();

        Clip::factory()
            ->active()
            ->create([
                'user_id' => $user->id,
                'views' => 500,
            ]);

        Clip::factory()
            ->waiting()
            ->create([
                'user_id' => $user->id,
                'views' => 500,
            ]);

        $achievement = new ThousandViewsAllClips($user);

        $this->assertFalse($achievement->eligible());
    }

    /**
     * @test
     */
    public function ineligible_with_insufficient_views()
    {
        $user = User::factory()->create();

        Clip::factory()
            ->active()
            ->create([
                'user_id' => $user->id,
                'views' => 500,
            ]);

        $achievement = new ThousandViewsAllClips($user);

        $this->assertFalse($achievement->eligible());
    }
}
