<?php

namespace App\Http\Controllers;

use View;
use Illuminate\Http\Request;
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
        $cards = $this->cardRepository->paginate($limit = null, $columns = ['*']);

        return View::make('cards.index', [
            'cards' => $cards->toArray(),
        ]);
    }

    public function show(Request $request)
    {
        $card = $this->cardRepository->find($request->id);

        return View::make('cards.show', [
            'card' => $card,
        ]);
    }
}
