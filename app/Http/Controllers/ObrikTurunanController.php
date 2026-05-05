<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ObrikTurunanController extends Controller
{
    public function index()
    {
        return view('master.obrik_turunan');
    }
}
