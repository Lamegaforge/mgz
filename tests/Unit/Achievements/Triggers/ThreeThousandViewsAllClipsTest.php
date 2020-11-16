<?php

namespace Tests\Unit\Achievements\Triggers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Clip;
use Illuminate\Foundation\Testing\DatabaseMigrations; 
use App\Services\Achievements\Triggers\ViewsAllClips\ThreeThousand;

class ThreeThousandViewsAllClipsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function eligible()
    {
        $user = User::factory()->create();

        Clip::factory()
            ->times(3)
            ->active()
            ->create([
                'user_id' => $user->id,
                'views' => 1000,
            ]);

        $achievement = new ThreeThousand($user);

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
                'views' => 2000,
            ]);

        Clip::factory()
            ->waiting()
            ->create([
                'user_id' => $user->id,
                'views' => 1000,
            ]);

        $achievement = new ThreeThousand($user);

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
                'views' => 2000,
            ]);

        $achievement = new ThreeThousand($user);

        $this->assertFalse($achievement->eligible());
    }
}
