<?php

namespace App\Repositories\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class Random implements CriteriaInterface 
{
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->inRandomOrder();

        return $model;
    }
}
