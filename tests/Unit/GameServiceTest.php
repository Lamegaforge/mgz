<?php

namespace Tests\Unit;

use Config;
use Tests\TestCase;
use App\Services\GameService;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class GameServiceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function get_top_games()
    {
        Config::set('manager.twitch.default_driver', 'mock');

        $games = app(GameService::class)->get();

        $expected = [
            'name' => 'S.T.A.L.K.E.R.',
            'slug' => 'stalker',
            'thumbnail' => 'thumbnail',
        ];

        $this->assertCount(101, $games);
        $this->assertEquals($expected, $games[0]);
    }
}
