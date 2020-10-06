<?php

namespace App\Http\Controllers;

use View;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function show(Request $request)
    {
        $user = $this->userRepository->find($request->id);

        return View::make('users.show', [
            'user' => $user,
        ]);
    }
}
