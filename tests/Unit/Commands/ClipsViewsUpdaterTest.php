<?php

namespace Tests\Unit;

use Config;
use Tests\TestCase;
use App\Models\Clip;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class ClipsViewsUpdaterTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function views_update()
    {
        $clip = Clip::factory()->create();

        Config::set('manager.twitch.default_driver', 'mock');

        $this->artisan('clips:views-update')->assertExitCode(0);
    }
}
