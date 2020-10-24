<?php

namespace App\Jobs;

use Log;
use App\Models;
use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Services\Achievements;
use App\Events\AchievementWon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\Achievements\Contracts;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
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
        $achievements = $this->achievements();

        foreach ($achievements as $achievement) {

            try {
                
                $eligible = $achievement->eligible();

                if (! $eligible) {
                    continue;
                }

               $this->assignee($achievement);

            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
        }
    }

    protected function achievements(): array
    {
        return [
            new Achievements\ValerieDamidot($this->user),
        ];
    }

    protected function assignee(Contracts\Achievement $achievement): void
    {
        $achievement = Models\Achievement::where('slug', $achievement->slug())->first();

        app(AchievementService::class)->assignee($this->user, $achievement);

        AchievementWon::dispatch($this->user, $achievement);
    }
}
