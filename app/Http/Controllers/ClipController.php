<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClipController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index(Request $request)
    {
        return View::make('clips.index');
    }

    public function show(Request $request)
    {
        $clip = [
            'tracking_id' => $faker->unique()->numberBetween(1000, 10000),
            'curator_id' => factory(Curator::class)->create()->id,
            'game_id' => factory(Game::class)->create()->id,
            'slug' => 'aight_imma_head_out',
            'title' => 'Aight Imma head out',
            'url' => $faker->unique()->url,
            'game' => $faker->unique()->sentence($nbWords = 2),
            'views' => $faker->numberBetween($min = 100, $max = 500),
            'active' => true,   
        ];

        return View::make('clips.show', [
            'clip' => $clip,
        ]);
    }
}


