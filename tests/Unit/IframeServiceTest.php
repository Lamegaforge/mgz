<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Clip;
use App\Services\IframeService;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class IframeServiceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function url_guest()
    {
        $clip = Clip::factory()->create();

        $url = app(IframeService::class)->url($clip);

        $expected = 'https://clips.twitch.tv/embed' .
            '?clip=' . $clip->slug . 
            '&parent=megasaurus.fr' .
            '&parent=staging.megasaurus.fr' .
            '&allowfullscreen=true' .
            '&autoplay=false';

        $this->assertEquals($url, $expected);
    }

    /**
     * @test
     */
    public function url_auth_with_autoplay()
    {
        $clip = Clip::factory()->create();
        $user = User::factory()->create([
            'autoplay' => true,
        ]);

        $this->actingAs($user, 'web');

        $url = app(IframeService::class)->url($clip);

        $expected = 'https://clips.twitch.tv/embed' .
            '?clip=' . $clip->slug . 
            '&parent=megasaurus.fr' .
            '&parent=staging.megasaurus.fr' .
            '&allowfullscreen=true' .
            '&autoplay=true';

        $this->assertEquals($url, $expected);
    }

    /**
     * @test
     */
    public function url_auth_without_autoplay()
    {
        $clip = Clip::factory()->create();
        $user = User::factory()->create([
            'autoplay' => false,
        ]);

        $this->actingAs($user, 'web');

        $url = app(IframeService::class)->url($clip);

        $expected = 'https://clips.twitch.tv/embed' .
            '?clip=' . $clip->slug . 
            '&parent=megasaurus.fr' .
            '&parent=staging.megasaurus.fr' .
            '&allowfullscreen=true' .
            '&autoplay=false';

        $this->assertEquals($url, $expected);
    }
}
