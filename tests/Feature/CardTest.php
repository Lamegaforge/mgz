<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Card;
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
    }

    /**
     * @test
     */
    public function show_card()
    {
        $cards = Card::factory()->count(10)->create();

        $response = $this->get('cards/' . $cards->first()->id);

        $response->assertStatus(200);
    }
}
