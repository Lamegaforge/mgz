<?php

namespace App\Http\Controllers\Web;

use View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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
        return View::make('clips.index');
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
