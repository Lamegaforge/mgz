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
     */
    public function refresh_banner()
    {
        list($user, $slug) = $this->prerequisite();

        app(AccountService::class)->refreshBanner($user, $slug);

        $user->refresh();

        $this->assertEquals($user->banner_image_slug, $slug);
    }

    protected function prerequisite()
    {
        Storage::fake('banners');

        return [
            User::factory()->create(),
            'new_banner_image_slug',
        ];
    }
}
