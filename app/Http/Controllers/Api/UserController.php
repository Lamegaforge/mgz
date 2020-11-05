<?php

namespace App\Http\Controllers\Api;

use Response;
use DateTime;
use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Criterias\OrderBy;
use App\Repositories\Criterias\WhereLike;
use App\Repositories\Criterias\WithCount;
use App\Http\Requests\Api\SearchUsersRequest;
use App\Repositories\Criterias\OrderWithCount;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function search(SearchUsersRequest $request)
    {
        $this->addOrderCriteria($request);
        $this->addDisplayNameCriteria($request);

        $paginator = $this->userRepository->paginate(12, $columns = ['*']);

        return Response::json([
            'timestamp' => (new DateTime())->getTimestamp(),
            'users' => $paginator->toArray(),
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

        $this->userRepository->pushCriteria(new WithCount('clips', 'DESC'));
        $this->userRepository->pushCriteria(new WithCount('achievements', 'DESC'));

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
}
