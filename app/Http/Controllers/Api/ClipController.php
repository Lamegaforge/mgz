<?php

namespace App\Http\Controllers\Api;

use Response;
use DateTime;
use App\Repositories\ClipRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Criterias\Where;
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
        if ($request->has('card_id')) {

            $cardId = $request->get('card_id');

            $this->clipRepository->pushCriteria(new Where('card_id', $cardId));
        }

        if ($request->has('search')) {

            $search = $request->get('search');

            $this->clipRepository->pushCriteria(new WhereLike('title', $search));
        }

        $clips = $this->clipRepository->paginate($limit = null, $columns = ['*']);

        return Response::json([
            'timestamp' => (new DateTime())->getTimestamp(),
            'clips' => $clips->toArray(),
        ], 200);
    }
}
