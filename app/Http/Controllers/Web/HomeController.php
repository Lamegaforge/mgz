<?php

namespace App\Http\Controllers\Web;

use Auth;
use View;
use Redirect;
use Illuminate\Http\Request;
use App\Services\ClipService;
use App\Repositories\Presenters;
use Illuminate\Routing\Controller;
use App\Repositories\ClipRepository;
use App\Repositories\CardRepository;
use App\Repositories\Criterias\Limit;
use App\Repositories\Criterias\Active;
use App\Repositories\Criterias\OrderBy;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $highlightClips = app(ClipRepository::class)
            ->pushCriteria(new Active())
            ->pushCriteria(new OrderBy('views', 'DESC'))
            ->pushCriteria(new Limit(10))
            ->all();

        $highlightClip = $highlightClips->random();

        $clips = app(ClipRepository::class)
            ->with(['card'])
            ->pushCriteria(new Active())
            ->pushCriteria(new OrderBy('approved_at', 'DESC'))
            ->pushCriteria(new Limit(16))
            ->all();

        $cards = app(CardRepository::class)
            ->withCount(['clips'])
            ->pushCriteria(new Limit(30))
            ->pushCriteria(new OrderBy('clips_count', 'DESC'))
            ->setPresenter(Presenters\CardWithMedia::class)
            ->all();

        return View::make('home.index', [
            'highlight_clip' => $highlightClip,
            'clips' => $clips,
            'cards' => $cards['data'],
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return Redirect::route('home');
    }
}
