<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Clip;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class HomeTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function home()
    {
        Clip::factory()->create();

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
