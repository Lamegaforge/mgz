<?php

namespace App\Http\Controllers\Api;

use Response;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Criterias\Where;
use App\Repositories\Criterias\Active;
use App\Repositories\CommentRepository;
use App\Repositories\Criterias\OrderBy;
use App\Repositories\Criterias\WhereNull;
use App\Http\Requests\Api\StoreCommentRequest;

class CommentController extends Controller
{
    protected $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function user(Request $request)
    {
        $comments = $this->commentRepository
            ->pushCriteria(new Active())
            ->pushCriteria(new Where('user_id', $request->user_id))
            ->pushCriteria(new OrderBy('created_at', 'DESC'))
            ->all();

        return Response::json([
            'timestamp' => (new DateTime())->getTimestamp(),
            'comments' => $comments->toArray(),
        ], 200);
    }

    public function search(Request $request)
    {
        $comments = $this->commentRepository
            ->with(['user', 'children' => function ($query) {
                $query->where('state', 'active')
                    ->orderBy('created_at', 'ASC');
            }, 'children.user'])
            ->pushCriteria(new Active())
            ->pushCriteria(new Where('clip_id', $request->clip_id))
            ->pushCriteria(new WhereNull('parent_comment_id'))
            ->pushCriteria(new OrderBy('created_at', 'DESC'))
            ->all();

        return Response::json([
            'timestamp' => (new DateTime())->getTimestamp(),
            'comments' => $comments->toArray(),
        ], 200);
    }

    public function store(StoreCommentRequest $request)
    {
        $attributes = $request->validated();

        $attributes['user_id'] = $request->user()->id;
        $attributes['state'] = 'active';

        $this->commentRepository->create($attributes);

        return Response::json([
            'timestamp' => (new DateTime())->getTimestamp(),
        ], 200);
    }
}
