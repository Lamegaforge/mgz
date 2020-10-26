<?php

namespace Tests\Unit\Achievements\Triggers;

use Tests\TestCase;
use App\Models\Clip;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations; 
use App\Services\Achievements\Triggers\ActiveClips\Ten;
use App\Services\Achievements\Triggers\ActiveClips\Thirty;
use App\Services\Achievements\Triggers\ActiveClips\Fifty;
use App\Services\Achievements\Triggers\ActiveClips\Seventy;
use App\Services\Achievements\Triggers\ActiveClips\Hundred;
use App\Services\Achievements\Triggers\ActiveClips\OneHundredFifty;

class ActiveClipsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @dataProvider teenProvider
     * @dataProvider thirtyProvider
     * @dataProvider fiftyProvider
     * @dataProvider seventyProvider
     * @dataProvider hundredProvider
     * @dataProvider oneHundredFiftyProvider
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
    public function teenProvider(): array
    {
        return [
            [9, $fqcn = Ten::class, $expected = false],
            [10, $fqcn = Ten::class, $expected = true],
            [11, $fqcn = Ten::class, $expected = true],
        ];
    }

    public function thirtyProvider(): array
    {
        return [
            [29, $fqcn = Thirty::class, $expected = false],
            [30, $fqcn = Thirty::class, $expected = true],
            [31, $fqcn = Thirty::class, $expected = true],
        ];
    }

    public function fiftyProvider(): array
    {
        return [
            [49, $fqcn = Fifty::class, $expected = false],
            [50, $fqcn = Fifty::class, $expected = true],
            [51, $fqcn = Fifty::class, $expected = true],
        ];
    }

    public function seventyProvider(): array
    {
        return [
            [69, $fqcn = Seventy::class, $expected = false],
            [70, $fqcn = Seventy::class, $expected = true],
            [71, $fqcn = Seventy::class, $expected = true],
        ];
    }

    public function hundredProvider(): array
    {
        return [
            [99, $fqcn = Hundred::class, $expected = false],
            [100, $fqcn = Hundred::class, $expected = true],
            [101, $fqcn = Hundred::class, $expected = true],
        ];
    }

    public function oneHundredFiftyProvider(): array
    {
        return [
            [149, $fqcn = OneHundredFifty::class, $expected = false],
            [150, $fqcn = OneHundredFifty::class, $expected = true],
            [151, $fqcn = OneHundredFifty::class, $expected = true],
        ];
    }
}
