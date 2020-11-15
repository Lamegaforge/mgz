<?php

namespace App\Jobs;

use Log;
use Event;
use App\Models;
use App\Models\User;
use App\Models\Achievement;
use Illuminate\Bus\Queueable;
use App\Events\AchievementWon;
use App\Services\ScoringService;
use Illuminate\Queue\SerializesModels;
use App\Services\Achievements\Triggers;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Achievements\Contracts\Trigger;
use App\Services\Achievements\AchievementService;
use App\Services\Achievements\Triggers\ActiveClips;
use App\Services\Achievements\Triggers\ViewsAllClips;

class ProcessAchievements implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $triggers = $this->triggers();

        $achievements = Achievement::all()->keyBy('slug');

        foreach ($triggers as $trigger) {

            try {
                
                $eligible = $trigger->eligible();

                $achievement = $achievements->get($trigger->slug());

                $eligible 
                    ? $this->assignee($achievement)
                    : $this->unassign($achievement);


            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
        }

        $this->refreshPoints();
    }

    protected function triggers(): array
    {
        return [
            new Triggers\CompulsiveClipper($this->user),
            new Triggers\ValerieDamidot($this->user),
            new Triggers\Famous($this->user),
            new Triggers\ILoveThisGame($this->user),
            new Triggers\Unloved($this->user),
            new Triggers\Pharos($this->user),
            new Triggers\IAmAnIdiot($this->user),
            new Triggers\OldMan($this->user),
            new Triggers\Random($this->user),
            new Triggers\Stalker($this->user),
            new Triggers\Narcissistic($this->user),

            new ActiveClips\Fifty($this->user),
            new ActiveClips\Hundred($this->user),
            new ActiveClips\OneHundredFifty($this->user),
            new ActiveClips\Seventy($this->user),
            new ActiveClips\Ten($this->user),
            new ActiveClips\Thirty($this->user),

            new ViewsAllClips\Thousand($this->user),
            new ViewsAllClips\TwoThousand($this->user),
            new ViewsAllClips\ThreeThousand($this->user),
            new ViewsAllClips\FourThousand($this->user),
        ];
    }

    protected function assignee(Achievement $achievement): void
    {
        $assigned = app(AchievementService::class)->assignee($this->user, $achievement);

        if ($assigned) {
            Event::dispatch('NotifySubscriber@achievementWon', [$this->user, $achievement]);
        }
    }

    protected function unassign(Achievement $achievement)
    {
        if ($achievement->always) {
            return;
        }

        $unassigned = app(AchievementService::class)->unassign($this->user, $achievement);

        if ($unassigned) {
            Event::dispatch('NotifySubscriber@achievementLost', [$this->user, $achievement]);
        }
    }

    protected function refreshPoints()
    {
        app(ScoringService::class)->total($this->user);
    }
}
