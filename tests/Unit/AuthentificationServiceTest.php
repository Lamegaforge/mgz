<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use App\Services\AuthentificationService;
use Illuminate\Foundation\Testing\DatabaseMigrations; 
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class AuthentificationServiceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function get_user()
    {
        $attributes = [
            'tracking_id' => '1',
            'login' => 'aloy',
            'display_name' => 'Aloy',
            'profile_image_url' => 'url',
            'email' => 'email',
        ];

        $user = app(AuthentificationService::class)->getUser($attributes);

        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * @test
     */
    public function get_outdated_user()
    {
        $user = User::factory()->create([
            'created_at' => Carbon::yesterday(),
            'profile_image_url' => null,
            'email' => null,
        ]);

        $attributes = $user->only('login', 'display_name');

        $attributes['tracking_id'] = $user->id;
        $attributes['profile_image_url'] = 'profile_image_url';
        $attributes['email'] = 'email';

        $user = app(AuthentificationService::class)->getUser($attributes);

        $this->assertInstanceOf(User::class, $user);
        
        $this->assertEquals($user->profile_image_url, 'profile_image_url');
        $this->assertEquals($user->email, 'email');
    }
}
