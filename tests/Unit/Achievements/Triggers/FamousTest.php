<?php

namespace Tests\Unit\Achievements\Triggers;

use Tests\TestCase;
use App\Models\Clip;
use App\Models\User;
use App\Services\Achievements\Triggers\Famous;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class FamousTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @dataProvider dataProvider
     */
    public function eligible(int $views, bool $expected)
    {   
        $user = User::factory()->create();

        Clip::factory()
            ->create([
                'views' => $views,
                'user_id' => $user->id,
            ]);

        $trigger = new Famous($user);

        $this->assertEquals($expected, $trigger->eligible());
    }
    public function dataProvider(): array
    {
        return [
            [499, $expected = false],
            [500, $expected = true],
            [501, $expected = true],
        ];
    }
}
