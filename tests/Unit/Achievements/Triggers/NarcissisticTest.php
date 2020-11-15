<?php

namespace Tests\Unit\Achievements\Triggers;

use DB;
use Tests\TestCase;
use App\Models\User;
use App\Services\Achievements\Triggers\Narcissistic;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class NarcissisticTest extends TestCase
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
            'slug' => 'narcissistic',
            'values' => $count,
        ]);

        $trigger = new Narcissistic($user);

        $this->assertEquals($expected, $trigger->eligible());
    }

    public function dataProvider(): array
    {
        return [
            [29, $expected = false],
            [30, $expected = true],
            [31, $expected = true],
        ];
    }
}
