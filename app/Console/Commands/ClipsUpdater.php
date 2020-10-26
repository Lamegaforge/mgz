<?php

namespace App\Console\Commands;

use App\Models\Clip;
use Illuminate\Console\Command;
use App\Repositories\Criterias;
use Illuminate\Support\Collection;
use App\Repositories\ClipRepository;
use App\Managers\Twitch\TwitchManager;

class ClipsUpdater extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clips:update';

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
        $clips = $this->getAllClips();

        foreach ($clips as $clip) {

            $concret = $this->getConcretClip($clip);

            $this->updateClip($clip, $concret);
        }
    }

    protected function getAllClips(): Collection
    {
        $clipRepository = app(ClipRepository::class);

        $clipRepository->pushCriteria(new Criterias\Active());

        return $clipRepository->all();
    }

    protected function getConcretClip(Clip $clip): array
    {
        return app(TwitchManager::class)->get($clip->slug);
    }

    protected function updateClip(Clip $clip, array $concret)
    {
        $state = $concret['slug'] ? 'active' : 'rejected';
        $views = $concret['views'] ?? 0;

        app(ClipRepository::class)->update([
            'state' => $state,
            'views' => $views,
        ], $clip->id);        
    }
}
