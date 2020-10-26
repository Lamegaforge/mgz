<?php

namespace App\Services\Achievements\Triggers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Collection;
use App\Services\Achievements\Contracts\Trigger;

class CompulsiveClipper extends Triggers implements Trigger 
{
    protected $slug = 'compulsive_clipper';

    public function eligible(): bool
    {
        $clips = $this->getClips();

        $grouped = $this->groupByWeeks($clips);
        
        return $grouped->max() >= 7;
    }

    protected function getClips(): Collection
    {
        return $this->user
            ->clips()
            ->where('state', 'active')
            ->get();
    }

    protected function groupByWeeks(Collection $clips): Collection
    {
        return $clips->groupBy(function($clip) {
            return Carbon::parse($clip->approved_at)->format('W');
        })->map(function ($item, $key) {
            return $item->count();
        });
    }
}
