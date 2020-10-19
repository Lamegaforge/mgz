<?php

namespace App\Repositories\Transformers;

use App\Models\Card;
use App\Services\MediaService;
use League\Fractal\TransformerAbstract;

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
            'medias' => app(MediaService::class)->all($card->slug),
        ];
    }
}
