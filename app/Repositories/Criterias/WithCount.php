<?php

namespace App\Repositories\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class WithCount implements CriteriaInterface {

    public function __construct(string $column)
    {
        $this->column = $column;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->withCount($this->column);

        return $model;
    }
}
