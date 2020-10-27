<?php

namespace Tests\Api;

use Storage;
use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Clip;
use App\Models\Card;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function update_without_token()
    {
        $response = $this->post('api/admin/clip-update');

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function update_title()
    {
        $clip = Clip::factory()->create();

        $parameters = [
            'hook' => $clip->slug,
            'title' => 'qsdsqdqdq',
        ];

        $this->handle($parameters);

        $clip->refresh();

        $this->assertEquals($clip->title, 'qsdsqdqdq');
    }

    /**
     * @test
     */
    public function update_card()
    {
        $clip = Clip::factory()->create();
        $card = Card::factory()->create();

        $parameters = [
            'hook' => $clip->slug,
            'card' => $card->slug,
        ];

        $this->handle($parameters);

        $clip->refresh();

        $this->assertEquals($clip->card_id, $card->id);
    }

    /**
     * @test
     */
    public function update_state()
    {
        $clip = Clip::factory()->create();

        $parameters = [
            'hook' => $clip->slug,
            'state' => 'rejected',
        ];

        $this->handle($parameters);

        $clip->refresh();

        $this->assertEquals($clip->state, 'rejected');
    }

    /**
     * @test
     */
    public function validate_a_clip()
    {
        $clip = Clip::factory()->create([
            'state' => 'waiting',
            'approved_at' => '2020-01-01',
        ]);

        $parameters = [
            'hook' => $clip->slug,
            'state' => 'active',
        ];

        $this->handle($parameters);

        $clip->refresh();

        $this->assertEquals('active', $clip->state);
        $this->assertEquals($clip->approved_at->format('ymd'), Carbon::now()->format('ymd'));
    }

    protected function handle(array $parameters): void
    {
        $headers = ['token' => env('APP_TOKEN')];

        $response = $this->withHeaders($headers)
            ->post('api/admin/clip-update', $parameters);
    }
}
