<?php

namespace App\Repositories;

use App\Models\Comment;
use Prettus\Repository\Eloquent\BaseRepository;

class CommentRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Comment::class;
    }
}
