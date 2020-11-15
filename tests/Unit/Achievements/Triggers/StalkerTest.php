<?php

namespace Tests\Unit\Achievements\Triggers;

use DB;
use Tests\TestCase;
use App\Models\User;
use App\Services\Achievements\Triggers\Stalker;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class StalkerTest extends TestCase
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
            'slug' => 'see_another_account',
            'values' => $count,
        ]);

        $trigger = new Stalker($user);

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
