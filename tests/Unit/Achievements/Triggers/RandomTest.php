<?php

namespace Tests\Unit\Achievements\Triggers;

use DB;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations; 
use App\Services\Achievements\Triggers\Random;

class RandomTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @dataProvider dataProvider
     */
    public function eligible(int $count, bool $expected)
    {   
        $user = User::factory()->create();

        DB::table('counts')->insert([
            'user_id' => $user->id,
            'slug' => 'random',
            'values' => $count,
        ]);

        $trigger = new Random($user);

        $this->assertEquals($expected, $trigger->eligible());
    }

    public function dataProvider(): array
    {
        return [
            [999, $expected = false],
            [1000, $expected = true],
            [1001, $expected = true],
        ];
    }
}
