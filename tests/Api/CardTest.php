<?php

namespace Tests\Api;

use Tests\TestCase;
use App\Models\Card;
use App\Models\Clip;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CardTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function get_cards()
    {
        $card = Card::factory()
            ->has(Clip::factory()->count(3))
            ->create();

        $response = $this->get('api/cards/search');

        $response
            ->assertStatus(200)
            ->assertJsonPath('cards.data.0.id', $card->id);
    }

    /**
     * @test
     */
    public function get_cards_with_title_search()
    {
        $card = Card::factory()
            ->has(Clip::factory()->count(3))
            ->create();

        $truncatedTitle = Str::limit($card->title, 5, $end = null);

        $response = $this->get('api/cards/search', [
            'title' => $truncatedTitle,
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonPath('cards.data.0.id', $card->id);
    }

    /**
     * @test
     */
    public function cannot_get_card_without_active_clips()
    {
        $card = Card::factory()->create();

        $response = $this->get('api/cards/search');

        $response
            ->assertStatus(200)
            ->assertJsonPath('cards.total', 0);
    }
}
