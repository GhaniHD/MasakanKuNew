<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PopulerController extends Controller
{
    public function index()
    {
        return view('populer');
    }
}
