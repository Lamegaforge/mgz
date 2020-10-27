<?php

namespace Tests\Api;

use Storage;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AccountTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function update_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('api/account/update-user', [
            'autoplay' => true,
            'description' => 'blablabla',
            'youtube' => 'youtube',
            'instagram' => 'instagram',
            'twitter' => 'twitter',
        ]);

        $response->assertStatus(200);

        $user->refresh();

        $this->assertEquals($user->autoplay, true);
        $this->assertEquals($user->description, 'blablabla');
        $this->assertEquals($user->youtube, 'youtube');
        $this->assertEquals($user->instagram, 'instagram');
        $this->assertEquals($user->twitter, 'twitter');
    }

    /**
     * @test
     */
    public function update_banner()
    {
        list($banner, $user) = $this->prerequisite();

        $response = $this->actingAs($user)->post('api/account/update-banner', [
            'banner' => $banner,
        ]);

        $response->assertStatus(200);

        $user->refresh();

        Storage::disk('banners')->assertExists($banner->hashName());

        $this->assertEquals($user->banner_image_slug, $banner->hashName());
    }

    protected function prerequisite(): array
    {
        Storage::fake('banners');

        return [
            UploadedFile::fake()->image('banner.jpg'),
            User::factory()->create(),
        ];
    }
}
