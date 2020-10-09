<?php

namespace App\Http\Controllers;

use View;
use Illuminate\Http\Request;
use App\Repositories\ClipRepository;
use App\Repositories\Criterias\Where;
use App\Repositories\Criterias\WhereLike;

class ClipController extends Controller
{
    protected $clipRepository;

    public function __construct(ClipRepository $clipRepository)
    {
        $this->clipRepository = $clipRepository;
    }

    public function index(Request $request)
    {
        $clips = $this->clipRepository->paginate($limit = null, $columns = ['*']);

        return View::make('clips.index', [
            'clips' => $clips,
        ]);
    }

    public function api(Request $request)
    {
        if ($request->has('card_id')) {

            $cardId = $request->get('card_id');

            $this->clipRepository->pushCriteria(new Where('card_id', $cardId));
        }

        if ($request->has('search')) {

            $search = $request->get('search');

            $this->clipRepository->pushCriteria(new WhereLike('title', $search));
        }

        $clips = $this->clipRepository->paginate($limit = null, $columns = ['*']);

        return response()->json($clips->toArray());
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
