<?php

namespace Tests\Unit;

use Auth;
use Tests\TestCase;
use App\Models\User;
use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class NotificationServiceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function read_all()
    {
        $user = User::factory()
            ->has(Notification::factory()->unread()->count(2))
            ->has(Notification::factory()->readed()->count(3))
            ->create();

        app(NotificationService::class)->readAll($user);

        $user->refresh();

        $unreadNotifications = $user->notifications()->unread()->count();

        $this->assertEquals($unreadNotifications, 0);
    }

    /**
     * @test
     */
    public function get_authenticated_user_count()
    {
        $user = User::factory()
            ->has(Notification::factory()->unread()->count(2))
            ->has(Notification::factory()->readed()->count(3))
            ->create();
        
        Auth::login($user);

        $count = app(NotificationService::class)->count();

        $this->assertEquals($count, 2);
    }

    /**
     * @test
     */
    public function get_guest_count()
    {
        $count = app(NotificationService::class)->count();

        $this->assertEquals($count, 0);
    }
}
