<?php

namespace App\Http\Controllers\Web;

use View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\CardRepository;
use App\Repositories\ClipRepository;
use App\Repositories\Criterias\Limit;
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

        $this->clipRepository->pushCriteria(new Limit(5));
        $this->clipRepository->pushCriteria(new OrderBy('views', 'DESC'));
        $this->clipRepository->where([
            'card_id' => $card->id,
        ]);

        $clips = $this->clipRepository->all();

        return View::make('cards.show', [
            'card' => $card,
            'clips' => $clips,
        ]);
    }
}
