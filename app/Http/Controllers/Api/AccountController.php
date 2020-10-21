<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Services\AccountService;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Http\Responses\GenericApiResponse;
use Illuminate\Contracts\Support\Responsable;
use App\Http\Requests\Api\UpdateBannerRequest;
use App\Http\Requests\Api\UpdateNetworksRequest;
use App\Http\Requests\Api\UpdateDescriptionRequest;

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

        app(AccountService::class)->refreshBanner(Auth::user(), $slug);

        return new GenericApiResponse();
    }

    public function updateNetworks(UpdateNetworksRequest $request): Responsable
    {
        $attributes = $request->validated();

        $this->userRepository->update($attributes, Auth::id());

        return new GenericApiResponse();
    }

    public function updateDescription(UpdateDescriptionRequest $request): Responsable
    {
        $attributes = $request->validated();

        $this->userRepository->update($attributes, Auth::id());

        return new GenericApiResponse();
    }
}
