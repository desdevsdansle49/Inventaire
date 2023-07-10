<?php

namespace App\Http\Controllers;

class PostController extends Controller
{
    public function tableau()
    {
        return view('tableau');
    }

    public function stats()
    {
        return view('stats');
    }

    public function logs()
    {
        return view('historique');
    }

    public function catTab()
    {
        return view('catTab');
    }
}
