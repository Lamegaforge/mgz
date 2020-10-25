<?php

namespace Tests\Unit\Achievements;

use Tests\TestCase;
use App\Models\Clip;
use App\Models\User;
use App\Services\Achievements\TenActiveClips;
use App\Services\Achievements\FiveActiveClips;
use App\Services\Achievements\TwentyActiveClips;
use App\Services\Achievements\FifteenActiveClips;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

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
            [4, $fqcn = FiveActiveClips::class, $expected = false],
            [5, $fqcn = FiveActiveClips::class, $expected = true],
            [6, $fqcn = FiveActiveClips::class, $expected = true],
        ];
    }

    public function teenProvider(): array
    {
        return [
            [9, $fqcn = TenActiveClips::class, $expected = false],
            [10, $fqcn = TenActiveClips::class, $expected = true],
            [11, $fqcn = TenActiveClips::class, $expected = true],
        ];
    }

    public function fifteenProvider(): array
    {
        return [
            [14, $fqcn = FifteenActiveClips::class, $expected = false],
            [15, $fqcn = FifteenActiveClips::class, $expected = true],
            [16, $fqcn = FifteenActiveClips::class, $expected = true],
        ];
    }

    public function twentyProvider(): array
    {
        return [
            [19, $fqcn = TwentyActiveClips::class, $expected = false],
            [20, $fqcn = TwentyActiveClips::class, $expected = true],
            [21, $fqcn = TwentyActiveClips::class, $expected = true],
        ];
    }
}
