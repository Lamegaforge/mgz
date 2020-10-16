<?php

namespace App\Http\Controllers\Web;

use View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\ClipRepository;
use App\Repositories\CardRepository;
use App\Repositories\Criterias\Limit;
use App\Repositories\Criterias\Where;
use App\Repositories\Criterias\Active;
use App\Repositories\Criterias\OrderBy;
use App\Repositories\Criterias\WhereLike;

class ClipController extends Controller
{
    public function index(Request $request)
    {
        $cards = app(ClipRepository::class)->all();

        return View::make('clips.index', ['cards' => $cards]);
    }

    public function show(Request $request)
    {
        $clip = app(ClipRepository::class)
            ->with(['user', 'card'])
            ->pushCriteria(new Active())
            ->find($request->id);

        $clips = app(ClipRepository::class)
            ->with(['user', 'card'])
            ->pushCriteria(new Active())
            ->pushCriteria(new Limit(8))
            ->pushCriteria(new OrderBy('approved_at', 'DESC'))
            ->all();

        return View::make('clips.show', [
            'clip' => $clip,
            'clips' => $clips,
        ]);
    }
}
