<?php

namespace Tests\Unit;

use Storage;
use Tests\TestCase;
use App\Models\User;
use App\Services\AccountService;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class AccountServiceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @dataProvider provider
     */
    public function refresh_banner($slug)
    {
        Storage::fake('banners');

        $user = User::factory()->create([
            'banner_image_slug' => $slug,
        ]);

        app(AccountService::class)->refreshBanner($user, 'new_banner_image_slug');

        $user->refresh();

        $this->assertEquals($user->banner_image_slug, 'new_banner_image_slug');
    }

    public function provider(): array
    {
        return [
            [null],
            ['banner_slug'],
        ];
    }
}
