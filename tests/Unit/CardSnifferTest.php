<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Card;
use App\Models\Clip;
use App\Services\CardSniffer;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class CardSnifferTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function retrieve()
    {
        $cardsWithMoreClips = $this->prerequisite();

        $card = app(CardSniffer::class)->retrieve('same_game_title');

        $this->assertInstanceOf(Card::class, $card);
        $this->assertEquals($card->id, $cardsWithMoreClips->id);
    }

    /**
     * @test
     */
    public function no_results()
    {
        $cardsWithMoreClips = $this->prerequisite();

        $card = app(CardSniffer::class)->retrieve('other_game_title');

        $this->assertNull($card);
    }

    protected function prerequisite(): Card
    {
        $cards = Card::factory()
            ->count(3)
            ->create();

        $this->clipsFactory($cards[0], $count = 1);
        $this->clipsFactory($cards[1], $count = 3);
        $this->clipsFactory($cards[2], $count = 2);

        return $cards[1];
    }

    protected function clipsFactory(Card $card, int $count): void
    {
        Clip::factory()
            ->count($count)
            ->create([
                'card_id' => $card->id,
                'game' => 'same_game_title',
            ]);
    }
}
