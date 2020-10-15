<?php

namespace Tests\Unit;

use Config;
use Tests\TestCase;
use App\Services\VideoService;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class VideoServiceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function get_last_games()
    {
        Config::set('manager.twitch.default_driver', 'mock');

        $games = app(VideoService::class)->getLastGames();

        $expected = [
            'Dino Crisis 2',
            'Horizon Zero Dawn',
        ];

        $this->assertEquals($expected, $games);
    }
}
