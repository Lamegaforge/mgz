<?php

namespace App\Http\Controllers\Api;

use Response;
use DateTime;
use App\Services\MediaService;
use App\Repositories\CardRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Criterias\WhereLike;
use App\Http\Requests\Api\SearchCardsRequest;
use Illuminate\Contracts\Pagination\Paginator;

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

        $paginator = $this->cardRepository->paginate(12, $columns = ['*']);

        return Response::json([
            'timestamp' => (new DateTime())->getTimestamp(),
            'cards' => $this->present($paginator),
        ], 200);
    }

    protected function present(Paginator $paginator): array
    {
        $attributes = $paginator->toArray();   

        $attributes['data'] = $paginator->map(function ($card) {
            return $card->toArray() + [
                'medias' => app(MediaService::class)->all($card['media']),
            ];
        })->toArray();

        return $attributes;
    }
}
