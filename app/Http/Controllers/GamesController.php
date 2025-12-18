<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GamesController extends Controller
{
    public function index()
    {
        return view('games.index');
    }

    public function tts()
    {
        return view('games.tts');
    }

    public function quiz()
    {
        return view('games.quiz');
    }

    public function memory()
    {
        return view('games.memory');
    }
}
