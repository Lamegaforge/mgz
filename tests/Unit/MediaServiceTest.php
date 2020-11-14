<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\MediaService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class MediaServiceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @dataProvider provider
     */
    // public function get_medias(string $method, string $file, string $expected)
    // {
    //     Storage::fake('cards');

    //     Storage::disk('cards')->put('stalker2/' . $file, 'content');

    //     $path = app(MediaService::class)->{$method}('stalker2');

    //     $this->assertEquals($expected, $path);
    // }

    // public function provider(): array
    // {
    //     return [
    //         ['background', 'background.jpg', '/storage/stalker2/background.jpg'],
    //         ['vignette', 'vignette.jpg', '/storage/stalker2/vignette.jpg'],
    //     ];
    // }

    /**
     * @test
     * @dataProvider placeholdersProvider
     */
    // public function get_placeholders(string $method, string $file, string $expected)
    // {
    //     Storage::fake('cards');

    //     $path = app(MediaService::class)->{$method}('dinocrisis3');

    //     $this->assertEquals($expected, $path);
    // }

    // public function placeholdersProvider(): array
    // {
    //     return [
    //         ['background', 'background.jpg', '/storage/placeholders/background.jpg'],
    //         ['vignette', 'vignette.jpg', '/storage/placeholders/vignette.jpg'],
    //     ];
    // }
}
