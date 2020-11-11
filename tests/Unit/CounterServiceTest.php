<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Services\CounterService;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class CounterServiceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function get_empty_count()
    {
        $user = User::factory()->create();

        $count = app(CounterService::class)->count($user, 'banner');

        $this->assertEquals(0, $count);
    }

    /**
     * @test
     */
    public function get_count()
    {
        $user = User::factory()->create();

        app(CounterService::class)->increment($user, 'banner');
        app(CounterService::class)->increment($user, 'banner');
        app(CounterService::class)->increment($user, 'banner');

        $count = app(CounterService::class)->count($user, 'banner');

        $this->assertEquals(3, $count);
    }


    /**
     * @test
     */
    public function increment_banner()
    {
        $user = User::factory()->create();

        $count = app(CounterService::class)->increment($user, 'banner');

        $this->assertEquals($user->id, $count->user_id);
        $this->assertEquals(1, $count->values);
        $this->assertEquals('banner', $count->slug);
    }

    /**
     * @test
     */
    public function increment_banner_many_times()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        app(CounterService::class)->increment($user, 'banner');
        app(CounterService::class)->increment($otherUser, 'banner');
        $count = app(CounterService::class)->increment($user, 'banner');

        $this->assertEquals($user->id, $count->user_id);
        $this->assertEquals(2, $count->values);
        $this->assertEquals('banner', $count->slug);
    }
}
