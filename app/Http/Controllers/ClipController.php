<?php

namespace App\Http\Controllers;

use View;
use Illuminate\Http\Request;
use App\Repositories\ClipRepository;

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
