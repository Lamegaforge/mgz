<?php

namespace App\Services\Achievements\Triggers;

use Illuminate\Support\Str;
use App\Services\Achievements\Contracts\Trigger;

class IAmAnIdiot extends Triggers implements Trigger 
{
    protected $slug = 'i_am_an_idiot';

    public function eligible(): bool
    {
        $prerequisites = [
            $this->check($this->user->youtube),
            $this->check($this->user->instagram),
            $this->check($this->user->twitter),
        ];

        return in_array(true, $prerequisites);
    }

    protected function check(string $socialNetwork): bool
    {
        return Str::startsWith($socialNetwork, 'http://') 
            || Str::startsWith($socialNetwork, 'https://');
    }
}
