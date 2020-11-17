<?php

namespace App\Http\Controllers\Web;

use View;
use Event;
use Redirect;
use App\Models\User;
use App\Models\Achievement;
use Illuminate\Http\Request;
use App\Services\ScoringService;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Services\NotificationService;
use App\Repositories\Criterias\Limit;
use App\Repositories\Criterias\Recents;
use App\Repositories\Criterias\OrderBy;
use App\Repositories\Criterias\WhereNull;
use App\Repositories\NotificationRepository;

class UserController extends Controller
{
    protected $userRepository;
    protected $notificationRepository;

    public function __construct(UserRepository $userRepository, NotificationRepository $notificationRepository)
    {
        $this->userRepository = $userRepository;
        $this->notificationRepository = $notificationRepository;
    }

    public function index()
    {
        return View::make('users.index');
    }

    public function account(Request $request)
    {
        $user = $request->user();

        Event::dispatch('CounterSubscriber@seeOwnAccount', [$user]);

        return Redirect::route('users.show', [$user->login]);
    }

    public function settings(Request $request)
    {
        return View::make('users.settings', [
            'user' => $request->user(),
        ]);
    }

    public function notifications(Request $request)
    {
        $user = $request->user();

        $notifications = $this->notificationRepository
            ->pushCriteria(new Recents())
            ->pushCriteria(new Limit(20))
            ->pushCriteria(new OrderBy('created_at', 'DESC'))
            ->where('user_id', $user->id)
            ->get();

        app(NotificationService::class)->readAll($user);

        return View::make('users.notifications', [
            'user' => $user,
            'notifications' => $notifications,
        ]);
    }

    public function show(Request $request)
    {
        $user = $this->userRepository
            ->where('login', $request->hook)
            ->orWhere('id', $request->hook)
            ->firstOrFail();

        $scores = app(ScoringService::class)->total($user);

        $maxAchievementsPoints = $this->getMaxAchievementsPoints();

        if ($this->userLookAnotherAccount($request, $user)) {
            Event::dispatch('CounterSubscriber@seeAnotherAccount', [$request->user()]);
        }

        return View::make('users.show', [
            'user' => $user,
            'scores' => $scores,
            'max_achievements_points' => $maxAchievementsPoints,
        ]);
    }

    protected function getMaxAchievementsPoints(): int
    {
        return Achievement::sum('points');
    }

    protected function userLookAnotherAccount(Request $request, User $user): bool
    {
        if (! $request->auth()) {
            return false;
        }

        return $request->user()->id !== $user->id;
    }
}
