<?php

namespace Tests\Api;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Clip;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Sequence;
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

        $response = $this->get('api/clips/search?card_id=' . $clip->card->id);

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

        $response = $this->get('api/clips/search?title=' . $truncatedTitle);

        $response
            ->assertStatus(200)
            ->assertJsonPath('clips.data.0.id', $clip->id)
            ->assertJsonPath('clips.data.0.card.id', $clip->card->id);
    }

    /**
     * @test
     */
    public function get_clips_with_user_search()
    {
        $clip = Clip::factory()->create();

        $user = $clip->user;

        $response = $this->get('api/clips/search?user_id=' . $user->id);

        $response
            ->assertStatus(200)
            ->assertJsonPath('clips.data.0.id', $clip->id)
            ->assertJsonPath('clips.data.0.user_id', $user->id);
    }

    /**
     * @test
     */
    public function get_clips_ordered_by_date()
    {
        $clips = Clip::factory()
            ->count(3)
            ->state(new Sequence(
                ['approved_at' => Carbon::yesterday()],
                ['approved_at' => Carbon::today()],
                ['approved_at' => Carbon::tomorrow()],
            ))
            ->create();

        $response = $this->get('api/clips/search?order=approved_at');

        $sorted = $clips->sortBy('approved_at')->values()->all();

        $response
            ->assertStatus(200)
            ->assertJsonPath('clips.data.0.id', $sorted[2]->id)
            ->assertJsonPath('clips.data.1.id', $sorted[1]->id)
            ->assertJsonPath('clips.data.2.id', $sorted[0]->id);
    }

    /**
     * @test
     */
    public function get_clips_ordered_by_views()
    {
        $clips = Clip::factory()
            ->count(3)
            ->state(new Sequence(
                ['views' => 300],
                ['views' => 100],
                ['views' => 200],
            ))
            ->create();

        $response = $this->get('api/clips/search?order=views');

        $sorted = $clips->sortBy('views')->values()->all();

        $response
            ->assertStatus(200)
            ->assertJsonPath('clips.data.0.id', $sorted[2]->id)
            ->assertJsonPath('clips.data.1.id', $sorted[1]->id)
            ->assertJsonPath('clips.data.2.id', $sorted[0]->id);
    }

    /**
     * @test
     */
    public function cannot_get_inactive_clips()
    {
        $clip = Clip::factory()->create([
            'state' => 'waiting',
        ]);

        $response = $this->get('api/clips/search');

        $response
            ->assertStatus(200)
            ->assertJsonMissing(['clips.data.0.id']);
    }
}
