<?php

namespace App\Services;

use Event;
use App\Models\User;
use App\Models\Favorite;

class ScoringService
{
    protected const CLIP_VALOR = 100;
    protected const VIEWS_VALOR = 1;
    protected const FAVORITE_VALOR = 10;

    public function total(User $user): array
    {
        $sumAchievements = $this->getSumAchievements($user);
        $sumClips = $this->getSumClips($user);
        $sumViews = $this->getSumViews($user);
        $sumfavorites = $this->getSumFavorites($user);

        $sum = $sumAchievements + $sumClips + $sumViews + $sumfavorites;

        Event::dispatch('ScoringSubscriber@refresh', [$user, $sum]);

        return [
            'sum' => $sum,
            'sum_achievements' => $sumAchievements,
            'sum_clips' => $sumClips,
            'sum_views' => $sumViews,
            'sum_favorites' => $sumfavorites,
        ];
    }

    protected function getSumAchievements(User $user): int
    {
        return $user->achievements->sum('points');
    }

    protected function getSumClips(User $user): int
    {
        $count = $user->clips->where('state', 'active')->count();

        return $count * self::CLIP_VALOR;
    }

    protected function getSumViews(User $user): int
    {
        $views = $user->clips->where('state', 'active')->sum('views');

        return $views * self::VIEWS_VALOR;
    }

    protected function getSumFavorites(User $user): int
    {
        $count = Favorite::join('clips', 'clips.id', '=', 'favorites.clip_id')
            ->where('clips.user_id', $user->id)
            ->where('favorites.user_id', '!=', $user->id)
            ->where('clips.state', 'active')
            ->count();

        return $count * self::FAVORITE_VALOR;
    }
}
