<?php

namespace Tests\Unit\Achievements\Triggers;

use DB;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations; 
use App\Services\Achievements\Triggers\ValerieDamidot;

class ValerieDamidotTest extends TestCase
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
            'slug' => 'banner',
            'values' => $count,
        ]);

        $trigger = new ValerieDamidot($user);

        $this->assertEquals($expected, $trigger->eligible());
    }

    public function dataProvider(): array
    {
        return [
            [4, $expected = false],
            [5, $expected = true],
            [6, $expected = true],
        ];
    }
}
