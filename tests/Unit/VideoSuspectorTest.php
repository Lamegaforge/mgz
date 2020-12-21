<?php

namespace Tests\Unit;

use Config;
use Tests\TestCase;
use App\Services\VideoSuspector;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class VideoSuspectorTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @dataProvider dataProvider
     */
    public function is_clean(string $title, bool $expected)
    {
        Config::set('manager.twitch.default_driver', 'mock');

        $clip = [
            'title' => $title,
            'vod' => [
                'id' => 841550600,
            ],
        ];

        $isClean = app(VideoSuspector::class)->isClean($clip);

        $this->assertEquals($expected, $isClean);
    }

    public function dataProvider(): array
    {
        return [
            [$title = 'video title', $expected = false],
            [$title = 'qsdqsdsqdqs', $expected = true],
        ];
    }
}
