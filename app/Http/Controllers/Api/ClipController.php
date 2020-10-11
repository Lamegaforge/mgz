<?php

namespace App\Http\Controllers\Api;

use Response;
use DateTime;
use App\Repositories\ClipRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Criterias\Where;
use App\Repositories\Criterias\Active;
use App\Repositories\Criterias\OrderBy;
use App\Repositories\Criterias\WhereLike;
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

        $order = $request->get('order');
        
        $this->clipRepository->pushCriteria(new OrderBy($order, 'DESC'));

        if ($request->has('card_id')) {

            $cardId = $request->get('card_id');

            $this->clipRepository->pushCriteria(new Where('card_id', $cardId));
        }

        if ($request->has('title')) {

            $title = $request->get('title');

            $this->clipRepository->pushCriteria(new WhereLike('title', $title));
        }

        $this->clipRepository->with(['card']);

        $clips = $this->clipRepository->paginate(12, $columns = ['*']);

        return Response::json([
            'timestamp' => (new DateTime())->getTimestamp(),
            'clips' => $clips->toArray(),
        ], 200);
    }
}
