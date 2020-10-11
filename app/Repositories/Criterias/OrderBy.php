<?php

namespace App\Repositories\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class OrderBy implements CriteriaInterface {

    public function __construct(string $column)
    {
        $this->column = $column;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->orderBy($this->column);

        return $model;
    }
}
