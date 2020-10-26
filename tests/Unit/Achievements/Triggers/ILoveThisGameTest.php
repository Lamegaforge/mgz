<?php

namespace Tests\Unit\Achievements\Triggers;

use Tests\TestCase;
use App\Models\Clip;
use App\Models\User;
use App\Models\Card;
use Illuminate\Foundation\Testing\DatabaseMigrations; 
use App\Services\Achievements\Triggers\ILoveThisGame;

class ILoveThisGameTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @dataProvider dataProvider
     */
    public function eligible(int $times, bool $expected)
    {   
        $user = User::factory()->create();
        $card = Card::factory()->create();

        Clip::factory()
            ->times($times)
            ->create([
                'user_id' => $user->id,
                'card_id' => $card->id,
            ]);

        $trigger = new ILoveThisGame($user);

        $this->assertEquals($expected, $trigger->eligible());
    }

    public function dataProvider(): array
    {
        return [
            [9, $expected = false],
            [10, $expected = true],
            [11, $expected = true],
        ];
    }
}
