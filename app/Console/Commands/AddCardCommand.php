<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\CardRepository;

class AddCardCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'card-store';

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
        $attributes = [
            'title' => $this->ask('Title card ?'),
            'short_title' => $this->ask('Short title card ?'),
            'image_url' => $this->ask('Image url ?'),
            'description' => $this->ask('Description card ?'),
        ];

        if (! $this->confirm('Créer la card : ' . $attributes['title'] . ' ?')) {
            $this->error('abort');
            return;
        }

        $card = app(CardRepository::class)->create($attributes);

        $this->info('Création de la card : ' . $card->title . ' (' . $card->id . ')');
    }
}
