<?php

namespace Tests\Unit\Achievements\Triggers;

use Tests\TestCase;
use App\Models\User;
use App\Services\Achievements\Triggers\IAmAnIdiot;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class IAmAnIdiotTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @dataProvider dataProvider
     */
    public function eligible(string $attribute, bool $expected)
    {   
        $user = User::factory()->create([
            'youtube' => $attribute,
        ]);

        $trigger = new IAmAnIdiot($user);

        $this->assertEquals($expected, $trigger->eligible());
    }

    public function dataProvider(): array
    {
        return [
            ['qsdsqdsq', $expected = false],
            ['http://qsdqsdsqdq', $expected = true],
            ['https://qsdqsdsqdq', $expected = true],
        ];
    }
}
