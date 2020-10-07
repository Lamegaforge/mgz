<?php

namespace App\Console\Commands;

use App\Models\Clip;
use Illuminate\Console\Command;
use App\Repositories\Criterias;
use Illuminate\Support\Collection;
use App\Repositories\ClipRepository;
use App\Managers\Twitch\TwitchManager;

class ClipsViewsUpdater extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clips:views-update';

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

            $views = $this->getViews($clip);

            $this->updateClip($clip, $views);
        }
    }

    protected function getAllClips(): Collection
    {
        $clipRepository = app(ClipRepository::class);

        $clipRepository->pushCriteria(new Criterias\Active());

        return $clipRepository->all();
    }

    protected function getViews(Clip $clip): int
    {
        $concret = app(TwitchManager::class)->driver('api')->get($clip->slug);

        return $concret['views'];
    }

    protected function updateClip(Clip $clip, int $views)
    {
        app(ClipRepository::class)->update([
            'views' => $views,
        ], $clip->id);        
    }
}
