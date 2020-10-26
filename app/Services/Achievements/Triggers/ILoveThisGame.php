<?php

namespace App\Services\Achievements\Triggers;

use Illuminate\Support\Collection;
use App\Services\Achievements\Contracts\Trigger;

class ILoveThisGame extends Triggers implements Trigger 
{
    protected $slug = 'i_love_this_game';

    public function eligible(): bool
    {
        $clips = $this->getClips();

        $grouped = $this->groupByCards($clips);

        return $grouped->max() >= 10;
    }

    protected function getClips(): Collection
    {
        return $this->user
            ->clips()
            ->where('state', 'active')
            ->get();
    }

    protected function groupByCards(Collection $clips): Collection
    {
        return $clips->groupBy(function($clip) {
            return $clip->card_id;
        })->map(function ($item, $key) {
            return $item->count();
        });
    }
}
