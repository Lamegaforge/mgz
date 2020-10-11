<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Clip;
use Illuminate\Support\Str;
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

    /**
     * @test
     */
    public function get_clips_with_card_search()
    {
        $clip = Clip::factory()->create();

        $clip->load('card');

        $response = $this->get('api/clips/search', [
            'card_id' => $clip->card->id,
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonPath('clips.data.0.id', $clip->id)
            ->assertJsonPath('clips.data.0.card.id', $clip->card->id);
    }

    /**
     * @test
     */
    public function get_clips_with_title_search()
    {
        $clip = Clip::factory()->create();

        $clip->load('card');

        $truncatedTitle = Str::limit($clip->title, 5, $end = null);

        $response = $this->get('api/clips/search', [
            'title' => $truncatedTitle,
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonPath('clips.data.0.id', $clip->id)
            ->assertJsonPath('clips.data.0.card.id', $clip->card->id);
    }

    /**
     * @test
     */
    public function cannot_get_inactive_clips()
    {
        $clip = Clip::factory()->create([
            'active' => false,
        ]);

        $response = $this->get('api/clips/search');

        $response
            ->assertStatus(200)
            ->assertJsonMissing(['clips.data.0.id']);
    }
}
