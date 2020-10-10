<?php

namespace App\Http\Controllers\Api;

use Auth;
use Response;
use DateTime;
use App\Http\Controllers\Controller;
use App\Repositories\CommentRepository;
use App\Http\Requests\Api\StoreCommentRequest;

class CommentController extends Controller
{
    protected $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function store(StoreCommentRequest $request)
    {
        $attributes = $request->validated();

        $attributes['user_id'] = Auth::id();

        $this->commentRepository->create($attributes);

        return Response::json([
            'timestamp' => (new DateTime())->getTimestamp(),
        ], 200);
    }
}
