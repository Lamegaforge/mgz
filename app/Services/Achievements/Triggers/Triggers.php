<?php

namespace App\Services\Achievements\Triggers;

use App\Models\User;

abstract class Triggers 
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