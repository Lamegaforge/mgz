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
    public function get_medias(string $method, string $file, string $expected)
    {
        Storage::fake('cards');

        Storage::disk('cards')->put('stalker2/' . $file, 'content');

        $path = app(MediaService::class)->{$method}('stalker2');

        $this->assertEquals($expected, $path);
    }

    public function provider(): array
    {
        return [
            ['background', 'background.png', '/storage/stalker2/background.png'],
            ['logo', 'logo.png', '/storage/stalker2/logo.png'],
            ['smallLogo', 'small-logo.png', '/storage/stalker2/small-logo.png'],
            ['vignette', 'vignette.png', '/storage/stalker2/vignette.png'],
        ];
    }

    /**
     * @test
     * @dataProvider placeholdersProvider
     */
    public function get_placeholders(string $method, string $file, string $expected)
    {
        Storage::fake('cards');

        $path = app(MediaService::class)->{$method}('dinocrisis3');

        $this->assertEquals($expected, $path);
    }

    public function placeholdersProvider(): array
    {
        return [
            ['background', 'background.png', '/storage/placeholders/background.png'],
            ['logo', 'logo.png', '/storage/placeholders/logo.png'],
            ['smallLogo', 'small-logo.png', '/storage/placeholders/small-logo.png'],
            ['vignette', 'vignette.png', '/storage/placeholders/vignette.png'],
        ];
    }
}
