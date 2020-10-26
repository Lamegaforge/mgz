<?php

namespace App\Jobs;

use Log;
use App\Models;
use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Events\AchievementWon;
use Illuminate\Queue\SerializesModels;
use App\Services\Achievements\Triggers;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Achievements\Contracts\Trigger;
use App\Services\Achievements\AchievementService;

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

        foreach ($triggers as $trigger) {

            try {
                
                $eligible = $trigger->eligible();

                if (! $eligible) {
                    continue;
                }

               $this->assignee($trigger);

            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
        }
    }

    protected function triggers(): array
    {
        return [
            new Triggers\ValerieDamidot($this->user),
            new Triggers\FiveActiveClips($this->user),
            new Triggers\TenActiveClips($this->user),
            new Triggers\FifteenActiveClips($this->user),
            new Triggers\TwentyActiveClips($this->user),
        ];
    }

    protected function assignee(Trigger $trigger): void
    {
        $achievement = Achievement::where('slug', $trigger->slug())->first();

        app(AchievementService::class)->assignee($this->user, $achievement);

        AchievementWon::dispatch($this->user, $achievement);
    }
}
