<?php

namespace App\Http\Controllers\Web;

use View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\ClipRepository;
use App\Repositories\CardRepository;
use App\Repositories\Criterias\Where;
use App\Repositories\Criterias\WhereLike;

class ClipController extends Controller
{
    protected $clipRepository;
    protected $cardRepository;

    public function __construct(ClipRepository $clipRepository, CardRepository $cardRepository)
    {
        $this->clipRepository = $clipRepository;
        $this->cardRepository = $cardRepository;
    }

    public function index(Request $request)
    {
        $cards = $this->cardRepository->all();

        return View::make('clips.index', $cards);
    }

    public function show(Request $request)
    {
        $clip = $this->clipRepository
            ->with(['user', 'card'])
            ->find($request->id);

        return View::make('clips.show', [
            'clip' => $clip,
        ]);
    }
}
