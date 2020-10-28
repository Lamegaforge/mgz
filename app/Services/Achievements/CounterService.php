<?php

namespace App\Services\Achievements;

use App\Models\User;
use App\Models\Counter;

class CounterService 
{
    public function increment(User $user, string $slug): Counter
    {
        $counter = $this->get($user, $slug);

        $counter->increment('iterations');

        return $counter;
    }
    
    public function get(User $user, string $slug): Counter
    {
        return Counter::firstOrCreate([
            'user_id' => $user->id,
            'slug' => $slug,
        ]);
    }
}
