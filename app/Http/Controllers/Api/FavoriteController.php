<?php

namespace App\Http\Controllers\Api;

use Datetime;
use Response;
use Illuminate\Http\Request;
use App\Services\FavoriteService;
use App\Http\Controllers\Controller;
use App\Repositories\ClipRepository;
use App\Repositories\UserRepository;
use App\Http\Responses\GenericApiResponse;
use App\Http\Requests\Api\SearchFavoriteRequest;
use App\Http\Requests\Api\ToggleFavoriteRequest;

class FavoriteController extends Controller
{
    protected $clipRepository;
    protected $userRepository;

    public function __construct(ClipRepository $clipRepository, UserRepository $userRepository)
    {
        $this->clipRepository = $clipRepository;
        $this->userRepository = $userRepository;
    }

    public function search(SearchFavoriteRequest $request)
    {
        $user = $this->userRepository
            ->where('id', $request->user_id)
            ->first();

        $favorites = $user->favorites()->paginate(12);

        return Response::json([
            'timestamp' => (new DateTime())->getTimestamp(),
            'favorites' => $favorites->toArray(),
        ], 200);
    }

    public function toggle(ToggleFavoriteRequest $request)
    {
        $user = $request->user();

        $clip = $this->clipRepository->find($request->clip_id);

        app(FavoriteService::class)->toggle($user, $clip);

        return new GenericApiResponse();
    }
}
