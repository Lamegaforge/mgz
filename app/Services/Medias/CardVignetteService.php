<?php

namespace App\Services\Medias;

use Storage;
use App\Models\Card;

class CardVignetteService
{
    public function get(Card $card): string
    {
        if ($this->haveCustomMedia($card)) {
            return $this->getCustomMedia($card);
        }

        return $this->getPlaceholderPath($card);
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

    protected function getPlaceholderPath(Card $card): string 
    {
        $path = 'placeholder.jpg';

        return Storage::disk('cards')->url($path);
    }

    protected function getCustomPath(Card $card): string 
    {
        return $card->slug . '/placeholders/vignette.jpg';
    }
}
