<?php

namespace App\Repositories\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class WhereNull implements CriteriaInterface {

    public function __construct(string $column)
    {
        $this->column = $column;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->whereNull($this->column);

        return $model;
    }
}
