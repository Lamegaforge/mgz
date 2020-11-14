<?php

namespace Tests\Unit\Medias;

use Tests\TestCase;
use App\Models\Card;
use Illuminate\Support\Facades\Storage;
use App\Services\Medias\CardVignetteService;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class CardVignetteServiceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @dataProvider provider
     */
    public function get_media(string $slug, string $file, string $expected)
    {
        Storage::fake('cards');

        Storage::disk('cards')->put('stalker_2/' . $file, 'content');

        $card = Card::factory()->create([
            'slug' => $slug,
        ]);

        $path = app(CardVignetteService::class)->get($card);

        $this->assertEquals($expected, $path);
    }

    public function provider(): array
    {
        return [
            ['stalker_2', 'vignette.jpg', '/storage/stalker_2/vignette.jpg'],
            ['other_slug', 'vignette.jpg', '/storage//placeholders/vignette.jpg'],
        ];
    }
}
