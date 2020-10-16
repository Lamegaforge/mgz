<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use App\Managers\Twitch\TwitchManager;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class TwitchManagerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function get_last_clips()
    {
        $clips = app(TwitchManager::class)->getLastClips();

        $clip = $clips[0];
        $keys = ['slug', 'tracking_id', 'title', 'url', 'game', 'views', 'thumbnail'];

        $this->handle($clip, $keys);

        $curator = $clip['curator'];
        $keys = ['tracking_id', 'name', 'display_name', 'channel_url', 'logo'];

        $this->handle($curator, $keys);
    }

    /**
     * @test
     */
    public function get_last_videos()
    {
        $videos = app(TwitchManager::class)->getLastVideos();

        $video = $videos[0];
        $keys = ['title', 'game', 'created_at'];

        $this->handle($video, $keys);
    }

    protected function handle(array $sufferer, array $keys): void
    {
        array_map(function ($key) use($sufferer) {
            $this->assertArrayHasKey($key, $sufferer);
        }, $keys);
    }
}
