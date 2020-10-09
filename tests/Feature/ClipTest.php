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
        Clip::factory()->count(10)->create();

        $response = $this->get('clips');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function show_clip()
    {
        $clips = Clip::factory()->count(10)->create();

        $response = $this->get('clips/' . $clips->first()->id);

        $response->assertStatus(200);
    }
}
