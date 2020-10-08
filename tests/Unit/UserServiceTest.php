<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class UserServiceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function create_user()
    {
        $trackingId = '1';

        $attributes = [
            'tracking_id' => $trackingId,
            'display_name' => 'Alan Grant',
            'profile_image_url' => 'url',
            'login' => 'alan_grant',
        ];

        $user = app(UserService::class)->firstOrCreate($trackingId, $attributes);

        $this->assertInstanceOf(User::class, $user);

        $this->assertEquals($user->id, $attributes['tracking_id']);
        $this->assertEquals($user->display_name, $attributes['display_name']);
        $this->assertEquals($user->profile_image_url, $attributes['profile_image_url']);
        $this->assertEquals($user->login, $attributes['login']);
    }

    /**
     * @test
     */
    public function first_user()
    {
        $user = User::factory()->create();

        $userRetrieved = app(UserService::class)->firstOrCreate($user->tracking_id, $attributes = []);

        $this->assertInstanceOf(User::class, $userRetrieved);
        $this->assertEquals($user->toArray(), $userRetrieved->toArray());
    }
}
