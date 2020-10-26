<?php

namespace Tests\Unit\Achievements\Triggers;

use Tests\TestCase;
use App\Models\Clip;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations; 
use App\Services\Achievements\Triggers\ActiveClips\Ten;
use App\Services\Achievements\Triggers\ActiveClips\Five;
use App\Services\Achievements\Triggers\ActiveClips\Twenty;
use App\Services\Achievements\Triggers\ActiveClips\Fifteen;

class ActiveClipsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @dataProvider fiveProvider
     * @dataProvider teenProvider
     * @dataProvider fifteenProvider
     * @dataProvider twentyProvider
     */
    public function eligible(int $times, string $fqcn, bool $expected)
    {   
        $user = User::factory()->create();

        Clip::factory()
            ->times($times)
            ->create([
                'state' => 'active',
                'user_id' => $user->id,
            ]);

        $achievement = new $fqcn($user);

        $this->assertEquals($expected, $achievement->eligible());
    }

    public function fiveProvider(): array
    {
        return [
            [4, $fqcn = Five::class, $expected = false],
            [5, $fqcn = Five::class, $expected = true],
            [6, $fqcn = Five::class, $expected = true],
        ];
    }

    public function teenProvider(): array
    {
        return [
            [9, $fqcn = Ten::class, $expected = false],
            [10, $fqcn = Ten::class, $expected = true],
            [11, $fqcn = Ten::class, $expected = true],
        ];
    }

    public function fifteenProvider(): array
    {
        return [
            [14, $fqcn = Fifteen::class, $expected = false],
            [15, $fqcn = Fifteen::class, $expected = true],
            [16, $fqcn = Fifteen::class, $expected = true],
        ];
    }

    public function twentyProvider(): array
    {
        return [
            [19, $fqcn = Twenty::class, $expected = false],
            [20, $fqcn = Twenty::class, $expected = true],
            [21, $fqcn = Twenty::class, $expected = true],
        ];
    }
}
