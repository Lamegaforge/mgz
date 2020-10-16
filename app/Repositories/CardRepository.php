<?php

namespace App\Repositories;

use App\Models\Card;
use Prettus\Repository\Eloquent\BaseRepository;

class CardRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Card::class;
    }
}
