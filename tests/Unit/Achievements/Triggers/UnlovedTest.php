<?php

namespace Tests\Unit\Achievements\Triggers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Clip;
use App\Services\Achievements\Triggers\Unloved;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class UnlovedTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @dataProvider dataProvider
     */
    public function eligible(int $times, bool $expected)
    {   
        $user = User::factory()->create();

        Clip::factory()
            ->times($times)
            ->create([
                'user_id' => $user->id,
                'state' => 'rejected',
            ]);

        $trigger = new Unloved($user);

        $this->assertEquals($expected, $trigger->eligible());
    }

    public function dataProvider(): array
    {
        return [
            [19, $expected = false],
            [20, $expected = true],
            [21, $expected = true],
        ];
    }
}
