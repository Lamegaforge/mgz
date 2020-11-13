<?php

namespace App\Http\Controllers\Api;

use Auth;
use Response;
use DateTime;
use App\Models\User;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;

class AchievementController extends Controller
{
    public function search(Request $request)
    {
        $user = app(UserRepository::class)
            ->where('id', $request->user_id)
            ->firstOrFail();

        $attributes = Achievement::oldest()
            ->paginate(50)
            ->toArray();
dd($this->present($user, $attributes));
        return Response::json([
            'timestamp' => (new DateTime())->getTimestamp(),
            'achievements' => $this->present($user, $attributes),
        ], 200);
    }

    protected function present(User $user, array $attributes): array
    {
        $unlockedAchievements = $this->getUnlockedAchievements($user);

        $achievements = new Collection($attributes['data']);

        $achievements = $this->displayable($achievements, $unlockedAchievements);
        $achievements = $this->markUnlocked($achievements, $unlockedAchievements);
        $achievements = $this->hideDescription($achievements, $user);

        $attributes['data'] = $achievements->toArray();

        return $attributes;
    }

    protected function getUnlockedAchievements(User $user): Collection
    {
       $unlockedAchievements = $user->achievements()->get(); 

       return $unlockedAchievements->keyBy('id');
    }

    protected function displayable(Collection $achievements, Collection $unlockedAchievements): Collection
    {
        return $achievements->filter(function ($achievement) use($unlockedAchievements) {

            if ($achievement['displayable']) {
                return true;
            }

            $unlockedAchievement = $unlockedAchievements->get($achievement['id']);

            return (bool) $unlockedAchievement;
        });
    }

    protected function markUnlocked(Collection $achievements, Collection $unlockedAchievements): Collection
    {
        return $achievements->map(function ($achievement) use($unlockedAchievements) {

            $unlockedAchievement = $unlockedAchievements->get($achievement['id']);

            $achievement['unlocked_at'] = null;

            if ($unlockedAchievement) {
                $achievement['unlocked_at'] = $unlockedAchievement->pivot->created_at->toDateTimeString();
            }

            return $achievement;
        });
    }

    protected function hideDescription(Collection $achievements, User $user): Collection
    {
        $lookHisOwnAccount = $this->userLookHisOwnAccount($user);

        return $achievements->map(function ($achievement) use($lookHisOwnAccount) {

            if ($achievement['secret'] && $achievement['unlocked_at'] && $lookHisOwnAccount) {
                return $achievement;
            }

            if ($achievement['secret']) {
                $achievement['description'] = null;
            }

            return $achievement;
        });
    }

    protected function userLookHisOwnAccount(User $user): bool
    {
        if (Auth::guest()) {
            return false;
        }

        return $user->id == Auth::user()->id;
    }
}
