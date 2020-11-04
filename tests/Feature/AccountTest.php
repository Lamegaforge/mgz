<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AccountTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function guest_cannot_access_account()
    {
        $response = $this->get('users/account');

        $response->assertStatus(302);
    }

    /**
     * @test
     */
    public function guest_cannot_access_settings()
    {
        $response = $this->get('users/account/settings');

        $response->assertStatus(302);
    }

    /**
     * @test
     */
    public function auth_can_access_account()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('users/account/settings');

        $response
            ->assertStatus(200)
            ->assertSee($user->display_name);
    }

    /**
     * @test
     */
    public function auth_can_access_settings()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('users/account/settings');

        $response
            ->assertStatus(200)
            ->assertSee($user->display_name);
    }
}
