<?php

namespace App\Http\Controllers\Web;

use View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\CardRepository;
use App\Repositories\ClipRepository;
use App\Repositories\Criterias\Limit;
use App\Repositories\Criterias\Where;
use App\Repositories\Criterias\Active;
use App\Repositories\Criterias\OrderBy;

class CardController extends Controller
{
    protected $cardRepository;
    protected $clipRepository;

    public function __construct(CardRepository $cardRepository, ClipRepository $clipRepository)
    {
        $this->cardRepository = $cardRepository;
        $this->clipRepository = $clipRepository;
    }

    public function index(Request $request)
    {
        return View::make('cards.index');
    }

    public function show(Request $request)
    {
        $card = $this->cardRepository->find($request->id);

        $this->clipRepository->pushCriteria(new Active());
        $this->clipRepository->pushCriteria(new Where('card_id', $card->id));

        $countClips = $this->clipRepository->count();

        $this->clipRepository->pushCriteria(new Limit(8));
        $this->clipRepository->pushCriteria(new OrderBy('views', 'DESC'));

        $clips = $this->clipRepository->all();

        return View::make('cards.show', [
            'card' => $card,
            'countClips' => $countClips,
            'clips' => $clips,
        ]);
    }
}
