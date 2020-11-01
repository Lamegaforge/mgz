<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Clip;
use App\Jobs\ProcessAchievements;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class AchievementsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function aggregate()
    {
        Queue::fake();

        Clip::factory()->create();

        $this->artisan('achievements')->assertExitCode(0);

        Queue::assertPushed(ProcessAchievements::class);
    }
}
