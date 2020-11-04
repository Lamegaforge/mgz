<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AchievementsProgress extends Component
{
    public $sumAchievements;
    public $maxAchievementsPoints;

    public function __construct(int $sumAchievements, int $maxAchievementsPoints)
    {
        $this->sumAchievements = $sumAchievements;
        $this->maxAchievementsPoints = $maxAchievementsPoints;
    }

    public function percentage(): int
    {
        return $this->sumAchievements * 100 / $this->maxAchievementsPoints;
    }

    public function render()
    {
        return view('components.achievements-progress');
    }
}
