<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class ClipAggregatorTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function aggregate()
    {
        $this->artisan('clips:aggregate')->assertExitCode(0);
    }
}
