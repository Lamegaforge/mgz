<?php

namespace App\Http\Controllers\Web;

use View;
use Event;
use Redirect;
use App\Models\Clip;
use Illuminate\Http\Request;
use App\Repositories\Presenters;
use Illuminate\Support\Collection;
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

    public function random(Request $request)
    {
        $clip = app(ClipRepository::class)
            ->pushCriteria(new Random())
            ->pushCriteria(new Active())
            ->first();

        if ($request->auth()) {
            Event::dispatch('CounterSubscriber@random', [$request->user()]);
        }

        return Redirect::route('clips.show', $clip->slug);
    }

    public function show(Request $request)
    {
        $clip = app(ClipRepository::class)
            ->with(['user', 'card'])
            ->pushCriteria(new Active())
            ->where('slug', $request->hook)
            ->orWhere('id', $request->hook)
            ->firstOrFail();
            
        $clips = $this->getOtherClips($clip);

        $commentCount = $clip->comments->where('active', true)->count();

        $isFavorite = $this->isFavorite($request, $clip);

        return View::make('clips.show', [
            'clip' => $clip,
            'comment_count' => $commentCount,
            'clips' => $clips,
            'isFavorite' => $isFavorite,
        ]);
    }

    protected function getOtherClips(Clip $clip): Collection
    {
        $clips = app(ClipRepository::class)
            ->with(['user', 'card'])
            ->pushCriteria(new Random())
            ->pushCriteria(new Active())
            ->pushCriteria(new Limit(8))
            ->pushCriteria(new Where('card_id', $clip->card_id))
            ->all();

        $missing = 8 - $clips->count();

        if ($missing == 0) {
            return $clips;
        }

        $missingClips = app(ClipRepository::class)
            ->with(['user', 'card'])
            ->pushCriteria(new Random())
            ->pushCriteria(new Active())
            ->pushCriteria(new Limit($missing))
            ->all();

        return $clips->merge($missingClips);
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
