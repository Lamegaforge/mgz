<?php

namespace Tests\Unit\Achievements\Triggers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Clip;
use Illuminate\Foundation\Testing\DatabaseMigrations; 
use App\Services\Achievements\Triggers\TwoThousandViewsAllClips;

class TwoThousandViewsAllClipsTest extends TestCase
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
                'views' => 500,
            ]);

        $achievement = new TwoThousandViewsAllClips($user);

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
                'views' => 1000,
            ]);

        Clip::factory()
            ->waiting()
            ->create([
                'user_id' => $user->id,
                'views' => 1000,
            ]);

        $achievement = new TwoThousandViewsAllClips($user);

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
                'views' => 1000,
            ]);

        $achievement = new TwoThousandViewsAllClips($user);

        $this->assertFalse($achievement->eligible());
    }
}
