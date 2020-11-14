<?php

namespace App\Http\Controllers\Api;

use Response;
use DateTime;
use App\Repositories\CardRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Criterias\OrderBy;
use App\Repositories\Criterias\WhereLike;
use App\Services\Medias\CardVignetteService;
use App\Http\Requests\Api\SearchCardsRequest;
use App\Services\Medias\CardBackgroundService;
use App\Repositories\Criterias\OrderWithCount;
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
        $this->addOrderCriteria($request);
        $this->addTitleCriteria($request);

        $this->cardRepository->has('clips', function () {
            $query->where('state', 'active'); 
        });

        $paginator = $this->cardRepository->paginate(12, $columns = ['*']);

        return Response::json([
            'timestamp' => (new DateTime())->getTimestamp(),
            'cards' => $this->present($paginator),
        ], 200);
    }

    protected function addOrderCriteria(SearchCardsRequest $request): void
    {
        $order = $request->get('order');
        
        switch ($order) {
            case 'created_at':
                $criteria = new OrderBy('created_at', 'DESC');
                break;
            case 'title':
                $criteria = new OrderBy('title', 'ASC');
                break;
            case 'count':
            default:
                $criteria = new OrderWithCount('clips', 'DESC');
                break;
        }

        $this->cardRepository->pushCriteria($criteria);
    }

    protected function addTitleCriteria(SearchCardsRequest $request): void
    {
        if ($request->missing('title')) {
            return;
        }

        $title = $request->get('title');

        $this->cardRepository->pushCriteria(new WhereLike('title', $title));
    }

    protected function present(Paginator $paginator): array
    {
        $attributes = $paginator->toArray();   

        $attributes['data'] = $paginator->map(function ($card) {
            return $card->toArray() + [
                'medias' => [
                    'background' => app(CardBackgroundService::class)->get($card),
                    'vignette' => app(CardVignetteService::class)->get($card),
                ],
            ];
        })->toArray();

        return $attributes;
    }
}
