<?php

namespace App\Repositories\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class WhereLike implements CriteriaInterface {

    public function __construct(string $column, $value)
    {
        $this->column = $column;
        $this->value = $value;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where($this->column, 'like', '%' . $this->value . '%');

        return $model;
    }
}
