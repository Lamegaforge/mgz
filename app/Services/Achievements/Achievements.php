<?php

namespace App\Services\Achievements;

use App\Models\User;

abstract class Achievements 
{
    protected $user;
    protected $slug;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function slug(): string
    {
        return $this->slug;
    }
}