<?php

namespace Tests\Unit\Achievements\Triggers;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Clip;
use App\Models\User;
use App\Services\Achievements\Triggers\OldMan;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class OldManTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @dataProvider dataProvider
     */
    public function eligible(Carbon $createdAt, bool $expected)
    {   
        $user = User::factory()->create();

        Clip::factory()
            ->create([
                'user_id' => $user->id,
                'created_at' => $createdAt->format('Y-m-d'),
            ]);

        $trigger = new OldMan($user);

        $this->assertEquals($trigger->eligible(), $expected);
    }

    public function dataProvider(): array
    {
        return [
            [Carbon::now()->subYear(), $expected = false],
            [Carbon::now()->subYears(2), $expected = false],
            [Carbon::now()->subYears(3), $expected = true],
            [Carbon::now()->subYears(4), $expected = true],
        ];
    }
}
