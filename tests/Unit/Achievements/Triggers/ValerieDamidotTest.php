<?php

namespace Tests\Unit\Achievements\Triggers;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations; 
use App\Services\Achievements\Triggers\ValerieDamidot;

class ValerieDamidotTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function eligible()
    {
        $user = User::factory()->create();

        $achievement = new ValerieDamidot($user);

        $this->assertTrue($achievement->eligible());
    }

    /**
     * @test
     */
    public function ineligible()
    {
        $user = User::factory()->create([
            'description' => null,
        ]);

        $achievement = new ValerieDamidot($user);

        $this->assertFalse($achievement->eligible());
    }
}
