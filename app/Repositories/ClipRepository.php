<?php

namespace App\Repositories;

use App\Models\Clip;
use Prettus\Repository\Eloquent\BaseRepository;

class ClipRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Clip::class;
    }
}
