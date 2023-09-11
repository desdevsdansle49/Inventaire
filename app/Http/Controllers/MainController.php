<?php

namespace App\Http\Controllers;

class MainController extends Controller
{
    public function mainTable()
    {
        return view('mainTable');
    }

    public function stats()
    {
        return view('stats');
    }

    public function logs()
    {
        return view('logs');
    }

    public function addTable()
    {
        return view('addTable');
    }
}




