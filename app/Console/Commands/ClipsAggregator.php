<?php

namespace App\Console\Commands;

use Event;
use Storage;
use App\Models\User;
use App\Models\Card;
use App\Models\Clip;
use Illuminate\Support\Str;
use App\Services\UserService;
use App\Services\CardSniffer;
use App\Services\CardService;
use Illuminate\Console\Command;
use App\Services\VideoSuspector;
use Illuminate\Support\Collection;
use App\Repositories\CardRepository;
use App\Repositories\ClipRepository;
use App\Managers\Twitch\TwitchManager;

class ClipsAggregator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clips:aggregate {--period=} {--cursor=} {--active} {--disabled-notify}';

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
        $clips = $this->retrieveClips();

        foreach ($clips as $clip) {

            if ($this->alreadySave($clip)) {
                continue;
            }

            if ($this->isSuspect($clip)) {
                continue;
            }

            $user = $this->retrieveUser($clip['curator']);
            $card = $this->retrieveCard($clip);
          
            $clip = $this->storeClip($clip, $user, $card);
            $this->makeCardDirectory($card);
            $this->notify($clip, $user);
        }

        return 0;
    }

    protected function retrieveClips(): array
    {
        $period = $this->option('period') ?? 'day';
        $cursor = $this->option('cursor');

        return app(TwitchManager::class)->driver('api')->getLastClips($period, $cursor);
    }

    protected function alreadySave(array $clip): bool
    {
        $found = app(ClipRepository::class)->findByField('tracking_id', $clip['tracking_id']);

        return ! $found->isEmpty();
    }

    protected function isSuspect(array $clip): bool
    {
        $isClean = app(VideoSuspector::class)->isClean($clip);

        return ! $isClean;
    }

    protected function retrieveUser(array $curator): User
    {
        $attributes = (new Collection($curator))->only([
            'tracking_id',
            'display_name',
            'profile_image_url',
        ]);

        $attributes['login'] = $curator['name'];

        $user = app(UserService::class)->findOrCreateUser($curator['tracking_id'], $attributes->toArray());

        return $user;
    }

    protected function retrieveCard(array $clip): Card
    {
        $attributes = [
            'title' => $clip['game'],
            'slug' => Str::slug($clip['game'], '_'),
            'description' => '',
            'game' => $clip['game'],
        ];

        return app(CardService::class)->findOrCreateCard($attributes['game'], $attributes);
    }

    protected function storeClip(array $clip, User $user, ?Card $card): Clip
    {
        $attributes = (new Collection($clip))->only([
            'tracking_id',
            'slug',
            'title',
            'game',
            'thumbnail',
            'views',
            'duration',
            'url',
            'created_at',
        ]);

        $active = $this->getActiveAttribute($card);

        $attributes['user_id'] = $user->id;
        $attributes['card_id'] = $card->id ?? null;
        $attributes['state'] = $active;
        $attributes['approved_at'] = $attributes['created_at'];

        return app(ClipRepository::class)->create($attributes->toArray());
    }

    protected function getActiveAttribute(?Card $card): string
    {
        if ($card) {
            return 'active';
        } 

        return $this->option('active') ? 'active' : 'waiting';
    }

    protected function makeCardDirectory(Card $card): void
    {
        Storage::disk('cards')->makeDirectory($card->slug);
    }

    protected function notify(Clip $clip, User $user)
    {
        if ($this->option('disabled-notify')) {
            return;
        }

        if ($clip->state != 'active') {
            return;
        }

        Event::dispatch('NotifySubscriber@clipWon', [$clip]);
    }
}
