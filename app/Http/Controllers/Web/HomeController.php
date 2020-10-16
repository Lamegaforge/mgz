<?php

namespace App\Http\Controllers\Web;

use View;
use Illuminate\Http\Request;
use App\Services\ClipService;
use Illuminate\Routing\Controller;
use App\Repositories\ClipRepository;
use App\Repositories\CardRepository;
use App\Repositories\Criterias\Limit;
use App\Repositories\Criterias\Active;
use App\Repositories\Criterias\OrderBy;

class HomeController extends Controller
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
    	$highlightClip = app(ClipService::class)->getHighlightClip();

        $clips = $this->clipRepository
            ->with(['card'])
            ->pushCriteria(new Active())
            ->pushCriteria(new OrderBy('approved_at', 'DESC'))
            ->pushCriteria(new Limit(16))
            ->all();

        $cards = $this->cardRepository
            ->withCount(['clips'])
            ->pushCriteria(new Limit(30))
            ->all();

        return View::make('home.index', [
            'highlight_clip' => $highlightClip,
            'clips' => $clips,
            'cards' => $cards,
        ]);
    }
}
