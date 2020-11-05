<?php

namespace App\Repositories;

use App\Models\Notification;
use Prettus\Repository\Eloquent\BaseRepository;

class NotificationRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Notification::class;
    }
}
