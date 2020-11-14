<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Clip;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ClipTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function get_clips()
    {
        $response = $this->get('clips');

        $response->assertStatus(200);

        $response->assertSee('Tous les clips');
    }

    /**
     * @test
     */
    public function show_clip()
    {
        $clips = Clip::factory()->count(10)->create();

        $response = $this->get('clips/' . $clips->first()->id);

        $response->assertStatus(200);

        $response->assertSee($clips->first()->title);
    }

    /**
     * @test
     */
    public function random()
    {
        $clip = Clip::factory()->create();

        $response = $this->followingRedirects()->get('clips/random');

        $response
            ->assertStatus(200)
            ->assertSee($clip->title);
    }
}
