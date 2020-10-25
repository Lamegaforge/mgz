<?php

namespace Tests\Unit\Achievements;

use Tests\TestCase;
use App\Models\Clip;
use App\Models\User;
use App\Services\Achievements\FiveActiveClips;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class FiveActiveClipsTest extends TestCase
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
                'state' => 'active',
                'user_id' => $user->id,
            ]);

        $achievement = new FiveActiveClips($user);

        $this->assertEquals($expected, $achievement->eligible());
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
