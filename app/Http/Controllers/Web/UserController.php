<?php

namespace App\Http\Controllers\Web;

use View;
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

    public function account(Request $request)
    {
        $userId = $request->user()->id;

        $user = $this->userRepository->find($userId);

        $scores = app(ScoringService::class)->total($user);

        return View::make('users.show', [
            'user' => $user,
            'scores' => $scores,
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
        $user = $this->userRepository->find($request->id);

        $scores = app(ScoringService::class)->total($user);

        return View::make('users.show', [
            'user' => $user,
            'scores' => $scores,
        ]);
    }
}
