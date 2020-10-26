<?php

namespace Tests\Unit;

use Config;
use Tests\TestCase;
use App\Models\Clip;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class ClipsUpdaterTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function views_update()
    {
        $clip = Clip::factory()->create();

        Config::set('manager.twitch.default_driver', 'mock');

        $this->artisan('clips:update')->assertExitCode(0);
    }
}
