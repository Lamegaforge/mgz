<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function get_notifications()
    {
        $user = User::factory()
            ->has(Notification::factory()->unread()->count(2))
            ->has(Notification::factory()->readed()->count(3))
            ->create();

        $response = $this->actingAs($user)->get('users/notifications');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function get_ranking()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('users');

        $response
            ->assertStatus(200)
            ->assertSee('Classement')
            ->assertSee($user->display_name);
    }
}
