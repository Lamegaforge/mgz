<?php

namespace App\Repositories\Transformers;

use App\Models\Card;
use App\Services\MediaService;
use League\Fractal\TransformerAbstract;
use App\Services\Medias\CardVignetteService;
use App\Services\Medias\CardBackgroundService;

/**
 * Class CardTransformer.
 *
 * @package namespace App\Transformers;
 */
class CardTransformer extends TransformerAbstract
{
    /**
     * Transform the Card entity.
     *
     * @param \App\Model\Card $card
     *
     * @return array
     */
    public function transform(Card $card): array
    {
        return $card->toArray() + [
            'medias' => [
                'background' => app(CardBackgroundService::class)->get($card),
                'vignette' => app(CardVignetteService::class)->get($card),
            ],
        ];
    }
}
