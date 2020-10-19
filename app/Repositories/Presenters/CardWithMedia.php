<?php

namespace App\Repositories\Presenters;

use App\Repositories\Transformers\CardTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CardPresenter.
 *
 * @package namespace App\Presenters;
 */
class CardWithMedia extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CardTransformer();
    }
}
