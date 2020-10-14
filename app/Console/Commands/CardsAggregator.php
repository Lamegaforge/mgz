<?php

namespace App\Console\Commands;

use Storage;
use App\Models\Card;
use Illuminate\Support\Str;
use App\Services\VideoService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class CardsAggregator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cards:aggregate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $games = $this->getLastGames();

        $games->map(function ($game) {

            $slug = Str::slug($game, '_');

            $this->makeCard($game, $slug);
            $this->makeCardDirectory($slug);
        });
    }

    protected function getLastGames(): Collection
    {
        $games = app(VideoService::class)->getLastGames();

        $cards = Card::all()->pluck('title')->toArray();

        return (new Collection($games))
            ->filter(function ($game) use($cards) {
                return ! in_array($game, $cards, true);
            })
            ->values();
    }

    protected function makeCard(string $game, string $slug)
    {
        $attributes = [
            'title' => $game,
            'slug' => $slug,
        ];

        Card::factory()->create($attributes);
    }

    protected function makeCardDirectory(string $slug)
    {
        Storage::disk('cards')->makeDirectory($slug);
    }
}
