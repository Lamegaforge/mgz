<?php

namespace App\Http\Controllers\Web;

use View;
use App\Models\Clip;
use Illuminate\Http\Request;
use App\Repositories\Presenters;
use Illuminate\Routing\Controller;
use App\Repositories\ClipRepository;
use App\Repositories\CardRepository;
use App\Repositories\Criterias\Limit;
use App\Repositories\Criterias\Where;
use App\Repositories\Criterias\Active;
use App\Repositories\Criterias\Random;
use App\Repositories\Criterias\OrderBy;
use App\Repositories\Criterias\WhereLike;

class ClipController extends Controller
{
    public function index(Request $request)
    {
        $cards = app(CardRepository::class)
            ->setPresenter(Presenters\CardWithMedia::class)
            ->all();

        return View::make('clips.index', [
            'cards' => $cards['data'],
        ]);
    }

    public function show(Request $request)
    {
        $clip = app(ClipRepository::class)
            ->with(['user', 'card'])
            ->pushCriteria(new Active())
            ->find($request->id);

        $clips = app(ClipRepository::class)
            ->with(['user', 'card'])
            ->pushCriteria(new Random())
            ->pushCriteria(new Active())
            ->pushCriteria(new Limit(8))
            ->pushCriteria(new OrderBy('approved_at', 'DESC'))
            ->all();

        $commentCount = $clip->comments->where('active', true)->count();

        $isFavorite = $this->isFavorite($request, $clip);

        return View::make('clips.show', [
            'clip' => $clip,
            'comment_count' => $commentCount,
            'clips' => $clips,
            'isFavorite' => $isFavorite,
        ]);
    }

    protected function isFavorite(Request $request, Clip $clip): bool
    {
        $user = $request->user();

        if (! $user) {
            return false;
        }

        return $user->favorites->contains($clip->id);
    }
}
