<?php

namespace App\Http\Controllers\Api;

use Response;
use DateTime;
use App\Repositories\CardRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Criterias\WhereLike;
use App\Http\Requests\Api\SearchCardsRequest;

class CardController extends Controller
{
    protected $cardRepository;

    public function __construct(CardRepository $cardRepository)
    {
        $this->cardRepository = $cardRepository;
    }

    public function search(SearchCardsRequest $request)
    {
        if ($request->has('title')) {

            $title = $request->get('title');

            $this->cardRepository->pushCriteria(new WhereLike('title', $title));
        }

        $cards = $this->cardRepository->paginate(12, $columns = ['*']);

        return Response::json([
            'timestamp' => (new DateTime())->getTimestamp(),
            'cards' => $cards->toArray(),
        ], 200);
    }
}
