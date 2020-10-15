<?php

namespace App\Http\Controllers\Api;

use Auth;
use Response;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Criterias\Where;
use App\Repositories\Criterias\Active;
use App\Repositories\CommentRepository;
use App\Repositories\Criterias\OrderBy;
use App\Http\Requests\Api\StoreCommentRequest;

class CommentController extends Controller
{
    protected $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function list(Request $request)
    {
        $comments = app(CommentRepository::class)
            ->with(['childs' => function ($query) {
                $query->where('active', true)
                    ->orderBy('approved_at', 'DESC');
            }])
            ->pushCriteria(new Active())
            ->pushCriteria(new Where('clip_id', $request->clip_id))
            ->pushCriteria(new OrderBy('approved_at', 'DESC'))
            ->all();

        return Response::json([
            'timestamp' => (new DateTime())->getTimestamp(),
            'comments' => $comments->toArray(),
        ], 200);
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
