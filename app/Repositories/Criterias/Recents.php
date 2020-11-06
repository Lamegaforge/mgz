<?php

namespace App\Repositories\Criterias;

use Carbon\Carbon;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class Recents implements CriteriaInterface {

    public function apply($model, RepositoryInterface $repository)
    {
        $threshold = Carbon::today()->subWeek();

        $model = $model->whereNull('readed_at')
            ->orWhere('created_at', '>=', $threshold);

        return $model;
    }
}
