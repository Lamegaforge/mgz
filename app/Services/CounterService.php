<?php

namespace App\Services;

use App\Models\User;
use App\Models\Count;

class CounterService
{
    public function get(User $user, string $slug): int
    {
        $count = $user->counts()->where('slug', $slug)->first();

        return $count->values ?? 0;
    }

    public function increment(User $user, string $slug): Count
    {
        $count = $user->counts()->where('slug', $slug)->first();

        return ($count)
            ? $this->increase($count)
            : $this->start($user, $slug);
    }

    protected function start(User $user, string $slug): Count
    {
        $count = Count::create([
            'slug' => $slug,
            'values' => 1,
        ]);

        $user->counts()->save($count);

        return $count;
    }

    protected function increase(Count $count): Count
    {
        $count->increment('values');

        $count->save();

        return $count;
    }
}
