<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use App\Repositories\ClipRepository;
use App\Managers\Twitch\TwitchManager;

class ClipsAggregator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clips:aggregate';

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
        $clips = app(TwitchManager::class)->driver('api')->getLastClips();

        foreach ($clips as $clip) {

            if ($this->alreadySave($clip)) {
                continue;
            }

            $user = $this->retrieveUser($clip['curator']);

            $this->storeClip($clip, $user);
        }
    }

    protected function alreadySave(array $clip): bool
    {
        $found = app(ClipRepository::class)->findByField('tracking_id', $clip['tracking_id']);

        return ! $found->isEmpty();
    }

    protected function retrieveUser(array $curator): User
    {
        $attributes = (new Collection($curator))->only([
            'tracking_id',
            'display_name',
            'profile_image_url',
        ]);

        $attributes['login'] = $curator['name'];

        $user = app(UserService::class)->firstOrCreate($curator['tracking_id'], $attributes->toArray());

        return $user;
    }

    protected function storeClip(array $clip, User $user): void
    {
        $attributes = (new Collection($clip))->only([
            'tracking_id',
            'slug',
            'title',
            'thumbnail',
            'views',
            'url',
        ]);

        $attributes['user_id'] = $user->id;

        app(ClipRepository::class)->create($attributes->toArray());
    }
}
