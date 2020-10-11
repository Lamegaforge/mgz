<?php

namespace App\Repositories\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class OrderBy implements CriteriaInterface {

    public function __construct(string $column, string $direction)
    {
        $this->column = $column;
        $this->direction = $direction;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->orderBy($this->column, $this->direction);

        return $model;
    }
}
