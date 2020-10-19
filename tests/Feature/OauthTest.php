<?php

namespace Tests\Feature;

use Auth;
use Config;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class OauthTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function guest_redirect_to_oauth_twitch()
    {
        $response = $this->get('oauth/login');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function auth_redirect_to_home()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('oauth/login');

        $response->assertStatus(302);

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function guest_consume_request()
    {
        Config::set('manager.oauth.default_driver', 'mock');

        $response = $this->get('oauth/consume?state=state&code=code');

        $response->assertStatus(302);
        $response->assertRedirect('/');

        $this->assertTrue(Auth::check());
    }
}
