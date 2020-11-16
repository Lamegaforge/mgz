<?php

namespace App\Services\Medias;

use Storage;
use App\Models\Card;

class CardBackgroundService
{
    public function get(Card $card): string
    {
        if ($this->haveCustomMedia($card)) {
            return $this->getCustomMedia($card);
        }

        return $this->getRandomPath($card);
    }

    public function haveCustomMedia(Card $card): string 
    {
        $path = $this->getCustomPath($card);

        return Storage::disk('cards')->has($path);
    }

    protected function getCustomMedia(Card $card): string 
    {
        $path = $this->getCustomPath($card);

        return Storage::disk('cards')->url($path);
    }

    protected function getRandomPath(Card $card): string 
    {
        $clip = $card->clips()->inRandomOrder()->first();

        return $clip->thumbnail;
    }

    protected function getCustomPath(Card $card): string 
    {
        return $card->slug . '/background.jpg';
    }
}
