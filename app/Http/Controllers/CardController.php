<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index(Request $request)
    {
    	return View::make('cards.index');
    }

    public function show(Request $request)
    {
    	return View::make('cards.show');
    }
}
