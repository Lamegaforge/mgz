<?php

namespace App\Repositories\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class Where implements CriteriaInterface {

    public function __construct(string $column, $value)
    {
        $this->column = $column;
        $this->value = $value;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where($this->column, $this->value);

        return $model;
    }
}
