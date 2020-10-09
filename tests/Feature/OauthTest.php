<?php

namespace Tests\Feature;

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

        $response->assertStatus(302);

        $headers = $response->headers;

        $this->assertMatchesRegularExpression('#.*id\.twitch\.tv\/oauth2\/authorize#', $headers->get('Location'));
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
}
