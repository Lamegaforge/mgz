<?php

namespace Tests\Feature\Api;

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
        $clip = Clip::factory()->create();

        $response = $this->get('api/clips/search');

        $clip->load('card');

        $response
            ->assertStatus(200)
            ->assertJsonPath('clips.data.0.id', $clip->id)
            ->assertJsonPath('clips.data.0.card.id', $clip->card->id);
    }
}
