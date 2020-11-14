<?php

namespace Tests\Unit\Medias;

use Tests\TestCase;
use App\Models\Card;
use App\Models\Clip;
use Illuminate\Support\Facades\Storage;
use App\Services\Medias\CardBackgroundService;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class CardBackgroundServiceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function get_background()
    {
        Storage::fake('cards');

        Storage::disk('cards')->put('stalker_2/background.jpg', 'content');

        $card = Card::factory()->create([
            'slug' => 'stalker_2',
        ]);

        $path = app(CardBackgroundService::class)->get($card);

        $this->assertEquals($path, '/storage/stalker_2/background.jpg');
    }

    /**
     * @test
     */
    public function get_placeholder()
    {
        $card = Card::factory()
            ->has(Clip::factory())
            ->create();

        $path = app(CardBackgroundService::class)->get($card);

        $clip = $card->clips()->first();

        $this->assertEquals($clip->thumbnail, $path);
    }
}
