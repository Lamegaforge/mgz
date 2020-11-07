<?php

namespace App\Http\Controllers\Api;

use Response;
use DateTime;
use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Criterias\OrderBy;
use App\Repositories\Criterias\WhereLike;
use App\Repositories\Criterias\WhereNotNull;
use App\Http\Requests\Api\SearchUsersRequest;
use App\Repositories\Criterias\OrderWithCount;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as Paginator;

class UserController extends Controller
{
    protected const PER_PAGE = 12;

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function search(SearchUsersRequest $request)
    {
        $this->addOrderCriteria($request);
        $this->addDisplayNameCriteria($request);

        $this->userRepository->pushCriteria(new WhereNotNull('display_name'));

        $paginator = $this->userRepository->paginate(self::PER_PAGE, $columns = ['*']);

        return Response::json([
            'timestamp' => (new DateTime())->getTimestamp(),
            'users' => $this->present($paginator, $request),
        ], 200);
    }

    protected function addOrderCriteria(SearchUsersRequest $request): void
    {
        $order = $request->get('order');

        switch ($order) {
            case 'achievements':
                $criteria = new OrderWithCount('achievements', 'DESC');
                break;
            case 'clips':
                $criteria = new OrderWithCount('clips', 'DESC');
                break;
            case 'points':
            default:
                $criteria = new OrderBy('points', 'DESC');
                break;
        }

        $this->userRepository->pushCriteria($criteria);
    }

    protected function addDisplayNameCriteria(SearchUsersRequest $request): void
    {
        if ($request->missing('display_name')) {
            return;
        }

        $displayName = $request->get('display_name');

        $this->userRepository->pushCriteria(new WhereLike('display_name', $displayName));
    }

    protected function present(Paginator $paginator, SearchUsersRequest $request): array
    {
        $attributes = $paginator->toArray();   

        $needRanking = $request->missing('display_name');

        $attributes['data'] = $paginator->map(function ($card, $rank) use($paginator, $needRanking) {

            $ranking = $needRanking ? $this->getRanking($paginator, $rank) : null;

            return $card->toArray() + [
                'rank' => $ranking,
            ];
        })->toArray();

        return $attributes;
    }

    protected function getRanking(Paginator $paginator, int $rank): int
    {
        $currentPage = $paginator->currentPage();

        $currentPage = ($currentPage == 1) ? 0 : $currentPage - 1;

        $rank++;

        return ($currentPage * self::PER_PAGE) + $rank;
    }
}
