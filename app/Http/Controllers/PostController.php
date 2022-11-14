<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

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

    public function alerts()
    {
        return view('alerts');
    }
}
