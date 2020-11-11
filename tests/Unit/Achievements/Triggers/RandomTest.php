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
            [99, $expected = false],
            [100, $expected = true],
            [101, $expected = true],
        ];
    }
}
