<?php

namespace Tests\Unit\Achievements\Triggers;

use Tests\TestCase;
use App\Models\Clip;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations; 
use App\Services\Achievements\Triggers\CompulsiveClipper;

class CompulsiveClipperTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function eligible()
    {   
        $user = User::factory()->create();

        Clip::factory()
            ->times(2)
            ->create([
                'approved_at' => '2020-01-01',
                'user_id' => $user->id,
            ]);

        Clip::factory()
            ->times(5)
            ->create([
                'approved_at' => '2020-01-03',
                'user_id' => $user->id,
            ]);

        $trigger = new CompulsiveClipper($user);

        $this->assertTrue($trigger->eligible());
    }

    /**
     * @test
     */
    public function ineligible()
    {
        $user = User::factory()->create();

        Clip::factory()
            ->times(6)
            ->create([
                'approved_at' => '2020-01-01',
                'user_id' => $user->id,
            ]);

        Clip::factory()
            ->times(1)
            ->create([
                'approved_at' => '2020-01-08',
                'user_id' => $user->id,
            ]);

        $trigger = new CompulsiveClipper($user);

        $this->assertFalse($trigger->eligible());
    }
}
