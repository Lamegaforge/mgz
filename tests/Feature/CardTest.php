<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Card;
use App\Models\Clip;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CardTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function get_cards()
    {
        Card::factory()->create();

        $response = $this->get('cards');

        $response->assertStatus(200);

        $response->assertSee('Toutes les fiches');
    }

    /**
     * @test
     */
    public function show_card()
    {
        $cards = Card::factory()
            ->has(Clip::factory()->count(3))
            ->count(10)
            ->create();

        $response = $this->get('cards/' . $cards->first()->id);

        $response->assertStatus(200);

        $response->assertSee($cards->first()->title);
        $response->assertSee('Meilleurs clips');
        $response->assertSee('Tous les clips');
    }
}
