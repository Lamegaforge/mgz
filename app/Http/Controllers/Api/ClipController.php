<?php

namespace App\Http\Controllers\Api;

use Event;
use Response;
use DateTime;
use App\Repositories\ClipRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Criterias\Where;
use App\Repositories\Criterias\Active;
use App\Repositories\Criterias\OrderBy;
use App\Repositories\Criterias\WhereLike;
use App\Http\Responses\GenericApiResponse;
use App\Http\Requests\Api\RejectClipRequest;
use App\Http\Requests\Api\SearchClipsRequest;

class ClipController extends Controller
{
    protected $clipRepository;

    public function __construct(ClipRepository $clipRepository)
    {
        $this->clipRepository = $clipRepository;
    }

    public function search(SearchClipsRequest $request)
    {
        $this->clipRepository->pushCriteria(new Active());

        $this->addOrderCriteria($request);
        $this->addCardCriteria($request);
        $this->addUserCriteria($request);
        $this->addTitleCriteria($request);

        $this->clipRepository->with(['card']);

        $clips = $this->clipRepository->paginate(12, $columns = ['*']);

        return Response::json([
            'timestamp' => (new DateTime())->getTimestamp(),
            'clips' => $clips->toArray(),
        ], 200);
    }

    public function reject(RejectClipRequest $request)
    {
        $attributes = [
            'state' => 'rejected',
            'approved_at' => null,
        ];

        $clip = $this->clipRepository->find($request->clip_id);

        $this->clipRepository->update($attributes, $clip->id);

        Event::dispatch('NotifySubscriber@clipLost', [$clip]);

        return new GenericApiResponse();
    }

    protected function addOrderCriteria(SearchClipsRequest $request)
    {
        $order = $request->get('order');
        
        $this->clipRepository->pushCriteria(new OrderBy($order, 'DESC'));
    }

    protected function addCardCriteria(SearchClipsRequest $request)
    {
        if ($request->missing('card_id')) {
            return;
        };
        
        $cardId = $request->get('card_id');

        $this->clipRepository->pushCriteria(new Where('card_id', $cardId));
    }

    protected function addUserCriteria(SearchClipsRequest $request)
    {
        if ($request->missing('user_id')) {
            return;
        };
        
        $userId = $request->get('user_id');

        $this->clipRepository->pushCriteria(new Where('user_id', $userId));
    }

    protected function addTitleCriteria(SearchClipsRequest $request)
    {
        if ($request->missing('title')) {
            return;
        };
        
        $title = $request->get('title');

        $this->clipRepository->pushCriteria(new WhereLike('title', $title));
    }
}
