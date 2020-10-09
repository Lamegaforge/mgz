<?php

namespace App\Http\Controllers\Web;

use View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Repositories\CardRepository;

class CardController extends Controller
{
    protected $cardRepository;

    public function __construct(CardRepository $cardRepository)
    {
        $this->cardRepository = $cardRepository;
    }

    public function index(Request $request)
    {
        return View::make('cards.index');
    }

    public function show(Request $request)
    {
        $card = $this->cardRepository->find($request->id);

        return View::make('cards.show', [
            'card' => $card,
        ]);
    }
}
