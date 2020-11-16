<?php

namespace App\Console\Commands;

use Storage;
use App\Models\Card;
use App\Services\GameService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class CardsAggregator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cards:aggregate {--force}';

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
        $games = app(GameService::class)->get();

        $cards = $this->getCards();

        $games->map(function ($game) use($cards) {

            $card = $cards->get($game['slug']);

            if (! $card) {
                return;
            }

            $file = $this->download($game);

            $this->store($card, $file);
        });
    }

    protected function getCards(): Collection
    {
        $cards = Card::get();

        return $cards->keyBy('slug');
    }

    protected function download(array $game): string
    {
        return file_get_contents($game['thumbnail']);
    }

    protected function store(Card $card, $file): void
    {
        $path = $card->slug . '/vignette.jpg';

        $exist = Storage::disk('cards')->has($path);

        if ($exist && ! $this->option('force')) {
            return;
        }

        Storage::disk('cards')->put($path, $file);
    }
}
