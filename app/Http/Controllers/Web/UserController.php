<?php

namespace App\Http\Controllers\Web;

use View;
use App\Models\Achievement;
use Illuminate\Http\Request;
use App\Services\ScoringService;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        return View::make('users.index');
    }

    public function account(Request $request)
    {
        $userId = $request->user()->id;

        $user = $this->userRepository->find($userId);

        $scores = app(ScoringService::class)->total($user);

        $maxAchievementsPoints = $this->getMaxAchievementsPoints();

        return View::make('users.show', [
            'user' => $user,
            'scores' => $scores,
            'max_achievements_points' => $maxAchievementsPoints,
        ]);
    }

    public function settings(Request $request)
    {
        $userId = $request->user()->id;

        $user = $this->userRepository->find($userId);

        return View::make('users.settings', [
            'user' => $user,
        ]);
    }

    public function show(Request $request)
    {
        $user = $this->userRepository
            ->where('login', $request->hook)
            ->orWhere('id', $request->hook)
            ->first();

        $scores = app(ScoringService::class)->total($user);

        $maxAchievementsPoints = $this->getMaxAchievementsPoints();

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
}
