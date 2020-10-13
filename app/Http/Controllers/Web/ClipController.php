<?php

namespace App\Http\Controllers\Web;

use View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\ClipRepository;
use App\Repositories\CardRepository;
use App\Repositories\Criterias\Limit;
use App\Repositories\Criterias\Where;
use App\Repositories\Criterias\OrderBy;
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

        return View::make('clips.index', ['cards' => $cards]);
    }

    public function show(Request $request)
    {
        $this->clipRepository->with(['user', 'card']);

        $clip = $this->clipRepository->find($request->id);

        $this->clipRepository->pushCriteria(new Limit(8));
        $this->clipRepository->pushCriteria(new OrderBy('approved_at', 'DESC'));

        $clips = $this->clipRepository->all();

        return View::make('clips.show', [
            'clip' => $clip,
            'clips' => $clips,
        ]);
    }
}
