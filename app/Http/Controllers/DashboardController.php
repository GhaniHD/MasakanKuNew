<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;

class DashboardController extends Controller
{
    public function index()
    {
        $recipes = Recipe::all();
        $popularRecipes = Recipe::orderBy('views', 'desc')->limit(5)->get();
        dd($popularRecipes);
        return view('Dashboard.index', ['recipes' => $recipes], ['popularRecipes' => $popularRecipes]);
    }
}





