<?php

namespace App\Http\Controllers\Api;

use Event;
use App\Services\AccountService;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Http\Responses\GenericApiResponse;
use App\Http\Requests\Api\UpdateUserRequest;
use Illuminate\Contracts\Support\Responsable;
use App\Http\Requests\Api\UpdateBannerRequest;

class AccountController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function updateBanner(UpdateBannerRequest $request): Responsable
    {
        $slug = $request->file('banner')->store($path = null, $disk = 'banners');

        app(AccountService::class)->refreshBanner($request->user(), $slug);

        Event::dispatch('CounterSubscriber@banner', [$request->user()]);

        return new GenericApiResponse();
    }

    public function updateUser(UpdateUserRequest $request): Responsable
    {
        $attributes = $request->validated();

        $this->userRepository->update($attributes, $request->user()->id);

        return new GenericApiResponse();
    }
}
