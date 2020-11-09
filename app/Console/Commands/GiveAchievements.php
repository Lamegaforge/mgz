<?php

namespace App\Console\Commands;

use Event;
use App\Models\User;
use App\Models\Achievement;
use Illuminate\Console\Command;
use App\Services\ScoringService;
use Illuminate\Support\Collection;
use App\Repositories\UserRepository;
use App\Services\Achievements\AchievementService;

class GiveAchievements extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'give-achievements';

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
        $user = $this->findUser();

        $this->info('User found : ' . $user->display_name . ' (' . $user->id . ')');

        $lockedAchievements = $this->getLockedAchievements($user);

        $choice = $this->choice('Achievements : ', $lockedAchievements->pluck('slug')->toArray());

        $achievement = $lockedAchievements->get($choice);

        app(AchievementService::class)->assignee($user, $achievement);

        $this->notify($user, $achievement);

        return 0;
    }

    protected function findUser(): User
    {
        $userHook = $this->ask('User ?');

        return app(UserRepository::class)
            ->where('id', $userHook)
            ->orWhere('display_name', $userHook)
            ->orWhere('login', $userHook)
            ->firstOrFail();
    }

    protected function getLockedAchievements(User $user): Collection
    {
        $unlockedAchievements = $user->achievements->pluck('id');

        $lockedAchievements = Achievement::whereNotIn('id', $unlockedAchievements)->get();

        return $lockedAchievements->keyBy('slug');
    }

    protected function notify(User $user, Achievement $achievement): void
    {
        $this->info($user->display_name . ' won ' . $achievement->title . ' !');

        Event::dispatch('NotifySubscriber@achievementWon', [$user, $achievement]);

        app(ScoringService::class)->total($user);
    }
}
