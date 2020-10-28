<?php

namespace Tests\Unit\Achievements;

use Tests\TestCase;
use App\Models\User;
use App\Models\Counter;
use App\Services\Achievements\CounterService;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class CounterServiceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function increment()
    {
        $user = User::factory()->create();

        $counter = app(CounterService::class)->increment($user, 'slug');

        $this->assertInstanceOf(Counter::class, $counter);
        $this->assertEquals(1, $counter->iterations);

        $counter = app(CounterService::class)->increment($user, 'slug');

        $this->assertEquals(2, $counter->iterations);
    }
}
